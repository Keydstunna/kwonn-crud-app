-- ===================================================================
-- DATABASE.SQL — I-import ito sa phpMyAdmin ng Laragon
-- -------------------------------------------------------------------
-- PAANO I-IMPORT (Laragon):
--   1. Buksan ang Laragon, i-click ang "Database" button (phpMyAdmin
--      will open), o pumunta sa http://localhost/phpmyadmin
--   2. Gumawa ng bagong database na "event_registration_db"
--      (kung hindi pa awtomatikong nagawa nung tumakbo ang script na ito)
--   3. I-click yung database, tapos "Import" tab, piliin itong file.
-- ===================================================================

CREATE DATABASE IF NOT EXISTS event_registration_db
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE event_registration_db;

-- -------------------------------------------------------------------
-- USERS TABLE — para sa login (auth) at role-based access (admin/user)
-- -------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name     VARCHAR(100) NOT NULL,
    role          ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Demo accounts. Both passwords are hashed versions of the plaintext
-- password shown in the comment next to each row.
-- (Password hashes generated with PHP's password_hash(), bcrypt.)
INSERT INTO users (username, password_hash, full_name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.YeYqBGuIF/Y.g95G.j8v3B4gzHNIz4jTa', 'Barangay Masipit Admin', 'admin'), -- password: admin123
('juan',  '$2y$10$92IXUNpkjO0rOQ5byMi.YeYqBGuIF/Y.g95G.j8v3B4gzHNIz4jTa', 'Juan Dela Cruz',           'user')  -- password: admin123
ON DUPLICATE KEY UPDATE username = username;

-- -------------------------------------------------------------------
-- CLEANUP_REGISTRATIONS — CRUD data for "Clean-Up Drive" event
-- -------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cleanup_registrations (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    full_name      VARCHAR(100) NOT NULL,
    email          VARCHAR(100) NOT NULL,
    contact_number VARCHAR(20)  NOT NULL,
    purok_sitio    VARCHAR(100) NOT NULL,
    bring_gloves   TINYINT(1)   NOT NULL DEFAULT 0,
    notes          VARCHAR(255) DEFAULT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- -------------------------------------------------------------------
-- TREEPLANTING_REGISTRATIONS — CRUD data for "Tree Planting" event
-- -------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS treeplanting_registrations (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    full_name      VARCHAR(100) NOT NULL,
    email          VARCHAR(100) NOT NULL,
    contact_number VARCHAR(20)  NOT NULL,
    purok_sitio    VARCHAR(100) NOT NULL,
    seedlings      INT          NOT NULL DEFAULT 1,
    notes          VARCHAR(255) DEFAULT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample seed rows lang, pwede tanggalin/palitan.
INSERT INTO cleanup_registrations (full_name, email, contact_number, purok_sitio, bring_gloves, notes) VALUES
('Maria Santos', 'maria.santos@example.com', '09171234567', 'Purok 3', 1, 'May dala ring sariling tapon.');

INSERT INTO treeplanting_registrations (full_name, email, contact_number, purok_sitio, seedlings, notes) VALUES
('Pedro Reyes', 'pedro.reyes@example.com', '09181234567', 'Purok 1', 5, 'Gustong mag-donate ng narra seedlings.');
