<?php
require_once 'config.php';

$contact_info = [];
$maintenance_enabled = isMaintenanceModeEnabled();

if (!$maintenance_enabled) {
    header('Location: index.php');
    exit;
}

$conn = getDBConnection();
if ($conn) {
    $contact_result = $conn->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('support_email', 'support_phone', 'support_hours')");
    if ($contact_result) {
        while ($contact_row = $contact_result->fetch_assoc()) {
            $contact_info[$contact_row['setting_key']] = $contact_row['setting_value'];
        }
    }

    $conn->close();
}

if (isset($_SESSION['admin_id'])) {
    header('Location: admin/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <link rel="icon" type="image/png" href="logo/icon.png">
    
    <!-- Add auto-refresh meta tag to check every 30 seconds -->
    <meta http-equiv="refresh" content="30">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .maintenance-container {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            max-width: 700px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .maintenance-icon {
            font-size: 100px;
            margin-bottom: 30px;
            animation: wrench 3s ease-in-out infinite;
        }
        
        @keyframes wrench {
            0%, 10% { transform: rotate(0deg); }
            25%, 35% { transform: rotate(-20deg); }
            50%, 60% { transform: rotate(20deg); }
            75%, 85% { transform: rotate(-10deg); }
            100% { transform: rotate(0deg); }
        }
        
        h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .subtitle {
            font-size: 1.2rem;
            color: #7f8c8d;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin: 30px 0;
        }
        
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 10px;
            animation: progress 2s ease-in-out infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .info-box h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .info-box ul {
            list-style: none;
            padding-left: 0;
        }
        
        .info-box li {
            padding: 10px 0;
            color: #555;
            font-size: 1.05rem;
        }
        
        .info-box li:before {
            content: "✓ ";
            color: #27ae60;
            font-weight: bold;
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .admin-access {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .admin-access h3 {
            color: white;
            margin-bottom: 15px;
        }
        
        .admin-access p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
        }
        
        .admin-btn {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .admin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }
        
        .contact-info {
            background: #e3f2fd;
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
            border: 2px solid #3498db;
        }
        
        .contact-info h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .contact-info p {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #555;
        }
        
        .contact-info a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .contact-info a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .back-soon {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 20px;
            font-size: 1.1rem;
        }
        
        .auto-refresh-notice {
            margin-top: 20px;
            padding: 12px;
            background: #fff3cd;
            border-radius: 8px;
            color: #856404;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .maintenance-container {
                padding: 40px 25px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .maintenance-icon {
                font-size: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>
        <h1>We'll Be Right Back!</h1>
        <p class="subtitle">Our website is currently undergoing scheduled maintenance to bring you an even better shopping experience.</p>
        
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
        
        <div class="info-box">
            <h3>What's happening?</h3>
            <ul>
                <li>System upgrades and improvements</li>
                <li>Performance optimization</li>
                <li>Enhanced security measures</li>
                <li>New features being added</li>
            </ul>
        </div>
        
        <p><strong>We apologize for any inconvenience.</strong><br>Our team is working hard to get things back up and running!</p>
        
        <div class="back-soon">⏰ Back Online Soon</div>
        
        <div class="auto-refresh-notice">
            🔄 This page automatically checks every 30 seconds for when the site is back online
        </div>
        
        <div class="admin-access">
            <h3>👨‍💼 Are you an administrator?</h3>
            <p>Access the admin panel to manage the site and turn off maintenance mode when ready.</p>
            <a href="admin/login.php" class="admin-btn">🔐 Admin Login</a>
        </div>
        
        <div class="contact-info">
            <h3>Need Immediate Assistance?</h3>
            <?php if (!empty($contact_info['support_email'])): ?>
                <p><strong>📧 Email:</strong> <a href="mailto:<?php echo htmlspecialchars($contact_info['support_email']); ?>"><?php echo htmlspecialchars($contact_info['support_email']); ?></a></p>
            <?php endif; ?>
            <?php if (!empty($contact_info['support_phone'])): ?>
                <p><strong>📞 Phone:</strong> <a href="tel:<?php echo htmlspecialchars($contact_info['support_phone']); ?>"><?php echo htmlspecialchars($contact_info['support_phone']); ?></a></p>
            <?php endif; ?>
            <?php if (!empty($contact_info['support_hours'])): ?>
                <p><strong>⏰ Support Hours:</strong> <?php echo htmlspecialchars($contact_info['support_hours']); ?></p>
            <?php endif; ?>
            <?php if (empty($contact_info)): ?>
                <p><strong>📧 Email:</strong> <a href="mailto:support@ncccmalls.com">support@ncccmalls.com</a></p>
                <p><strong>📞 Phone:</strong> <a href="tel:+12345678900">+1 234 567 8900</a></p>
                <p><strong>⏰ Support Hours:</strong> Mon-Fri, 9AM-6PM EST</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>