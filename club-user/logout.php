<?php
// Logs the student out without touching an admin session in the same browser.
require_once __DIR__ . '/lib.php';
unset($_SESSION['login_user'], $_SESSION['login_msg']);
flash('You have been signed out.');
redirect('loginUser.php');
