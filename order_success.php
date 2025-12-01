<?php
require_once 'config.php';

// Debug: Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Debug: Check if order_number is provided
if (!isset($_GET['order_number'])) {
    echo "Error: No order number provided<br>";
    echo "<a href='orders.php'>View My Orders</a>";
    exit;
}

$order_number = $_GET['order_number'];

// Fetch order details
$conn = getDBConnection();
$stmt = $conn->prepare("
    SELECT o.*, p.payment_status, p.transaction_id, p.payment_date,
           a.street_address, a.city, a.state_province, a.postal_code, a.country
    FROM orders o
    LEFT JOIN payments p ON o.order_id = p.order_id
    LEFT JOIN addresses a ON o.shipping_address_id = a.address_id
    WHERE o.order_number = ? AND o.customer_id = ?
");
$stmt->bind_param("si", $order_number, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Error: Order not found<br>";
    echo "Order Number: " . htmlspecialchars($order_number) . "<br>";
    echo "Customer ID: " . $customer_id . "<br>";
    echo "<a href='orders.php'>View My Orders</a>";
    exit;
}

$order = $result->fetch_assoc();

// Get order items
$stmt = $conn->prepare("
    SELECT oi.*, p.product_name, pi.image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order['order_id']);
$stmt->execute();
$order_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get customer email and name
$customer_stmt = $conn->prepare("
    SELECT email, first_name, last_name 
    FROM customers 
    WHERE customer_id = ?
");
$customer_stmt->bind_param("i", $customer_id);
$customer_stmt->execute();
$customer_result = $customer_stmt->get_result();
$customer = $customer_result->fetch_assoc();

// Send order confirmation email if enabled
if (ENABLE_EMAIL_NOTIFICATIONS && ENABLE_ORDER_EMAILS) {
    require_once 'includes/email.php';
    
    $email_sent = sendOrderConfirmationEmail(
        $order['order_id'],
        $customer['email'],
        $customer['first_name'] . ' ' . $customer['last_name'],
        $order['order_number'],
        $order['total_amount']
    );
    
    if ($email_sent) {
        error_log("Order confirmation email sent for order " . $order['order_number']);
    } else {
        error_log("Failed to send order confirmation email for order " . $order['order_number']);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .success-container {
            max-width: 900px;
            margin: 60px auto;
            padding: 0 20px;
        }
        
        .success-header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInUp 0.6s ease;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--success), #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
        }
        
        .success-icon::before {
            content: '✓';
            font-size: 50px;
            color: white;
            font-weight: bold;
        }
        
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--success);
            margin-bottom: 15px;
        }
        
        .success-header p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 10px;
        }
        
        .order-number-display {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 20px;
        }
        
        .success-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            animation: fadeInUp 0.6s ease 0.2s both;
        }
        
        .order-status-timeline {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            padding: 0 20px;
            position: relative;
        }
        
        .order-status-timeline::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 4px;
            background: var(--border);
            z-index: 0;
        }
        
        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            background: white;
            border: 4px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            transition: var(--transition);
        }
        
        .timeline-step.completed .step-icon {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }
        
        .timeline-step.active .step-icon {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(124, 58, 237, 0);
            }
        }
        
        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-light);
            text-align: center;
        }
        
        .timeline-step.completed .step-label,
        .timeline-step.active .step-label {
            color: var(--dark);
            font-weight: 700;
        }
        
        .order-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .detail-box {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(124, 58, 237, 0.1);
        }
        
        .detail-box h3 {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .detail-box p {
            font-size: 1.1rem;
            color: var(--dark);
            font-weight: 700;
            margin: 0;
        }
        
        .items-summary {
            margin-top: 30px;
        }
        
        .items-summary h2 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--dark);
        }
        
        .order-items-list {
            border-top: 2px solid var(--border);
        }
        
        .order-item-row {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid var(--border);
            gap: 20px;
        }
        
        .item-image-small {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .item-quantity {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .item-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary);
        }
        
        .order-total {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            text-align: right;
        }
        
        .total-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text);
            margin-right: 20px;
        }
        
        .total-amount {
            font-size: 2rem;
            font-weight: 900;
            color: var(--success);
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            animation: fadeInUp 0.6s ease 0.4s both;
        }
        
        .info-banner {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-left: 4px solid var(--info);
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
        }
        
        .info-banner h3 {
            color: var(--info);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .info-banner p {
            color: var(--text);
            line-height: 1.8;
            margin: 5px 0;
        }
        
        @media (max-width: 768px) {
            .success-header h1 {
                font-size: 2rem;
            }
            
            .order-status-timeline {
                flex-wrap: wrap;
                gap: 20px;
            }
            
            .order-status-timeline::before {
                display: none;
            }
            
            .success-content {
                padding: 25px 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="success-container">
        <div class="success-header">
            <div class="success-icon"></div>
            <h1>Order Placed Successfully!</h1>
            <p>Thank you for your purchase. Your order has been received and is being processed.</p>
            <div class="order-number-display">
                Order #<?php echo htmlspecialchars($order['order_number']); ?>
            </div>
        </div>
        
        <div class="success-content">
            <!-- Order Status Timeline -->
            <div class="order-status-timeline">
                <div class="timeline-step completed">
                    <div class="step-icon">✓</div>
                    <span class="step-label">Order Placed</span>
                </div>
                <div class="timeline-step <?php echo ($order['payment_status'] === 'completed') ? 'completed' : 'active'; ?>">
                    <div class="step-icon"><?php echo ($order['payment_status'] === 'completed') ? '✓' : '💳'; ?></div>
                    <span class="step-label">Payment <?php echo ($order['payment_status'] === 'completed') ? 'Confirmed' : 'Pending'; ?></span>
                </div>
                <div class="timeline-step">
                    <div class="step-icon">📦</div>
                    <span class="step-label">Processing</span>
                </div>
                <div class="timeline-step">
                    <div class="step-icon">🚚</div>
                    <span class="step-label">Shipped</span>
                </div>
                <div class="timeline-step">
                    <div class="step-icon">🏠</div>
                    <span class="step-label">Delivered</span>
                </div>
            </div>
            
            <!-- Order Details -->
            <div class="order-details-grid">
                <div class="detail-box">
                    <h3>Order Date</h3>
                    <p><?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Payment Method</h3>
                    <p><?php echo htmlspecialchars($order['payment_method']); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Payment Status</h3>
                    <p style="color: <?php echo ($order['payment_status'] === 'completed') ? 'var(--success)' : 'var(--warning)'; ?>">
                        <?php echo ucfirst($order['payment_status']); ?>
                    </p>
                </div>
                <?php if ($order['transaction_id']): ?>
                <div class="detail-box">
                    <h3>Transaction ID</h3>
                    <p style="font-size: 0.9rem;"><?php echo htmlspecialchars($order['transaction_id']); ?></p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Shipping Address -->
            <div class="detail-box" style="margin-top: 20px;">
                <h3>Shipping Address</h3>
                <p style="line-height: 1.8; font-size: 1rem; font-weight: 600;">
                    <?php echo htmlspecialchars($order['street_address']); ?><br>
                    <?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['state_province']); ?><br>
                    <?php echo htmlspecialchars($order['postal_code']); ?>, <?php echo htmlspecialchars($order['country']); ?>
                </p>
            </div>
            
            <!-- Order Items -->
            <div class="items-summary">
                <h2>Order Items</h2>
                <div class="order-items-list">
                    <?php foreach ($order_items as $item): ?>
                        <div class="order-item-row">
                            <img src="<?php echo htmlspecialchars($item['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                 class="item-image-small">
                            <div class="item-details">
                                <div class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                <div class="item-quantity">Quantity: <?php echo $item['quantity']; ?></div>
                            </div>
                            <div class="item-price"><?php echo formatCurrency($item['subtotal']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-total">
                    <span class="total-label">Total Amount:</span>
                    <span class="total-amount"><?php echo formatCurrency($order['total_amount']); ?></span>
                </div>
            </div>
            
            <!-- Information Banner -->
            <div class="info-banner">
                <h3>📧 What's Next?</h3>
                <p>✓ A confirmation email has been sent to your registered email address.</p>
                <p>✓ You can track your order status in the "My Orders" section.</p>
                <p>✓ You will receive updates via email as your order progresses.</p>
                <?php if ($order['payment_status'] === 'pending'): ?>
                    <p style="color: var(--warning); font-weight: 700; margin-top: 10px;">
                        ⚠️ Please note: For Cash on Delivery orders, payment will be collected upon delivery.
                    </p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="orders.php" class="btn btn-primary">View All Orders</a>
            <a href="shop.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>