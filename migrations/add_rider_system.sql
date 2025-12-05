-- Add Rider Delivery System Tables

-- Table for riders
CREATE TABLE IF NOT EXISTS `riders` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table for delivery assignments
CREATE TABLE IF NOT EXISTS `delivery_assignments` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table for delivery history/logs
CREATE TABLE IF NOT EXISTS `delivery_logs` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample riders (optional)
INSERT INTO `riders` (`first_name`, `last_name`, `email`, `phone`, `password_hash`, `vehicle_type`, `vehicle_plate`, `status`, `is_verified`) VALUES
('John', 'Rider', 'rider1@example.com', '+63 9123456789', '$2y$10$GnVEXPzfP1WEQNHrQEb6hOXE.B9VbxGPHpjn7fVHCQEVPaFOjLDWC', 'motorcycle', 'ABC-1234', 'active', 1),
('Maria', 'Delgado', 'rider2@example.com', '+63 9123456790', '$2y$10$GnVEXPzfP1WEQNHrQEb6hOXE.B9VbxGPHpjn7fVHCQEVPaFOjLDWC', 'bicycle', 'XYZ-5678', 'active', 1);

ALTER TABLE `activity_logs` MODIFY COLUMN `user_type` enum('admin','customer','rider') NOT NULL;
