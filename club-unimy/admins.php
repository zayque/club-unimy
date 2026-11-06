<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';

$errors = [];
$old = ['first' => '', 'last' => '', 'email' => '', 'uid' => '', 'studentid' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $sid = (string)($_POST['studentid'] ?? '');
        if (strcasecmp($sid, $_SESSION['u_studentid'] ?? '') === 0) {
            flash("You can't remove your own account.", 'error');
        } elseif ((int)row("SELECT COUNT(*) n FROM adminlogin")['n'] <= 1) {
            flash('There must be at least one admin.', 'error');
        } else {
            q("DELETE FROM adminlogin WHERE student_id = ?", [$sid]);
            flash('Admin removed.');
        }
        redirect('admins.php');
    }

    if ($action === 'add') {
        $old = [
            'first'     => trim($_POST['first'] ?? ''),
            'last'      => trim($_POST['last'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'uid'       => trim($_POST['uid'] ?? ''),
            'studentid' => strtoupper(trim($_POST['studentid'] ?? '')),
        ];
        $pwd = (string)($_POST['pwd'] ?? '');
        if ($old['first'] === '' || $old['last'] === '') $errors[] = 'Enter a first and last name.';
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
        if (!preg_match('/^[A-Za-z0-9_.-]{3,30}$/', $old['uid'])) $errors[] = 'Username must be 3–30 letters, numbers, dots, dashes or underscores.';
        if ($old['studentid'] === '') $errors[] = 'Enter a student ID.';
        if (strlen($pwd) < 8) $errors[] = 'Password must be at least 8 characters.';
        if (!$errors && row("SELECT 1 FROM adminlogin WHERE user_uid = ? OR student_id = ? OR user_email = ?", [$old['uid'], $old['studentid'], $old['email']])) {
            $errors[] = 'An admin with this username, student ID or email already exists.';
        }
        if (!$errors) {
            q("INSERT INTO adminlogin (user_first, user_last, user_email, user_uid, user_pwd, student_id) VALUES (?, ?, ?, ?, ?, ?)",
                [$old['first'], $old['last'], $old['email'], $old['uid'], password_hash($pwd, PASSWORD_DEFAULT), $old['studentid']]);
            flash($old['first'] . ' can now sign in to the admin panel.');
            redirect('admins.php');
        }
    }
}

$admins = rows("SELECT user_first, user_last, user_email, user_uid, student_id FROM adminlogin ORDER BY user_first");
admin_header('Admins', 'People who can sign in to this admin panel.', 'admins');
?>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-body">
                <ul class="cb-list">
                    <?php foreach ($admins as $a) { $me = strcasecmp($a['student_id'], $_SESSION['u_studentid'] ?? '') === 0; ?>
                    <li>
                        <div class="cb-avatar-sm"><?= e(strtoupper(substr($a['user_first'], 0, 1))) ?></div>
                        <div class="flex-grow-1" style="min-width:0">
                            <strong><?= e($a['user_first'] . ' ' . $a['user_last']) ?> <?= $me ? '<span class="cb-pill" style="background:#eef2ff;color:#4f46e5">You</span>' : '' ?></strong>
                            <small class="d-block text-truncate">@<?= e($a['user_uid']) ?> · <?= e(strtoupper($a['student_id'])) ?> · <?= e($a['user_email']) ?></small>
                        </div>
                        <?php if (!$me) { ?>
                        <form method="post" data-confirm="Remove <?= e($a['user_first']) ?>'s admin access?">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="studentid" value="<?= e($a['student_id']) ?>">
                            <button class="btn btn-light-danger btn-sm" title="Remove admin"><i class="fa fa-trash"></i></button>
                        </form>
                        <?php } else { ?>
                        <a href="profile.php" class="btn btn-light-primary btn-sm">Edit</a>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-4" id="add">
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-user-plus"></i> Add an admin</h5></div>
            <div class="card-body">
                <?php if ($errors) { ?>
                <div class="alert alert-danger small"><?php foreach ($errors as $er) { echo '<div>' . e($er) . '</div>'; } ?></div>
                <?php } ?>
                <form method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="add">
                    <div class="form-row">
                        <div class="form-group col-6"><label for="first">First name</label><input class="form-control" id="first" name="first" value="<?= e($old['first']) ?>" required></div>
                        <div class="form-group col-6"><label for="last">Last name</label><input class="form-control" id="last" name="last" value="<?= e($old['last']) ?>" required></div>
                    </div>
                    <div class="form-group"><label for="email">Email</label><input type="email" class="form-control" id="email" name="email" value="<?= e($old['email']) ?>" required></div>
                    <div class="form-row">
                        <div class="form-group col-6"><label for="uid">Username</label><input class="form-control" id="uid" name="uid" value="<?= e($old['uid']) ?>" required></div>
                        <div class="form-group col-6"><label for="studentid">Student ID</label><input class="form-control" id="studentid" name="studentid" maxlength="10" value="<?= e($old['studentid']) ?>" required></div>
                    </div>
                    <div class="form-group"><label for="pwd">Password</label><input type="password" class="form-control" id="pwd" name="pwd" minlength="8" placeholder="At least 8 characters" required></div>
                    <button class="btn btn-primary btn-block"><i class="fa fa-user-plus mr-1"></i> Create admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php admin_footer(); ?>
