<?php
/**
 * Notification System Functions
 * Send email and create in-app notifications for customers
 */

// Create notifications table (run this once)
function createNotificationsTable() {
    $conn = getDBConnection();
    $conn->query("
        CREATE TABLE IF NOT EXISTS notifications (
            notification_id INT PRIMARY KEY AUTO_INCREMENT,
            customer_id INT NOT NULL,
            order_id INT,
            type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            is_read BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
            FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL,
            INDEX idx_customer_read (customer_id, is_read),
            INDEX idx_created (created_at DESC)
        )
    ");
    $conn->close();
}

/**
 * Create a notification for a customer
 */
function createNotification($customer_id, $order_id, $type, $title, $message) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        INSERT INTO notifications (customer_id, order_id, type, title, message) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisss", $customer_id, $order_id, $type, $title, $message);
    $result = $stmt->execute();
    $conn->close();
    return $result;
}

/**
 * Send order status update notification
 */
function notifyOrderStatusChange($order_id, $new_status) {
    $conn = getDBConnection();
    
    // Get order and customer details
    $stmt = $conn->prepare("
        SELECT o.*, c.email, c.first_name, c.last_name 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        WHERE o.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $conn->close();
    
    if (!$order) return false;
    
    // Prepare notification content based on status
    $notifications = [
        'pending' => [
            'title' => 'Order Received',
            'message' => "We've received your order #{$order['order_number']}. We'll process it shortly.",
            'email_subject' => 'Order Confirmation',
            'email_body' => "
                <h2>Thank you for your order!</h2>
                <p>Hi {$order['first_name']},</p>
                <p>We've received your order <strong>#{$order['order_number']}</strong> and will begin processing it soon.</p>
                <p><strong>Order Total:</strong> " . formatCurrency($order['total_amount']) . "</p>
                <p>You can track your order status anytime by logging into your account.</p>
            "
        ],
        'processing' => [
            'title' => 'Order Processing',
            'message' => "Great news! Your order #{$order['order_number']} is now being processed.",
            'email_subject' => 'Your Order is Being Processed',
            'email_body' => "
                <h2>Your order is being processed</h2>
                <p>Hi {$order['first_name']},</p>
                <p>Good news! Your order <strong>#{$order['order_number']}</strong> is now being processed and will be shipped soon.</p>
                <p><strong>Order Total:</strong> " . formatCurrency($order['total_amount']) . "</p>
                <p>We'll notify you once it ships.</p>
            "
        ],
        'shipped' => [
            'title' => 'Order Shipped',
            'message' => "Your order #{$order['order_number']} has been shipped! It's on its way to you.",
            'email_subject' => 'Your Order Has Been Shipped',
            'email_body' => "
                <h2>Your order is on the way!</h2>
                <p>Hi {$order['first_name']},</p>
                <p>Exciting news! Your order <strong>#{$order['order_number']}</strong> has been shipped.</p>
                <p><strong>Order Total:</strong> " . formatCurrency($order['total_amount']) . "</p>
                <p>Track your order in your account to see estimated delivery date.</p>
            "
        ],
        'delivered' => [
            'title' => 'Order Delivered',
            'message' => "Your order #{$order['order_number']} has been delivered. Enjoy your purchase!",
            'email_subject' => 'Your Order Has Been Delivered',
            'email_body' => "
                <h2>Your order has been delivered!</h2>
                <p>Hi {$order['first_name']},</p>
                <p>Your order <strong>#{$order['order_number']}</strong> has been successfully delivered.</p>
                <p>We hope you love your purchase! If you have any questions or concerns, please don't hesitate to contact us.</p>
                <p>Thank you for shopping with us!</p>
            "
        ],
        'cancelled' => [
            'title' => 'Order Cancelled',
            'message' => "Your order #{$order['order_number']} has been cancelled.",
            'email_subject' => 'Order Cancellation Confirmation',
            'email_body' => "
                <h2>Your order has been cancelled</h2>
                <p>Hi {$order['first_name']},</p>
                <p>Your order <strong>#{$order['order_number']}</strong> has been cancelled as requested.</p>
                <p>If you didn't request this cancellation or have questions, please contact our support team.</p>
                <p>Thank you for your understanding.</p>
            "
        ]
    ];
    
    if (!isset($notifications[$new_status])) {
        return false;
    }
    
    $notif = $notifications[$new_status];
    
    // Create in-app notification
    createNotification(
        $order['customer_id'],
        $order_id,
        'order_status',
        $notif['title'],
        $notif['message']
    );
    
    // Send email notification
    sendEmailNotification(
        $order['email'],
        $order['first_name'],
        $notif['email_subject'],
        $notif['email_body'],
        $order['order_number']
    );
    
    return true;
}

/**
 * Send email via Gmail SMTP
 */
function sendGmailSMTP($to_email, $subject, $body, $from_email, $from_name) {
    $smtp_host = GMAIL_SMTP_HOST;
    $smtp_port = GMAIL_SMTP_PORT;
    $smtp_user = GMAIL_SENDER_EMAIL;
    $smtp_pass = GMAIL_SENDER_PASSWORD;
    
    try {
        $socket = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 10);
        
        if (!$socket) {
            error_log("SMTP Connection failed: $errstr ($errno)");
            return false;
        }
        
        $response = fgets($socket, 1024);
        if (strpos($response, '220') === false) {
            fclose($socket);
            return false;
        }
        
        fwrite($socket, "EHLO [127.0.0.1]\r\n");
        $response = fgets($socket, 1024);
        
        fwrite($socket, "STARTTLS\r\n");
        $response = fgets($socket, 1024);
        
        if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            fclose($socket);
            error_log("STARTTLS failed");
            return false;
        }
        
        fwrite($socket, "EHLO [127.0.0.1]\r\n");
        $response = fgets($socket, 1024);
        
        fwrite($socket, "AUTH LOGIN\r\n");
        fgets($socket, 1024);
        
        fwrite($socket, base64_encode($smtp_user) . "\r\n");
        fgets($socket, 1024);
        
        fwrite($socket, base64_encode($smtp_pass) . "\r\n");
        $response = fgets($socket, 1024);
        
        if (strpos($response, '235') === false) {
            fclose($socket);
            error_log("SMTP Authentication failed");
            return false;
        }
        
        fwrite($socket, "MAIL FROM:<{$smtp_user}>\r\n");
        fgets($socket, 1024);
        
        fwrite($socket, "RCPT TO:<{$to_email}>\r\n");
        $response = fgets($socket, 1024);
        
        if (strpos($response, '250') === false) {
            fclose($socket);
            error_log("RCPT TO failed");
            return false;
        }
        
        fwrite($socket, "DATA\r\n");
        fgets($socket, 1024);
        
        $headers = "From: {$from_name} <{$from_email}>\r\n";
        $headers .= "To: {$to_email}\r\n";
        $headers .= "Subject: {$subject}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "\r\n";
        
        $message = $headers . $body . "\r\n.\r\n";
        fwrite($socket, $message);
        $response = fgets($socket, 1024);
        
        fwrite($socket, "QUIT\r\n");
        fclose($socket);
        
        return strpos($response, '250') !== false;
        
    } catch (Exception $e) {
        error_log("SMTP Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send email notification
 */
function sendEmailNotification($to_email, $customer_name, $subject, $body, $order_number) {
    $site_name = SITE_NAME;
    $site_email = SITE_EMAIL;
    
    $email_template = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            .email-container {
                background: #ffffff;
                border-radius: 10px;
                padding: 30px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .header {
                background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%);
                color: white;
                padding: 20px;
                border-radius: 10px 10px 0 0;
                text-align: center;
                margin: -30px -30px 30px -30px;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
            }
            .content {
                padding: 20px 0;
            }
            .button {
                display: inline-block;
                background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%);
                color: white;
                padding: 12px 30px;
                text-decoration: none;
                border-radius: 8px;
                margin: 20px 0;
                font-weight: bold;
            }
            .footer {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eee;
                text-align: center;
                color: #999;
                font-size: 12px;
            }
            .order-info {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h1>{$site_name}</h1>
            </div>
            <div class='content'>
                {$body}
                <div class='order-info'>
                    <p><strong>Order Number:</strong> {$order_number}</p>
                </div>
                <center>
                    <a href='" . getBaseUrl() . "/orders.php' class='button'>View Order Details</a>
                </center>
            </div>
            <div class='footer'>
                <p>This is an automated message from {$site_name}. Please do not reply to this email.</p>
                <p>If you have questions, contact us at {$site_email}</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return sendGmailSMTP($to_email, $subject, $email_template, GMAIL_SENDER_EMAIL, $site_name);
}

/**
 * Get base URL for links in emails
 */
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);
    return $protocol . "://" . $host . $script;
}

