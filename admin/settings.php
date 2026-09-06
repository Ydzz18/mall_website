<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_SETTINGS)) {
    header('Location: index.php');
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
    ['admin_sidebar_auto_hide', '0', 'checkbox', 'Auto-hide admin sidebar'],
    
    // Gmail SMTP Settings
    ['gmail_sender_email', '', 'email', 'Gmail sender email address'],
    ['gmail_sender_password', '', 'password', 'Gmail app password (16 characters)'],
    ['gmail_sender_name', 'NCCC Malls', 'text', 'Email sender name'],
    
    // Email Notification Settings
    ['enable_email_notifications', '1', 'checkbox', 'Enable email notifications'],
    ['enable_order_emails', '1', 'checkbox', 'Send order confirmation emails'],
    ['enable_shipping_emails', '1', 'checkbox', 'Send shipping notification emails'],
    ['enable_payment_emails', '1', 'checkbox', 'Send payment confirmation emails'],
];

foreach ($default_settings as $setting) {
    $conn->query("INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_type, description) 
                  VALUES ('{$setting[0]}', '{$setting[1]}', '{$setting[2]}', '{$setting[3]}')");
}

// Handle maintenance mode toggle - MUST BE BEFORE ANY OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_maintenance_mode'])) {
    clearSettingsCache();
    
    $result = $conn->query("SELECT setting_value FROM site_settings WHERE setting_key = 'maintenance_mode'");
    $current_value = $result->fetch_assoc()['setting_value'];
    
    $new_value = ($current_value === '1') ? '0' : '1';
    $old_value = $current_value;
    
    $conn->query("UPDATE site_settings SET setting_value = '$new_value' WHERE setting_key = 'maintenance_mode'");
    
    // Create or delete maintenance flag file (in nccc directory)
    $flag_file = dirname(__DIR__) . '/maintenance.flag';
    if ($new_value === '1') {
        // Create flag file when enabling maintenance mode
        file_put_contents($flag_file, 'Maintenance mode enabled at ' . date('Y-m-d H:i:s'));
    } else {
        // Delete flag file when disabling maintenance mode
        if (file_exists($flag_file)) {
            unlink($flag_file);
        }
    }
    
    logAdminActivity(
        $_SESSION['admin_id'],
        'maintenance_mode_toggle',
        "Maintenance mode " . ($new_value === '1' ? 'enabled' : 'disabled'),
        'site_settings',
        null,
        null,
        ['maintenance_mode' => $old_value],
        ['maintenance_mode' => $new_value]
    );
    
    clearSettingsCache();
    
    $message = $new_value === '1' 
        ? '🔒 Maintenance mode enabled. Your site is now offline for customers.' 
        : '✅ Maintenance mode disabled. Your site is now live and accessible to customers!';
    
    $conn->close();
    header("Location: settings.php?message=" . urlencode($message));
    exit;
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $updated_settings = [];
    
    foreach ($_POST as $key => $value) {
        if ($key !== 'update_settings') {
            $value_safe = $conn->real_escape_string($value);
            $key_safe = $conn->real_escape_string($key);
            
            $stmt = $conn->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $old_setting = $stmt->get_result()->fetch_assoc();
            
            $conn->query("UPDATE site_settings SET setting_value = '$value_safe' WHERE setting_key = '$key_safe'");
            $updated_settings[] = [
                'key' => $key,
                'old' => $old_setting['setting_value'],
                'new' => $value
            ];
        }
    }
    
    // Handle checkboxes (unchecked boxes don't send POST data)
    $checkboxes = ['enable_reviews', 'require_email_verification', 'maintenance_mode', 'admin_sidebar_auto_hide',
                   'enable_email_notifications', 'enable_order_emails', 'enable_shipping_emails', 'enable_payment_emails'];
    foreach ($checkboxes as $checkbox) {
        if (!isset($_POST[$checkbox])) {
            $stmt = $conn->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
            $stmt->bind_param("s", $checkbox);
            $stmt->execute();
            $old_setting = $stmt->get_result()->fetch_assoc();
            
            $conn->query("UPDATE site_settings SET setting_value = '0' WHERE setting_key = '$checkbox'");
            $updated_settings[] = [
                'key' => $checkbox,
                'old' => $old_setting['setting_value'],
                'new' => '0'
            ];
        }
    }
    
    // Log settings update
    $settings_summary = implode(', ', array_map(function($s) { 
        return $s['key'] . ': ' . $s['old'] . ' → ' . $s['new']; 
    }, $updated_settings));
    
    logAdminActivity(
        $_SESSION['admin_id'],
        'settings_update',
        "Site settings updated: " . (count($updated_settings) > 0 ? substr($settings_summary, 0, 100) . '...' : 'No changes'),
        'site_settings',
        null,
        null,
        ['total_updates' => count($updated_settings)]
    );
    
    // Clear settings cache
    clearSettingsCache();
    
    $message = 'Settings updated successfully! Changes will take effect on next page load.';
}

