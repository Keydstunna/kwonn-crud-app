<?php
// ===================================================================
// PARTIALS/TOPNAV.PHP — Shared nav bar
// -------------------------------------------------------------------
// I-include lang ito (hindi kailangan i-require_once) sa loob ng
// <body> ng bawat protected page. Umaasa ito na naka-set na ang
// $_SESSION at BASE_URL bago siya i-include (nangyayari yun dahil
// dumaan na ang page sa config/middleware.php).
// ===================================================================
?>
<header class="topnav">
    <a href="<?= BASE_URL ?>/choose-event.php" class="brand">🌿 Barangay Masipit</a>
    <nav>
        <a href="<?= BASE_URL ?>/choose-event.php">Mga Event</a>
        <a href="<?= BASE_URL ?>/contact.php">Contact</a>
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
            <a href="<?= BASE_URL ?>/admin/dashboard.php">Admin Dashboard</a>
        <?php endif; ?>
        <span style="color:var(--ink-soft); font-size:0.85rem;">Hi, <?= htmlspecialchars($_SESSION['full_name'] ?? '') ?></span>
        <a href="<?= BASE_URL ?>/logout.php" class="btn btn-ghost" style="padding:0.4em 1em;">Logout</a>
    </nav>
</header>
