<?php $currentUser = \App\Core\Auth::user(); ?>
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-badge">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <span class="logo-title">LeadFlow CRM</span>
        <button type="button" class="sidebar-collapse-btn" id="sidebarCollapseBtn" title="Toggle Sidebar (260px / 72px)">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <!-- CRM SECTION -->
        <div class="nav-section-title">CRM</div>
        
        <a href="<?= base_url('/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/dashboard') ? 'active' : '' ?>" title="Dashboard">
            <i class="fa-solid fa-chart-pie"></i>
            <span class="nav-label">Dashboard</span>
        </a>

        <a href="<?= base_url('/leads') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/leads') ? 'active' : '' ?>" title="Leads">
            <i class="fa-solid fa-users"></i>
            <span class="nav-label">Leads</span>
        </a>

        <a href="<?= base_url('/pipeline') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/pipeline') ? 'active' : '' ?>" title="Pipeline">
            <i class="fa-solid fa-bars-staggered"></i>
            <span class="nav-label">Pipeline</span>
        </a>

        <!-- MANAGEMENT SECTION -->
        <div class="nav-section-title">MANAGEMENT</div>

        <a href="<?= base_url('/activities') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/activities') ? 'active' : '' ?>" title="Activities">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span class="nav-label">Activities</span>
        </a>

        <a href="<?= base_url('/notes') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/notes') ? 'active' : '' ?>" title="Notes">
            <i class="fa-solid fa-note-sticky"></i>
            <span class="nav-label">Notes</span>
        </a>

        <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
        <a href="<?= base_url('/users') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/users') ? 'active' : '' ?>" title="Users">
            <i class="fa-solid fa-user-gear"></i>
            <span class="nav-label">Users</span>
        </a>

        <a href="<?= base_url('/reports') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/reports') ? 'active' : '' ?>" title="Reports">
            <i class="fa-solid fa-chart-column"></i>
            <span class="nav-label">Reports</span>
        </a>
        <?php endif; ?>

        <!-- ADMINISTRATION SECTION -->
        <div class="nav-section-title">ADMINISTRATION</div>

        <a href="<?= base_url('/settings') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/settings') ? 'active' : '' ?>" title="Settings">
            <i class="fa-solid fa-gear"></i>
            <span class="nav-label">Settings</span>
        </a>
    </nav>

    <!-- PROFESSIONAL USER PROFILE CARD & VERSION -->
    <?php if ($currentUser): ?>
    <div class="sidebar-user-footer">
        <div class="user-card-inner">
            <div class="user-avatar-badge" style="width: 36px; height: 36px; font-size: 0.85rem;">
                <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name"><?= e($currentUser['name']) ?></div>
                <div style="display: flex; align-items: center; gap: 0.35rem; margin-top: 0.1rem;">
                    <span class="online-indicator" title="Online"></span>
                    <span class="sidebar-user-role"><?= $currentUser['role'] ?></span>
                </div>
            </div>
            <a href="<?= base_url('/logout') ?>" class="btn-ghost-sm" title="Sign Out">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
        <div class="sidebar-version-badge">CRM v1.0</div>
    </div>
    <?php endif; ?>
</aside>
