<?php
// ===================================================================
// LOGOUT.PHP — Winawasak ang session
// -------------------------------------------------------------------
// Pagkatapos nito, kahit i-paste pa ulit ang isang protected link
// (choose-event.php, events/cleanup/, atbp.), babalik agad siya sa
// login page dahil sa middleware.php.
// ===================================================================
require_once __DIR__ . '/config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_destroy();

header('Location: ' . BASE_URL . '/index.php?notice=logged_out');
exit;
