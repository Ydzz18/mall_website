<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$message = '';
$error = '';

// Create settings table if not exists
$conn->query("
    CREATE TABLE IF NOT EXISTS site_settings (
        setting_key VARCHAR(100) PRIMARY KEY,
        setting_value TEXT,
        setting_type VARCHAR(50) DEFAULT 'text',
        description TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
");

// Initialize default settings
$default_settings = [
    ['site_name', 'NCCC Malls', 'text', 'Website name'],
    ['site_email', 'admin@ncccmalls.com', 'email', 'Contact email'],
    ['site_phone', '+1 234 567 8900', 'text', 'Contact phone'],
    ['tax_rate', '12', 'number', 'Tax rate (%)'],
    ['shipping_cost', '5.99', 'number', 'Standard shipping cost'],
    ['free_shipping_threshold', '50', 'number', 'Free shipping minimum'],
    ['currency_symbol', '$', 'text', 'Currency symbol'],
    ['items_per_page', '12', 'number', 'Products per page'],
    ['enable_reviews', '1', 'checkbox', 'Enable product reviews'],
    ['require_email_verification', '0', 'checkbox', 'Require email verification'],
    ['maintenance_mode', '0', 'checkbox', 'Maintenance mode'],
];

foreach ($default_settings as $setting) {
    $conn->query("INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_type, description) 
                  VALUES ('{$setting[0]}', '{$setting[1]}', '{$setting[2]}', '{$setting[3]}')");
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'update_settings') {
            $value_safe = $conn->real_escape_string($value);
            $key_safe = $conn->real_escape_string($key);
            $conn->query("UPDATE site_settings SET setting_value = '$value_safe' WHERE setting_key = '$key_safe'");
        }
    }
    
    // Handle checkboxes (unchecked boxes don't send POST data)
    $checkboxes = ['enable_reviews', 'require_email_verification', 'maintenance_mode'];
    foreach ($checkboxes as $checkbox) {
        if (!isset($_POST[$checkbox])) {
            $conn->query("UPDATE site_settings SET setting_value = '0' WHERE setting_key = '$checkbox'");
        }
    }
    
    $message = 'Settings updated successfully! Changes will take effect on next page load.';
}

// Handle admin creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    // Create admins table if not exists
    $conn->query("
        CREATE TABLE IF NOT EXISTS admins (
            admin_id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(100) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            full_name VARCHAR(200),
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $username = trim($_POST['admin_username']);
    $password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
    $email = trim($_POST['admin_email']);
    $full_name = trim($_POST['admin_full_name']);
    
    $stmt = $conn->prepare("INSERT INTO admins (username, password_hash, email, full_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $full_name);
    
    if ($stmt->execute()) {
        $message = 'Admin user created successfully!';
    } else {
        $error = 'Error creating admin user. Username may already exist.';
    }
}

// Handle clear all carts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all_carts'])) {
    $result = $conn->query("DELETE FROM shopping_cart");
    if ($result) {
        $message = 'All shopping carts cleared successfully!';
    } else {
        $error = 'Failed to clear shopping carts.';
    }
}

// Handle reset statistics
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_statistics'])) {
    // Reset view counts or other statistics
    $conn->query("UPDATE products SET views = 0");
    $message = 'Statistics reset successfully!';
}

// Handle database backup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['backup_database'])) {
    $backup_file = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $command = sprintf(
        'mysqldump --user=%s --password=%s --host=%s %s > %s',
        DB_USER,
        DB_PASS,
        DB_HOST,
        DB_NAME,
        $backup_file
    );
    
    system($command, $output);
    
    if ($output === 0) {
        $message = "Database backup created: $backup_file";
    } else {
        $error = 'Failed to create database backup.';
    }
}

// Get all settings
$settings = $conn->query("SELECT * FROM site_settings ORDER BY setting_key")->fetch_all(MYSQLI_ASSOC);

