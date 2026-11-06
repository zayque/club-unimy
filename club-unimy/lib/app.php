<?php
/**
 * ClubHub admin – shared bootstrap.
 * Every admin page includes this file first.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kuala_Lumpur');
define('APP_ROOT', dirname(__DIR__));
define('APP_NAME', 'ClubHub');

require_once APP_ROOT . '/config-mysqli.php'; // provides $conn
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
mysqli_set_charset($conn, 'utf8mb4');

/** All clubs: club_type key => details. `keyword` is what is stored in user.club_user. */
const CLUBS = [
    'esport'  => ['name' => 'E-Sports Club',                 'keyword' => 'E-Sports',                 'icon' => 'fa-gamepad',   'color' => '#6366f1', 'desc' => 'Competitive gaming & tournaments'],
    'cyber'   => ['name' => 'Cybersecurity Club',            'keyword' => 'Cybersecurity',            'icon' => 'fa-shield',    'color' => '#0ea5e9', 'desc' => 'CTFs, ethical hacking & security'],
    'photo'   => ['name' => 'Photography Crew',              'keyword' => 'Photography',              'icon' => 'fa-camera',    'color' => '#f43f5e', 'desc' => 'Shoots, editing & exhibitions'],
    'japan'   => ['name' => 'Japananime Society',            'keyword' => 'Japananime',               'icon' => 'fa-star',      'color' => '#ec4899', 'desc' => 'Anime, manga & Japanese culture'],
    'advent'  => ['name' => 'Adventurous Recreational Club', 'keyword' => 'Adventurous Recreational', 'icon' => 'fa-tree',      'color' => '#10b981', 'desc' => 'Hiking, camping & outdoor trips'],
    'music'   => ['name' => 'Music Club',                    'keyword' => 'Music',                    'icon' => 'fa-music',     'color' => '#f59e0b', 'desc' => 'Jam sessions & live performances'],
    'biztech' => ['name' => 'BizTech Club',                  'keyword' => 'BizTech',                  'icon' => 'fa-briefcase', 'color' => '#8b5cf6', 'desc' => 'Compulsory for diploma & business students'],
    'inge'    => ['name' => 'Ingenieurs Club',               'keyword' => 'Ingenieurs',               'icon' => 'fa-cogs',      'color' => '#14b8a6', 'desc' => 'Engineering students only'],
];

function db(): mysqli
{
    global $conn;
    return $conn;
}

/** Run a prepared query. Returns mysqli_result for SELECT, true otherwise. */
function q(string $sql, array $params = [])
{
    $stmt = db()->prepare($sql);
    if ($params) {
        $stmt->bind_param(str_repeat('s', count($params)), ...array_map('strval', $params));
    }
    $stmt->execute();
    $res = $stmt->get_result();
    return $res === false ? true : $res;
}

function rows(string $sql, array $params = []): array
{
    return q($sql, $params)->fetch_all(MYSQLI_ASSOC);
}

function row(string $sql, array $params = []): ?array
{
    return q($sql, $params)->fetch_assoc() ?: null;
}

function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/* ---------- auth ---------- */

function is_admin(): bool
{
    return !empty($_SESSION['u_uid']);
}

function require_admin(): void
{
    if (!is_admin()) {
        redirect(url('admin.php'));
    }
}

/** Build a URL relative to the admin root, from any sub-folder. */
function url(string $path): string
{
    $script = str_replace(DIRECTORY_SEPARATOR, '/', dirname(realpath($_SERVER['SCRIPT_FILENAME'])));
    $root = str_replace(DIRECTORY_SEPARATOR, '/', APP_ROOT);
    $rel = trim(substr($script, strlen($root)), '/');
    $depth = $rel === '' ? 0 : substr_count($rel, '/') + 1;
    return str_repeat('../', $depth) . $path;
}

/* ---------- CSRF ---------- */

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_check(): void
{
    $sent = $_POST['csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!hash_equals(csrf_token(), (string)$sent)) {
        http_response_code(419);
        exit('Your session expired. Go back, refresh the page and try again.');
    }
}

