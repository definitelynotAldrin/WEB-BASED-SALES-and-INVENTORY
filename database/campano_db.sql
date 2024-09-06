-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2024 at 02:52 AM
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
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_category` enum('Main Course','Beverages','Dessert') NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `stock_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `item_name`, `item_price`, `item_category`, `item_image`, `stock_id`) VALUES
(1, 'shrimp', '240.00', 'Main Course', '../uploads/image3.jpg', 0),
(2, 'aldriN', '55.00', 'Dessert', '../uploads/image1.jpg', 0),
(3, 'aldrin', '555.00', 'Dessert', '../uploads/image1.jpg', 0),
(4, 'aldrin', '123.00', 'Main Course', '../uploads/image2.webp', 0),
(5, 'aldrin ca', '150.00', 'Beverages', '../uploads/image1.jpg', 0),
(6, 'Sinugba', '345.00', 'Main Course', 'grilled shrimp.jpg', 0),
(7, 'San Miguel', '123.00', 'Beverages', 'grilled shrimp.jpg', 0),
(8, 'aldrin', '123.00', 'Main Course', '../uploads/', 0),
(9, 'aldrin', '213.00', 'Dessert', '../uploads/image1.jpg', 0),
(10, 'aldrin', '123.00', 'Main Course', '../uploads/image3.jpg', 0),
(11, 'aldrin', '12333.00', 'Main Course', '../uploads/image1.jpg', 0),
(12, 'aldrin', '123.00', '', '../uploads/image3.jpg', 0),
(13, 'coke', '50.00', '', '../uploads/image3.jpg', 0),
(14, 'coke', '56.00', '', '../uploads/image1.jpg', 0),
(15, 'Leche plan', '123.00', 'Dessert', '../uploads/image1.jpg', 0),
(16, 'coke', '123.00', '', '../uploads/image3.jpg', 0),
(17, 'coke', '100.00', 'Dessert', '../uploads/image3.jpg', 0),
(18, 'coke', '55.00', 'Beverages', '../uploads/image1.jpg', 0),
(19, 'coke mismo', '20.00', 'Main Course', 'image3.jpg', 0),
(20, 'Parrot Fish', '123.00', 'Main Course', '../uploads/grilled shrimp.jpg', 0),
(21, 'grilled shrimp', '255.00', 'Dessert', '../uploads/grilled shrimp.jpg', 0),
(22, 'Shrimp HAHA', '12.00', 'Main Course', '../uploads/image2.webp', 0),
(23, 'Shrimp', '112.00', 'Main Course', '../uploads/grilled shrimp.jpg', 1),
(24, 'grilled shrimp', '255.00', 'Main Course', '../uploads/image1.jpg', 1),
(25, 'Kinilaw', '230.00', 'Main Course', '../uploads/image3.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_stocks`
--

CREATE TABLE `menu_item_stocks` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity_required` decimal(50,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_stocks`
--

INSERT INTO `menu_item_stocks` (`id`, `menu_item_id`, `stock_id`, `quantity_required`, `created_at`) VALUES
(1, 22, 7, '1', '2024-09-04 15:31:10'),
(2, 23, 1, '1', '2024-09-04 23:36:23'),
(3, 19, 9, '1', '2024-09-05 00:02:33'),
(4, 24, 1, '1', '2024-09-05 00:04:27'),
(5, 19, 9, '1', '2024-09-05 00:04:44'),
(6, 22, 3, '1', '2024-09-05 00:05:10'),
(7, 22, 7, '1', '2024-09-05 00:05:23'),
(8, 19, 9, '1', '2024-09-05 00:05:42'),
(9, 19, 9, '1', '2024-09-05 00:05:59'),
(10, 19, 9, '1', '2024-09-05 00:07:23'),
(11, 19, 9, '1', '2024-09-05 00:14:08'),
(12, 19, 9, '1', '2024-09-05 00:15:10'),
(13, 22, 1, '1', '2024-09-05 00:15:59'),
(14, 19, 9, '1', '2024-09-05 00:24:04'),
(15, 5, 6, '1', '2024-09-05 00:31:34'),
(16, 4, 10, '1', '2024-09-05 01:14:14'),
(17, 23, 1, '1', '2024-09-05 01:14:33'),
(18, 22, 7, '1', '2024-09-05 01:14:39'),
(19, 1, 1, '1', '2024-09-05 01:50:12'),
(20, 1, 1, '1', '2024-09-05 02:27:55'),
(21, 7, 6, '1', '2024-09-05 13:06:24'),
(22, 25, 10, '1', '2024-09-06 00:07:26'),
(23, 6, 8, '1', '2024-09-06 00:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `stock_name` varchar(100) NOT NULL,
  `stock_quantity` int(250) NOT NULL,
  `stock_unit` enum('KG','Pieces') DEFAULT NULL,
  `stock_date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `stock_quantity`, `stock_unit`, `stock_date_added`) VALUES
(1, 'Shrimp', 25, 'KG', '2024-09-03 09:44:43'),
(2, 'Parrot Fish', 50, 'KG', '2024-09-03 06:05:40'),
(3, 'Red horse', 35, 'Pieces', '2024-09-03 09:44:57'),
(4, 'Royal', 10, 'Pieces', '2024-09-03 19:39:49'),
(5, 'Tamban tuloy', 55, 'KG', '2024-09-04 06:51:13'),
(6, 'San miguel', 55, 'Pieces', '2024-09-03 06:51:20'),
(7, 'Bangus', 65, 'KG', '2024-09-04 05:17:27'),
(8, 'Bangus', 55, 'KG', '2024-09-03 06:53:03'),
(9, 'Coke', 55, 'Pieces', '2024-09-03 06:53:54'),
(10, 'Tamban', 45, 'KG', '2024-09-03 07:19:34');

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
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  ADD CONSTRAINT `menu_item_stocks_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_item_stocks_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
