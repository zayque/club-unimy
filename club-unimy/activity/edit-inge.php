<?php
$id = (int)($_GET['club_id'] ?? 0);
header('Location: ' . ($id ? 'edit.php?id=' . $id : 'edit.php?type=inge'));
exit;
