<?php
// ===================================================================
// LOGIN_PROCESS.PHP — Sinusuri ang username/password laban sa DB
// -------------------------------------------------------------------
// Papasukin lang dito galing sa POST form ng index.php. Kung tama,
// gagawa ng session ($_SESSION['user_id'], role, atbp.) at
// ire-redirect papunta sa dati niyang pupuntahan (o choose-event.php
// kung wala namang na-save na "redirect_after_login").
// ===================================================================
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: ' . BASE_URL . '/index.php?notice=invalid');
    exit;
}

$stmt = $pdo->prepare('SELECT id, username, password_hash, full_name, role FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ' . BASE_URL . '/index.php?notice=invalid');
    exit;
}

// Regenerate session id bawat successful login (basic session-fixation hygiene)
session_regenerate_id(true);

$_SESSION['user_id']   = $user['id'];
$_SESSION['username']  = $user['username'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['role']      = $user['role'];

$redirect = $_SESSION['redirect_after_login'] ?? (BASE_URL . '/choose-event.php');
unset($_SESSION['redirect_after_login']);

header('Location: ' . $redirect);
exit;
