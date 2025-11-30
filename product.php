<?php
require_once 'config.php';

// Get product ID
if (!isset($_GET['id'])) {
    header('Location: shop.php');
    exit;
}

$product_id = intval($_GET['id']);
$message = '';
$error = '';

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
    
    $customer_id = $_SESSION['customer_id'];
    $quantity = intval($_POST['quantity']);
    
    if ($quantity < 1) {
        $error = 'Invalid quantity.';
    } else {
        $conn = getDBConnection();
        
        // Check inventory
        $stmt = $conn->prepare("SELECT quantity FROM inventory WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $inventory = $result->fetch_assoc();
        
        if ($inventory && $inventory['quantity'] >= $quantity) {
            // Check if item already in cart
            $stmt = $conn->prepare("SELECT cart_id, quantity FROM shopping_cart WHERE customer_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $customer_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update quantity
                $cart_item = $result->fetch_assoc();
                $new_quantity = $cart_item['quantity'] + $quantity;
                $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = ? WHERE cart_id = ?");
                $stmt->bind_param("ii", $new_quantity, $cart_item['cart_id']);
                $stmt->execute();
                $message = 'Cart updated successfully!';
            } else {
                // Add new item
                $stmt = $conn->prepare("INSERT INTO shopping_cart (customer_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $customer_id, $product_id, $quantity);
                $stmt->execute();
                $message = 'Product added to cart!';
            }
        } else {
            $error = 'Insufficient stock available.';
        }
        
        $conn->close();
    }
}

// Handle Add to Wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
    
    $customer_id = $_SESSION['customer_id'];
    $conn = getDBConnection();
    
    // Check if already in wishlist
    $stmt = $conn->prepare("SELECT wishlist_id FROM wishlist WHERE customer_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $customer_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = 'Product already in wishlist.';
    } else {
        $stmt = $conn->prepare("INSERT INTO wishlist (customer_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $customer_id, $product_id);
        if ($stmt->execute()) {
            $message = 'Added to wishlist!';
        }
    }
    
    $conn->close();
}

// Get product details
$conn = getDBConnection();
$stmt = $conn->prepare("
    SELECT p.*, c.category_name, i.quantity as stock_quantity
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN inventory i ON p.product_id = i.product_id
    WHERE p.product_id = ? AND p.is_active = 1
");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: shop.php');
    exit;
}

$product = $result->fetch_assoc();

// Get product images
$stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, display_order ASC");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get product reviews
$stmt = $conn->prepare("
    SELECT r.*, c.first_name, c.last_name
    FROM reviews r
    JOIN customers c ON r.customer_id = c.customer_id
    WHERE r.product_id = ? AND r.is_approved = 1
    ORDER BY r.created_at DESC
    LIMIT 10
");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate average rating
$stmt = $conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM reviews WHERE product_id = ? AND is_approved = 1");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$rating_data = $stmt->get_result()->fetch_assoc();
$avg_rating = $rating_data['avg_rating'] ? round($rating_data['avg_rating'], 1) : 0;
$review_count = $rating_data['review_count'];

// Get related products
$stmt = $conn->prepare("
    SELECT p.*, pi.image_url
    FROM products p
    LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
    WHERE p.category_id = ? AND p.product_id != ? AND p.is_active = 1
    ORDER BY RAND()
    LIMIT 4
");
$stmt->bind_param("ii", $product['category_id'], $product_id);
$stmt->execute();
$related_products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

// Calculate discount percentage
$discount_percentage = 0;
if ($product['sale_price']) {
    $discount_percentage = round((($product['price'] - $product['sale_price']) / $product['price']) * 100);
}

$current_price = $product['sale_price'] ?: $product['price'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="product-container">
        <div class="breadcrumb">
            <a href="index.php">Home</a> / 
            <a href="shop.php">Shop</a> / 
            <a href="shop.php?category=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a> / 
            <?php echo htmlspecialchars($product['product_name']); ?>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="product-main">
            <div class="product-gallery">
                <img src="<?php echo htmlspecialchars($images[0]['image_url'] ?? 'images/placeholder.jpg'); ?>" 
                     alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                     class="main-image" 
                     id="mainImage">
                
                <?php if (count($images) > 1): ?>
                    <div class="thumbnail-container">
                        <?php foreach ($images as $index => $image): ?>
                            <img src="<?php echo htmlspecialchars($image['image_url']); ?>" 
                                 alt="Thumbnail <?php echo $index + 1; ?>" 
                                 class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                                 onclick="changeMainImage('<?php echo htmlspecialchars($image['image_url']); ?>', this)">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <p class="product-brand">Brand: <strong><?php echo htmlspecialchars($product['brand']); ?></strong></p>
                
                <div class="rating-section">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $avg_rating): ?>
                                ★
                            <?php else: ?>
                                ☆
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-text"><?php echo $avg_rating; ?> (<?php echo $review_count; ?> reviews)</span>
                </div>
                
                <div class="price-section">
                    <span class="current-price"><?php echo formatCurrency($current_price); ?></span>
                    <?php if ($product['sale_price']): ?>
                        <span class="original-price-large"><?php echo formatCurrency($product['price']); ?></span>
                        <span class="discount-badge">Save <?php echo $discount_percentage; ?>%</span>
                    <?php endif; ?>
                </div>
                
                <div class="stock-info">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <span class="in-stock">✓ In Stock (<?php echo $product['stock_quantity']; ?> available)</span>
                    <?php else: ?>
                        <span class="out-of-stock">✗ Out of Stock</span>
                    <?php endif; ?>
                </div>
                
                <p class="product-description">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </p>
                
                <?php if ($product['stock_quantity'] > 0): ?>
                    <form method="POST">
                        <div class="quantity-selector">
                            <label style="font-weight: bold;">Quantity:</label>
                            <div class="quantity-input">
                                <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                                <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" readonly>
                                <button type="button" class="quantity-btn" onclick="increaseQuantity(<?php echo $product['stock_quantity']; ?>)">+</button>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" name="add_to_cart" class="btn-add-cart">
                                🛒 Add to Cart
                            </button>
                            <button type="submit" name="add_to_wishlist" class="btn-wishlist">
                                ♥
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-error">This product is currently out of stock.</div>
                <?php endif; ?>
                
                <div class="shipping-benefits">
                    <p><strong>✓</strong> Free shipping on orders over <?php echo formatCurrency(FREE_SHIPPING_THRESHOLD); ?></p>
                    <p><strong>✓</strong> 30-day money-back guarantee</p>
                </div>
            </div>
        </div>
        
        <div class="product-details-section">
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('description')">Description</button>
                <button class="tab-btn" onclick="showTab('specifications')">Specifications</button>
                <button class="tab-btn" onclick="showTab('reviews')">Reviews (<?php echo $review_count; ?>)</button>
            </div>
            
            <div id="description" class="tab-content active">
                <h3>Product Description</h3>
                <p class="product-description">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </p>
            </div>
            
            <div id="specifications" class="tab-content">
                <h3>Specifications</h3>
                <div class="spec-grid">
                    <div class="spec-item">
                        <span class="spec-label">SKU:</span>
                        <span class="spec-value"><?php echo htmlspecialchars($product['sku']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Brand:</span>
                        <span class="spec-value"><?php echo htmlspecialchars($product['brand']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Category:</span>
                        <span class="spec-value"><?php echo htmlspecialchars($product['category_name']); ?></span>
                    </div>
                    <?php if ($product['weight']): ?>
                        <div class="spec-item">
                            <span class="spec-label">Weight:</span>
                            <span class="spec-value"><?php echo $product['weight']; ?> kg</span>
                        </div>
                    <?php endif; ?>
                    <?php if ($product['dimensions']): ?>
                        <div class="spec-item">
                            <span class="spec-label">Dimensions:</span>
                            <span class="spec-value"><?php echo htmlspecialchars($product['dimensions']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div id="reviews" class="tab-content">
                <h3>Customer Reviews</h3>
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <span class="reviewer-name"><?php echo htmlspecialchars($review['first_name'] . ' ' . substr($review['last_name'], 0, 1) . '.'); ?></span>
                                <span class="review-date"><?php echo date('M d, Y', strtotime($review['created_at'])); ?></span>
                            </div>
                            <div class="review-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php echo $i <= $review['rating'] ? '★' : '☆'; ?>
                                <?php endfor; ?>
                            </div>
                            <?php if ($review['title']): ?>
                                <div class="review-title"><?php echo htmlspecialchars($review['title']); ?></div>
                            <?php endif; ?>
                            <div class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></div>
                            <?php if ($review['is_verified_purchase']): ?>
                                <div class="verified-purchase">✓ Verified Purchase</div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet. Be the first to review this product!</p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (count($related_products) > 0): ?>
            <div class="related-products">
                <h2>Related Products</h2>
                <div class="product-grid">
                    <?php foreach ($related_products as $related): ?>
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($related['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($related['product_name']); ?>">
                            <h3><?php echo htmlspecialchars($related['product_name']); ?></h3>
                            <p class="price">
                                <?php if ($related['sale_price']): ?>
                                    <span class="original-price"><?php echo formatCurrency($related['price']); ?></span>
                                    <span class="sale-price"><?php echo formatCurrency($related['sale_price']); ?></span>
                                <?php else: ?>
                                    <?php echo formatCurrency($related['price']); ?>
                                <?php endif; ?>
                            </p>
                            <a href="product.php?id=<?php echo $related['product_id']; ?>" class="btn btn-secondary">View Details</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function changeMainImage(imageUrl, thumbnail) {
            document.getElementById('mainImage').src = imageUrl;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
        
        function increaseQuantity(max) {
            const input = document.getElementById('quantityInput');
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }
        
        function decreaseQuantity() {
            const input = document.getElementById('quantityInput');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
        
        function showTab(tabName) {
            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
    </script>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>