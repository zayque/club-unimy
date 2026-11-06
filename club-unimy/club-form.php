<?php
require_once __DIR__ . '/lib/app.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Join a Club · ClubHub</title>
    <link rel="icon" type="image/svg+xml" href="img/logo.svg" />
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">
    <style>
    body.cb-auth { align-items: flex-start; }

    .cb-join {
        width: 100%;
        max-width: 1120px;
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        gap: 2.5rem;
        align-items: start;
    }

    .cb-hero { color: #fff; padding-top: 1.5rem; position: sticky; top: 2rem; }
    .cb-hero .cb-logo { display: flex; align-items: center; gap: .75rem; font-weight: 800; font-size: 1.3rem; margin-bottom: 2.5rem; }
    .cb-hero .cb-logo img { width: 44px; height: 44px; }
    .cb-hero h1 { font-size: 2.8rem; font-weight: 800; letter-spacing: -.03em; line-height: 1.1; }
    .cb-hero h1 span { background: linear-gradient(90deg, #a5b4fc, #f0abfc); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .cb-hero > p { color: #cbd5e1; font-size: 1.08rem; max-width: 460px; margin: 1rem 0 2rem; }

    .cb-club-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .75rem; }
    .cb-club-tile {
        display: flex; align-items: center; gap: .75rem;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 14px; padding: .8rem 1rem;
        font-size: .9rem; font-weight: 600; color: #e2e8f0;
        backdrop-filter: blur(6px);
        transition: transform .2s, background .2s;
    }
    .cb-club-tile:hover { transform: translateY(-2px); background: rgba(255, 255, 255, .1); }
    .cb-club-tile i { width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center; color: #fff; flex: 0 0 34px; }

    .cb-join .cb-auth-card { max-width: none; }

    .cb-choices { display: grid; grid-template-columns: repeat(2, 1fr); gap: .6rem; }
    .cb-choice { position: relative; margin: 0; cursor: pointer; }
    .cb-choice input { position: absolute; opacity: 0; }
    .cb-choice .cb-choice-box {
        display: flex; align-items: flex-start; gap: .65rem;
        border: 1.5px solid var(--cb-border); border-radius: 12px;
        padding: .75rem .85rem; height: 100%;
        transition: border-color .15s, background .15s, box-shadow .15s;
    }
    .cb-choice .cb-check {
        flex: 0 0 20px; height: 20px; border-radius: 6px; margin-top: 1px;
        border: 1.5px solid #cbd5e1; display: grid; place-items: center;
        color: transparent; font-size: .7rem; transition: all .15s;
    }
    .cb-choice strong { display: block; font-size: .88rem; color: var(--cb-text); }
    .cb-choice small { display: block; font-size: .74rem; color: var(--cb-muted); font-weight: 500; margin-top: 2px; }
    .cb-choice:hover .cb-choice-box { border-color: #c7d2fe; }
    .cb-choice input:checked + .cb-choice-box { border-color: var(--cb-primary); background: #f5f3ff; box-shadow: 0 0 0 3px rgba(99, 102, 241, .12); }
    .cb-choice input:checked + .cb-choice-box .cb-check { background: var(--cb-gradient); border-color: transparent; color: #fff; }
    .cb-choice input:focus-visible + .cb-choice-box { outline: 2px solid var(--cb-primary); outline-offset: 2px; }

    .cb-section-label { font-weight: 700; font-size: .9rem; margin: 1.5rem 0 .75rem; display: block; }

    @media (max-width: 900px) {
        .cb-join { grid-template-columns: 1fr; gap: 1.5rem; }
        .cb-hero { position: static; padding-top: 0; }
        .cb-hero h1 { font-size: 2.1rem; }
        .cb-hero .cb-logo { margin-bottom: 1.25rem; }
    }

    @media (max-width: 520px) {
        .cb-choices, .cb-club-grid { grid-template-columns: 1fr; }
        .cb-join .cb-auth-card { padding: 1.75rem 1.25rem; }
    }
    .cb-err { color: #dc2626; font-size: .82rem; font-weight: 600; margin-top: .4rem; }
    .form-control.is-invalid { border-color: #ef4444; }
    .cb-spots { display: inline-flex; align-items: center; gap: .55rem; margin-top: 1.75rem; padding: .6rem 1rem; border-radius: 999px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); font-weight: 600; font-size: .9rem; color: #e0e7ff; }
    .cb-closed-icon { width: 76px; height: 76px; margin: 0 auto 1rem; border-radius: 50%; display: grid; place-items: center; background: #fef2f2; color: #ef4444; font-size: 2rem; }
    </style>
</head>

<body class="cb-auth">
    <?php
        $settings = registration_settings();
        $total = total_students();
        $full = $total >= $settings['limit'];
        $left = max(0, $settings['limit'] - $total);
        $errors = $_SESSION['reg_errors'] ?? [];
        $old = $_SESSION['reg_old'] ?? ['name' => '', 'studentid' => '', 'email' => '', 'phone' => '', 'clubs' => []];
        unset($_SESSION['reg_errors'], $_SESSION['reg_old']);
        $err = function ($k) use ($errors) { return isset($errors[$k]) ? '<div class="cb-err"><i class="fa fa-exclamation-circle"></i> ' . e($errors[$k]) . '</div>' : ''; };
        $bad = function ($k) use ($errors) { return isset($errors[$k]) ? ' is-invalid' : ''; };
    ?>

    <div class="cb-join">
        <section class="cb-hero">
            <div class="cb-logo"><img src="img/logo.svg" alt=""> ClubHub</div>
            <h1>Find your people.<br><span>Join a club today.</span></h1>
            <p>Explore student clubs, meet people who share your interests and get involved in activities all semester long.</p>

            <div class="cb-club-grid">
                <?php foreach (CLUBS as $c) { ?>
                <div class="cb-club-tile">
                    <i class="fa <?= $c['icon'] ?>" style="background:<?= $c['color'] ?>"></i>
                    <?= e($c['name']) ?>
                </div>
                <?php } ?>
            </div>

            <div class="cb-spots">
                <i class="fa <?= $full ? 'fa-lock' : 'fa-ticket' ?>"></i>
                <?= $full ? 'Registration is full' : $left . ' place' . ($left === 1 ? '' : 's') . ' left this semester' ?>
            </div>
        </section>

        <section class="cb-auth-card" id="form">
            <?php if ($full) { ?>
            <div class="text-center py-4">
                <div class="cb-closed-icon"><i class="fa fa-lock"></i></div>
                <span class="cb-badge">Registration closed</span>
                <h2 class="h3 font-weight-bold mt-2"><?= e($settings['message']) ?></h2>
                <p class="text-muted mb-4">All places have been taken. Please contact the club office if you have questions.</p>
                <a href="../club-user/loginUser.php" class="btn btn-secondary">Already registered? Sign in</a>
            </div>
            <?php } else { ?>
            <div class="mb-4">
                <span class="cb-badge">Registration</span>
                <h2 class="h3 font-weight-bold mb-1">Club registration</h2>
                <p class="text-muted mb-0">Fill in your details and choose the clubs you're interested in.</p>
            </div>

            <?php if (isset($errors['form'])) { ?><div class="alert alert-danger"><?= e($errors['form']) ?></div><?php } ?>
            <?php if ($errors && !isset($errors['form'])) { ?>
            <div class="alert alert-danger small font-weight-bold"><i class="fa fa-exclamation-circle mr-1"></i> Please fix the highlighted fields.</div>
            <?php } ?>

            <form action="index_db.php" method="post" novalidate>
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="name1">Full name</label>
                    <div class="cb-input-wrap">
                        <i class="fa fa-user-o"></i>
                        <input type="text" class="form-control<?= $bad('name') ?>" id="name1" name="name1" placeholder="Your full name" value="<?= e($old['name']) ?>" required autocomplete="name">
                    </div>
                    <?= $err('name') ?>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="idstudent1">Student ID</label>
                        <div class="cb-input-wrap">
                            <i class="fa fa-id-card-o"></i>
                            <input type="text" class="form-control<?= $bad('studentid') ?>" id="idstudent1" name="idstudent1" placeholder="e.g. B08180002" maxlength="10" value="<?= e($old['studentid']) ?>" required>
                        </div>
                        <?= $err('studentid') ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="notel1">Phone number</label>
                        <div class="cb-input-wrap">
                            <i class="fa fa-phone"></i>
                            <input type="tel" class="form-control<?= $bad('phone') ?>" id="notel1" name="notel1" placeholder="01XXXXXXXXX" maxlength="13" value="<?= e($old['phone']) ?>" required autocomplete="tel">
                        </div>
                        <?= $err('phone') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email1">Student email</label>
                    <div class="cb-input-wrap">
                        <i class="fa fa-envelope-o"></i>
                        <input type="email" class="form-control<?= $bad('email') ?>" id="email1" name="email1" placeholder="name@example.com" value="<?= e($old['email']) ?>" required autocomplete="email">
                    </div>
                    <?= $err('email') ?>
                </div>

                <span class="cb-section-label">Interested clubs <span class="text-muted font-weight-normal" id="pickCount"></span></span>
                <div class="cb-choices">
                    <?php foreach (CLUBS as $c) { ?>
                    <label class="cb-choice">
                        <input type="checkbox" name="check[]" value="<?= e($c['keyword']) ?>" <?= in_array($c['keyword'], $old['clubs'], true) ? 'checked' : '' ?>>
                        <span class="cb-choice-box">
                            <span class="cb-check"><i class="fa fa-check"></i></span>
                            <span><strong><?= e($c['name']) ?></strong><small><?= e($c['desc']) ?></small></span>
                        </span>
                    </label>
                    <?php } ?>
                </div>
                <?= $err('clubs') ?>

                <button type="submit" class="btn btn-primary btn-block mt-4" id="submitBtn">
                    Submit registration <i class="fa fa-paper-plane ml-1"></i>
                </button>
                <p class="text-center small text-muted mt-3 mb-0">Already registered? <a href="../club-user/loginUser.php">Sign in to the student portal</a></p>
            </form>
            <?php } ?>
        </section>
    </div>

    <script>
    (function () {
        var boxes = document.querySelectorAll('input[name="check[]"]'), out = document.getElementById('pickCount');
        function count() {
            var n = Array.prototype.filter.call(boxes, function (b) { return b.checked; }).length;
            if (out) out.textContent = n ? '· ' + n + ' selected' : '';
        }
        Array.prototype.forEach.call(boxes, function (b) { b.addEventListener('change', count); });
        count();
        var form = document.querySelector('form[action="index_db.php"]');
        if (form) form.addEventListener('submit', function () {
            var btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Submitting…';
        });
    })();
    </script>
</body>

</html>
