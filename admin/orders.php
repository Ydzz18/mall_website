<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config.php';
$conn = getDBConnection();

$message = '';

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['order_status'];
    
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        require_once '../includes/notifications.php';
        notifyOrderStatusChange($order_id, $new_status);
        
        // Also update shipping status if order is shipped/delivered
        if ($new_status === 'shipped') {
            $conn->query("UPDATE shipping SET status = 'shipped', shipped_date = NOW() WHERE order_id = $order_id");
        } elseif ($new_status === 'delivered') {
            $conn->query("UPDATE shipping SET status = 'delivered', actual_delivery_date = NOW() WHERE order_id = $order_id");
        }
        $message = 'Order status updated successfully!';
    }
}

// Filter orders
$filter_status = isset($_GET['status']) ? $_GET['status'] : 'all';
$where_clause = "1=1";
if ($filter_status !== 'all') {
    $where_clause = "o.order_status = '$filter_status'";
}

// Get orders
$orders = $conn->query("
    SELECT o.*, 
           c.first_name, c.last_name, c.email,
           COUNT(oi.order_item_id) as item_count
    FROM orders o
    JOIN customers c ON o.customer_id = c.customer_id
    LEFT JOIN order_items oi ON o.order_id = oi.order_id
    WHERE $where_clause
    GROUP BY o.order_id
    ORDER BY o.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Get order counts by status
$status_counts = $conn->query("
    SELECT order_status, COUNT(*) as count 
    FROM orders 
    GROUP BY order_status
")->fetch_all(MYSQLI_ASSOC);

$counts = ['all' => 0];
foreach ($status_counts as $sc) {
    $counts[$sc['order_status']] = $sc['count'];
    $counts['all'] += $sc['count'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-tab {
            padding: 10px 20px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            color: #2c3e50;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .filter-tab:hover {
            border-color: #3498db;
            background: #e3f2fd;
        }
        
        .filter-tab.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .status-select {
            padding: 8px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        
        .quick-actions {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Orders Management</h1>
                <div style="display: flex; gap: 10px;">
                    <input type="text" placeholder="Search orders..." style="padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                    <button class="btn-admin btn-primary">Search</button>
                </div>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <a href="?status=all" class="filter-tab <?php echo $filter_status === 'all' ? 'active' : ''; ?>">
                    All Orders (<?php echo $counts['all']; ?>)
                </a>
                <a href="?status=pending" class="filter-tab <?php echo $filter_status === 'pending' ? 'active' : ''; ?>">
                    Pending (<?php echo $counts['pending'] ?? 0; ?>)
                </a>
                <a href="?status=processing" class="filter-tab <?php echo $filter_status === 'processing' ? 'active' : ''; ?>">
                    Processing (<?php echo $counts['processing'] ?? 0; ?>)
                </a>
                <a href="?status=shipped" class="filter-tab <?php echo $filter_status === 'shipped' ? 'active' : ''; ?>">
                    Shipped (<?php echo $counts['shipped'] ?? 0; ?>)
                </a>
                <a href="?status=delivered" class="filter-tab <?php echo $filter_status === 'delivered' ? 'active' : ''; ?>">
                    Delivered (<?php echo $counts['delivered'] ?? 0; ?>)
                </a>
                <a href="?status=cancelled" class="filter-tab <?php echo $filter_status === 'cancelled' ? 'active' : ''; ?>">
                    Cancelled (<?php echo $counts['cancelled'] ?? 0; ?>)
                </a>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($order['order_number']); ?></strong>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?><br>
                                    <small style="color: #7f8c8d;"><?php echo htmlspecialchars($order['email']); ?></small>
                                </td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($order['created_at'])); ?><br>
                                    <small style="color: #7f8c8d;"><?php echo date('h:i A', strtotime($order['created_at'])); ?></small>
                                </td>
                                <td><?php echo $order['item_count']; ?> item(s)</td>
                                <td><strong><?php echo formatCurrency($order['total_amount']); ?></strong></td>
                                <td>
                                    <span class="status-badge status-<?php echo $order['payment_status']; ?>">
                                        <?php echo ucfirst($order['payment_status']); ?>
                                    </span><br>
                                    <small style="color: #7f8c8d;"><?php echo htmlspecialchars($order['payment_method']); ?></small>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <select name="order_status" class="status-select" onchange="this.form.submit()">
                                            <option value="pending" <?php echo $order['order_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="processing" <?php echo $order['order_status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                            <option value="shipped" <?php echo $order['order_status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                            <option value="delivered" <?php echo $order['order_status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo $order['order_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td>
                                    <div class="quick-actions">
                                        <a href="order_details.php?id=<?php echo $order['order_id']; ?>" class="btn-admin btn-primary">View</a>
                                        <a href="invoice.php?id=<?php echo $order['order_id']; ?>" class="btn-admin btn-secondary" target="_blank">Invoice</a>
                                    </div>
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