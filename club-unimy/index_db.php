<?php
/**
 * Handles the public club registration form (club-form.php).
 */
require_once __DIR__ . '/lib/app.php';
require_once __DIR__ . '/lib/mailer.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('club-form.php');
}
csrf_check();

$old = [
    'name'      => trim($_POST['name1'] ?? ''),
    'studentid' => strtoupper(trim($_POST['idstudent1'] ?? '')),
    'email'     => strtolower(trim($_POST['email1'] ?? '')),
    'phone'     => preg_replace('/[^0-9+]/', '', $_POST['notel1'] ?? ''),
    'clubs'     => array_values(array_intersect(array_column(CLUBS, 'keyword'), (array)($_POST['check'] ?? []))),
];

$errors = [];
if (mb_strlen($old['name']) < 3) $errors['name'] = 'Enter your full name.';
if (!preg_match('/^[A-Z0-9]{5,10}$/', $old['studentid'])) $errors['studentid'] = 'Enter a valid student ID (5–10 letters and numbers).';
if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
if (strlen($old['phone']) < 9 || strlen($old['phone']) > 13) $errors['phone'] = 'Enter a phone number with 9–12 digits.';
if (!$old['clubs']) $errors['clubs'] = 'Choose at least one club.';

$settings = registration_settings();
if (total_students() >= $settings['limit']) {
    $errors['form'] = $settings['message'];
}

if (!$errors) {
    $dup = row("SELECT studentid_user, email_user FROM user WHERE studentid_user = ? OR email_user = ? LIMIT 1", [$old['studentid'], $old['email']]);
    if ($dup) {
        if (strcasecmp($dup['studentid_user'], $old['studentid']) === 0) {
            $errors['studentid'] = 'This student ID is already registered. Sign in to the student portal to change your clubs.';
        } else {
            $errors['email'] = 'This email is already registered.';
        }
    }
}

if ($errors) {
    $_SESSION['reg_errors'] = $errors;
    $_SESSION['reg_old'] = $old;
    redirect('club-form.php#form');
}

$student = [
    'name_user'      => $old['name'],
    'studentid_user' => $old['studentid'],
    'email_user'     => $old['email'],
    'phone_user'     => $old['phone'],
    'club_user'      => clubs_to_store($old['clubs']),
];
q("INSERT INTO user (name_user, studentid_user, email_user, phone_user, club_user) VALUES (?, ?, ?, ?, ?)", array_values($student));

// Email is optional: registration succeeds even if it can't be sent.
$mailError = send_welcome_email($student);

$_SESSION['reg_done'] = [
    'name'  => $student['name_user'],
    'email' => $student['email_user'],
    'clubs' => $old['clubs'],
    'mailed' => $mailError === null,
];
redirect('display.php');
