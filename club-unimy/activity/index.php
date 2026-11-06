<?php
require_once __DIR__ . '/../includes/core.php';
require_once __DIR__ . '/../lib/layout.php';

$type = $_GET['type'] ?? '';
if ($type !== '' && !isset(CLUBS[$type])) {
    $type = '';
}
$when = $_GET['when'] ?? 'all';

// ----- delete -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    csrf_check();
    $a = row("SELECT * FROM club_activity WHERE club_id = ?", [(int)$_POST['id']]);
    if ($a) {
        q("DELETE FROM club_activity WHERE club_id = ?", [(int)$a['club_id']]);
        delete_upload($a['club_image']);
        flash('Activity "' . $a['club_content'] . '" deleted.');
    }
    redirect('index.php' . ($type ? '?type=' . $type : ''));
}

$where = [];
$params = [];
if ($type) { $where[] = 'club_type = ?'; $params[] = $type; }
if ($when === 'upcoming') $where[] = 'club_date >= CURDATE()';
if ($when === 'past') $where[] = 'club_date < CURDATE()';
$sql = 'SELECT * FROM club_activity' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY club_date DESC, club_id DESC';
$activities = rows($sql, $params);

$base = 'index.php?' . ($type ? 'type=' . $type . '&' : '');
admin_header(
    $type ? CLUBS[$type]['name'] . ' activities' : 'Activities',
    'Meetings and events students see on their portal.',
    'activity',
    '<a class="btn" href="edit.php' . ($type ? '?type=' . $type : '') . '"><i class="fa fa-plus mr-1"></i> New activity</a>'
);
?>

<div class="cb-club-tabs">
    <a href="index.php<?= $when !== 'all' ? '?when=' . e($when) : '' ?>" class="<?= $type === '' ? 'active' : '' ?>"><i class="fa fa-th"></i> All clubs</a>
    <?php foreach (CLUBS as $t => $c) { ?>
    <a href="index.php?type=<?= $t ?>&when=<?= e($when) ?>" class="<?= $t === $type ? 'active' : '' ?>" style="--c:<?= $c['color'] ?>">
        <i class="fa <?= $c['icon'] ?>"></i> <?= e($c['keyword']) ?>
    </a>
    <?php } ?>
</div>

<div class="btn-group mb-4" role="group" aria-label="Filter by date">
    <?php foreach (['all' => 'All', 'upcoming' => 'Upcoming', 'past' => 'Past'] as $k => $label) { ?>
    <a href="<?= $base ?>when=<?= $k ?>" class="btn btn-sm <?= $when === $k ? 'btn-primary' : 'btn-secondary' ?>"><?= $label ?></a>
    <?php } ?>
</div>

<?php if (!$activities) { ?>
<div class="card"><div class="cb-empty-state"><i class="fa fa-calendar-o"></i>No activities here yet.<br>
    <a href="edit.php<?= $type ? '?type=' . $type : '' ?>" class="btn btn-primary mt-3"><i class="fa fa-plus mr-1"></i> Add the first one</a></div></div>
<?php } ?>

<div class="cb-act-grid mb-4">
    <?php foreach ($activities as $a) {
        $c = CLUBS[$a['club_type']] ?? ['name' => $a['club_type'], 'color' => '#64748b', 'icon' => 'fa-calendar'];
        $ts = strtotime($a['club_date']);
        $upcoming = $ts && $ts >= strtotime('today'); ?>
    <div class="cb-act">
        <div class="cb-act-top" style="background:linear-gradient(135deg, <?= $c['color'] ?>, #0f172a)">
            <i class="fa <?= $c['icon'] ?>"></i>
            <?php if ($a['club_image']) { ?><img src="<?= e($a['club_image']) ?>" alt="" onerror="this.remove()"><?php } ?>
            <?php if ($ts) { ?><span class="cb-act-date"><?= date('d M Y', $ts) ?></span><?php } ?>
            <span class="cb-act-status<?= $upcoming ? ' upcoming' : '' ?>"><?= $upcoming ? 'Upcoming' : 'Past' ?></span>
        </div>
        <div class="cb-act-body">
            <span class="cb-pill" style="background:<?= $c['color'] ?>1a;color:<?= $c['color'] ?>;align-self:flex-start"><?= e($c['name']) ?></span>
            <h5><?= e($a['club_content']) ?></h5>
            <p><?= e($a['club_content_2']) ?></p>
            <div class="cb-act-meta">
                <span><i class="fa fa-clock-o"></i><?= e($a['club_time']) ?></span>
                <span><i class="fa fa-user-o"></i><?= e($a['club_name']) ?></span>
                <span><i class="fa fa-phone"></i><?= e($a['club_contact']) ?></span>
            </div>
        </div>
        <div class="cb-act-actions">
            <a href="edit.php?id=<?= (int)$a['club_id'] ?>" class="btn btn-light-primary"><i class="fa fa-pencil mr-1"></i> Edit</a>
            <form method="post" data-confirm="Delete &quot;<?= e($a['club_content']) ?>&quot;? Students will no longer see it.">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$a['club_id'] ?>">
                <button class="btn btn-light-danger"><i class="fa fa-trash"></i></button>
            </form>
        </div>
    </div>
    <?php } ?>
</div>

<?php admin_footer(); ?>
