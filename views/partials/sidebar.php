<?php $currentUser = \App\Core\Auth::user(); ?>
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-badge">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <span class="logo-title">LeadFlow CRM</span>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= base_url('/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/dashboard') || $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= base_url('/leads') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/leads') ? 'active' : '' ?>">
            <i class="fa-solid fa-users-between-lines"></i>
            <span>Leads</span>
        </a>
        <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
        <a href="<?= base_url('/users') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/users') ? 'active' : '' ?>">
            <i class="fa-solid fa-user-gear"></i>
            <span>Team Users</span>
        </a>
        <?php endif; ?>
    </nav>
</aside>
