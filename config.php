<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nccc_malls');

// Connect to database
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['customer_id']);
}

// Get current user
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    $conn = getDBConnection();
    $customer_id = $_SESSION['customer_id'];
    $stmt = $conn->prepare("SELECT customer_id, email, first_name, last_name FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $conn->close();
    return $user;
}

// Global settings cache
$GLOBALS['site_settings_cache'] = null;

// Get site settings
function getSiteSettings() {
    if ($GLOBALS['site_settings_cache'] !== null) {
        return $GLOBALS['site_settings_cache'];
    }
    
    $conn = getDBConnection();
    $result = $conn->query("SELECT setting_key, setting_value FROM site_settings");
    $settings = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    
    $conn->close();
    
    // Cache the settings
    $GLOBALS['site_settings_cache'] = $settings;
    return $settings;
}

// Get specific setting value
function getSetting($key, $default = null) {
    $settings = getSiteSettings();
    return isset($settings[$key]) ? $settings[$key] : $default;
}

// Define site constants from settings (with defaults)
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
    define('ENABLE_REVIEWS', boolval(getSetting('enable_reviews', 1)));
}
if (!defined('MAINTENANCE_MODE')) {
    define('MAINTENANCE_MODE', boolval(getSetting('maintenance_mode', 0)));
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

// Check maintenance mode
if (MAINTENANCE_MODE && !isset($_SESSION['admin_id'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page !== 'maintenance.php') {
        header('Location: maintenance.php');
        exit;
    }
}

// Format currency
function formatCurrency($amount) {
    return CURRENCY_SYMBOL . number_format($amount, 2);
}

// Calculate tax
function calculateTax($subtotal) {
    return $subtotal * TAX_RATE;
}

// Calculate shipping
function calculateShipping($subtotal) {
    return $subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : SHIPPING_COST;
}

// Clear settings cache (call this after updating settings)
function clearSettingsCache() {
    $GLOBALS['site_settings_cache'] = null;
}
?>