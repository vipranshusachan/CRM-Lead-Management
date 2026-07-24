<?php $currentUser = \App\Core\Auth::user(); ?>
<nav class="top-navbar">
    <div class="navbar-left">
        <button type="button" class="menu-toggle-btn" id="menuToggleBtn" title="Toggle Navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Breadcrumbs & Title -->
        <div class="breadcrumb-container">
            <span class="breadcrumb-root">CRM</span>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-current"><?= e($title ?? 'Dashboard') ?></span>
        </div>
    </div>

    <!-- Global Search Input Trigger (Ctrl+K) -->
    <div class="global-search-trigger" id="globalSearchTrigger" title="Press Ctrl+K to Search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span>Search leads, users, companies...</span>
        <kbd>Ctrl K</kbd>
    </div>

    <div class="user-nav-group">
        <!-- Quick Add Lead Button -->
        <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
            <a href="<?= base_url('/leads/create') ?>" class="btn btn-primary btn-sm" title="Quick Add Lead">
                <i class="fa-solid fa-plus"></i>
                <span>Add Lead</span>
            </a>
        <?php endif; ?>

        <!-- Notification Bell Dropdown Trigger -->
        <div class="nav-dropdown-wrapper">
            <button type="button" class="nav-icon-btn" id="notificationsBtn" title="Notifications">
                <i class="fa-solid fa-bell"></i>
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
            </div>
        </div>

        <!-- Theme Toggle Button -->
        <button type="button" class="nav-icon-btn" id="themeToggleBtn" title="Toggle Light/Dark Theme">
            <i class="fa-solid fa-moon"></i>
        </button>

        <!-- User Profile Dropdown -->
        <?php if ($currentUser): ?>
            <div class="nav-dropdown-wrapper">
                <button type="button" class="user-avatar-btn" id="userProfileBtn">
                    <div class="user-avatar-badge">
                        <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
                    </div>
                </button>
                <div class="nav-dropdown-menu profile-menu" id="profileDropdown">
                    <div class="profile-menu-header">
                        <strong><?= e($currentUser['name']) ?></strong>
                        <div class="text-muted" style="font-size: 0.75rem;"><?= e($currentUser['email']) ?></div>
                    </div>
                    <div class="profile-menu-divider"></div>
                    <a href="<?= base_url('/settings') ?>" class="profile-menu-item"><i class="fa-solid fa-gear"></i> Settings</a>
                    <a href="<?= base_url('/logout') ?>" class="profile-menu-item text-danger"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
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
            <input type="text" id="globalSearchInput" placeholder="Type to search leads, companies, contacts..." autofocus>
            <button type="button" onclick="closeModal('searchModal')" class="search-modal-close">&times;</button>
        </div>
        <div class="search-results-list" id="globalSearchResults">
            <div class="search-category-label">Quick Suggestions</div>
            <a href="<?= base_url('/leads') ?>" class="search-result-item">
                <i class="fa-solid fa-users"></i>
                <div>
                    <div class="search-result-title">View All Leads</div>
                    <div class="search-result-sub">Search through active pipeline leads</div>
                </div>
            </a>
            <?php if ($currentUser && $currentUser['role'] === 'ADMIN'): ?>
            <a href="<?= base_url('/users') ?>" class="search-result-item">
                <i class="fa-solid fa-user-gear"></i>
                <div>
                    <div class="search-result-title">Team Users</div>
                    <div class="search-result-sub">Manage team members and permissions</div>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
