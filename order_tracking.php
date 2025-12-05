<?php
require_once 'config.php';

// Get order_id from URL
$order_id = intval($_GET['order_id'] ?? 0);
$order = null;
$order_items = null;
$error = '';

// Verify order_id is valid
if ($order_id > 0) {
    $conn = getDBConnection();
    
    if ($conn) {
        // Fetch order details - NO AUTHENTICATION REQUIRED for email links
        $stmt = $conn->prepare("
            SELECT o.* 
            FROM orders o
            WHERE o.order_id = ?
        ");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        
        if ($order) {
            // Fetch order items
            $stmt = $conn->prepare("
                SELECT oi.*, p.product_name, p.sku, pi.image_url
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
                WHERE oi.order_id = ?
            ");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $order_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            // Log the tracking view
            if (function_exists('logCustomerActivity') && isset($order['customer_id'])) {
                logCustomerActivity(
                    $order['customer_id'],
                    'order_tracking_viewed',
                    "Order tracking page viewed for order #" . $order['order_number'],
                    $order_id,
                    null,
                    null,
                    ['source' => 'email_link']
                );
            }
        } else {
            $error = 'Order not found. Please check your order ID.';
        }
        
        $conn->close();
    } else {
        $error = 'Database connection error. Please try again later.';
    }
} else {
    $error = 'Invalid order ID. Please use the link from your order confirmation email.';
}

// Function to get status badge class
function getStatusBadgeClass($status) {
    $status = strtolower($status);
    $classes = [
        'pending' => 'pending',
        'processing' => 'processing',
        'shipped' => 'shipped',
        'delivered' => 'delivered',
        'cancelled' => 'cancelled',
        'paid' => 'delivered',
        'unpaid' => 'pending'
    ];
    return $classes[$status] ?? 'pending';
}

// Function to get status icon
function getStatusIcon($status) {
    $status = strtolower($status);
    $icons = [
        'pending' => '⏳',
        'processing' => '⚙️',
        'shipped' => '📦',
        'delivered' => '✅',
        'cancelled' => '❌',
        'paid' => '✅',
        'unpaid' => '⏳'
    ];
    return $icons[$status] ?? '📋';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking<?php echo $order ? ' - Order #' . htmlspecialchars($order['order_number']) : ''; ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .tracking-container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .tracking-header {
            background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .tracking-header h1 {
            margin: 0 0 15px 0;
            font-size: 2rem;
            font-weight: 700;
        }
        
        .order-number {
            font-family: 'Courier New', monospace;
            font-size: 1.3rem;
            background: rgba(255,255,255,0.2);
            padding: 12px 24px;
            border-radius: 8px;
            display: inline-block;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .tracking-content {
            padding: 40px;
        }
        
        .tracking-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .tracking-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .tracking-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .status-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #7c3aed;
        }
        
        .status-label {
            font-size: 0.85rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .status-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .status-badge.processing { background: #d1ecf1; color: #0c5460; }
        .status-badge.shipped { background: #d4edda; color: #155724; }
        .status-badge.delivered { background: #d4edda; color: #155724; }
        .status-badge.cancelled { background: #f8d7da; color: #721c24; }
        
        .items-list {
            display: grid;
            gap: 15px;
        }
        
        .item-card {
            display: flex;
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            gap: 20px;
            transition: all 0.3s ease;
        }
        
        .item-card:hover {
            border-color: #7c3aed;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
        }
        
        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            background: #f0f0f0;
        }
        
        .item-info {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }
        
        .item-details {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
        }
        
        .item-price {
            font-weight: 700;
            color: #27ae60;
            font-size: 1.2rem;
            align-self: center;
        }
        
        .order-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #dee2e6;
            font-size: 1rem;
        }
        
        .summary-row.total {
            border-bottom: none;
            border-top: 3px solid #2c3e50;
            padding-top: 20px;
            margin-top: 10px;
            font-size: 1.4rem;
            font-weight: 700;
            color: #27ae60;
        }
        
        .error-message {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            font-size: 1.1rem;
        }
        
        .error-message strong {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #7c3aed;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            background: #6d28d9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
        }
        
        @media (max-width: 768px) {
            .tracking-container {
                margin: 20px auto;
            }
            
            .tracking-header {
                padding: 30px 20px;
            }
            
            .tracking-header h1 {
                font-size: 1.5rem;
            }
            
            .tracking-content {
                padding: 20px;
            }
            
            .item-card {
                flex-direction: column;
            }
            
            .item-image {
                width: 100%;
                height: 200px;
            }
            
            .status-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="tracking-container">
        <?php if ($error): ?>
            <div class="tracking-header">
                <h1>❌ Order Not Found</h1>
            </div>
            <div class="tracking-content">
                <div class="error-message">
                    <strong>Oops!</strong>
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <div style="text-align: center;">
                    <a href="/" class="back-button">← Back to Home</a>
                </div>
            </div>
        <?php elseif ($order): ?>
            <div class="tracking-header">
                <h1>📦 Order Tracking</h1>
                <div class="order-number">Order #<?php echo htmlspecialchars($order['order_number']); ?></div>
            </div>
            
            <div class="tracking-content">
                <div class="tracking-section">
                    <h2>📊 Current Status</h2>
                    <div class="status-grid">
                        <div class="status-card">
                            <div class="status-label">Order Status</div>
                            <div class="status-value">
                                <span class="status-badge <?php echo getStatusBadgeClass($order['order_status']); ?>">
                                    <?php echo getStatusIcon($order['order_status']); ?>
                                    <?php echo ucfirst($order['order_status']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="status-card">
                            <div class="status-label">Payment Status</div>
                            <div class="status-value">
                                <span class="status-badge <?php echo getStatusBadgeClass($order['payment_status']); ?>">
                                    <?php echo getStatusIcon($order['payment_status']); ?>
                                    <?php echo ucfirst($order['payment_status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tracking-section">
                    <h2>📋 Order Information</h2>
                    <div class="status-grid">
                        <div class="status-card">
                            <div class="status-label">Order Date</div>
                            <div class="status-value"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></div>
                            <div style="font-size: 0.85rem; color: #666; margin-top: 4px;">
                                <?php echo date('h:i A', strtotime($order['created_at'])); ?>
                            </div>
                        </div>
                        <div class="status-card">
                            <div class="status-label">Payment Method</div>
                            <div class="status-value"><?php echo htmlspecialchars($order['payment_method']); ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="tracking-section">
                    <h2>🛍️ Items Ordered</h2>
                    <div class="items-list">
                        <?php foreach ($order_items as $item): ?>
                            <div class="item-card">
                                <img src="<?php echo htmlspecialchars($item['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                     class="item-image"
                                     onerror="this.src='images/placeholder.jpg'">
                                <div class="item-info">
                                    <div class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                    <div class="item-details">
                                        <div><strong>SKU:</strong> <?php echo htmlspecialchars($item['sku']); ?></div>
                                        <div><strong>Quantity:</strong> <?php echo $item['quantity']; ?></div>
                                        <div><strong>Unit Price:</strong> <?php echo formatCurrency($item['unit_price']); ?></div>
                                    </div>
                                </div>
                                <div class="item-price"><?php echo formatCurrency($item['subtotal']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span><?php echo formatCurrency($order['subtotal']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax:</span>
                            <span><?php echo formatCurrency($order['tax_amount']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span><?php echo formatCurrency($order['shipping_cost']); ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span><?php echo formatCurrency($order['total_amount']); ?></span>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="/" class="back-button">← Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>