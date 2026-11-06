<?php
/**
 * Download a club activity as an .ics calendar file (Google Calendar, Outlook, Apple Calendar).
 */
require_once __DIR__ . '/lib.php';
require_student();

$a = row("SELECT * FROM club_activity WHERE club_id = ?", [(int)($_GET['id'] ?? 0)]);
if (!$a || !strtotime($a['club_date'])) {
    http_response_code(404);
    exit('Activity not found.');
}
$club = CLUBS[$a['club_type']]['name'] ?? 'Club';

// Try to read a start time like "3.00 pm" or "10:41 pm"; fall back to an all-day event.
$start = null;
if (preg_match('/(\d{1,2})[.:](\d{2})\s*(am|pm)?/i', $a['club_time'], $m)) {
    $h = (int)$m[1] % 12 + (strtolower($m[3] ?? '') === 'pm' ? 12 : 0);
    if (empty($m[3]) && (int)$m[1] === 12) $h = 12;
    $start = strtotime($a['club_date'] . sprintf(' %02d:%02d:00', $h, (int)$m[2]));
}

function ics_escape(string $s): string
{
    return str_replace(["\r\n", "\n"], '\\n', addcslashes($s, ',;\\'));
}

$lines = [
    'BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//ClubHub//Club Activities//EN', 'CALSCALE:GREGORIAN',
    'BEGIN:VEVENT',
    'UID:clubhub-activity-' . $a['club_id'] . '@clubhub',
    'DTSTAMP:' . gmdate('Ymd\THis\Z'),
];
if ($start) {
    $lines[] = 'DTSTART;TZID=Asia/Kuala_Lumpur:' . date('Ymd\THis', $start);
    $lines[] = 'DTEND;TZID=Asia/Kuala_Lumpur:' . date('Ymd\THis', $start + 2 * 3600);
} else {
    $lines[] = 'DTSTART;VALUE=DATE:' . date('Ymd', strtotime($a['club_date']));
}
$lines[] = 'SUMMARY:' . ics_escape($club . ': ' . $a['club_content']);
$lines[] = 'DESCRIPTION:' . ics_escape($a['club_content_2'] . "\nContact: " . $a['club_name'] . ' ' . $a['club_contact'] . "\nTime: " . $a['club_time']);
$lines[] = 'END:VEVENT';
$lines[] = 'END:VCALENDAR';

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="' . preg_replace('/[^a-z0-9]+/i', '-', $a['club_content']) . '.ics"');
echo implode("\r\n", $lines) . "\r\n";
