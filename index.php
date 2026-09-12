<?php
// ===================================================================
// INDEX.PHP — ENTRY POINT ng buong system (Login Page)
// -------------------------------------------------------------------
// Ito ang UNANG PAGE na dapat makita ng sinuman, kahit i-type niya
// diretso sa address bar ang link ng choose-event.php o ng event
// pages — kasi may middleware.php na naka-guard doon na magbabalik
// sa kanya dito kapag wala pa siyang session.
// ===================================================================
require_once __DIR__ . '/config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kung naka-login na pala siya, wag nang ipakita ulit ang login form —
// diretso na sa choose-event.php.
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/choose-event.php');
    exit;
}

$notice = $_GET['notice'] ?? null;
?>
<!DOCTYPE html>
<html lang="tl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mag-login — Barangay Masipit Environmental Program</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<style>
    body.login-body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(160deg, rgba(14,76,70,0.92), rgba(46,140,125,0.85)),
            url('<?= BASE_URL ?>/assets/images/login-bg.jpg') center/cover no-repeat,
            linear-gradient(160deg, var(--accent-deep), var(--accent-mid));
        padding: 1.5rem;
    }
    .login-card {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 400px;
        background: var(--paper);
        border-radius: var(--radius-lg);
        padding: 2.25rem 2rem;
        box-shadow: 0 24px 60px rgba(0,0,0,0.28);
    }
    .login-eyebrow-icon {
        width: 46px; height: 46px; margin-bottom: 1rem;
    }
    .login-card p.sub { color: var(--ink-soft); font-size: 0.92rem; margin-top: -0.3em; }
    .demo-hint {
        margin-top: 1.25rem;
        font-size: 0.8rem;
        color: var(--ink-soft);
        border-top: 1px dashed var(--line);
        padding-top: 0.85rem;
    }
</style>
</head>
<body class="login-body">
    <canvas id="leafBg" class="leaf-canvas"></canvas>

    <div class="login-card">
        <svg class="login-eyebrow-icon" viewBox="0 0 48 48" fill="none">
            <path d="M24 4C15 10 9 19 9 27a15 15 0 0030 0c0-8-6-17-15-23z" fill="#2E8C7D"/>
            <path d="M24 44V20" stroke="#0E4C46" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <h1>Barangay Masipit</h1>
        <p class="sub">Environmental Program — mag-login para magpatuloy sa Event Registration.</p>

        <?php if ($notice === 'login_required'): ?>
            <div class="notice warn">Kailangan mo munang mag-login bago ma-access ang page na iyon.</div>
        <?php elseif ($notice === 'logged_out'): ?>
            <div class="notice ok">Na-logout ka na. Mag-login ulit para magpatuloy.</div>
        <?php elseif ($notice === 'invalid'): ?>
            <div class="notice error">Mali ang username o password. Subukan ulit.</div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/login_process.php" method="POST" id="loginForm">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Mag-login
            </button>
        </form>

        <p class="demo-hint">
            Demo accounts — <strong>admin</strong> / admin123 (may access sa Admin Dashboard),
            <strong>juan</strong> / admin123 (regular user).
        </p>
    </div>

    <script src="<?= BASE_URL ?>/assets/js/effects.js"></script>
    <script>
        leafCanvas('leafBg', { count: 22, color: 'rgba(255,255,255,0.5)' });

        document.getElementById('loginForm').addEventListener('submit', function (e) {
            if (!validateForm(this)) e.preventDefault();
        });
    </script>
</body>
</html>
