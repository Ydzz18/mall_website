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

// Handle product image operations
if (isset($_POST['add_image'])) {
    $product_id = intval($_POST['product_id']);
    $image_url = trim($_POST['image_url']);
    $is_primary = isset($_POST['is_primary']) ? 1 : 0;
    
    if (!empty($image_url)) {
        // If setting as primary, unset other primary images
        if ($is_primary) {
            $conn->query("UPDATE product_images SET is_primary = 0 WHERE product_id = $product_id");
        }
        
        // Get max display order
        $result = $conn->query("SELECT MAX(display_order) as max_order FROM product_images WHERE product_id = $product_id");
        $row = $result->fetch_assoc();
        $display_order = ($row['max_order'] ?? 0) + 1;
        
        $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $product_id, $image_url, $is_primary, $display_order);
        if ($stmt->execute()) {
            $message = 'Image added successfully!';
            $image_id = $conn->insert_id;
            
            logAdminActivity(
                $_SESSION['admin_id'],
                'product_image_add',
                "Image added to product (ID: $product_id)",
                'product_images',
                $image_id,
                null,
                ['image_url' => $image_url, 'is_primary' => $is_primary]
            );
        } else {
            $error = 'Failed to add image.';
        }
    }
}

if (isset($_POST['delete_image'])) {
    $image_id = intval($_POST['image_id']);
    
    $stmt = $conn->prepare("SELECT product_id, image_url FROM product_images WHERE image_id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $image_data = $stmt->get_result()->fetch_assoc();
    
    $stmt = $conn->prepare("DELETE FROM product_images WHERE image_id = ?");
    $stmt->bind_param("i", $image_id);
    if ($stmt->execute()) {
        $message = 'Image deleted successfully!';
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'product_image_delete',
            "Image deleted from product (ID: {$image_data['product_id']})",
            'product_images',
            $image_id,
            ['image_url' => $image_data['image_url']]
        );
    }
}

if (isset($_POST['set_primary'])) {
    $image_id = intval($_POST['image_id']);
    $product_id = intval($_POST['product_id']);
    
    // Get current primary image
    $stmt = $conn->prepare("SELECT image_id FROM product_images WHERE product_id = ? AND is_primary = 1");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $old_primary = $stmt->get_result()->fetch_assoc();
    
    // Unset all primary images for this product
    $conn->query("UPDATE product_images SET is_primary = 0 WHERE product_id = $product_id");
    
    // Set new primary
    $stmt = $conn->prepare("UPDATE product_images SET is_primary = 1 WHERE image_id = ?");
    $stmt->bind_param("i", $image_id);
    if ($stmt->execute()) {
        $message = 'Primary image updated!';
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'product_image_primary',
            "Primary image changed for product (ID: $product_id)",
            'product_images',
            $image_id,
            ['is_primary' => 0],
            ['is_primary' => 1]
        );
    }
}

