<?php
$title = "Edit User - " . e($user['name']);
ob_start();
?>

<div style="margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
    <a href="<?= base_url('/users') ?>">Users</a> &nbsp;&sol;&nbsp; <span>Edit User</span>
</div>

<div class="table-card" style="max-width: 600px; padding: 2rem; margin: 0 auto;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-main);">Edit User Account</h1>

    <form action="<?= base_url('/users/' . $user['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="name">Full Name *</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= e(old('name', $user['name'])) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address *</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= e(old('email', $user['email'])) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">New Password (Leave blank to keep unchanged)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
        </div>

        <div class="form-group">
            <label class="form-label" for="role">Role *</label>
            <select id="role" name="role" class="form-control" required>
                <option value="MEMBER" <?= old('role', $user['role']) === 'MEMBER' ? 'selected' : '' ?>>MEMBER (Sales Representative)</option>
                <option value="ADMIN" <?= old('role', $user['role']) === 'ADMIN' ? 'selected' : '' ?>>ADMIN (Full System Control)</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem;">
            <a href="<?= base_url('/users') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update User</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
