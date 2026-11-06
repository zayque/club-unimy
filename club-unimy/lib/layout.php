<?php
/**
 * Admin page shell. Usage:
 *   admin_header('Students', 'Everyone who has registered.', 'students');
 *   ... page content ...
 *   admin_footer();
 */

function nav_items(): array
{
    return [
        ['dashboard', 'Dashboard',        'fa-th-large',   'dashboard.php'],
        ['students',  'Students',         'fa-users',      'students.php'],
        ['clubs',     'Clubs',            'fa-flag',       'form/club.php'],
        ['activity',  'Activities',       'fa-calendar',   'activity/index.php'],
        ['register',  'Registration',     'fa-list-alt',   'forminfo.php'],
        ['email',     'Email template',   'fa-envelope-o', 'maklumatemail.php'],
        ['admins',    'Admins',           'fa-user-secret', 'admins.php'],
    ];
}

function admin_header(string $title, string $subtitle = '', string $active = '', string $actions = ''): void
{
    $u = 'url';
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title) ?> · <?= APP_NAME ?> Admin</title>
    <link rel="icon" type="image/svg+xml" href="<?= $u('img/logo.svg') ?>" />
    <link href="<?= $u('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= $u('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= $u('vendor/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <link href="<?= $u('css/sb-admin.css') ?>" rel="stylesheet">
    <link href="<?= $u('css/theme.css') ?>" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="<?= $u('dashboard.php') ?>">
            <img src="<?= $u('img/logo.svg') ?>" alt="">
            <span><?= APP_NAME ?><small>Admin Panel</small></span>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="cb-nav-label">Menu</li>
                <li class="nav-item">
                    <?php foreach (nav_items() as [$key, $label, $icon, $href]) { ?>
                    <a class="nav-link<?= $key === $active ? ' active' : '' ?>" href="<?= $u($href) ?>" title="<?= e($label) ?>">
                        <i class="fa <?= $icon ?>" aria-hidden="true"></i>
                        <span class="nav-link-text"><?= e($label) ?></span>
                    </a>
                    <?php } ?>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler"><i class="fa fa-fw fa-angle-left"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $u('../club-user/loginUser.php') ?>" target="_blank" rel="noopener">
                        <i class="fa fa-external-link"></i> Student portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $u('profile.php') ?>">
                        <i class="fa fa-user-circle-o"></i> <?= e($_SESSION['u_first'] ?? 'Admin') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link cb-logout" data-toggle="modal" data-target="#logoutModal" href="#">
                        <i class="fa fa-fw fa-sign-out"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="breadcrumb cb-page-head">
                <div>
                    <h4><?= e($title) ?></h4>
                    <?php if ($subtitle) { ?><small><?= e($subtitle) ?></small><?php } ?>
                </div>
                <?php if ($actions) { ?><div class="cb-head-actions"><?= $actions ?></div><?php } ?>
            </div>
<?php
}

function admin_footer(string $scripts = ''): void
{
    $u = 'url';
    $flashes = take_flashes();
    ?>
        </div>
    </div>

    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>&copy; <?= date('Y') ?> <?= APP_NAME ?> &middot; Club Registration System</small>
            </div>
        </div>
    </footer>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fa fa-angle-up"></i></a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutLabel">Log out?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">You'll need to sign in again to manage clubs.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="<?= $u('process/logout.php') ?>">Log out</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reusable confirmation dialog for forms with data-confirm -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="confirmText"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="button" id="confirmOk">Yes, continue</button>
                </div>
            </div>
        </div>
    </div>

    <div class="cb-toasts" id="cbToasts">
        <?php foreach ($flashes as $f) { ?>
        <div class="cb-toast cb-toast-<?= e($f['type']) ?>">
            <i class="fa <?= $f['type'] === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle' ?>"></i>
            <span><?= e($f['message']) ?></span>
        </div>
        <?php } ?>
    </div>

    <script src="<?= $u('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= $u('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= $u('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= $u('vendor/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?= $u('vendor/datatables/dataTables.bootstrap4.js') ?>"></script>
    <script src="<?= $u('js/sb-admin.min.js') ?>"></script>
    <script src="<?= $u('js/clubhub.js') ?>"></script>
    <?= $scripts ?>
</body>

</html>
<?php
}
