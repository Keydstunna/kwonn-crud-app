<?php
// ===================================================================
// ADMIN_MIDDLEWARE.PHP — Extra layer, pang-admin pages lang
// -------------------------------------------------------------------
// I-include ito PAGKATAPOS ng config/middleware.php (kailangan naka-
// login muna, saka tsina-check kung "admin" ba ang role niya).
// Ginagamit sa admin/dashboard.php.
// ===================================================================

require_once __DIR__ . '/middleware.php'; // dapat naka-login muna

if (($_SESSION['role'] ?? 'user') !== 'admin') {
    http_response_code(403);
    die('
        <div style="font-family:sans-serif; text-align:center; margin-top:80px;">
            <h2>🚫 Bawal dito</h2>
            <p>Admin account lang ang pwedeng mag-view ng dashboard na ito.</p>
            <a href="' . BASE_URL . '/choose-event.php">← Bumalik</a>
        </div>
    ');
}
