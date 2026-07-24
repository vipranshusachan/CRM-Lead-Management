<?php
$title = "User Management - Digital Heroes CRM";
ob_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <div>
        <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-main);">Team Accounts</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Manage Administrator and Sales Member system credentials</p>
    </div>
    <a href="<?= base_url('/users/create') ?>" class="btn btn-primary">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Add New User</span>
    </a>
</div>

<div class="table-card">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>System Role</th>
                    <th>Created Date</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>#<?= $u['id'] ?></td>
                        <td style="font-weight: 600;"><?= e($u['name']) ?></td>
                        <td><?= e($u['email']) ?></td>
                        <td>
                            <span class="badge-role <?= $u['role'] === 'ADMIN' ? 'badge-admin' : 'badge-member' ?>">
                                <?= $u['role'] ?>
                            </span>
                        </td>
                        <td style="font-size: 0.85rem; color: var(--text-muted);">
                            <?= date('M d, Y', strtotime($u['created_at'])) ?>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.5rem;">
                                <a href="<?= base_url('/users/' . $u['id'] . '/edit') ?>" class="btn btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.8rem;">
                                    Edit
                                </a>
                                <?php if ((int)$u['id'] !== \App\Core\Auth::id()): ?>
                                    <form action="<?= base_url('/users/' . $u['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Delete user <?= e($u['name']) ?>?');" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger" style="padding: 0.35rem 0.65rem; font-size: 0.8rem;">
                                            Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
