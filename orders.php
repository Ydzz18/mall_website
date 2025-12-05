<?php
require_once 'config.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$error_message = '';
$success_message = '';

// Get all orders for customer
$conn = getDBConnection();
if (!$conn) {
    die("Database connection failed. Please try again later.");
}

$stmt = $conn->prepare("
    SELECT o.*, 
           a.street_address, a.city, a.state_province, a.postal_code, a.country,
           COUNT(oi.order_item_id) as item_count
    FROM orders o
    LEFT JOIN addresses a ON o.shipping_address_id = a.address_id
    LEFT JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.customer_id = ?
    GROUP BY o.order_id
    ORDER BY o.created_at DESC
");

if (!$stmt) {
    error_log("Orders query preparation failed: " . $conn->error);
    die("Unable to fetch orders. Please try again later.");
}

$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get order details if viewing specific order
$order_details = null;
$selected_order = null;

if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    
    // First verify the order belongs to this customer
    $stmt = $conn->prepare("
        SELECT o.*, 
               a.street_address, a.city, a.state_province, a.postal_code, a.country
        FROM orders o
        LEFT JOIN addresses a ON o.shipping_address_id = a.address_id
        WHERE o.order_id = ? AND o.customer_id = ?
    ");
    
    if ($stmt) {
        $stmt->bind_param("ii", $order_id, $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $selected_order = $result->fetch_assoc();
        $stmt->close();
        
        if ($selected_order) {
            // Now get order items
            $stmt = $conn->prepare("
                SELECT oi.*, p.product_name, p.sku, pi.image_url
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
                WHERE oi.order_id = ?
            ");
            
            if ($stmt) {
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $order_details = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
            } else {
                error_log("Order items query failed: " . $conn->error);
                $error_message = "Unable to load order details.";
            }
        } else {
            $error_message = "Order not found or you don't have permission to view it.";
        }
    } else {
        error_log("Order verification query failed: " . $conn->error);
        $error_message = "Unable to load order.";
    }
}

$conn->close();

function getStatusBadge($status) {
    $colors = [
        'pending' => '#f39c12',
        'processing' => '#3498db',
        'shipped' => '#9b59b6',
        'delivered' => '#27ae60',
        'cancelled' => '#e74c3c',
        'refunded' => '#95a5a6'
    ];
    $color = $colors[$status] ?? '#333';
    return "<span style='background: {$color}; color: white; padding: 5px 12px; border-radius: 15px; font-size: 0.85rem; font-weight: bold;'>" . ucfirst($status) . "</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
        .order-details-section {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #7c3aed;
        }
        .close-details {
            display: inline-block;
            margin-bottom: 15px;
            color: #7c3aed;
            text-decoration: none;
            font-weight: bold;
        }
        .close-details:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="orders-container">
        <div class="orders-header">
            <h1>My Orders</h1>
            <p style="color: #7f8c8d;">View and track your order history</p>
        </div>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (count($orders) > 0): ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <span class="order-number">Order #<?php echo htmlspecialchars($order['order_number']); ?></span>
                            <?php echo getStatusBadge($order['order_status']); ?>
                        </div>
                        
                        <div class="order-info">
                            <div class="info-item">
                                <span class="info-label">Order Date</span>
                                <span class="info-value"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Total Amount</span>
                                <span class="info-value" style="color: #27ae60;"><?php echo formatCurrency($order['total_amount']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Items</span>
                                <span class="info-value"><?php echo $order['item_count']; ?> item(s)</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Payment Method</span>
                                <span class="info-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Shipping Address</span>
                            <span class="info-value">
                                <?php echo htmlspecialchars($order['street_address']); ?>, 
                                <?php echo htmlspecialchars($order['city']); ?>, 
                                <?php echo htmlspecialchars($order['state_province']); ?> 
                                <?php echo htmlspecialchars($order['postal_code']); ?>
                            </span>
                        </div>
                        
                        <div class="order-actions">
                            <?php if (isset($_GET['order_id']) && $_GET['order_id'] == $order['order_id']): ?>
                                <a href="orders.php" class="btn btn-secondary">← Back to Orders</a>
                            <?php else: ?>
                                <a href="orders.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-secondary">View Details</a>
                            <?php endif; ?>
                            
                            <?php if ($order['order_status'] === 'pending'): ?>
                                <button class="btn btn-remove" onclick="confirmCancel(<?php echo $order['order_id']; ?>)">Cancel Order</button>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($selected_order && $selected_order['order_id'] == $order['order_id'] && $order_details): ?>
                            <div class="order-details-section">
                                <h3>Order Items</h3>
                                
                                <?php if (count($order_details) > 0): ?>
                                    <table class="order-items-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>SKU</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order_details as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div style="display: flex; align-items: center; gap: 10px;">
                                                            <?php if (!empty($item['image_url'])): ?>
                                                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                                                     alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                                                     class="item-image"
                                                                     onerror="this.src='images/placeholder.jpg'">
                                                            <?php else: ?>
                                                                <img src="images/placeholder.jpg" 
                                                                     alt="No image" 
                                                                     class="item-image">
                                                            <?php endif; ?>
                                                            <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($item['sku']); ?></td>
                                                    <td><?php echo intval($item['quantity']); ?></td>
                                                    <td><?php echo formatCurrency($item['unit_price']); ?></td>
                                                    <td><strong><?php echo formatCurrency($item['subtotal']); ?></strong></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    
                                    <div style="margin-top: 20px; text-align: right;">
                                        <p><strong>Subtotal:</strong> <?php echo formatCurrency($selected_order['subtotal']); ?></p>
                                        <p><strong>Tax:</strong> <?php echo formatCurrency($selected_order['tax_amount']); ?></p>
                                        <p><strong>Shipping:</strong> <?php echo formatCurrency($selected_order['shipping_cost']); ?></p>
                                        <p style="font-size: 1.2rem; color: #27ae60;"><strong>Total:</strong> <?php echo formatCurrency($selected_order['total_amount']); ?></p>
                                    </div>
                                <?php else: ?>
                                    <p>No items found for this order.</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-orders">
                <h2>No orders yet</h2>
                <p>Start shopping to see your orders here!</p>
                <a href="shop.php" class="btn btn-primary" style="margin-top: 20px;">Browse Products</a>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
        function confirmCancel(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                window.location.href = 'cancel_order.php?order_id=' + orderId;
            }
        }
    </script>
</body>
</html>