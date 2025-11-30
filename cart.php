<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$message = '';

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();
    
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update') {
            $cart_id = intval($_POST['cart_id']);
            $quantity = intval($_POST['quantity']);
            
            if ($quantity > 0) {
                $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = ? WHERE cart_id = ? AND customer_id = ?");
                $stmt->bind_param("iii", $quantity, $cart_id, $customer_id);
                $stmt->execute();
                $message = 'Cart updated successfully!';
            }
        } elseif ($_POST['action'] === 'remove') {
            $cart_id = intval($_POST['cart_id']);
            $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE cart_id = ? AND customer_id = ?");
            $stmt->bind_param("ii", $cart_id, $customer_id);
            $stmt->execute();
            $message = 'Item removed from cart!';
        } elseif ($_POST['action'] === 'clear') {
            $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE customer_id = ?");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $message = 'Cart cleared!';
        }
    }
    
    $conn->close();
}

// Get cart items
$conn = getDBConnection();
$stmt = $conn->prepare("
    SELECT sc.cart_id, sc.quantity, p.product_id, p.product_name, p.price, p.sale_price, p.sku, pi.image_url
    FROM shopping_cart sc
    JOIN products p ON sc.product_id = p.product_id
    LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
    WHERE sc.customer_id = ?
    ORDER BY sc.added_at DESC
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

// Calculate totals using config functions
$subtotal = 0;
foreach ($cart_items as $item) {
    $price = $item['sale_price'] ?: $item['price'];
    $subtotal += $price * $item['quantity'];
}
$tax = calculateTax($subtotal);
$shipping = calculateShipping($subtotal);
$total = $subtotal + $tax + $shipping;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .cart-table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .cart-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .cart-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
        }
        
        .cart-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .cart-item-details {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .quantity-control input {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .cart-summary {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 400px;
            margin-left: auto;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .summary-row.total {
            font-size: 1.3rem;
            font-weight: bold;
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 15px;
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .empty-cart h2 {
            margin-bottom: 20px;
            color: #666;
        }
        
        .btn-remove {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-remove:hover {
            background: #c0392b;
        }
        
        .btn-update {
            background: #3498db;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-update:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="cart-container">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <?php if (count($cart_items) > 0): ?>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn-remove" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
                </form>
            <?php endif; ?>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if (count($cart_items) > 0): ?>
            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): 
                            $price = $item['sale_price'] ?: $item['price'];
                            $item_subtotal = $price * $item['quantity'];
                        ?>
                            <tr>
                                <td>
                                    <div class="cart-item-details">
                                        <img src="<?php echo htmlspecialchars($item['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                                             alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                             class="cart-item-image">
                                        <div>
                                            <strong><?php echo htmlspecialchars($item['product_name']); ?></strong>
                                            <br>
                                            <small>SKU: <?php echo htmlspecialchars($item['sku']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($item['sale_price']): ?>
                                        <span class="original-price"><?php echo formatCurrency($item['price']); ?></span>
                                        <br>
                                        <span class="sale-price"><?php echo formatCurrency($item['sale_price']); ?></span>
                                    <?php else: ?>
                                        <?php echo formatCurrency($item['price']); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" class="quantity-control">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="99">
                                        <button type="submit" class="btn-update">Update</button>
                                    </form>
                                </td>
                                <td><strong><?php echo formatCurrency($item_subtotal); ?></strong></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <button type="submit" class="btn-remove" onclick="return confirm('Remove this item?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span><?php echo formatCurrency($subtotal); ?></span>
                </div>
                <div class="summary-row">
                    <span>Tax (<?php echo (TAX_RATE * 100); ?>%):</span>
                    <span><?php echo formatCurrency($tax); ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span><?php echo $shipping > 0 ? formatCurrency($shipping) : 'FREE'; ?></span>
                </div>
                <?php if ($subtotal < FREE_SHIPPING_THRESHOLD && $subtotal > 0): ?>
                    <small style="color: #3498db; display: block; margin: 10px 0;">
                        Add <?php echo formatCurrency(FREE_SHIPPING_THRESHOLD - $subtotal); ?> more for free shipping!
                    </small>
                <?php endif; ?>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span><?php echo formatCurrency($total); ?></span>
                </div>
                <a href="checkout.php" class="btn btn-primary btn-block" style="margin-top: 20px; text-align: center;">Proceed to Checkout</a>
                <a href="shop.php" class="btn btn-secondary btn-block" style="margin-top: 10px; text-align: center;">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Add some products to get started!</p>
                <a href="shop.php" class="btn btn-primary" style="margin-top: 20px;">Browse Products</a>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>