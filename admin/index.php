<?php
require_once '../config.php';

// Admin authentication check
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Get dashboard statistics
$conn = getDBConnection();

// Total revenue
$result = $conn->query("SELECT SUM(total_amount) as total_revenue FROM orders WHERE payment_status = 'completed'");
$total_revenue = $result->fetch_assoc()['total_revenue'] ?? 0;

// Total orders
$result = $conn->query("SELECT COUNT(*) as total_orders FROM orders");
$total_orders = $result->fetch_assoc()['total_orders'];

// Total customers
$result = $conn->query("SELECT COUNT(*) as total_customers FROM customers WHERE is_active = 1");
$total_customers = $result->fetch_assoc()['total_customers'];

// Total products
$result = $conn->query("SELECT COUNT(*) as total_products FROM products WHERE is_active = 1");
$total_products = $result->fetch_assoc()['total_products'];

// Pending orders
$result = $conn->query("SELECT COUNT(*) as pending_orders FROM orders WHERE order_status = 'pending'");
$pending_orders = $result->fetch_assoc()['pending_orders'];

// Low stock products
$result = $conn->query("SELECT COUNT(*) as low_stock FROM inventory WHERE quantity <= reorder_level");
$low_stock = $result->fetch_assoc()['low_stock'];

// Recent orders
$recent_orders = $conn->query("
    SELECT o.*, c.first_name, c.last_name, c.email 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.customer_id 
    ORDER BY o.created_at DESC 
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);

