<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config.php';
$conn = getDBConnection();

$message = '';
$error = '';

// Get order ID
if (!isset($_GET['id'])) {
    header('Location: orders.php');
    exit;
}

$order_id = intval($_GET['id']);

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_order_status'])) {
        $new_status = $_POST['order_status'];
        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $new_status, $order_id);
        
        if ($stmt->execute()) {
            // Update shipping status based on order status
            if ($new_status === 'shipped') {
                $conn->query("UPDATE shipping SET status = 'shipped', shipped_date = NOW() WHERE order_id = $order_id");
            } elseif ($new_status === 'delivered') {
                $conn->query("UPDATE shipping SET status = 'delivered', actual_delivery_date = NOW() WHERE order_id = $order_id");
            }
            if ($stmt->execute()) {
                require_once '../includes/notifications.php';
                notifyOrderStatusChange($order_id, $new_status);
                $message = 'Order status updated successfully!';
            }
        }
    }
    
    if (isset($_POST['update_payment_status'])) {
        $payment_status = $_POST['payment_status'];
        $stmt = $conn->prepare("UPDATE orders SET payment_status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $payment_status, $order_id);
        
        if ($stmt->execute()) {
            $conn->query("UPDATE payments SET payment_status = '$payment_status' WHERE order_id = $order_id");
            $message = 'Payment status updated successfully!';
        }
    }
    
    if (isset($_POST['update_tracking'])) {
        $tracking_number = trim($_POST['tracking_number']);
        $carrier = trim($_POST['carrier']);
        
        $stmt = $conn->prepare("UPDATE shipping SET tracking_number = ?, carrier = ? WHERE order_id = ?");
        $stmt->bind_param("ssi", $tracking_number, $carrier, $order_id);
        
        if ($stmt->execute()) {
            $message = 'Tracking information updated successfully!';
            
            // Send shipping notification email if enabled
            if (ENABLE_EMAIL_NOTIFICATIONS && ENABLE_SHIPPING_EMAILS) {
                require_once '../includes/email.php';
                
                $order_data = $conn->query("
                    SELECT o.*, c.email, c.first_name, c.last_name 
                    FROM orders o 
                    JOIN customers c ON o.customer_id = c.customer_id 
                    WHERE o.order_id = $order_id
                ")->fetch_assoc();
                
                $email_sent = sendShippingNotificationEmail(
                    $order_id,
                    $order_data['email'],
                    $order_data['first_name'] . ' ' . $order_data['last_name'],
                    $order_data['order_number'],
                    $tracking_number
                );
                
                if ($email_sent) {
                    error_log("Shipping notification email sent for order " . $order_data['order_number']);
                }
            }
        }
    }
    
    if (isset($_POST['add_note'])) {
        $note = trim($_POST['admin_note']);
        if (!empty($note)) {
            $admin_id = $_SESSION['admin_id'];
            $stmt = $conn->prepare("INSERT INTO order_notes (order_id, admin_id, note_text) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $order_id, $admin_id, $note);
            
            if ($stmt->execute()) {
                $message = 'Note added successfully!';
            }
        }
    }
}

// Get order details
$order = $conn->query("
    SELECT o.*, 
           c.first_name, c.last_name, c.email, c.phone,
           p.payment_status as payment_status_detail, p.transaction_id, p.payment_date,
           s.status as shipping_status, s.tracking_number, s.carrier, s.shipped_date, s.estimated_delivery_date,
           ba.street_address as billing_address, ba.city as billing_city, ba.state_province as billing_state, 
           ba.postal_code as billing_postal, ba.country as billing_country,
           sa.street_address as shipping_address, sa.city as shipping_city, sa.state_province as shipping_state,
           sa.postal_code as shipping_postal, sa.country as shipping_country
    FROM orders o
    JOIN customers c ON o.customer_id = c.customer_id
    LEFT JOIN payments p ON o.order_id = p.order_id
    LEFT JOIN shipping s ON o.order_id = s.order_id
    LEFT JOIN addresses ba ON o.billing_address_id = ba.address_id
    LEFT JOIN addresses sa ON o.shipping_address_id = sa.address_id
    WHERE o.order_id = $order_id
")->fetch_assoc();

if (!$order) {
    header('Location: orders.php');
    exit;
}

// Get order items
$order_items = $conn->query("
    SELECT oi.*, p.product_name, p.sku, p.brand,
           (SELECT image_url FROM product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = $order_id
")->fetch_all(MYSQLI_ASSOC);

// Create order_notes table if not exists
$conn->query("
    CREATE TABLE IF NOT EXISTS order_notes (
        note_id INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        admin_id INT,
        note_text TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(order_id)
    )
");

// Get order notes
$order_notes = $conn->query("
    SELECT * FROM order_notes 
    WHERE order_id = $order_id 
    ORDER BY created_at DESC
")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #<?php echo $order['order_number']; ?> - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .order-details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        .detail-card h2 {
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(226, 232, 240, 0.6);
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .order-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }
        
        .order-header-card h1 {
            margin-bottom: 10px;
            font-size: 2rem;
        }
        
        .order-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .meta-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
        }
        
        .meta-label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 5px;
        }
        
        .meta-value {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.4);
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #64748b;
            font-weight: 600;
        }
        
        .info-value {
            color: #1e293b;
            font-weight: 600;
            text-align: right;
        }
        
        .item-card {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: rgba(226, 232, 240, 0.2);
            border-radius: 10px;
            margin-bottom: 10px;
            border: 1px solid rgba(226, 232, 240, 0.4);
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
            font-size: 1.05rem;
        }
        
        .item-meta {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        
        .item-price {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            color: #1e293b;
        }
        
        .address-box {
            background: rgba(226, 232, 240, 0.2);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid rgba(226, 232, 240, 0.4);
            margin-bottom: 15px;
        }
        
        .address-box h4 {
            color: #1e293b;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .address-box p {
            color: #64748b;
            line-height: 1.8;
            margin: 0;
        }
        
        .status-form {
            background: rgba(226, 232, 240, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid rgba(226, 232, 240, 0.4);
        }
        
        .status-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .status-form select,
        .status-form input {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(226, 232, 240, 0.6);
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 15px;
        }
        
        .note-card {
            background: rgba(226, 232, 240, 0.2);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #0284c7;
        }
        
        .note-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .note-author {
            font-weight: 700;
            color: #1e293b;
        }
        
        .note-date {
            color: #64748b;
            font-size: 0.85rem;
        }
        
        .note-text {
            color: #475569;
            line-height: 1.6;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(226, 232, 240, 0.6);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #0284c7;
            border: 3px solid white;
        }
        
        .timeline-date {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }
        
        .timeline-content {
            font-weight: 600;
            color: #1e293b;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            font-size: 1.3rem;
            font-weight: 700;
            color: #16a34a;
            border-top: 2px solid #1e293b;
            margin-top: 10px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        @media (max-width: 968px) {
            .order-details-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media print {
            .admin-sidebar, .admin-header, .action-buttons, .status-form, .btn-admin {
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
                <h1>Order Details</h1>
                <div style="display: flex; gap: 10px;">
                    <a href="orders.php" class="btn-admin btn-secondary">← Back to Orders</a>
                    <button onclick="window.print()" class="btn-admin btn-primary">🖨️ Print</button>
                </div>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <!-- Order Header -->
            <div class="order-header-card">
                <h1>Order #<?php echo htmlspecialchars($order['order_number']); ?></h1>
                <div class="order-meta">
                    <div class="meta-item">
                        <div class="meta-label">Order Status</div>
                        <div class="meta-value"><?php echo ucfirst($order['order_status']); ?></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Payment Status</div>
                        <div class="meta-value"><?php echo ucfirst($order['payment_status']); ?></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Total Amount</div>
                        <div class="meta-value"><?php echo formatCurrency($order['total_amount']); ?></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Order Date</div>
                        <div class="meta-value"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="order-details-grid">
                <!-- Left Column -->
                <div>
                    <!-- Order Items -->
                    <div class="detail-card">
                        <h2>Order Items (<?php echo count($order_items); ?>)</h2>
                        <?php foreach ($order_items as $item): ?>
                            <div class="item-card">
                                <img src="<?php echo htmlspecialchars($item['image_url'] ?: '../images/placeholder.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                     class="item-image">
                                <div class="item-details">
                                    <div class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                    <div class="item-meta">
                                        SKU: <?php echo htmlspecialchars($item['sku']); ?>
                                        <?php if ($item['brand']): ?>
                                            | Brand: <?php echo htmlspecialchars($item['brand']); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="item-price">
                                        <span><?php echo formatCurrency($item['unit_price']); ?> × <?php echo $item['quantity']; ?></span>
                                        <strong><?php echo formatCurrency($item['subtotal']); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div style="margin-top: 20px;">
                            <div class="info-row">
                                <span>Subtotal:</span>
                                <span><?php echo formatCurrency($order['subtotal']); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Tax:</span>
                                <span><?php echo formatCurrency($order['tax_amount']); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Shipping:</span>
                                <span><?php echo formatCurrency($order['shipping_cost']); ?></span>
                            </div>
                            <div class="total-row">
                                <span>Total:</span>
                                <span><?php echo formatCurrency($order['total_amount']); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="detail-card">
                        <h2>Customer Information</h2>
                        <div class="info-row">
                            <span class="info-label">Name:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['email']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['phone'] ?: 'N/A'); ?></span>
                        </div>
                    </div>
                    
                    <!-- Addresses -->
                    <div class="detail-card">
                        <h2>Addresses</h2>
                        <div class="address-box">
                            <h4>📦 Shipping Address</h4>
                            <p>
                                <?php echo htmlspecialchars($order['shipping_address']); ?><br>
                                <?php echo htmlspecialchars($order['shipping_city']); ?>, <?php echo htmlspecialchars($order['shipping_state']); ?><br>
                                <?php echo htmlspecialchars($order['shipping_postal']); ?>, <?php echo htmlspecialchars($order['shipping_country']); ?>
                            </p>
                        </div>
                        <div class="address-box">
                            <h4>💳 Billing Address</h4>
                            <p>
                                <?php echo htmlspecialchars($order['billing_address']); ?><br>
                                <?php echo htmlspecialchars($order['billing_city']); ?>, <?php echo htmlspecialchars($order['billing_state']); ?><br>
                                <?php echo htmlspecialchars($order['billing_postal']); ?>, <?php echo htmlspecialchars($order['billing_country']); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    <div class="detail-card">
                        <h2>Order Notes</h2>
                        <form method="POST" style="margin-bottom: 20px;">
                            <textarea name="admin_note" rows="3" 
                                      style="width: 100%; padding: 12px; border: 2px solid rgba(226, 232, 240, 0.6); border-radius: 8px; font-family: inherit;"
                                      placeholder="Add a note about this order..."></textarea>
                            <button type="submit" name="add_note" class="btn-admin btn-primary" style="margin-top: 10px;">
                                Add Note
                            </button>
                        </form>
                        
                        <?php if (count($order_notes) > 0): ?>
                            <?php foreach ($order_notes as $note): ?>
                                <div class="note-card">
                                    <div class="note-header">
                                        <span class="note-author">Admin</span>
                                        <span class="note-date"><?php echo date('M d, Y h:i A', strtotime($note['created_at'])); ?></span>
                                    </div>
                                    <div class="note-text"><?php echo nl2br(htmlspecialchars($note['note_text'])); ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: #64748b; text-align: center; padding: 20px;">No notes yet</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div>
                    <!-- Update Order Status -->
                    <div class="detail-card">
                        <h2>Update Order Status</h2>
                        <form method="POST" class="status-form">
                            <label>Order Status</label>
                            <select name="order_status">
                                <option value="pending" <?php echo $order['order_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="processing" <?php echo $order['order_status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="shipped" <?php echo $order['order_status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="delivered" <?php echo $order['order_status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="cancelled" <?php echo $order['order_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_order_status" class="btn-admin btn-success" style="width: 100%;">
                                Update Status
                            </button>
                        </form>
                        
                        <form method="POST" class="status-form">
                            <label>Payment Status</label>
                            <select name="payment_status">
                                <option value="pending" <?php echo $order['payment_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo $order['payment_status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="failed" <?php echo $order['payment_status'] === 'failed' ? 'selected' : ''; ?>>Failed</option>
                                <option value="refunded" <?php echo $order['payment_status'] === 'refunded' ? 'selected' : ''; ?>>Refunded</option>
                            </select>
                            <button type="submit" name="update_payment_status" class="btn-admin btn-success" style="width: 100%;">
                                Update Payment
                            </button>
                        </form>
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="detail-card">
                        <h2>Payment Details</h2>
                        <div class="info-row">
                            <span class="info-label">Method:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="info-value">
                                <span class="status-badge status-<?php echo $order['payment_status']; ?>">
                                    <?php echo ucfirst($order['payment_status']); ?>
                                </span>
                            </span>
                        </div>
                        <?php if ($order['transaction_id']): ?>
                            <div class="info-row">
                                <span class="info-label">Transaction ID:</span>
                                <span class="info-value" style="font-size: 0.85rem;"><?php echo htmlspecialchars($order['transaction_id']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($order['payment_date']): ?>
                            <div class="info-row">
                                <span class="info-label">Payment Date:</span>
                                <span class="info-value"><?php echo date('M d, Y', strtotime($order['payment_date'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Shipping & Tracking -->
                    <div class="detail-card">
                        <h2>Shipping & Tracking</h2>
                        <form method="POST" class="status-form">
                            <label>Tracking Number</label>
                            <input type="text" name="tracking_number" 
                                   value="<?php echo htmlspecialchars($order['tracking_number'] ?: ''); ?>" 
                                   placeholder="Enter tracking number">
                            
                            <label>Carrier</label>
                            <input type="text" name="carrier" 
                                   value="<?php echo htmlspecialchars($order['carrier'] ?: ''); ?>" 
                                   placeholder="e.g., FedEx, UPS, USPS">
                            
                            <button type="submit" name="update_tracking" class="btn-admin btn-primary" style="width: 100%;">
                                Update Tracking
                            </button>
                        </form>
                        
                        <?php if ($order['shipped_date']): ?>
                            <div class="info-row">
                                <span class="info-label">Shipped Date:</span>
                                <span class="info-value"><?php echo date('M d, Y', strtotime($order['shipped_date'])); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($order['estimated_delivery_date']): ?>
                            <div class="info-row">
                                <span class="info-label">Est. Delivery:</span>
                                <span class="info-value"><?php echo date('M d, Y', strtotime($order['estimated_delivery_date'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Order Timeline -->
                    <div class="detail-card">
                        <h2>Order Timeline</h2>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-date"><?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?></div>
                                <div class="timeline-content">Order placed</div>
                            </div>
                            
                            <?php if ($order['payment_date']): ?>
                                <div class="timeline-item">
                                    <div class="timeline-date"><?php echo date('M d, Y h:i A', strtotime($order['payment_date'])); ?></div>
                                    <div class="timeline-content">Payment confirmed</div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($order['shipped_date']): ?>
                                <div class="timeline-item">
                                    <div class="timeline-date"><?php echo date('M d, Y h:i A', strtotime($order['shipped_date'])); ?></div>
                                    <div class="timeline-content">Order shipped</div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($order['order_status'] === 'delivered'): ?>
                                <div class="timeline-item">
                                    <div class="timeline-date"><?php echo date('M d, Y h:i A', strtotime($order['updated_at'])); ?></div>
                                    <div class="timeline-content">Order delivered</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if ($order['notes']): ?>
                        <div class="detail-card">
                            <h2>Customer Notes</h2>
                            <div style="background: rgba(226, 232, 240, 0.2); padding: 15px; border-radius: 10px; border: 1px solid rgba(226, 232, 240, 0.4);">
                                <?php echo nl2br(htmlspecialchars($order['notes'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>