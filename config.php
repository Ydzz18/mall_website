<?php
// Set timezone to Philippine Standard Time (GMT+8)
date_default_timezone_set('Asia/Manila');

// Include rating functions
require_once __DIR__ . '/includes/rating_functions.php';

// Set UTF-8 header at the very beginning
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================================
// SIMPLE MAINTENANCE CHECK - MUST BE AT THE VERY TOP
// ============================================================================

// Get the current script filename
$current_file = basename($_SERVER['PHP_SELF']);

// Files that should NEVER redirect (whitelist)
$allowed_files = ['maintenance.php', 'logout.php'];

// Only check maintenance if we're NOT on an allowed file
if (!in_array($current_file, $allowed_files)) {
    // Check if we're in admin directory
    $is_in_admin = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false);
    
    // Simple maintenance mode check - WITHOUT loading database yet
    if (file_exists(__DIR__ . '/maintenance.flag')) {
        // Only redirect if:
        // 1. User is NOT an admin
        // 2. User is NOT already in admin area
        if (!isset($_SESSION['admin_id']) && !$is_in_admin) {
            header('Location: /maintenance.php');
            exit;
        }
    }
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'malls');

// Connect to database
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        if (basename($_SERVER['PHP_SELF']) !== 'maintenance.php') {
            error_log("Database connection failed: " . $conn->connect_error);
        }
        return null;
    }
    $conn->set_charset("utf8mb4");
    $conn->query("SET time_zone = '+08:00'");
    return $conn;
}

require_once __DIR__ . '/includes/ActivityLogger.php';
require_once __DIR__ . '/includes/RoleManager.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['customer_id']);
}

function getSiteRelativePrefix() {
    $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    $script_dir = dirname($script_name);

    if (stripos($script_dir, '/rider') !== false || stripos($script_dir, '/admin') !== false) {
        return '../';
    }

    return '';
}

// Check if admin is logged in - SIMPLIFIED VERSION
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Check if rider is logged in
function isRiderLoggedIn() {
    return isset($_SESSION['rider_id']);
}

// Get current admin's role
function getAdminRole() {
    if (!isAdminLoggedIn()) return null;
    return $_SESSION['admin_role'] ?? 'admin';
}

// Check if current admin has permission
function hasAdminPermission($permission) {
    $role = getAdminRole();
    if (!$role) return false;
    return RoleManager::hasPermission($role, $permission);
}

// Check if current admin has permission to create a role
function canCreateAdminRole($targetRole) {
    $currentRole = getAdminRole();
    if (!$currentRole) return false;
    return RoleManager::canCreateRole($currentRole, $targetRole);
}

// Get current user
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    $conn = getDBConnection();
    if (!$conn) return null;
    
    $customer_id = $_SESSION['customer_id'];
    $stmt = $conn->prepare("SELECT customer_id, email, first_name, last_name FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $conn->close();
    return $user;
}

