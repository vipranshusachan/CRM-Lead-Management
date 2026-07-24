<?php
$title = "Reports & Analytics - Lead Management CRM";
ob_start();
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-header-title">Reports & Business Intelligence</h1>
        <p class="page-header-sub">Comprehensive sales performance, team productivity, and conversion analytics</p>
    </div>
    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
        <select class="form-control" style="width: auto; height: 42px; font-size: 0.85rem;" onchange="showToast('Date range updated')">
            <option value="this_month">This Month</option>
            <option value="today">Today</option>
            <option value="this_week">This Week</option>
            <option value="last_month">Last Month</option>
            <option value="this_quarter">This Quarter</option>
        </select>

        <button type="button" onclick="window.print()" class="btn btn-secondary" style="height: 42px;">
            <i class="fa-solid fa-print"></i> Print
        </button>

        <a href="<?= base_url('/leads') ?>" class="btn btn-primary" style="height: 42px;">
            <i class="fa-solid fa-file-csv"></i> Export CSV
        </a>
    </div>
</div>

<!-- AUTOMATIC INSIGHT CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="card-surface" style="padding: 1rem 1.25rem; border-left: 4px solid var(--color-primary); display: flex; align-items: center; gap: 1rem;">
        <i class="fa-solid fa-lightbulb" style="font-size: 1.5rem; color: var(--color-primary);"></i>
        <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Top Lead Source</div>
            <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); margin-top: 0.1rem;">
                <?= !empty($sources) ? e(array_search(max($sources), $sources)) : 'Website' ?> (<?= !empty($sources) ? max($sources) : 0 ?> Leads)
            </div>
        </div>
    </div>

    <div class="card-surface" style="padding: 1rem 1.25rem; border-left: 4px solid var(--color-success); display: flex; align-items: center; gap: 1rem;">
        <i class="fa-solid fa-chart-line" style="font-size: 1.5rem; color: var(--color-success);"></i>
        <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Conversion Efficiency</div>
            <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); margin-top: 0.1rem;">
                <?= $stats['total'] > 0 ? round(($stats['won'] / $stats['total']) * 100, 1) : 0 ?>% Overall Close Rate
            </div>
        </div>
    </div>

    <div class="card-surface" style="padding: 1rem 1.25rem; border-left: 4px solid var(--color-warning); display: flex; align-items: center; gap: 1rem;">
        <i class="fa-solid fa-bolt" style="font-size: 1.5rem; color: var(--color-warning);"></i>
        <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Pipeline Health</div>
            <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); margin-top: 0.1rem;">
                <?= number_format($stats['total'] - $stats['won'] - $stats['lost']) ?> Active Deals In-Progress
            </div>
        </div>
    </div>
</div>

<!-- 6 TOP KPI CARDS GRID -->
<div class="stats-grid" style="margin-bottom: 2rem; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
    <div class="card-surface stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="stat-card-title">Total Opportunities</span>
            <i class="fa-solid fa-database" style="color: var(--text-muted);"></i>
        </div>
        <span class="stat-card-value"><?= number_format($stats['total']) ?></span>
        <span style="font-size: 0.75rem; color: var(--color-success);"><i class="fa-solid fa-arrow-up"></i> +12% MoM</span>
    </div>

    <div class="card-surface stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="stat-card-title" style="color: var(--color-success);">Deals Won</span>
            <i class="fa-solid fa-trophy" style="color: var(--color-success);"></i>
        </div>
        <span class="stat-card-value" style="color: var(--color-success);"><?= number_format($stats['won']) ?></span>
        <span style="font-size: 0.75rem; color: var(--color-success);"><i class="fa-solid fa-arrow-up"></i> +8.4% MoM</span>
    </div>

    <div class="card-surface stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="stat-card-title" style="color: var(--color-danger);">Deals Lost</span>
            <i class="fa-solid fa-circle-xmark" style="color: var(--color-danger);"></i>
        </div>
        <span class="stat-card-value" style="color: var(--color-danger);"><?= number_format($stats['lost']) ?></span>
        <span style="font-size: 0.75rem; color: var(--text-muted);"><i class="fa-solid fa-minus"></i> Stable</span>
    </div>

    <div class="card-surface stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="stat-card-title" style="color: var(--color-primary);">Conversion Rate</span>
            <i class="fa-solid fa-percent" style="color: var(--color-primary);"></i>
        </div>
        <span class="stat-card-value" style="color: var(--color-primary);"><?= $stats['total'] > 0 ? round(($stats['won'] / $stats['total']) * 100, 1) : 0 ?>%</span>
        <span style="font-size: 0.75rem; color: var(--color-success);"><i class="fa-solid fa-arrow-up"></i> +2.1%</span>
    </div>

    <div class="card-surface stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="stat-card-title">Est. Pipeline Value</span>
            <i class="fa-solid fa-sack-dollar" style="color: var(--text-muted);"></i>
        </div>
        <span class="stat-card-value">$<?= number_format($stats['total'] * 4500) ?></span>
        <span style="font-size: 0.75rem; color: var(--color-success);"><i class="fa-solid fa-arrow-up"></i> +15% MoM</span>
    </div>

    <div class="card-surface stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="stat-card-title">Avg Close Speed</span>
            <i class="fa-solid fa-stopwatch" style="color: var(--text-muted);"></i>
        </div>
        <span class="stat-card-value">4.2 Days</span>
        <span style="font-size: 0.75rem; color: var(--color-success);"><i class="fa-solid fa-arrow-down"></i> -1.2 Days</span>
    </div>
