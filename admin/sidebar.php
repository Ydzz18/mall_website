<aside class="admin-sidebar">
    <div class="admin-logo">NCCC Admin</div>
    <nav class="admin-nav">
        <a href="index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📊</span>
            <span>Dashboard</span>
        </a>
        <a href="orders.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📦</span>
            <span>Orders</span>
        </a>
        <a href="products.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🛍️</span>
            <span>Products</span>
        </a>
        <a href="customers.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : ''; ?>">
            <span class="nav-icon">👥</span>
            <span>Customers</span>
        </a>
        <a href="categories.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📑</span>
            <span>Categories</span>
        </a>
        <a href="inventory.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'inventory.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📊</span>
            <span>Inventory</span>
        </a>
        <a href="coupons.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'coupons.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🎫</span>
            <span>Coupons</span>
        </a>
        <a href="reviews.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'reviews.php' ? 'active' : ''; ?>">
            <span class="nav-icon">⭐</span>
            <span>Reviews</span>
        </a>
        <a href="reports.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'reports.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📈</span>
            <span>Reports</span>
        </a>
        <a href="settings.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>">
            <span class="nav-icon">⚙️</span>
            <span>Settings</span>
        </a>
        <a href="logout.php" class="nav-item">
            <span class="nav-icon">🚪</span>
            <span>Logout</span>
        </a>
    </nav>
</aside>