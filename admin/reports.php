<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();

// Date range filter
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Sales Report
$sales_report = $conn->query("
    SELECT 
        DATE(created_at) as date,
        COUNT(*) as total_orders,
        SUM(total_amount) as revenue,
        SUM(tax_amount) as tax,
        SUM(shipping_cost) as shipping,
        AVG(total_amount) as avg_order_value
    FROM orders
    WHERE created_at BETWEEN '$start_date' AND '$end_date 23:59:59'
    AND payment_status = 'completed'
    GROUP BY DATE(created_at)
    ORDER BY date DESC
")->fetch_all(MYSQLI_ASSOC);

// Calculate totals
$total_revenue = array_sum(array_column($sales_report, 'revenue'));
$total_orders = array_sum(array_column($sales_report, 'total_orders'));
$avg_order_value = $total_orders > 0 ? $total_revenue / $total_orders : 0;

// Top products
$top_products = $conn->query("
    SELECT p.product_name, p.sku, c.category_name,
           SUM(oi.quantity) as units_sold,
           SUM(oi.subtotal) as revenue
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.created_at BETWEEN '$start_date' AND '$end_date 23:59:59'
    AND o.payment_status = 'completed'
    GROUP BY oi.product_id
    ORDER BY revenue DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);

// Sales by category
$category_sales = $conn->query("
    SELECT c.category_name,
           COUNT(DISTINCT oi.order_id) as orders,
           SUM(oi.quantity) as units_sold,
           SUM(oi.subtotal) as revenue
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.created_at BETWEEN '$start_date' AND '$end_date 23:59:59'
    AND o.payment_status = 'completed'
    GROUP BY c.category_id
    ORDER BY revenue DESC
")->fetch_all(MYSQLI_ASSOC);

// Top customers
$top_customers = $conn->query("
    SELECT c.first_name, c.last_name, c.email,
           COUNT(o.order_id) as total_orders,
           SUM(o.total_amount) as total_spent,
           AVG(o.total_amount) as avg_order_value
    FROM customers c
    JOIN orders o ON c.customer_id = o.customer_id
    WHERE o.created_at BETWEEN '$start_date' AND '$end_date 23:59:59'
    AND o.payment_status = 'completed'
    GROUP BY c.customer_id
    ORDER BY total_spent DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);

// Payment methods distribution
$payment_methods = $conn->query("
    SELECT payment_method,
           COUNT(*) as count,
           SUM(total_amount) as revenue
    FROM orders
    WHERE created_at BETWEEN '$start_date' AND '$end_date 23:59:59'
    AND payment_status = 'completed'
    GROUP BY payment_method
    ORDER BY revenue DESC
")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .date-filter {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: end;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .date-filter .form-group {
            flex: 1;
            margin: 0;
        }
        
        .date-filter label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .date-filter input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .progress-bar {
            background: #f0f0f0;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }
        
        .export-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        @media print {
            .admin-sidebar, .admin-header, .date-filter, .export-buttons {
                display: none !important;
            }
            
            .admin-main {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Sales Reports & Analytics</h1>
            </header>
            
            <!-- Date Filter -->
            <form method="GET" class="date-filter">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
                </div>
                <button type="submit" class="btn-admin btn-primary">Generate Report</button>
                <button type="button" onclick="window.print()" class="btn-admin btn-secondary">Print Report</button>
            </form>
            
            <!-- Summary Stats -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-title">Total Revenue</div>
                    <div class="stat-value"><?php echo formatCurrency($total_revenue); ?></div>
                </div>
                <div class="stat-card green">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-value"><?php echo number_format($total_orders); ?></div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-title">Average Order Value</div>
                    <div class="stat-value"><?php echo formatCurrency($avg_order_value); ?></div>
                </div>
            </div>
            
            <!-- Daily Sales -->
            <div class="content-card" style="margin-bottom: 30px;">
                <h2>Daily Sales Report</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                            <th>Tax</th>
                            <th>Shipping</th>
                            <th>Avg Order Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales_report as $day): ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($day['date'])); ?></td>
                                <td><strong><?php echo number_format($day['total_orders']); ?></strong></td>
                                <td><strong style="color: #27ae60;"><?php echo formatCurrency($day['revenue']); ?></strong></td>
                                <td><?php echo formatCurrency($day['tax']); ?></td>
                                <td><?php echo formatCurrency($day['shipping']); ?></td>
                                <td><?php echo formatCurrency($day['avg_order_value']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="report-grid">
                <!-- Top Products -->
                <div class="chart-container">
                    <div class="chart-title">Top 10 Products</div>
                    <?php foreach ($top_products as $product): 
                        $max_revenue = max(array_column($top_products, 'revenue'));
                        $percentage = ($product['revenue'] / $max_revenue) * 100;
                    ?>
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-weight: 600; color: #2c3e50;"><?php echo htmlspecialchars($product['product_name']); ?></span>
                                <span style="color: #27ae60; font-weight: bold;"><?php echo formatCurrency($product['revenue']); ?></span>
                            </div>
                            <div style="font-size: 0.85rem; color: #7f8c8d; margin-bottom: 5px;">
                                <?php echo number_format($product['units_sold']); ?> units sold
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $percentage; ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Sales by Category -->
                <div class="chart-container">
                    <div class="chart-title">Sales by Category</div>
                    <?php foreach ($category_sales as $cat): 
                        $max_revenue = max(array_column($category_sales, 'revenue'));
                        $percentage = ($cat['revenue'] / $max_revenue) * 100;
                    ?>
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-weight: 600; color: #2c3e50;"><?php echo htmlspecialchars($cat['category_name']); ?></span>
                                <span style="color: #27ae60; font-weight: bold;"><?php echo formatCurrency($cat['revenue']); ?></span>
                            </div>
                            <div style="font-size: 0.85rem; color: #7f8c8d; margin-bottom: 5px;">
                                <?php echo number_format($cat['units_sold']); ?> units • <?php echo number_format($cat['orders']); ?> orders
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $percentage; ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Top Customers -->
            <div class="content-card" style="margin-bottom: 30px;">
                <h2>Top 10 Customers</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Avg Order Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($top_customers as $customer): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo number_format($customer['total_orders']); ?></td>
                                <td><strong style="color: #27ae60;"><?php echo formatCurrency($customer['total_spent']); ?></strong></td>
                                <td><?php echo formatCurrency($customer['avg_order_value']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Payment Methods -->
            <div class="chart-container">
                <div class="chart-title">Payment Methods Distribution</div>
                <?php foreach ($payment_methods as $method): 
                    $max_revenue = max(array_column($payment_methods, 'revenue'));
                    $percentage = ($method['revenue'] / $max_revenue) * 100;
                ?>
                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="font-weight: 600; color: #2c3e50;"><?php echo htmlspecialchars($method['payment_method']); ?></span>
                            <span style="color: #27ae60; font-weight: bold;"><?php echo formatCurrency($method['revenue']); ?></span>
                        </div>
                        <div style="font-size: 0.85rem; color: #7f8c8d; margin-bottom: 5px;">
                            <?php echo number_format($method['count']); ?> transactions
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $percentage; ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>