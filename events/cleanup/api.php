<?php
// ===================================================================
// EVENTS/CLEANUP/API.PHP — CRUD endpoint (JSON) para sa Clean-Up Drive
// -------------------------------------------------------------------
// Ito ang tinatawag ng React app (app.js sa parehong folder) gamit
// ang fetch(). Naka-guard pa rin ng session check (kahit AJAX call,
// dapat naka-login) — kaya kahit i-hit direkta ang URL na ito, kung
// naka-logout ka na, "unauthorized" JSON lang ang lalabas.
//
// Mga supported na method:
//   GET     -> ibalik lahat ng registrations (JSON array)
//   POST    -> gumawa ng bagong registration     (Create)
//   PUT     -> i-update ang existing (kailangan ?id=)   (Update)
//   DELETE  -> tanggalin ang isa (kailangan ?id=)        (Delete)
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

// -------------------------------------------------------------
// READ (GET) — ito rin ang "JSON file" na kinukuha ng useEffect
// -------------------------------------------------------------
if ($method === 'GET') {
    $rows = $pdo->query('SELECT * FROM cleanup_registrations ORDER BY created_at DESC')->fetchAll();
    echo json_encode($rows);
    exit;
}

// Para sa POST/PUT, JSON body ang pinapadala ng React fetch()
$input = json_decode(file_get_contents('php://input'), true) ?? [];

// -------------------------------------------------------------
// CREATE (POST)
// -------------------------------------------------------------
if ($method === 'POST') {
    $stmt = $pdo->prepare(
        'INSERT INTO cleanup_registrations (full_name, email, contact_number, purok_sitio, bring_gloves, notes)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        trim($input['full_name'] ?? ''),
        trim($input['email'] ?? ''),
        trim($input['contact_number'] ?? ''),
        trim($input['purok_sitio'] ?? ''),
        !empty($input['bring_gloves']) ? 1 : 0,
        trim($input['notes'] ?? ''),
    ]);
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    exit;
}

// -------------------------------------------------------------
// UPDATE (PUT) — ?id=5
// -------------------------------------------------------------
if ($method === 'PUT') {
    $id = (int)($_GET['id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'Kulang ang id.']); exit; }

    $stmt = $pdo->prepare(
        'UPDATE cleanup_registrations
         SET full_name=?, email=?, contact_number=?, purok_sitio=?, bring_gloves=?, notes=?
         WHERE id=?'
    );
    $stmt->execute([
        trim($input['full_name'] ?? ''),
        trim($input['email'] ?? ''),
        trim($input['contact_number'] ?? ''),
        trim($input['purok_sitio'] ?? ''),
        !empty($input['bring_gloves']) ? 1 : 0,
        trim($input['notes'] ?? ''),
        $id,
    ]);
    echo json_encode(['success' => true]);
    exit;
}

// -------------------------------------------------------------
// DELETE — ?id=5
// -------------------------------------------------------------
if ($method === 'DELETE') {
    $id = (int)($_GET['id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'Kulang ang id.']); exit; }

    $stmt = $pdo->prepare('DELETE FROM cleanup_registrations WHERE id=?');
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);
