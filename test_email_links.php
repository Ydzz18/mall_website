<?php
require_once 'config.php';

// Function to get site base URL
function getSiteBaseUrl() {
    $site_url = getSetting('site_url', '');
    
    if (!empty($site_url)) {
        return rtrim($site_url, '/');
    }
    
    if (isset($_SERVER['HTTP_HOST'])) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }
    
    return 'http://localhost';
}

// Get a sample order for testing
$conn = getDBConnection();
$order = null;
$order_url = '';

if ($conn) {
    $result = $conn->query("SELECT order_id, order_number FROM orders ORDER BY order_id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $site_url = getSiteBaseUrl();
        $order_url = $site_url . "/order_tracking.php?order_id=" . $order['order_id'];
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Link Tester - <?php echo SITE_NAME; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2rem;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1rem;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #7c3aed;
        }
        
        .info-box h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .label {
            font-weight: 600;
            color: #666;
        }
        
        .value {
            color: #2c3e50;
            font-family: monospace;
            background: white;
            padding: 4px 8px;
            border-radius: 4px;
        }
        
        .url-display {
            background: #2c3e50;
            color: #06d6a0;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            word-break: break-all;
            margin: 20px 0;
            font-size: 0.9rem;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: #7c3aed;
            color: white;
        }
        
        .btn-primary:hover {
            background: #6d28d9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
        }
        
        .btn-secondary {
            background: #06d6a0;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #05b589;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(6, 214, 160, 0.4);
        }
        
        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
        }
        
        .note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .note strong {
            color: #856404;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔗 Email Link Tester</h1>
        <p class="subtitle">Test your order tracking email links</p>
        
        <?php if ($order): ?>
            <div class="info-box">
                <h2>📊 System Information</h2>
                <div class="info-row">
                    <span class="label">Site Base URL:</span>
                    <span class="value"><?php echo htmlspecialchars(getSiteBaseUrl()); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Latest Order ID:</span>
                    <span class="value"><?php echo $order['order_id']; ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Order Number:</span>
                    <span class="value"><?php echo htmlspecialchars($order['order_number']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Link Status:</span>
                    <span class="status success">✓ Generated Successfully</span>
                </div>
            </div>
            
            <div class="info-box">
                <h2>🔗 Generated Order Tracking URL</h2>
                <div class="url-display"><?php echo htmlspecialchars($order_url); ?></div>
                
                <div class="button-group">
                    <a href="<?php echo htmlspecialchars($order_url); ?>" class="btn btn-primary" target="_blank">
                        🚀 Open Tracking Page
                    </a>
                    <button class="btn btn-secondary" onclick="copyToClipboard('<?php echo htmlspecialchars($order_url, ENT_QUOTES); ?>')">
                        📋 Copy URL
                    </button>
                </div>
            </div>
            
            <div class="note">
                <strong>📝 Note:</strong> If the link doesn't work, check:
                <ul style="margin: 10px 0 0 20px;">
                    <li>Make sure the site_url is set correctly in your database settings</li>
                    <li>Verify that order_tracking.php file exists and has proper permissions</li>
                    <li>Check if there are any .htaccess rules blocking access</li>
                    <li>Ensure the order ID <?php echo $order['order_id']; ?> exists in the database</li>
                </ul>
            </div>
            
        <?php else: ?>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span class="status error">✗ No Orders Found</span>
                </div>
            </div>
            
            <div class="note">
                <strong>⚠️ Warning:</strong> No orders found in the database. Create a test order first to test the email links.
            </div>
        <?php endif; ?>
        
        <div class="info-box" style="margin-top: 30px;">
            <h2>⚙️ Configuration Check</h2>
            <div class="info-row">
                <span class="label">Site Name:</span>
                <span class="value"><?php echo htmlspecialchars(SITE_NAME); ?></span>
            </div>
            <div class="info-row">
                <span class="label">Site Email:</span>
                <span class="value"><?php echo htmlspecialchars(SITE_EMAIL); ?></span>
            </div>
            <div class="info-row">
                <span class="label">Gmail Sender:</span>
                <span class="value"><?php echo htmlspecialchars(GMAIL_SENDER_EMAIL); ?></span>
            </div>
            <div class="info-row">
                <span class="label">Email Notifications:</span>
                <span class="status <?php echo ENABLE_EMAIL_NOTIFICATIONS ? 'success' : 'error'; ?>">
                    <?php echo ENABLE_EMAIL_NOTIFICATIONS ? '✓ Enabled' : '✗ Disabled'; ?>
                </span>
            </div>
        </div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('URL copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
                prompt('Copy this URL:', text);
            });
        }
    </script>
</body>
</html>