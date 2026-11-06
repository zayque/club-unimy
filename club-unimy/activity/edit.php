<?php
require_once __DIR__ . '/../includes/core.php';
require_once __DIR__ . '/../lib/layout.php';

$id = (int)($_GET['id'] ?? $_GET['club_id'] ?? 0);
$activity = $id ? row("SELECT * FROM club_activity WHERE club_id = ?", [$id]) : null;
if ($id && !$activity) {
    flash('That activity no longer exists.', 'error');
    redirect('index.php');
}

$data = $activity ?: [
    'club_type' => isset(CLUBS[$_GET['type'] ?? '']) ? $_GET['type'] : 'esport',
    'club_image' => '', 'club_content' => '', 'club_content_2' => '',
    'club_date' => date('Y-m-d', strtotime('+7 days')), 'club_time' => '', 'club_contact' => '', 'club_name' => '',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $data = [
        'club_type'      => $_POST['club_type'] ?? '',
        'club_image'     => $activity['club_image'] ?? '',
        'club_content'   => trim($_POST['club_content'] ?? ''),
        'club_content_2' => trim($_POST['club_content_2'] ?? ''),
        'club_date'      => $_POST['club_date'] ?? '',
        'club_time'      => trim($_POST['club_time'] ?? ''),
        'club_contact'   => trim($_POST['club_contact'] ?? ''),
        'club_name'      => trim($_POST['club_name'] ?? ''),
    ];

    if (!isset(CLUBS[$data['club_type']])) $errors['club_type'] = 'Choose a club.';
    if ($data['club_content'] === '') $errors['club_content'] = 'Give the activity a title.';
    if (!DateTime::createFromFormat('Y-m-d', $data['club_date'])) $errors['club_date'] = 'Choose a date.';
    if ($data['club_time'] === '') $errors['club_time'] = 'Enter a time, e.g. 3:00 pm.';
    if ($data['club_name'] === '') $errors['club_name'] = 'Enter the person in charge.';

    // Image: new upload, pasted URL, or removal
    try {
        $uploaded = save_upload('image_file');
    } catch (RuntimeException $ex) {
        $errors['image'] = $ex->getMessage();
        $uploaded = null;
    }
    $url = trim($_POST['image_url'] ?? '');
    if ($uploaded) {
        $data['club_image'] = $uploaded;
    } elseif (!empty($_POST['remove_image'])) {
        $data['club_image'] = '';
    } elseif ($url !== '' && $url !== ($activity['club_image'] ?? '')) {
        if (!preg_match('~^(https?://|/)~i', $url)) {
            $errors['image'] = 'Image links must start with http://, https:// or /.';
        } else {
            $data['club_image'] = $url;
        }
    }

    if (!$errors) {
        if ($activity && $data['club_image'] !== $activity['club_image']) {
            delete_upload($activity['club_image']);
        }
        $vals = [$data['club_image'], $data['club_content'], $data['club_content_2'], $data['club_date'], $data['club_time'], $data['club_contact'], $data['club_name'], $data['club_type']];
        if ($activity) {
            q("UPDATE club_activity SET club_image = ?, club_content = ?, club_content_2 = ?, club_date = ?, club_time = ?, club_contact = ?, club_name = ?, club_type = ? WHERE club_id = ?", [...$vals, $id]);
            flash('Activity updated.');
        } else {
            q("INSERT INTO club_activity (club_image, club_content, club_content_2, club_date, club_time, club_contact, club_name, club_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", $vals);
            flash('Activity added. Students can see it on their portal now.');
        }
        redirect('index.php?type=' . $data['club_type']);
    } elseif ($uploaded) {
        delete_upload($uploaded); // don't keep orphan files when the form has errors
        $data['club_image'] = $activity['club_image'] ?? '';
    }
}

admin_header($activity ? 'Edit activity' : 'New activity', 'Students see this on their portal under Activities.', 'activity');

function err(array $errors, string $k): string
{
    return isset($errors[$k]) ? '<div class="invalid-feedback d-block">' . e($errors[$k]) . '</div>' : '';
}
?>

