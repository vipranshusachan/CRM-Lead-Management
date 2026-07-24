<?php
$title = "Create New Lead - Digital Heroes CRM";
ob_start();
?>

<div style="margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
    <a href="<?= base_url('/leads') ?>">Leads</a> &nbsp;&sol;&nbsp; <span>Create Lead</span>
</div>

<div class="table-card" style="max-width: 700px; padding: 2rem; margin: 0 auto;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-main);">Create New Lead</h1>

    <form action="<?= base_url('/leads') ?>" method="POST">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="name">Lead Full Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= e(old('name')) ?>" placeholder="e.g. John Doe" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e(old('email')) ?>" placeholder="john@example.com" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= e(old('phone')) ?>" placeholder="+1 555-0199">
            </div>

            <div class="form-group">
                <label class="form-label" for="company">Company Name</label>
                <input type="text" id="company" name="company" class="form-control" value="<?= e(old('company')) ?>" placeholder="Acme Inc">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="source">Lead Source</label>
                <select id="source" name="source" class="form-control">
                    <option value="Website" <?= old('source') === 'Website' ? 'selected' : '' ?>>Website</option>
                    <option value="LinkedIn" <?= old('source') === 'LinkedIn' ? 'selected' : '' ?>>LinkedIn</option>
                    <option value="Referral" <?= old('source') === 'Referral' ? 'selected' : '' ?>>Referral</option>
                    <option value="Conference" <?= old('source') === 'Conference' ? 'selected' : '' ?>>Conference</option>
                    <option value="Cold Call" <?= old('source') === 'Cold Call' ? 'selected' : '' ?>>Cold Call</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Initial Status</label>
                <select id="status" name="status" class="form-control">
                    <?php foreach ($statuses as $st): ?>
                        <option value="<?= e($st) ?>" <?= old('status', 'New') === $st ? 'selected' : '' ?>><?= e($st) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="assigned_to">Assign To Sales Member</label>
            <select id="assigned_to" name="assigned_to" class="form-control">
                <option value="">-- Leave Unassigned --</option>
                <?php foreach ($members as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= ((string)old('assigned_to')) === (string)$m['id'] ? 'selected' : '' ?>>
                        <?= e($m['name']) ?> (<?= e($m['email']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem;">
            <a href="<?= base_url('/leads') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Lead</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
