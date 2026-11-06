<?php
// Kept for compatibility: older code included this to get the logged-in student.
require_once __DIR__ . '/lib.php';
$student = require_student();
$studentid_session = $student['studentid_user'];
$username_session  = $student['name_user'];
$email_session     = $student['email_user'];
$contact_session   = $student['phone_user'];
$club_session      = $student['club_user'];
