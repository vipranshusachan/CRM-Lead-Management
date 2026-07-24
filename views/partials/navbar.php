<?php $currentUser = \App\Core\Auth::user(); ?>
<nav class="top-navbar">
    <!-- LEFT: Sidebar Toggle & Breadcrumb -->
    <div class="navbar-left">
        <button type="button" class="menu-toggle-btn" id="menuToggleBtn" title="Toggle Navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="breadcrumb-container">
            <span class="breadcrumb-current"><?= e($title ?? 'Dashboard') ?></span>
        </div>
    </div>

    <!-- CENTER: Large Global Search Bar (420px min) -->
    <div class="global-search-trigger" id="globalSearchTrigger" title="Press Ctrl+K to Search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <span class="search-placeholder">Search Leads, Companies, Users...</span>
        <kbd class="search-kbd">Ctrl K</kbd>
    </div>

    <!-- RIGHT: Quick Add, Notifications, Theme Toggle, Profile Menu -->
    <div class="user-nav-group">
        <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
            <a href="<?= base_url('/leads/create') ?>" class="btn btn-primary btn-nav-action" title="Quick Add Lead">
                <i class="fa-solid fa-plus"></i>
                <span>Add Lead</span>
            </a>
        <?php endif; ?>

        <!-- Notification Bell Dropdown -->
        <div class="nav-dropdown-wrapper">
            <button type="button" class="nav-icon-btn" id="notificationsBtn" title="Notifications">
                <i class="fa-regular fa-bell"></i>
                <span class="notification-badge"></span>
            </button>
            <div class="nav-dropdown-menu notification-menu" id="notificationDropdown">
                <div class="dropdown-header">
                    <span>Notifications</span>
                    <a href="#" class="mark-all-read">Mark all read</a>
                </div>
                <div class="dropdown-list">
                    <div class="dropdown-item">
                        <i class="fa-solid fa-circle-check text-success"></i>
                        <div>
                            <div class="dropdown-item-title">New Lead Assigned</div>
                            <div class="dropdown-item-sub">Acme Corp Deal was assigned to you.</div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <i class="fa-solid fa-circle-info text-primary"></i>
                        <div>
                            <div class="dropdown-item-title">Status Updated</div>
                            <div class="dropdown-item-sub">TechSolutions Inc changed to Qualified.</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-footer">
                    <a href="<?= base_url('/activities') ?>">View All Activities &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Theme Toggle Button -->
        <button type="button" class="nav-icon-btn" id="themeToggleBtn" title="Toggle Theme">
            <i class="fa-regular fa-moon"></i>
        </button>

        <!-- Profile Dropdown Menu -->
        <?php if ($currentUser): ?>
            <div class="nav-dropdown-wrapper">
                <button type="button" class="user-avatar-btn" id="userProfileBtn">
                    <div class="user-avatar-badge">
                        <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
                    </div>
                </button>
                <div class="nav-dropdown-menu profile-menu" id="profileDropdown">
                    <div class="profile-menu-header">
                        <div class="profile-name"><?= e($currentUser['name']) ?></div>
                        <div class="profile-email"><?= e($currentUser['email']) ?></div>
                        <span class="badge-role <?= $currentUser['role'] === 'ADMIN' ? 'badge-admin' : 'badge-member' ?>" style="margin-top: 0.35rem; display: inline-block;">
                            <?= $currentUser['role'] ?>
                        </span>
                    </div>
                    <div class="profile-menu-divider"></div>
                    <a href="<?= base_url('/settings') ?>" class="profile-menu-item"><i class="fa-regular fa-user"></i> Profile</a>
                    <a href="<?= base_url('/settings') ?>" class="profile-menu-item"><i class="fa-solid fa-gear"></i> Settings</a>
                    <a href="<?= base_url('/logout') ?>" class="profile-menu-item text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>

<!-- Global Search Modal (Ctrl+K) -->
<div id="searchModal" class="modal-overlay">
    <div class="modal-card search-modal-card">
        <div class="search-input-header">
            <i class="fa-solid fa-magnifying-glass search-modal-icon"></i>
            <input type="text" id="globalSearchInput" placeholder="Search Leads, Companies, Users..." autofocus>
            <button type="button" onclick="closeModal('searchModal')" class="search-modal-close">&times;</button>
        </div>
        <div class="search-results-list" id="globalSearchResults">
            <div class="search-category-label">Quick Links</div>
            <a href="<?= base_url('/leads') ?>" class="search-result-item">
                <i class="fa-solid fa-users"></i>
                <div>
                    <div class="search-result-title">Leads Database</div>
                    <div class="search-result-sub">Search active deals & leads</div>
                </div>
            </a>
            <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
            <a href="<?= base_url('/users') ?>" class="search-result-item">
                <i class="fa-solid fa-user-gear"></i>
                <div>
                    <div class="search-result-title">Team Users</div>
                    <div class="search-result-sub">Manage team access & roles</div>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