// Monthly revenue (last 6 months)
$monthly_revenue = $conn->query("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        SUM(total_amount) as revenue
    FROM orders 
    WHERE payment_status = 'completed' 
    AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month
")->fetch_all(MYSQLI_ASSOC);

// Top selling products
$top_products = $conn->query("
    SELECT p.product_name, SUM(oi.quantity) as total_sold, SUM(oi.subtotal) as revenue
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.payment_status = 'completed'
    GROUP BY p.product_id
    ORDER BY total_sold DESC
    LIMIT 5
")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        /* Chart Area */
        .chart-container {
            height: 300px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
            padding: 20px 0;
        }
        
        .chart-bar {
            flex: 1;
            background: linear-gradient(to top, #0284c7, #06b6d4);
            border-radius: 5px 5px 0 0;
            position: relative;
            min-height: 20px;
            transition: all 0.3s;
        }
        
        .chart-bar:hover {
            opacity: 0.8;
            transform: translateY(-5px);
        }
        
        .chart-label {
            text-align: center;
            font-size: 0.75rem;
            color: #7f8c8d;
            margin-top: 8px;
        }
        
        .chart-value {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.8rem;
            font-weight: bold;
            color: #1e293b;
        }
        
        /* Top Products List */
        .product-list {
            list-style: none;
        }
        
        .product-item {
            padding: 15px 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.4);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .product-item:last-child {
            border-bottom: none;
        }
        
        .product-name {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }
        
        .product-sales {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
        
        .product-revenue {
            font-weight: bold;
            color: #16a34a;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-logo">NCCC Admin</div>
            <nav class="admin-nav">
                <a href="index.php" class="nav-item active">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="orders.php" class="nav-item">
                    <span class="nav-icon">📦</span>
                    <span>Orders</span>
                </a>
                <a href="products.php" class="nav-item">
                    <span class="nav-icon">🛍️</span>
                    <span>Products</span>
                </a>
                <a href="customers.php" class="nav-item">
                    <span class="nav-icon">👥</span>
                    <span>Customers</span>
                </a>
                <a href="categories.php" class="nav-item">
                    <span class="nav-icon">📑</span>
                    <span>Categories</span>
                </a>
                <a href="inventory.php" class="nav-item">
                    <span class="nav-icon">📊</span>
                    <span>Inventory</span>
                </a>
                <a href="coupons.php" class="nav-item">
                    <span class="nav-icon">🎫</span>
                    <span>Coupons</span>
                </a>
                <a href="reviews.php" class="nav-item">
                    <span class="nav-icon">⭐</span>
                    <span>Reviews</span>
                </a>
                <a href="reports.php" class="nav-item">
                    <span class="nav-icon">📈</span>
                    <span>Reports</span>
                </a>
                <a href="settings.php" class="nav-item">
                    <span class="nav-icon">⚙️</span>
                    <span>Settings</span>
                </a>
                <a href="logout.php" class="nav-item">
                    <span class="nav-icon">🚪</span>
                    <span>Logout</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    <div class="user-avatar">A</div>
                    <div>
                        <div style="font-weight: 600;">Admin User</div>
                        <div style="font-size: 0.85rem; color: #7f8c8d;">Administrator</div>
                    </div>
                    <a href="logout.php" class="btn-admin btn-secondary">Logout</a>
                </div>
            </header>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-header">
                        <span class="stat-title">Total Revenue</span>
                        <span class="stat-icon">💰</span>
                    </div>
                    <div class="stat-value"><?php echo formatCurrency($total_revenue); ?></div>
                    <div class="stat-change">↑ 12.5% from last month</div>
                </div>
                
                <div class="stat-card green">
                    <div class="stat-header">
                        <span class="stat-title">Total Orders</span>
                        <span class="stat-icon">📦</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($total_orders); ?></div>
                    <div class="stat-change">↑ 8.2% from last month</div>
                </div>
                
                <div class="stat-card orange">
                    <div class="stat-header">
                        <span class="stat-title">Total Customers</span>
                        <span class="stat-icon">👥</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($total_customers); ?></div>
                    <div class="stat-change">↑ 15.3% from last month</div>
                </div>
                
                <div class="stat-card purple">
                    <div class="stat-header">
                        <span class="stat-title">Total Products</span>
                        <span class="stat-icon">🛍️</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($total_products); ?></div>
                    <div class="stat-change">↑ 5 new this month</div>
                </div>
                
                <div class="stat-card red">
                    <div class="stat-header">
                        <span class="stat-title">Pending Orders</span>
                        <span class="stat-icon">⏳</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($pending_orders); ?></div>
                    <div class="stat-change" style="color: #e74c3c;">Requires attention</div>
                </div>
                
                <div class="stat-card orange">
                    <div class="stat-header">
                        <span class="stat-title">Low Stock Items</span>
                        <span class="stat-icon">⚠️</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($low_stock); ?></div>
                    <div class="stat-change" style="color: #f39c12;">Needs restocking</div>
                </div>
            </div>
            
            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Monthly Revenue Chart -->
                <div class="content-card">
                    <h2>Revenue Overview (Last 6 Months)</h2>
                    <div class="chart-container">
                        <?php 
                        $max_revenue = max(array_column($monthly_revenue, 'revenue') ?: [1]);
                        foreach ($monthly_revenue as $data): 
                            $height = ($data['revenue'] / $max_revenue) * 100;
                        ?>
                            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                                <div class="chart-bar" style="height: <?php echo $height; ?>%;">
                                    <span class="chart-value"><?php echo formatCurrency($data['revenue'], 0); ?></span>
                                </div>
                                <div class="chart-label"><?php echo date('M', strtotime($data['month'] . '-01')); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Top Products -->
                <div class="content-card">
                    <h2>Top Selling Products</h2>
                    <ul class="product-list">
                        <?php foreach ($top_products as $product): ?>
                            <li class="product-item">
                                <div>
                                    <div class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></div>
                                    <div class="product-sales"><?php echo $product['total_sold']; ?> units sold</div>
                                </div>
                                <div class="product-revenue"><?php echo formatCurrency($product['revenue']); ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="content-card">
                <h2>Recent Orders</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($order['order_number']); ?></strong></td>
                                <td>
                                    <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?><br>
                                    <small style="color: #7f8c8d;"><?php echo htmlspecialchars($order['email']); ?></small>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                <td><strong><?php echo formatCurrency($order['total_amount']); ?></strong></td>
                                <td>
                                    <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                        <?php echo ucfirst($order['order_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_details.php?id=<?php echo $order['order_id']; ?>" class="btn-admin btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>