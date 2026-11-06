<?php
require_once __DIR__ . '/../includes/core.php';
require_once __DIR__ . '/../lib/layout.php';

$type = $_GET['type'] ?? '';

// ----- overview of all clubs -----
if ($type === '') {
    admin_header('Clubs', 'Pick a club to see its members, print a list or export it.', 'clubs');
    ?>
    <div class="cb-act-grid">
        <?php foreach (CLUBS as $t => $c) {
            $n = member_count($t);
            $acts = (int)row("SELECT COUNT(*) n FROM club_activity WHERE club_type = ?", [$t])['n']; ?>
        <a class="cb-act" href="club.php?type=<?= $t ?>" style="color:inherit">
            <div class="cb-act-top" style="background:linear-gradient(135deg, <?= $c['color'] ?>, #0f172a)"><i class="fa <?= $c['icon'] ?>"></i></div>
            <div class="cb-act-body">
                <h5><?= e($c['name']) ?></h5>
                <p><?= e($c['desc']) ?></p>
                <div class="cb-act-meta">
                    <span><i class="fa fa-users"></i><?= $n ?> member<?= $n === 1 ? '' : 's' ?></span>
                    <span><i class="fa fa-calendar"></i><?= $acts ?> activit<?= $acts === 1 ? 'y' : 'ies' ?></span>
                </div>
            </div>
        </a>
        <?php } ?>
    </div>
    <?php
    admin_footer();
    exit;
}

$type = club_type_or_404($type);
$club = CLUBS[$type];

// ----- remove members from this club (keeps the student record) -----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $ids = array_filter(array_map('intval', (array)($_POST['ids'] ?? [$_POST['id'] ?? 0])));
    foreach ($ids as $id) {
        $s = row("SELECT club_user FROM user WHERE id_user = ?", [$id]);
        if ($s) {
            $left = array_diff(club_list($s['club_user']), [$club['keyword']]);
            q("UPDATE user SET club_user = ? WHERE id_user = ?", [clubs_to_store($left), $id]);
        }
    }
    flash(count($ids) . ' member(s) removed from ' . $club['name'] . '.');
    redirect('club.php?type=' . $type);
}

$members = members_of($type);
$upcoming = rows("SELECT * FROM club_activity WHERE club_type = ? AND club_date >= CURDATE() ORDER BY club_date LIMIT 3", [$type]);

admin_header(
    $club['name'],
    $club['desc'],
    'clubs',
    '<a class="btn" href="print/print.php?type=' . $type . '" target="_blank"><i class="fa fa-print mr-1"></i> Print</a>
     <a class="btn" href="csv/csv.php?type=' . $type . '"><i class="fa fa-download mr-1"></i> Export CSV</a>
     <a class="btn" href="../activity/index.php?type=' . $type . '"><i class="fa fa-calendar mr-1"></i> Activities</a>'
);
?>

<div class="cb-club-tabs">
    <?php foreach (CLUBS as $t => $c) { ?>
    <a href="club.php?type=<?= $t ?>" class="<?= $t === $type ? 'active' : '' ?>" style="--c:<?= $c['color'] ?>">
        <i class="fa <?= $c['icon'] ?>"></i> <?= e($c['keyword']) ?>
    </a>
    <?php } ?>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card mb-4">
            <div class="cb-hero-club">
                <div class="cb-stat-icon" style="background:<?= $club['color'] ?>"><i class="fa <?= $club['icon'] ?>"></i></div>
                <div>
                    <h3><?= count($members) ?></h3>
                    <div class="cb-muted">member<?= count($members) === 1 ? '' : 's' ?></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-calendar-check-o"></i> Upcoming</h5></div>
            <div class="card-body py-2">
                <?php if (!$upcoming) { ?>
                    <p class="cb-muted small my-2">Nothing scheduled. <a href="../activity/edit.php?type=<?= $type ?>">Add an activity</a>.</p>
                <?php } ?>
                <ul class="cb-list">
                    <?php foreach ($upcoming as $a) { ?>
                    <li>
                        <div class="cb-avatar-sm" style="background:<?= $club['color'] ?>;font-size:.75rem;line-height:1.05;text-align:center"><?= e(date("d\nM", strtotime($a['club_date']))) ?></div>
                        <div><strong><?= e($a['club_content']) ?></strong><small><?= e($a['club_time']) ?> · <?= e($a['club_name']) ?></small></div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-body">
                <form method="post" class="js-bulk-form js-bulk d-none mb-3" data-confirm="Remove the selected students from <?= e($club['name']) ?>? Their student records are kept.">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm"><i class="fa fa-user-times mr-1"></i> Remove <span data-bulk-count>0</span> from club</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover js-datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="no-sort"><input type="checkbox" class="js-check-all" aria-label="Select all"></th>
                                <th>Name</th><th>Student ID</th><th>Email</th><th>Phone</th>
                                <th class="no-sort text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $s) { ?>
                            <tr>
                                <td><input type="checkbox" class="js-check" value="<?= (int)$s['id_user'] ?>" aria-label="Select"></td>
                                <td class="font-weight-bold"><?= e(strtoupper($s['name_user'])) ?></td>
                                <td><?= e(strtoupper($s['studentid_user'])) ?></td>
                                <td><?= e($s['email_user']) ?></td>
                                <td><?= e($s['phone_user']) ?></td>
                                <td class="text-right text-nowrap">
                                    <a href="../edituser.php?id_user=<?= (int)$s['id_user'] ?>" class="btn btn-light-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                    <form method="post" class="d-inline" data-confirm="Remove <?= e($s['name_user']) ?> from <?= e($club['name']) ?>?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$s['id_user'] ?>">
                                        <button class="btn btn-light-danger btn-sm" title="Remove from club"><i class="fa fa-user-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php admin_footer(); ?>
