<?php
require_once __DIR__ . '/lib.php';

if (current_student()) {
    redirect('index.php');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = strtolower(trim($_POST['email_user'] ?? ''));
    $studentid = strtoupper(trim($_POST['studentid_user'] ?? ''));

    if ($email === '' || $studentid === '') {
        $error = 'Enter your email and student ID.';
    } else {
        $s = row("SELECT * FROM user WHERE LOWER(email_user) = ? AND UPPER(studentid_user) = ? LIMIT 1", [$email, $studentid]);
        if (!$s) {
            $error = "We couldn't find a student with that email and student ID.";
        } else {
            session_regenerate_id(true);
            $_SESSION['login_user'] = $s['email_user'];
            flash('Welcome back, ' . explode(' ', trim($s['name_user']))[0] . '!');
            redirect('index.php');
        }
    }
}

$flashes = take_flashes();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login · ClubHub</title>
    <link rel="icon" type="image/svg+xml" href="img/logo.svg" />
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/clubhub.css">
</head>

<body>

    <div class="cb-login">
        <aside class="cb-login-art">
            <a class="cb-brand" href="loginUser.php"><img src="img/logo.svg" alt=""> ClubHub</a>

            <div>
                <h1>Your campus life,<br><span>all in one place.</span></h1>
                <p>Check your club memberships, upcoming meetings and activities — and stay connected with your community.</p>
            </div>

            <div class="cb-floating">
                <?php foreach (array_slice(CLUBS, 0, 6) as $c) { ?>
                <span><i class="fas <?= str_replace('fa-shield', 'fa-shield-alt', $c['icon']) ?>"></i> <?= e($c['keyword']) ?></span>
                <?php } ?>
            </div>
        </aside>

        <main class="cb-login-form-wrap">
            <form class="cb-login-form" action="" method="POST">
                <?= csrf_field() ?>
                <span class="cb-badge"><i class="fas fa-user-graduate"></i> Student Portal</span>
                <h2>Sign in</h2>
                <p>Use your registered email and student ID.</p>

                <?php if ($error) { ?>
                <div class="cb-alert cb-alert-error"><i class="fas fa-exclamation-circle"></i> <?= e($error) ?></div>
                <?php } ?>
                <?php foreach ($flashes as $f) { ?>
                <div class="cb-alert <?= $f['type'] === 'error' ? 'cb-alert-error' : '' ?>"><i class="fas fa-check-circle"></i> <?= e($f['message']) ?></div>
                <?php } ?>

                <div class="cb-field">
                    <label for="email_user">Email</label>
                    <div class="cb-input">
                        <i class="far fa-envelope"></i>
                        <input type="email" id="email_user" name="email_user" placeholder="name@example.com" required autocomplete="email"
                            value="<?= e($email) ?>">
                    </div>
                </div>

                <div class="cb-field">
                    <label for="myInput">Student ID</label>
                    <div class="cb-input">
                        <i class="far fa-id-card"></i>
                        <input type="password" name="studentid_user" id="myInput" placeholder="Your student ID" required>
                        <button type="button" class="cb-toggle" onclick="toggleId(this)" aria-label="Show student ID">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="cb-btn cb-btn-primary" type="submit" name="submit">
                    Sign in <i class="fas fa-arrow-right"></i>
                </button>


                <p class="cb-login-note">Not registered yet? <a href="../club-unimy/club-form.php">Join a club</a></p>
            </form>
        </main>
    </div>

    <script>
    function toggleId(btn) {
        var x = document.getElementById("myInput");
        var show = x.type === "password";
        x.type = show ? "text" : "password";
        btn.innerHTML = show ? '<i class="far fa-eye-slash"></i>' : '<i class="far fa-eye"></i>';
    }
    </script>

</body>

</html>
