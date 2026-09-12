<?php
// ===================================================================
// CHOOSE-EVENT.PHP — Protected page, dito pumipili ng event
// -------------------------------------------------------------------
// Sunod ito sa login. Naka-guard ng middleware.php kaya hindi ito
// ma-a-access kung hindi naka-login. Dalawang malaking card lang:
// Clean-Up Drive at Tree Planting, bawat isa may sariling accent color
// (ginagamit dito ang parehong theme classes na ginagamit sa event
// pages mismo, para consistent yung "preview" ng kulay).
// ===================================================================
require_once __DIR__ . '/config/middleware.php';
?>
<!DOCTYPE html>
<html lang="tl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pumili ng Event — Barangay Masipit</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<style>
    .choose-hero {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 2.5rem;
    }
    .event-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.75rem;
    }
    .event-card {
        position: relative;
        display: block;
        text-decoration: none;
        border-radius: var(--radius-lg);
        padding: 2.5rem 2rem;
        color: var(--paper);
        min-height: 320px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }
    .event-card::before {
        content: "";
        position: absolute; inset: 0;
        background: linear-gradient(165deg, var(--accent-deep), var(--accent-mid) 65%, var(--accent-light));
        z-index: 0;
    }
    .event-card > * { position: relative; z-index: 1; }
    .event-card svg { width: 54px; height: 54px; margin-bottom: 1rem; }
    .event-card h2 { color: var(--paper); font-size: 1.6rem; }
    .event-card p { color: rgba(251,253,251,0.88); font-size: 0.92rem; }
    .event-card .tag {
        align-self: flex-start;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        background: rgba(251,253,251,0.18);
        padding: 0.3em 0.8em;
        border-radius: 999px;
        margin-bottom: 1rem;
    }
    @media (max-width: 720px) {
        .event-grid { grid-template-columns: 1fr; }
    }
</style>
</head>
<body>
    <?php include __DIR__ . '/partials/topnav.php'; ?>

    <div class="page-shell">
        <div class="choose-hero">
            <h1>Kumusta, <?= htmlspecialchars($_SESSION['full_name']) ?> 🌿</h1>
            <p style="margin: 0 auto;">Pumili kung saang environmental activity ka magpaparehistro. Ang bawat isa ay may sariling registration form at listahan ng mga rehistrado.</p>
        </div>

        <div class="event-grid">
            <a href="<?= BASE_URL ?>/events/cleanup/index.php" class="event-card tilt-card" style="--accent-deep:#0E4C46; --accent-mid:#2E8C7D; --accent-light:#8FE3D3;">
                <span class="tag">Ilog &amp; Baybayin</span>
                <svg viewBox="0 0 48 48" fill="none"><path d="M4 34c6-4 10-4 16 0s10 4 16 0 8-4 8-4M4 24c6-4 10-4 16 0s10 4 16 0 8-4 8-4" stroke="#fff" stroke-width="3" stroke-linecap="round"/></svg>
                <h2>Clean-Up Drive</h2>
                <p>Barangay Masipit Clean-Up Drive — magtulong sa paglilinis ng ilog at kalsada.</p>
            </a>

            <a href="<?= BASE_URL ?>/events/treeplanting/index.php" class="event-card tilt-card" style="--accent-deep:#33512B; --accent-mid:#6B8E4E; --accent-light:#C9A64C;">
                <span class="tag">Gubat &amp; Kabundukan</span>
                <svg viewBox="0 0 48 48" fill="none"><path d="M24 4l9 16H15l9-16zM24 14l11 18H13l11-18z" fill="#fff"/><rect x="21" y="30" width="6" height="14" fill="#fff"/></svg>
                <h2>Tree Planting</h2>
                <p>Barangay Masipit Tree Planting — magtanim ng puno para sa susunod na henerasyon.</p>
            </a>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/assets/js/effects.js"></script>
    <script>initTiltCards('.tilt-card');</script>
</body>
</html>
