-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 01:52 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campano_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `account_email` varchar(255) NOT NULL,
  `account_password` varchar(255) NOT NULL,
  `user_role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_email`, `account_password`, `user_role`) VALUES
(1, 'admin123@gmail.com', 'useradmin_123', 'user_admin'),
(2, 'service123@gmail.com', 'service_123', 'user_service'),
(3, 'kitchen123@gmail.com', 'kitchen_123', 'user_kitchen');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_location` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `lifetime_sales` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_category` enum('Main Course','Beverages','Dessert') NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `stock_id` int(50) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `item_name`, `item_price`, `item_category`, `item_image`, `stock_id`, `status`) VALUES
(1, 'Buttered shrimp', '240.00', 'Main Course', '../uploads/image3.jpg', 0, 'inactive'),
(2, 'Leche Plan haha', '120.00', 'Dessert', 'leche plan.jpg', 0, 'active'),
(3, 'aldrinnn', '555.00', 'Dessert', '../uploads/image1.jpg', 0, 'active'),
(4, 'aldrin dr', '123.00', 'Beverages', '../uploads/image2.webp', 0, 'active'),
(5, 'aldrin ca', '150.00', 'Beverages', '../uploads/image1.jpg', 0, 'inactive'),
(6, 'Sinugba', '345.00', 'Main Course', 'grilled shrimp.jpg', 0, 'active'),
(7, 'San Miguel', '123.00', 'Beverages', 'grilled shrimp.jpg', 0, 'active'),
(8, 'Sinugbang Ok', '200.00', 'Main Course', 'grilled shrimp.jpg', 0, 'active'),
(9, 'aldrin', '213.00', 'Dessert', '../uploads/image1.jpg', 0, 'active'),
(10, 'aldrin', '123.00', 'Main Course', '../uploads/image3.jpg', 0, 'active'),
(11, 'aldrin', '12333.00', 'Main Course', '../uploads/image1.jpg', 0, 'active'),
(12, 'aldrin', '123.00', '', '../uploads/image3.jpg', 0, 'active'),
(13, 'coke', '50.00', 'Beverages', 'leche plan.jpg', 0, 'active'),
(14, 'coke', '56.00', 'Beverages', 'leche plan.jpg', 0, 'active'),
(15, 'Leche plan', '123.00', 'Dessert', '../uploads/image1.jpg', 0, 'active'),
(16, 'coke', '123.00', 'Beverages', '../uploads/image3.jpg', 0, 'active'),
(17, 'coke litro', '50.00', 'Beverages', '../uploads/image3.jpg', 0, 'active'),
(18, 'coke', '55.00', 'Beverages', '../uploads/image1.jpg', 0, 'active'),
(19, 'coke mismo', '20.00', 'Beverages', 'image3.jpg', 0, 'active'),
(20, 'Parrot Fish', '123.00', 'Main Course', '../uploads/grilled shrimp.jpg', 0, 'active'),
(21, 'grilled shrimp', '255.00', 'Dessert', '../uploads/grilled shrimp.jpg', 0, 'active'),
(22, 'Shrimp HAHA', '12.00', 'Main Course', '../uploads/image2.webp', 0, 'active'),
(23, 'Shrimp', '112.00', 'Main Course', '../uploads/grilled shrimp.jpg', 1, 'active'),
(24, 'grilled shrimp', '255.00', 'Main Course', '../uploads/image1.jpg', 1, 'active'),
(25, 'Kinilaw', '230.00', 'Main Course', '../uploads/image3.jpg', 10, 'active'),
(26, 'Kinilaw', '130.00', 'Main Course', '../uploads/leche plan.jpg', 1, 'active'),
(27, 'Kinilaw', '125.00', 'Main Course', '../uploads/image1.jpg', 10, 'active'),
(28, 'Sugba', '452.00', 'Main Course', '../uploads/grilled shrimp.jpg', 9, 'active'),
(29, 'Cake', '450.00', 'Dessert', '../uploads/leche plan.jpg', 0, 'active'),
(30, 'ice cream', '55.00', 'Dessert', '../uploads/leche plan.jpg', 0, 'active'),
(31, 'cream', '345.00', 'Dessert', '../uploads/image3.jpg', 0, 'active'),
(32, 'Cakeeee', '233.00', 'Dessert', '../uploads/leche plan.jpg', 0, 'active'),
(33, 'Shrimp Fried', '455.00', 'Main Course', '../uploads/grilled shrimp.jpg', 0, 'active'),
(34, 'Kinilaw Banguss', '223.00', 'Main Course', '../uploads/grilled shrimp.jpg', 0, 'active'),
(35, 'Shrimp', '123.00', 'Dessert', '../uploads/leche plan.jpg', 0, 'active'),
(36, 'Test item', '55.00', 'Beverages', '../uploads/royal.jpg', 0, 'active'),
(37, 'Shrimp tinola', '12.00', 'Dessert', '../uploads/grilled shrimp.jpg', 0, 'active'),
(38, 'tinola', '12.00', 'Main Course', '../uploads/grilled shrimp.jpg', 0, 'active'),
(39, 'Okay Shrimp', '123.00', 'Main Course', '../uploads/grilled shrimp.jpg', 0, 'active'),
(40, 'sprite', '50.00', 'Beverages', '../uploads/sprite.png', 0, 'active'),
(41, 'coke float', '78.00', 'Dessert', '../uploads/coke mismo.png', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_stocks`
--

CREATE TABLE `menu_item_stocks` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity_required` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_stocks`
--

INSERT INTO `menu_item_stocks` (`id`, `menu_item_id`, `stock_id`, `quantity_required`, `created_at`) VALUES
(1, 22, 7, '0.00', '2024-09-04 15:31:10'),
(2, 23, 1, '0.00', '2024-09-04 23:36:23'),
(3, 19, 9, '0.00', '2024-09-05 00:02:33'),
(4, 24, 1, '0.00', '2024-09-05 00:04:27'),
(5, 19, 9, '0.00', '2024-09-05 00:04:44'),
(6, 22, 3, '0.00', '2024-09-05 00:05:10'),
(7, 22, 7, '0.00', '2024-09-05 00:05:23'),
(8, 19, 9, '0.00', '2024-09-05 00:05:42'),
(9, 19, 9, '0.00', '2024-09-05 00:05:59'),
(10, 19, 9, '0.00', '2024-09-05 00:07:23'),
(11, 19, 9, '0.00', '2024-09-05 00:14:08'),
(12, 19, 9, '0.00', '2024-09-05 00:15:10'),
(13, 22, 1, '0.00', '2024-09-05 00:15:59'),
(14, 19, 9, '0.00', '2024-09-05 00:24:04'),
(17, 23, 1, '0.00', '2024-09-05 01:14:33'),
(18, 22, 7, '0.00', '2024-09-05 01:14:39'),
(21, 7, 6, '0.00', '2024-09-05 13:06:24'),
(22, 25, 10, '0.00', '2024-09-06 00:07:26'),
(23, 6, 8, '0.00', '2024-09-06 00:08:29'),
(24, 8, 10, '0.00', '2024-09-06 07:59:30'),
(25, 2, 11, '0.00', '2024-09-06 10:21:06'),
(26, 16, 9, '0.00', '2024-09-06 14:08:30'),
(27, 17, 9, '0.00', '2024-09-06 14:12:41'),
(28, 17, 9, '0.00', '2024-09-06 14:17:35'),
(29, 13, 9, '0.00', '2024-09-06 14:17:56'),
(30, 14, 9, '0.00', '2024-09-06 14:18:28'),
(31, 19, 9, '0.00', '2024-09-06 14:19:44'),
(32, 26, 1, '0.00', '2024-09-06 22:38:56'),
(33, 27, 10, '0.00', '2024-09-06 22:39:52'),
(34, 2, 11, '0.00', '2024-09-06 22:44:17'),
(35, 2, 11, '0.00', '2024-09-07 02:03:46'),
(36, 28, 9, '0.00', '2024-09-07 05:35:59'),
(37, 29, 11, '0.00', '2024-09-07 12:54:17'),
(38, 29, 4, '0.00', '2024-09-07 12:54:17'),
(39, 30, 12, '0.00', '2024-09-07 12:57:03'),
(40, 30, 11, '0.00', '2024-09-07 12:57:03'),
(41, 31, 11, '0.00', '2024-09-07 13:03:54'),
(42, 31, 12, '0.00', '2024-09-07 13:03:54'),
(43, 32, 11, '5.00', '2024-09-07 13:10:10'),
(44, 32, 12, '5.00', '2024-09-07 13:10:10'),
(45, 33, 11, '5.00', '2024-09-07 13:29:25'),
(46, 33, 12, '5.00', '2024-09-07 13:29:25'),
(47, 34, 10, '2.00', '2024-09-08 01:49:58'),
(48, 34, 5, '2.00', '2024-09-08 01:49:58'),
(50, 34, 1, '1.00', '2024-09-08 02:12:16'),
(51, 35, 2, '0.00', '2024-09-09 05:05:09'),
(52, 34, 1, '1.00', '2024-09-09 05:15:44'),
(53, 34, 1, '1.00', '2024-09-09 05:16:05'),
(54, 31, 1, '1.00', '2024-09-09 05:16:45'),
(55, 17, 1, '1.00', '2024-09-09 05:44:06'),
(56, 2, 1, '1.00', '2024-09-09 06:56:28'),
(61, 35, 1, '1.00', '2024-09-09 07:05:35'),
(62, 36, 4, '25.00', '2024-09-09 07:13:53'),
(66, 40, 13, '1.00', '2024-09-09 14:36:16'),
(73, 4, 10, '1.00', '2024-09-09 14:38:22'),
(94, 3, 1, '1.00', '2024-09-09 15:11:30'),
(95, 3, 1, '1.00', '2024-09-09 15:11:30'),
(96, 5, 6, '0.00', '2024-09-09 15:11:42'),
(103, 1, 1, '2.00', '2024-09-09 15:12:56'),
(109, 39, 1, '2.00', '2024-09-09 15:16:38'),
(114, 38, 8, '1.00', '2024-09-09 16:09:57'),
(115, 38, 10, '0.00', '2024-09-09 16:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_status` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_location` varchar(255) DEFAULT NULL,
  `customer_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `stock_name` varchar(100) NOT NULL,
  `stock_quantity` int(250) NOT NULL,
  `stock_unit` enum('KG','Pieces') DEFAULT NULL,
  `stock_date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `stock_quantity`, `stock_unit`, `stock_date_added`, `stock_status`) VALUES
(1, 'Shrimp', 25, 'KG', '2024-09-07 19:36:07', 'active'),
(2, 'Parrot fish', 60, 'KG', '2024-09-07 04:21:17', 'inactive'),
(3, 'Red horse', 8, 'Pieces', '2024-09-06 16:21:55', 'active'),
(4, 'Royal', 10, 'Pieces', '2024-09-03 19:39:49', 'active'),
(5, 'Tamban tuloy', 55, 'KG', '2024-09-04 06:51:13', 'inactive'),
(6, 'San miguel', 55, 'Pieces', '2024-09-03 06:51:20', 'active'),
(7, 'Bangus', 65, 'KG', '2024-09-04 05:17:27', 'inactive'),
(8, 'Bangus', 55, 'KG', '2024-09-03 06:53:03', 'active'),
(9, 'Coke', 1, 'Pieces', '2024-09-06 08:50:55', 'active'),
(10, 'Tamban', 5, 'KG', '2024-09-06 03:18:17', 'active'),
(11, 'Eggs', 50, 'Pieces', '2024-09-06 04:20:04', 'active'),
(12, 'Flour', 50, 'KG', '2024-09-07 06:56:04', 'active'),
(13, 'Sprite', 50, 'Pieces', '2024-09-09 08:34:21', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`account_email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_item_id` (`menu_item_id`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  ADD CONSTRAINT `menu_item_stocks_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_item_stocks_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
