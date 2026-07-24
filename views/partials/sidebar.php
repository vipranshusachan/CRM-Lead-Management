<?php $currentUser = \App\Core\Auth::user(); ?>
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-badge">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <span class="logo-title">LeadFlow CRM</span>
        <button type="button" class="sidebar-collapse-btn" id="sidebarCollapseBtn" title="Toggle Sidebar">
            <i class="fa-solid fa-angles-left"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">CORE PIPELINE</div>
        
        <a href="<?= base_url('/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/dashboard') ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= base_url('/leads') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/leads') ? 'active' : '' ?>">
            <i class="fa-solid fa-users-between-lines"></i>
            <span>Leads Database</span>
        </a>

        <a href="<?= base_url('/pipeline') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/pipeline') ? 'active' : '' ?>">
            <i class="fa-solid fa-bars-staggered"></i>
            <span>Kanban Pipeline</span>
        </a>

        <div class="nav-section-title">TECHNICAL & AUDIT</div>

        <a href="<?= base_url('/activities') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/activities') ? 'active' : '' ?>">
            <i class="fa-solid fa-code-commit"></i>
            <span>Technical Audit Trail</span>
        </a>

        <a href="<?= base_url('/notes') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/notes') ? 'active' : '' ?>">
            <i class="fa-solid fa-terminal"></i>
            <span>System Logs & Notes</span>
        </a>

        <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
        <a href="<?= base_url('/users') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/users') ? 'active' : '' ?>">
            <i class="fa-solid fa-user-gear"></i>
            <span>User Management</span>
        </a>

        <a href="<?= base_url('/reports') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/reports') ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-column"></i>
            <span>Performance Reports</span>
        </a>
        <?php endif; ?>

        <div class="nav-section-title">SYSTEM CONFIG</div>

        <a href="<?= base_url('/settings') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/settings') ? 'active' : '' ?>">
            <i class="fa-solid fa-sliders"></i>
            <span>System Settings</span>
        </a>
    </nav>

    <?php if ($currentUser): ?>
    <div class="sidebar-user-footer">
        <div class="user-avatar-badge" style="width: 34px; height: 34px; font-size: 0.85rem;">
            <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name"><?= e($currentUser['name']) ?></div>
            <div class="sidebar-user-role"><?= $currentUser['role'] ?></div>
        </div>
        <a href="<?= base_url('/logout') ?>" class="btn-ghost-sm" title="Sign Out">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </div>
    <?php endif; ?>
</aside>
