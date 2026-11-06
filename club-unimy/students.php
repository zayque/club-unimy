<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';

$club = $_GET['club'] ?? '';
if ($club !== '' && !isset(CLUBS[$club])) {
    $club = '';
}

// ----- actions -----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    $ids = array_filter(array_map('intval', (array)($_POST['ids'] ?? [$_POST['id'] ?? 0])));

    if ($action === 'delete' && $ids) {
        $in = implode(',', array_fill(0, count($ids), '?'));
        q("DELETE FROM user WHERE id_user IN ($in)", $ids);
        flash(count($ids) === 1 ? 'Student deleted.' : count($ids) . ' students deleted.');
    }
    redirect('students.php' . ($club ? '?club=' . $club : ''));
}

$students = $club ? members_of($club) : rows("SELECT * FROM user ORDER BY created_at DESC, id_user DESC");

// ----- CSV export -----
if (($_GET['export'] ?? '') === 'csv') {
    $out = [];
    foreach ($students as $i => $s) {
        $out[] = [$i + 1, strtoupper($s['name_user']), strtoupper($s['studentid_user']), $s['email_user'], $s['phone_user'], implode(', ', club_list($s['club_user'])), $s['created_at']];
    }
    send_csv(($club ? $club : 'all') . '-students-' . date('Y-m-d') . '.csv',
        ['No.', 'Name', 'Student ID', 'Email', 'Phone', 'Clubs', 'Registered at'], $out);
}

$qs = $club ? '&club=' . $club : '';
admin_header(
    $club ? CLUBS[$club]['name'] . ' students' : 'Students',
    count($students) . ' student(s)' . ($club ? ' in this club.' : ' registered in total.'),
    'students',
    '<a class="btn" href="students.php?export=csv' . $qs . '"><i class="fa fa-download mr-1"></i> Export CSV</a>
     <a class="btn" href="edituser.php"><i class="fa fa-plus mr-1"></i> Add student</a>'
);
?>

<div class="cb-club-tabs">
    <a href="students.php" class="<?= $club === '' ? 'active' : '' ?>"><i class="fa fa-users"></i> All <span class="cb-count"><?= total_students() ?></span></a>
    <?php foreach (CLUBS as $type => $c) { ?>
    <a href="students.php?club=<?= $type ?>" class="<?= $club === $type ? 'active' : '' ?>" style="--c:<?= $c['color'] ?>">
        <i class="fa <?= $c['icon'] ?>"></i> <?= e($c['keyword']) ?> <span class="cb-count"><?= member_count($type) ?></span>
    </a>
    <?php } ?>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="post" class="js-bulk-form js-bulk d-none mb-3" data-confirm="Delete the selected students? This can't be undone.">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="delete">
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash mr-1"></i> Delete <span data-bulk-count>0</span> selected</button>
        </form>

        <div class="table-responsive">
            <table class="table table-hover js-datatable" style="width:100%">
                <thead>
                    <tr>
                        <th class="no-sort"><input type="checkbox" class="js-check-all" aria-label="Select all"></th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Clubs</th>
                        <th>Registered</th>
                        <th class="no-sort text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s) { ?>
                    <tr>
                        <td><input type="checkbox" class="js-check" value="<?= (int)$s['id_user'] ?>" aria-label="Select"></td>
                        <td class="font-weight-bold"><?= e(strtoupper($s['name_user'])) ?></td>
                        <td><?= e(strtoupper($s['studentid_user'])) ?></td>
                        <td><?= e($s['email_user']) ?></td>
                        <td><?= e($s['phone_user']) ?></td>
                        <td>
                            <?php foreach (club_list($s['club_user']) as $k) { $c = club_by_keyword($k); ?>
                                <span class="cb-pill" style="background:<?= $c ? $c['color'] : '#64748b' ?>1a;color:<?= $c ? $c['color'] : '#64748b' ?>"><?= e($k) ?></span>
                            <?php } ?>
                        </td>
                        <td data-order="<?= e($s['created_at']) ?>" class="text-nowrap"><?= e(date('d M Y', strtotime($s['created_at']))) ?></td>
                        <td class="text-right text-nowrap">
                            <a href="edituser.php?id_user=<?= (int)$s['id_user'] ?>" class="btn btn-light-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                            <form method="post" class="d-inline" data-confirm="Delete <?= e($s['name_user']) ?>? This can't be undone.">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$s['id_user'] ?>">
                                <button class="btn btn-light-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php admin_footer(); ?>
