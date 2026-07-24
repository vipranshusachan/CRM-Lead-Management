<?php
$title = "Dashboard - Lead Management CRM";
ob_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em;">Dashboard Overview</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Real-time metrics, pipeline statistics, and sales activity</p>
    </div>
    <?php if (\App\Core\Auth::isAdmin()): ?>
        <a href="<?= base_url('/leads/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Add Lead</span>
        </a>
    <?php endif; ?>
</div>

<!-- Stat Cards -->
<div class="stats-grid">
    <div class="card-surface stat-card">
        <span class="stat-card-title">Total Leads</span>
        <span class="stat-card-value"><?= number_format($stats['total']) ?></span>
    </div>
    <div class="card-surface stat-card">
        <span class="stat-card-title">Assigned To Me</span>
        <span class="stat-card-value"><?= number_format($stats['my_leads']) ?></span>
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
        <span class="stat-card-title" style="color: var(--color-primary);">New Today</span>
        <span class="stat-card-value" style="color: var(--color-primary);"><?= number_format($stats['new_today']) ?></span>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem; margin-bottom: 1.75rem;">
    <div class="table-card" style="padding: 1.25rem;">
        <h3 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">Sales Pipeline Funnel</h3>
        <canvas id="pipelineChart" height="210"></canvas>
    </div>
    <div class="table-card" style="padding: 1.25rem;">
        <h3 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">Status Breakdown</h3>
        <canvas id="statusChart" height="210"></canvas>
    </div>
</div>

<!-- Activity & Notes Split Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem;">
    <!-- Recent Activity -->
    <div class="table-card">
        <div class="table-header-bar">
            <h3 style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary);">Audit Activity Feed</h3>
            <a href="<?= base_url('/leads') ?>" style="font-size: 0.8rem; font-weight: 500;">View Leads</a>
        </div>
        <div style="padding: 1rem;">
            <?php if (empty($recentActivities)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">No activity logged yet.</p>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <?php foreach ($recentActivities as $act): ?>
                        <div style="display: flex; gap: 0.75rem; align-items: flex-start; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                            <div class="user-avatar-badge" style="width: 30px; height: 30px; font-size: 0.75rem; flex-shrink: 0;">
                                <?= strtoupper(substr($act['user_name'], 0, 1)) ?>
                            </div>
                            <div style="flex: 1; font-size: 0.85rem;">
                                <div style="color: var(--text-primary);">
                                    <strong><?= e($act['user_name']) ?></strong> performed
                                    <span style="color: var(--color-primary); font-weight: 600;"><?= e($act['action']) ?></span>
                                    on <strong><?= e($act['lead_name']) ?></strong>
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.15rem;">
                                    <?= date('M d, Y \a\t H:i', strtotime($act['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Latest Notes -->
    <div class="table-card">
        <div class="table-header-bar">
            <h3 style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary);">Recent Team Notes</h3>
        </div>
        <div style="padding: 1rem;">
            <?php if (empty($latestNotes)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fa-regular fa-note-sticky"></i></div>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">No notes created yet.</p>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <?php foreach ($latestNotes as $nt): ?>
                        <div style="padding: 0.75rem 0.9rem; background-color: var(--bg-subtle); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.35rem;">
                                <strong style="color: var(--color-primary);"><?= e($nt['author_name']) ?></strong>
                                <span style="color: var(--text-muted);"><?= date('M d, H:i', strtotime($nt['created_at'])) ?></span>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-primary);">"<?= e($nt['note']) ?>"</p>
                            <div style="margin-top: 0.35rem; font-size: 0.75rem; color: var(--text-muted);">
                                Lead: <a href="<?= base_url('/leads/' . $nt['lead_id']) ?>"><?= e($nt['lead_name']) ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const pipelineData = <?= json_encode($stats['pipeline']) ?>;
    const labels = Object.keys(pipelineData);
    const counts = Object.values(pipelineData);

    // 1. Pipeline Bar Chart - Muted Clean Palette
    const ctxPipeline = document.getElementById('pipelineChart').getContext('2d');
    new Chart(ctxPipeline, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Leads Count',
                data: counts,
                backgroundColor: [
                    '#dbeafe',
                    '#f3e8ff',
                    '#cff4fc',
                    '#ffedd5',
                    '#fef9c3',
                    '#dcfce7',
                    '#fee2e2'
                ],
                borderColor: [
                    '#1e40af',
                    '#6b21a8',
                    '#055160',
                    '#9a3412',
                    '#854d0e',
                    '#166534',
                    '#991b1b'
                ],
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

    // 2. Status Doughnut Chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: [
                    '#2563eb',
                    '#9333ea',
                    '#0891b2',
                    '#ea580c',
                    '#ca8a04',
                    '#16a34a',
                    '#dc2626'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'right', labels: { boxWidth: 12, font: { family: 'Inter', size: 11 } } }
            }
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
