<?php
/**
 * Student self-service: update phone number and club membership.
 */
require_once __DIR__ . '/lib.php';
$student = require_student();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}
csrf_check();

switch ($_POST['action'] ?? '') {
    case 'phone':
        $phone = preg_replace('/[^0-9+]/', '', $_POST['phone'] ?? '');
        if (strlen($phone) < 9 || strlen($phone) > 13) {
            flash('Enter a phone number with 9–12 digits.', 'error');
        } else {
            q("UPDATE user SET phone_user = ? WHERE id_user = ?", [$phone, $student['id_user']]);
            flash('Phone number updated.');
        }
        redirect('index.php#profile');

    case 'clubs':
        $clubs = clubs_to_store((array)($_POST['clubs'] ?? []));
        if ($clubs === '') {
            flash('Keep at least one club. Ask an admin if you want to leave every club.', 'error');
        } else {
            $before = club_list($student['club_user']);
            $after = club_list($clubs);
            q("UPDATE user SET club_user = ? WHERE id_user = ?", [$clubs, $student['id_user']]);
            $joined = array_diff($after, $before);
            $left = array_diff($before, $after);
            $parts = [];
            if ($joined) $parts[] = 'joined ' . implode(', ', $joined);
            if ($left) $parts[] = 'left ' . implode(', ', $left);
            flash($parts ? 'You ' . implode(' and ', $parts) . '.' : 'No changes to your clubs.');
        }
        redirect('index.php#profile');
}

redirect('index.php');
