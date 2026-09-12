<?php
// ===================================================================
// DB.PHP — Database connection gamit ang Laragon (MySQL via PDO)
// -------------------------------------------------------------------
// Ito yung "isang pinto" papuntang database. Lahat ng ibang PHP file
// (login_process.php, api.php ng bawat event, admin dashboard) ay
// dito kukuha ng $pdo connection sa halip na gumawa ng sarili nila.
//
// DEFAULT NA SETTINGS NG LARAGON:
//   Host     : localhost
//   Username : root
//   Password : (walang laman / empty string)
//   Port     : 3306 (default, hindi na kailangan i-type)
//
// Kung may binago kang password sa MySQL ng Laragon mo, palitan lang
// dito sa DB_PASS.
// ===================================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'event_registration_db');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    // DSN = Data Source Name, ito yung "address" ng database
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        // Kapag may error sa query, magthrow ng exception (mas madaling i-debug)
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // I-return ang resulta ng query bilang associative array (['column' => value])
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Kung hindi pa na-import yung sql/database.sql, dito lalabas yung error.
    http_response_code(500);
    die(
        "Hindi maka-connect sa database. Siguraduhin na: <br>" .
        "1. Naka-start ang Apache at MySQL sa Laragon.<br>" .
        "2. Na-import mo na ang sql/database.sql sa phpMyAdmin.<br>" .
        "3. Tama ang DB_NAME/DB_USER/DB_PASS sa config/db.php.<br><br>" .
        "Detalye ng error: " . htmlspecialchars($e->getMessage())
    );
}
