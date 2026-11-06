<?php
/**
 * Student portal bootstrap. Shares the club list, database and helpers with the admin app.
 */
require_once __DIR__ . '/../club-unimy/lib/app.php';

function current_student(): ?array
{
    if (empty($_SESSION['login_user'])) {
        return null;
    }
    return row("SELECT * FROM user WHERE email_user = ? LIMIT 1", [$_SESSION['login_user']]);
}

function require_student(): array
{
    $s = current_student();
    if (!$s) {
        unset($_SESSION['login_user']);
        redirect('loginUser.php');
    }
    return $s;
}
