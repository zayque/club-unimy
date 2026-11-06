<?php
require_once __DIR__ . '/lib/app.php';
if (is_admin()) {
    redirect('dashboard.php');
}
$flashes = take_flashes();
$old = $_SESSION['login_old'] ?? '';
unset($_SESSION['login_old']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login · ClubHub</title>
    <link rel="icon" type="image/svg+xml" href="img/logo.svg" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/theme.css">
</head>

<body class="cb-auth">

    <div class="cb-auth-card">
        <div class="cb-auth-brand">
            <img src="img/logo.svg" alt="ClubHub">
            <div><span class="cb-badge">Admin Portal</span></div>
            <h1>Welcome back</h1>
            <p>Sign in to manage clubs, members and activities.</p>
        </div>

        <?php foreach ($flashes as $f) { ?>
        <div class="alert <?= $f['type'] === 'error' ? 'alert-danger' : 'alert-success' ?> py-2 small font-weight-bold" role="alert">
            <i class="fa <?= $f['type'] === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle' ?> mr-1"></i><?= e($f['message']) ?>
        </div>
        <?php } ?>

        <form action="adminlogin.php" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="studentid">Student ID or username</label>
                <div class="cb-input-wrap">
                    <i class="fa fa-id-card-o"></i>
                    <input name="studentid" type="text" class="form-control" id="studentid" placeholder="e.g. B09190001"
                        value="<?= e($old) ?>" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="cb-input-wrap">
                    <i class="fa fa-lock"></i>
                    <input name="pwd" type="password" class="form-control" id="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="submit">
                Sign in <i class="fa fa-arrow-right ml-1"></i>
            </button>
        </form>


        <div class="cb-auth-foot">
            <a href="club-form.php"><i class="fa fa-external-link"></i> Open the public registration form</a>
        </div>
    </div>

</body>

</html>
