<?php
$title = "Activity Timeline - Lead Management CRM";
ob_start();
?>

<div style="margin-bottom: 1.75rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Audit & Activity Timeline</h1>
    <p style="color: var(--text-muted); font-size: 0.875rem;">Immutable system activity trail across all lead interactions</p>
</div>

<div class="table-card" style="padding: 1.5rem;">
    <?php if (empty($activities)): ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <h3>No Recent Activity</h3>
            <p style="color: var(--text-muted); font-size: 0.875rem;">System activity will automatically stream here when team members interact with leads.</p>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            <?php foreach ($activities as $act): ?>
                <div style="display: flex; gap: 1rem; align-items: flex-start; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-color);">
                    <div class="user-avatar-badge" style="width: 36px; height: 36px; font-size: 0.85rem; flex-shrink: 0; background: linear-gradient(135deg, #2563eb, #9333ea); color: white;">
                        <?= strtoupper(substr($act['user_name'], 0, 1)) ?>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.925rem; color: var(--text-primary);">
                            <strong><?= e($act['user_name']) ?></strong> performed
                            <span style="color: var(--color-primary); font-weight: 600;"><?= e($act['action']) ?></span>
                            on lead <a href="<?= base_url('/leads/' . $act['lead_id']) ?>" style="font-weight: 600;"><?= e($act['lead_name']) ?></a>
                        </div>

                        <?php if (!empty($act['metadata'])): ?>
                            <div style="font-size: 0.8rem; color: var(--text-secondary); background: var(--bg-subtle); padding: 0.6rem 0.85rem; border-radius: var(--radius-md); margin-top: 0.5rem; font-family: monospace; border: 1px solid var(--border-color);">
                                <?= e(json_encode($act['metadata'], JSON_PRETTY_PRINT)) ?>
                            </div>
                        <?php endif; ?>

                        <div style="font-size: 0.775rem; color: var(--text-muted); margin-top: 0.35rem;">
                            <i class="fa-regular fa-clock" style="margin-right: 0.25rem;"></i> <?= date('F d, Y \a\t H:i:s', strtotime($act['created_at'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
