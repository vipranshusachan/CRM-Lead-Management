document.addEventListener('DOMContentLoaded', () => {
    // 1. Theme Toggle
    const themeBtn = document.getElementById('themeToggleBtn');
    const storedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', storedTheme);

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', nextTheme);
            localStorage.setItem('theme', nextTheme);
        });
    }

    // 2. Mobile Sidebar Drawer & Desktop Collapse Toggle
    const menuToggleBtn = document.getElementById('menuToggleBtn');
    const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-open');
        });
    }

    if (sidebarCollapseBtn && sidebar && mainContent) {
        sidebarCollapseBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // 3. Global Search (Ctrl + K) Keyboard Shortcut
    const globalSearchTrigger = document.getElementById('globalSearchTrigger');
    const searchModal = document.getElementById('searchModal');
    const globalSearchInput = document.getElementById('globalSearchInput');

    if (globalSearchTrigger) {
        globalSearchTrigger.addEventListener('click', () => {
            openModal('searchModal');
            if (globalSearchInput) globalSearchInput.focus();
        });
    }

    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openModal('searchModal');
            if (globalSearchInput) globalSearchInput.focus();
        }
        if (e.key === 'Escape') {
            closeModal('searchModal');
            closeDropdowns();
        }
    });

    // 4. Dropdowns (Notifications & Profile)
    const notificationsBtn = document.getElementById('notificationsBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const userProfileBtn = document.getElementById('userProfileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    function closeDropdowns() {
        if (notificationDropdown) notificationDropdown.classList.remove('show');
        if (profileDropdown) profileDropdown.classList.remove('show');
    }

    if (notificationsBtn && notificationDropdown) {
        notificationsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (profileDropdown) profileDropdown.classList.remove('show');
            notificationDropdown.classList.toggle('show');
        });
    }

    if (userProfileBtn && profileDropdown) {
        userProfileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (notificationDropdown) notificationDropdown.classList.remove('show');
            profileDropdown.classList.toggle('show');
        });
    }

    document.addEventListener('click', () => {
        closeDropdowns();
    });

    // 5. Quick-Fill Demo Credentials (on Login Page)
    window.fillCredentials = function(email, password) {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        if (emailInput && passwordInput) {
            emailInput.value = email;
            passwordInput.value = password;
            showToast(`Filled credentials for ${email}`);
        }
    };

    // 6. Modal Handlers
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
        }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    };

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    });

    // 7. Toast Notifications
    window.showToast = function(message) {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `<i class="fa-solid fa-circle-check" style="color: var(--color-primary);"></i> <span>${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3500);
    };
});
