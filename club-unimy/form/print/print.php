<?php
require_once __DIR__ . '/../../includes/core.php';

$type = club_type_or_404($_GET['type'] ?? '');
$club = CLUBS[$type];
$members = members_of($type);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= e($club['name']) ?> – member list</title>
    <link rel="icon" type="image/svg+xml" href="../../img/logo.svg" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap");
        body { font-family: "Plus Jakarta Sans", Arial, sans-serif; color: #0f172a; margin: 40px; }
        header { display: flex; align-items: center; gap: 14px; border-bottom: 3px solid <?= $club['color'] ?>; padding-bottom: 14px; margin-bottom: 20px; }
        header img { width: 44px; }
        h1 { margin: 0; font-size: 22px; }
        header p { margin: 2px 0 0; color: #64748b; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; background: #f1f5f9; padding: 8px 10px; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: #475569; }
        td { padding: 8px 10px; border-bottom: 1px solid #e2e8f0; }
        tr:nth-child(even) td { background: #fafbfc; }
        footer { margin-top: 24px; font-size: 12px; color: #64748b; display: flex; justify-content: space-between; }
        .actions { margin-bottom: 20px; }
        .actions button { font: inherit; font-weight: 600; background: <?= $club['color'] ?>; color: #fff; border: 0; padding: 8px 16px; border-radius: 8px; cursor: pointer; }
        @media print { .actions { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="actions"><button onclick="window.print()">Print this list</button></div>
    <header>
        <img src="../../img/logo.svg" alt="">
        <div>
            <h1>List of students – <?= e($club['name']) ?></h1>
            <p><?= count($members) ?> member(s) · printed <?= date('d M Y, g:i a') ?></p>
        </div>
    </header>
    <table>
        <thead><tr><th>No.</th><th>Name</th><th>Student ID</th><th>Email</th><th>Phone</th></tr></thead>
        <tbody>
            <?php foreach ($members as $i => $s) { ?>
            <tr><td><?= $i + 1 ?></td><td><?= e(strtoupper($s['name_user'])) ?></td><td><?= e(strtoupper($s['studentid_user'])) ?></td><td><?= e($s['email_user']) ?></td><td><?= e($s['phone_user']) ?></td></tr>
            <?php } ?>
            <?php if (!$members) { ?><tr><td colspan="5" style="text-align:center;color:#64748b">No members yet.</td></tr><?php } ?>
        </tbody>
    </table>
    <footer><span>ClubHub · Club Registration System</span><span>Signature: ______________________</span></footer>
</body>
</html>
