<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$message = '';

// Handle inventory update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_inventory'])) {
    $inventory_id = intval($_POST['inventory_id']);
    $quantity = intval($_POST['quantity']);
    $reorder_level = intval($_POST['reorder_level']);
    
    $stmt = $conn->prepare("UPDATE inventory SET quantity=?, reorder_level=?, last_restocked=NOW() WHERE inventory_id=?");
    $stmt->bind_param("iii", $quantity, $reorder_level, $inventory_id);
    
    if ($stmt->execute()) {
        $message = 'Inventory updated successfully!';
    }
}

// Handle bulk restock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_restock'])) {
    $product_id = intval($_POST['product_id']);
    $add_quantity = intval($_POST['add_quantity']);
    
    $conn->query("UPDATE inventory SET quantity = quantity + $add_quantity, last_restocked = NOW() WHERE product_id = $product_id");
    $message = 'Stock added successfully!';
}

// Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where = "p.is_active = 1";

if ($filter === 'low_stock') {
    $where .= " AND i.quantity <= i.reorder_level";
} elseif ($filter === 'out_of_stock') {
    $where .= " AND i.quantity = 0";
}

// Get inventory data
$inventory = $conn->query("
    SELECT p.product_id, p.product_name, p.sku, p.price,
           c.category_name,
           i.inventory_id, i.quantity, i.reserved_quantity, i.reorder_level, i.last_restocked,
           (i.quantity - i.reserved_quantity) as available_quantity
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN inventory i ON p.product_id = i.product_id
    WHERE $where
    ORDER BY i.quantity ASC, p.product_name
")->fetch_all(MYSQLI_ASSOC);

// Get inventory statistics
$stats = $conn->query("
    SELECT 
        COUNT(*) as total_products,
        SUM(CASE WHEN quantity = 0 THEN 1 ELSE 0 END) as out_of_stock,
        SUM(CASE WHEN quantity <= reorder_level THEN 1 ELSE 0 END) as low_stock,
        SUM(quantity) as total_units,
        SUM(quantity * (SELECT price FROM products WHERE product_id = inventory.product_id)) as inventory_value
    FROM inventory
")->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .stock-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .stock-status.in-stock { background: #d4edda; color: #155724; }
        .stock-status.low-stock { background: #fff3cd; color: #856404; }
        .stock-status.out-of-stock { background: #f8d7da; color: #721c24; }
        
        .quick-restock {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        
        .quick-restock input {
            width: 70px;
            padding: 5px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active { display: flex; }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
        }
        
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .filter-tab {
            padding: 10px 20px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            transition: all 0.3s;
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
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Inventory Management</h1>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <!-- Statistics -->
            <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                <div class="stat-card blue">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value"><?php echo number_format($stats['total_products']); ?></div>
                </div>
                <div class="stat-card green">
                    <div class="stat-title">Total Units</div>
                    <div class="stat-value"><?php echo number_format($stats['total_units']); ?></div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-title">Low Stock Items</div>
                    <div class="stat-value"><?php echo number_format($stats['low_stock']); ?></div>
                </div>
                <div class="stat-card red">
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-value"><?php echo number_format($stats['out_of_stock']); ?></div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-title">Inventory Value</div>
                    <div class="stat-value"><?php echo formatCurrency($stats['inventory_value']); ?></div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="filter-tabs">
                <a href="?filter=all" class="filter-tab <?php echo $filter === 'all' ? 'active' : ''; ?>">
                    All Products
                </a>
                <a href="?filter=low_stock" class="filter-tab <?php echo $filter === 'low_stock' ? 'active' : ''; ?>">
                    Low Stock (<?php echo $stats['low_stock']; ?>)
                </a>
                <a href="?filter=out_of_stock" class="filter-tab <?php echo $filter === 'out_of_stock' ? 'active' : ''; ?>">
                    Out of Stock (<?php echo $stats['out_of_stock']; ?>)
                </a>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>In Stock</th>
                            <th>Reserved</th>
                            <th>Available</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                            <th>Last Restocked</th>
                            <th>Quick Restock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventory as $item): 
                            $status = $item['quantity'] == 0 ? 'out-of-stock' : 
                                     ($item['quantity'] <= $item['reorder_level'] ? 'low-stock' : 'in-stock');
                            $status_text = $item['quantity'] == 0 ? 'Out of Stock' : 
                                          ($item['quantity'] <= $item['reorder_level'] ? 'Low Stock' : 'In Stock');
                        ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($item['product_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['sku']); ?></td>
                                <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                                <td><strong><?php echo number_format($item['quantity']); ?></strong></td>
                                <td><?php echo number_format($item['reserved_quantity']); ?></td>
                                <td><strong style="color: #27ae60;"><?php echo number_format($item['available_quantity']); ?></strong></td>
                                <td><?php echo number_format($item['reorder_level']); ?></td>
                                <td>
                                    <span class="stock-status <?php echo $status; ?>">
                                        <?php echo $status_text; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo $item['last_restocked'] ? date('M d, Y', strtotime($item['last_restocked'])) : 'Never'; ?>
                                </td>
                                <td>
                                    <form method="POST" class="quick-restock">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                        <input type="number" name="add_quantity" value="10" min="1" required>
                                        <button type="submit" name="bulk_restock" class="btn-admin btn-success">+ Add</button>
                                    </form>
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