<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$error = '';
$success = '';

// Get order information
if (!isset($_GET['order_id'])) {
    header('Location: orders.php');
    exit;
}

$order_id = intval($_GET['order_id']);

// Verify order belongs to customer and get order details
$conn = getDBConnection();
$stmt = $conn->prepare("
    SELECT o.*, p.payment_id, p.payment_status, p.payment_method as payment_method_used,
           a.street_address, a.city, a.state_province, a.postal_code, a.country
    FROM orders o
    LEFT JOIN payments p ON o.order_id = p.order_id
    LEFT JOIN addresses a ON o.shipping_address_id = a.address_id
    WHERE o.order_id = ? AND o.customer_id = ?
");
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $conn->close();
    header('Location: orders.php');
    exit;
}

$order = $result->fetch_assoc();

// Check if payment is already completed
if ($order['payment_status'] === 'completed') {
    $conn->close();
    header('Location: order_success.php?order_number=' . urlencode($order['order_number']));
    exit;
}

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

// Handle payment processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_payment'])) {
    $payment_method = $order['payment_method'];
    
    // Simulate payment processing based on payment method
    $payment_successful = false;
    $transaction_id = 'TXN-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
    
    switch ($payment_method) {
        case 'Credit Card':
        case 'Debit Card':
            $card_number = isset($_POST['card_number']) ? str_replace(' ', '', $_POST['card_number']) : '';
            $card_name = isset($_POST['card_name']) ? trim($_POST['card_name']) : '';
            $expiry = isset($_POST['expiry']) ? $_POST['expiry'] : '';
            $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';
            
            // Validate card name (letters only)
            if (!preg_match("/^[a-zA-Z\s'-]+$/", $card_name)) {
                $error = 'Cardholder name should only contain letters.';
                break;
            }
            
            // Validate card number (numbers only)
            if (!preg_match("/^[0-9]+$/", $card_number)) {
                $error = 'Card number should only contain numbers.';
                break;
            }
            
            // Validate CVV (numbers only)
            if (!preg_match("/^[0-9]+$/", $cvv)) {
                $error = 'CVV should only contain numbers.';
                break;
            }
            
            // Basic validation
            if (strlen($card_number) >= 13 && strlen($card_number) <= 19 && 
                !empty($card_name) && !empty($expiry) && strlen($cvv) >= 3) {
                $payment_successful = true;
            } else {
                $error = 'Invalid card details. Please check and try again.';
            }
            break;
            
        case 'PayPal':
            $paypal_email = isset($_POST['paypal_email']) ? trim($_POST['paypal_email']) : '';
            if (filter_var($paypal_email, FILTER_VALIDATE_EMAIL)) {
                $payment_successful = true;
            } else {
                $error = 'Invalid PayPal email address.';
            }
            break;
            
        case 'GCash':
            $gcash_number = isset($_POST['gcash_number']) ? trim($_POST['gcash_number']) : '';
            
            // Remove any spaces or dashes and validate numbers only
            $gcash_number = preg_replace('/[^0-9]/', '', $gcash_number);
            
            if (!preg_match("/^[0-9]+$/", $gcash_number)) {
                $error = 'GCash number should only contain numbers.';
            } elseif (strlen($gcash_number) < 10) {
                $error = 'Invalid GCash number. Must be at least 10 digits.';
            } else {
                $payment_successful = true;
            }
            break;
            
        case 'Cash on Delivery':
            // COD doesn't require payment processing now
            $payment_successful = true;
            $transaction_id = 'COD-' . $order['order_number'];
            break;
            
        default:
            $error = 'Invalid payment method.';
            break;
    }
    
    if ($payment_successful && empty($error)) {
        try {
            // Start transaction
            $conn->begin_transaction();
            
            // Update payment record
            $payment_date = date('Y-m-d H:i:s');
            $payment_status = ($payment_method === 'Cash on Delivery') ? 'pending' : 'completed';
            
            $stmt = $conn->prepare("
                UPDATE payments 
                SET payment_status = ?, transaction_id = ?, payment_date = ? 
                WHERE order_id = ?
            ");
            $stmt->bind_param("sssi", $payment_status, $transaction_id, $payment_date, $order_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to update payment record");
            }
            
            // Update order payment status
            $stmt = $conn->prepare("UPDATE orders SET payment_status = ?, order_status = 'processing' WHERE order_id = ?");
            $stmt->bind_param("si", $payment_status, $order_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to update order status");
            }
            
            // Update shipping status
            $stmt = $conn->prepare("UPDATE shipping SET status = 'preparing' WHERE order_id = ?");
            $stmt->bind_param("i", $order_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to update shipping status");
            }
            
            // Clear shopping cart after successful payment
            $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE customer_id = ?");
            $stmt->bind_param("i", $customer_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to clear shopping cart");
            }
            
            // Commit transaction
            $conn->commit();
            
            $stmt->close();
            $conn->close();
            
            // Redirect to success page - CRITICAL: Must exit immediately after
            header('Location: order_success.php?order_number=' . urlencode($order['order_number']));
            exit();
            
        } catch (Exception $e) {
            $conn->rollback();
            $error = 'Payment processing failed: ' . $e->getMessage();
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
    <title>Payment - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .form-input.error {
            border-color: #dc2626;
        }

        .input-error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: none;
        }

        .input-error.show {
            display: block;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="payment-container">
        <h1>Complete Your Payment</h1>
        <p style="color: #7f8c8d; margin-bottom: 30px;">Order #<?php echo htmlspecialchars($order['order_number']); ?></p>
        
        <?php if ($error): ?>
            <div class="alert alert-error" style="background: #fef2f2; border: 2px solid #dc2626; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success" style="background: #f0fdf4; border: 2px solid #16a34a; color: #16a34a; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
                ✓ <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <div class="payment-grid">
            <div>
                <div class="payment-section">
                    <h2>Payment Method</h2>
                    
                    <div class="payment-method-display">
                        <strong><?php echo htmlspecialchars($order['payment_method']); ?></strong>
                    </div>
                    
                    <form method="POST" id="paymentForm" action="" novalidate>
                        <!-- Credit/Debit Card Form -->
                        <?php if (strpos($order['payment_method'], 'Card') !== false): ?>
                        <div class="payment-form active">
                            <div class="card-icons">
                                <div class="card-icon">VISA</div>
                                <div class="card-icon">MC</div>
                                <div class="card-icon">AMEX</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Card Number *</label>
                                <input type="text" name="card_number" id="card_number" class="form-input" 
                                       placeholder="1234 5678 9012 3456" maxlength="19" required autocomplete="off">
                                <div class="input-error" id="cardNumberError">Please enter a valid card number (numbers only)</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Cardholder Name *</label>
                                <input type="text" name="card_name" id="card_name" class="form-input" 
                                       placeholder="John Doe" required autocomplete="off">
                                <div class="input-error" id="cardNameError">Please enter a valid name (letters only)</div>
                            </div>
                            
                            <div class="card-input-group">
                                <div class="form-group">
                                    <label>Expiry Date *</label>
                                    <input type="text" name="expiry" id="expiryDate" class="form-input" 
                                           placeholder="MM/YY" maxlength="5" required autocomplete="off">
                                    <div class="input-error" id="expiryError">Please enter expiry date (MM/YY)</div>
                                </div>
                                <div class="form-group">
                                    <label>CVV *</label>
                                    <input type="text" name="cvv" id="cvv" class="form-input" 
                                           placeholder="123" maxlength="4" required autocomplete="off">
                                    <div class="input-error" id="cvvError">Please enter CVV (3-4 digits)</div>
                                </div>
                            </div>
                            
                            <div class="secure-badge">
                                <span class="secure-icon">🔒</span>
                                <div>
                                    <strong>Secure Payment</strong><br>
                                    Your payment information is encrypted and secure
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- PayPal Form -->
                        <?php if ($order['payment_method'] === 'PayPal'): ?>
                        <div class="payment-form active">
                            <div class="paypal-info">
                                <strong>PayPal Payment</strong>
                                <p style="margin: 10px 0 0 0; font-size: 0.9rem;">Enter your PayPal email address to complete the payment.</p>
                            </div>
                            
                            <div class="form-group">
                                <label>PayPal Email Address *</label>
                                <input type="email" name="paypal_email" id="paypal_email" class="form-input" 
                                       placeholder="your@email.com" required autocomplete="off">
                                <div class="input-error" id="paypalError">Please enter a valid email address</div>
                            </div>
                            
                            <div class="secure-badge">
                                <span class="secure-icon">🔒</span>
                                <div>
                                    <strong>PayPal Protection</strong><br>
                                    Your payment is protected by PayPal's Buyer Protection
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- GCash Form -->
                        <?php if ($order['payment_method'] === 'GCash'): ?>
                        <div class="payment-form active">
                            <div class="gcash-info">
                                <strong>GCash Payment</strong>
                                <p style="margin: 10px 0 0 0; font-size: 0.9rem;">Enter your GCash mobile number to complete the payment.</p>
                            </div>
                            
                            <div class="form-group">
                                <label>GCash Mobile Number *</label>
                                <input type="tel" name="gcash_number" id="gcash_number" class="form-input" 
                                       placeholder="09171234567" required autocomplete="off" minlength="10">
                                <div class="input-error" id="gcashError">Please enter a valid mobile number (10-11 digits)</div>
                            </div>
                            
                            <div style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 15px;">
                                <p style="margin: 0; font-size: 0.9rem;">
                                    <strong>Instructions:</strong><br>
                                    1. You will receive a GCash payment request<br>
                                    2. Open your GCash app to approve the payment<br>
                                    3. Enter your MPIN to confirm
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Cash on Delivery -->
                        <?php if ($order['payment_method'] === 'Cash on Delivery'): ?>
                        <div class="payment-form active">
                            <div class="cod-info">
                                <strong>Cash on Delivery</strong>
                                <p style="margin: 10px 0 0 0; font-size: 0.9rem;">
                                    Pay when your order is delivered to your doorstep.
                                </p>
                            </div>
                            
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 15px;">
                                <h4 style="margin-top: 0;">Important Notes:</h4>
                                <ul style="margin-bottom: 0; padding-left: 20px;">
                                    <li>Prepare exact amount if possible</li>
                                    <li>Payment will be collected upon delivery</li>
                                    <li>Our delivery partner will provide a receipt</li>
                                    <li>Please inspect your items before payment</li>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <button type="submit" name="process_payment" value="1" id="submitBtn" class="btn btn-primary btn-block" style="margin-top: 30px; padding: 15px; font-size: 1.1rem;">
                            <?php if ($order['payment_method'] === 'Cash on Delivery'): ?>
                                Confirm Order
                            <?php else: ?>
                                Pay <?php echo formatCurrency($order['total_amount']); ?>
                            <?php endif; ?>
                        </button>
                        
                        <a href="checkout.php" style="display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none;">
                            ← Back to Checkout
                        </a>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div>
                <div class="order-summary-box">
                    <h2>Order Summary</h2>
                    
                    <div class="order-items-preview">
                        <?php foreach ($order_items as $item): ?>
                            <div class="order-item-mini">
                                <span><?php echo htmlspecialchars($item['product_name']); ?> x<?php echo $item['quantity']; ?></span>
                                <span><strong><?php echo formatCurrency($item['subtotal']); ?></strong></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
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
                    
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                        <h4 style="margin-bottom: 10px;">Shipping Address</h4>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">
                            <?php echo htmlspecialchars($order['street_address']); ?><br>
                            <?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['state_province']); ?><br>
                            <?php echo htmlspecialchars($order['postal_code']); ?>, <?php echo htmlspecialchars($order['country']); ?>
                        </p>
                    </div>
                    
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                        <h4 style="margin-bottom: 10px;">Order Details</h4>
                        <p style="color: #666; font-size: 0.9rem; margin: 5px 0;">
                            <strong>Order Number:</strong> <?php echo htmlspecialchars($order['order_number']); ?>
                        </p>
                        <p style="color: #666; font-size: 0.9rem; margin: 5px 0;">
                            <strong>Order Date:</strong> <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const paymentMethod = '<?php echo addslashes($order['payment_method']); ?>';
        
        // Validation patterns
        const namePattern = /^[a-zA-Z\s'-]+$/;
        const numberPattern = /^[0-9]+$/;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Restrict to letters only
        function restrictToLetters(e) {
            const char = String.fromCharCode(e.which || e.keyCode);
            if (!/[a-zA-Z\s'-]/.test(char)) {
                e.preventDefault();
            }
        }
        
        // Restrict to numbers only
        function restrictToNumbers(e) {
            const char = String.fromCharCode(e.which || e.keyCode);
            if (!/[0-9]/.test(char)) {
                e.preventDefault();
            }
        }
        
        // Card number formatting and validation
        const cardNumberInput = document.getElementById('card_number');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('keypress', restrictToNumbers);
            
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
                
                // Validate
                const cleanValue = value.replace(/\s/g, '');
                if (cleanValue && !numberPattern.test(cleanValue)) {
                    this.classList.add('error');
                    document.getElementById('cardNumberError').classList.add('show');
                } else if (cleanValue.length >= 13) {
                    this.classList.remove('error');
                    document.getElementById('cardNumberError').classList.remove('show');
                }
            });
        }
        
        // Cardholder name validation
        const cardNameInput = document.getElementById('card_name');
        if (cardNameInput) {
            cardNameInput.addEventListener('keypress', restrictToLetters);
            
            cardNameInput.addEventListener('input', function(e) {
                if (this.value && !namePattern.test(this.value)) {
                    this.classList.add('error');
                    document.getElementById('cardNameError').classList.add('show');
                } else if (this.value) {
                    this.classList.remove('error');
                    document.getElementById('cardNameError').classList.remove('show');
                }
            });
        }
        
        // Expiry date formatting
        const expiryInput = document.getElementById('expiryDate');
        if (expiryInput) {
            expiryInput.addEventListener('keypress', restrictToNumbers);
            
            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length >= 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2, 4);
                }
                
                e.target.value = value;
                
                // Validate
                if (value.length === 5) {
                    this.classList.remove('error');
                    document.getElementById('expiryError').classList.remove('show');
                }
            });
        }
        
        // CVV - only numbers
        const cvvInput = document.getElementById('cvv');
        if (cvvInput) {
            cvvInput.addEventListener('keypress', restrictToNumbers);
            
            cvvInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
                
                if (this.value.length >= 3) {
                    this.classList.remove('error');
                    document.getElementById('cvvError').classList.remove('show');
                }
            });
        }
        
        // PayPal email validation
        const paypalInput = document.getElementById('paypal_email');
        if (paypalInput) {
            paypalInput.addEventListener('blur', function() {
                if (this.value && !emailPattern.test(this.value)) {
                    this.classList.add('error');
                    document.getElementById('paypalError').classList.add('show');
                } else if (this.value) {
                    this.classList.remove('error');
                    document.getElementById('paypalError').classList.remove('show');
                }
            });
        }
        
        // GCash - only numbers
        const gcashInput = document.getElementById('gcash_number');
        if (gcashInput) {
            gcashInput.addEventListener('keypress', restrictToNumbers);
            
            gcashInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
                
                if (this.value.length >= 10) {
                    this.classList.remove('error');
                    document.getElementById('gcashError').classList.remove('show');
                }
            });
        }
        
        // Form submission validation
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            let isValid = true;
            let errorMessage = '';
            
            // Validate based on payment method
            if (paymentMethod.includes('Card')) {
                // Validate card number
                if (cardNumberInput) {
                    const cardNumber = cardNumberInput.value.replace(/\s/g, '');
                    if (!cardNumber || cardNumber.length < 13 || cardNumber.length > 19) {
                        cardNumberInput.classList.add('error');
                        document.getElementById('cardNumberError').classList.add('show');
                        isValid = false;
                        errorMessage += 'Invalid card number. ';
                    }
                }
                
                // Validate cardholder name
                if (cardNameInput && !cardNameInput.value.trim()) {
                    cardNameInput.classList.add('error');
                    document.getElementById('cardNameError').classList.add('show');
                    isValid = false;
                    errorMessage += 'Cardholder name is required. ';
                }
                
                // Validate expiry
                if (expiryInput && expiryInput.value.length !== 5) {
                    expiryInput.classList.add('error');
                    document.getElementById('expiryError').classList.add('show');
                    isValid = false;
                    errorMessage += 'Invalid expiry date. ';
                }
                
                // Validate CVV
                if (cvvInput) {
                    const cvv = cvvInput.value;
                    if (!cvv || cvv.length < 3) {
                        cvvInput.classList.add('error');
                        document.getElementById('cvvError').classList.add('show');
                        isValid = false;
                        errorMessage += 'Invalid CVV. ';
                    }
                }
            } else if (paymentMethod === 'PayPal') {
                if (paypalInput && !paypalInput.value.trim()) {
                    paypalInput.classList.add('error');
                    document.getElementById('paypalError').classList.add('show');
                    isValid = false;
                    errorMessage = 'PayPal email is required.';
                }
            } else if (paymentMethod === 'GCash') {
                if (gcashInput) {
                    const gcashNumber = gcashInput.value.trim();
                    if (!gcashNumber || gcashNumber.length < 10) {
                        gcashInput.classList.add('error');
                        document.getElementById('gcashError').classList.add('show');
                        isValid = false;
                        errorMessage = 'Valid GCash number is required (at least 10 digits).';
                    }
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                if (errorMessage) {
                    alert(errorMessage);
                }
                return false;
            }
            
            // Show processing message - do NOT disable button yet
            // We need the button to submit with the form
            setTimeout(function() {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing Payment...';
            }, 50);
        });
    </script>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>