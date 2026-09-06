<?php $sidebar_auto_hide = (getSetting('admin_sidebar_auto_hide', '0') == '1' || getSetting('admin_sidebar_auto_hide', '0') === 1); ?>
<button class="mobile-menu-toggle" id="mobileMenuToggle">
    <span id="menuIcon">☰</span>
</button>

<aside class="admin-sidebar<?php echo $sidebar_auto_hide ? ' auto-hide' : ''; ?>" id="adminSidebar" data-auto-hide="<?php echo $sidebar_auto_hide ? '1' : '0'; ?>">
    <div class="admin-logo">Admin</div>
    <nav class="admin-nav">
        <?php if (hasAdminPermission(RoleManager::PERMISSION_VIEW_DASHBOARD)): ?>
        <a href="index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📊</span>
            <span class="nav-label">Dashboard</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_ORDERS)): ?>
        <a href="orders.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📦</span>
            <span class="nav-label">Orders</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_DELIVERIES)): ?>
        <a href="deliveries.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'deliveries.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🚚</span>
            <span class="nav-label">Deliveries</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_RIDERS)): ?>
        <a href="riders.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'riders.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🏍️</span>
            <span class="nav-label">Riders</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_PRODUCTS)): ?>
        <a href="products.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🛍️</span>
            <span class="nav-label">Products</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_CUSTOMERS)): ?>
        <a href="customers.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : ''; ?>">
            <span class="nav-icon">👥</span>
            <span class="nav-label">Customers</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_CATEGORIES)): ?>
        <a href="categories.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📑</span>
            <span class="nav-label">Categories</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_INVENTORY)): ?>
        <a href="inventory.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'inventory.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📊</span>
            <span class="nav-label">Inventory</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_COUPONS)): ?>
        <a href="coupons.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'coupons.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🎫</span>
            <span class="nav-label">Coupons</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_REVIEWS)): ?>
        <a href="reviews.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'reviews.php' ? 'active' : ''; ?>">
            <span class="nav-icon">⭐</span>
            <span class="nav-label">Reviews</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_VIEW_REPORTS)): ?>
        <a href="reports.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'reports.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📈</span>
            <span class="nav-label">Reports</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_SETTINGS)): ?>
        <a href="settings.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>">
            <span class="nav-icon">⚙️</span>
            <span class="nav-label">Settings</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_RIDERS)): ?>
        <a href="setup_riders.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'setup_riders.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🔧</span>
            <span class="nav-label">Rider Setup</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_VIEW_ACTIVITY_LOGS)): ?>
        <a href="activity_logs.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'activity_logs.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📋</span>
            <span class="nav-label">Activity Logs</span>
        </a>
        <?php endif; ?>
        
        <?php if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_ADMINS)): ?>
        <a href="super_admin.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'super_admin.php' ? 'active' : ''; ?>">
            <span class="nav-icon">👑</span>
            <span class="nav-label">Admin Management</span>
        </a>
        <?php endif; ?>
        
        <a href="logout.php" class="nav-item">
            <span class="nav-icon">🚪</span>
            <span class="nav-label">Logout</span>
        </a>
    </nav>
</aside>

<div class="mobile-overlay" id="mobileOverlay"></div>

<script>
(function() {
    function initMobileMenu() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const menuIcon = document.getElementById('menuIcon');
        const autoHideEnabled = adminSidebar && adminSidebar.dataset.autoHide === '1';
        
        if (!mobileMenuToggle || !adminSidebar || !mobileOverlay) {
            console.error('Mobile menu elements not found');
            return;
        }

        if (autoHideEnabled && window.innerWidth > 968) {
            adminSidebar.addEventListener('mouseenter', function() {
                adminSidebar.classList.add('expanded');
            });

            adminSidebar.addEventListener('mouseleave', function() {
                adminSidebar.classList.remove('expanded');
            });
        }
        
        function toggleMenu(e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = adminSidebar.classList.contains('open');
            
            if (isOpen) {
                adminSidebar.classList.remove('open');
                mobileOverlay.classList.remove('active');
                menuIcon.textContent = '☰';
            } else {
                adminSidebar.classList.add('open');
                mobileOverlay.classList.add('active');
                menuIcon.textContent = '✕';
            }
        }
        
        function closeMenu() {
            adminSidebar.classList.remove('open');
            mobileOverlay.classList.remove('active');
            menuIcon.textContent = '☰';
        }
        
        mobileMenuToggle.addEventListener('click', toggleMenu, false);
        mobileOverlay.addEventListener('click', closeMenu, false);
        
        const navItems = adminSidebar.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                closeMenu();
            }, false);
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 968) {
                closeMenu();
                if (autoHideEnabled) {
                    adminSidebar.classList.remove('expanded');
                }
            }
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileMenu);
    } else {
        initMobileMenu();
    }
})();
</script>