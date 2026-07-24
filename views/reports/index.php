<?php
$title = "Reports & Analytics - Lead Management CRM";
ob_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Reports & Sales Analytics</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Performance charts, conversion metrics, and data export</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button type="button" onclick="window.print()" class="btn btn-secondary">
            <i class="fa-solid fa-print"></i> Print Report
        </button>
        <a href="<?= base_url('/leads') ?>" class="btn btn-primary">
            <i class="fa-solid fa-file-csv"></i> Export Leads CSV
        </a>
    </div>
</div>

<!-- Key Performance Metrics Row -->
<div class="stats-grid" style="margin-bottom: 1.75rem;">
    <div class="card-surface stat-card">
        <span class="stat-card-title">Total Opportunities</span>
        <span class="stat-card-value"><?= number_format($stats['total']) ?></span>
    </div>
    <div class="card-surface stat-card">
        <span class="stat-card-title" style="color: var(--color-success);">Deals Won</span>
        <span class="stat-card-value" style="color: var(--color-success);"><?= number_format($stats['won']) ?></span>
    </div>
    <div class="card-surface stat-card">
        <span class="stat-card-title" style="color: var(--color-danger);">Deals Lost</span>
        <span class="stat-card-value" style="color: var(--color-danger);"><?= number_format($stats['lost']) ?></span>
    </div>
    <div class="card-surface stat-card">
        <span class="stat-card-title" style="color: var(--color-primary);">Conversion Rate</span>
        <span class="stat-card-value" style="color: var(--color-primary);"><?= $stats['total'] > 0 ? round(($stats['won'] / $stats['total']) * 100, 1) : 0 ?>%</span>
    </div>
</div>

<!-- Charts Section -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem;">
    <div class="table-card" style="padding: 1.25rem;">
        <h3 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">Pipeline Stage Volume</h3>
        <canvas id="reportPipelineChart" height="220"></canvas>
    </div>
    <div class="table-card" style="padding: 1.25rem;">
        <h3 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">Won vs Lost Distribution</h3>
        <canvas id="reportWinLossChart" height="220"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const pipelineData = <?= json_encode($stats['pipeline']) ?>;
    const labels = Object.keys(pipelineData);
    const counts = Object.values(pipelineData);

    const ctxPipe = document.getElementById('reportPipelineChart').getContext('2d');
    new Chart(ctxPipe, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Leads',
                data: counts,
                backgroundColor: '#2563eb',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    const ctxWinLoss = document.getElementById('reportWinLossChart').getContext('2d');
    new Chart(ctxWinLoss, {
        type: 'doughnut',
        data: {
            labels: ['Won', 'Lost', 'In Progress'],
            datasets: [{
                data: [
                    <?= $stats['won'] ?>,
                    <?= $stats['lost'] ?>,
                    <?= max(0, $stats['total'] - $stats['won'] - $stats['lost']) ?>
                ],
                backgroundColor: ['#10b981', '#ef4444', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
