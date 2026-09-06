<?php 
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Your Premier Shopping Destination</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        /* Fix for category cards - Enhanced overlay design */
        .category-card {
            position: relative;
            overflow: hidden;
            height: 300px;
            cursor: pointer;
        }
        
        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .category-card:hover img {
            transform: scale(1.15);
        }
        
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
            padding: 30px 20px 20px;
            transition: all 0.4s ease;
            z-index: 2;
        }
        
        .category-card:hover .category-overlay {
            background: linear-gradient(to top, rgba(124, 58, 237, 0.95) 0%, rgba(124, 58, 237, 0.7) 50%, rgba(124, 58, 237, 0.3) 100%);
        }
        
        .category-card h3 {
            color: white;
            font-size: 1.8rem;
            font-weight: 900;
            margin: 0 0 10px 0;
            text-shadow: 0 4px 10px rgba(0,0,0,0.5);
            transform: translateY(0);
            transition: transform 0.4s ease;
            position: relative;
            z-index: 3;
        }
        
        .category-card:hover h3 {
            transform: translateY(-5px);
        }
        
        .category-description {
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
            margin-bottom: 15px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
            position: relative;
            z-index: 3;
        }
        
        .category-card:hover .category-description {
            opacity: 1;
            transform: translateY(0);
        }
        
        .category-card a {
            display: inline-block;
            padding: 12px 28px;
            background: white;
            color: var(--primary);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            position: relative;
            z-index: 10 !important;
            pointer-events: all !important;
            cursor: pointer !important;
        }
        
        .category-card:hover a {
            opacity: 1;
            transform: translateY(0);
        }
        
        .category-card a:hover {
            background: var(--secondary);
            color: white;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        }

        /* Fix for product cards - Remove conflicting animations */
        .product-card {
            animation: none !important;
        }
        
        .product-card:nth-child(odd),
        .product-card:nth-child(even) {
            animation: none !important;
        }
        
        /* Ensure product card buttons are always clickable */
        .product-card a.btn {
            position: relative;
            z-index: 100 !important;
            pointer-events: all !important;
            cursor: pointer !important;
            margin-top: auto;
        }
        
        .product-card a.btn:hover {
            transform: translateY(-2px) !important;
        }
        
        /* Remove any overlay that might block clicks */
        .product-card::before,
        .product-card::after {
            pointer-events: none !important;
        }
        
        /* Ensure proper stacking */
        .product-card {
            isolation: isolate;
        }
        
        .product-card > * {
            position: relative;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to <?php echo SITE_NAME; ?></h1>
            <p>Discover Amazing Products at Unbeatable Prices</p>
            <a href="shop.php" class="btn btn-primary">Shop Now</a>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="categories">
        <div class="container">
            <h2>Shop by Category</h2>
            <div class="category-grid">
                <?php
                $conn = getDBConnection();
                
                // Define default category images and descriptions
                $categoryData = [
                    'Electronics' => [
                        'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800&q=80',
                        'description' => 'Latest gadgets and tech essentials'
                    ],
                    'Clothing' => [
                        'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80',
                        'description' => 'Fashion for every style and occasion'
                    ],
                    'Home & Garden' => [
                        'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&q=80',
                        'description' => 'Transform your living space'
                    ],
                    'Sports & Outdoors' => [
                        'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&q=80',
                        'description' => 'Gear up for adventure'
                    ],
                    'Books' => [
                        'image' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800&q=80',
                        'description' => 'Knowledge and stories await'
                    ],
                    'Groceries' => [
                        'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80',
                        'description' => 'Fresh food and essentials'
                    ]
                ];
                
                $result = $conn->query("SELECT * FROM categories WHERE parent_category_id IS NULL AND is_active = 1 LIMIT 6");
                while ($category = $result->fetch_assoc()): 
                    $categoryName = htmlspecialchars($category['category_name']);
                    $imageUrl = !empty($category['image_url']) 
                        ? htmlspecialchars($category['image_url']) 
                        : ($categoryData[$categoryName]['image'] ?? 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&q=80');
                    $description = $categoryData[$categoryName]['description'] ?? htmlspecialchars($category['description']);
                ?>
                    <div class="category-card" onclick="window.location.href='shop.php?category=<?php echo $category['category_id']; ?>'">
                        <img src="<?php echo $imageUrl; ?>" 
                             alt="<?php echo $categoryName; ?>"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&q=80'">
                        <div class="category-overlay">
                            <h3><?php echo $categoryName; ?></h3>
                            <p class="category-description"><?php echo $description; ?></p>
                            <a href="shop.php?category=<?php echo $category['category_id']; ?>" 
                               onclick="event.stopPropagation();">Browse Now →</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <?php
                $result = $conn->query("SELECT p.*, pi.image_url FROM products p 
                                       LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
                                       WHERE p.featured = 1 AND p.is_active = 1 LIMIT 9");
                while ($product = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                             loading="lazy">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p class="price">
                            <?php if ($product['sale_price']): ?>
                                <span class="original-price"><?php echo formatCurrency($product['price']); ?></span>
                                <span class="sale-price"><?php echo formatCurrency($product['sale_price']); ?></span>
                            <?php else: ?>
                                <?php echo formatCurrency($product['price']); ?>
                            <?php endif; ?>
                        </p>
                        <a href="product.php?id=<?php echo $product['product_id']; ?>" 
                           class="btn btn-secondary"
                           onclick="event.stopPropagation();">View Details</a>
                    </div>
                <?php endwhile;
                $conn->close(); ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>