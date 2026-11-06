<?php
require_once __DIR__ . '/lib/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin.php');
}
csrf_check();

$studentid = trim($_POST['studentid'] ?? '');
$pwd = (string)($_POST['pwd'] ?? '');
$_SESSION['login_old'] = $studentid;

if ($studentid === '' || $pwd === '') {
    flash('Enter your student ID and password.', 'error');
    redirect('admin.php');
}

// Accept either the student ID or the username
$admin = row("SELECT * FROM adminlogin WHERE student_id = ? OR user_uid = ? LIMIT 1", [$studentid, $studentid]);

if (!$admin || !password_verify($pwd, $admin['user_pwd'])) {
    flash('That student ID or password is incorrect.', 'error');
    redirect('admin.php');
}

session_regenerate_id(true);
unset($_SESSION['login_old']);
$_SESSION['u_id']        = $admin['user_id'] ?? null;
$_SESSION['u_first']     = $admin['user_first'];
$_SESSION['u_last']      = $admin['user_last'];
$_SESSION['u_email']     = $admin['user_email'];
$_SESSION['u_uid']       = $admin['user_uid'];
$_SESSION['u_studentid'] = $admin['student_id'];

flash('Welcome back, ' . $admin['user_first'] . '!');
redirect('dashboard.php');
