<?php
/**
 * Email Functions using Gmail SMTP
 * Requires PHPMailer library
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader (adjust path if needed)
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Initialize PHPMailer with Gmail SMTP settings
 */
function getMailer() {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = GMAIL_SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = GMAIL_SENDER_EMAIL;
        $mail->Password   = GMAIL_SENDER_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = GMAIL_SMTP_PORT;
        
        // Sender info
        $mail->setFrom(GMAIL_SENDER_EMAIL, SITE_NAME);
        
        // Content settings
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        return $mail;
    } catch (Exception $e) {
        error_log("PHPMailer initialization error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send order confirmation email
 */
function sendOrderConfirmationEmail($order_id, $customer_email, $customer_name, $order_number, $total) {
    try {
        $mail = getMailer();
        if (!$mail) return false;
        
        $mail->addAddress($customer_email, $customer_name);
        $mail->Subject = "Order Confirmation - $order_number";
        
        $mail->Body = getOrderConfirmationTemplate($order_number, $customer_name, $total, $order_id);
        $mail->AltBody = "Thank you for your order #$order_number. Total: " . formatCurrency($total);
        
        $result = $mail->send();
        if ($result) {
            error_log("Order confirmation email sent to $customer_email for order $order_number");
            
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT customer_id FROM orders WHERE order_id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $order_row = $stmt->get_result()->fetch_assoc();
            
            if ($order_row) {
                logCustomerActivity(
                    $order_row['customer_id'],
                    'email_sent',
                    "Order confirmation email sent: $order_number to $customer_email",
                    null,
                    null,
                    null,
                    [
                        'to' => $customer_email,
                        'subject' => 'Order Confirmation',
                        'order_number' => $order_number
                    ]
                );
            }
            $conn->close();
        }
        return $result;
    } catch (Exception $e) {
        error_log("Order confirmation email error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send order status update email
 */
function sendOrderStatusEmail($order_id, $customer_email, $customer_name, $order_number, $status) {
    try {
        $mail = getMailer();
        if (!$mail) return false;
        
        $mail->addAddress($customer_email, $customer_name);
        
        $status_titles = [
            'processing' => 'Order is Being Processed',
            'shipped' => 'Order Has Been Shipped',
            'delivered' => 'Order Delivered',
            'cancelled' => 'Order Cancelled'
        ];
        
        $subject = $status_titles[$status] ?? 'Order Status Update';
        $mail->Subject = "$subject - $order_number";
        
        $mail->Body = getOrderStatusTemplate($order_number, $customer_name, $status, $order_id);
        $mail->AltBody = "Your order #$order_number status has been updated to: $status";
        
        $result = $mail->send();
        if ($result) {
            error_log("Order status email sent to $customer_email for order $order_number - Status: $status");
            
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT customer_id FROM orders WHERE order_id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $order_row = $stmt->get_result()->fetch_assoc();
            
            if ($order_row) {
                logCustomerActivity(
                    $order_row['customer_id'],
                    'email_sent',
                    "Order status email sent: $order_number - Status changed to $status",
                    null,
                    null,
                    null,
                    [
                        'to' => $customer_email,
                        'subject' => 'Order Status Update',
                        'status' => $status
                    ]
                );
            }
            $conn->close();
        }
        return $result;
    } catch (Exception $e) {
        error_log("Order status email error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send payment confirmation email
 */
function sendPaymentConfirmationEmail($order_id, $customer_email, $customer_name, $order_number, $amount, $payment_method) {
    try {
        $mail = getMailer();
        if (!$mail) return false;
        
        $mail->addAddress($customer_email, $customer_name);
        $mail->Subject = "Payment Confirmed - $order_number";
        
        $mail->Body = getPaymentConfirmationTemplate($order_number, $customer_name, $amount, $payment_method);
        $mail->AltBody = "Payment confirmed for order #$order_number. Amount: " . formatCurrency($amount);
        
        $result = $mail->send();
        if ($result) {
            error_log("Payment confirmation email sent to $customer_email for order $order_number");
            
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT customer_id FROM orders WHERE order_id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $order_row = $stmt->get_result()->fetch_assoc();
            
            if ($order_row) {
                logCustomerActivity(
                    $order_row['customer_id'],
                    'email_sent',
                    "Payment confirmation email sent: $order_number for $amount via $payment_method",
                    null,
                    null,
                    null,
                    [
                        'to' => $customer_email,
                        'subject' => 'Payment Confirmation',
                        'amount' => $amount,
                        'payment_method' => $payment_method
                    ]
                );
            }
            $conn->close();
        }
        return $result;
    } catch (Exception $e) {
        error_log("Payment confirmation email error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send shipping notification email
 */
function sendShippingNotificationEmail($order_id, $customer_email, $customer_name, $order_number, $tracking_number = null) {
    try {
        $mail = getMailer();
        if (!$mail) return false;
        
        $mail->addAddress($customer_email, $customer_name);
        $mail->Subject = "Your Order Has Shipped - $order_number";
        
        $mail->Body = getShippingNotificationTemplate($order_number, $customer_name, $tracking_number);
        $mail->AltBody = "Your order #$order_number has been shipped!" . ($tracking_number ? " Tracking: $tracking_number" : "");
        
        $result = $mail->send();
        if ($result) {
            error_log("Shipping notification email sent to $customer_email for order $order_number");
            
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT customer_id FROM orders WHERE order_id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $order_row = $stmt->get_result()->fetch_assoc();
            
            if ($order_row) {
                logCustomerActivity(
                    $order_row['customer_id'],
                    'email_sent',
                    "Shipping notification email sent: $order_number" . ($tracking_number ? " with tracking $tracking_number" : ""),
                    null,
                    null,
                    null,
                    [
                        'to' => $customer_email,
                        'subject' => 'Shipping Notification',
                        'tracking_number' => $tracking_number
                    ]
                );
            }
            $conn->close();
        }
        return $result;
    } catch (Exception $e) {
        error_log("Shipping notification email error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send welcome email to new customer
 */
function sendWelcomeEmail($customer_email, $customer_name) {
    try {
        $mail = getMailer();
        if (!$mail) return false;
        
        $mail->addAddress($customer_email, $customer_name);
        $mail->Subject = "Welcome to " . SITE_NAME . "!";
        
        $mail->Body = getWelcomeEmailTemplate($customer_name);
        $mail->AltBody = "Welcome to " . SITE_NAME . "! Thank you for joining us.";
        
        $result = $mail->send();
        if ($result) {
            error_log("Welcome email sent to $customer_email");
            
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
            $stmt->bind_param("s", $customer_email);
            $stmt->execute();
            $customer_row = $stmt->get_result()->fetch_assoc();
            
            if ($customer_row) {
                logCustomerActivity(
                    $customer_row['customer_id'],
                    'email_sent',
                    "Welcome email sent to $customer_email",
                    null,
                    null,
                    null,
                    [
                        'to' => $customer_email,
                        'subject' => 'Welcome to ' . SITE_NAME
                    ]
                );
            }
            $conn->close();
        }
        return $result;
    } catch (Exception $e) {
        error_log("Welcome email error: " . $e->getMessage());
        return false;
    }
}

/**
 * Email Templates
 */

function getOrderConfirmationTemplate($order_number, $customer_name, $total, $order_id) {
    $site_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    $order_url = $site_url . "/orders.php?order_id=" . $order_id;
    
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .order-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .button { display: inline-block; background: #7c3aed; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>✅ Order Confirmed!</h1>
            </div>
            <div class='content'>
                <p>Hi <strong>$customer_name</strong>,</p>
                <p>Thank you for your order! We've received your order and it's being processed.</p>
                
                <div class='order-details'>
                    <h2>Order Details</h2>
                    <p><strong>Order Number:</strong> $order_number</p>
                    <p><strong>Total Amount:</strong> " . formatCurrency($total) . "</p>
                </div>
                
                <p>You can track your order status at any time:</p>
                <a href='$order_url' class='button'>View Order Details</a>
                
                <p>We'll send you another email when your order ships.</p>
                
                <p>Thank you for shopping with " . SITE_NAME . "!</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " " . SITE_NAME . ". All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

function getOrderStatusTemplate($order_number, $customer_name, $status, $order_id) {
    $site_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    $order_url = $site_url . "/orders.php?order_id=" . $order_id;
    
    $status_messages = [
        'processing' => ['emoji' => '⚙️', 'title' => 'Order is Being Processed', 'message' => 'Your order is now being prepared for shipment.'],
        'shipped' => ['emoji' => '📦', 'title' => 'Order Has Been Shipped', 'message' => 'Your order is on its way to you!'],
        'delivered' => ['emoji' => '✅', 'title' => 'Order Delivered', 'message' => 'Your order has been successfully delivered.'],
        'cancelled' => ['emoji' => '❌', 'title' => 'Order Cancelled', 'message' => 'Your order has been cancelled.']
    ];
    
    $status_info = $status_messages[$status] ?? ['emoji' => '📋', 'title' => 'Order Status Update', 'message' => 'Your order status has been updated.'];
    
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .status-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
            .button { display: inline-block; background: #7c3aed; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>{$status_info['emoji']} {$status_info['title']}</h1>
            </div>
            <div class='content'>
                <p>Hi <strong>$customer_name</strong>,</p>
                
                <div class='status-box'>
                    <h2>Order #$order_number</h2>
                    <p style='font-size: 18px; color: #7c3aed;'><strong>" . ucfirst($status) . "</strong></p>
                    <p>{$status_info['message']}</p>
                </div>
                
                <a href='$order_url' class='button'>View Order Details</a>
                
                <p>If you have any questions, please don't hesitate to contact us.</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " " . SITE_NAME . ". All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

function getPaymentConfirmationTemplate($order_number, $customer_name, $amount, $payment_method) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .payment-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>💳 Payment Confirmed</h1>
            </div>
            <div class='content'>
                <p>Hi <strong>$customer_name</strong>,</p>
                <p>Your payment has been successfully processed!</p>
                
                <div class='payment-details'>
                    <h2>Payment Details</h2>
                    <p><strong>Order Number:</strong> $order_number</p>
                    <p><strong>Amount Paid:</strong> " . formatCurrency($amount) . "</p>
                    <p><strong>Payment Method:</strong> $payment_method</p>
                </div>
                
                <p>Your order will be processed shortly.</p>
                
                <p>Thank you for your business!</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " " . SITE_NAME . ". All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

function getShippingNotificationTemplate($order_number, $customer_name, $tracking_number) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .shipping-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .tracking { background: #f0f0f0; padding: 15px; border-radius: 6px; font-size: 18px; font-weight: bold; text-align: center; margin: 15px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🚚 Your Order Has Shipped!</h1>
            </div>
            <div class='content'>
                <p>Hi <strong>$customer_name</strong>,</p>
                <p>Great news! Your order has been shipped and is on its way to you.</p>
                
                <div class='shipping-box'>
                    <h2>Shipping Details</h2>
                    <p><strong>Order Number:</strong> $order_number</p>
                    " . ($tracking_number ? "<p><strong>Tracking Number:</strong></p><div class='tracking'>$tracking_number</div>" : "<p>You will receive a tracking number soon.</p>") . "
                </div>
                
                <p>Your order should arrive within 3-7 business days.</p>
                
                <p>Thank you for shopping with " . SITE_NAME . "!</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " " . SITE_NAME . ". All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

function getWelcomeEmailTemplate($customer_name) {
    $site_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed 0%, #06d6a0 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .button { display: inline-block; background: #7c3aed; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🎉 Welcome to " . SITE_NAME . "!</h1>
            </div>
            <div class='content'>
                <p>Hi <strong>$customer_name</strong>,</p>
                <p>Thank you for joining " . SITE_NAME . "! We're excited to have you as part of our community.</p>
                
                <p>Here's what you can do now:</p>
                <ul>
                    <li>Browse our latest products</li>
                    <li>Add items to your wishlist</li>
                    <li>Enjoy exclusive member benefits</li>
                    <li>Track your orders easily</li>
                </ul>
                
                <a href='$site_url' class='button'>Start Shopping</a>
                
                <p>If you have any questions, feel free to contact us at " . SITE_EMAIL . "</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " " . SITE_NAME . ". All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}