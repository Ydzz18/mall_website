<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config.php';

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_ORDERS)) {
    header('Location: index.php');
    exit;
}
$conn = getDBConnection();

$message = '';
$error = '';

// Handle bulk status updates
if (isset($_POST['bulk_update']) && isset($_POST['selected_orders'])) {
    $selected_orders = $_POST['selected_orders'];
    $new_status = $_POST['bulk_status'];
    
    foreach ($selected_orders as $order_id) {
        $order_id = intval($order_id);
        
        $stmt = $conn->prepare("SELECT order_number, order_status FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order_result = $stmt->get_result()->fetch_assoc();
        $old_status = $order_result['order_status'];
        $order_number = $order_result['order_number'];
        
        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'order_update',
            "Order status updated: $order_number from '$old_status' to '$new_status'",
            'orders',
            $order_id,
            ['order_status' => $old_status],
            ['order_status' => $new_status]
        );
    }
    
    $message = count($selected_orders) . ' order(s) updated successfully!';
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Build query
$where_clauses = ["o.order_id IS NOT NULL"];
$params = [];
$types = '';

if ($status_filter) {
    $where_clauses[] = "o.order_status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

if ($search) {
    $where_clauses[] = "(o.order_number LIKE ? OR c.first_name LIKE ? OR c.last_name LIKE ? OR c.email LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'ssss';
}

if ($date_from) {
    $where_clauses[] = "DATE(o.created_at) >= ?";
    $params[] = $date_from;
    $types .= 's';
}

if ($date_to) {
    $where_clauses[] = "DATE(o.created_at) <= ?";
    $params[] = $date_to;
    $types .= 's';
}

$where_sql = implode(' AND ', $where_clauses);

// Get orders with pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Count total orders
$count_query = "SELECT COUNT(*) as total FROM orders o 
                JOIN customers c ON o.customer_id = c.customer_id 
                WHERE $where_sql";
$count_stmt = $conn->prepare($count_query);
if ($types) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_orders = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $per_page);

// Get orders
$query = "SELECT o.*, 
          c.first_name, c.last_name, c.email,
          (SELECT COUNT(*) FROM order_items WHERE order_id = o.order_id) as item_count
          FROM orders o
          JOIN customers c ON o.customer_id = c.customer_id
          WHERE $where_sql
          ORDER BY o.created_at DESC
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
$params[] = $per_page;
$params[] = $offset;
$types .= 'ii';
$stmt->bind_param($types, ...$params);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get order statistics
$stats = $conn->query("
    SELECT 
        COUNT(*) as total_orders,
        SUM(CASE WHEN order_status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
        SUM(CASE WHEN order_status = 'processing' THEN 1 ELSE 0 END) as processing_orders,
        SUM(CASE WHEN order_status = 'shipped' THEN 1 ELSE 0 END) as shipped_orders,
        SUM(CASE WHEN order_status = 'delivered' THEN 1 ELSE 0 END) as delivered_orders,
        SUM(CASE WHEN payment_status = 'pending' THEN 1 ELSE 0 END) as pending_payments,
        SUM(total_amount) as total_revenue,
        SUM(CASE WHEN DATE(created_at) = CURDATE() THEN total_amount ELSE 0 END) as today_revenue
    FROM orders
")->fetch_assoc();

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
        
        .filter-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #1e293b;
            font-size: 0.9rem;
        }
        
        .filter-group input,
        .filter-group select {
            padding: 10px 12px;
            border: 2px solid rgba(226, 232, 240, 0.6);
            border-radius: 8px;
            font-size: 0.95rem;
        }
        
        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .bulk-actions {
            background: rgba(226, 232, 240, 0.2);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: none;
            align-items: center;
            gap: 15px;
        }
        
        .bulk-actions.active {
            display: flex;
        }
        
        .order-number {
            font-weight: 700;
            color: #5b21b6;
        }
        
        .customer-info {
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
        }
        
        .pagination a,
        .pagination span {
            padding: 8px 15px;
            border: 2px solid rgba(226, 232, 240, 0.6);
            border-radius: 8px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
        }
        
        .pagination a:hover {
            background: rgba(91, 33, 182, 0.1);
            border-color: #5b21b6;
        }
        
        .pagination .active {
            background: linear-gradient(135deg, #5b21b6, #06b6d4);
            color: white;
            border-color: transparent;
        }
        
        .checkbox-cell {
            width: 40px;
            text-align: center;
        }
        
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Orders Management</h1>
                <div class="admin-user">
                    <span>Admin</span>
                </div>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-header">
                        <span class="stat-title">Total Orders</span>
                        <span class="stat-icon">📦</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['total_orders']); ?></div>
                </div>
                
                <div class="stat-card orange">
                    <div class="stat-header">
                        <span class="stat-title">Pending Orders</span>
                        <span class="stat-icon">⏳</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['pending_orders']); ?></div>
                </div>
                
                <div class="stat-card purple">
                    <div class="stat-header">
                        <span class="stat-title">Processing</span>
                        <span class="stat-icon">⚙️</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['processing_orders']); ?></div>
                </div>
                
                <div class="stat-card green">
                    <div class="stat-header">
                        <span class="stat-title">Total Revenue</span>
                        <span class="stat-icon">💰</span>
                    </div>
                    <div class="stat-value"><?php echo formatCurrency($stats['total_revenue']); ?></div>
                    <div class="stat-change">Today: <?php echo formatCurrency($stats['today_revenue']); ?></div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="filter-section">
                <form method="GET" action="orders.php">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label>Order Status</label>
                            <select name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="processing" <?php echo $status_filter === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="shipped" <?php echo $status_filter === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="delivered" <?php echo $status_filter === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="cancelled" <?php echo $status_filter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label>Search</label>
                            <input type="text" name="search" placeholder="Order #, customer name, email..." 
                                   value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label>Date From</label>
                            <input type="date" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label>Date To</label>
                            <input type="date" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
                        </div>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn-admin btn-primary">Apply Filters</button>
                        <a href="orders.php" class="btn-admin btn-secondary">Clear Filters</a>
                    </div>
                </form>
            </div>
            
            <!-- Bulk Actions -->
            <form method="POST" id="bulkForm">
                <div class="bulk-actions" id="bulkActions">
                    <span id="selectedCount">0 selected</span>
                    <select name="bulk_status" required>
                        <option value="">Change Status To...</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button type="submit" name="bulk_update" class="btn-admin btn-primary">Update Selected</button>
                    <button type="button" class="btn-admin btn-secondary" onclick="clearSelection()">Clear</button>
                </div>
                
                <!-- Orders Table -->
                <div class="content-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($orders) > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="checkbox-cell">
                                            <input type="checkbox" name="selected_orders[]" 
                                                   value="<?php echo $order['order_id']; ?>" 
                                                   class="order-checkbox" onchange="updateBulkActions()">
                                        </td>
                                        <td>
                                            <a href="order_details.php?id=<?php echo $order['order_id']; ?>" 
                                               class="order-number">
                                                #<?php echo htmlspecialchars($order['order_number']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></strong><br>
                                            <span class="customer-info"><?php echo htmlspecialchars($order['email']); ?></span>
                                        </td>
                                        <td><?php echo $order['item_count']; ?> item(s)</td>
                                        <td><strong><?php echo formatCurrency($order['total_amount']); ?></strong></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $order['payment_status']; ?>">
                                                <?php echo ucfirst($order['payment_status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                                <?php echo ucfirst($order['order_status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                        <td>
                                            <a href="order_details.php?id=<?php echo $order['order_id']; ?>" 
                                               class="btn-admin btn-primary" style="font-size: 0.85rem; padding: 6px 12px;">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px; color: #7f8c8d;">
                                        No orders found matching your criteria.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&status=<?php echo $status_filter; ?>&search=<?php echo urlencode($search); ?>&date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?>">
                            ← Previous
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="active"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>&search=<?php echo urlencode($search); ?>&date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&status=<?php echo $status_filter; ?>&search=<?php echo urlencode($search); ?>&date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?>">
                            Next →
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
    
    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateBulkActions();
        }
        
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.order-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (checkboxes.length > 0) {
                bulkActions.classList.add('active');
                selectedCount.textContent = checkboxes.length + ' selected';
            } else {
                bulkActions.classList.remove('active');
            }
            
            // Update select all checkbox state
            const allCheckboxes = document.querySelectorAll('.order-checkbox');
            const selectAll = document.getElementById('selectAll');
            selectAll.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
        }
        
        function clearSelection() {
            document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateBulkActions();
        }
        
        // Confirm bulk update
        document.getElementById('bulkForm').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('.order-checkbox:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one order.');
                return false;
            }
            
            if (!confirm('Update ' + checkboxes.length + ' order(s)?')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>