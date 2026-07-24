<?php $currentUser = \App\Core\Auth::user(); ?>
<nav class="top-navbar">
    <div class="navbar-left">
        <button type="button" class="menu-toggle-btn" id="menuToggleBtn" title="Toggle Navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <span style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary);">
            Lead Management CRM
        </span>
    </div>
    <div class="user-nav-group">
        <button type="button" class="btn btn-secondary" id="themeToggleBtn" style="padding: 0.4rem 0.75rem; font-size: 0.8rem;">
            <i class="fa-solid fa-moon"></i>
            <span>Theme</span>
        </button>
        <?php if ($currentUser): ?>
            <div class="user-avatar-badge">
                <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
            </div>
            <div style="display: flex; flex-direction: column; line-height: 1.2;">
                <span style="font-weight: 600; font-size: 0.875rem; color: var(--text-primary);"><?= e($currentUser['name']) ?></span>
                <span class="badge-role <?= $currentUser['role'] === 'ADMIN' ? 'badge-admin' : 'badge-member' ?>" style="width: fit-content; margin-top: 0.15rem;">
                    <?= $currentUser['role'] ?>
                </span>
            </div>
            <a href="<?= base_url('/logout') ?>" class="btn btn-ghost" style="padding: 0.4rem 0.75rem; font-size: 0.85rem;" title="Sign Out">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        <?php endif; ?>
    </div>
</nav>
