<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$message = '';
$error = '';

// Handle category add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);
    $parent_category_id = !empty($_POST['parent_category_id']) ? intval($_POST['parent_category_id']) : null;
    $image_url = trim($_POST['image_url']);
    
    // Handle file upload
    $upload_dir = '../uploads/categories/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['category_image']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($filetype, $allowed)) {
            $new_filename = uniqid('cat_') . '.' . $filetype;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $upload_path)) {
                $image_url = 'uploads/categories/' . $new_filename;
            } else {
                $error = 'Failed to upload image.';
            }
        } else {
            $error = 'Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP allowed.';
        }
    }
    
    if (empty($error)) {
        if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
            // Update existing category
            $category_id = intval($_POST['category_id']);
            
            if (!empty($image_url)) {
                $stmt = $conn->prepare("UPDATE categories SET category_name=?, description=?, parent_category_id=?, image_url=? WHERE category_id=?");
                $stmt->bind_param("sssii", $category_name, $description, $parent_category_id, $image_url, $category_id);
            } else {
                $stmt = $conn->prepare("UPDATE categories SET category_name=?, description=?, parent_category_id=? WHERE category_id=?");
                $stmt->bind_param("ssii", $category_name, $description, $parent_category_id, $category_id);
            }
            
            if ($stmt->execute()) {
                $message = 'Category updated successfully!';
            }
        } else {
            // Add new category
            $stmt = $conn->prepare("INSERT INTO categories (category_name, description, parent_category_id, image_url) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $category_name, $description, $parent_category_id, $image_url);
            if ($stmt->execute()) {
                $message = 'Category added successfully!';
            }
        }
    }
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $category_id = intval($_GET['delete']);
    $conn->query("UPDATE categories SET is_active = 0 WHERE category_id = $category_id");
    $message = 'Category deleted successfully!';
}

