<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Get all orders for customer
$conn = getDBConnection();
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
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

// Get order details if viewing specific order
$order_details = null;
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    $stmt = $conn->prepare("
        SELECT oi.*, p.product_name, p.sku, pi.image_url
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
        JOIN orders o ON oi.order_id = o.order_id
        WHERE oi.order_id = ? AND o.customer_id = ?
    ");
    $stmt->bind_param("ii", $order_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_details = $result->fetch_all(MYSQLI_ASSOC);
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
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="orders-container">
        <div class="orders-header">
            <h1>My Orders</h1>
            <p style="color: #7f8c8d;">View and track your order history</p>
        </div>
        
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
                            <a href="?order_id=<?php echo $order['order_id']; ?>" class="btn btn-secondary">View Details</a>
                            <?php if ($order['order_status'] === 'pending'): ?>
                                <button class="btn btn-remove">Cancel Order</button>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (isset($_GET['order_id']) && $_GET['order_id'] == $order['order_id'] && $order_details): ?>
                            <div class="order-details-modal">
                                <h3>Order Items</h3>
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
                                                        <img src="<?php echo htmlspecialchars($item['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                                                             alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                                             class="item-image">
                                                        <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($item['sku']); ?></td>
                                                <td><?php echo $item['quantity']; ?></td>
                                                <td><?php echo formatCurrency($item['unit_price']); ?></td>
                                                <td><strong><?php echo formatCurrency($item['subtotal']); ?></strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                
                                <div style="margin-top: 20px; text-align: right;">
                                    <p><strong>Subtotal:</strong> <?php echo formatCurrency($order['subtotal']); ?></p>
                                    <p><strong>Tax:</strong> <?php echo formatCurrency($order['tax_amount']); ?></p>
                                    <p><strong>Shipping:</strong> <?php echo formatCurrency($order['shipping_cost']); ?></p>
                                    <p style="font-size: 1.2rem; color: #27ae60;"><strong>Total:</strong> <?php echo formatCurrency($order['total_amount']); ?></p>
                                </div>
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
</body>
</html>