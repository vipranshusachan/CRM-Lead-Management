<?php
$title = "Account Settings - Lead Management CRM";
ob_start();
?>

<div style="margin-bottom: 1.75rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Account & System Settings</h1>
    <p style="color: var(--text-muted); font-size: 0.875rem;">Manage profile details, system preferences, and security</p>
</div>

<div style="display: grid; grid-template-columns: 240px 1fr; gap: 1.5rem;">
    <!-- Settings Tabs Nav -->
    <div class="table-card" style="padding: 0.75rem; height: fit-content;">
        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
            <a href="#profile" class="nav-item-link active"><i class="fa-solid fa-user"></i> Profile Info</a>
            <a href="#company" class="nav-item-link"><i class="fa-solid fa-building"></i> Company Profile</a>
            <a href="#security" class="nav-item-link"><i class="fa-solid fa-shield-halved"></i> Security & Password</a>
            <a href="#system" class="nav-item-link"><i class="fa-solid fa-server"></i> System Info</a>
        </div>
    </div>

    <!-- Settings Content Cards -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Profile Form Card -->
        <div class="table-card" style="padding: 1.5rem;" id="profile">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.25rem;">Profile Information</h3>
            <form action="#" method="POST" onsubmit="event.preventDefault(); showToast('Profile details updated successfully!');">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="<?= e($user['name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="<?= e($user['email'] ?? '') ?>" readonly style="background-color: var(--bg-subtle);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">System Role</label>
                    <input type="text" class="form-control" value="<?= e($user['role'] ?? 'MEMBER') ?>" readonly style="background-color: var(--bg-subtle);">
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">Save Profile Changes</button>
                </div>
            </form>
        </div>

        <!-- Security Card -->
        <div class="table-card" style="padding: 1.5rem;" id="security">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.25rem;">Security & Password</h3>
            <form action="#" method="POST" onsubmit="event.preventDefault(); showToast('Password updated!');">
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-secondary">Update Password</button>
                </div>
            </form>
        </div>

        <!-- System Info Card -->
        <div class="table-card" style="padding: 1.5rem;" id="system">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">System Information</h3>
            <div style="font-size: 0.875rem; color: var(--text-secondary); display: flex; flex-direction: column; gap: 0.5rem;">
                <div><strong>CRM Version:</strong> 2.0.0 (Production Core PHP)</div>
                <div><strong>PHP Version:</strong> <?= PHP_VERSION ?></div>
                <div><strong>Environment:</strong> Development / XAMPP Localhost</div>
                <div><strong>Database Engine:</strong> MySQL / MariaDB (InnoDB)</div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