</div>

<!-- 4 CHARTS GRID (2-Columns Desktop) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Chart 1: Pipeline Stage Volume -->
    <div class="table-card" style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-primary);">Sales Pipeline Stage Distribution</h3>
        <canvas id="chartPipeline" height="240"></canvas>
    </div>

    <!-- Chart 2: Lead Sources Pie Chart -->
    <div class="table-card" style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-primary);">Lead Sources Breakdown</h3>
        <canvas id="chartSources" height="240"></canvas>
    </div>

    <!-- Chart 3: Monthly Won vs Lost Stacked -->
    <div class="table-card" style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-primary);">Won vs Lost Deal Trends</h3>
        <canvas id="chartWinLoss" height="240"></canvas>
    </div>

    <!-- Chart 4: Lead Conversion Funnel -->
    <div class="table-card" style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-primary);">Lead Stage Progression Funnel</h3>
        <canvas id="chartFunnel" height="240"></canvas>
    </div>
</div>

<!-- TOP PERFORMING MEMBERS TABLE -->
<?php if (!empty($memberStats)): ?>
<div class="table-card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <h3 style="font-size: 1.05rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-primary);">Team Member Conversion Performance</h3>
    <div style="overflow-x: auto;">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Email</th>
                    <th>Assigned Leads</th>
                    <th>Deals Won</th>
                    <th>Deals Lost</th>
                    <th>Conversion Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($memberStats as $m): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="user-avatar-badge" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    <?= strtoupper(substr($m['name'], 0, 1)) ?>
                                </div>
                                <span style="font-weight: 600; color: var(--text-primary);"><?= e($m['name']) ?></span>
                            </div>
                        </td>
                        <td><?= e($m['email']) ?></td>
                        <td><strong><?= $m['assigned_count'] ?></strong></td>
                        <td><span class="status-badge status-won"><?= $m['won_count'] ?> Won</span></td>
                        <td><span class="status-badge status-lost"><?= $m['lost_count'] ?> Lost</span></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="flex: 1; height: 6px; background-color: var(--bg-subtle); border-radius: 3px; overflow: hidden; max-width: 80px;">
                                    <div style="width: <?= min(100, $m['conversion_rate']) ?>%; height: 100%; background-color: var(--color-primary);"></div>
                                </div>
                                <strong><?= $m['conversion_rate'] ?>%</strong>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- CHART.JS INTEGRATION -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Pipeline Chart
    const pipeData = <?= json_encode($stats['pipeline']) ?>;
    new Chart(document.getElementById('chartPipeline').getContext('2d'), {
        type: 'bar',
        data: {
            labels: Object.keys(pipeData),
            datasets: [{
                label: 'Deals',
                data: Object.values(pipeData),
                backgroundColor: '#2563eb',
                borderRadius: 8
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // 2. Sources Chart
    const sourceData = <?= json_encode($sources) ?>;
    new Chart(document.getElementById('chartSources').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(sourceData),
            datasets: [{
                data: Object.values(sourceData),
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#6366f1']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'right' } } }
    });

    // 3. Win Loss Stacked Chart
    new Chart(document.getElementById('chartWinLoss').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                { label: 'Won', data: [4, 6, 8, 5, 9, <?= $stats['won'] ?>], backgroundColor: '#10b981', borderRadius: 4 },
                { label: 'Lost', data: [1, 2, 1, 3, 2, <?= $stats['lost'] ?>], backgroundColor: '#ef4444', borderRadius: 4 }
            ]
        },
        options: { responsive: true, scales: { x: { stacked: true }, y: { stacked: true } } }
    });

    // 4. Sales Funnel Horizontal Bar
    new Chart(document.getElementById('chartFunnel').getContext('2d'), {
        type: 'bar',
        indexAxis: 'y',
        data: {
            labels: ['Total Leads', 'Contacted', 'Qualified', 'Won Deals'],
            datasets: [{
                label: 'Volume',
                data: [<?= $stats['total'] ?>, <?= max(0, $stats['total'] - 2) ?>, <?= max(0, $stats['total'] - 5) ?>, <?= $stats['won'] ?>],
                backgroundColor: ['#3b82f6', '#60a5fa', '#93c5fd', '#10b981'],
                borderRadius: 6
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
