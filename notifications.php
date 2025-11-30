<?php
require_once 'config.php';
require_once 'includes/notifications.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$message = '';

// Handle mark as read
if (isset($_POST['mark_read'])) {
    $notification_id = intval($_POST['notification_id']);
    if (markNotificationAsRead($notification_id, $customer_id)) {
        $message = 'Notification marked as read';
    }
}

// Handle mark all as read
if (isset($_POST['mark_all_read'])) {
    if (markAllNotificationsAsRead($customer_id)) {
        $message = 'All notifications marked as read';
    }
}

// Get notifications
$notifications = getCustomerNotifications($customer_id, 50);
$unread_count = getUnreadNotificationCount($customer_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .notifications-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .notifications-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .unread-badge {
            background: var(--error);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .notification-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            border-left: 4px solid var(--border);
            display: flex;
            gap: 15px;
            align-items: start;
        }
        
        .notification-card.unread {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%);
            border-left-color: var(--primary);
        }
        
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.15);
        }
        
        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            background: var(--gradient-primary);
            color: white;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .notification-message {
            color: var(--text);
            line-height: 1.6;
            margin-bottom: 10px;
        }
        
        .notification-meta {
            display: flex;
            gap: 15px;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-light);
        }
        
        .notification-time {
            font-weight: 600;
        }
        
        .notification-order {
            background: var(--light);
            padding: 3px 10px;
            border-radius: 5px;
            font-weight: 600;
            color: var(--primary);
        }
        
        .notification-actions {
            display: flex;
            gap: 10px;
            flex-direction: column;
        }
        
        .empty-notifications {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .empty-notifications-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 8px 16px;
            background: white;
            border: 2px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="notifications-container">
        <div class="notifications-header">
            <div>
                <h1>Notifications</h1>
                <?php if ($unread_count > 0): ?>
                    <span class="unread-badge"><?php echo $unread_count; ?> unread</span>
                <?php endif; ?>
            </div>
            
            <?php if ($unread_count > 0): ?>
                <form method="POST">
                    <button type="submit" name="mark_all_read" class="btn btn-secondary">
                        Mark All as Read
                    </button>
                </form>
            <?php endif; ?>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if (count($notifications) > 0): ?>
            <div class="notifications-list">
                <?php foreach ($notifications as $notif): ?>
                    <div class="notification-card <?php echo !$notif['is_read'] ? 'unread' : ''; ?>">
                        <div class="notification-icon">
                            <?php
                            $icons = [
                                'order_status' => '📦',
                                'payment' => '💳',
                                'shipping' => '🚚',
                                'system' => '🔔'
                            ];
                            echo $icons[$notif['type']] ?? '🔔';
                            ?>
                        </div>
                        
                        <div class="notification-content">
                            <div class="notification-title"><?php echo htmlspecialchars($notif['title']); ?></div>
                            <div class="notification-message"><?php echo htmlspecialchars($notif['message']); ?></div>
                            <div class="notification-meta">
                                <span class="notification-time">
                                    <?php 
                                    $time_ago = time() - strtotime($notif['created_at']);
                                    if ($time_ago < 60) echo 'Just now';
                                    elseif ($time_ago < 3600) echo floor($time_ago / 60) . ' minutes ago';
                                    elseif ($time_ago < 86400) echo floor($time_ago / 3600) . ' hours ago';
                                    else echo date('M d, Y h:i A', strtotime($notif['created_at']));
                                    ?>
                                </span>
                                <?php if ($notif['order_number']): ?>
                                    <a href="orders.php?order_id=<?php echo $notif['order_id']; ?>" class="notification-order">
                                        Order #<?php echo htmlspecialchars($notif['order_number']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (!$notif['is_read']): ?>
                            <div class="notification-actions">
                                <form method="POST">
                                    <input type="hidden" name="notification_id" value="<?php echo $notif['notification_id']; ?>">
                                    <button type="submit" name="mark_read" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.85rem;">
                                        ✓ Mark Read
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-notifications">
                <div class="empty-notifications-icon">🔔</div>
                <h2>No notifications yet</h2>
                <p>You'll see updates about your orders here</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>