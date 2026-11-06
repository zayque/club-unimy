<?php
require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/lib/layout.php';

$total = total_students();
$settings = registration_settings();
$pct = $settings['limit'] > 0 ? min(100, round($total / $settings['limit'] * 100)) : 0;

$counts = [];
foreach (CLUBS as $type => $c) {
    $counts[$type] = member_count($type);
}
arsort($counts);
$topType = key($counts);

$activities = (int)row("SELECT COUNT(*) n FROM club_activity")['n'];
$upcoming = rows("SELECT * FROM club_activity WHERE club_date >= CURDATE() ORDER BY club_date ASC LIMIT 5");
$recent = rows("SELECT * FROM user ORDER BY created_at DESC, id_user DESC LIMIT 6");
$today = (int)row("SELECT COUNT(*) n FROM user WHERE DATE(created_at) = CURDATE()")['n'];

admin_header(
    'Dashboard',
    'Hello ' . ($_SESSION['u_first'] ?? 'Admin') . ' — here is how registrations are going.',
    'dashboard',
    '<a class="btn" href="students.php?export=csv"><i class="fa fa-download mr-1"></i> Export all</a>
     <a class="btn" href="club-form.php" target="_blank" rel="noopener"><i class="fa fa-external-link mr-1"></i> Registration form</a>'
);
?>

<div class="cb-stats">
    <div class="cb-stat">
        <div class="cb-stat-icon" style="background:var(--cb-gradient)"><i class="fa fa-users"></i></div>
        <div><div class="cb-stat-value"><?= $total ?></div><div class="cb-stat-label">Registered students</div></div>
    </div>
    <div class="cb-stat">
        <div class="cb-stat-icon" style="background:#10b981"><i class="fa fa-user-plus"></i></div>
        <div><div class="cb-stat-value"><?= $today ?></div><div class="cb-stat-label">Joined today</div></div>
    </div>
    <div class="cb-stat">
        <div class="cb-stat-icon" style="background:#f59e0b"><i class="fa fa-calendar"></i></div>
        <div><div class="cb-stat-value"><?= $activities ?></div><div class="cb-stat-label">Club activities</div></div>
    </div>
    <div class="cb-stat">
        <div class="cb-stat-icon" style="background:<?= CLUBS[$topType]['color'] ?>"><i class="fa fa-trophy"></i></div>
        <div><div class="cb-stat-value" style="font-size:1.05rem;line-height:1.3"><?= e(CLUBS[$topType]['name']) ?></div><div class="cb-stat-label">Most popular club</div></div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="cb-panel-title"><i class="fa fa-bar-chart"></i> Members per club</h5>
                <a href="form/club.php" class="small font-weight-bold">View clubs →</a>
            </div>
            <div class="card-body">
                <canvas id="clubChart" height="130"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="cb-panel-title"><i class="fa fa-tachometer"></i> Registration capacity</h5></div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div><span class="cb-stat-value"><?= $total ?></span> <span class="cb-muted">/ <?= $settings['limit'] ?> places</span></div>
                    <strong><?= $pct ?>%</strong>
                </div>
                <div class="cb-progress<?= $pct >= 90 ? ' warn' : '' ?>"><span style="width:<?= $pct ?>%"></span></div>
                <p class="small cb-muted mt-2 mb-0">
                    <?= $total >= $settings['limit'] ? 'Registration is closed — the limit has been reached.' : ($settings['limit'] - $total) . ' places left.' ?>
                    <a href="forminfo.php">Change limit</a>
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="cb-panel-title"><i class="fa fa-clock-o"></i> Recent registrations</h5>
                <a href="students.php" class="small font-weight-bold">All →</a>
            </div>
            <div class="card-body py-2">
                <?php if (!$recent) { ?>
                    <div class="cb-empty-state py-3"><i class="fa fa-inbox"></i>No registrations yet.</div>
                <?php } ?>
                <ul class="cb-list">
                    <?php foreach ($recent as $s) { ?>
                    <li>
                        <div class="cb-avatar-sm"><?= e(strtoupper(substr($s['name_user'], 0, 1))) ?></div>
                        <div class="flex-grow-1" style="min-width:0">
                            <strong class="text-truncate"><?= e($s['name_user']) ?></strong>
                            <small><?= e(strtoupper($s['studentid_user'])) ?> · <?= count(club_list($s['club_user'])) ?> club(s)</small>
                        </div>
                        <small><?= e(date('d M', strtotime($s['created_at']))) ?></small>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="cb-panel-title"><i class="fa fa-calendar-check-o"></i> Upcoming activities</h5>
        <a href="activity/index.php" class="small font-weight-bold">Manage activities →</a>
    </div>
    <div class="card-body">
        <?php if (!$upcoming) { ?>
            <div class="cb-empty-state py-3"><i class="fa fa-calendar-o"></i>No upcoming activities. <a href="activity/edit.php">Add one</a>.</div>
        <?php } else { ?>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Date</th><th>Club</th><th>Activity</th><th>Time</th><th>Contact</th></tr></thead>
                <tbody>
                <?php foreach ($upcoming as $a) { $c = CLUBS[$a['club_type']] ?? null; ?>
                    <tr>
                        <td class="font-weight-bold"><?= e(date('d M Y', strtotime($a['club_date']))) ?></td>
                        <td><?php if ($c) { ?><span class="cb-pill" style="background:<?= $c['color'] ?>1a;color:<?= $c['color'] ?>"><i class="fa <?= $c['icon'] ?>"></i><?= e($c['name']) ?></span><?php } ?></td>
                        <td><?= e($a['club_content']) ?></td>
                        <td><?= e($a['club_time']) ?></td>
                        <td><?= e($a['club_name']) ?>, <?= e($a['club_contact']) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>

<?php
$labels = []; $data = []; $colors = [];
foreach (CLUBS as $type => $c) { $labels[] = $c['keyword']; $data[] = member_count($type); $colors[] = $c['color']; }
admin_footer('
<script src="vendor/chart.js/Chart.min.js"></script>
<script>
Chart.defaults.global.defaultFontFamily = "\'Plus Jakarta Sans\', system-ui, sans-serif";
new Chart(document.getElementById("clubChart"), {
    type: "horizontalBar",
    data: { labels: ' . json_encode($labels) . ', datasets: [{ data: ' . json_encode($data) . ', backgroundColor: ' . json_encode($colors) . ', borderWidth: 0 }] },
    options: {
        legend: { display: false },
        scales: {
            xAxes: [{ ticks: { beginAtZero: true, precision: 0, stepSize: 1, fontColor: "#64748b" }, gridLines: { color: "#eef2f7", zeroLineColor: "#e2e8f0" } }],
            yAxes: [{ barPercentage: .7, ticks: { fontColor: "#0f172a" }, gridLines: { display: false } }]
        },
        tooltips: { callbacks: { label: function (i) { return " " + i.xLabel + " member(s)"; } } }
    }
});
</script>');
