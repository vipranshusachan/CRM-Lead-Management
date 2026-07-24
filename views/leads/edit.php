<?php
$title = "Edit Lead - " . e($lead['name']);
ob_start();
?>

<div style="margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
    <a href="<?= base_url('/leads') ?>">Leads</a> &nbsp;&sol;&nbsp;
    <a href="<?= base_url('/leads/' . $lead['id']) ?>"><?= e($lead['name']) ?></a> &nbsp;&sol;&nbsp;
    <span>Edit</span>
</div>

<div class="table-card" style="max-width: 700px; padding: 2rem; margin: 0 auto;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-main);">Edit Lead Details</h1>

    <form action="<?= base_url('/leads/' . $lead['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="name">Lead Full Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= e(old('name', $lead['name'])) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e(old('email', $lead['email'])) ?>" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= e(old('phone', $lead['phone'])) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="company">Company Name</label>
                <input type="text" id="company" name="company" class="form-control" value="<?= e(old('company', $lead['company'])) ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="source">Lead Source</label>
            <input type="text" id="source" name="source" class="form-control" value="<?= e(old('source', $lead['source'])) ?>">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem;">
            <a href="<?= base_url('/leads/' . $lead['id']) ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Lead</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
