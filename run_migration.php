<?php
require_once 'config.php';

if (!isAdminLoggedIn()) {
    die('Access denied. Admin login required.');
}

$conn = getDBConnection();

if (!$conn) {
    die("Database connection failed");
}

$migration_sql = "CREATE TABLE IF NOT EXISTS `password_resets` (
  `reset_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reset_id`),
  UNIQUE KEY `uk_token` (`token`),
  KEY `fk_customer_id` (`customer_id`),
  CONSTRAINT `fk_password_resets_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($migration_sql)) {
    echo "<h2 style='color: green;'>✓ Migration successful!</h2>";
    echo "<p>The 'password_resets' table has been created.</p>";
} else {
    echo "<h2 style='color: red;'>✗ Migration failed!</h2>";
    echo "<p>Error: " . $conn->error . "</p>";
}

$conn->close();
?>
