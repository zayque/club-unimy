<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once APP_ROOT . '/vendorphpmailer/autoload.php';

function mail_config(): ?array
{
    $file = APP_ROOT . '/mail-config.php';
    if (!is_file($file)) {
        return null;
    }
    $cfg = require $file;
    return !empty($cfg['enabled']) ? $cfg : null;
}

function email_template(): array
{
    return row("SELECT * FROM email ORDER BY id_email LIMIT 1") ?: ['id_email' => 0, 'subject_email' => '', 'body_email' => '', 'altbody_email' => ''];
}

/** Replace {name}, {student_id}, {email}, {phone}, {clubs} in a template string. */
function fill_template(string $text, array $student, bool $html): string
{
    $clubs = implode(', ', array_map(function ($k) {
        $c = club_by_keyword($k);
        return $c ? $c['name'] : $k;
    }, club_list($student['club_user'] ?? '')));
    $vars = [
        '{name}'       => $student['name_user'] ?? '',
        '{student_id}' => strtoupper($student['studentid_user'] ?? ''),
        '{email}'      => $student['email_user'] ?? '',
        '{phone}'      => $student['phone_user'] ?? '',
        '{clubs}'      => $clubs ?: 'no clubs yet',
    ];
    if ($html) {
        $vars = array_map('e', $vars);
    }
    return strtr($text, $vars);
}

/**
 * Send the welcome email. Returns null on success, or an error string.
 * Never throws, so a mail problem can't break registration.
 */
function send_welcome_email(array $student, ?string $to = null): ?string
{
    $cfg = mail_config();
    if (!$cfg) {
        return 'Email is not set up (copy mail-config.example.php to mail-config.php).';
    }
    $t = email_template();
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $cfg['host'];
        $mail->Port = (int)$cfg['port'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $cfg['secure'];
        $mail->Username = $cfg['username'];
        $mail->Password = $cfg['password'];
        $mail->CharSet = 'UTF-8';
        $mail->Timeout = 15;
        $mail->setFrom($cfg['from_email'], $cfg['from_name'] ?? APP_NAME);
        $mail->addAddress($to ?: $student['email_user'], $student['name_user'] ?? '');
        $mail->isHTML(true);
        $mail->Subject = fill_template($t['subject_email'], $student, false);
        $mail->Body = nl2br(fill_template($t['body_email'], $student, true));
        $mail->AltBody = fill_template($t['altbody_email'] ?: strip_tags($t['body_email']), $student, false);
        $mail->send();
        return null;
    } catch (Throwable $ex) {
        error_log('ClubHub mail error: ' . $ex->getMessage());
        return 'The email could not be sent: ' . $ex->getMessage();
    }
}
