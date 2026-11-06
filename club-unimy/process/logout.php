<?php
require_once __DIR__ . '/../lib/app.php';
// Logs the admin out without touching a student session in the same browser.
foreach (['u_id', 'u_first', 'u_last', 'u_email', 'u_uid', 'u_studentid'] as $k) {
    unset($_SESSION[$k]);
}
redirect('../admin.php');