// Get all categories with product count
$categories = $conn->query("
    SELECT c.*, 
           pc.category_name as parent_name,
           COUNT(DISTINCT p.product_id) as product_count
    FROM categories c
    LEFT JOIN categories pc ON c.parent_category_id = pc.category_id
    LEFT JOIN products p ON c.category_id = p.category_id
    WHERE c.is_active = 1
    GROUP BY c.category_id
    ORDER BY c.parent_category_id, c.category_name
")->fetch_all(MYSQLI_ASSOC);

// Get parent categories for dropdown
$parent_categories = $conn->query("SELECT * FROM categories WHERE parent_category_id IS NULL AND is_active = 1 ORDER BY category_name")->fetch_all(MYSQLI_ASSOC);

// Get category for editing
$edit_category = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_category = $stmt->get_result()->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .categories-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }
        
        .category-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin-bottom: 10px;
            display: flex;
            gap: 15px;
            align-items: center;
            position: relative;
            isolation: isolate;
        }
        
        .category-card.subcategory {
            margin-left: 30px;
            border-left-color: #95a5a6;
            background: #ecf0f1;
        }
        
        .category-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            border: 2px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }
        
        .category-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }
        
        .category-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }
        
        .category-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            position: relative;
            z-index: 10;
        }
        
        .category-info .btn-admin {
            position: relative;
            z-index: 100 !important;
            pointer-events: all !important;
            cursor: pointer !important;
        }
        
        .form-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }
        
        .image-upload-section {
            margin-bottom: 20px;
        }
        
        .upload-options {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .upload-tab {
            flex: 1;
            padding: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            position: relative;
            z-index: 10;
            pointer-events: all !important;
        }
        
        .upload-tab.active {
            border-color: #3498db;
            background: #ebf5fb;
            color: #3498db;
        }
        
        .upload-tab:hover {
            border-color: #3498db;
            transform: translateY(-2px);
        }
        
        .upload-content {
            display: none;
            position: relative;
            z-index: 5;
        }
        
        .upload-content.active {
            display: block;
        }
        
        .file-upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8fafc;
            position: relative;
            z-index: 10;
            pointer-events: all !important;
        }
        
        .file-upload-area:hover {
            border-color: #3498db;
            background: #ebf5fb;
        }
        
        .file-upload-area.dragover {
            border-color: #3498db;
            background: #ebf5fb;
        }
        
        .upload-icon {
            font-size: 3rem;
            color: #cbd5e0;
            margin-bottom: 10px;
            pointer-events: none;
        }
        
        .image-preview {
            margin-top: 15px;
            text-align: center;
            position: relative;
            z-index: 5;
        }
        
        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }
        
        .remove-image {
            display: inline-block;
            margin-top: 10px;
            color: #e74c3c;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            position: relative;
            z-index: 100;
            pointer-events: all !important;
        }
        
        .remove-image:hover {
            text-decoration: underline;
            transform: scale(1.05);
        }
        
        .suggested-images {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 10px;
            position: relative;
            z-index: 10;
        }
        
        .suggested-image {
            position: relative;
            cursor: pointer;
            border-radius: 8px;
            overflow: hidden;
            border: 3px solid transparent;
            transition: all 0.3s;
            z-index: 10;
            pointer-events: all !important;
        }
        
        .suggested-image:hover {
            border-color: #3498db;
            transform: scale(1.05);
        }
        
        .suggested-image.selected {
            border-color: #27ae60;
        }
        
        .suggested-image img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            display: block;
            pointer-events: none;
        }
        
        .no-image-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            flex-shrink: 0;
        }
        
        /* Form elements fixes */
        .form-group input,
        .form-group select,
        .form-group textarea,
        .form-group button {
            position: relative;
            z-index: 10;
            pointer-events: all !important;
        }
        
        button[type="submit"],
        button[type="button"],
        .btn-admin {
            position: relative;
            z-index: 100 !important;
            pointer-events: all !important;
            cursor: pointer !important;
        }
        
        button[type="submit"]:hover,
        button[type="button"]:hover,
        .btn-admin:hover {
            transform: translateY(-2px);
        }
        
        /* Fix for URL input button */
        #url-upload button {
            width: auto;
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            z-index: 100;
            pointer-events: all !important;
        }
        
        #url-upload button:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        @media (max-width: 968px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .form-card {
                position: relative;
                top: 0;
                max-height: none;
            }
            
            .suggested-images {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Categories Management</h1>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="categories-grid">
                <!-- Categories List -->
                <div class="content-card">
                    <h2>All Categories (<?php echo count($categories); ?>)</h2>
                    
                    <?php 
                    $parent_cats = array_filter($categories, fn($c) => $c['parent_category_id'] === null);
                    foreach ($parent_cats as $parent): 
                    ?>
                        <div class="category-card">
                            <?php if (!empty($parent['image_url'])): ?>
                                <img src="../<?php echo htmlspecialchars($parent['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($parent['category_name']); ?>"
                                     class="category-thumbnail"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="no-image-placeholder" style="display: none;">
                                    📁
                                </div>
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    📁
                                </div>
                            <?php endif; ?>
                            
                            <div class="category-content">
                                <div class="category-name">
                                    <?php echo htmlspecialchars($parent['category_name']); ?>
                                </div>
                                <div style="color: #7f8c8d; font-size: 0.9rem; margin: 5px 0;">
                                    <?php echo htmlspecialchars($parent['description']); ?>
                                </div>
                                <div class="category-info">
                                    <span style="color: #7f8c8d; font-size: 0.9rem;">
                                        <?php echo $parent['product_count']; ?> products
                                    </span>
                                    <div style="display: flex; gap: 5px; position: relative; z-index: 100;">
                                        <a href="?edit=<?php echo $parent['category_id']; ?>" 
                                           class="btn-admin btn-primary"
                                           onclick="event.stopPropagation();">Edit</a>
                                        <a href="?delete=<?php echo $parent['category_id']; ?>" 
                                           class="btn-admin btn-danger"
                                           onclick="event.stopPropagation(); return confirm('Delete this category?');">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                        $subcats = array_filter($categories, fn($c) => $c['parent_category_id'] === $parent['category_id']);
                        foreach ($subcats as $sub): 
                        ?>
                            <div class="category-card subcategory">
                                <?php if (!empty($sub['image_url'])): ?>
                                    <img src="../<?php echo htmlspecialchars($sub['image_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($sub['category_name']); ?>"
                                         class="category-thumbnail"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="no-image-placeholder" style="display: none;">
                                        📂
                                    </div>
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        📂
                                    </div>
                                <?php endif; ?>
                                
                                <div class="category-content">
                                    <div class="category-name">
                                        └─ <?php echo htmlspecialchars($sub['category_name']); ?>
                                    </div>
                                    <div style="color: #7f8c8d; font-size: 0.9rem; margin: 5px 0;">
                                        <?php echo htmlspecialchars($sub['description']); ?>
                                    </div>
                                    <div class="category-info">
                                        <span style="color: #7f8c8d; font-size: 0.9rem;">
                                            <?php echo $sub['product_count']; ?> products
                                        </span>
                                        <div style="display: flex; gap: 5px; position: relative; z-index: 100;">
                                            <a href="?edit=<?php echo $sub['category_id']; ?>" 
                                               class="btn-admin btn-primary"
                                               onclick="event.stopPropagation();">Edit</a>
                                            <a href="?delete=<?php echo $sub['category_id']; ?>" 
                                               class="btn-admin btn-danger"
                                               onclick="event.stopPropagation(); return confirm('Delete this category?');">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
                
                <!-- Add/Edit Form -->
                <div class="form-card">
                    <h2><?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?></h2>
                    
                    <form method="POST" enctype="multipart/form-data" id="categoryForm">
                        <?php if ($edit_category): ?>
                            <input type="hidden" name="category_id" value="<?php echo $edit_category['category_id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Category Name *</label>
                            <input type="text" name="category_name" required 
                                   value="<?php echo $edit_category ? htmlspecialchars($edit_category['category_name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_category_id">
                                <option value="">None (Main Category)</option>
                                <?php foreach ($parent_categories as $pc): ?>
                                    <option value="<?php echo $pc['category_id']; ?>"
                                        <?php echo ($edit_category && $edit_category['parent_category_id'] == $pc['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($pc['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="3"><?php echo $edit_category ? htmlspecialchars($edit_category['description']) : ''; ?></textarea>
                        </div>
                        
                        <!-- Image Upload Section -->
                        <div class="image-upload-section">
                            <label>Category Image</label>
                            
                            <div class="upload-options">
                                <div class="upload-tab active" onclick="switchUploadTab(event, 'file')">
                                    📁 Upload File
                                </div>
                                <div class="upload-tab" onclick="switchUploadTab(event, 'url')">
                                    🔗 Image URL
                                </div>
                                <div class="upload-tab" onclick="switchUploadTab(event, 'gallery')">
                                    🖼️ Gallery
                                </div>
                            </div>
                            
                            <!-- File Upload -->
                            <div id="file-upload" class="upload-content active">
                                <div class="file-upload-area" id="dropArea">
                                    <div class="upload-icon">📤</div>
                                    <p><strong>Click to upload</strong> or drag and drop</p>
                                    <p style="font-size: 0.85rem; color: #7f8c8d; margin-top: 5px;">
                                        PNG, JPG, GIF, WEBP up to 5MB
                                    </p>
                                    <input type="file" name="category_image" id="fileInput" 
                                           accept="image/*" style="display: none;">
                                </div>
                            </div>
                            
                            <!-- URL Input -->
                            <div id="url-upload" class="upload-content">
                                <input type="text" name="image_url" id="imageUrl" 
                                       placeholder="https://example.com/image.jpg"
                                       value="<?php echo $edit_category ? htmlspecialchars($edit_category['image_url']) : ''; ?>"
                                       style="width: 100%; padding: 12px; border: 1px solid #cbd5e0; border-radius: 6px;">
                                <button type="button" onclick="previewUrl(event)">
                                    Preview Image
                                </button>
                            </div>
                            
                            <!-- Gallery -->
                            <div id="gallery-upload" class="upload-content">
                                <div class="suggested-images">
                                    <div class="suggested-image" onclick="selectGalleryImage(event, 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800&q=80')">
                                        <img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?w=200&q=80" alt="Electronics">
                                    </div>
                                    <div class="suggested-image" onclick="selectGalleryImage(event, 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80')">
                                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=200&q=80" alt="Clothing">
                                    </div>
                                    <div class="suggested-image" onclick="selectGalleryImage(event, 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&q=80')">
                                        <img src="https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=200&q=80" alt="Home & Garden">
                                    </div>
                                    <div class="suggested-image" onclick="selectGalleryImage(event, 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&q=80')">
                                        <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=200&q=80" alt="Sports">
                                    </div>
                                    <div class="suggested-image" onclick="selectGalleryImage(event, 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800&q=80')">
                                        <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=200&q=80" alt="Books">
                                    </div>
                                    <div class="suggested-image" onclick="selectGalleryImage(event, 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80')">
                                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=200&q=80" alt="Groceries">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="image-preview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview">
                                <div class="remove-image" onclick="removeImage(event)">❌ Remove Image</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-admin btn-success" style="width: 100%; margin-bottom: 10px;">
                            <?php echo $edit_category ? 'Update Category' : 'Add Category'; ?>
                        </button>
                        
                        <?php if ($edit_category): ?>
                            <a href="categories.php" class="btn-admin btn-secondary" style="width: 100%; text-align: center; display: block;">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Upload Tab Switching with event parameter
        function switchUploadTab(event, tab) {
            event.preventDefault();
            event.stopPropagation();
            
            document.querySelectorAll('.upload-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.upload-content').forEach(c => c.classList.remove('active'));
            
            event.currentTarget.classList.add('active');
            document.getElementById(tab + '-upload').classList.add('active');
        }
        
        // File Upload
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        
        if (dropArea && fileInput) {
            dropArea.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.add('dragover'), false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.remove('dragover'), false);
            });
            
            dropArea.addEventListener('drop', handleDrop, false);
            fileInput.addEventListener('change', handleFiles, false);
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles();
        }
        
        function handleFiles() {
            const file = fileInput.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showPreview(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }
        
        // URL Preview with event parameter
        function previewUrl(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const url = document.getElementById('imageUrl').value;
            if (url) {
                showPreview(url);
            }
        }
        
        // Gallery Selection with event parameter
        function selectGalleryImage(event, url) {
            event.preventDefault();
            event.stopPropagation();
            
            document.querySelectorAll('.suggested-image').forEach(img => {
                img.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
            document.getElementById('imageUrl').value = url;
            showPreview(url);
        }
        
        // Show Preview
        function showPreview(src) {
            const previewImg = document.getElementById('previewImg');
            const imagePreview = document.getElementById('imagePreview');
            
            if (previewImg && imagePreview) {
                previewImg.src = src;
                imagePreview.style.display = 'block';
            }
        }
        
        // Remove Image with event parameter
        function removeImage(event) {
            event.preventDefault();
            event.stopPropagation();
            
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('previewImg').src = '';
            document.getElementById('fileInput').value = '';
            document.getElementById('imageUrl').value = '';
            document.querySelectorAll('.suggested-image').forEach(img => {
                img.classList.remove('selected');
            });
        }
        
        // Show existing image preview on edit
        <?php if ($edit_category && !empty($edit_category['image_url'])): ?>
        showPreview('../<?php echo htmlspecialchars($edit_category['image_url']); ?>');
        <?php endif; ?>
    </script>
</body>
</html>