// Check for message in URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

// Handle test email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_test_email'])) {
    $test_email = trim($_POST['test_email']);
    
    if (filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
        require_once '../includes/email.php';
        
        try {
            $mail = getMailer();
            if ($mail) {
                $mail->addAddress($test_email);
                $mail->Subject = 'Test Email from ' . SITE_NAME;
                $mail->Body = "
                <html>
                <body style='font-family: Arial, sans-serif; padding: 20px;'>
                    <h2>🎉 Email Configuration Test</h2>
                    <p>Congratulations! Your Gmail SMTP configuration is working correctly.</p>
                    <p><strong>Configuration Details:</strong></p>
                    <ul>
                        <li>SMTP Host: " . GMAIL_SMTP_HOST . "</li>
                        <li>SMTP Port: " . GMAIL_SMTP_PORT . "</li>
                        <li>Sender Email: " . GMAIL_SENDER_EMAIL . "</li>
                    </ul>
                    <p>This means your e-commerce site can now send:</p>
                    <ul>
                        <li>✅ Order confirmations</li>
                        <li>✅ Shipping notifications</li>
                        <li>✅ Payment confirmations</li>
                        <li>✅ Account welcome emails</li>
                    </ul>
                    <p style='margin-top: 30px; color: #666; font-size: 12px;'>
                        Sent from " . SITE_NAME . " at " . date('Y-m-d H:i:s') . "
                    </p>
                </body>
                </html>
                ";
                $mail->AltBody = 'Test email from ' . SITE_NAME . '. Your Gmail SMTP is configured correctly!';
                
                if ($mail->send()) {
                    $message = "✅ Test email sent successfully to $test_email! Check your inbox.";
                } else {
                    $error = "Failed to send test email. Please check your Gmail configuration.";
                }
            } else {
                $error = "Failed to initialize email mailer. Please check your Gmail app password.";
            }
        } catch (Exception $e) {
            $error = "Email error: " . $e->getMessage();
        }
    } else {
        $error = "Please enter a valid email address.";
    }
}

// Handle admin creation - FIXED TO USE admin_users TABLE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $username = trim($_POST['admin_username']);
    $password = $_POST['admin_password'];
    $email = trim($_POST['admin_email']);
    $full_name = trim($_POST['admin_full_name']);
    $role = isset($_POST['admin_role']) ? $_POST['admin_role'] : 'admin';
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        // Check if username already exists
        $check_stmt = $conn->prepare("SELECT admin_id FROM admin_users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $existing = $check_stmt->get_result();
        
        if ($existing->num_rows > 0) {
            $error = 'Username or email already exists.';
        } else {
            // Hash password and insert into admin_users table
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash, email, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("sssss", $username, $password_hash, $email, $full_name, $role);
            
            if ($stmt->execute()) {
                $new_admin_id = $conn->insert_id;
                
                // Log admin creation
                logAdminActivity(
                    $_SESSION['admin_id'],
                    'admin_create',
                    "New admin user created: $username ($full_name)",
                    'admin_users',
                    $new_admin_id,
                    null,
                    ['username' => $username, 'email' => $email, 'role' => $role]
                );
                
                $message = "✅ Admin user '$username' created successfully! They can now login with their credentials.";
            } else {
                $error = 'Error creating admin user: ' . $conn->error;
            }
        }
    }
}