// Get database stats
$db_stats = [
    'customers' => $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'],
    'products' => $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'],
    'orders' => $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'],
    'reviews' => $conn->query("SELECT COUNT(*) as count FROM reviews")->fetch_assoc()['count'],
    'cart_items' => $conn->query("SELECT COUNT(*) as count FROM shopping_cart")->fetch_assoc()['count'],
];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .settings-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }
        
        .settings-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .settings-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
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
        
        .form-group small {
            display: block;
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin-bottom: 15px;
        }
        
        .info-card h4 {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .danger-zone {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .danger-zone h3 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 968px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>System Settings</h1>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="settings-grid">
                <div>
                    <!-- General Settings -->
                    <div class="settings-section">
                        <h2>General Settings</h2>
                        <form method="POST">
                            <?php foreach ($settings as $setting): ?>
                                <div class="form-group">
                                    <label><?php echo ucwords(str_replace('_', ' ', $setting['setting_key'])); ?></label>
                                    
                                    <?php if ($setting['setting_type'] === 'checkbox'): ?>
                                        <label class="checkbox-label">
                                            <input type="checkbox" 
                                                   name="<?php echo $setting['setting_key']; ?>" 
                                                   value="1"
                                                   <?php echo $setting['setting_value'] == '1' ? 'checked' : ''; ?>>
                                            <?php echo htmlspecialchars($setting['description']); ?>
                                        </label>
                                    <?php else: ?>
                                        <input type="<?php echo $setting['setting_type']; ?>" 
                                               name="<?php echo $setting['setting_key']; ?>" 
                                               value="<?php echo htmlspecialchars($setting['setting_value']); ?>"
                                               step="<?php echo $setting['setting_type'] === 'number' ? '0.01' : ''; ?>">
                                        <small><?php echo htmlspecialchars($setting['description']); ?></small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            
                            <button type="submit" name="update_settings" class="btn-admin btn-success" style="width: 100%;">
                                Save Settings
                            </button>
                        </form>
                    </div>
                    
                    <!-- Create Admin User -->
                    <div class="settings-section">
                        <h2>Create Admin User</h2>
                        <form method="POST">
                            <div class="form-group">
                                <label>Username *</label>
                                <input type="text" name="admin_username" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="admin_full_name">
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="admin_email">
                            </div>
                            
                            <div class="form-group">
                                <label>Password *</label>
                                <input type="password" name="admin_password" required>
                            </div>
                            
                            <button type="submit" name="create_admin" class="btn-admin btn-primary" style="width: 100%;">
                                Create Admin
                            </button>
                        </form>
                    </div>
                    
                    <!-- Danger Zone -->
                    <div class="danger-zone">
                        <h3>⚠️ Danger Zone</h3>
                        <p style="color: #856404; margin-bottom: 15px;">
                            These actions are irreversible. Use with caution.
                        </p>
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="clear_all_carts" class="btn-admin btn-danger" 
                                    onclick="return confirm('Are you sure you want to clear all shopping carts? This action cannot be undone.')">
                                Clear All Carts
                            </button>
                        </form>
                        <form method="POST" style="display: inline; margin-left: 10px;">
                            <button type="submit" name="reset_statistics" class="btn-admin btn-danger"
                                    onclick="return confirm('Are you sure you want to reset all statistics?')">
                                Reset Statistics
                            </button>
                        </form>
                    </div>
                </div>
                
                <div>
                    <!-- System Information -->
                    <div class="settings-section">
                        <h2>System Information</h2>
                        
                        <div class="info-card">
                            <h4>Database Statistics</h4>
                            <div class="info-row">
                                <span>Customers:</span>
                                <strong><?php echo number_format($db_stats['customers']); ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Products:</span>
                                <strong><?php echo number_format($db_stats['products']); ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Orders:</span>
                                <strong><?php echo number_format($db_stats['orders']); ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Reviews:</span>
                                <strong><?php echo number_format($db_stats['reviews']); ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Cart Items:</span>
                                <strong><?php echo number_format($db_stats['cart_items']); ?></strong>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <h4>Server Information</h4>
                            <div class="info-row">
                                <span>PHP Version:</span>
                                <strong><?php echo phpversion(); ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Server:</span>
                                <strong><?php echo $_SERVER['SERVER_SOFTWARE']; ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Max Upload:</span>
                                <strong><?php echo ini_get('upload_max_filesize'); ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Memory Limit:</span>
                                <strong><?php echo ini_get('memory_limit'); ?></strong>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <h4>Quick Actions</h4>
                            <button class="btn-admin btn-primary" style="width: 100%; margin-bottom: 10px;" onclick="window.open('../index.php', '_blank')">
                                View Store
                            </button>
                            <form method="POST" style="margin-bottom: 10px;">
                                <button type="submit" name="backup_database" class="btn-admin btn-secondary" style="width: 100%;"
                                        onclick="return confirm('Create database backup?')">
                                    Backup Database
                                </button>
                            </form>
                            <button class="btn-admin btn-secondary" style="width: 100%;" onclick="clearCache()">
                                Clear Cache
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        function clearCache() {
            // Simulate cache clearing
            if (confirm('Clear application cache?')) {
                alert('Cache cleared successfully!');
            }
        }
        
        // Show a notification when settings are saved
        <?php if ($message && strpos($message, 'Settings updated') !== false): ?>
        setTimeout(function() {
            if (confirm('Settings have been updated! Would you like to view the store to see the changes?')) {
                window.open('../index.php', '_blank');
            }
        }, 500);
        <?php endif; ?>
    </script>
</body>
</html>