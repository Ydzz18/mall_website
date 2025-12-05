<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="shop-container">
        <!-- Enhanced Sidebar -->
        <aside class="sidebar fade-in">
            <div class="sidebar-header">
                <h3>Categories</h3>
                <div class="filter-icon">🔍</div>
            </div>
            <ul class="category-list">
                <?php
                $conn = getDBConnection();
                $categories = $conn->query("SELECT * FROM categories WHERE parent_category_id IS NULL AND is_active = 1");
                while ($cat = $categories->fetch_assoc()): ?>
                    <li class="category-item">
                        <a href="shop.php?category=<?php echo $cat['category_id']; ?>" class="category-link">
                            <span class="category-icon">🛍️</span>
                            <span class="category-name"><?php echo htmlspecialchars($cat['category_name']); ?></span>
                            <span class="category-arrow">→</span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
            
            <!-- Price Filter -->
            <div class="filter-section">
                <h4>Price Range</h4>
                <div class="price-inputs">
                    <input type="number" placeholder="Min" class="price-input">
                    <span class="price-separator">-</span>
                    <input type="number" placeholder="Max" class="price-input">
                </div>
                <button class="btn btn-secondary btn-block">Apply Filters</button>
            </div>
        </aside>
        
        <!-- Enhanced Shop Content -->
        <main class="shop-content">
            <div class="shop-header fade-in">
                <h1>Discover Amazing Products</h1>
                <p class="shop-subtitle">Find the perfect items for your needs</p>
                
                <div class="shop-controls">
                    <div class="sort-controls">
                        <select class="sort-select">
                            <option>Sort by: Newest</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Most Popular</option>
                        </select>
                    </div>
                    <div class="view-controls">
                        <button class="view-btn active" data-view="grid">▦</button>
                        <button class="view-btn" data-view="list">📃</button>
                    </div>
                </div>
            </div>
            
            <div class="product-grid" id="productGrid">
                <?php
                $where = "p.is_active = 1";
                if (isset($_GET['category'])) {
                    $category_id = intval($_GET['category']);
                    $where .= " AND p.category_id = $category_id";
                }
                
                $query = "SELECT p.*, pi.image_url FROM products p 
                         LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.is_primary = 1
                         WHERE $where ORDER BY p.created_at DESC";
                $products = $conn->query($query);
                
                if ($products->num_rows > 0):
                    while ($product = $products->fetch_assoc()): ?>
                        <div class="product-card fade-in">
                            <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                <div class="product-badge">Sale</div>
                            <?php endif; ?>
                            <div class="product-image-container">
                                <img src="<?php echo htmlspecialchars($product['image_url'] ?: 'images/placeholder.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                     class="product-image">
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                <p class="brand"><?php echo htmlspecialchars($product['brand']); ?></p>
                                <div class="rating">
                                    ⭐⭐⭐⭐⭐ <span class="rating-count">(24)</span>
                                </div>
                                <p class="price">
                                    <?php if ($product['sale_price']): ?>
                                        <span class="original-price"><?php echo formatCurrency($product['price']); ?></span>
                                        <span class="sale-price"><?php echo formatCurrency($product['sale_price']); ?></span>
                                    <?php else: ?>
                                        <?php echo formatCurrency($product['price']); ?>
                                    <?php endif; ?>
                                </p>
                                <div class="product-actions">
                                    <a href="product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-secondary">View Details</a>
                                    <a href="product.php?id=<?php echo $product['product_id']; ?>" class="btn-add-cart" title="View product to add to cart">🛒</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                else: ?>
                    <div class="no-products fade-in">
                        <div class="no-products-icon">😔</div>
                        <h3>No products found</h3>
                        <p>Try adjusting your filters or browse other categories</p>
                        <a href="shop.php" class="btn btn-primary">Browse All Products</a>
                    </div>
                <?php endif;
                $conn->close(); ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination fade-in">
                <button class="pagination-btn">← Previous</button>
                <div class="pagination-numbers">
                    <span class="page-number active">1</span>
                    <span class="page-number">2</span>
                    <span class="page-number">3</span>
                    <span class="page-dots">...</span>
                    <span class="page-number">10</span>
                </div>
                <button class="pagination-btn">Next →</button>
            </div>
        </main>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <style>
        header {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }
        
        header.hide {
            transform: translateY(-100%);
        }
        
        .sidebar {
            transition: top 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: top;
        }
        
        .sidebar.sticky-top {
            top: 0 !important;
        }
    </style>
    
    <script>
        let lastScrollTop = 0;
        let isHeaderHidden = false;
        let ticking = false;
        const header = document.querySelector('header');
        const sidebar = document.querySelector('.sidebar');
        
        function updateScroll() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            let scrollingDown = currentScroll > lastScrollTop;
            
            if (scrollingDown && currentScroll > 100 && !isHeaderHidden) {
                header.classList.add('hide');
                if (sidebar) sidebar.classList.add('sticky-top');
                isHeaderHidden = true;
            } else if (!scrollingDown && isHeaderHidden) {
                header.classList.remove('hide');
                if (sidebar) sidebar.classList.remove('sticky-top');
                isHeaderHidden = false;
            }
            
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
            ticking = false;
        }
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateScroll);
                ticking = true;
            }
        }, { passive: true });
        
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            
            fadeElements.forEach(el => observer.observe(el));
            
            // View controls
            const viewBtns = document.querySelectorAll('.view-btn');
            const productGrid = document.getElementById('productGrid');
            
            viewBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    viewBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    if (btn.dataset.view === 'list') {
                        productGrid.classList.add('list-view');
                    } else {
                        productGrid.classList.remove('list-view');
                    }
                });
            });
        });
    </script>
</body>
</html>