/* ---------- flash messages ---------- */

function flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'][] = ['message' => $message, 'type' => $type];
}

function take_flashes(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

/* ---------- domain helpers ---------- */

function club_type_or_404(?string $type): string
{
    if (!$type || !isset(CLUBS[$type])) {
        http_response_code(404);
        exit('Unknown club.');
    }
    return $type;
}

/** "A,B,C," -> ['A','B','C'] */
function club_list(?string $stored): array
{
    return array_values(array_filter(array_map('trim', explode(',', (string)$stored))));
}

/** Normalise submitted club keywords to the known list, stored as "A,B,". */
function clubs_to_store(array $keywords): string
{
    $valid = array_column(CLUBS, 'keyword');
    $keep = array_values(array_intersect($valid, $keywords));
    return $keep ? implode(',', $keep) . ',' : '';
}

function club_by_keyword(string $keyword): ?array
{
    foreach (CLUBS as $type => $c) {
        if (strcasecmp($c['keyword'], $keyword) === 0) {
            return $c + ['type' => $type];
        }
    }
    return null;
}

function member_count(string $type): int
{
    $r = row("SELECT COUNT(*) n FROM user WHERE CONCAT(',', club_user) LIKE ?", ['%,' . CLUBS[$type]['keyword'] . ',%']);
    return (int)$r['n'];
}

function members_of(string $type): array
{
    return rows("SELECT * FROM user WHERE CONCAT(',', club_user) LIKE ? ORDER BY name_user", ['%,' . CLUBS[$type]['keyword'] . ',%']);
}

function registration_settings(): array
{
    $r = row("SELECT * FROM limitseminar ORDER BY id_limit2 LIMIT 1");
    return [
        'id'      => $r['id_limit2'] ?? '1',
        'limit'   => (int)($r['jumlah_limit2'] ?? 0),
        'message' => $r['mesej_limit2'] ?? 'Registration is full.',
    ];
}

function total_students(): int
{
    return (int)row("SELECT COUNT(*) n FROM user")['n'];
}

/** Stream rows as a CSV download. */
function send_csv(string $filename, array $header, array $rows): void
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel shows names correctly
    fputcsv($out, $header, ',', '"', '');
    foreach ($rows as $r) {
        fputcsv($out, $r, ',', '"', '');
    }
    fclose($out);
    exit;
}

/* ---------- image uploads (activity pictures) ---------- */

/** Absolute web path of the admin app, e.g. "/club-unimy". */
function app_web_path(): string
{
    $doc = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', realpath($_SERVER['DOCUMENT_ROOT'])), '/');
    $app = str_replace(DIRECTORY_SEPARATOR, '/', APP_ROOT);
    return strpos($app, $doc) === 0 ? substr($app, strlen($doc)) : '';
}

/**
 * Save an uploaded image and return its web path, or null when nothing was uploaded.
 * Throws RuntimeException with a readable message when the file is rejected.
 */
function save_upload(string $field): ?string
{
    $f = $_FILES[$field] ?? null;
    if (!$f || $f['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($f['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The image could not be uploaded. Try a smaller file (max 3 MB).');
    }
    if ($f['size'] > 3 * 1024 * 1024) {
        throw new RuntimeException('The image is larger than 3 MB.');
    }
    $info = @getimagesize($f['tmp_name']);
    $ext = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif', IMAGETYPE_WEBP => 'webp'][$info[2] ?? 0] ?? null;
    if (!$ext) {
        throw new RuntimeException('Upload a JPG, PNG, GIF or WebP image.');
    }
    $dir = APP_ROOT . '/uploads/activities';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $name = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    move_uploaded_file($f['tmp_name'], "$dir/$name");
    return app_web_path() . '/uploads/activities/' . $name;
}

/** Remove a previously uploaded image (ignores external URLs and old paths). */
function delete_upload(?string $webPath): void
{
    if (!$webPath || strpos($webPath, '/uploads/activities/') === false) {
        return;
    }
    $file = APP_ROOT . '/uploads/activities/' . basename($webPath);
    if (is_file($file)) {
        @unlink($file);
    }
}
