<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$error = '';
$success = '';

// Get cart items
$conn = getDBConnection();
$stmt = $conn->prepare("
    SELECT sc.*, p.product_name, p.price, p.sale_price, p.sku
    FROM shopping_cart sc
    JOIN products p ON sc.product_id = p.product_id
    WHERE sc.customer_id = ?
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Check if cart is empty
if (count($cart_items) === 0) {
    header('Location: cart.php');
    exit;
}

// Get customer addresses
$stmt = $conn->prepare("SELECT * FROM addresses WHERE customer_id = ? ORDER BY is_default DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$addresses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate totals using config functions
$subtotal = 0;
foreach ($cart_items as $item) {
    $price = $item['sale_price'] ?: $item['price'];
    $subtotal += $price * $item['quantity'];
}
$tax = calculateTax($subtotal);
$shipping = calculateShipping($subtotal);
$total = $subtotal + $tax + $shipping;

// Handle checkout submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // FIX: Check if keys exist before accessing them
    $shipping_address_id = isset($_POST['shipping_address_id']) ? intval($_POST['shipping_address_id']) : 0;
    $billing_address_id = isset($_POST['billing_address_id']) ? intval($_POST['billing_address_id']) : 0;
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
    
    if (empty($shipping_address_id) || empty($billing_address_id) || empty($payment_method)) {
        $error = 'Please complete all required fields.';
    } else {
        // Generate order number
        $order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Create order
            $stmt = $conn->prepare("
                INSERT INTO orders (customer_id, order_number, order_status, subtotal, tax_amount, shipping_cost, total_amount, 
                                   shipping_address_id, billing_address_id, payment_method, payment_status, notes)
                VALUES (?, ?, 'pending', ?, ?, ?, ?, ?, ?, ?, 'pending', ?)
            ");
            $stmt->bind_param("isdddiisss", $customer_id, $order_number, $subtotal, $tax, $shipping, $total, 
                            $shipping_address_id, $billing_address_id, $payment_method, $notes);
            $stmt->execute();
            $order_id = $conn->insert_id;
            
            // Insert order items
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?)");
            foreach ($cart_items as $item) {
                $price = $item['sale_price'] ?: $item['price'];
                $item_subtotal = $price * $item['quantity'];
                $stmt->bind_param("iiidd", $order_id, $item['product_id'], $item['quantity'], $price, $item_subtotal);
                $stmt->execute();
            }
            
            // Create payment record
            $stmt = $conn->prepare("INSERT INTO payments (order_id, payment_method, amount, payment_status) VALUES (?, ?, ?, 'pending')");
            $stmt->bind_param("isd", $order_id, $payment_method, $total);
            $stmt->execute();
            
            // Create shipping record
            $stmt = $conn->prepare("INSERT INTO shipping (order_id, status, shipping_method) VALUES (?, 'preparing', 'Standard')");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            
            // Don't clear cart yet - will clear after successful payment
            
            // Commit transaction
            $conn->commit();
            
            // Redirect to payment page
            header("Location: payment.php?order_id=" . $order_id);
            exit;
            
        } catch (Exception $e) {
            $conn->rollback();
            $error = 'Failed to process order. Please try again.';
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }
        
        .checkout-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .checkout-section h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .address-selector {
            display: grid;
            gap: 15px;
        }
        
        .address-option {
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .address-option:hover {
            border-color: #3498db;
        }
        
        .address-option input[type="radio"] {
            margin-right: 10px;
        }
        
        .address-option.selected {
            border-color: #3498db;
            background: #e3f2fd;
        }
        
        .payment-methods {
            display: grid;
            gap: 15px;
        }
        
        .payment-option {
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .payment-option:hover {
            border-color: #3498db;
        }
        
        .payment-option input[type="radio"] {
            margin-right: 10px;
        }
        
        .payment-option.selected {
            border-color: #3498db;
            background: #e3f2fd;
        }
        
        .payment-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .order-summary {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .summary-item.total {
            font-size: 1.3rem;
            font-weight: bold;
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 15px;
            color: #27ae60;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .item-name {
            flex: 1;
        }
        
        .item-quantity {
            color: #7f8c8d;
            margin: 0 10px;
        }
        
        .item-price {
            font-weight: bold;
        }
        
        .add-address-link {
            display: inline-block;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }
        
        .add-address-link:hover {
            text-decoration: underline;
        }
        
        .secure-checkout-badge {
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .secure-checkout-badge strong {
            color: var(--success);
            display: block;
            margin-bottom: 5px;
        }
        
        @media (max-width: 968px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
            
            .order-summary {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="checkout-container">
        <h1>Checkout</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" id="checkoutForm">
            <div class="checkout-grid">
                <div>
                    <!-- Shipping Address -->
                    <div class="checkout-section">
                        <h2>Shipping Address</h2>
                        <?php if (count($addresses) > 0): ?>
                            <div class="address-selector">
                                <?php foreach ($addresses as $index => $address): ?>
                                    <label class="address-option">
                                        <input type="radio" name="shipping_address_id" value="<?php echo $address['address_id']; ?>" 
                                               <?php echo ($address['is_default'] || $index === 0) ? 'checked' : ''; ?> required>
                                        <div>
                                            <strong><?php echo ucfirst($address['address_type']); ?> Address</strong>
                                            <?php if ($address['is_default']): ?>
                                                <span style="background: #3498db; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 5px;">Default</span>
                                            <?php endif; ?>
                                            <p style="margin: 5px 0 0 0; color: #666;">
                                                <?php echo htmlspecialchars($address['street_address']); ?>,
                                                <?php echo htmlspecialchars($address['city']); ?>,
                                                <?php echo htmlspecialchars($address['state_province']); ?>
                                                <?php echo htmlspecialchars($address['postal_code']); ?>
                                            </p>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>No addresses found. <a href="profile.php" class="add-address-link">Add an address</a></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Billing Address -->
                    <div class="checkout-section">
                        <h2>Billing Address</h2>
                        <?php if (count($addresses) > 0): ?>
                            <div class="address-selector">
                                <label class="address-option">
                                    <input type="radio" name="use_shipping_for_billing" value="1" checked 
                                           onchange="toggleBillingAddress(false)">
                                    <strong>Same as shipping address</strong>
                                </label>
                                <label class="address-option">
                                    <input type="radio" name="use_shipping_for_billing" value="0"
                                           onchange="toggleBillingAddress(true)">
                                    <strong>Use different billing address</strong>
                                </label>
                                
                                <div id="billing_addresses" style="display: none; margin-top: 15px;">
                                    <?php foreach ($addresses as $index => $address): ?>
                                        <label class="address-option">
                                            <input type="radio" name="billing_address_id" value="<?php echo $address['address_id']; ?>"
                                                   <?php echo $index === 0 ? 'data-first="true"' : ''; ?>>
                                            <div>
                                                <strong><?php echo ucfirst($address['address_type']); ?> Address</strong>
                                                <p style="margin: 5px 0 0 0; color: #666;">
                                                    <?php echo htmlspecialchars($address['street_address']); ?>,
                                                    <?php echo htmlspecialchars($address['city']); ?>,
                                                    <?php echo htmlspecialchars($address['state_province']); ?>
                                                </p>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="checkout-section">
                        <h2>Payment Method</h2>
                        <p style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 15px;">
                            You will be redirected to complete your payment on the next page.
                        </p>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="Credit Card" required>
                                <span class="payment-icon">💳</span>
                                <strong>Credit Card</strong>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="Debit Card">
                                <span class="payment-icon">💳</span>
                                <strong>Debit Card</strong>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="PayPal">
                                <span class="payment-icon">🅿️</span>
                                <strong>PayPal</strong>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="GCash">
                                <span class="payment-icon">📱</span>
                                <strong>GCash</strong>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="Cash on Delivery">
                                <span class="payment-icon">💵</span>
                                <strong>Cash on Delivery</strong>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    <div class="checkout-section">
                        <h2>Order Notes (Optional)</h2>
                        <textarea name="notes" rows="4" placeholder="Special instructions for your order..." 
                                  style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit;"></textarea>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div>
                    <div class="order-summary">
                        <h2>Order Summary</h2>
                        
                        <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                            <?php foreach ($cart_items as $item): 
                                $price = $item['sale_price'] ?: $item['price'];
                            ?>
                                <div class="order-item">
                                    <span class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                    <span class="item-quantity">x<?php echo $item['quantity']; ?></span>
                                    <span class="item-price"><?php echo formatCurrency($price * $item['quantity']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="summary-item">
                            <span>Subtotal:</span>
                            <span><?php echo formatCurrency($subtotal); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Tax (<?php echo (TAX_RATE * 100); ?>%):</span>
                            <span><?php echo formatCurrency($tax); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Shipping:</span>
                            <span><?php echo $shipping > 0 ? formatCurrency($shipping) : 'FREE'; ?></span>
                        </div>
                        <div class="summary-item total">
                            <span>Total:</span>
                            <span><?php echo formatCurrency($total); ?></span>
                        </div>
                        
                        <button type="submit" name="place_order" class="btn btn-primary btn-block" style="margin-top: 20px;">
                            Continue to Payment
                        </button>
                        
                        <div class="secure-checkout-badge">
                            <strong>🔒 Secure Checkout</strong>
                            <small style="color: #666;">Your payment information is encrypted and secure</small>
                        </div>
                        
                        <a href="cart.php" style="display: block; text-align: center; margin-top: 15px; color: #3498db; text-decoration: none;">
                            ← Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        const form = document.getElementById('checkoutForm');
        
        // Toggle billing address visibility
        function toggleBillingAddress(show) {
            const billingDiv = document.getElementById('billing_addresses');
            billingDiv.style.display = show ? 'block' : 'none';
            
            // If showing, select first address; if hiding, clear selection
            const billingInputs = billingDiv.querySelectorAll('input[name="billing_address_id"]');
            billingInputs.forEach(input => {
                input.required = show;
                if (show && input.hasAttribute('data-first')) {
                    input.checked = true;
                    input.closest('.address-option').classList.add('selected');
                }
            });
        }
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            const useShippingForBilling = document.querySelector('input[name="use_shipping_for_billing"]:checked');
            
            if (useShippingForBilling && useShippingForBilling.value === '1') {
                // Use shipping address for billing
                const shippingAddressId = document.querySelector('input[name="shipping_address_id"]:checked').value;
                
                // Remove any existing hidden billing input
                const existingHidden = form.querySelector('input[name="billing_address_id"][type="hidden"]');
                if (existingHidden) {
                    existingHidden.remove();
                }
                
                // Create hidden input with shipping address
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'billing_address_id';
                hiddenInput.value = shippingAddressId;
                form.appendChild(hiddenInput);
            }
        });
        
        // Add visual feedback for selected options
        document.querySelectorAll('.address-option input, .payment-option input').forEach(input => {
            input.addEventListener('change', function() {
                const container = this.closest('.address-selector, .payment-methods');
                container.querySelectorAll('.address-option, .payment-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.closest('.address-option, .payment-option').classList.add('selected');
            });
        });
        
        // Initialize selected states
        document.querySelectorAll('.address-option input:checked, .payment-option input:checked').forEach(input => {
            input.closest('.address-option, .payment-option').classList.add('selected');
        });
    </script>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>