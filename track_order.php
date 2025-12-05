<?php
require_once 'config.php';

$order = null;
$order_items = null;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_number'])) {
    $order_number = trim($_POST['order_number']);
    
    if (empty($order_number)) {
        $error = 'Please enter a valid order number.';
    } else {
        $conn = getDBConnection();
        
        $stmt = $conn->prepare("
            SELECT o.*, 
                   a.street_address, a.city, a.state_province, a.postal_code, a.country
            FROM orders o
            LEFT JOIN addresses a ON o.shipping_address_id = a.address_id
            WHERE o.order_number = ?
        ");
        $stmt->bind_param("s", $order_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        
        if (!$order) {
            $error = 'Order not found. Please check your order ID and try again.';
        } else {
            $stmt = $conn->prepare("
                SELECT oi.*, p.product_name, p.sku, pi.image_url
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
                WHERE oi.order_id = ?
            ");
            $stmt->bind_param("i", $order['order_id']);
            $stmt->execute();
            $order_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $success = 'Order found! Here are your order details.';
        }
        
        $conn->close();
    }
}

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
    <title>Track Your Order - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .track-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .track-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .track-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #333;
        }
        
        .track-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
        
        .search-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .search-form .form-group {
            margin-bottom: 0;
        }
        
        .search-form .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }
        
        .search-form .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .search-form .form-group input:focus {
            outline: none;
            border-color: #7c3aed;
        }
        
        .search-form button {
            width: 100%;
            padding: 12px;
            background: #7c3aed;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 15px;
        }
        
        .search-form button:hover {
            background: #6d28d9;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 2px solid #dc2626;
            color: #dc2626;
        }
        
        .alert-success {
            background: #f0fdf4;
            border: 2px solid #16a34a;
            color: #16a34a;
        }
        
        .order-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .order-number {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }
        
        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #333;
            font-size: 1rem;
        }
        
        .order-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        .order-items-table thead {
            background: #f8f9fa;
        }
        
        .order-items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            color: #333;
        }
        
        .order-items-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .order-totals {
            text-align: right;
            margin-bottom: 25px;
            padding-top: 15px;
            border-top: 2px solid #f0f0f0;
        }
        
        .order-totals p {
            margin: 10px 0;
            display: flex;
            justify-content: flex-end;
            gap: 50px;
        }
        
        .order-totals .total-label {
            font-weight: 600;
            color: #666;
        }
        
        .order-totals .total-value {
            min-width: 150px;
            text-align: right;
        }
        
        .order-totals .grand-total {
            font-size: 1.3rem;
            color: #27ae60;
        }
        
        .order-footer {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            color: #666;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            line-height: 1.6;
            color: #333;
        }
        
        a {
            color: #7c3aed;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Removed header include for independence -->
    
    <div class="track-container">
        <div class="track-header">
            <h1>Track Your Order</h1>
            <p>Enter your order ID to view order status and details</p>
        </div>
        
        <div class="search-form">
            <form method="POST">
                <div class="form-group">
                    <label for="order_number">Order Number</label>
                    <input 
                        type="text" 
                        id="order_number" 
                        name="order_number" 
                        placeholder="Enter your order number (e.g., ORD-2024-001234)" 
                        required
                    >
                </div>
                <button type="submit">Search Order</button>
            </form>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($order && $success): ?>
            <div class="alert alert-success">
                ✓ <?php echo htmlspecialchars($success); ?>
            </div>
            
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
                        <span class="info-label">Order Status</span>
                        <span class="info-value" style="text-transform: capitalize;"><?php echo htmlspecialchars($order['order_status']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Method</span>
                        <span class="info-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Status</span>
                        <span class="info-value" style="text-transform: capitalize;"><?php echo htmlspecialchars($order['payment_status']); ?></span>
                    </div>
                </div>
                
                <div class="info-item" style="margin-bottom: 25px;">
                    <span class="info-label">Shipping Address</span>
                    <span class="info-value">
                        <?php 
                        $address_parts = [];
                        if ($order['street_address']) $address_parts[] = htmlspecialchars($order['street_address']);
                        if ($order['city']) $address_parts[] = htmlspecialchars($order['city']);
                        if ($order['state_province']) $address_parts[] = htmlspecialchars($order['state_province']);
                        if ($order['postal_code']) $address_parts[] = htmlspecialchars($order['postal_code']);
                        if ($order['country']) $address_parts[] = htmlspecialchars($order['country']);
                        echo implode(', ', $address_parts);
                        ?>
                    </span>
                </div>
                
                <h3 style="margin-bottom: 15px; color: #333;">Order Items</h3>
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
                        <?php foreach ($order_items as $item): ?>
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
                
                <div class="order-totals">
                    <p>
                        <span class="total-label">Subtotal:</span>
                        <span class="total-value"><?php echo formatCurrency($order['subtotal']); ?></span>
                    </p>
                    <p>
                        <span class="total-label">Tax:</span>
                        <span class="total-value"><?php echo formatCurrency($order['tax_amount']); ?></span>
                    </p>
                    <p>
                        <span class="total-label">Shipping:</span>
                        <span class="total-value"><?php echo formatCurrency($order['shipping_cost']); ?></span>
                    </p>
                    <p class="grand-total">
                        <span class="total-label">Total:</span>
                        <span class="total-value"><?php echo formatCurrency($order['total_amount']); ?></span>
                    </p>
                </div>
                
                <div class="order-footer">
                    <p>Need help? <a href="contact.php" style="color: #7c3aed; text-decoration: none; font-weight: 600;">Contact us</a> for assistance with your order.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Removed footer include for independence -->
</body>
</html>
