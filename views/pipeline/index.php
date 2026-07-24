<?php
$title = "Pipeline Kanban Board - Lead Management CRM";
ob_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Sales Pipeline Kanban</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Visual lead stage workflow & drag-and-drop progression</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <?php if (\App\Core\Auth::isAdmin()): ?>
            <a href="<?= base_url('/leads/create') ?>" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Lead
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Kanban Columns Grid -->
<div class="kanban-wrapper" style="display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 1rem;">
    <?php foreach ($statuses as $status): 
        $leads = $pipeline[$status] ?? [];
        $statusSlug = strtolower(str_replace(' ', '', $status));
    ?>
        <div class="kanban-column" style="flex: 0 0 280px; background-color: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-lg); display: flex; flex-direction: column; max-height: calc(100vh - 200px);">
            <!-- Column Header -->
            <div style="padding: 1rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background-color: var(--bg-subtle);">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span class="status-badge status-<?= $statusSlug ?>" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;"><?= e($status) ?></span>
                </div>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); background: var(--bg-surface); padding: 0.15rem 0.5rem; border-radius: 12px; border: 1px solid var(--border-color);"><?= count($leads) ?></span>
            </div>

            <!-- Column Cards Scroll Container -->
            <div class="kanban-cards" style="padding: 0.75rem; display: flex; flex-direction: column; gap: 0.75rem; overflow-y: auto; flex: 1;">
                <?php if (empty($leads)): ?>
                    <div style="text-align: center; padding: 2rem 0.5rem; color: var(--text-muted); font-size: 0.8rem;">
                        No leads in <?= e($status) ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($leads as $lead): ?>
                        <div class="kanban-card card-surface" style="padding: 1rem; border-radius: var(--radius-md); cursor: pointer; transition: transform var(--transition-fast);" onclick="window.location.href='<?= base_url('/leads/' . $lead['id']) ?>'">
                            <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary); margin-bottom: 0.35rem;">
                                <?= e($lead['name']) ?>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                <i class="fa-regular fa-building" style="margin-right: 0.25rem;"></i> <?= e($lead['company'] ?? 'N/A') ?>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
                                <span style="color: var(--text-muted);"><i class="fa-solid fa-user" style="margin-right: 0.2rem;"></i> <?= e($lead['assigned_to_name'] ?? 'Unassigned') ?></span>
                                <span style="color: var(--color-primary); font-weight: 600;">View &rarr;</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
