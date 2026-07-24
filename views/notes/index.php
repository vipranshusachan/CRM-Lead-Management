<?php
$title = "Team Notes Stream - Lead Management CRM";
ob_start();
?>

<div style="margin-bottom: 1.75rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Centralized Notes Stream</h1>
    <p style="color: var(--text-muted); font-size: 0.875rem;">View and search all discussion highlights and lead notes</p>
</div>

<div class="table-card" style="padding: 1.5rem;">
    <?php if (empty($notes)): ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fa-regular fa-note-sticky"></i></div>
            <h3>No Notes Posted</h3>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Team discussion notes added to leads will appear in this centralized feed.</p>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem;">
            <?php foreach ($notes as $nt): ?>
                <div class="card-surface" style="padding: 1.25rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div class="user-avatar-badge" style="width: 30px; height: 30px; font-size: 0.75rem;">
                                    <?= strtoupper(substr($nt['author_name'], 0, 1)) ?>
                                </div>
                                <span style="font-weight: 600; font-size: 0.875rem; color: var(--text-primary);"><?= e($nt['author_name']) ?></span>
                            </div>
                            <span style="font-size: 0.75rem; color: var(--text-muted);"><?= date('M d, Y', strtotime($nt['created_at'])) ?></span>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-primary); line-height: 1.5; white-space: pre-wrap; margin-bottom: 1rem;">"<?= e($nt['note']) ?>"</p>
                    </div>

                    <div style="border-top: 1px solid var(--border-color); padding-top: 0.75rem; font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center;">
                        <span>Lead: <a href="<?= base_url('/leads/' . $nt['lead_id']) ?>" style="font-weight: 600;"><?= e($nt['lead_name']) ?></a></span>
                        <a href="<?= base_url('/leads/' . $nt['lead_id']) ?>" class="btn-ghost" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">View Lead &rarr;</a>
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
