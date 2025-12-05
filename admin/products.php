<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config.php';
$conn = getDBConnection();

// AJAX Request Handling
if (isset($_POST['ajax_action'])) {
    ob_clean();
    header('Content-Type: application/json');
    
    try {
        switch ($_POST['ajax_action']) {
        case 'save_product':
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
                    // Get updated product with category name
                    $result = $conn->query("
                        SELECT p.*, c.category_name, 
                               (SELECT image_url FROM product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image_url
                        FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.category_id 
                        WHERE p.product_id = $product_id
                    ");
                    $product = $result->fetch_assoc();
                    
                    logAdminActivity(
                        $_SESSION['admin_id'],
                        'product_update',
                        "Product updated: $product_name",
                        'products',
                        $product_id,
                        null,
                        ['product_name' => $product_name, 'price' => $price, 'sku' => $sku]
                    );
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Product updated successfully!',
                        'product' => $product
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update product']);
                }
            } else {
                // Add new product
                $stmt = $conn->prepare("INSERT INTO products (product_name, category_id, description, price, sale_price, sku, brand, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sisdsssi", $product_name, $category_id, $description, $price, $sale_price, $sku, $brand, $featured);
                
                if ($stmt->execute()) {
                    $new_product_id = $conn->insert_id();
                    
                    // Get new product with category name
                    $result = $conn->query("
                        SELECT p.*, c.category_name, 
                               (SELECT image_url FROM product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image_url
                        FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.category_id 
                        WHERE p.product_id = $new_product_id
                    ");
                    $product = $result->fetch_assoc();
                    
                    logAdminActivity(
                        $_SESSION['admin_id'],
                        'product_create',
                        "New product created: $product_name (SKU: $sku)",
                        'products',
                        $new_product_id,
                        null,
                        ['product_name' => $product_name, 'sku' => $sku, 'price' => $price]
                    );
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Product added successfully!',
                        'product' => $product,
                        'is_new' => true
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to add product']);
                }
            }
            break;
            
        case 'delete_product':
            $product_id = intval($_POST['product_id']);
            
            $stmt = $conn->prepare("SELECT product_name, sku FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $deleted_product = $stmt->get_result()->fetch_assoc();
            
            $stmt = $conn->prepare("UPDATE products SET is_active = 0 WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            
            if ($stmt->execute()) {
                logAdminActivity(
                    $_SESSION['admin_id'],
                    'product_delete',
                    "Product deleted: {$deleted_product['product_name']} (SKU: {$deleted_product['sku']})",
                    'products',
                    $product_id,
                    ['product_name' => $deleted_product['product_name'], 'sku' => $deleted_product['sku']]
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Product deleted successfully!'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
            }
            break;
            
        case 'load_product':
            $product_id = intval($_POST['product_id']);
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            
            echo json_encode([
                'success' => true,
                'product' => $product
            ]);
            break;
            
        case 'load_images':
            $product_id = intval($_POST['product_id']);
            
            $stmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            
            $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, display_order ASC");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            echo json_encode([
                'success' => true,
                'product_name' => $product['product_name'],
                'images' => $images
            ]);
            break;
            
        case 'add_image':
            $product_id = intval($_POST['product_id']);
            $image_url = trim($_POST['image_url']);
            $is_primary = isset($_POST['is_primary']) ? 1 : 0;
            
            if (empty($product_id)) {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
                break;
            }
            
            if (empty($image_url)) {
                echo json_encode(['success' => false, 'message' => 'Image URL is required']);
                break;
            }
            
            if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid URL format']);
                break;
            }
            
            $stmt = $conn->prepare("SELECT product_id FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                echo json_encode(['success' => false, 'message' => 'Product not found']);
                break;
            }
            
            if ($is_primary) {
                $stmt = $conn->prepare("UPDATE product_images SET is_primary = 0 WHERE product_id = ?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
            }
            
            $stmt = $conn->prepare("SELECT MAX(display_order) as max_order FROM product_images WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $display_order = ($row['max_order'] ?? 0) + 1;
            
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isii", $product_id, $image_url, $is_primary, $display_order);
            
            if ($stmt->execute()) {
                $image_id = $conn->insert_id();
                
                logAdminActivity(
                    $_SESSION['admin_id'],
                    'product_image_add',
                    "Image added to product (ID: $product_id)",
                    'product_images',
                    $image_id,
                    null,
                    ['image_url' => $image_url, 'is_primary' => $is_primary]
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Image added successfully!',
                    'image' => [
                        'image_id' => $image_id,
                        'product_id' => $product_id,
                        'image_url' => $image_url,
                        'is_primary' => $is_primary,
                        'display_order' => $display_order
                    ]
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Database error: ' . $conn->error
                ]);
            }
            break;
            
        case 'delete_image':
            $image_id = intval($_POST['image_id']);
            
            $stmt = $conn->prepare("SELECT product_id, image_url FROM product_images WHERE image_id = ?");
            $stmt->bind_param("i", $image_id);
            $stmt->execute();
            $image_data = $stmt->get_result()->fetch_assoc();
            
            $stmt = $conn->prepare("DELETE FROM product_images WHERE image_id = ?");
            $stmt->bind_param("i", $image_id);
            
            if ($stmt->execute()) {
                logAdminActivity(
                    $_SESSION['admin_id'],
                    'product_image_delete',
                    "Image deleted from product (ID: {$image_data['product_id']})",
                    'product_images',
                    $image_id,
                    ['image_url' => $image_data['image_url']]
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Image deleted successfully!'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete image']);
            }
            break;
            
        case 'set_primary':
            $image_id = intval($_POST['image_id']);
            $product_id = intval($_POST['product_id']);
            
            $conn->query("UPDATE product_images SET is_primary = 0 WHERE product_id = $product_id");
            
            $stmt = $conn->prepare("UPDATE product_images SET is_primary = 1 WHERE image_id = ?");
            $stmt->bind_param("i", $image_id);
            
            if ($stmt->execute()) {
                logAdminActivity(
                    $_SESSION['admin_id'],
                    'product_image_primary',
                    "Primary image changed for product (ID: $product_id)",
                    'product_images',
                    $image_id,
                    ['is_primary' => 0],
                    ['is_primary' => 1]
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Primary image updated!'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to set primary image']);
            }
            break;
            
        case 'update_image_url':
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
                    logAdminActivity(
                        $_SESSION['admin_id'],
                        'product_image_update',
                        "Image URL updated for product (ID: {$old_image['product_id']})",
                        'product_images',
                        $image_id,
                        ['image_url' => $old_image['image_url']],
                        ['image_url' => $new_url]
                    );
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Image URL updated successfully!',
                        'image_url' => $new_url
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update image URL']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Image URL is required']);
            }
            break;
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
    
    $conn->close();
    ob_end_flush();
    exit;
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

// Get unique brands from products
$brands = $conn->query("SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != '' ORDER BY brand")->fetch_all(MYSQLI_ASSOC);

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
        
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }
        
        .filter-header h3 {
            margin: 0;
            color: #1e293b;
            font-size: 1.15rem;
            font-weight: 600;
        }
        
        .filter-toggle {
            background: linear-gradient(135deg, #5b21b6, #06b6d4);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .filter-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .toggle-icon {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
            display: inline-block;
        }
        
        .filter-toggle.collapsed .toggle-icon {
            transform: rotate(-180deg);
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 20px;
            opacity: 1;
            max-height: 1000px;
            overflow: visible;
            transition: all 0.4s ease;
        }
        
        .filter-grid.collapsed {
            opacity: 0;
            max-height: 0;
            margin-bottom: 0;
            overflow: hidden;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #475569;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .filter-group select,
        .filter-group input[type="text"],
        .filter-group input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: white;
            color: #1e293b;
        }
        
        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }
        
        .filter-group input::placeholder {
            color: #94a3b8;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
            pointer-events: none;
        }
        
        .search-box input {
            padding-left: 40px;
        }
        
        .price-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .price-range input {
            flex: 1;
            min-width: 0;
        }
        
        .price-range span {
            color: #64748b;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .checkbox-filter {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-top: 8px;
        }
        
        .checkbox-filter input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #0284c7;
        }
        
        .checkbox-filter label {
            margin: 0;
            cursor: pointer;
            font-weight: normal;
            color: #475569;
            font-size: 0.95rem;
            text-transform: none;
            letter-spacing: normal;
        }
        
        .filter-actions {
            grid-column: 1 / -1;
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }
        
        .filter-actions .btn-admin {
            flex: 1;
            min-width: 140px;
            justify-content: center;
        }
        
        .filter-summary {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 16px 20px;
            border-radius: 10px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #0284c7;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-summary-content {
            color: #0c4a6e;
            font-size: 0.95rem;
            flex: 1;
            min-width: 200px;
        }
        
        .filter-summary-content strong {
            color: #0369a1;
            font-weight: 700;
        }
        
        .btn-clear-filters {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        
        .btn-clear-filters:hover {
            background: #b91c1c;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }
        
        .filter-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }
        
        .filter-badge {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .filter-badge-remove {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.2s ease;
        }
        
        .filter-badge-remove:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: scale(1.1);
        }
        
        .table-header-actions {
            background: white;
            padding: 18px 24px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .table-count {
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .table-count span {
            color: #0284c7;
            font-weight: 700;
        }
        
        .sort-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sort-controls label {
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .sort-controls select {
            padding: 8px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            background: white;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        
        .sort-controls select:focus {
            outline: none;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }
        
        .no-results {
            background: white;
            border-radius: 12px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 2px dashed #e2e8f0;
        }
        
        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.4;
        }
        
        .no-results h3 {
            color: #1e293b;
            font-size: 1.5rem;
            margin: 0 0 10px 0;
            font-weight: 600;
        }
        
        .no-results p {
            color: #64748b;
            font-size: 1rem;
            margin: 0 0 25px 0;
        }
        
        @media (max-width: 968px) {
            .filter-section {
                padding: 20px;
            }
            
            .filter-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 15px;
            }
            
            .table-header-actions {
                padding: 15px 20px;
            }
        }
        
        @media (max-width: 640px) {
            .filter-section {
                padding: 16px;
            }
            
            .filter-header {
                flex-direction: row;
                align-items: center;
            }
            
            .filter-header h3 {
                font-size: 1rem;
            }
            
            .filter-toggle {
                padding: 8px 14px;
                font-size: 0.85rem;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-actions {
                flex-direction: column;
            }
            
            .filter-actions .btn-admin {
                width: 100%;
            }
            
            .table-header-actions {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }
            
            .sort-controls {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .sort-controls select {
                width: 100%;
            }
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .pagination button {
            padding: 8px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            cursor: pointer;
            background: white;
            color: #2c3e50;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .pagination button:hover {
            border-color: #3498db;
            background: #ecf0f1;
        }
        
        .pagination button.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
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
            background: none;
            border: none;
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
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            max-width: 400px;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .notification.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .notification.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .product-row.highlight {
            animation: highlight 1s ease;
        }
        
        @keyframes highlight {
            0%, 100% { background: transparent; }
            50% { background: #e3f2fd; }
        }
        
        /* Image Modal Styles */
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
            transition: all 0.3s;
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
        
        .gmail-setup-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .gmail-setup-box h3 {
            color: white;
            margin-top: 0;
            margin-bottom: 15px;
        }
        
        .gmail-setup-box ol {
            margin-left: 20px;
            line-height: 1.8;
        }
        
        .test-email-form {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .test-email-form h4 {
            margin-bottom: 10px;
        }
        
        #imagesModal .modal-content {
            max-width: 900px;
        }
        
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .image-gallery {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 10px;
            }
            
            .image-item img {
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Products Management</h1>
                <button onclick="openAddModal()" class="btn-admin btn-success">+ Add New Product</button>
            </header>

            <section class="filter-section">
                <div class="filter-header">
                    <h3>Filters</h3>
                    <button class="filter-toggle" id="filterToggle">
                        <span>Hide Filters</span>
                        <span class="toggle-icon">▼</span>
                    </button>
                </div>
                
                <div class="filter-grid" id="filterGrid">
                    <div class="filter-group">
                        <label for="searchInput">Search Products</label>
                        <div class="search-box">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="searchInput" placeholder="Search by name, SKU, or brand...">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label for="categoryFilter">Category</label>
                        <select id="categoryFilter">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>">
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="priceMin">Price Range</label>
                        <div class="price-range">
                            <input type="number" id="priceMin" placeholder="Min" step="0.01">
                            <span>to</span>
                            <input type="number" id="priceMax" placeholder="Max" step="0.01">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label for="featuredFilter">Featured Status</label>
                        <select id="featuredFilter">
                            <option value="">All Products</option>
                            <option value="1">Featured Only</option>
                            <option value="0">Not Featured</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="sortBy">Sort By</label>
                        <select id="sortBy">
                            <option value="created_at_desc">Newest First</option>
                            <option value="created_at_asc">Oldest First</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                            <option value="sale_price_desc">Sale Price: High to Low</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="brandFilter">Brand</label>
                        <select id="brandFilter">
                            <option value="">All Brands</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo htmlspecialchars($brand['brand']); ?>">
                                    <?php echo htmlspecialchars($brand['brand']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="checkbox-filter">
                        <input type="checkbox" id="showOnlyOnSale">
                        <label for="showOnlyOnSale">Show only products on sale</label>
                    </div>
                    
                    <div class="filter-actions">
                        <button onclick="applyFilters()" class="btn-admin btn-primary">Apply Filters</button>
                        <button onclick="clearFilters()" class="btn-admin btn-secondary">Clear All</button>
                    </div>
                </div>
                
                <div class="filter-summary" id="filterSummary" style="display: none;">
                    <div class="filter-summary-content" id="filterSummaryText"></div>
                    <button onclick="clearFilters()" class="btn-clear-filters">Clear Filters</button>
                </div>
                
                <div class="filter-badges" id="activeFilters"></div>
            </section>

            <div class="table-header-actions">
                <div class="table-count">
                    Showing <span id="productCount"><?php echo count($products); ?></span> products
                </div>
                <div class="sort-controls">
                    <label for="resultsPerPage">Results per page:</label>
                    <select id="resultsPerPage" onchange="applyFilters()">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                    </select>
                </div>
            </div>
            
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
                    <tbody id="productsTableBody">
                        <?php foreach ($products as $product): ?>
                            <tr class="product-row" data-product-id="<?php echo $product['product_id']; ?>">
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
                                    <button onclick="manageImages(<?php echo $product['product_id']; ?>)" class="btn-admin btn-success" style="margin-right: 5px;">Images</button>
                                    <button onclick="editProduct(<?php echo $product['product_id']; ?>)" class="btn-admin btn-primary" style="margin-right: 5px;">Edit</button>
                                    <button onclick="deleteProduct(<?php echo $product['product_id']; ?>)" class="btn-admin btn-danger">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="pagination" style="margin-top: 20px;"></div>
            </div>
            
            <div id="noResults" class="no-results" style="display: none;">
                <div class="no-results-icon">📦</div>
                <h3>No products found</h3>
                <p>Try adjusting your filters or search criteria</p>
                <button onclick="clearFilters()" class="btn-admin btn-primary" style="margin-top: 15px;">
                    Clear All Filters
                </button>
            </div>
        </main>
    </div>
    
    <!-- Add/Edit Product Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Product</h2>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="productForm">
                <input type="hidden" id="product_id" name="product_id">
                
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Category *</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>">
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>SKU *</label>
                        <input type="text" id="sku" name="sku" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" id="brand" name="brand">
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Regular Price *</label>
                        <input type="number" step="0.01" id="price" name="price" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Sale Price</label>
                        <input type="number" step="0.01" id="sale_price" name="sale_price">
                    </div>
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="featured" name="featured" value="1">
                    <label for="featured" style="margin: 0;">Featured Product</label>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" id="submitBtn" class="btn-admin btn-success" style="flex: 1;">
                        <span id="submitText">Save Product</span>
                    </button>
                    <button type="button" onclick="closeModal()" class="btn-admin btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Manage Images Modal -->
    <div id="imagesModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="imagesModalTitle">Manage Images</h2>
                <button class="close-modal" onclick="closeImagesModal()">&times;</button>
            </div>
            
            <div id="imagesContent">
                <!-- Add New Image Form -->
                <form id="addImageForm" style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <input type="hidden" id="image_product_id" name="product_id">
                    <h3 style="margin-bottom: 15px;">Add New Image</h3>
                    <div class="form-group">
                        <label>Image URL *</label>
                        <input type="url" id="image_url" name="image_url" required placeholder="https://example.com/image.jpg">
                    </div>
                    <div class="checkbox-group" style="margin-bottom: 15px;">
                        <input type="checkbox" id="is_primary" name="is_primary">
                        <label for="is_primary" style="margin: 0;">Set as primary image</label>
                    </div>
                    <button type="submit" class="btn-admin btn-success">Add Image</button>
                </form>
                
                <!-- Images Gallery -->
                <h3>Current Images (<span id="imageCount">0</span>)</h3>
                <div id="imagesGallery" class="image-gallery">
                    <!-- Images will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // Open add modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Product';
            document.getElementById('productForm').reset();
            document.getElementById('product_id').value = '';
            document.getElementById('sku').value = 'SKU-' + Date.now();
            document.getElementById('productModal').classList.add('active');
        }
        
        // Edit product
        async function editProduct(productId) {
            try {
                const formData = new FormData();
                formData.append('ajax_action', 'load_product');
                formData.append('product_id', productId);
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const product = data.product;
                    
                    document.getElementById('modalTitle').textContent = 'Edit Product';
                    document.getElementById('product_id').value = product.product_id;
                    document.getElementById('product_name').value = product.product_name;
                    document.getElementById('category_id').value = product.category_id;
                    document.getElementById('sku').value = product.sku;
                    document.getElementById('brand').value = product.brand || '';
                    document.getElementById('description').value = product.description || '';
                    document.getElementById('price').value = product.price;
                    document.getElementById('sale_price').value = product.sale_price || '';
                    document.getElementById('featured').checked = product.featured == 1;
                    
                    document.getElementById('productModal').classList.add('active');
                }
            } catch (error) {
                showNotification('Error loading product: ' + error.message, 'error');
            }
        }
        
        // Delete product
        async function deleteProduct(productId) {
            if (!confirm('Are you sure you want to delete this product?')) {
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('ajax_action', 'delete_product');
                formData.append('product_id', productId);
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    allProducts = allProducts.filter(p => p.product_id != productId);
                    filteredProducts = filteredProducts.filter(p => p.product_id != productId);
                    updateProductDisplay();
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                showNotification('Error deleting product: ' + error.message, 'error');
            }
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('productModal').classList.remove('active');
        }
        
        // Handle form submission
        document.getElementById('productForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const originalText = submitText.textContent;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitText.innerHTML = '<span class="loading-spinner"></span> Saving...';
            
            try {
                const formData = new FormData(this);
                formData.append('ajax_action', 'save_product');
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    if (data.is_new) {
                        // Add new row to table
                        addProductRow(data.product);
                    } else {
                        // Update existing row
                        updateProductRow(data.product);
                    }
                    
                    closeModal();
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                showNotification('Error saving product: ' + error.message, 'error');
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = originalText;
            }
        });
        
        // Add new product row to table
        function addProductRow(product) {
            allProducts.unshift(product);
            filteredProducts.unshift(product);
            currentPage = 1;
            updateProductDisplay();
        }
        
        // Update existing product row
        function updateProductRow(product) {
            const index = allProducts.findIndex(p => p.product_id === product.product_id);
            if (index !== -1) {
                allProducts[index] = product;
            }
            
            const filteredIndex = filteredProducts.findIndex(p => p.product_id === product.product_id);
            if (filteredIndex !== -1) {
                filteredProducts[filteredIndex] = product;
            }
            
            updateProductDisplay();
        }
        
        // Create product row HTML
        function createProductRow(product) {
            const row = document.createElement('tr');
            row.className = 'product-row';
            row.setAttribute('data-product-id', product.product_id);
            
            const imageUrl = product.image_url || '../images/placeholder.jpg';
            const salePrice = product.sale_price 
                ? `<span style="color: #e74c3c; font-weight: bold;">$${parseFloat(product.sale_price).toFixed(2)}</span>`
                : '-';
            const featured = product.featured == 1 
                ? '<span style="color: #f39c12;">⭐ Featured</span>'
                : '-';
            
            row.innerHTML = `
                <td>
                    <img src="${imageUrl}" alt="Product" class="product-image-thumb">
                </td>
                <td>
                    <strong>${escapeHtml(product.product_name)}</strong><br>
                    <small style="color: #7f8c8d;">${escapeHtml(product.brand || '')}</small>
                </td>
                <td>${escapeHtml(product.category_name)}</td>
                <td>${escapeHtml(product.sku)}</td>
                <td>$${parseFloat(product.price).toFixed(2)}</td>
                <td>${salePrice}</td>
                <td>${featured}</td>
                <td>
                    <button onclick="manageImages(${product.product_id})" class="btn-admin btn-success" style="margin-right: 5px;">Images</button>
                    <button onclick="editProduct(${product.product_id})" class="btn-admin btn-primary" style="margin-right: 5px;">Edit</button>
                    <button onclick="deleteProduct(${product.product_id})" class="btn-admin btn-danger">Delete</button>
                </td>
            `;
            
            return row;
        }
        
        // Escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Close modal on outside click
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        document.getElementById('imagesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImagesModal();
            }
        });
        
        // Manage Images
        async function manageImages(productId) {
            try {
                const formData = new FormData();
                formData.append('ajax_action', 'load_images');
                formData.append('product_id', productId);
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('imagesModalTitle').textContent = 'Manage Images - ' + data.product_name;
                    document.getElementById('image_product_id').value = productId;
                    document.getElementById('imageCount').textContent = data.images.length;
                    
                    const gallery = document.getElementById('imagesGallery');
                    
                    if (data.images.length === 0) {
                        gallery.innerHTML = '<div class="no-images"><p>No images uploaded yet. Add your first image above!</p></div>';
                    } else {
                        gallery.innerHTML = data.images.map(image => createImageCardHTML(image)).join('');
                    }
                    
                    document.getElementById('imagesModal').classList.add('active');
                } else {
                    showNotification('Failed to load images', 'error');
                }
            } catch (error) {
                console.error('Error loading images:', error);
                showNotification('Error loading images: ' + error.message, 'error');
            }
        }
        
        // Separate function to create image card HTML
        function createImageCardHTML(image) {
            const primaryBadge = image.is_primary == 1 ? '<span class="primary-badge">PRIMARY</span>' : '';
            const primaryClass = image.is_primary == 1 ? 'primary' : '';
            const setPrimaryButton = image.is_primary != 1 
                ? `<button onclick="setPrimaryImage(${image.image_id}, ${image.product_id})" class="btn-set-primary">Set as Primary</button>`
                : '';
            
            return `
                <div class="image-item ${primaryClass}" id="image-${image.image_id}">
                    ${primaryBadge}
                    <img src="${escapeHtml(image.image_url)}" alt="Product Image" onerror="this.src='../images/placeholder.jpg'">
                    <div class="image-actions">
                        ${setPrimaryButton}
                        <button onclick="toggleReplaceForm(${image.image_id})" class="btn-replace">Replace URL</button>
                        <button onclick="deleteImage(${image.image_id})" class="btn-delete">Delete</button>
                    </div>
                    <div class="replace-form" id="replace-form-${image.image_id}">
                        <input type="url" id="new-url-${image.image_id}" placeholder="New image URL" required>
                        <button onclick="updateImageUrl(${image.image_id})" class="btn-admin btn-success">Update URL</button>
                        <button onclick="toggleReplaceForm(${image.image_id})" class="btn-admin btn-secondary">Cancel</button>
                    </div>
                </div>
            `;
        }
        
        // Create image card HTML
        function createImageCard(image) {
            const primaryBadge = image.is_primary == 1 ? '<span class="primary-badge">PRIMARY</span>' : '';
            const primaryClass = image.is_primary == 1 ? 'primary' : '';
            const setPrimaryButton = image.is_primary != 1 
                ? `<button onclick="setPrimaryImage(${image.image_id}, ${image.product_id})" class="btn-set-primary">Set as Primary</button>`
                : '';
            
            return `
                <div class="image-item ${primaryClass}" id="image-${image.image_id}">
                    ${primaryBadge}
                    <img src="${escapeHtml(image.image_url)}" alt="Product Image" onerror="this.src='../images/placeholder.jpg'">
                    <div class="image-actions">
                        ${setPrimaryButton}
                        <button onclick="toggleReplaceForm(${image.image_id})" class="btn-replace">Replace URL</button>
                        <button onclick="deleteImage(${image.image_id})" class="btn-delete">Delete</button>
                    </div>
                    <div class="replace-form" id="replace-form-${image.image_id}">
                        <input type="url" id="new-url-${image.image_id}" placeholder="New image URL" required>
                        <button onclick="updateImageUrl(${image.image_id})" class="btn-admin btn-success">Update URL</button>
                        <button onclick="toggleReplaceForm(${image.image_id})" class="btn-admin btn-secondary">Cancel</button>
                    </div>
                </div>
            `;
        }
        
        // Add image form submission
        document.getElementById('addImageForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Adding...';
            
            try {
                const formData = new FormData(this);
                formData.append('ajax_action', 'add_image');
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                // Parse JSON response
                const data = await response.json();
                
                if (data.success) {
                    // Add new image to gallery
                    const gallery = document.getElementById('imagesGallery');
                    
                    // Remove "no images" message if present
                    const noImages = gallery.querySelector('.no-images');
                    if (noImages) {
                        noImages.remove();
                    }
                    
                    // Create new image card element
                    const imageCard = document.createElement('div');
                    imageCard.className = 'image-item' + (data.image.is_primary == 1 ? ' primary' : '');
                    imageCard.id = 'image-' + data.image.image_id;
                    
                    const primaryBadge = data.image.is_primary == 1 ? '<span class="primary-badge">PRIMARY</span>' : '';
                    const setPrimaryButton = data.image.is_primary != 1 
                        ? `<button onclick="setPrimaryImage(${data.image.image_id}, ${data.image.product_id})" class="btn-set-primary">Set as Primary</button>`
                        : '';
                    
                    imageCard.innerHTML = `
                        ${primaryBadge}
                        <img src="${escapeHtml(data.image.image_url)}" alt="Product Image" onerror="this.src='../images/placeholder.jpg'">
                        <div class="image-actions">
                            ${setPrimaryButton}
                            <button onclick="toggleReplaceForm(${data.image.image_id})" class="btn-replace">Replace URL</button>
                            <button onclick="deleteImage(${data.image.image_id})" class="btn-delete">Delete</button>
                        </div>
                        <div class="replace-form" id="replace-form-${data.image.image_id}">
                            <input type="url" id="new-url-${data.image.image_id}" placeholder="New image URL" required>
                            <button onclick="updateImageUrl(${data.image.image_id})" class="btn-admin btn-success">Update URL</button>
                            <button onclick="toggleReplaceForm(${data.image.image_id})" class="btn-admin btn-secondary">Cancel</button>
                        </div>
                    `;
                    
                    // Insert at the beginning of gallery
                    gallery.insertBefore(imageCard, gallery.firstChild);
                    
                    // Update count
                    const currentCount = parseInt(document.getElementById('imageCount').textContent);
                    document.getElementById('imageCount').textContent = currentCount + 1;
                    
                    // Reset form
                    this.reset();
                    
                    // If this was set as primary, update product thumbnail in main table
                    if (data.image.is_primary == 1) {
                        updateProductThumbnail(data.image.product_id, data.image.image_url);
                    }
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message || 'Failed to add image', 'error');
                }
            } catch (error) {
                console.error('Error adding image:', error);
                showNotification('Error adding image: ' + error.message, 'error');
            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
        
        // Set primary image
        async function setPrimaryImage(imageId, productId) {
            try {
                const formData = new FormData();
                formData.append('ajax_action', 'set_primary');
                formData.append('image_id', imageId);
                formData.append('product_id', productId);
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Reload images to reflect changes
                    manageImages(productId);
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                showNotification('Error setting primary image: ' + error.message, 'error');
            }
        }
        
        // Delete image
        async function deleteImage(imageId) {
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('ajax_action', 'delete_image');
                formData.append('image_id', imageId);
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Remove image card with animation
                    const imageCard = document.getElementById(`image-${imageId}`);
                    imageCard.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        imageCard.remove();
                        
                        // Update count
                        const currentCount = parseInt(document.getElementById('imageCount').textContent);
                        document.getElementById('imageCount').textContent = currentCount - 1;
                        
                        // Show "no images" if gallery is empty
                        const gallery = document.getElementById('imagesGallery');
                        if (gallery.children.length === 0) {
                            gallery.innerHTML = '<div class="no-images"><p>No images uploaded yet. Add your first image above!</p></div>';
                        }
                    }, 300);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                showNotification('Error deleting image: ' + error.message, 'error');
            }
        }
        
        // Toggle replace form
        function toggleReplaceForm(imageId) {
            const form = document.getElementById(`replace-form-${imageId}`);
            form.classList.toggle('active');
        }
        
        // Update image URL
        async function updateImageUrl(imageId) {
            const newUrl = document.getElementById(`new-url-${imageId}`).value;
            
            if (!newUrl) {
                showNotification('Please enter a valid URL', 'error');
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('ajax_action', 'update_image_url');
                formData.append('image_id', imageId);
                formData.append('new_image_url', newUrl);
                
                const response = await fetch('products.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update image src
                    const imageCard = document.getElementById(`image-${imageId}`);
                    const img = imageCard.querySelector('img');
                    img.src = data.image_url;
                    
                    // Hide replace form
                    toggleReplaceForm(imageId);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                showNotification('Error updating image URL: ' + error.message, 'error');
            }
        }
        
        // Update product thumbnail in main table
        function updateProductThumbnail(productId, imageUrl) {
            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            if (row) {
                const img = row.querySelector('.product-image-thumb');
                if (img) {
                    img.src = imageUrl;
                }
            }
        }
        
        // Close images modal
        function closeImagesModal() {
            document.getElementById('imagesModal').classList.remove('active');
            document.getElementById('addImageForm').reset();
        }
        
        // Add fadeOut animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeOut {
                to {
                    opacity: 0;
                    transform: translateX(-20px);
                }
            }
        `;
        document.head.appendChild(style);
        
        // Filter functionality
        let currentFilters = {};
        let allProducts = <?php echo json_encode($products); ?>;
        let filteredProducts = [...allProducts];
        let currentPage = 1;
        let itemsPerPage = 25;
        
        function setupFilterToggle() {
            const filterToggle = document.getElementById('filterToggle');
            const filterGrid = document.getElementById('filterGrid');
            
            if (!filterToggle || !filterGrid) {
                console.error('Filter elements not found');
                return;
            }
            
            filterGrid.classList.remove('collapsed');
            filterToggle.classList.remove('collapsed');
            
            filterToggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const isCollapsed = filterGrid.classList.toggle('collapsed');
                filterToggle.classList.toggle('collapsed', isCollapsed);
                
                const buttonText = filterToggle.querySelector('span:first-child');
                if (buttonText) {
                    buttonText.textContent = isCollapsed ? 'Show Filters' : 'Hide Filters';
                }
                
                const icon = filterToggle.querySelector('.toggle-icon');
                if (icon) {
                    icon.style.transform = isCollapsed ? 'rotate(-180deg)' : 'rotate(0deg)';
                }
            });
        }
        
        function setupFilterInputs() {
            let searchTimeout;
            
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        applyFilters();
                    }, 300);
                });
            }
            
            ['categoryFilter', 'featuredFilter', 'brandFilter', 'sortBy', 'resultsPerPage'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('change', applyFilters);
                }
            });
            
            let priceTimeout;
            ['priceMin', 'priceMax'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', function() {
                        clearTimeout(priceTimeout);
                        priceTimeout = setTimeout(() => {
                            applyFilters();
                        }, 500);
                    });
                }
            });
            
            const onSaleCheckbox = document.getElementById('showOnlyOnSale');
            if (onSaleCheckbox) {
                onSaleCheckbox.addEventListener('change', applyFilters);
            }
        }
        
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const categoryId = document.getElementById('categoryFilter').value;
            const priceMin = document.getElementById('priceMin').value ? parseFloat(document.getElementById('priceMin').value) : null;
            const priceMax = document.getElementById('priceMax').value ? parseFloat(document.getElementById('priceMax').value) : null;
            const featuredFilter = document.getElementById('featuredFilter').value;
            const brandFilter = document.getElementById('brandFilter').value;
            const sortBy = document.getElementById('sortBy').value;
            const showOnlyOnSale = document.getElementById('showOnlyOnSale').checked;
            itemsPerPage = parseInt(document.getElementById('resultsPerPage').value);
            
            currentFilters = {
                search: searchTerm,
                category: categoryId,
                priceMin: priceMin,
                priceMax: priceMax,
                featured: featuredFilter,
                brand: brandFilter,
                sort: sortBy,
                onSale: showOnlyOnSale
            };
            
            filteredProducts = allProducts.filter(product => {
                if (searchTerm) {
                    const searchable = [
                        product.product_name?.toLowerCase(),
                        product.sku?.toLowerCase(),
                        product.brand?.toLowerCase(),
                        product.description?.toLowerCase()
                    ].join(' ');
                    
                    if (!searchable.includes(searchTerm)) {
                        return false;
                    }
                }
                
                if (categoryId && product.category_id != categoryId) {
                    return false;
                }
                
                if (priceMin !== null && parseFloat(product.price) < priceMin) {
                    return false;
                }
                
                if (priceMax !== null && parseFloat(product.price) > priceMax) {
                    return false;
                }
                
                if (featuredFilter !== '' && product.featured != featuredFilter) {
                    return false;
                }
                
                if (brandFilter && product.brand !== brandFilter) {
                    return false;
                }
                
                if (showOnlyOnSale && (!product.sale_price || parseFloat(product.sale_price) <= 0)) {
                    return false;
                }
                
                return true;
            });
            
            sortProducts(sortBy);
            currentPage = 1;
            updateProductDisplay();
            updateFilterSummary();
            updateActiveFilterBadges();
        }
        
        function sortProducts(sortBy) {
            filteredProducts.sort((a, b) => {
                switch (sortBy) {
                    case 'created_at_desc':
                        return new Date(b.created_at) - new Date(a.created_at);
                    case 'created_at_asc':
                        return new Date(a.created_at) - new Date(b.created_at);
                    case 'price_asc':
                        return parseFloat(a.price) - parseFloat(b.price);
                    case 'price_desc':
                        return parseFloat(b.price) - parseFloat(a.price);
                    case 'name_asc':
                        return a.product_name.localeCompare(b.product_name);
                    case 'name_desc':
                        return b.product_name.localeCompare(a.product_name);
                    case 'sale_price_desc':
                        const salePriceA = a.sale_price ? parseFloat(a.sale_price) : 0;
                        const salePriceB = b.sale_price ? parseFloat(b.sale_price) : 0;
                        return salePriceB - salePriceA;
                    default:
                        return 0;
                }
            });
        }
        
        function updateProductDisplay() {
            const tbody = document.getElementById('productsTableBody');
            const noResults = document.getElementById('noResults');
            const pagination = document.getElementById('pagination');
            
            if (filteredProducts.length === 0) {
                tbody.innerHTML = '';
                noResults.style.display = 'block';
                pagination.innerHTML = '';
                updateProductCount();
                return;
            }
            
            noResults.style.display = 'none';
            
            const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
            currentPage = Math.min(currentPage, totalPages) || 1;
            
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredProducts.length);
            const currentProducts = filteredProducts.slice(startIndex, endIndex);
            
            tbody.innerHTML = currentProducts.map(product => createProductRowHTML(product)).join('');
            
            updatePagination(totalPages);
            updateProductCount();
        }
        
        function createProductRowHTML(product) {
            const imageUrl = product.image_url || '../images/placeholder.jpg';
            const salePrice = product.sale_price 
                ? `<span style="color: #e74c3c; font-weight: bold;">$${parseFloat(product.sale_price).toFixed(2)}</span>`
                : '-';
            const featured = product.featured == 1 
                ? '<span style="color: #f39c12;">⭐ Featured</span>'
                : '-';
            
            return `
                <tr class="product-row" data-product-id="${product.product_id}">
                    <td>
                        <img src="${imageUrl}" alt="Product" class="product-image-thumb">
                    </td>
                    <td>
                        <strong>${escapeHtml(product.product_name)}</strong><br>
                        <small style="color: #7f8c8d;">${escapeHtml(product.brand || '')}</small>
                    </td>
                    <td>${escapeHtml(product.category_name)}</td>
                    <td>${escapeHtml(product.sku)}</td>
                    <td>$${parseFloat(product.price).toFixed(2)}</td>
                    <td>${salePrice}</td>
                    <td>${featured}</td>
                    <td>
                        <button onclick="manageImages(${product.product_id})" class="btn-admin btn-success" style="margin-right: 5px;">Images</button>
                        <button onclick="editProduct(${product.product_id})" class="btn-admin btn-primary" style="margin-right: 5px;">Edit</button>
                        <button onclick="deleteProduct(${product.product_id})" class="btn-admin btn-danger">Delete</button>
                    </td>
                </tr>
            `;
        }
        
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
        
        function updatePagination(totalPages) {
            const pagination = document.getElementById('pagination');
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            
            if (currentPage > 1) {
                paginationHTML += `<button onclick="goToPage(${currentPage - 1})" class="btn-admin btn-secondary">Previous</button>`;
            }
            
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    paginationHTML += `<button class="btn-admin btn-primary active" style="margin: 0 2px;">${i}</button>`;
                } else {
                    paginationHTML += `<button onclick="goToPage(${i})" class="btn-admin btn-secondary" style="margin: 0 2px;">${i}</button>`;
                }
            }
            
            if (currentPage < totalPages) {
                paginationHTML += `<button onclick="goToPage(${currentPage + 1})" class="btn-admin btn-secondary">Next</button>`;
            }
            
            pagination.innerHTML = paginationHTML;
        }
        
        function goToPage(page) {
            currentPage = page;
            updateProductDisplay();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function updateProductCount() {
            const countElement = document.getElementById('productCount');
            const total = filteredProducts.length;
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, total);
            
            if (total === 0) {
                countElement.textContent = '0';
            } else if (total <= itemsPerPage) {
                countElement.textContent = `${total}`;
            } else {
                countElement.textContent = `${start}-${end} of ${total}`;
            }
        }
        
        function updateFilterSummary() {
            const summary = document.getElementById('filterSummary');
            const summaryText = document.getElementById('filterSummaryText');
            
            if (!summary || !summaryText) return;
            
            const activeFilters = [];
            
            if (currentFilters.search) {
                activeFilters.push(`Search: "${currentFilters.search}"`);
            }
            
            if (currentFilters.category) {
                const select = document.getElementById('categoryFilter');
                const categoryName = select.options[select.selectedIndex].text;
                activeFilters.push(`Category: ${categoryName}`);
            }
            
            if (currentFilters.priceMin !== null || currentFilters.priceMax !== null) {
                const min = currentFilters.priceMin !== null ? `$${currentFilters.priceMin.toFixed(2)}` : 'Any';
                const max = currentFilters.priceMax !== null ? `$${currentFilters.priceMax.toFixed(2)}` : 'Any';
                activeFilters.push(`Price: ${min} - ${max}`);
            }
            
            if (currentFilters.featured !== '') {
                activeFilters.push(`Featured: ${currentFilters.featured === '1' ? 'Yes' : 'No'}`);
            }
            
            if (currentFilters.brand) {
                activeFilters.push(`Brand: ${currentFilters.brand}`);
            }
            
            if (currentFilters.onSale) {
                activeFilters.push('On Sale Only');
            }
            
            if (activeFilters.length > 0) {
                summaryText.innerHTML = `<strong>${filteredProducts.length} product${filteredProducts.length !== 1 ? 's' : ''}</strong> filtered by: ${activeFilters.join(', ')}`;
                summary.style.display = 'flex';
            } else {
                summary.style.display = 'none';
            }
        }
        
        function updateActiveFilterBadges() {
            const container = document.getElementById('activeFilters');
            if (!container) return;
            
            let badgesHTML = '';
            
            const badgeConfigs = [
                {
                    condition: currentFilters.search,
                    label: `Search: "${currentFilters.search}"`,
                    type: 'search'
                },
                {
                    condition: currentFilters.category,
                    label: `Category: ${document.getElementById('categoryFilter')?.options[document.getElementById('categoryFilter').selectedIndex]?.text}`,
                    type: 'category'
                },
                {
                    condition: currentFilters.priceMin !== null || currentFilters.priceMax !== null,
                    label: `Price: ${currentFilters.priceMin !== null ? `$${currentFilters.priceMin.toFixed(2)}` : 'Any'} - ${currentFilters.priceMax !== null ? `$${currentFilters.priceMax.toFixed(2)}` : 'Any'}`,
                    type: 'price'
                },
                {
                    condition: currentFilters.featured !== '',
                    label: `Featured: ${currentFilters.featured === '1' ? 'Yes' : 'No'}`,
                    type: 'featured'
                },
                {
                    condition: currentFilters.brand,
                    label: `Brand: ${currentFilters.brand}`,
                    type: 'brand'
                },
                {
                    condition: currentFilters.onSale,
                    label: 'On Sale Only',
                    type: 'onSale'
                }
            ];
            
            badgeConfigs.forEach(config => {
                if (config.condition) {
                    badgesHTML += `
                        <span class="filter-badge">
                            ${config.label}
                            <button onclick="removeFilter('${config.type}')" class="filter-badge-remove" title="Remove filter">×</button>
                        </span>
                    `;
                }
            });
            
            container.innerHTML = badgesHTML;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing filters...');
            setupFilterToggle();
            setupFilterInputs();
            updateProductDisplay();
        });
        
        function clearFilters() {
            const inputs = {
                'searchInput': '',
                'categoryFilter': '',
                'priceMin': '',
                'priceMax': '',
                'featuredFilter': '',
                'brandFilter': '',
                'sortBy': 'created_at_desc'
            };
            
            Object.entries(inputs).forEach(([id, value]) => {
                const element = document.getElementById(id);
                if (element) {
                    element.value = value;
                }
            });
            
            const onSaleCheckbox = document.getElementById('showOnlyOnSale');
            if (onSaleCheckbox) {
                onSaleCheckbox.checked = false;
            }
            
            currentPage = 1;
            filteredProducts = [...allProducts];
            currentFilters = {};
            
            updateProductDisplay();
            updateFilterSummary();
            updateActiveFilterBadges();
            
            showNotification('All filters cleared', 'success');
        }
        
        function removeFilter(filterType) {
            const filterMap = {
                'search': 'searchInput',
                'category': 'categoryFilter',
                'featured': 'featuredFilter',
                'brand': 'brandFilter'
            };
            
            if (filterType === 'price') {
                document.getElementById('priceMin').value = '';
                document.getElementById('priceMax').value = '';
            } else if (filterType === 'onSale') {
                document.getElementById('showOnlyOnSale').checked = false;
            } else if (filterMap[filterType]) {
                document.getElementById(filterMap[filterType]).value = '';
            }
            
            applyFilters();
        }
    </script>
</body>
</html>