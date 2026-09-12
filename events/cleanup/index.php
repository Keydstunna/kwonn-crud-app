<?php
// ===================================================================
// EVENTS/CLEANUP/INDEX.PHP — CRUD page ng "Clean-Up Drive"
// -------------------------------------------------------------------
// Protected (middleware.php). Ito yung PHP "shell" lang — lahat ng
// CRUD logic (useState/useEffect/props) ay nasa app.jsx sa parehong
// folder, gamit ang React (walang build step, CDN + Babel standalone
// lang para tumakbo agad sa Laragon nang hindi kailangan ng npm).
// ===================================================================
require_once __DIR__ . '/../../config/middleware.php';
?>
<!DOCTYPE html>
<html lang="tl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clean-Up Drive — Barangay Masipit</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<style>
    body.theme-estuary { --accent-deep:#0E4C46; --accent-mid:#2E8C7D; --accent-light:#8FE3D3; --accent-warm:#E8DCC6; }
    .event-hero {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        background:
            linear-gradient(155deg, rgba(14,76,70,0.9), rgba(46,140,125,0.75)),
            url('<?= BASE_URL ?>/assets/images/cleanup-bg.jpg') center/cover no-repeat;
        color: var(--paper);
    }
    .event-hero h1 { color: var(--paper); font-size: 2.1rem; }
    .event-hero p { color: rgba(251,253,251,0.9); max-width: 52ch; }

    .crud-layout { display: grid; grid-template-columns: 340px 1fr; gap: 1.75rem; align-items: start; }
    @media (max-width: 860px) { .crud-layout { grid-template-columns: 1fr; } }

    .reg-list { display: flex; flex-direction: column; gap: 0.9rem; }
    .reg-item {
        display: flex; justify-content: space-between; gap: 1rem;
        padding: 1rem 1.15rem; border-radius: var(--radius-sm);
        border: 1px solid var(--line); background: var(--paper);
    }
    .reg-item h3 { margin: 0 0 0.15em; font-size: 1rem; color: var(--ink); font-family: var(--font-body); font-weight: 700; }
    .reg-item p { margin: 0; font-size: 0.85rem; color: var(--ink-soft); }
    .reg-item .pill {
        display:inline-block; font-size:0.72rem; font-weight:600;
        background: var(--accent-warm); color: var(--accent-deep);
        padding: 0.15em 0.6em; border-radius: 999px; margin-top:0.35em;
    }
    .reg-actions { display:flex; flex-direction: column; gap:0.4rem; flex-shrink:0; }
    .reg-actions button {
        font-size: 0.78rem; padding: 0.4em 0.8em; border-radius: 8px; border:none; cursor:pointer;
    }
    .empty-state { text-align:center; color: var(--ink-soft); padding: 2rem 1rem; border: 1.5px dashed var(--line); border-radius: var(--radius-sm); }
</style>
</head>
<body class="theme-estuary">
    <?php include __DIR__ . '/../../partials/topnav.php'; ?>

    <div class="page-shell">
        <section class="event-hero">
            <span class="pill" style="background:rgba(255,255,255,0.18); color:#fff;">Barangay Masipit Clean-Up Drive</span>
            <h1>Linisin natin ang ilog at kalsada ng ating barangay 🌊</h1>
            <p>I-rehistro ang sarili o mag-manage ng listahan ng mga kalahok sa ibaba. Real-time itong naka-connect sa MySQL database gamit ang PHP API.</p>
        </section>

        <!-- Dito mounted ang buong React app (Parent: App, Children: RegistrationForm at RegistrationList) -->
        <div id="cleanup-root"></div>
    </div>

    <!-- React 18 + Babel standalone via CDN — walang build step -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script type="text/babel" data-type="module" src="app.jsx"></script>
</body>
</html>
