<?php
// ===================================================================
// EVENTS/TREEPLANTING/API.PHP — CRUD endpoint (JSON) para sa Tree Planting
// -------------------------------------------------------------------
// Kaparehong istruktura ng events/cleanup/api.php pero ibang table
// (treeplanting_registrations) at may "seedlings" field sa halip na
// "bring_gloves".
// ===================================================================
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Kailangan mag-login muna.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = $pdo->query('SELECT * FROM treeplanting_registrations ORDER BY created_at DESC')->fetchAll();
    echo json_encode($rows);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? [];

if ($method === 'POST') {
    $stmt = $pdo->prepare(
        'INSERT INTO treeplanting_registrations (full_name, email, contact_number, purok_sitio, seedlings, notes)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        trim($input['full_name'] ?? ''),
        trim($input['email'] ?? ''),
        trim($input['contact_number'] ?? ''),
        trim($input['purok_sitio'] ?? ''),
        max(1, (int)($input['seedlings'] ?? 1)),
        trim($input['notes'] ?? ''),
    ]);
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    exit;
}

if ($method === 'PUT') {
    $id = (int)($_GET['id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'Kulang ang id.']); exit; }

    $stmt = $pdo->prepare(
        'UPDATE treeplanting_registrations
         SET full_name=?, email=?, contact_number=?, purok_sitio=?, seedlings=?, notes=?
         WHERE id=?'
    );
    $stmt->execute([
        trim($input['full_name'] ?? ''),
        trim($input['email'] ?? ''),
        trim($input['contact_number'] ?? ''),
        trim($input['purok_sitio'] ?? ''),
        max(1, (int)($input['seedlings'] ?? 1)),
        trim($input['notes'] ?? ''),
        $id,
    ]);
    echo json_encode(['success' => true]);
    exit;
}

if ($method === 'DELETE') {
    $id = (int)($_GET['id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'Kulang ang id.']); exit; }

    $stmt = $pdo->prepare('DELETE FROM treeplanting_registrations WHERE id=?');
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);
