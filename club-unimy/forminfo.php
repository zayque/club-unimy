<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';

$settings = registration_settings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $limit = max(0, (int)($_POST['limit'] ?? 0));
    $message = trim($_POST['message'] ?? '') ?: 'Registration is full.';
    $exists = row("SELECT 1 FROM limitseminar LIMIT 1");
    if ($exists) {
        q("UPDATE limitseminar SET jumlah_limit2 = ?, mesej_limit2 = ?", [$limit, $message]);
    } else {
        q("INSERT INTO limitseminar (id_limit2, jumlah_limit2, mesej_limit2) VALUES ('1', ?, ?)", [$limit, $message]);
    }
    flash('Registration settings saved.');
    redirect('forminfo.php');
}

$total = total_students();
$open = $total < $settings['limit'];
$pct = $settings['limit'] > 0 ? min(100, round($total / $settings['limit'] * 100)) : 100;
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$formUrl = $scheme . '://' . $_SERVER['HTTP_HOST'] . app_web_path() . '/club-form.php';

admin_header('Registration', 'Control how many students can sign up and share the form.', 'register',
    '<a class="btn" href="club-form.php" target="_blank" rel="noopener"><i class="fa fa-external-link mr-1"></i> Open form</a>');
?>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card mb-4">
            <div class="card-body p-4">
                <span class="cb-pill" style="background:<?= $open ? '#10b9811a;color:#059669' : '#ef44441a;color:#dc2626' ?>">
                    <i class="fa fa-circle"></i> <?= $open ? 'Open for registration' : 'Closed – limit reached' ?>
                </span>
                <div class="d-flex align-items-end justify-content-between mt-3 mb-2">
                    <div><span class="cb-stat-value" style="font-size:2.4rem"><?= $total ?></span> <span class="cb-muted">/ <?= $settings['limit'] ?> students</span></div>
                    <strong><?= $pct ?>%</strong>
                </div>
                <div class="cb-progress<?= $pct >= 90 ? ' warn' : '' ?>"><span style="width:<?= $pct ?>%"></span></div>
                <p class="small cb-muted mt-2 mb-0"><?= $open ? max(0, $settings['limit'] - $total) . ' places left.' : 'New students see your "full" message instead of the form.' ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-share-alt"></i> Share the form</h5></div>
            <div class="card-body">
                <p class="small cb-muted">Send this link to students so they can register.</p>
                <div class="input-group">
                    <input class="form-control" id="formUrl" value="<?= e($formUrl) ?>" readonly>
                    <div class="input-group-append"><button class="btn btn-primary" type="button" data-copy="#formUrl"><i class="fa fa-clone"></i> Copy</button></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-sliders"></i> Settings</h5></div>
            <div class="card-body p-4">
                <form method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="limit">Maximum number of students</label>
                        <input type="number" min="0" class="form-control" id="limit" name="limit" value="<?= $settings['limit'] ?>" required>
                        <small class="form-text cb-muted">The form closes automatically once this many students have registered.</small>
                    </div>
                    <div class="form-group">
                        <label for="message">Message shown when registration is full</label>
                        <textarea class="form-control" id="message" name="message" rows="3" maxlength="200"><?= e($settings['message']) ?></textarea>
                    </div>
                    <button class="btn btn-primary"><i class="fa fa-check mr-1"></i> Save settings</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php admin_footer(); ?>
