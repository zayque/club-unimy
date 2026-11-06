<?php
require_once __DIR__ . '/../../includes/core.php';

$type = club_type_or_404($_GET['type'] ?? '');
$out = [];
foreach (members_of($type) as $i => $s) {
    $out[] = [$i + 1, strtoupper($s['name_user']), strtoupper($s['studentid_user']), $s['email_user'], $s['phone_user'], $s['created_at']];
}
send_csv($type . '-members-' . date('Y-m-d') . '.csv', ['No.', 'Name', 'Student ID', 'Email', 'Phone', 'Registered at'], $out);
