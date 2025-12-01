<?php
require_once 'config.php';
require_once 'includes/email.php';

// ... your existing checkout code ...

// After order is created successfully
if ($order_created_successfully) {
    // Get customer details
    $customer = getCurrentUser();
    
    // Send order confirmation email (only if enabled)
    if (ENABLE_EMAIL_NOTIFICATIONS && ENABLE_ORDER_EMAILS) {
        sendOrderConfirmationEmail(
            $order_id,
            $customer['email'],
            $customer['first_name'] . ' ' . $customer['last_name'],
            $order_number,
            $total_amount
        );
    }
}
?>