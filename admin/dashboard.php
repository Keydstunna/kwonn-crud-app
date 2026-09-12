<?php
// ===================================================================
// ADMIN/DASHBOARD.PHP — Admin-only view ng LAHAT ng registrations
// -------------------------------------------------------------------
// Naka-guard ng DALAWANG layer: middleware.php (dapat naka-login),
// tapos admin_middleware.php (dapat role === 'admin'). Kaya kahit
// naka-login yung regular user (juan), 403 lang makikita niya rito.
// ===================================================================
require_once __DIR__ . '/../config/admin_middleware.php';
require_once __DIR__ . '/../config/db.php';

$cleanup = $pdo->query('SELECT * FROM cleanup_registrations ORDER BY created_at DESC')->fetchAll();
$tree    = $pdo->query('SELECT * FROM treeplanting_registrations ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="tl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — Barangay Masipit</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<style>
    .tabs { display: flex; gap: 0.5rem; margin-bottom: 1.25rem; }
    .tab-btn {
        padding: 0.55em 1.2em; border-radius: 999px; border: 1.5px solid var(--line);
        background: var(--paper); cursor: pointer; font-weight: 600; font-size: 0.88rem;
        color: var(--ink-soft);
    }
    .tab-btn.active { background: var(--accent-deep); color: #fff; border-color: var(--accent-deep); }
    table { width: 100%; border-collapse: collapse; background: var(--paper); border-radius: var(--radius-md); overflow: hidden; }
    th, td { text-align: left; padding: 0.75em 0.9em; font-size: 0.88rem; border-bottom: 1px solid var(--line); }
    th { background: var(--mist); color: var(--ink-soft); font-weight: 600; }
    .stat-row { display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap: wrap; }
    .stat-card { flex:1; min-width:160px; padding:1.1rem 1.3rem; border-radius: var(--radius-md); }
    .stat-card .num { font-family: var(--font-display); font-size: 2rem; }
</style>
</head>
<body class="theme-admin">
    <?php include __DIR__ . '/../partials/topnav.php'; ?>

    <div class="page-shell">
        <h1>Admin Dashboard</h1>
        <p>Buod ng lahat ng nakarehistro sa dalawang environmental activity ng barangay.</p>

        <div class="stat-row">
            <div class="stat-card gradient-surface" style="--accent-deep:#0E4C46; --accent-mid:#2E8C7D;">
                <div class="num"><?= count($cleanup) ?></div>
                <div>Clean-Up Drive registrants</div>
            </div>
            <div class="stat-card gradient-surface" style="--accent-deep:#33512B; --accent-mid:#6B8E4E;">
                <div class="num"><?= count($tree) ?></div>
                <div>Tree Planting registrants</div>
            </div>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="showTable('cleanup', this)">Clean-Up Drive</button>
            <button class="tab-btn" onclick="showTable('tree', this)">Tree Planting</button>
        </div>

        <div id="table-cleanup" class="card" style="overflow-x:auto;">
            <table>
                <thead><tr><th>Pangalan</th><th>Email</th><th>Contact</th><th>Purok/Sitio</th><th>Gloves?</th><th>Rehistro noong</th></tr></thead>
                <tbody>
                <?php foreach ($cleanup as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['full_name']) ?></td>
                        <td><?= htmlspecialchars($r['email']) ?></td>
                        <td><?= htmlspecialchars($r['contact_number']) ?></td>
                        <td><?= htmlspecialchars($r['purok_sitio']) ?></td>
                        <td><?= $r['bring_gloves'] ? 'Oo' : 'Hindi' ?></td>
                        <td><?= htmlspecialchars($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$cleanup): ?><tr><td colspan="6">Wala pang data.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="table-tree" class="card" style="overflow-x:auto; display:none;">
            <table>
                <thead><tr><th>Pangalan</th><th>Email</th><th>Contact</th><th>Purok/Sitio</th><th>Seedlings</th><th>Rehistro noong</th></tr></thead>
                <tbody>
                <?php foreach ($tree as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['full_name']) ?></td>
                        <td><?= htmlspecialchars($r['email']) ?></td>
                        <td><?= htmlspecialchars($r['contact_number']) ?></td>
                        <td><?= htmlspecialchars($r['purok_sitio']) ?></td>
                        <td><?= (int)$r['seedlings'] ?></td>
                        <td><?= htmlspecialchars($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$tree): ?><tr><td colspan="6">Wala pang data.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Simpleng tab-switch, walang kailangang library
        function showTable(which, btn) {
            document.getElementById('table-cleanup').style.display = which === 'cleanup' ? 'block' : 'none';
            document.getElementById('table-tree').style.display = which === 'tree' ? 'block' : 'none';
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    </script>
</body>
</html>