if (isset($_POST['update_image_url'])) {
    $image_id = intval($_POST['image_id']);
    $new_url = trim($_POST['new_image_url']);
    
    if (!empty($new_url)) {
        $stmt = $conn->prepare("SELECT product_id, image_url FROM product_images WHERE image_id = ?");
        $stmt->bind_param("i", $image_id);
        $stmt->execute();
        $old_image = $stmt->get_result()->fetch_assoc();
        
        $stmt = $conn->prepare("UPDATE product_images SET image_url = ? WHERE image_id = ?");
        $stmt->bind_param("si", $new_url, $image_id);
        if ($stmt->execute()) {
            $message = 'Image URL updated successfully!';
            
            logAdminActivity(
                $_SESSION['admin_id'],
                'product_image_update',
                "Image URL updated for product (ID: {$old_image['product_id']})",
                'product_images',
                $image_id,
                ['image_url' => $old_image['image_url']],
                ['image_url' => $new_url]
            );
        }
    }
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    
    $stmt = $conn->prepare("SELECT product_name, sku FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $deleted_product = $stmt->get_result()->fetch_assoc();
    
    $stmt = $conn->prepare("UPDATE products SET is_active = 0 WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        $message = 'Product deleted successfully!';
        
        logAdminActivity(
            $_SESSION['admin_id'],
            'product_delete',
            "Product deleted: {$deleted_product['product_name']} (SKU: {$deleted_product['sku']})",
            'products',
            $product_id,
            ['product_name' => $deleted_product['product_name'], 'sku' => $deleted_product['sku']]
        );
    }
}

// Handle product add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
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
        
        $stmt = $conn->prepare("SELECT product_name, category_id, price, sale_price, sku, brand, featured FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $old_product = $stmt->get_result()->fetch_assoc();
        
        $stmt = $conn->prepare("UPDATE products SET product_name=?, category_id=?, description=?, price=?, sale_price=?, sku=?, brand=?, featured=? WHERE product_id=?");
        $stmt->bind_param("sisdssisi", $product_name, $category_id, $description, $price, $sale_price, $sku, $brand, $featured, $product_id);
        if ($stmt->execute()) {
            $message = 'Product updated successfully!';
            
            logAdminActivity(
                $_SESSION['admin_id'],
                'product_update',
                "Product updated: $product_name",
                'products',
                $product_id,
                [
                    'product_name' => $old_product['product_name'],
                    'price' => $old_product['price'],
                    'sale_price' => $old_product['sale_price'],
                    'sku' => $old_product['sku'],
                    'brand' => $old_product['brand']
                ],
                [
                    'product_name' => $product_name,
                    'price' => $price,
                    'sale_price' => $sale_price,
                    'sku' => $sku,
                    'brand' => $brand
                ]
            );
        }
    } else {
        // Add new product
        $stmt = $conn->prepare("INSERT INTO products (product_name, category_id, description, price, sale_price, sku, brand, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisdssi", $product_name, $category_id, $description, $price, $sale_price, $sku, $brand, $featured);
        if ($stmt->execute()) {
            $message = 'Product added successfully!';
            $new_product_id = $conn->insert_id;
            
            logAdminActivity(
                $_SESSION['admin_id'],
                'product_create',
                "New product created: $product_name (SKU: $sku)",
                'products',
                $new_product_id,
                null,
                [
                    'product_name' => $product_name,
                    'sku' => $sku,
                    'price' => $price,
                    'brand' => $brand
                ]
            );
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

// Get product for managing images
$manage_images_product = null;
$product_images = [];
if (isset($_GET['manage_images'])) {
    $manage_id = intval($_GET['manage_images']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $manage_id);
    $stmt->execute();
    $manage_images_product = $stmt->get_result()->fetch_assoc();
    
    if ($manage_images_product) {
        $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, display_order ASC");
        $stmt->bind_param("i", $manage_id);
        $stmt->execute();
        $product_images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
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
        
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .image-item {
            position: relative;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px;
            background: #f9f9f9;
        }
        
        .image-item.primary {
            border-color: #16a34a;
            background: #f0fdf4;
        }
        
        .image-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .image-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .image-actions button {
            padding: 6px 10px;
            font-size: 0.85rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-set-primary {
            background: #16a34a;
            color: white;
        }
        
        .btn-replace {
            background: #0284c7;
            color: white;
        }
        
        .btn-delete {
            background: #dc2626;
            color: white;
        }
        
        .btn-set-primary:hover,
        .btn-replace:hover,
        .btn-delete:hover {
            opacity: 0.8;
        }
        
        .primary-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #16a34a;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .no-images {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }
        
        .replace-form {
            display: none;
            margin-top: 10px;
        }
        
        .replace-form.active {
            display: block;
        }
        
        .replace-form input {
            width: 100%;
            padding: 8px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        
        .replace-form button {
            width: 100%;
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
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
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
                                    <a href="?manage_images=<?php echo $product['product_id']; ?>" class="btn-admin btn-success" style="margin-right: 5px;">Images</a>
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
                <span class="close-modal" onclick="closeModal('productModal')">&times;</span>
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
                    <button type="submit" name="save_product" class="btn-admin btn-success" style="flex: 1;">
                        <?php echo $edit_product ? 'Update Product' : 'Add Product'; ?>
                    </button>
                    <button type="button" onclick="closeModal('productModal')" class="btn-admin btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Manage Images Modal -->
    <div id="imagesModal" class="modal <?php echo $manage_images_product ? 'active' : ''; ?>">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2>Manage Images - <?php echo $manage_images_product ? htmlspecialchars($manage_images_product['product_name']) : ''; ?></h2>
                <span class="close-modal" onclick="closeModal('imagesModal')">&times;</span>
            </div>
            
            <?php if ($manage_images_product): ?>
                <!-- Add New Image Form -->
                <form method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <input type="hidden" name="product_id" value="<?php echo $manage_images_product['product_id']; ?>">
                    <h3 style="margin-bottom: 15px;">Add New Image</h3>
                    <div class="form-group">
                        <label>Image URL *</label>
                        <input type="url" name="image_url" required placeholder="https://example.com/image.jpg">
                    </div>
                    <div class="checkbox-group" style="margin-bottom: 15px;">
                        <input type="checkbox" name="is_primary" id="is_primary">
                        <label for="is_primary" style="margin: 0;">Set as primary image</label>
                    </div>
                    <button type="submit" name="add_image" class="btn-admin btn-success">Add Image</button>
                </form>
                
                <!-- Existing Images -->
                <h3>Current Images (<?php echo count($product_images); ?>)</h3>
                
                <?php if (count($product_images) > 0): ?>
                    <div class="image-gallery">
                        <?php foreach ($product_images as $image): ?>
                            <div class="image-item <?php echo $image['is_primary'] ? 'primary' : ''; ?>">
                                <?php if ($image['is_primary']): ?>
                                    <span class="primary-badge">PRIMARY</span>
                                <?php endif; ?>
                                
                                <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Product Image">
                                
                                <div class="image-actions">
                                    <?php if (!$image['is_primary']): ?>
                                        <form method="POST" style="margin: 0;">
                                            <input type="hidden" name="image_id" value="<?php echo $image['image_id']; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $manage_images_product['product_id']; ?>">
                                            <button type="submit" name="set_primary" class="btn-set-primary">Set as Primary</button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn-replace" onclick="toggleReplaceForm(<?php echo $image['image_id']; ?>)">
                                        Replace URL
                                    </button>
                                    
                                    <form method="POST" style="margin: 0;" onsubmit="return confirm('Delete this image?')">
                                        <input type="hidden" name="image_id" value="<?php echo $image['image_id']; ?>">
                                        <button type="submit" name="delete_image" class="btn-delete">Delete</button>
                                    </form>
                                </div>
                                
                                <!-- Replace URL Form -->
                                <form method="POST" class="replace-form" id="replace-form-<?php echo $image['image_id']; ?>">
                                    <input type="hidden" name="image_id" value="<?php echo $image['image_id']; ?>">
                                    <input type="url" name="new_image_url" placeholder="New image URL" required>
                                    <button type="submit" name="update_image_url" class="btn-admin btn-success">Update URL</button>
                                    <button type="button" class="btn-admin btn-secondary" onclick="toggleReplaceForm(<?php echo $image['image_id']; ?>)">Cancel</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-images">
                        <p>No images uploaded yet. Add your first image above!</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <div style="margin-top: 20px;">
                <button type="button" onclick="closeModal('imagesModal')" class="btn-admin btn-secondary">Close</button>
            </div>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('productModal').classList.add('active');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            if (modalId === 'productModal' && !<?php echo $edit_product ? 'true' : 'false'; ?>) {
                window.location.href = 'products.php';
            } else if (modalId === 'imagesModal') {
                window.location.href = 'products.php';
            }
        }
        
        function toggleReplaceForm(imageId) {
            const form = document.getElementById('replace-form-' + imageId);
            form.classList.toggle('active');
        }
        
        // Close modal on outside click
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('productModal');
            }
        });
        
        document.getElementById('imagesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('imagesModal');
            }
        });
    </script>
</body>
</html>