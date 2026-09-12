<?php
// ===================================================================
// MIDDLEWARE.PHP — "Bantay" ng mga protected pages
// -------------------------------------------------------------------
// I-require/include ito sa PINAKAUNANG LINYA ng bawat page na dapat
// naka-login bago makapasok (choose-event.php, events/*/index.php,
// contact.php, admin/dashboard.php).
//
// Paano gumagana:
//   1. Sisimulan (o ipagpapatuloy) ang PHP session.
//   2. Titingnan kung may $_SESSION['user_id'].
//   3. Kung WALA (hindi naka-login, or ka-logout lang, or dinikit
//      lang yung copied link), agad na iri-redirect pabalik sa login
//      page (index.php) — kahit anong URL pa ang direktang pinasok.
//
// Ito yung dahilan kung bakit hindi basta-basta ma-bypass ang
// Event Registration Page kahit i-copy paste ang link nito.
// ===================================================================

require_once __DIR__ . '/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // I-save muna kung saan papunta sana siya, para pagkatapos mag-login
    // maibalik natin agad siya doon (optional na "return to" behavior).
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    header('Location: ' . BASE_URL . '/index.php?notice=login_required');
    exit;
}
