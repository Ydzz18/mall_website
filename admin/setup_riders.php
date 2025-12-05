<?php
require_once '../config.php';

if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_RIDERS)) {
    header('Location: index.php');
    exit;
}

$migration_done = false;
$migration_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['run_migration'])) {
    $conn = getDBConnection();
    
    if ($conn) {
        $sql_queries = [
            "CREATE TABLE IF NOT EXISTS `riders` (
              `rider_id` int(11) NOT NULL AUTO_INCREMENT,
              `first_name` varchar(100) NOT NULL,
              `last_name` varchar(100) NOT NULL,
              `email` varchar(100) NOT NULL,
              `phone` varchar(20) NOT NULL,
              `password_hash` varchar(255) NOT NULL,
              `vehicle_type` enum('motorcycle','bicycle','car','truck') NOT NULL,
              `vehicle_plate` varchar(20),
              `status` enum('active','inactive','suspended') DEFAULT 'active',
              `is_verified` tinyint(1) DEFAULT 0,
              `rating` decimal(3,2) DEFAULT 0.00,
              `total_deliveries` int(11) DEFAULT 0,
              `completed_deliveries` int(11) DEFAULT 0,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
              PRIMARY KEY (`rider_id`),
              UNIQUE KEY `unique_email` (`email`),
              KEY `status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
            
            "CREATE TABLE IF NOT EXISTS `delivery_assignments` (
              `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
              `order_id` int(11) NOT NULL,
              `rider_id` int(11),
              `delivery_status` enum('pending_assignment','assigned','picked_up','in_transit','delivered','failed','returned') DEFAULT 'pending_assignment',
              `assigned_at` timestamp NULL,
              `picked_up_at` timestamp NULL,
              `delivered_at` timestamp NULL,
              `failure_reason` text,
              `notes` text,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
              PRIMARY KEY (`assignment_id`),
              UNIQUE KEY `order_id` (`order_id`),
              KEY `rider_id` (`rider_id`),
              KEY `delivery_status` (`delivery_status`),
              CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
              CONSTRAINT `fk_rider` FOREIGN KEY (`rider_id`) REFERENCES `riders` (`rider_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
            
            "CREATE TABLE IF NOT EXISTS `delivery_logs` (
              `log_id` int(11) NOT NULL AUTO_INCREMENT,
              `assignment_id` int(11) NOT NULL,
              `rider_id` int(11) NOT NULL,
              `status_from` varchar(50),
              `status_to` varchar(50) NOT NULL,
              `location` varchar(255),
              `notes` text,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`log_id`),
              KEY `assignment_id` (`assignment_id`),
              KEY `rider_id` (`rider_id`),
              CONSTRAINT `fk_assignment_log` FOREIGN KEY (`assignment_id`) REFERENCES `delivery_assignments` (`assignment_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;"
        ];
        
        $all_success = true;
        foreach ($sql_queries as $query) {
            if (!$conn->query($query)) {
                $all_success = false;
                $migration_message .= "Error: " . htmlspecialchars($conn->error) . "<br>";
            }
        }
        
        if ($all_success) {
            $sample_password = password_hash('password123', PASSWORD_BCRYPT);
            $sample_queries = [
                "INSERT IGNORE INTO `riders` (`first_name`, `last_name`, `email`, `phone`, `password_hash`, `vehicle_type`, `vehicle_plate`, `status`, `is_verified`) 
                 VALUES ('John', 'Rider', 'rider1@example.com', '+63 9123456789', '$sample_password', 'motorcycle', 'ABC-1234', 'active', 1)",
                 
                "INSERT IGNORE INTO `riders` (`first_name`, `last_name`, `email`, `phone`, `password_hash`, `vehicle_type`, `vehicle_plate`, `status`, `is_verified`) 
                 VALUES ('Maria', 'Delgado', 'rider2@example.com', '+63 9123456790', '$sample_password', 'bicycle', 'XYZ-5678', 'active', 1)"
            ];
            
            foreach ($sample_queries as $query) {
                $conn->query($query);
            }
            
            $migration_done = true;
            $migration_message = "Database migration completed successfully! Sample riders have been added.";
        }
        
        $conn->close();
    }
}

$check_tables = false;
$conn = getDBConnection();
if ($conn) {
    $result = $conn->query("SHOW TABLES LIKE 'riders'");
    $check_tables = $result && $result->num_rows > 0;
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Rider System - Admin</title>
    <link rel="stylesheet" href="../admin/admin-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .setup-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .setup-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .setup-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .setup-header i {
            font-size: 2rem;
            color: #3b82f6;
        }

        .setup-header h1 {
            font-size: 1.5rem;
            color: #1e293b;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .status-indicator.success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #047857;
        }

        .status-indicator.warning {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            color: #b45309;
        }

        .status-indicator i {
            font-size: 1.2rem;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid #3b82f6;
        }

        .feature-item i {
            font-size: 1.2rem;
            color: #3b82f6;
            flex-shrink: 0;
            margin-top: 0.25rem;
        }

        .feature-item-content h3 {
            margin: 0 0 0.25rem 0;
            color: #1e293b;
            font-size: 1rem;
        }

        .feature-item-content p {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        .btn-migrate {
            background: #3b82f6;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-migrate:hover {
            background: #2563eb;
        }

        .btn-migrate:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #047857;
        }

        .alert-warning {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            color: #b45309;
        }

        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            color: #1e40af;
        }

        .info-box h4 {
            margin-top: 0;
            color: #1e3a8a;
        }

        .info-box p {
            margin: 0.5rem 0;
            font-size: 0.95rem;
        }

        .code-block {
            background: #1f2937;
            color: #f3f4f6;
            padding: 1rem;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .access-info {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .access-info h3 {
            margin-top: 0;
            color: #1e293b;
        }

        .access-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .access-item:last-child {
            border-bottom: none;
        }

        .access-label {
            font-weight: 600;
            color: #374151;
        }

        .access-value {
            color: #64748b;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <div class="setup-container">
        <div class="setup-card">
            <div class="setup-header">
                <i class="fas fa-motorcycle"></i>
                <h1>Rider Delivery System Setup</h1>
            </div>

            <?php if ($migration_done): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($migration_message); ?>
                </div>
                <div class="access-info">
                    <h3><i class="fas fa-sign-in-alt"></i> Rider Portal Access</h3>
                    <div class="access-item">
                        <span class="access-label">URL:</span>
                        <span class="access-value">http://localhost/nccc/rider/login.php</span>
                    </div>
                    <div class="access-item">
                        <span class="access-label">Sample Email 1:</span>
                        <span class="access-value">rider1@example.com</span>
                    </div>
                    <div class="access-item">
                        <span class="access-label">Sample Email 2:</span>
                        <span class="access-value">rider2@example.com</span>
                    </div>
                    <div class="access-item">
                        <span class="access-label">Password:</span>
                        <span class="access-value">password123</span>
                    </div>
                </div>
                <div class="info-box">
                    <h4>Next Steps:</h4>
                    <p>✓ Database tables created successfully</p>
                    <p>✓ Sample riders added</p>
                    <p>✓ Ready to manage riders and deliveries</p>
                    <p style="margin-top: 1rem;"><strong>What to do next:</strong></p>
                    <p>1. Go to <strong><a href="riders.php" style="color: #1e40af; text-decoration: underline;">Manage Riders</a></strong> to add more riders</p>
                    <p>2. Go to <strong><a href="deliveries.php" style="color: #1e40af; text-decoration: underline;">Manage Deliveries</a></strong> to assign riders to orders</p>
                    <p>3. Update orders to "shipped" status to enable delivery assignment</p>
                    <p>4. Riders can login at <strong>http://localhost/nccc/rider/login.php</strong></p>
                </div>
            <?php elseif ($check_tables): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Rider system tables already exist
                </div>
                <div class="info-box">
                    <h4>System Status: Ready to Use</h4>
                    <p>The rider delivery system is already installed and ready to use.</p>
                    <p><a href="riders.php" style="color: #1e40af; text-decoration: underline;"><i class="fas fa-users"></i> Go to Manage Riders</a></p>
                    <p><a href="deliveries.php" style="color: #1e40af; text-decoration: underline;"><i class="fas fa-truck"></i> Go to Manage Deliveries</a></p>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Rider system tables not detected. Run migration to set up the system.
                </div>

                <h2 style="margin: 2rem 0 1rem 0;">Features Included:</h2>
                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fas fa-user-check"></i>
                        <div class="feature-item-content">
                            <h3>Rider Authentication</h3>
                            <p>Secure login system for delivery riders with email verification</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-tasks"></i>
                        <div class="feature-item-content">
                            <h3>Delivery Management</h3>
                            <p>Riders can view assigned orders and update delivery status</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-chart-line"></i>
                        <div class="feature-item-content">
                            <h3>Dashboard & Statistics</h3>
                            <p>View delivery statistics and track performance metrics</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-history"></i>
                        <div class="feature-item-content">
                            <h3>Delivery Timeline</h3>
                            <p>Complete history of delivery updates and status changes</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-gavel"></i>
                        <div class="feature-item-content">
                            <h3>Admin Management</h3>
                            <p>Manage riders and assign deliveries from admin panel</p>
                        </div>
                    </div>
                </div>

                <form method="POST" style="margin-top: 2rem;">
                    <input type="hidden" name="run_migration" value="1">
                    <button type="submit" class="btn-migrate">
                        <i class="fas fa-database"></i> Run Database Migration
                    </button>
                </form>

                <?php if (!empty($migration_message)): ?>
                    <div class="alert alert-warning" style="margin-top: 1.5rem;">
                        <i class="fas fa-info-circle"></i>
                        <?php echo htmlspecialchars($migration_message); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="setup-card">
            <h2><i class="fas fa-book"></i> System Documentation</h2>
            
            <h3>Rider Portal URLs</h3>
            <div class="code-block">
Login Page: /rider/login.php
Dashboard: /rider/dashboard.php
Order Details: /rider/order_details.php
            </div>

            <h3>Admin Management URLs</h3>
            <div class="code-block">
Manage Riders: /admin/riders.php
Manage Deliveries: /admin/deliveries.php
            </div>

            <h3>Delivery Status Flow</h3>
            <div style="margin: 1rem 0;">
                <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1rem;">
                    <strong>Pending Assignment</strong> → <strong>Assigned</strong> → <strong>Picked Up</strong> → <strong>In Transit</strong> → <strong>Delivered</strong>
                </p>
                <p style="font-size: 0.9rem; color: #64748b;">
                    Alternative statuses: <strong>Failed Delivery</strong> or <strong>Returned</strong> (requires reason)
                </p>
            </div>

            <h3>Sample Rider Credentials</h3>
            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1rem;">
                After running migration, two sample riders are created:
            </p>
            <div class="code-block">
Email: rider1@example.com
Email: rider2@example.com
Password: password123

Vehicle Types: motorcycle, bicycle, car, truck
            </div>
        </div>
            </div>
        </main>
    </div>
</body>
</html>
