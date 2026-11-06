<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';
require_once __DIR__ . '/lib/mailer.php';

$t = email_template();
$sample = ['name_user' => 'Ahmad Munir', 'studentid_user' => 'B08180002', 'email_user' => $_SESSION['u_email'] ?? 'student@example.com', 'phone_user' => '0123456789', 'club_user' => 'Photography,Music,'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'test') {
        $err = send_welcome_email($sample, $_SESSION['u_email'] ?? null);
        $err ? flash($err, 'error') : flash('Test email sent to ' . ($_SESSION['u_email'] ?? 'you') . '.');
        redirect('maklumatemail.php');
    }
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $alt = trim($_POST['altbody'] ?? '');
    if ($subject === '' || $body === '') {
        flash('The subject and message can\'t be empty.', 'error');
        redirect('maklumatemail.php');
    }
    if ($t['id_email']) {
        q("UPDATE email SET subject_email = ?, body_email = ?, altbody_email = ? WHERE id_email = ?", [$subject, $body, $alt, $t['id_email']]);
    } else {
        q("INSERT INTO email (subject_email, body_email, altbody_email) VALUES (?, ?, ?)", [$subject, $body, $alt]);
    }
    flash('Email template saved.');
    redirect('maklumatemail.php');
}

$configured = mail_config() !== null;
admin_header('Email template', 'The welcome email every student receives after registering.', 'email');
?>

<?php if (!$configured) { ?>
<div class="alert alert-warning d-flex align-items-start" style="border-radius:12px;gap:.75rem">
    <i class="fa fa-exclamation-triangle mt-1"></i>
    <div><strong>Emails are not being sent yet.</strong> Copy <code>club-unimy/mail-config.example.php</code> to
        <code>mail-config.php</code>, fill in your SMTP details and set <code>'enabled' =&gt; true</code>.
        Registration still works without it.</div>
</div>
<?php } ?>

<div class="row">
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-pencil"></i> Edit</h5></div>
            <div class="card-body p-4">
                <form method="post" id="tplForm">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input class="form-control" id="subject" name="subject" maxlength="200" value="<?= e($t['subject_email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Message</label>
                        <textarea class="form-control" id="body" name="body" rows="9" required><?= e($t['body_email']) ?></textarea>
                        <small class="form-text cb-muted">Placeholders:
                            <?php foreach (['{name}', '{student_id}', '{email}', '{phone}', '{clubs}'] as $ph) { ?>
                            <button type="button" class="btn btn-light-primary btn-sm js-insert" data-ph="<?= $ph ?>"><?= $ph ?></button>
                            <?php } ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="altbody">Plain-text version <span class="cb-muted font-weight-normal">(optional)</span></label>
                        <textarea class="form-control" id="altbody" name="altbody" rows="3"><?= e($t['altbody_email']) ?></textarea>
                    </div>
                    <div class="d-flex flex-wrap" style="gap:.5rem">
                        <button class="btn btn-primary"><i class="fa fa-check mr-1"></i> Save template</button>
                    </div>
                </form>
                <form method="post" class="mt-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="test">
                    <button class="btn btn-secondary" <?= $configured ? '' : 'disabled title="Set up mail-config.php first"' ?>>
                        <i class="fa fa-paper-plane mr-1"></i> Send me a test email</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-eye"></i> Preview <span class="cb-muted small font-weight-normal">with sample student</span></h5></div>
            <div class="card-body p-0">
                <div style="background:#f1f5f9;padding:1.5rem">
                    <div style="background:#fff;border-radius:12px;box-shadow:var(--cb-shadow);overflow:hidden">
                        <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--cb-border)">
                            <div class="small cb-muted">To: <?= e($sample['name_user']) ?> &lt;student@example.com&gt;</div>
                            <div class="font-weight-bold mt-1" id="pvSubject"></div>
                        </div>
                        <div style="padding:1.25rem;white-space:pre-wrap;line-height:1.6" id="pvBody"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$vars = ['{name}' => 'Ahmad Munir', '{student_id}' => 'B08180002', '{email}' => 'student@example.com', '{phone}' => '0123456789', '{clubs}' => 'Photography Crew, Music Club'];
admin_footer('<script>
(function () {
    var vars = ' . json_encode($vars) . ';
    function fill(s) { Object.keys(vars).forEach(function (k) { s = s.split(k).join(vars[k]); }); return s; }
    function render() {
        document.getElementById("pvSubject").textContent = fill(document.getElementById("subject").value);
        document.getElementById("pvBody").textContent = fill(document.getElementById("body").value);
    }
    ["subject", "body"].forEach(function (id) { document.getElementById(id).addEventListener("input", render); });
    document.querySelectorAll(".js-insert").forEach(function (b) {
        b.addEventListener("click", function () {
            var ta = document.getElementById("body"), p = ta.selectionStart;
            ta.value = ta.value.slice(0, p) + b.dataset.ph + ta.value.slice(ta.selectionEnd);
            ta.focus(); ta.selectionStart = ta.selectionEnd = p + b.dataset.ph.length; render();
        });
    });
    render();
})();
</script>');
