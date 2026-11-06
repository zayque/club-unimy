<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';

$id = (int)($_GET['id_user'] ?? 0);
$student = $id ? row("SELECT * FROM user WHERE id_user = ?", [$id]) : null;
if ($id && !$student) {
    flash('That student no longer exists.', 'error');
    redirect('students.php');
}

$errors = [];
$data = $student ?: ['name_user' => '', 'studentid_user' => '', 'email_user' => '', 'phone_user' => '', 'club_user' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $data = [
        'name_user'      => trim($_POST['name_user'] ?? ''),
        'studentid_user' => strtoupper(trim($_POST['studentid_user'] ?? '')),
        'email_user'     => trim($_POST['email_user'] ?? ''),
        'phone_user'     => preg_replace('/[^0-9+]/', '', $_POST['phone_user'] ?? ''),
        'club_user'      => clubs_to_store((array)($_POST['clubs'] ?? [])),
    ];

    if ($data['name_user'] === '') $errors['name_user'] = 'Enter the student\'s name.';
    if ($data['studentid_user'] === '') $errors['studentid_user'] = 'Enter a student ID.';
    if (!filter_var($data['email_user'], FILTER_VALIDATE_EMAIL)) $errors['email_user'] = 'Enter a valid email address.';
    if (strlen($data['phone_user']) < 9) $errors['phone_user'] = 'Enter a phone number with at least 9 digits.';

    if (!$errors) {
        $dup = row("SELECT id_user FROM user WHERE (studentid_user = ? OR email_user = ?) AND id_user <> ? LIMIT 1",
            [$data['studentid_user'], $data['email_user'], $id]);
        if ($dup) $errors['studentid_user'] = 'Another student already uses this student ID or email.';
    }

    if (!$errors) {
        if ($id) {
            q("UPDATE user SET name_user = ?, studentid_user = ?, email_user = ?, phone_user = ?, club_user = ? WHERE id_user = ?",
                [...array_values($data), $id]);
            flash('Saved changes to ' . $data['name_user'] . '.');
        } else {
            q("INSERT INTO user (name_user, studentid_user, email_user, phone_user, club_user) VALUES (?, ?, ?, ?, ?)", array_values($data));
            flash($data['name_user'] . ' was added.');
        }
        redirect('students.php');
    }
}

$mine = club_list($data['club_user']);
admin_header($id ? 'Edit student' : 'Add student', $id ? 'Update details and club membership.' : 'Register a student manually.', 'students');

function field(string $name, string $label, string $icon, array $data, array $errors, string $type = 'text'): void { ?>
    <div class="form-group">
        <label for="<?= $name ?>"><?= $label ?></label>
        <div class="cb-input-wrap">
            <i class="fa <?= $icon ?>"></i>
            <input type="<?= $type ?>" name="<?= $name ?>" id="<?= $name ?>" value="<?= e($data[$name]) ?>"
                class="form-control<?= isset($errors[$name]) ? ' is-invalid' : '' ?>" required>
        </div>
        <?php if (isset($errors[$name])) { ?><div class="invalid-feedback d-block"><?= e($errors[$name]) ?></div><?php } ?>
    </div>
<?php }
?>

<div class="card cb-form-card mb-4">
    <div class="card-body p-4">
        <form method="post">
            <?= csrf_field() ?>
            <?php field('name_user', 'Full name', 'fa-user-o', $data, $errors); ?>
            <div class="form-row">
                <div class="col-md-6"><?php field('studentid_user', 'Student ID', 'fa-id-card-o', $data, $errors); ?></div>
                <div class="col-md-6"><?php field('phone_user', 'Phone number', 'fa-phone', $data, $errors, 'tel'); ?></div>
            </div>
            <?php field('email_user', 'Email', 'fa-envelope-o', $data, $errors, 'email'); ?>

            <label class="d-block mt-2">Clubs</label>
            <div class="cb-check-grid mb-4">
                <?php foreach (CLUBS as $type => $c) { ?>
                <label>
                    <input type="checkbox" name="clubs[]" value="<?= e($c['keyword']) ?>" <?= in_array($c['keyword'], $mine, true) ? 'checked' : '' ?>>
                    <i class="fa <?= $c['icon'] ?>" style="color:<?= $c['color'] ?>"></i>
                    <span><?= e($c['name']) ?></span>
                </label>
                <?php } ?>
            </div>

            <div class="d-flex flex-wrap" style="gap:.5rem">
                <button class="btn btn-primary"><i class="fa fa-check mr-1"></i> <?= $id ? 'Save changes' : 'Add student' ?></button>
                <a href="students.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php admin_footer(); ?>
