-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.infinityfree.com
-- Generation Time: Nov 30, 2025 at 09:39 PM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40532602_nccc_malls`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address_type` enum('billing','shipping') NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state_province` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `customer_id`, `address_type`, `is_default`, `street_address`, `city`, `state_province`, `postal_code`, `country`, `created_at`) VALUES
(1, 3, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-24 02:54:32'),
(2, 2, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-28 10:44:57'),
(3, 4, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-29 00:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `parent_category_id`, `description`, `image_url`, `is_active`, `created_at`) VALUES
(1, 'Electronics', NULL, 'Latest gadgets, smartphones, laptops, and tech accessories', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800&q=80', 1, '2025-11-24 00:05:44'),
(2, 'Clothing', NULL, 'Fashion for every style and occasion - men, women, and kids', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80', 1, '2025-11-24 00:05:44'),
(3, 'Home & Garden', NULL, 'Transform your living space with furniture and decor', 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&q=80', 1, '2025-11-24 00:05:44'),
(4, 'Sports & Outdoors', NULL, 'Gear up for adventure and active lifestyle', 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&q=80', 1, '2025-11-24 00:05:44'),
(5, 'Books', NULL, 'Knowledge and stories await in our book collection', 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800&q=80', 1, '2025-11-24 00:05:44'),
(6, 'Grocery', NULL, '', NULL, 0, '2025-11-25 03:10:42'),
(29, 'Groceries', NULL, 'Fresh food, beverages, and household essentials', 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80', 1, '2025-11-25 05:31:02'),
(30, 'Snacks & Sweets', 29, 'Filipino chips, cookies, candies, and sweet treats', 'https://images.unsplash.com/photo-1621768216002-5ac171876625?w=800&q=80', 0, '2025-11-25 05:31:02'),
(31, 'Canned Goods', 29, 'Canned fish, meat, vegetables, and preserved foods', 'https://images.unsplash.com/photo-1562843467-e0e689b3d98d?w=800&q=80', 1, '2025-11-25 05:31:02'),
(32, 'Noodles & Pasta', 29, 'Instant noodles, pasta, and quick meal solutions', 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, '2025-11-25 05:31:02'),
(33, 'Beverages', 29, 'Coffee, tea, juices, soft drinks, and refreshments', 'https://images.unsplash.com/photo-1544145945-35046820424e?w=800&q=80', 1, '2025-11-25 05:31:02'),
(34, 'Condiments & Sauces', 29, 'Soy sauce, vinegar, cooking oils, and flavor enhancers', 'https://images.unsplash.com/photo-1596040033229-a0b8f3f5e5f5?w=800&q=80', 1, '2025-11-25 05:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_type` enum('percentage','fixed_amount') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase_amount` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `coupon_code`, `description`, `discount_type`, `discount_value`, `min_purchase_amount`, `max_discount_amount`, `usage_limit`, `usage_count`, `start_date`, `end_date`, `is_active`, `created_at`) VALUES
(1, '1', 'Gadget', 'percentage', '10.00', '100.00', NULL, NULL, 0, '2025-11-28', '2025-11-29', 1, '2025-11-28 12:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `email`, `password_hash`, `first_name`, `last_name`, `phone`, `date_of_birth`, `created_at`, `updated_at`, `is_active`, `last_login`) VALUES
(2, 'yayenydrian@gmail.com', '$2y$10$.VYqTcirLgMMy5zONfCPBuP3A/BOqN2ui9sy8tgtktgmMOqDl7GBW', 'Ydrian', 'Yayen', '09461478420', '2002-05-18', '2025-11-24 00:16:42', '2025-12-01 01:38:51', 1, '2025-12-01 01:38:51'),
(3, 'johndoe@gmail.com', '$2y$10$UwyejG2ch57BFD.W5zxD5eDCGhmvfdjWncFQX5BfSs/5N/g9saymG', 'john', 'doe', '09123121231', NULL, '2025-11-24 02:52:43', '2025-11-24 02:52:52', 1, '2025-11-24 02:52:52'),
(4, 'andrepagliawan@gmail.com', '$2y$10$A.kIRqkRC4wvR4Fj1TQvMeftFcGwtdnY9pW.NCgjTgMlUGHkKgj/G', 'Andre', 'Pagliawan', '09123121231', NULL, '2025-11-29 00:25:52', '2025-11-29 00:26:05', 1, '2025-11-29 00:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reserved_quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) DEFAULT 10,
  `last_restocked` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `quantity`, `reserved_quantity`, `reorder_level`, `last_restocked`, `updated_at`) VALUES
(1, 1, 45, 5, 15, NULL, '2025-11-24 02:27:17'),
(2, 2, 30, 3, 10, NULL, '2025-11-24 02:27:17'),
(3, 3, 75, 8, 20, NULL, '2025-11-24 02:27:17'),
(4, 4, 20, 2, 8, NULL, '2025-11-24 02:27:17'),
(5, 5, 120, 10, 30, NULL, '2025-11-24 02:27:17'),
(6, 6, 26, 1, 5, '2025-11-29 04:18:12', '2025-11-29 04:18:12'),
(7, 7, 200, 15, 50, NULL, '2025-11-24 02:27:17'),
(8, 8, 19, 1, 3, '2025-11-29 04:17:42', '2025-11-29 04:17:42'),
(9, 9, 150, 12, 40, NULL, '2025-11-24 02:27:17'),
(10, 10, 200, 20, 50, NULL, '2025-11-24 02:27:17'),
(11, 11, 85, 9, 25, NULL, '2025-11-24 02:27:17'),
(12, 12, 60, 5, 20, NULL, '2025-11-24 02:27:17'),
(13, 13, 180, 15, 45, NULL, '2025-11-24 02:27:17'),
(14, 14, 95, 8, 30, NULL, '2025-11-24 02:27:17'),
(15, 15, 140, 11, 35, NULL, '2025-11-24 02:27:17'),
(16, 16, 35, 3, 10, NULL, '2025-11-24 02:27:17'),
(17, 17, 90, 7, 25, NULL, '2025-11-24 02:27:17'),
(18, 18, 25, 2, 8, NULL, '2025-11-24 02:27:17'),
(19, 19, 50, 4, 15, NULL, '2025-11-24 02:27:17'),
(20, 20, 18, 2, 6, NULL, '2025-11-24 02:27:17'),
(21, 21, 65, 5, 20, NULL, '2025-11-24 02:27:17'),
(22, 22, 24, 1, 4, '2025-11-29 04:17:50', '2025-11-29 04:17:50'),
(23, 23, 40, 3, 12, NULL, '2025-11-24 02:27:17'),
(24, 24, 22, 2, 7, NULL, '2025-11-24 02:27:17'),
(25, 25, 55, 4, 15, NULL, '2025-11-24 02:27:17'),
(26, 26, 80, 6, 25, NULL, '2025-11-24 02:27:17'),
(27, 27, 30, 2, 10, NULL, '2025-11-24 02:27:17'),
(28, 28, 45, 4, 15, NULL, '2025-11-24 02:27:17'),
(29, 29, 110, 9, 30, NULL, '2025-11-24 02:27:17'),
(30, 30, 250, 20, 60, NULL, '2025-11-24 02:27:17'),
(31, 31, 180, 15, 50, NULL, '2025-11-24 02:27:17'),
(32, 32, 160, 12, 45, NULL, '2025-11-24 02:27:17'),
(33, 33, 140, 10, 40, NULL, '2025-11-24 02:27:17'),
(34, 34, 200, 18, 55, NULL, '2025-11-24 02:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `customer_id`, `order_id`, `type`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 4, NULL, 'order_status', 'Order Shipped', 'Your order #ORD-20251129-2A1E86D9 has been shipped! It\'s on its way to you.', 1, '2025-11-29 01:52:44'),
(2, 2, NULL, 'order_status', 'Order Cancelled', 'Your order #ORD-20251128-2057B79F has been cancelled.', 0, '2025-11-29 04:16:06'),
(3, 2, NULL, 'order_status', 'Order Shipped', 'Your order #ORD-20251130-75969C1F has been shipped! It\'s on its way to you.', 0, '2025-12-01 01:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_status` enum('pending','processing','shipped','delivered','cancelled','refunded') DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address_id` int(11) NOT NULL,
  `billing_address_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_coupons`
--

CREATE TABLE `order_coupons` (
  `order_coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `discount_applied` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE `order_notes` (
  `note_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `note_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `sale_price`, `sku`, `brand`, `weight`, `dimensions`, `is_active`, `featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'Samsung Galaxy S24 Ultra', '6.8-inch Dynamic AMOLED display, 200MP camera, 12GB RAM, 256GB storage', '54999.00', '49999.00', 'ELEC-SMSG-S24U-256', 'Samsung', '0.23', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(2, 1, 'Apple iPhone 15 Pro Max', 'A17 Pro chip, Titanium design, 48MP camera, 256GB', '69999.00', NULL, 'ELEC-APPL-IP15PM-256', 'Apple', '0.22', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(3, 1, 'Sony WH-1000XM5 Headphones', 'Premium noise cancelling wireless headphones with 30-hour battery', '16999.00', '14999.00', 'ELEC-SONY-WH1000XM5', 'Sony', '0.25', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(4, 1, 'Dell XPS 15 Laptop', '15.6\" 4K display, Intel i7-13700H, 16GB RAM, 512GB SSD, RTX 4050', '89999.00', NULL, 'ELEC-DELL-XPS15-I7', 'Dell', '1.86', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(5, 1, 'Logitech MX Master 3S Mouse', 'Wireless ergonomic mouse with 8K DPI sensor', '4999.00', '4499.00', 'ELEC-LOGI-MXM3S', 'Logitech', '0.14', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(6, 1, 'Samsung 55\" 4K Smart TV', 'Crystal UHD 4K display, Tizen OS, HDR10+', '32999.00', '29999.00', 'ELEC-SMSG-TV55-4K', 'Samsung', '15.50', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(7, 1, 'Anker PowerCore 20000mAh', 'High-capacity portable charger with fast charging', '2499.00', NULL, 'ELEC-ANKR-PC20K', 'Anker', '0.35', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(8, 1, 'Canon EOS R6 Mark II', 'Full-frame mirrorless camera, 24.2MP, 4K 60fps video', '149999.00', NULL, 'ELEC-CANN-R6M2', 'Canon', '0.67', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(9, 2, 'Levi\'s 501 Original Jeans', 'Classic straight fit denim jeans, 100% cotton', '3499.00', '2999.00', 'CLTH-LEVI-501-BLU-32', 'Levi\'s', '0.60', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(10, 2, 'Nike Dri-FIT Running Shirt', 'Moisture-wicking performance t-shirt, breathable fabric', '1499.00', NULL, 'CLTH-NIKE-DRIF-BLK-L', 'Nike', '0.15', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(11, 2, 'Adidas Ultraboost 23 Shoes', 'Premium running shoes with Boost cushioning technology', '8999.00', '7999.00', 'CLTH-ADID-UB23-WHT-10', 'Adidas', '0.75', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(12, 2, 'The North Face Resolve Jacket', 'Waterproof windbreaker with adjustable hood', '5999.00', NULL, 'CLTH-TNF-RSLV-GRN-M', 'The North Face', '0.40', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(13, 2, 'Uniqlo Heattech Thermal Wear', 'Heat-generating base layer for cold weather', '799.00', '599.00', 'CLTH-UNIQ-HEAT-GRY-M', 'Uniqlo', '0.20', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(14, 2, 'Ralph Lauren Polo Shirt', 'Classic fit cotton polo with signature pony logo', '2999.00', NULL, 'CLTH-RL-POLO-NVY-L', 'Ralph Lauren', '0.25', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(15, 2, 'H&M Cotton Chino Pants', 'Slim fit chinos with stretch fabric', '1299.00', '999.00', 'CLTH-HM-CHIN-KHK-32', 'H&M', '0.35', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(16, 3, 'Dyson V15 Detect Cordless Vacuum', 'Laser dust detection, 60-minute runtime, HEPA filtration', '29999.00', '27999.00', 'HOME-DYSO-V15DET', 'Dyson', '3.10', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(17, 3, 'Philips Hue Smart Bulb Starter Kit', '4-pack color-changing LED bulbs with bridge', '6999.00', NULL, 'HOME-PHIL-HUE-4PK', 'Philips', '0.50', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(18, 3, 'KitchenAid Stand Mixer', '5-quart tilt-head mixer with 10 speeds, includes accessories', '18999.00', '16999.00', 'HOME-KA-MIXER-RED', 'KitchenAid', '10.20', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(19, 3, 'Nespresso Vertuo Coffee Maker', 'One-touch espresso and coffee machine with frother', '8999.00', NULL, 'HOME-NESP-VERT-BLK', 'Nespresso', '4.50', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(20, 3, 'iRobot Roomba j7+', 'Self-emptying robot vacuum with object recognition', '39999.00', '35999.00', 'HOME-IRO-J7PLUS', 'iRobot', '3.40', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(21, 3, 'Black+Decker 20V Drill Kit', 'Cordless drill with 2 batteries and carrying case', '3999.00', NULL, 'HOME-BD-DRILL-20V', 'Black+Decker', '2.00', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(22, 3, 'Weber Genesis Gas Grill', '3-burner propane grill with side burner and storage', '34999.00', NULL, 'HOME-WEBR-GEN-3B', 'Weber', '65.00', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(23, 4, 'Yeti Tundra 45 Cooler', 'Rotomolded construction, bear-resistant, 28-can capacity', '19999.00', NULL, 'SPRT-YETI-T45-WHT', 'Yeti', '10.00', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(24, 4, 'Trek Marlin 7 Mountain Bike', '29-inch wheels, 21-speed, aluminum frame', '32999.00', '29999.00', 'SPRT-TREK-M7-BLU-M', 'Trek', '13.50', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(25, 4, 'Coleman Sundome Tent 4-Person', 'WeatherTec system, easy setup, fits 4 campers', '4999.00', NULL, 'SPRT-COLM-SD4-GRN', 'Coleman', '5.80', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(26, 4, 'TRX Home2 Suspension Trainer', 'Total body resistance training system with workout guide', '7999.00', '6999.00', 'SPRT-TRX-HM2-BLK', 'TRX', '1.20', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(27, 4, 'Bowflex SelectTech 552 Dumbbells', 'Adjustable dumbbells, 5-52.5 lbs per dumbbell', '24999.00', NULL, 'SPRT-BWFX-ST552', 'Bowflex', '25.00', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(28, 4, 'GoPro HERO12 Black', '5.3K60 video, HyperSmooth 6.0, waterproof to 33ft', '21999.00', '19999.00', 'SPRT-GPRO-H12-BLK', 'GoPro', '0.15', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(29, 4, 'Wilson Evolution Basketball', 'Official size, composite leather, indoor use', '2499.00', NULL, 'SPRT-WILS-EVO-BBAL', 'Wilson', '0.62', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(30, 5, 'Atomic Habits by James Clear', 'Proven framework for improving every day, hardcover', '899.00', '749.00', 'BOOK-ATML-HBIT-HC', 'Penguin Random House', '0.40', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(31, 5, 'The Psychology of Money', 'Timeless lessons on wealth and happiness by Morgan Housel', '699.00', NULL, 'BOOK-PSYC-MONY-PB', 'Harriman House', '0.35', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(32, 5, 'Educated: A Memoir', 'Tara Westover\'s powerful story of self-invention', '799.00', '649.00', 'BOOK-EDUC-MEMO-PB', 'Random House', '0.38', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(33, 5, 'The Lean Startup', 'How today\'s entrepreneurs build successful businesses', '999.00', NULL, 'BOOK-LEAN-STRT-HC', 'Crown Business', '0.45', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(34, 5, 'Sapiens: A Brief History', 'Yuval Noah Harari\'s journey through human history', '1299.00', '999.00', 'BOOK-SAPI-HIST-HC', 'Harper', '0.65', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `is_primary`, `display_order`, `created_at`) VALUES
(17, 1, 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=800', 1, 1, '2025-11-24 02:39:49'),
(18, 1, 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800', 0, 2, '2025-11-24 02:39:49'),
(19, 1, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800', 0, 3, '2025-11-24 02:39:49'),
(20, 2, 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=800', 1, 1, '2025-11-24 02:39:49'),
(21, 2, 'https://images.unsplash.com/photo-1592286927505-c3b0842d2b1f?w=800', 0, 2, '2025-11-24 02:39:49'),
(22, 3, 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800', 1, 1, '2025-11-24 02:39:49'),
(23, 3, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800', 0, 2, '2025-11-24 02:39:49'),
(24, 4, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800', 1, 1, '2025-11-24 02:39:49'),
(25, 4, 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800', 0, 2, '2025-11-24 02:39:49'),
(26, 5, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800', 1, 1, '2025-11-24 02:39:49'),
(27, 6, 'https://images.unsplash.com/photo-1593784991095-a205069470b6?w=800', 1, 1, '2025-11-24 02:39:49'),
(28, 6, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800', 0, 2, '2025-11-24 02:39:49'),
(29, 7, 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=800', 1, 1, '2025-11-24 02:39:49'),
(30, 8, 'https://images.unsplash.com/photo-1606980395156-c1d49dd39ad6?w=800', 1, 1, '2025-11-24 02:39:49'),
(31, 8, 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800', 0, 2, '2025-11-24 02:39:49'),
(32, 9, 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800', 1, 1, '2025-11-24 02:39:49'),
(33, 9, 'https://images.unsplash.com/photo-1475178626620-a4d074967452?w=800', 0, 2, '2025-11-24 02:39:49'),
(34, 10, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800', 1, 1, '2025-11-24 02:39:49'),
(35, 11, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800', 1, 1, '2025-11-24 02:39:49'),
(36, 11, 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800', 0, 2, '2025-11-24 02:39:49'),
(37, 12, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800', 1, 1, '2025-11-24 02:39:49'),
(38, 13, 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800', 1, 1, '2025-11-24 02:39:49'),
(39, 14, 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?w=800', 1, 1, '2025-11-24 02:39:49'),
(40, 15, 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800', 1, 1, '2025-11-24 02:39:49'),
(41, 16, 'https://images.unsplash.com/photo-1558317374-067fb5f30001?w=800', 1, 1, '2025-11-24 02:39:49'),
(42, 16, 'https://images.unsplash.com/photo-1605726045934-a89dd4352d42?w=800', 0, 2, '2025-11-24 02:39:49'),
(43, 17, 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800', 1, 1, '2025-11-24 02:39:49'),
(44, 18, 'https://images.unsplash.com/photo-1578269174936-2709b6aeb913?w=800', 1, 1, '2025-11-24 02:39:49'),
(45, 18, 'https://images.unsplash.com/photo-1612967015325-c89d2ac2e9a0?w=800', 0, 2, '2025-11-24 02:39:49'),
(46, 19, 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800', 1, 1, '2025-11-24 02:39:49'),
(47, 20, 'https://images.unsplash.com/photo-1614963326505-843868e1d83a?w=800', 1, 1, '2025-11-24 02:39:49'),
(48, 21, 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800', 1, 1, '2025-11-24 02:39:49'),
(49, 22, 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800', 1, 1, '2025-11-24 02:39:49'),
(50, 23, 'https://images.unsplash.com/photo-1591154669695-5f2a8d20c089?w=800', 1, 1, '2025-11-24 02:39:49'),
(51, 24, 'https://images.unsplash.com/photo-1576435728678-68d0fbf94e91?w=800', 1, 1, '2025-11-24 02:39:49'),
(52, 24, 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?w=800', 0, 2, '2025-11-24 02:39:49'),
(53, 25, 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=800', 1, 1, '2025-11-24 02:39:49'),
(54, 26, 'https://images.unsplash.com/photo-1598971861713-54ad16c9b881?w=800', 1, 1, '2025-11-24 02:39:49'),
(55, 27, 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800', 1, 1, '2025-11-24 02:39:49'),
(56, 28, 'https://images.unsplash.com/photo-1531492746076-161ca9bcad58?w=800', 1, 1, '2025-11-24 02:39:49'),
(57, 28, 'https://images.unsplash.com/photo-1519638399535-1b036603ac77?w=800', 0, 2, '2025-11-24 02:39:49'),
(58, 29, 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800', 1, 1, '2025-11-24 02:39:49'),
(59, 30, 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800', 1, 1, '2025-11-24 02:39:49'),
(60, 31, 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=800', 1, 1, '2025-11-24 02:39:49'),
(61, 32, 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800', 1, 1, '2025-11-24 02:39:49'),
(62, 33, 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=800', 1, 1, '2025-11-24 02:39:49'),
(63, 34, 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800', 1, 1, '2025-11-24 02:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `carrier` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_method` varchar(100) DEFAULT NULL,
  `shipped_date` timestamp NULL DEFAULT NULL,
  `estimated_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` timestamp NULL DEFAULT NULL,
  `status` enum('preparing','shipped','in_transit','delivered','failed') DEFAULT 'preparing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `customer_id`, `product_id`, `quantity`, `added_at`, `updated_at`) VALUES
(3, 3, 1, 1, '2025-11-24 02:53:25', '2025-11-24 02:53:25'),
(4, 3, 2, 1, '2025-11-24 02:53:37', '2025-11-24 02:53:37'),
(5, 3, 3, 1, '2025-11-24 02:53:43', '2025-11-24 02:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `description`, `updated_at`) VALUES
('currency_symbol', '₱', 'text', 'Currency symbol', '2025-11-24 14:17:43'),
('enable_email_notifications', '1', 'checkbox', 'Enable email notifications', '2025-12-01 01:06:27'),
('enable_order_emails', '1', 'checkbox', 'Send order confirmation emails', '2025-12-01 01:06:27'),
('enable_payment_emails', '1', 'checkbox', 'Send payment confirmation emails', '2025-12-01 01:06:27'),
('enable_reviews', '1', 'checkbox', 'Enable product reviews', '2025-11-24 13:58:30'),
('enable_shipping_emails', '1', 'checkbox', 'Send shipping notification emails', '2025-12-01 01:06:27'),
('free_shipping_threshold', '49.9', 'number', 'Free shipping minimum', '2025-11-28 03:29:00'),
('gmail_sender_email', 'jrd.malls@gmail.com', 'email', 'Gmail sender email address', '2025-12-01 01:07:40'),
('gmail_sender_name', 'JRD Malls', 'text', 'Email sender name', '2025-12-01 01:07:40'),
('gmail_sender_password', 'kcooqodzgkvynodo', 'password', 'Gmail app password (16 characters)', '2025-12-01 01:07:40'),
('items_per_page', '10', 'number', 'Products per page', '2025-11-30 13:13:58'),
('maintenance_mode', '0', 'checkbox', 'Maintenance mode', '2025-11-28 03:29:00'),
('require_email_verification', '1', 'checkbox', 'Require email verification', '2025-11-28 03:29:00'),
('shipping_cost', '5.99', 'number', 'Standard shipping cost', '2025-11-24 13:58:30'),
('site_email', 'jrd.malls@gmail.com', 'email', 'Contact email', '2025-12-01 00:26:48'),
('site_name', 'JRD Malls', 'text', 'Website name', '2025-11-28 03:37:27'),
('site_phone', '+63 992 607 2695', 'text', 'Contact phone', '2025-12-01 00:26:48'),
('tax_rate', '10', 'number', 'Tax rate (%)', '2025-12-01 00:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `customer_id`, `product_id`, `added_at`) VALUES
(1, 3, 1, '2025-11-24 02:53:26'),
(2, 2, 1, '2025-11-29 00:10:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_category_id` (`parent_category_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_customer_email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `idx_inventory_product` (`product_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `idx_customer_read` (`customer_id`,`is_read`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `shipping_address_id` (`shipping_address_id`),
  ADD KEY `billing_address_id` (`billing_address_id`),
  ADD KEY `idx_order_customer` (`customer_id`),
  ADD KEY `idx_order_status` (`order_status`),
  ADD KEY `idx_order_date` (`created_at`);

--
-- Indexes for table `order_coupons`
--
ALTER TABLE `order_coupons`
  ADD PRIMARY KEY (`order_coupon_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_product_category` (`category_id`),
  ADD KEY `idx_product_sku` (`sku`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `unique_cart_item` (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `unique_wishlist_item` (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_coupons`
--
ALTER TABLE `order_coupons`
  MODIFY `order_coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_notes`
--
ALTER TABLE `order_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`address_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`address_id`);

--
-- Constraints for table `order_coupons`
--
ALTER TABLE `order_coupons`
  ADD CONSTRAINT `order_coupons_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_coupons_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`coupon_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD CONSTRAINT `order_notes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
