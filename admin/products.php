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

// Handle product deletion
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    $stmt = $conn->prepare("UPDATE products SET is_active = 0 WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        $message = 'Product deleted successfully!';
    }
}

// Handle product add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $category_id = intval($_POST['category_id']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $sale_price = !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : null;
    $sku = trim($_POST['sku']);
    $brand = trim($_POST['brand']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        // Update existing product
        $product_id = intval($_POST['product_id']);
        $stmt = $conn->prepare("UPDATE products SET product_name=?, category_id=?, description=?, price=?, sale_price=?, sku=?, brand=?, featured=? WHERE product_id=?");
        $stmt->bind_param("sisdssisi", $product_name, $category_id, $description, $price, $sale_price, $sku, $brand, $featured, $product_id);
        if ($stmt->execute()) {
            $message = 'Product updated successfully!';
        }
    } else {
        // Add new product
        $stmt = $conn->prepare("INSERT INTO products (product_name, category_id, description, price, sale_price, sku, brand, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisdssi", $product_name, $category_id, $description, $price, $sale_price, $sku, $brand, $featured);
        if ($stmt->execute()) {
            $message = 'Product added successfully!';
        }
    }
}

// Get all products with category names
$products = $conn->query("
    SELECT p.*, c.category_name, 
           (SELECT image_url FROM product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image_url
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.category_id 
    WHERE p.is_active = 1
    ORDER BY p.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Get categories for dropdown
$categories = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY category_name")->fetch_all(MYSQLI_ASSOC);

// Get product for editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_product = $stmt->get_result()->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .product-image-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .close-modal {
            font-size: 2rem;
            cursor: pointer;
            color: #7f8c8d;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Products Management</h1>
                <button onclick="openModal()" class="btn-admin btn-success">+ Add New Product</button>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($product['image_url'] ?: '../images/placeholder.jpg'); ?>" 
                                         alt="Product" class="product-image-thumb">
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($product['product_name']); ?></strong><br>
                                    <small style="color: #7f8c8d;"><?php echo htmlspecialchars($product['brand']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                <td><?php echo formatCurrency($product['price']); ?></td>
                                <td>
                                    <?php if ($product['sale_price']): ?>
                                        <span style="color: #e74c3c; font-weight: bold;"><?php echo formatCurrency($product['sale_price']); ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($product['featured']): ?>
                                        <span style="color: #f39c12;">⭐ Featured</span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $product['product_id']; ?>" class="btn-admin btn-primary" style="margin-right: 5px;">Edit</a>
                                    <a href="?delete=<?php echo $product['product_id']; ?>" 
                                       class="btn-admin btn-danger" 
                                       onclick="return confirm('Delete this product?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Add/Edit Product Modal -->
    <div id="productModal" class="modal <?php echo $edit_product ? 'active' : ''; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h2>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            
            <form method="POST">
                <?php if ($edit_product): ?>
                    <input type="hidden" name="product_id" value="<?php echo $edit_product['product_id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="product_name" required 
                           value="<?php echo $edit_product ? htmlspecialchars($edit_product['product_name']) : ''; ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Category *</label>
                        <select name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>"
                                    <?php echo ($edit_product && $edit_product['category_id'] == $cat['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>SKU *</label>
                        <input type="text" name="sku" required 
                               value="<?php echo $edit_product ? htmlspecialchars($edit_product['sku']) : 'SKU-' . time(); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand" 
                           value="<?php echo $edit_product ? htmlspecialchars($edit_product['brand']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Regular Price *</label>
                        <input type="number" step="0.01" name="price" required 
                               value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Sale Price</label>
                        <input type="number" step="0.01" name="sale_price" 
                               value="<?php echo $edit_product ? $edit_product['sale_price'] : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" name="featured" id="featured" 
                           <?php echo ($edit_product && $edit_product['featured']) ? 'checked' : ''; ?>>
                    <label for="featured" style="margin: 0;">Featured Product</label>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-admin btn-success" style="flex: 1;">
                        <?php echo $edit_product ? 'Update Product' : 'Add Product'; ?>
                    </button>
                    <button type="button" onclick="closeModal()" class="btn-admin btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('productModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('productModal').classList.remove('active');
            if (!<?php echo $edit_product ? 'true' : 'false'; ?>) {
                window.location.href = 'products.php';
            }
        }
        
        // Close modal on outside click
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>