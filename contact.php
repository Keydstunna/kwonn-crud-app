<?php
require_once __DIR__ . '/config/middleware.php';
?>
<!DOCTYPE html>
<html lang="tl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact — Barangay Masipit</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<style>
    .contact-wrap { max-width: 560px; margin: 0 auto; }
    .social-list { display: flex; flex-direction: column; gap: 0.85rem; margin-top: 1.5rem; }
    .social-link {
        display: flex; align-items: center; gap: 0.9rem;
        padding: 0.9rem 1.1rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--line);
        text-decoration: none;
        color: var(--ink);
        transition: border-color 0.15s ease, transform 0.15s ease;
    }
    .social-link:hover { border-color: var(--accent-mid); transform: translateX(4px); }
    .social-link svg { width: 26px; height: 26px; flex-shrink: 0; }
    .social-link .label { font-weight: 600; display:block; }
    .social-link .handle { font-size: 0.85rem; color: var(--ink-soft); }
</style>
</head>
<body>
    <?php include __DIR__ . '/partials/topnav.php'; ?>

    <div class="page-shell">
        <div class="contact-wrap card">
            <h1>Makipag-ugnayan</h1>
            <p>Developer ng Event Registration System na ito para sa ITP 313 — Event-Driven Programming.</p>

            <div class="social-list">
                <a class="social-link" href="https://github.com/Keydstunna" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" fill="#16261E"><path d="M12 .5C5.73.5.98 5.24.98 11.52c0 4.94 3.2 9.13 7.66 10.61.56.1.76-.24.76-.54 0-.27-.01-1.16-.02-2.1-3.11.68-3.77-1.32-3.77-1.32-.51-1.3-1.24-1.65-1.24-1.65-1.01-.7.08-.68.08-.68 1.12.08 1.71 1.15 1.71 1.15 1 1.71 2.62 1.22 3.26.93.1-.72.39-1.22.71-1.5-2.48-.28-5.09-1.24-5.09-5.53 0-1.22.44-2.22 1.15-3-.12-.28-.5-1.42.11-2.95 0 0 .94-.3 3.08 1.15a10.7 10.7 0 015.6 0c2.14-1.45 3.08-1.15 3.08-1.15.61 1.53.23 2.67.11 2.95.72.78 1.15 1.78 1.15 3 0 4.3-2.62 5.24-5.11 5.52.4.35.76 1.03.76 2.08 0 1.5-.01 2.71-.01 3.08 0 .3.2.65.77.54A11.03 11.03 0 0023.02 11.5C23.02 5.24 18.27.5 12 .5z"/></svg>
                    <span><span class="label">GitHub</span><span class="handle">github.com/Keydstunna</span></span>
                </a>
                <a class="social-link" href="https://www.facebook.com/share/1DWP6rnxw7/" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" fill="#0E4C46"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06C2 17.06 5.66 21.2 10.44 22v-7.03H7.9v-2.9h2.54V9.85c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.9h-2.34V22C18.34 21.2 22 17.06 22 12.06z"/></svg>
                    <span><span class="label">Facebook</span><span class="handle">Personal profile</span></span>
                </a>
                <a class="social-link" href="https://www.instagram.com/kwonbluu" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" fill="#6B8E4E"><path d="M12 2.2c3.2 0 3.6 0 4.85.07 1.17.05 1.97.24 2.43.4a4.9 4.9 0 011.77 1.15 4.9 4.9 0 011.15 1.77c.16.46.35 1.26.4 2.43.06 1.25.07 1.65.07 4.85s0 3.6-.07 4.85c-.05 1.17-.24 1.97-.4 2.43a4.9 4.9 0 01-1.15 1.77 4.9 4.9 0 01-1.77 1.15c-.46.16-1.26.35-2.43.4-1.25.06-1.65.07-4.85.07s-3.6 0-4.85-.07c-1.17-.05-1.97-.24-2.43-.4a4.9 4.9 0 01-1.77-1.15 4.9 4.9 0 01-1.15-1.77c-.16-.46-.35-1.26-.4-2.43C2.21 15.6 2.2 15.2 2.2 12s0-3.6.07-4.85c.05-1.17.24-1.97.4-2.43a4.9 4.9 0 011.15-1.77A4.9 4.9 0 015.6 1.8c.46-.16 1.26-.35 2.43-.4C9.28 2.34 9.68 2.2 12 2.2zm0 1.8c-3.15 0-3.52 0-4.76.07-.96.04-1.48.2-1.83.34-.46.18-.79.4-1.13.75-.35.34-.57.67-.75 1.13-.14.35-.3.87-.34 1.83-.07 1.24-.07 1.6-.07 4.76s0 3.52.07 4.76c.04.96.2 1.48.34 1.83.18.46.4.79.75 1.13.34.35.67.57 1.13.75.35.14.87.3 1.83.34 1.24.07 1.6.07 4.76.07s3.52 0 4.76-.07c.96-.04 1.48-.2 1.83-.34.46-.18.79-.4 1.13-.75.35-.34.57-.67.75-1.13.14-.35.3-.87.34-1.83.07-1.24.07-1.6.07-4.76s0-3.52-.07-4.76c-.04-.96-.2-1.48-.34-1.83a3.1 3.1 0 00-.75-1.13 3.1 3.1 0 00-1.13-.75c-.35-.14-.87-.3-1.83-.34-1.24-.07-1.6-.07-4.76-.07zm0 4.1a5.9 5.9 0 110 11.8 5.9 5.9 0 010-11.8zm0 1.8a4.1 4.1 0 100 8.2 4.1 4.1 0 000-8.2zm6.1-2.2a1.38 1.38 0 11-2.76 0 1.38 1.38 0 012.76 0z"/></svg>
                    <span><span class="label">Instagram</span><span class="handle">@kwonbluu</span></span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