/**
 * Get unread notification count for customer
 */
function getUnreadNotificationCount($customer_id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM notifications WHERE customer_id = ? AND is_read = 0");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $conn->close();
    return $result['count'];
}

/**
 * Get notifications for customer
 */
function getCustomerNotifications($customer_id, $limit = 20, $offset = 0) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT n.*, o.order_number 
        FROM notifications n 
        LEFT JOIN orders o ON n.order_id = o.order_id 
        WHERE n.customer_id = ? 
        ORDER BY n.created_at DESC 
        LIMIT ? OFFSET ?
    ");
    $stmt->bind_param("iii", $customer_id, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

/**
 * Mark notification as read
 */
function markNotificationAsRead($notification_id, $customer_id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE notification_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $notification_id, $customer_id);
    $result = $stmt->execute();
    $conn->close();
    return $result;
}

/**
 * Mark all notifications as read
 */
function markAllNotificationsAsRead($customer_id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE customer_id = ? AND is_read = 0");
    $stmt->bind_param("i", $customer_id);
    $result = $stmt->execute();
    $conn->close();
    return $result;
}

/**
 * Initialize notification system (call once)
 */
function initializeNotificationSystem() {
    createNotificationsTable();
    echo "Notification system initialized successfully!";
}

// Uncomment this line and run once to initialize:
// initializeNotificationSystem();
?>