<form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-body p-4">
                    <div class="form-group">
                        <label>Club</label>
                        <div class="cb-check-grid">
                            <?php foreach (CLUBS as $t => $c) { ?>
                            <label>
                                <input type="radio" name="club_type" value="<?= $t ?>" <?= $data['club_type'] === $t ? 'checked' : '' ?>>
                                <i class="fa <?= $c['icon'] ?>" style="color:<?= $c['color'] ?>"></i><span><?= e($c['name']) ?></span>
                            </label>
                            <?php } ?>
                        </div>
                        <?= err($errors, 'club_type') ?>
                    </div>
                    <div class="form-group">
                        <label for="club_content">Title</label>
                        <input class="form-control<?= isset($errors['club_content']) ? ' is-invalid' : '' ?>" id="club_content" name="club_content" maxlength="200" value="<?= e($data['club_content']) ?>" placeholder="e.g. Weekly practice session" required>
                        <?= err($errors, 'club_content') ?>
                    </div>
                    <div class="form-group">
                        <label for="club_content_2">What will happen</label>
                        <textarea class="form-control" id="club_content_2" name="club_content_2" rows="3" maxlength="200" placeholder="Short description students will read"><?= e($data['club_content_2']) ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="club_date">Date</label>
                            <input type="date" class="form-control<?= isset($errors['club_date']) ? ' is-invalid' : '' ?>" id="club_date" name="club_date" value="<?= e($data['club_date']) ?>" required>
                            <?= err($errors, 'club_date') ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="club_time">Time</label>
                            <input class="form-control<?= isset($errors['club_time']) ? ' is-invalid' : '' ?>" id="club_time" name="club_time" maxlength="200" value="<?= e($data['club_time']) ?>" placeholder="e.g. 3:00 pm – 5:00 pm" required>
                            <?= err($errors, 'club_time') ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="club_name">Person in charge</label>
                            <input class="form-control<?= isset($errors['club_name']) ? ' is-invalid' : '' ?>" id="club_name" name="club_name" maxlength="200" value="<?= e($data['club_name']) ?>" required>
                            <?= err($errors, 'club_name') ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="club_contact">Contact number</label>
                            <input type="tel" class="form-control" id="club_contact" name="club_contact" maxlength="200" value="<?= e($data['club_contact']) ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-picture-o"></i> Cover image</h5></div>
                <div class="card-body">
                    <div class="cb-act-top mb-3" id="imgPreview" style="border-radius:12px;overflow:hidden;background:linear-gradient(135deg,#6366f1,#0f172a)">
                        <i class="fa fa-picture-o"></i>
                        <?php if ($data['club_image']) { ?><img src="<?= e($data['club_image']) ?>" alt="" onerror="this.remove()"><?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="image_file" class="small">Upload (JPG, PNG, GIF, WebP · max 3 MB)</label>
                        <input type="file" class="form-control-file" id="image_file" name="image_file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="image_url" class="small">…or paste an image link</label>
                        <input class="form-control" id="image_url" name="image_url" value="<?= e($data['club_image']) ?>" placeholder="https://…">
                    </div>
                    <?php if ($data['club_image']) { ?>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remove_image" name="remove_image" value="1">
                        <label class="custom-control-label small" for="remove_image">Remove image (use the club icon)</label>
                    </div>
                    <?php } ?>
                    <?= err($errors, 'image') ?>
                </div>
            </div>
            <button class="btn btn-primary btn-block"><i class="fa fa-check mr-1"></i> <?= $activity ? 'Save changes' : 'Publish activity' ?></button>
            <a href="index.php?type=<?= e($data['club_type']) ?>" class="btn btn-secondary btn-block">Cancel</a>
        </div>
    </div>
</form>

<?php admin_footer('<script>
document.getElementById("image_file").addEventListener("change", function () {
    var f = this.files[0], box = document.getElementById("imgPreview");
    if (!f) return;
    var img = box.querySelector("img") || box.appendChild(document.createElement("img"));
    img.src = URL.createObjectURL(f);
});
</script>'); ?>
