<?php
require_once __DIR__ . '/../../lib/app.php';
header('Content-Type: application/json');

if (!is_admin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit(json_encode(['message' => 'Failed']));
}
csrf_check();

if (($_POST['action'] ?? '') === 'delete_selected') {
    $ids = array_values(array_filter(array_map('trim', (array)json_decode($_POST['itemArray'] ?? '[]', true))));
    if ($ids) {
        $in = implode(',', array_fill(0, count($ids), '?'));
        q("DELETE FROM user WHERE studentid_user IN ($in)", $ids);
    }
    exit(json_encode(['message' => 'Successful']));
}
echo json_encode(['message' => 'Failed']);