// Handle clear all carts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all_carts'])) {
    $result = $conn->query("DELETE FROM shopping_cart");
    if ($result) {
        logAdminActivity(
            $_SESSION['admin_id'],
            'carts_clear',
            "All shopping carts cleared",
            'shopping_cart',
            null
        );
        $message = 'All shopping carts cleared successfully!';
    } else {
        $error = 'Failed to clear shopping carts.';
    }
}

// Handle reset statistics
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_statistics'])) {
    $conn->query("UPDATE products SET views = 0");
    
    logAdminActivity(
        $_SESSION['admin_id'],
        'statistics_reset',
        "Product view statistics reset",
        'products',
        null
    );
    
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

// Get fresh maintenance mode value for display
clearSettingsCache();
$fresh_maintenance = getSetting('maintenance_mode', '0');
$is_maintenance_on = ($fresh_maintenance === '1' || $fresh_maintenance === 1);

// Get all settings grouped
$settings = $conn->query("SELECT * FROM site_settings ORDER BY setting_key")->fetch_all(MYSQLI_ASSOC);

// Group settings
$general_settings = [];
$gmail_settings = [];
$email_notification_settings = [];

foreach ($settings as $setting) {
    if (strpos($setting['setting_key'], 'gmail_') === 0) {
        $gmail_settings[] = $setting;
    } elseif (strpos($setting['setting_key'], 'enable_') === 0 && strpos($setting['setting_key'], 'email') !== false) {
        $email_notification_settings[] = $setting;
    } else {
        $general_settings[] = $setting;
    }
}

// Get database stats
$db_stats = [
    'customers' => $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'],
    'products' => $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'],
    'orders' => $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'],
    'reviews' => $conn->query("SELECT COUNT(*) as count FROM reviews")->fetch_assoc()['count'],
    'cart_items' => $conn->query("SELECT COUNT(*) as count FROM shopping_cart")->fetch_assoc()['count'],
    'admin_users' => $conn->query("SELECT COUNT(*) as count FROM admin_users")->fetch_assoc()['count'],
];