// Get current rider
function getCurrentRider() {
    if (!isRiderLoggedIn()) return null;
    
    $conn = getDBConnection();
    if (!$conn) return null;
    
    $rider_id = $_SESSION['rider_id'];
    $stmt = $conn->prepare("SELECT rider_id, email, first_name, last_name, vehicle_type, vehicle_plate, status, rating FROM riders WHERE rider_id = ?");
    $stmt->bind_param("i", $rider_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rider = $result->fetch_assoc();
    $conn->close();
    return $rider;
}

// Global settings cache
$GLOBALS['site_settings_cache'] = null;

// Get site settings
function getSiteSettings() {
    if ($GLOBALS['site_settings_cache'] !== null) {
        return $GLOBALS['site_settings_cache'];
    }
    
    $conn = getDBConnection();
    if (!$conn) {
        return [];
    }
    
    $settings = [];
    try {
        $result = $conn->query("SELECT setting_key, setting_value FROM site_settings");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
    } catch (mysqli_sql_exception $e) {
        error_log('getSiteSettings database error: ' . $e->getMessage());
    }
    
    $conn->close();
    $GLOBALS['site_settings_cache'] = $settings;
    return $settings;
}

// Get specific setting value
function getSetting($key, $default = null) {
    $settings = getSiteSettings();
    return isset($settings[$key]) ? $settings[$key] : $default;
}

// Define site constants from settings
if (!defined('SITE_NAME')) {
    define('SITE_NAME', getSetting('site_name', 'NCCC Malls'));
}
if (!defined('SITE_EMAIL')) {
    define('SITE_EMAIL', getSetting('site_email', 'admin@ncccmalls.com'));
}
if (!defined('SITE_PHONE')) {
    define('SITE_PHONE', getSetting('site_phone', '+1 234 567 8900'));
}
if (!defined('TAX_RATE')) {
    define('TAX_RATE', floatval(getSetting('tax_rate', 12)) / 100);
}
if (!defined('SHIPPING_COST')) {
    define('SHIPPING_COST', floatval(getSetting('shipping_cost', 5.99)));
}
if (!defined('FREE_SHIPPING_THRESHOLD')) {
    define('FREE_SHIPPING_THRESHOLD', floatval(getSetting('free_shipping_threshold', 50)));
}
if (!defined('CURRENCY_SYMBOL')) {
    define('CURRENCY_SYMBOL', getSetting('currency_symbol', '$'));
}
if (!defined('ITEMS_PER_PAGE')) {
    define('ITEMS_PER_PAGE', intval(getSetting('items_per_page', 12)));
}
if (!defined('ENABLE_REVIEWS')) {
    define('ENABLE_REVIEWS', getSetting('enable_reviews', 1) === '1' || getSetting('enable_reviews', 1) === 1);
}
if (!defined('MAINTENANCE_MODE')) {
    define('MAINTENANCE_MODE', getSetting('maintenance_mode', 0) === '1' || getSetting('maintenance_mode', 0) === 1);
}

function isMaintenanceModeEnabled() {
    $flag_exists = file_exists(__DIR__ . '/maintenance.flag');
    $db_enabled = getSetting('maintenance_mode', '0') === '1' || getSetting('maintenance_mode', '0') === 1;
    return $flag_exists || $db_enabled;
}

// Gmail SMTP Configuration
if (!defined('GMAIL_SMTP_HOST')) {
    define('GMAIL_SMTP_HOST', 'smtp.gmail.com');
}
if (!defined('GMAIL_SMTP_PORT')) {
    define('GMAIL_SMTP_PORT', 587);
}
if (!defined('GMAIL_SENDER_EMAIL')) {
    define('GMAIL_SENDER_EMAIL', getSetting('gmail_sender_email', 'your-email@gmail.com'));
}
if (!defined('GMAIL_SENDER_PASSWORD')) {
    define('GMAIL_SENDER_PASSWORD', getSetting('gmail_sender_password', 'your-app-password'));
}
if (!defined('GMAIL_SENDER_NAME')) {
    define('GMAIL_SENDER_NAME', getSetting('gmail_sender_name', SITE_NAME));
}

// Email notification settings
if (!defined('ENABLE_EMAIL_NOTIFICATIONS')) {
    define('ENABLE_EMAIL_NOTIFICATIONS', boolval(getSetting('enable_email_notifications', 1)));
}
if (!defined('ENABLE_ORDER_EMAILS')) {
    define('ENABLE_ORDER_EMAILS', boolval(getSetting('enable_order_emails', 1)));
}
if (!defined('ENABLE_SHIPPING_EMAILS')) {
    define('ENABLE_SHIPPING_EMAILS', boolval(getSetting('enable_shipping_emails', 1)));
}
if (!defined('ENABLE_PAYMENT_EMAILS')) {
    define('ENABLE_PAYMENT_EMAILS', boolval(getSetting('enable_payment_emails', 1)));
}

// ============================================================================
// SECONDARY MAINTENANCE CHECK (using database if available)
// ============================================================================
function checkMaintenanceMode() {
    // Get current file
    $current_file = basename($_SERVER['PHP_SELF']);
    $allowed_files = ['maintenance.php', 'logout.php'];
    
    // Never redirect if already on allowed pages
    if (in_array($current_file, $allowed_files)) {
        return false;
    }
    
    // Check if in admin area
    $is_in_admin = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false);
    
    // Admins bypass maintenance mode
    if (isset($_SESSION['admin_id'])) {
        return false;
    }

    $maintenance = isMaintenanceModeEnabled();
    if ($maintenance && !$is_in_admin) {
        header('Location: /maintenance.php');
        exit;
    }

    return $maintenance;
}

// Call the maintenance check function
checkMaintenanceMode();

// Format currency
function formatCurrency($amount) {
    $symbol = CURRENCY_SYMBOL;
    
    if (empty($symbol) || $symbol === '$') {
        $symbol = getSetting('currency_symbol', '₱');
    }
    
    if (strpos($symbol, '₱') === false && strpos($symbol, 'P') === false) {
        $symbol = '₱';
    }
    
    return $symbol . number_format($amount, 2);
}

// Calculate tax
function calculateTax($subtotal) {
    return $subtotal * TAX_RATE;
}

// Calculate shipping
function calculateShipping($subtotal) {
    return $subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : SHIPPING_COST;
}

// Clear settings cache
function clearSettingsCache() {
    $GLOBALS['site_settings_cache'] = null;
}
?>