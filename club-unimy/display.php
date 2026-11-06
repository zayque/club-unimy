<?php
require_once __DIR__ . '/lib/app.php';

$done = $_SESSION['reg_done'] ?? null;
unset($_SESSION['reg_done']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registration Complete · ClubHub</title>
    <link rel="icon" type="image/svg+xml" href="img/logo.svg" />
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">
    <style>
    .cb-success-icon {
        width: 84px; height: 84px; margin: 0 auto 1.25rem;
        border-radius: 50%; display: grid; place-items: center;
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff; font-size: 2.2rem;
        box-shadow: 0 14px 34px rgba(16, 185, 129, .4);
        animation: cb-pop .5s .15s cubic-bezier(.2, 1.4, .4, 1) both;
    }
    @keyframes cb-pop { from { transform: scale(.4); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .cb-summary { text-align: left; background: #f8fafc; border: 1px solid var(--cb-border); border-radius: 14px; padding: 1rem 1.25rem; margin: 1.5rem 0; }
    .cb-summary h6 { font-size: .72rem; text-transform: uppercase; letter-spacing: .08em; color: var(--cb-muted); font-weight: 700; margin-bottom: .6rem; }
    </style>
</head>

<body class="cb-auth">
    <div class="cb-auth-card text-center">
        <div class="cb-success-icon"><i class="fa fa-check"></i></div>
        <span class="cb-badge">Registration complete</span>
        <h1 class="h3 font-weight-bold">
            <?= $done ? 'Welcome aboard, ' . e(explode(' ', $done['name'])[0]) . '!' : 'Thank you for joining us!' ?>
        </h1>
        <p class="text-muted mb-0">Your club registration has been received.</p>

        <?php if ($done) { ?>
        <div class="cb-summary">
            <h6>You joined</h6>
            <?php foreach ($done['clubs'] as $k) { $c = club_by_keyword($k); if (!$c) continue; ?>
            <span class="cb-pill" style="background:<?= $c['color'] ?>1a;color:<?= $c['color'] ?>"><i class="fa <?= $c['icon'] ?>"></i> <?= e($c['name']) ?></span>
            <?php } ?>
            <h6 class="mt-3">Next steps</h6>
            <p class="small mb-0">
                <?= $done['mailed'] ? 'We sent a confirmation to <strong>' . e($done['email']) . '</strong>. ' : '' ?>
                Sign in to the student portal with your email and student ID to see upcoming club activities.
            </p>
        </div>
        <?php } ?>

        <a href="../club-user/loginUser.php" class="btn btn-primary btn-block"><i class="fa fa-sign-in mr-1"></i> Go to the student portal</a>
        <a href="club-form.php" class="btn btn-secondary btn-block">Register another student</a>
        <div class="cb-auth-foot"><img src="img/logo.svg" alt="" style="width:20px;vertical-align:-5px"> ClubHub</div>
    </div>
</body>

</html>
