<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';

$me = row("SELECT * FROM adminlogin WHERE student_id = ?", [$_SESSION['u_studentid'] ?? '']);
if (!$me) {
    redirect('process/logout.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'details') {
        $first = trim($_POST['first'] ?? '');
        $last = trim($_POST['last'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($first === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('Enter your first name and a valid email.', 'error');
        } else {
            q("UPDATE adminlogin SET user_first = ?, user_last = ?, user_email = ? WHERE student_id = ?", [$first, $last, $email, $me['student_id']]);
            $_SESSION['u_first'] = $first;
            $_SESSION['u_last'] = $last;
            $_SESSION['u_email'] = $email;
            flash('Your details were updated.');
        }
    } else {
        $current = (string)($_POST['current'] ?? '');
        $new = (string)($_POST['new'] ?? '');
        if (!password_verify($current, $me['user_pwd'])) {
            flash('Your current password is incorrect.', 'error');
        } elseif (strlen($new) < 8) {
            flash('The new password must be at least 8 characters.', 'error');
        } elseif ($new !== ($_POST['confirm'] ?? '')) {
            flash("The new passwords don't match.", 'error');
        } else {
            q("UPDATE adminlogin SET user_pwd = ? WHERE student_id = ?", [password_hash($new, PASSWORD_DEFAULT), $me['student_id']]);
            flash('Password changed.');
        }
    }
    redirect('profile.php');
}

admin_header('My account', '@' . $me['user_uid'] . ' · ' . strtoupper($me['student_id']), '');
?>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-user-o"></i> Details</h5></div>
            <div class="card-body">
                <form method="post">
                    <?= csrf_field() ?><input type="hidden" name="action" value="details">
                    <div class="form-row">
                        <div class="form-group col-6"><label for="first">First name</label><input class="form-control" id="first" name="first" value="<?= e($me['user_first']) ?>" required></div>
                        <div class="form-group col-6"><label for="last">Last name</label><input class="form-control" id="last" name="last" value="<?= e($me['user_last']) ?>"></div>
                    </div>
                    <div class="form-group"><label for="email">Email</label><input type="email" class="form-control" id="email" name="email" value="<?= e($me['user_email']) ?>" required></div>
                    <button class="btn btn-primary">Save details</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-key"></i> Change password</h5></div>
            <div class="card-body">
                <form method="post">
                    <?= csrf_field() ?><input type="hidden" name="action" value="password">
                    <div class="form-group"><label for="current">Current password</label><input type="password" class="form-control" id="current" name="current" required></div>
                    <div class="form-group"><label for="new">New password</label><input type="password" class="form-control" id="new" name="new" minlength="8" required></div>
                    <div class="form-group"><label for="confirm">Confirm new password</label><input type="password" class="form-control" id="confirm" name="confirm" minlength="8" required></div>
                    <button class="btn btn-primary">Change password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php admin_footer(); ?>
