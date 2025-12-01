<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$message = '';

// Handle customer actions
if (isset($_GET['action'])) {
    $customer_id = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT email, first_name, last_name, is_active FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $customer = $stmt->get_result()->fetch_assoc();
    $customer_email = $customer['email'];
    $customer_name = $customer['first_name'] . ' ' . $customer['last_name'];
    $old_status = $customer['is_active'];
    
    if ($_GET['action'] === 'activate') {
        $conn->query("UPDATE customers SET is_active = 1 WHERE customer_id = $customer_id");
        $message = 'Customer activated successfully!';
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'customer_status_change',
            "Customer activated: $customer_name ($customer_email)",
            'customers',
            $customer_id,
            ['is_active' => $old_status],
            ['is_active' => 1]
        );
    } elseif ($_GET['action'] === 'deactivate') {
        $conn->query("UPDATE customers SET is_active = 0 WHERE customer_id = $customer_id");
        $message = 'Customer deactivated successfully!';
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'customer_status_change',
            "Customer deactivated: $customer_name ($customer_email)",
            'customers',
            $customer_id,
            ['is_active' => $old_status],
            ['is_active' => 0]
        );
    } elseif ($_GET['action'] === 'delete') {
        $conn->query("DELETE FROM customers WHERE customer_id = $customer_id");
        $message = 'Customer deleted successfully!';
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'customer_delete',
            "Customer deleted: $customer_name ($customer_email)",
            'customers',
            $customer_id,
            ['email' => $customer_email, 'name' => $customer_name]
        );
    }
}

// Get search term
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = "1=1";
if ($search) {
    $search_safe = $conn->real_escape_string($search);
    $where = "(first_name LIKE '%$search_safe%' OR last_name LIKE '%$search_safe%' OR email LIKE '%$search_safe%')";
}

// Get customers with order stats
$customers = $conn->query("
    SELECT c.*, 
           COUNT(DISTINCT o.order_id) as total_orders,
           COALESCE(SUM(o.total_amount), 0) as total_spent
    FROM customers c
    LEFT JOIN orders o ON c.customer_id = o.customer_id
    WHERE $where
    GROUP BY c.customer_id
    ORDER BY c.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .search-bar input {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .customer-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .customer-status.active {
            background: #d4edda;
            color: #155724;
        }
        
        .customer-status.inactive {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Customers Management</h1>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <form method="GET" class="search-bar">
                <input type="text" name="search" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn-admin btn-primary">Search</button>
                <?php if ($search): ?>
                    <a href="customers.php" class="btn-admin btn-secondary">Clear</a>
                <?php endif; ?>
            </form>
            
            <div class="content-card">
                <h2>All Customers (<?php echo count($customers); ?>)</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?php echo $customer['customer_id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone'] ?: 'N/A'); ?></td>
                                <td><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></td>
                                <td><strong><?php echo $customer['total_orders']; ?></strong></td>
                                <td><strong style="color: #27ae60;"><?php echo formatCurrency($customer['total_spent']); ?></strong></td>
                                <td>
                                    <span class="customer-status <?php echo $customer['is_active'] ? 'active' : 'inactive'; ?>">
                                        <?php echo $customer['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($customer['is_active']): ?>
                                        <a href="?action=deactivate&id=<?php echo $customer['customer_id']; ?>" 
                                           class="btn-admin btn-danger"
                                           onclick="return confirm('Deactivate this customer?')">Deactivate</a>
                                    <?php else: ?>
                                        <a href="?action=activate&id=<?php echo $customer['customer_id']; ?>" 
                                           class="btn-admin btn-success">Activate</a>
                                    <?php endif; ?>
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