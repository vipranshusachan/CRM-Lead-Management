<?php
$title = e($lead['name']) . " - Lead Details";
$isAdmin = \App\Core\Auth::isAdmin();
$statusSlug = strtolower(str_replace(' ', '', $lead['status']));
ob_start();
?>

<!-- Breadcrumbs -->
<div style="margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
    <a href="<?= base_url('/leads') ?>">Leads</a> &nbsp;&sol;&nbsp; <span><?= e($lead['name']) ?></span>
</div>

<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-main);"><?= e($lead['name']) ?></h1>
            <span class="status-badge status-<?= $statusSlug ?>" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">
                <?= e($lead['status']) ?>
            </span>
        </div>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">Company: <strong><?= e($lead['company'] ?? 'N/A') ?></strong> | Source: <strong><?= e($lead['source'] ?? 'Website') ?></strong></p>
    </div>

    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <button type="button" onclick="openModal('statusModal')" class="btn btn-secondary">
            Change Status
        </button>

        <?php if ($isAdmin): ?>
            <button type="button" onclick="openModal('assignModal')" class="btn btn-secondary">
                Reassign Lead
            </button>
            <a href="<?= base_url('/leads/' . $lead['id'] . '/edit') ?>" class="btn btn-secondary">Edit Lead</a>
            <button type="button" onclick="openModal('deleteModal')" class="btn btn-danger">Delete</button>
        <?php endif; ?>
    </div>
</div>

<!-- Main Details Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    
    <!-- Left Column: Notes & Activity Timeline -->
    <div>
        <!-- Add Note Box -->
        <div class="table-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">Add Note</h3>
            <form action="<?= base_url('/leads/' . $lead['id'] . '/notes') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="form-group">
                    <textarea name="note" class="form-control" rows="3" placeholder="Enter notes or discussion highlights regarding this lead..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Note</button>
            </form>
        </div>

        <!-- Notes Stream -->
        <div class="table-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">Notes History (<?= count($notes) ?>)</h3>
            <?php if (empty($notes)): ?>
                <p style="color: var(--text-muted); font-size: 0.9rem;">No notes recorded yet for this lead.</p>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($notes as $nt): ?>
                        <div style="padding: 1rem; background-color: var(--bg-primary); border-radius: 8px; border: 1px solid var(--border-color);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div class="avatar" style="width: 28px; height: 28px; font-size: 0.75rem;"><?= strtoupper(substr($nt['author_name'], 0, 1)) ?></div>
                                    <span style="font-weight: 600; font-size: 0.9rem;"><?= e($nt['author_name']) ?></span>
                                    <span class="badge-role <?= $nt['author_role'] === 'ADMIN' ? 'badge-admin' : 'badge-member' ?>"><?= $nt['author_role'] ?></span>
                                </div>
                                <span style="font-size: 0.8rem; color: var(--text-muted);"><?= date('M d, Y H:i', strtotime($nt['created_at'])) ?></span>
                            </div>
                            <p style="font-size: 0.9rem; color: var(--text-main); white-space: pre-wrap;"><?= e($nt['note']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Activity Timeline -->
        <div class="table-card" style="padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">Audit & Activity Trail</h3>
            <?php if (empty($activities)): ?>
                <p style="color: var(--text-muted); font-size: 0.9rem;">No activity recorded.</p>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($activities as $act): ?>
                        <div style="display: flex; gap: 1rem; align-items: flex-start; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                            <div class="avatar" style="width: 32px; height: 32px; font-size: 0.8rem; flex-shrink: 0; background: linear-gradient(135deg, #38bdf8, #818cf8);">
                                <?= strtoupper(substr($act['user_name'], 0, 1)) ?>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.9rem; color: var(--text-main);">
                                    <strong><?= e($act['user_name']) ?></strong>:
                                    <span style="color: var(--accent-blue); font-weight: 600;"><?= e($act['action']) ?></span>
                                </div>
                                <?php if (!empty($act['metadata'])): ?>
                                    <div style="font-size: 0.8rem; color: var(--text-muted); background: var(--bg-primary); padding: 0.5rem; border-radius: 6px; margin-top: 0.4rem; font-family: monospace;">
                                        <?= e(json_encode($act['metadata'], JSON_PRETTY_PRINT)) ?>
                                    </div>
                                <?php endif; ?>
                                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">
                                    <?= date('M d, Y H:i:s', strtotime($act['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column: Metadata Overview -->
    <div>
        <div class="table-card" style="padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">Lead Info</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.9rem;">
                <div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Email Address</div>
                    <a href="mailto:<?= e($lead['email']) ?>"><?= e($lead['email']) ?></a>
                </div>

                <div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Phone Number</div>
                    <div><?= e($lead['phone'] ?? 'Not provided') ?></div>
                </div>

                <div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Assigned Sales Representative</div>
                    <div>
                        <?php if ($lead['assigned_to_name']): ?>
                            <strong><?= e($lead['assigned_to_name']) ?></strong> (<?= e($lead['assigned_to_email']) ?>)
                        <?php else: ?>
                            <span style="color: var(--text-muted); font-style: italic;">Unassigned</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Created By</div>
                    <div><?= e($lead['created_by_name'] ?? 'System') ?></div>
                </div>

                <div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Created At</div>
                    <div><?= date('F d, Y \a\t H:i', strtotime($lead['created_at'])) ?></div>
                </div>

                <div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Last Updated</div>
                    <div><?= date('F d, Y \a\t H:i', strtotime($lead['updated_at'])) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Status Modal -->
<div id="statusModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-size: 1.1rem; font-weight: 600;">Update Lead Status</h3>
            <button type="button" onclick="closeModal('statusModal')" style="background: none; border: none; color: var(--text-muted); font-size: 1.2rem; cursor: pointer;">&times;</button>
        </div>
        <form action="<?= base_url('/leads/' . $lead['id'] . '/status') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="modal_status">Select Status</label>
                <select id="modal_status" name="status" class="form-control" required>
                    <?php foreach ($statuses as $st): ?>
                        <option value="<?= e($st) ?>" <?= $lead['status'] === $st ? 'selected' : '' ?>><?= e($st) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeModal('statusModal')" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Status</button>
            </div>
        </form>
    </div>
</div>

<?php if ($isAdmin): ?>
<!-- Reassign Lead Modal -->
<div id="assignModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-size: 1.1rem; font-weight: 600;">Assign Lead to Team Member</h3>
            <button type="button" onclick="closeModal('assignModal')" style="background: none; border: none; color: var(--text-muted); font-size: 1.2rem; cursor: pointer;">&times;</button>
        </div>
        <form action="<?= base_url('/leads/' . $lead['id'] . '/assign') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="modal_assigned_to">Select Team Member</label>
                <select id="modal_assigned_to" name="assigned_to" class="form-control">
                    <option value="">Unassigned</option>
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= (int)$lead['assigned_to'] === (int)$m['id'] ? 'selected' : '' ?>>
                            <?= e($m['name']) ?> (<?= e($m['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeModal('assignModal')" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Assign Lead</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Lead Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--accent-red);">Confirm Delete</h3>
            <button type="button" onclick="closeModal('deleteModal')" style="background: none; border: none; color: var(--text-muted); font-size: 1.2rem; cursor: pointer;">&times;</button>
        </div>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem;">
            Are you sure you want to permanently delete lead <strong><?= e($lead['name']) ?></strong>? This action cannot be undone.
        </p>
        <form action="<?= base_url('/leads/' . $lead['id'] . '/delete') ?>" method="POST">
            <?= csrf_field() ?>
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                <button type="button" onclick="closeModal('deleteModal')" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-danger">Confirm Delete</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