// Get list of existing admin users
$admin_users_result = $conn->query("SELECT admin_id, username, email, full_name, role, is_active, created_at, last_login FROM admin_users ORDER BY created_at DESC");
$admin_users = $admin_users_result->fetch_all(MYSQLI_ASSOC);

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
        
        .settings-section h3 {
            color: #7c3aed;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 1.1rem;
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
        .form-group input[type="password"],
        .form-group select {
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
        }
        
        .gmail-setup-box a {
            color: #ffd700;
            text-decoration: underline;
        }
        
        .test-email-form {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .admin-users-list {
            margin-top: 20px;
        }
        
        .admin-user-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #3498db;
        }
        
        .admin-user-card.inactive {
            opacity: 0.6;
            border-left-color: #95a5a6;
        }
        
        .admin-user-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .admin-user-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .admin-user-role {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .role-super_admin {
            background: #e74c3c;
            color: white;
        }
        
        .role-admin {
            background: #3498db;
            color: white;
        }
        
        .role-moderator {
            background: #95a5a6;
            color: white;
        }
        
        .admin-user-details {
            font-size: 0.85rem;
            color: #7f8c8d;
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
            
            <?php if ($is_maintenance_on): ?>
                <div class="alert" style="background: #fef3c7; border: 2px solid #f59e0b; color: #92400e; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="font-size: 2rem;">⚠️</div>
                        <div style="flex: 1;">
                            <h3 style="margin: 0 0 10px 0; color: #92400e;">MAINTENANCE MODE IS CURRENTLY ACTIVE</h3>
                            <p style="margin: 0;">Your website is currently in maintenance mode. Regular customers cannot access the site. Only administrators can view and manage the system.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Maintenance Mode Quick Toggle Card -->
            <div class="settings-section" style="border-left: 4px solid <?php echo $is_maintenance_on ? '#f59e0b' : '#16a34a'; ?>;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <div style="flex: 1;">
                        <h2 style="margin: 0 0 10px 0; color: #1e293b;">
                            <?php if ($is_maintenance_on): ?>
                                🔒 Site is Under Maintenance
                            <?php else: ?>
                                ✅ Site is Online
                            <?php endif; ?>
                        </h2>
                        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
                            <?php if ($is_maintenance_on): ?>
                                Your store is currently offline for maintenance. Customers will see a maintenance page.
                            <?php else: ?>
                                Your store is live and customers can browse and make purchases.
                            <?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <form method="POST" style="display: inline;" onsubmit="return confirm('<?php echo $is_maintenance_on ? 'Turn OFF maintenance mode and make the site public?' : 'Turn ON maintenance mode? This will prevent customers from accessing your site.'; ?>')">
                            <input type="hidden" name="toggle_maintenance_mode" value="1">
                            <?php if ($is_maintenance_on): ?>
                                <button type="submit" class="btn-admin btn-success" style="font-size: 1rem; padding: 12px 30px;">
                                    🟢 Turn Site Online
                                </button>
                            <?php else: ?>
                                <button type="submit" class="btn-admin btn-danger" style="font-size: 1rem; padding: 12px 30px;">
                                    🔒 Enable Maintenance Mode
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="settings-grid">
                <div>
                    <!-- General Settings -->
                    <div class="settings-section">
                        <h2>⚙️ General Settings</h2>
                        <form method="POST">
                            <?php foreach ($general_settings as $setting): ?>
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
                            
                            <h3>📧 Gmail SMTP Configuration</h3>
                            <div class="gmail-setup-box">
                                <h3>📋 Setup Instructions</h3>
                                <ol style="line-height: 1.8;">
                                    <li>Enable 2-Factor Authentication on your Gmail account</li>
                                    <li>Generate an App Password at <a href="https://myaccount.google.com/apppasswords" target="_blank">myaccount.google.com/apppasswords</a></li>
                                    <li>Copy the 16-character password (no spaces)</li>
                                    <li>Paste it in the "Gmail App Password" field below</li>
                                </ol>
                                <small>⚠️ Never use your regular Gmail password - use App Password only!</small>
                            </div>
                            
                            <?php foreach ($gmail_settings as $setting): ?>
                                <div class="form-group">
                                    <label><?php echo ucwords(str_replace(['gmail_', '_'], ['', ' '], $setting['setting_key'])); ?></label>
                                    <input type="<?php echo $setting['setting_type']; ?>" 
                                           name="<?php echo $setting['setting_key']; ?>" 
                                           value="<?php echo htmlspecialchars($setting['setting_value']); ?>"
                                           placeholder="<?php echo $setting['setting_key'] === 'gmail_sender_email' ? 'your-email@gmail.com' : ''; ?>">
                                    <small><?php echo htmlspecialchars($setting['description']); ?></small>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="test-email-form">
                                <h4>🧪 Test Email Configuration</h4>
                                <p style="font-size: 0.9rem; margin-bottom: 10px;">Send a test email to verify your Gmail SMTP setup:</p>
                                <div style="display: flex; gap: 10px;">
                                    <input type="email" name="test_email" placeholder="test@example.com" style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                                    <button type="submit" name="send_test_email" class="btn-admin btn-primary">Send Test</button>
                                </div>
                            </div>
                            
                            <h3>📨 Email Notification Settings</h3>
                            <?php foreach ($email_notification_settings as $setting): ?>
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" 
                                               name="<?php echo $setting['setting_key']; ?>" 
                                               value="1"
                                               <?php echo $setting['setting_value'] == '1' ? 'checked' : ''; ?>>
                                        <?php echo htmlspecialchars($setting['description']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            
                            <button type="submit" name="update_settings" class="btn-admin btn-success" style="width: 100%;">
                                💾 Save All Settings
                            </button>
                        </form>
                    </div>
                    
                    <!-- Create Admin User -->
                    <div class="settings-section">
                        <h2>👤 Create Admin User</h2>
                        <form method="POST">
                            <div class="form-group">
                                <label>Username *</label>
                                <input type="text" name="admin_username" required placeholder="Enter username">
                            </div>
                            
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="admin_full_name" placeholder="Enter full name">
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="admin_email" placeholder="Enter email address">
                            </div>
                            
                            <div class="form-group">
                                <label>Password *</label>
                                <input type="password" name="admin_password" required placeholder="Enter password" minlength="6">
                                <small>Minimum 6 characters</small>
                            </div>
                            
                            <div class="form-group">
                                <label>Role *</label>
                                <select name="admin_role" required>
                                    <option value="admin">Admin</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="super_admin">Super Admin</option>
                                </select>
                                <small>Super Admin has full access, Admin has most features, Moderator has limited access</small>
                            </div>
                            
                            <button type="submit" name="create_admin" class="btn-admin btn-primary" style="width: 100%;">
                                ➕ Create Admin User
                            </button>
                        </form>
                        
                        <!-- Existing Admin Users -->
                        <?php if (count($admin_users) > 0): ?>
                        <div class="admin-users-list">
                            <h3>📋 Existing Admin Users (<?php echo count($admin_users); ?>)</h3>
                            <?php foreach ($admin_users as $admin): ?>
                            <div class="admin-user-card <?php echo $admin['is_active'] ? '' : 'inactive'; ?>">
                                <div class="admin-user-header">
                                    <div class="admin-user-name">
                                        <?php echo htmlspecialchars($admin['full_name'] ?: $admin['username']); ?>
                                        <?php if (!$admin['is_active']): ?>
                                            <span style="color: #e74c3c; font-size: 0.85rem;"> (Inactive)</span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="admin-user-role role-<?php echo $admin['role']; ?>">
                                        <?php echo strtoupper(str_replace('_', ' ', $admin['role'])); ?>
                                    </span>
                                </div>
                                <div class="admin-user-details">
                                    <div>👤 Username: <strong><?php echo htmlspecialchars($admin['username']); ?></strong></div>
                                    <?php if ($admin['email']): ?>
                                    <div>📧 Email: <?php echo htmlspecialchars($admin['email']); ?></div>
                                    <?php endif; ?>
                                    <div>📅 Created: <?php echo date('M d, Y', strtotime($admin['created_at'])); ?></div>
                                    <?php if ($admin['last_login']): ?>
                                    <div>🕐 Last Login: <?php echo date('M d, Y g:i A', strtotime($admin['last_login'])); ?></div>
                                    <?php else: ?>
                                    <div>🕐 Last Login: <em>Never logged in</em></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
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
                                🛒 Clear All Carts
                            </button>
                        </form>
                        <form method="POST" style="display: inline; margin-left: 10px;">
                            <button type="submit" name="reset_statistics" class="btn-admin btn-danger"
                                    onclick="return confirm('Are you sure you want to reset all statistics?')">
                                📊 Reset Statistics
                            </button>
                        </form>
                    </div>
                </div>
                
                <div>
                    <!-- System Information -->
                    <div class="settings-section">
                        <h2>📊 System Information</h2>
                        
                        <div class="info-card">
                            <h4>Database Statistics</h4>
                            <div class="info-row">
                                <span>👥 Admin Users:</span>
                                <strong><?php echo number_format($db_stats['admin_users']); ?></strong>
                            </div>
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
                        
                        <div class="info-card" style="border-left-color: #7c3aed;">
                            <h4>📧 Email Configuration Status</h4>
                            <div class="info-row">
                                <span>SMTP Host:</span>
                                <strong><?php echo GMAIL_SMTP_HOST; ?></strong>
                            </div>
                            <div class="info-row">
                                <span>SMTP Port:</span>
                                <strong><?php echo GMAIL_SMTP_PORT; ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Sender Email:</span>
                                <strong style="font-size: 0.8rem;"><?php echo GMAIL_SENDER_EMAIL; ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Status:</span>
                                <strong style="color: <?php echo GMAIL_SENDER_EMAIL !== 'your-email@gmail.com' ? '#27ae60' : '#e74c3c'; ?>;">
                                    <?php echo GMAIL_SENDER_EMAIL !== 'your-email@gmail.com' ? '✅ Configured' : '⚠️ Not Configured'; ?>
                                </strong>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <h4>Quick Actions</h4>
                            <button class="btn-admin btn-primary" style="width: 100%; margin-bottom: 10px;" onclick="window.open('../index.php', '_blank')">
                                🏪 View Store
                            </button>
                            <form method="POST" style="margin-bottom: 10px;">
                                <button type="submit" name="backup_database" class="btn-admin btn-secondary" style="width: 100%;"
                                        onclick="return confirm('Create database backup?')">
                                    💾 Backup Database
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
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