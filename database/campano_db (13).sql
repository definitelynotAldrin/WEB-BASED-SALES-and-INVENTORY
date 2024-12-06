-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 10:44 AM
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
  `account_username` varchar(255) NOT NULL,
  `account_password` varchar(255) NOT NULL,
  `user_role` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `security_code` varchar(11) DEFAULT NULL,
  `security_code_expiry` datetime DEFAULT NULL,
  `account_status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_username`, `account_password`, `user_role`, `email`, `date_time`, `reset_token_hash`, `reset_token_expires_at`, `security_code`, `security_code_expiry`, `account_status`) VALUES
(1, 'user_admin', '123', 'user_admin', 'always.rainnn@gmail.com', '2024-12-05 22:17:02', NULL, NULL, NULL, NULL, 'active'),
(2, 'user_service', '123', 'user_service', 'always.rainnn@gmail.com', '2024-12-01 22:51:38', NULL, NULL, NULL, NULL, 'active'),
(3, 'user_kitchen', '123', 'user_kitchen', 'always.rainnn@gmail.com', '2024-12-01 22:51:46', NULL, NULL, NULL, NULL, 'active'),
(4, 'camps', '123', 'user_admin', '', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(5, 'jhon doe', '$2y$10$acMa2v5DSApiLHSWLlv/2.UjjKFgYRS.z/ZR5QXmoiSg0EsdVwiHi', 'user_admin', 'johndoe@gmail.com', '2024-12-05 22:01:28', NULL, NULL, '21808983963', '2024-12-05 22:31:28', 'active'),
(6, 'joe', '$2y$10$78vlyElWQ3Lc6oAuX1XP0e6TTV0EZC2Sda0.o2OuWkrJmTcanJ.2.', 'user_service', 'admin@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(7, 'campo', '$2y$10$LoAqbZBJjT1StmQNiz0nBO8xeJtohHDW2uIHcpb5Vt7mVYmHiLZbu', 'user_admin', 'aldrincanunayon18@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(8, '123', '$2y$10$aGCmFxQkbYodV1PbA5/rQu01MrSqdEcy0Dz5CbBQl7CMPLWnc6f7e', 'user_kitchen', 'aldrincanunayon18@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(9, 'kitchen god2', '$2y$10$e1mbSRlCn.pY6zgqbhKROeCyNLPHlrtw3xPjV0mdvPs/nhJoF/RHK', 'user_kitchen', 'aldrincans17@gmail.comc', '2024-11-30 21:47:25', NULL, NULL, NULL, NULL, 'active'),
(10, '123123', '$2y$10$To3HvkiA7A7bElt9B.D.EuCSTuP2MtHE4Yls7LQCHgLPV3BTatmd2', 'user_service', 'aldrincanunayon18@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(11, 'kitchen god3', '$2y$10$ieQcFLB1XUgK6trjkxvZVO19gYY/fiu1QxB0ETRNefg2VrmAM5jKS', 'user_kitchen', 'aldrincanunayon18@gmail.com', '2024-11-29 21:12:16', 'db2d9d4867c30a7abcfa6cf11bc1f7174e55179469f373ca7841f2f8aa567983', '2024-11-29 14:42:16', NULL, NULL, 'active'),
(12, 'kitchen god4', '$2y$10$PIQk7uualzyaiEwfeM.DBOlJ0Sbmst6JvCvDBBTHc3d0j471OZRqy', 'user_kitchen', 'aldrincanunayon18@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(13, 'kitchen god5', '$2y$10$RbdNuorRVCxzCUAAwwn.ueVSq9pYy.lO4yUtMlx4CzzieTDzmotcG', 'user_kitchen', 'aldrincanunayon18@gmail.com', '2024-12-01 22:52:09', NULL, NULL, NULL, NULL, 'active'),
(14, 'kitchen gods6', '$2y$10$VDJVPUi3F4C9OTaQp/4aP.1BiC2TRNfLa6zsiqbeWMj6b3zaLqJ8a', 'user_kitchen', 'aldrincanunayon18@gmail.com', '2024-12-01 22:52:00', NULL, NULL, NULL, NULL, 'active'),
(15, 'admin god', '$2y$10$Fk644PpCBWaGZob7Vr4EveVf6cN1iPDWIqHGZ5yl6mPmfsFaXKnGO', 'user_admin', 'aldrincanunayon18@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(16, 'admin god1', '$2y$10$M2/2FNArSsW8S9QnB2jqg.k3bST3w05toMwEHylLo7W2nM0XyoKuO', 'user_admin', 'aldrincanunayon18@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(17, 'admin god3', '$2y$10$2IlVxnmf3hujexInVshrlucmwPlXiV8eApows1VzejtWJbrU6Zfyy', 'user_admin', 'johndoe@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(18, 'admin god6', '$2y$10$iYyfEJ9yjcMAlNsSO2G8cubfd4L6L/XM.QWB8HsqT2fAlRM8l5JL.', 'user_admin', 'johndoe@gmail.com', '2024-12-01 19:16:08', NULL, NULL, '80843929688', '2024-12-01 19:46:08', 'active'),
(19, 'admingod', '$2y$10$OJJO.NThqxuLPkh6F7IuCOvcSM7cWy3UHNdTAw3wER2ReCKaCX2fy', 'user_admin', 'johndoe@gmail.com', '2024-11-26 10:42:18', NULL, NULL, NULL, NULL, 'active'),
(21, 'service god', '$2y$10$Uh8trO/7CUc2zByuiu244OHkm50k94jK9YWC1hedqxzjf7sO3MUR.', 'user_service', 'always.rainnn@gmail.com', '2024-12-03 14:00:33', 'd5cf80d1aaef5fa69b6ff6f1e7b2f3e2b08d0e3523162fc3b79ae252805736b5', '2024-11-30 01:01:57', NULL, NULL, 'inactive'),
(22, 'admin god11', '$2y$10$fC2JdkDfYZ5.UGXAzaqJduLVG1nrghdu2c5vp28.ZMP4uzS2fMbXq', 'user_admin', 'always.rainnn@gmail.com', '2024-12-01 20:19:16', NULL, NULL, '06288435121', '2024-12-01 20:49:16', 'inactive'),
(23, 'admin god12', '$2y$10$u4ciC.bn6d4sW.w/we76GuCkzABjrk7fg4xnO9Yn1i8dDLeKvqmtu', 'user_admin', 'always.rainnn@gmail.com', '2024-12-05 23:48:57', '0e925680fe11b60b7b1afb79deda815a772f8491a26230c639d5512fbd9d06cd', '2024-12-06 00:03:27', '93370619716', '2024-12-06 00:18:57', 'inactive'),
(24, 'admin god13', '$2y$10$gE/Loegu.rW/gXqOOOZxT.H/I4KeCZij3NczPLUciuPTw6aAVgqee', 'user_admin', 'always.rainnn@gmail.com', '2024-12-05 23:37:43', '0bf89b72ca03f257df1f21b8e2f320a77682a737e785da397682d950a446d0a0', '2024-12-06 00:07:43', '98261388262', '2024-12-05 22:49:19', 'active'),
(31, 'admin_god15', '$2y$10$Pc7SWSqN0cOb.qwLkPUM3eiRVyuhtD3X1mfbTGYLqW2wZGqVtxW4.', 'user_admin', 'always.rainnn@gmail.com', '2024-12-05 23:48:21', NULL, NULL, NULL, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `total_amount_spent` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `total_amount_spent`) VALUES
(1, 'jewl', '1905.00'),
(2, 'Samboy', '30375.00'),
(3, 'asdasda', '1635.00'),
(4, 'Kenjard', '13150.00'),
(5, 'Traxex', '1365.00'),
(6, 'Definitelynot Joel', '14025.00'),
(7, 'Joel', '11044.00'),
(8, 'none', '0.00'),
(9, 'john', '0.00'),
(10, 'asdasdaasd', '0.00'),
(11, 'busssq', '1343.00'),
(12, 'Jasoa', '75.00'),
(13, 'gyu', '75.00'),
(14, 'taro', '75.00'),
(15, 'asda', '75.00'),
(16, 'asdd', '2.00'),
(17, 'Rea', '840.00'),
(18, 'asdasdas', '0.00'),
(19, 'test', '0.00'),
(20, 'tesst', '0.00'),
(21, 'drow', '4755.00'),
(22, 'Samboya', '0.00'),
(23, 'fsdfasf', '220.00'),
(24, 'james', '1830.00'),
(25, 'Dan Ackerman', '3862.50'),
(26, ' ', '6322.50'),
(27, 'customer 1', '840.00'),
(28, 'Customer 2', '450.00'),
(29, 'tags', '1580.00'),
(30, 'customer', '1470.00'),
(31, 'trax', '840.00'),
(32, 'Aizen', '1330.00'),
(33, 'camps', '300.00'),
(34, 'tabang part', '300.00'),
(35, 'Emerson', '1100.00'),
(36, ' campano', '2052.50'),
(37, 'tabat', '660.00'),
(38, 'draw', '1420.00'),
(39, 'helly', '320.00'),
(40, 'coffe', '220.00'),
(41, 'asdasdd', '375.00'),
(42, 'Yes king', '1910.00'),
(43, 'ray', '175.00');

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
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `item_name`, `item_price`, `item_category`, `item_image`, `status`) VALUES
(46, 'Kinilaw', '880.00', 'Main Course', '7a3da125-3515-4aaf-a15b-1fabf4ec8408.jpg', 'active'),
(47, 'butter shrimp', '300.00', 'Main Course', '599655e8-9ae0-4ca8-83ad-d6b262678083.jpg', 'active'),
(48, 'Leche Plan', '245.00', 'Dessert', '../uploads/leche plan.jpg', 'active'),
(49, 'coke litro', '75.00', 'Beverages', 'coke 1 liter.jpg', 'active'),
(50, 'Sprite Litro', '75.00', 'Beverages', 'sprite.png', 'active'),
(51, 'Coke Mismo', '25.00', 'Beverages', '../uploads/coke mismo.png', 'active'),
(52, 'Royal litro', '75.00', 'Beverages', '../uploads/royal.jpg', 'active'),
(53, 'royal mismo', '25.00', 'Beverages', '../uploads/royal.jpg', 'active'),
(54, 'grilled bangus', '880.00', 'Main Course', 'fish haha.jpg', 'active'),
(55, 'kamatis', '5.00', 'Dessert', 'vege-banner.png', 'active'),
(56, 'Grilled Parrot Fish', '880.00', 'Main Course', '../uploads/whole-grilled-snapper-11-1024x683.jpg', 'active'),
(57, 'Adubong Pusit', '470.00', 'Main Course', '9d5fc9f8-7c43-4be5-a538-961bbe75ff21.jpg', 'active'),
(58, 'calamares', '470.00', 'Main Course', '15c63ff1-ecce-481f-bf16-5681d6cd5f85.jpg', 'active'),
(59, 'mango float', '180.00', 'Dessert', 'mango.jpg', 'active'),
(60, 'sinugbang Pusit', '450.00', 'Main Course', '7a76db2e-bf91-4169-87c0-21bfa68d85dd.jpg', 'active'),
(61, 'Sinugbang Mol-Mol', '880.00', 'Main Course', '../uploads/632eb977-bced-4472-ad3d-c2c8eaa6f452.jpg', 'active'),
(62, 'Adobong Tuway', '220.00', 'Main Course', '../uploads/6e658a0d-a81e-4e81-8275-47b8fd00f5cb.jpg', 'active'),
(63, 'Tinulang Mol-Mol', '880.00', 'Main Course', '../uploads/549f7bf0-327b-4d57-98ba-0c42d979e464.jpg', 'active'),
(64, 'Fried shrimp', '880.00', 'Main Course', '../uploads/shrimp.jpg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_stocks`
--

CREATE TABLE `menu_item_stocks` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity_required` decimal(10,2) NOT NULL DEFAULT 1.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_stocks`
--

INSERT INTO `menu_item_stocks` (`id`, `menu_item_id`, `stock_id`, `quantity_required`, `created_at`) VALUES
(187, 50, 13, '1.00', '2024-09-12 22:22:43'),
(194, 51, 14, '1.00', '2024-09-18 23:55:39'),
(207, 52, 4, '1.00', '2024-09-24 03:32:47'),
(249, 55, 22, '1.00', '2024-10-20 00:29:34'),
(252, 48, 24, '1.00', '2024-10-21 01:45:35'),
(258, 61, 2, '1.00', '2024-11-07 14:35:20'),
(259, 59, 24, '1.00', '2024-11-07 14:40:11'),
(267, 62, 25, '1.00', '2024-11-07 14:50:10'),
(268, 63, 26, '1.00', '2024-11-07 14:52:17'),
(269, 60, 8, '1.00', '2024-11-07 14:56:39'),
(274, 53, 27, '1.00', '2024-11-08 00:34:06'),
(275, 56, 2, '1.00', '2024-11-08 01:32:18'),
(276, 57, 8, '1.00', '2024-11-08 01:33:02'),
(277, 58, 8, '1.00', '2024-11-08 01:34:57'),
(278, 47, 1, '1.00', '2024-11-08 01:41:04'),
(279, 54, 7, '1.00', '2024-11-08 06:11:00'),
(280, 64, 1, '1.00', '2024-11-08 06:31:55'),
(281, 46, 2, '1.00', '2024-11-21 13:27:55'),
(290, 49, 9, '1.00', '2024-12-06 08:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `menu_order_count`
--

CREATE TABLE `menu_order_count` (
  `item_id` int(11) NOT NULL,
  `order_count` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_order_count`
--

INSERT INTO `menu_order_count` (`item_id`, `order_count`) VALUES
(46, '23.00'),
(47, '40.50'),
(48, '29.00'),
(49, '15.00'),
(50, '18.00'),
(51, '39.00'),
(52, '46.00'),
(53, '22.00'),
(54, '11.50'),
(55, '11.00'),
(56, '10.50'),
(57, '31.75'),
(58, '30.75'),
(59, '6.00'),
(60, '0.25'),
(61, '1.75'),
(63, '4.25'),
(64, '0.25');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_role` varchar(250) NOT NULL,
  `username` varchar(255) NOT NULL,
  `text_message` text NOT NULL,
  `message_date` date DEFAULT curdate(),
  `message_time` time DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_role`, `username`, `text_message`, `message_date`, `message_time`) VALUES
(1, '', 'user_admin', 'borbs', '2024-11-08', '04:31:31'),
(2, '', 'user_admin', 'fasdsfasf', '2024-11-08', '04:44:17'),
(3, '', 'user_admin', 'adasdasda', '2024-11-08', '04:44:19'),
(4, '', 'user_kitchen', 'asdas', '2024-11-08', '04:48:16'),
(5, '', 'user_admin', 'qwewq', '2024-11-08', '04:48:33'),
(6, '', 'user_admin', 'ge', '2024-11-08', '04:55:58'),
(7, '', 'user_admin', 'asdasd', '2024-11-08', '04:59:48'),
(8, '', 'user_admin', 'adasd', '2024-11-08', '04:59:54'),
(9, '', 'user_admin', 'jeol love marla', '2024-11-08', '05:03:17'),
(10, '', 'user_kitchen', 'otenasdas', '2024-11-08', '05:04:08'),
(11, '', 'user_kitchen', 'ok', '2024-11-08', '05:09:02'),
(12, '', 'user_admin', 'asdasd', '2024-11-08', '05:53:51'),
(13, '', 'user_service', 'hahahaha', '2024-11-08', '07:41:41'),
(14, '', 'user_service', 'wow', '2024-11-08', '12:26:10'),
(15, '', 'user_service', 'as', '2024-11-08', '12:26:22'),
(16, '', 'user_service', 'kol', '2024-11-08', '12:27:32'),
(17, '', 'user_kitchen', 'fsdfsdf', '2024-11-08', '14:53:08'),
(18, '', 'user_kitchen', 'hey', '2024-11-13', '20:07:20'),
(19, '', 'user_admin', 'hello', '2024-11-13', '20:15:57'),
(20, '', 'user_admin', 'hey', '2024-11-13', '20:16:42'),
(21, '', 'user_admin', 'okay', '2024-11-13', '20:17:29'),
(22, '', 'user_admin', '345', '2024-11-13', '20:22:22'),
(23, '', 'user_admin', 'you', '2024-11-13', '20:22:46'),
(24, '', 'user_admin', '123', '2024-11-13', '20:23:09'),
(25, '', 'user_admin', 'yes', '2024-11-18', '06:03:10'),
(26, '', 'user_admin', 'asdasd', '2024-11-19', '09:00:50'),
(27, '', 'user_admin', 'haha', '2024-11-28', '11:04:55'),
(28, '', 'admin god', 'Hi', '2024-11-28', '11:10:10'),
(29, '', 'admin god', 'okay', '2024-11-28', '11:11:07'),
(30, '', 'admin god3', 'yessir', '2024-11-28', '11:11:47'),
(31, 'user_admin', 'admin god3', 'joel love marla', '2024-11-28', '11:31:24'),
(32, 'user_admin', 'admin god3', '12', '2024-11-28', '11:32:51'),
(33, 'user_admin', 'admin god', 'okay', '2024-11-28', '11:37:41'),
(34, 'user_admin', 'admin god', 'asdasd', '2024-11-28', '11:40:00'),
(35, 'user_admin', 'admin god', 'asd', '2024-11-28', '11:40:06'),
(36, 'user_admin', 'admin god', '123', '2024-11-28', '11:40:56'),
(37, 'user_admin', 'admin god', '123', '2024-11-28', '11:41:26'),
(38, 'user_admin', 'admin god', 'asdasd', '2024-11-28', '11:41:59'),
(39, 'user_admin', 'admin god', 'okay', '2024-11-29', '07:34:05'),
(40, 'user_admin', 'admin god', '123', '2024-11-29', '07:35:22'),
(41, 'user_admin', 'admin god', '123', '2024-11-29', '07:36:45'),
(42, 'user_admin', 'admin god11', 'okay', '2024-11-30', '08:56:36'),
(43, 'user_admin', 'admin god11', 'Joel love marla', '2024-11-30', '18:23:22'),
(44, 'user_admin', 'admin god10', 'haha', '2024-11-30', '18:24:00'),
(45, 'user_admin', 'admin god10', 'okay', '2024-12-01', '09:25:59'),
(46, 'user_admin', 'admin god13', 'erm, what a sigma!', '2024-12-01', '21:06:05'),
(47, 'user_admin', 'admin god', 'skibidi', '2024-12-03', '08:13:14'),
(48, 'user_admin', 'admin_god14', 'okay', '2024-12-03', '14:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `customer_note` text DEFAULT NULL,
  `customer_table` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'pending',
  `recent_status` varchar(50) NOT NULL,
  `order_date` date NOT NULL DEFAULT curdate(),
  `order_time` time NOT NULL DEFAULT curtime(),
  `table_status` tinyint(1) DEFAULT 0,
  `payment_status` varchar(50) DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `username`, `customer_note`, `customer_table`, `total_amount`, `order_status`, `recent_status`, `order_date`, `order_time`, `table_status`, `payment_status`) VALUES
(148, 'Joel', NULL, 'asd', 10, '210.00', 'served', '', '2024-10-26', '06:18:06', 0, 'paid'),
(149, 'jewl', NULL, 'Brns\n\n \n\n ', 9, '735.00', 'served', '', '2024-10-26', '06:30:43', 0, 'paid'),
(150, 'Samboy', NULL, 'asd', 11, '420.00', 'served', '', '2024-10-26', '08:28:42', 0, 'paid'),
(151, 'joel', NULL, ' ', 6, '2.00', 'served', '', '2024-10-26', '08:35:21', 0, 'paid'),
(152, 'asdasd', NULL, ' ', 8, '420.00', 'served', '', '2024-10-26', '08:40:18', 0, 'paid'),
(153, 'adsaad', NULL, 'Brns', 4, '25.00', 'served', '', '2024-10-26', '08:54:17', 0, 'paid'),
(154, 'asdasda', NULL, 'Bussss', 0, '245.00', 'served', '', '2024-10-26', '10:44:21', 0, 'paid'),
(155, 'busssq', NULL, 'asd', 7, '75.00', 'served', '', '2024-10-26', '10:56:48', 0, 'paid'),
(156, 'asdasdasd', NULL, ' ', 1, '2.00', 'served', '', '2024-10-26', '10:59:13', 0, 'paid'),
(157, 'busssq', NULL, 'Brns', 5, '3360.00', 'served', '', '2024-10-26', '11:17:19', 0, 'paid'),
(158, 'Samboy', NULL, 'asdasd', 1, '150.00', 'prepare', '', '2024-10-26', '12:16:05', 1, 'paid'),
(159, 'Samboy', NULL, 'asdas', 8, '840.00', 'prepare', '', '2024-10-26', '13:39:18', 1, 'paid'),
(160, 'busssq', NULL, ' ', 6, '840.00', 'prepare', '', '2024-10-26', '21:12:12', 1, 'paid'),
(161, 'busssqasd', NULL, 'asdasd', 7, '245.00', 'prepare', '', '2024-10-26', '21:12:54', 1, 'paid'),
(162, 'asdasda', NULL, 'asdasd\n\n \n\n \n\n ', 1, '980.00', 'served', '', '2024-10-28', '07:37:57', 1, 'paid'),
(163, 'Koel', NULL, 'asdsada\n\n \n\n ', 2, '2100.00', 'served', '', '2024-10-28', '08:54:46', 1, 'unpaid'),
(164, 'Bodrnhs', NULL, ' ', 3, '880.00', 'served', '', '2024-10-28', '09:04:28', 1, 'paid'),
(165, 'asdasda a', NULL, 'yes\n\n \n\n ', 4, '540.00', 'served', '', '2024-10-28', '09:07:29', 1, 'paid'),
(166, 'asdasda', NULL, ' ', 9, '1120.00', 'process', '', '2024-10-28', '14:57:24', 1, 'paid'),
(167, 'assadasdas', NULL, 'asd', 0, '840.00', 'process', '', '2024-10-28', '15:16:43', 1, 'paid'),
(168, 'asdasd', NULL, ' ', 0, '245.00', 'process', '', '2024-10-28', '20:37:01', 1, 'paid'),
(169, 'Jewl', NULL, 'asdasdas\n\n asd\n\n \n\n \n\n   \n\n \n\n \n\n ', 1, '5280.00', 'prepare', '', '2024-10-29', '08:17:06', 1, 'unpaid'),
(174, 'Samboy', NULL, 'asdasd\n \n ', 7, '445.00', 'served', '', '2024-10-30', '05:23:45', 0, 'paid'),
(175, 'Kenjard', NULL, ' \n ', 8, '215.00', 'served', '', '2024-10-30', '05:33:22', 0, 'paid'),
(176, 'Kenjard', NULL, ' ', 0, '220.00', 'served', '', '2024-10-30', '05:33:54', 0, 'paid'),
(177, 'kenjard', NULL, ' ', 0, '220.00', 'served', '', '2024-10-30', '05:34:26', 0, 'paid'),
(178, 'Traxex', NULL, ' \n \n ', 5, '890.00', 'served', '', '2024-10-30', '05:54:14', 0, 'paid'),
(179, 'Kenjard', NULL, 'mahalin mo naman ako kahit one time', 2, '840.00', 'served', '', '2024-10-30', '10:43:33', 1, 'paid'),
(182, 'Samboy', NULL, ' \nBussss\nadsasdasd', 1, '13200.00', 'served', '', '2024-10-31', '05:25:12', 0, 'paid'),
(187, 'jewl', NULL, ' ', 0, '6870.00', 'served', '', '2024-10-31', '07:22:16', 0, 'paid'),
(188, 'Definitelynot Joel', NULL, 'mahalin mo naman ako kahit one time', 2, '14025.00', 'served', '', '2024-10-31', '07:29:46', 0, 'paid'),
(189, 'Traxex', NULL, 'sadasd', 0, '2640.00', 'prepare', '', '2024-10-31', '10:37:17', 0, 'unpaid'),
(190, 'Joel', NULL, ' ', 1, '1760.00', 'served', '', '2024-10-31', '11:03:27', 1, 'unpaid'),
(197, 'Samboy', NULL, 'Bussss\n ', 8, '955.00', 'served', '', '2024-11-02', '04:57:31', 0, 'paid'),
(198, 'busssq', NULL, 'asdasd', 2, '50.00', 'served', '', '2024-11-02', '08:56:02', 1, 'paid'),
(199, 'jewl', NULL, 'asdasdasd', 9, '25.00', 'served', '', '2024-11-02', '10:20:13', 1, 'paid'),
(200, 'Samboy', NULL, 'adsa', 11, '25.00', 'served', '', '2024-11-03', '05:09:42', 0, 'paid'),
(201, 'jewl', NULL, 'asd', 1, '75.00', 'served', '', '2024-11-03', '05:24:02', 0, 'paid'),
(202, 'Samboy', NULL, 'ad', 10, '50.00', 'served', '', '2024-11-03', '05:28:09', 0, 'paid'),
(203, 'Joel', NULL, 'asdasd', 9, '150.00', 'served', '', '2024-11-03', '09:04:40', 0, 'paid'),
(204, 'kenjard', NULL, 'asdsa', 0, '75.00', 'served', '', '2024-11-03', '09:25:36', 0, 'paid'),
(205, 'Jasoa', NULL, 'sdasd', 0, '75.00', 'served', '', '2024-11-03', '09:25:47', 0, 'paid'),
(206, 'gyu', NULL, 'asd', 0, '75.00', 'served', '', '2024-11-03', '09:40:17', 0, 'paid'),
(207, 'taro', NULL, 'asd', 0, '75.00', 'served', '', '2024-11-03', '09:40:31', 0, 'paid'),
(208, 'jewl', NULL, 'asdasd', 8, '25.00', 'served', '', '2024-11-03', '09:49:49', 0, 'paid'),
(210, 'Samboy', NULL, 'Bussss', 7, '150.00', 'served', '', '2024-11-03', '20:19:08', 1, 'paid'),
(211, 'asdasda', NULL, 'asdasd', 0, '50.00', 'served', '', '2024-11-03', '20:52:03', 1, 'paid'),
(212, 'Joel', NULL, 'sadasd', 0, '125.00', 'served', '', '2024-11-03', '21:03:50', 1, 'paid'),
(213, 'Kenjard', NULL, 'asdsd', 9, '100.00', 'served', '', '2024-11-03', '21:05:29', 1, 'paid'),
(214, 'busssq', NULL, 'asdsad', 10, '152.00', 'served', '', '2024-11-03', '21:08:42', 1, 'paid'),
(215, 'busssq', NULL, 'asdasd', 0, '52.00', 'served', '', '2024-11-03', '22:13:44', 1, 'paid'),
(216, 'Samboy', NULL, 'asd', 0, '150.00', 'served', '', '2024-11-03', '22:18:21', 1, 'paid'),
(217, 'Samboy', NULL, 'mahalin mo naman ako kahit one time', 3, '1964.00', 'served', '', '2024-11-03', '22:50:18', 1, 'paid'),
(218, 'Samboy', NULL, 'asdasd', 11, '1680.00', 'served', '', '2024-11-04', '16:59:52', 1, 'paid'),
(219, 'Samboy', NULL, 'Bussss', 1, '630.00', 'served', '', '2024-11-05', '07:37:47', 0, 'paid'),
(220, 'Kenjard', NULL, ' ', 2, '150.00', 'served', '', '2024-11-05', '07:49:04', 0, 'paid'),
(221, 'Joel', NULL, ' ', 0, '300.00', 'served', '', '2024-11-05', '07:49:28', 0, 'paid'),
(222, 'Samboy', NULL, 'asd', 10, '2.00', 'served', '', '2024-11-05', '07:49:49', 0, 'paid'),
(223, 'Samboy', NULL, 'asd', 0, '75.00', 'served', '', '2024-11-05', '08:02:47', 0, 'paid'),
(224, 'Joel', NULL, 'aasdas', 8, '2100.00', 'served', '', '2024-11-05', '21:24:19', 0, 'paid'),
(225, 'busssq', NULL, 'asdasdasdasd', 2, '840.00', 'served', '', '2024-11-05', '21:27:11', 1, 'paid'),
(226, 'busssq', NULL, 'Bussss', 4, '5.00', 'served', '', '2024-11-06', '06:28:16', 0, 'paid'),
(227, 'Samboy', NULL, 'asdas', 10, '880.00', 'served', '', '2024-11-06', '07:03:42', 0, 'paid'),
(228, 'Samboy', NULL, 'asdasd', 7, '630.00', 'served', '', '2024-11-06', '07:04:05', 0, 'paid'),
(229, 'Joel', NULL, 'Bussss', 0, '75.00', 'served', '', '2024-11-06', '07:12:40', 0, 'paid'),
(230, 'Jewl', NULL, 'Bussss', 0, '2.00', 'served', '', '2024-11-06', '07:12:52', 0, 'paid'),
(231, 'busssq', NULL, 'asdasd', 0, '2.00', 'served', '', '2024-11-06', '07:24:38', 0, 'paid'),
(232, 'Samboy', NULL, 'asd', 0, '75.00', 'served', '', '2024-11-06', '07:25:07', 0, 'paid'),
(233, 'Samboy', NULL, 'a', 0, '75.00', 'served', '', '2024-11-06', '07:26:34', 0, 'paid'),
(234, 'Joel', NULL, 'asd', 0, '2.00', 'served', '', '2024-11-06', '07:26:45', 0, 'paid'),
(235, 'Samboy', NULL, ' ', 0, '880.00', 'served', '', '2024-11-06', '07:30:04', 0, 'paid'),
(236, 'jewl', NULL, 'asd', 11, '75.00', 'served', '', '2024-11-06', '07:32:01', 0, 'paid'),
(237, 'asda', NULL, 'asdasd', 9, '75.00', 'served', '', '2024-11-06', '07:32:56', 0, 'paid'),
(238, 'asdasda', NULL, ' ', 0, '75.00', 'served', '', '2024-11-06', '07:46:34', 0, 'paid'),
(239, 'Samboy', NULL, ' ', 0, '2.00', 'served', '', '2024-11-06', '07:46:52', 0, 'paid'),
(240, 'Joel', NULL, ' ', 0, '2.00', 'served', '', '2024-11-06', '07:49:35', 0, 'paid'),
(241, 'Kenjard', NULL, 'asd', 8, '210.00', 'served', '', '2024-11-06', '07:53:55', 0, 'paid'),
(242, 'Samboy', NULL, 'adsasd', 11, '75.00', 'served', '', '2024-11-06', '08:01:46', 0, 'paid'),
(243, 'jewl', NULL, ' ', 0, '2.00', 'served', '', '2024-11-06', '08:01:54', 1, 'paid'),
(244, 'Joel', NULL, ' ', 0, '75.00', 'served', '', '2024-11-06', '08:02:03', 1, 'paid'),
(245, 'Samboy', NULL, '  ', 0, '152.00', 'served', '', '2024-11-06', '08:05:05', 1, 'paid'),
(246, 'busssq', NULL, 'asd', 0, '75.00', 'served', '', '2024-11-06', '08:12:43', 1, 'paid'),
(247, 'Samboy', NULL, 'asd\n ', 0, '845.00', 'served', '', '2024-11-06', '08:12:51', 1, 'paid'),
(248, 'asdd', NULL, ' ', 0, '2.00', 'served', '', '2024-11-06', '08:12:59', 1, 'paid'),
(249, 'Rea', NULL, 'dasdas', 10, '840.00', 'served', '', '2024-11-06', '08:57:02', 0, 'paid'),
(250, 'busssq', NULL, 'asdaasdsads\n ', 0, '7.00', 'served', '', '2024-11-06', '08:58:54', 1, 'paid'),
(251, 'Samboy', NULL, 'mahalin mo naman ako kahit one time', 0, '840.00', 'served', '', '2024-11-06', '10:08:28', 1, 'paid'),
(252, 'Samboy', NULL, 'asdsa', 6, '1680.00', 'served', '', '2024-11-06', '13:15:25', 0, 'paid'),
(253, 'Kenjard', NULL, ' ', 0, '11120.00', 'served', '', '2024-11-06', '13:16:35', 1, 'paid'),
(254, 'Samboy', NULL, 'asdasdas', 9, '2.00', 'served', '', '2024-11-06', '19:37:17', 0, 'paid'),
(260, 'Jewl', NULL, ' \n \n \nasdasda\n \nasdasd\n \n \n \n \n \n \n \n \n \n \n ', 0, '657.00', 'served', 'served', '2024-11-06', '21:06:51', 1, 'unpaid'),
(280, 'Traxex', NULL, ' \n \n \n \n \n \n \n ', 0, '885.00', 'served', 'process', '2024-11-07', '06:15:50', 1, 'paid'),
(282, 'samboy', NULL, '', 9, '665.00', 'served', '', '2024-11-07', '22:14:55', 0, 'paid'),
(283, 'fsdfasf', NULL, 'sadvbcv', 7, '220.00', 'served', '', '2024-11-07', '22:16:38', 0, 'paid'),
(284, 'james', NULL, 'no onions no msg', 1, '1830.00', 'served', '', '2024-11-07', '23:09:18', 0, 'paid'),
(285, 'drow', NULL, '', 5, '360.00', 'served', '', '2024-11-07', '23:23:07', 0, 'paid'),
(286, 'Dan Ackerman', NULL, 'No garlic', 3, '3862.50', 'served', '', '2024-11-07', '23:31:14', 0, 'paid'),
(287, ' ', NULL, '\n', 12, '4620.00', 'served', 'prepare', '2024-11-07', '23:40:11', 0, 'paid'),
(288, 'customer 1', NULL, '', 1, '840.00', 'served', '', '2024-11-07', '23:54:19', 1, 'paid'),
(289, 'Customer 2', NULL, '', 2, '450.00', 'served', '', '2024-11-07', '23:54:34', 1, 'paid'),
(291, 'customer', NULL, '', 9, '1470.00', 'served', '', '2024-11-08', '01:42:34', 0, 'paid'),
(294, 'drow', NULL, '', 7, '245.00', 'served', '', '2024-11-08', '03:29:31', 0, 'paid'),
(295, 'tags', NULL, 'asd', 0, '245.00', 'served', '', '2024-11-08', '07:32:04', 1, 'paid'),
(296, 'trax', NULL, '', 4, '840.00', 'prepare', '', '2024-11-08', '07:33:29', 0, 'unpaid'),
(297, 'Aizen', NULL, '\n', 12, '1330.00', 'served', 'prepare', '2024-11-08', '07:40:21', 0, 'paid'),
(299, 'camps', NULL, '', 10, '300.00', 'served', '', '2024-11-08', '09:49:23', 0, 'paid'),
(300, 'tabang part', NULL, '', 0, '300.00', 'served', '', '2024-11-08', '09:53:56', 1, 'paid'),
(301, 'Emerson', NULL, '', 1, '1100.00', 'served', '', '2024-11-08', '12:19:55', 0, 'paid'),
(302, ' campano', NULL, '\n\n', 20, '1420.00', 'served', 'served', '2024-11-08', '14:40:31', 0, 'paid'),
(304, ' campano', NULL, 'no\n\n', 16, '632.50', 'prepare', 'prepare', '2024-11-13', '20:01:46', 1, 'unpaid'),
(305, 'Samboy', 'camps', 'asdasd', 10, '220.00', 'served', '', '2024-11-21', '13:13:07', 1, 'paid'),
(306, 'Traxex', 'camps', '', 18, '245.00', 'served', '', '2024-11-21', '19:58:03', 1, 'paid'),
(307, 'drow', 'camps', 'mahalin mo naman ako kahit one time', 7, '880.00', 'prepare', '', '2024-11-21', '21:28:18', 1, 'unpaid'),
(308, 'Joel', 'user_admin', '', 12, '3520.00', 'served', '', '2024-11-23', '07:56:10', 0, 'paid'),
(309, 'Joel', 'user_admin', '\nasdasd\n\nasd', 13, '1475.00', 'served', 'prepare', '2024-11-23', '09:51:57', 1, 'paid'),
(310, 'Samboy', 'user_admin', '\n', 16, '50.00', 'served', 'prepare', '2024-11-23', '09:58:33', 1, 'paid'),
(311, 'asdasda', 'user_admin', 'Bussss', 1, '75.00', 'prepare', '', '2024-11-23', '10:06:49', 1, 'unpaid'),
(312, 'Joel', 'user_admin', ' \n', 15, '150.00', 'prepare', 'prepare', '2024-11-23', '10:07:23', 1, 'unpaid'),
(313, 'jewl', 'user_admin', '\n\nd\n\n\n', 10, '765.00', 'prepare', 'prepare', '2024-11-23', '10:15:53', 1, 'unpaid'),
(314, 'draw', 'user_admin', '\n\n', 8, '370.00', 'prepare', 'prepare', '2024-11-23', '10:39:29', 1, 'unpaid'),
(315, 'asdasda', 'user_admin', ' ', 17, '440.00', 'served', '', '2024-11-24', '21:38:24', 1, 'paid'),
(316, 'Samboy', 'user_admin', '', 0, '300.00', 'served', '', '2024-11-25', '08:03:59', 1, 'paid'),
(317, 'Jewl', 'user_admin', 'Bussss\n\n\n\nhahah\nhello\nhello\nhello\nasd\n', 5, '600.00', 'served', 'prepare', '2024-11-25', '08:29:44', 1, 'paid'),
(318, 'Samboy', 'user_admin', '', 0, '150.00', 'served', '', '2024-11-25', '08:48:07', 1, 'paid'),
(319, 'busssq', 'user_admin', '', 0, '450.00', 'served', '', '2024-11-25', '08:50:36', 1, 'unpaid'),
(320, 'asdasda', 'user_admin', '', 0, '245.00', 'prepare', '', '2024-11-25', '08:51:00', 1, 'unpaid'),
(321, 'drow', 'user_admin', '', 8, '660.00', 'prepare', '', '2024-11-25', '08:52:05', 1, 'unpaid'),
(322, 'asdasda', 'user_admin', 'Bussss\n', 14, '515.00', 'prepare', 'prepare', '2024-11-25', '09:06:30', 1, 'unpaid'),
(323, 'helly', 'user_admin', '\n', 6, '320.00', 'prepare', 'prepare', '2024-11-25', '09:25:49', 1, 'unpaid'),
(324, 'coffe', 'user_admin', '', 7, '220.00', 'prepare', '', '2024-11-25', '09:29:14', 1, 'unpaid'),
(325, 'Joel', 'admin god', 'asdasd\n\nasdasd', 9, '1310.00', 'served', 'prepare', '2024-11-26', '21:42:39', 1, 'credit'),
(326, 'busssq', 'admin god', 'Bussss\n', 11, '75.00', 'served', 'prepare', '2024-11-26', '21:46:58', 1, 'paid'),
(327, 'busssq', 'admin god', '', 12, '440.00', 'served', '', '2024-11-27', '06:19:30', 1, 'unpaid'),
(328, '', 'admin god', '', 8, '25.00', 'served', '', '2024-11-28', '08:23:43', 0, 'paid'),
(329, 'Samboy', 'admin god', '', 11, '880.00', 'served', '', '2024-11-28', '10:10:36', 0, 'paid'),
(330, 'Samboy', 'admin god', '', 10, '880.00', 'served', '', '2024-11-28', '10:10:59', 0, 'paid'),
(331, 'draw', 'admin god', 'mahalin mo naman ako kahit one time\nasdasd\n\n\n', 7, '1050.00', 'prepare', 'prepare', '2024-11-28', '12:35:10', 1, 'unpaid'),
(332, 'busssq', 'admin god', '', 12, '75.00', 'prepare', '', '2024-11-28', '12:36:23', 1, 'unpaid'),
(333, 'Samboy', 'admin god', '', 11, '75.00', 'prepare', '', '2024-11-28', '12:37:57', 1, 'unpaid'),
(334, 'asdasdd', 'admin god', '\n', 8, '375.00', 'prepare', 'prepare', '2024-11-28', '12:38:16', 1, 'unpaid'),
(335, 'Samboy', 'admin god', '\n', 9, '520.00', 'prepare', 'prepare', '2024-11-28', '12:39:13', 1, 'unpaid'),
(336, 'Samboy', 'admin god', '', 10, '300.00', 'prepare', '', '2024-11-28', '12:41:20', 1, 'unpaid'),
(337, 'Jewl', 'admin god', '', 5, '490.00', 'prepare', '', '2024-11-28', '12:41:48', 1, 'unpaid'),
(338, 'Samboy', 'admin god', '231\n', 6, '125.00', 'prepare', 'prepare', '2024-11-28', '12:44:43', 1, 'unpaid'),
(339, 'Jewl', 'admin god', '', 13, '50.00', 'prepare', '', '2024-11-28', '12:45:14', 1, 'unpaid'),
(340, 'asdasda', 'admin_god15', 'mahalin mo naman ako kahit one time', 14, '25.00', 'served', '', '2024-12-05', '14:42:57', 1, 'paid'),
(341, 'Samboy', 'admin_god15', '', 12, '3520.00', 'served', '', '2024-12-05', '14:43:06', 1, 'credit'),
(342, 'Samboy', 'admin_god15', 'Bussss', 10, '25.00', 'served', '', '2024-12-05', '14:43:33', 1, 'credit'),
(343, 'Yes king', 'service_god0', '', 11, '1910.00', 'served', '', '2024-12-05', '14:52:29', 1, 'credit'),
(344, 'Drow', 'service_god0', '', 7, '440.00', 'served', '', '2024-12-05', '14:52:51', 1, 'paid'),
(345, 'ray', 'service_god0', '', 9, '100.00', 'served', '', '2024-12-05', '14:55:48', 1, 'credit'),
(346, '', 'admin_god15', '', 9, '490.00', 'prepare', '', '2024-12-06', '17:36:18', 1, 'unpaid'),
(347, 'Samboy', 'admin_god15', '\n\n', 10, '1015.00', 'prepare', 'prepare', '2024-12-06', '17:36:27', 1, 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_item_stock_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `order_item_status` varchar(50) NOT NULL,
  `created_at` date NOT NULL DEFAULT curdate(),
  `time_created` time NOT NULL DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `menu_item_stock_id`, `quantity`, `menu_price`, `sub_total`, `order_item_status`, `created_at`, `time_created`) VALUES
(192, 148, 46, '0.25', '840.00', '210.00', 'served', '2024-10-26', '20:31:15'),
(193, 149, 48, '1.00', '245.00', '245.00', 'served', '2024-10-26', '20:31:15'),
(194, 149, 48, '1.00', '245.00', '245.00', 'served', '2024-10-26', '20:31:15'),
(195, 149, 48, '1.00', '245.00', '245.00', 'served', '2024-10-26', '20:31:15'),
(196, 150, 46, '0.50', '840.00', '420.00', 'served', '2024-10-26', '20:31:15'),
(197, 151, 53, '1.00', '2.00', '2.00', 'served', '2024-10-26', '20:31:15'),
(198, 152, 46, '0.50', '840.00', '420.00', 'served', '2024-10-26', '20:31:15'),
(199, 153, 51, '1.00', '25.00', '25.00', 'served', '2024-10-26', '20:31:15'),
(200, 154, 48, '1.00', '245.00', '245.00', 'served', '2024-10-26', '20:31:15'),
(201, 155, 50, '1.00', '75.00', '75.00', 'served', '2024-10-26', '20:31:15'),
(202, 156, 53, '1.00', '2.00', '2.00', 'served', '2024-10-26', '20:31:15'),
(203, 157, 46, '4.00', '840.00', '3360.00', 'served', '2024-10-26', '20:31:15'),
(204, 158, 52, '2.00', '75.00', '150.00', 'prepare', '2024-10-26', '20:31:15'),
(205, 159, 46, '1.00', '840.00', '840.00', 'prepare', '2024-10-26', '20:31:15'),
(206, 160, 46, '1.00', '840.00', '840.00', 'prepare', '2024-10-26', '20:31:15'),
(207, 161, 48, '1.00', '245.00', '245.00', 'prepare', '2024-10-26', '20:31:15'),
(208, 162, 48, '1.00', '245.00', '245.00', 'served', '2024-10-28', '20:31:15'),
(209, 162, 48, '1.00', '245.00', '245.00', 'served', '2024-10-28', '20:31:15'),
(210, 163, 47, '1.00', '840.00', '840.00', 'served', '2024-10-28', '20:31:15'),
(211, 164, 54, '1.00', '880.00', '880.00', 'served', '2024-10-28', '20:31:15'),
(212, 165, 51, '2.00', '25.00', '50.00', 'served', '2024-10-28', '20:31:15'),
(213, 165, 48, '1.00', '245.00', '245.00', 'served', '2024-10-28', '20:31:15'),
(214, 165, 48, '1.00', '245.00', '245.00', 'served', '2024-10-28', '20:31:15'),
(215, 162, 48, '1.00', '245.00', '245.00', 'served', '2024-10-28', '20:31:15'),
(216, 162, 48, '1.00', '245.00', '245.00', 'served', '2024-10-28', '20:31:15'),
(217, 163, 47, '1.00', '840.00', '840.00', 'served', '2024-10-28', '20:31:15'),
(218, 163, 47, '0.50', '840.00', '420.00', 'served', '2024-10-28', '20:31:15'),
(219, 166, 48, '2.00', '245.00', '490.00', 'process', '2024-10-28', '20:31:15'),
(220, 166, 46, '0.75', '840.00', '630.00', 'process', '2024-10-28', '20:31:15'),
(221, 167, 47, '1.00', '840.00', '840.00', 'process', '2024-10-28', '20:31:15'),
(222, 168, 48, '1.00', '245.00', '245.00', 'process', '2024-10-28', '20:31:15'),
(223, 169, 47, '1.00', '840.00', '840.00', 'prepare', '2024-10-29', '20:31:15'),
(224, 169, 47, '2.00', '840.00', '1680.00', 'prepare', '2024-10-29', '20:31:15'),
(225, 169, 47, '0.25', '840.00', '210.00', 'prepare', '2024-10-29', '20:31:15'),
(226, 169, 54, '0.50', '880.00', '440.00', 'prepare', '2024-10-29', '20:31:15'),
(227, 169, 52, '2.00', '75.00', '150.00', 'prepare', '2024-10-29', '20:31:15'),
(228, 169, 47, '0.75', '840.00', '630.00', 'prepare', '2024-10-29', '20:31:15'),
(229, 169, 54, '0.75', '880.00', '660.00', 'prepare', '2024-10-29', '20:31:15'),
(230, 169, 54, '0.75', '880.00', '660.00', 'prepare', '2024-10-29', '20:31:15'),
(231, 169, 55, '2.00', '5.00', '10.00', 'prepare', '2024-10-29', '20:31:15'),
(235, 174, 47, '0.25', '840.00', '210.00', 'served', '2024-10-30', '20:31:15'),
(236, 174, 47, '0.25', '840.00', '210.00', 'served', '2024-10-30', '20:31:15'),
(237, 174, 51, '1.00', '25.00', '25.00', 'served', '2024-10-30', '20:31:15'),
(238, 175, 47, '0.25', '840.00', '210.00', 'served', '2024-10-30', '20:31:15'),
(239, 176, 54, '0.25', '880.00', '220.00', 'served', '2024-10-30', '20:31:15'),
(240, 177, 54, '0.25', '880.00', '220.00', 'served', '2024-10-30', '20:31:15'),
(241, 175, 55, '1.00', '5.00', '5.00', 'served', '2024-10-30', '20:31:15'),
(242, 178, 47, '1.00', '840.00', '840.00', 'served', '2024-10-30', '20:31:15'),
(243, 178, 51, '1.00', '25.00', '25.00', 'served', '2024-10-30', '20:31:15'),
(244, 178, 51, '1.00', '25.00', '25.00', 'served', '2024-10-30', '20:31:15'),
(245, 179, 47, '1.00', '840.00', '840.00', 'served', '2024-10-30', '20:31:15'),
(248, 182, 58, '4.00', '880.00', '3520.00', 'served', '2024-10-31', '20:31:15'),
(254, 187, 46, '4.00', '840.00', '3360.00', 'served', '2024-10-31', '20:31:15'),
(255, 187, 47, '4.00', '840.00', '3360.00', 'served', '2024-10-31', '20:31:15'),
(256, 187, 50, '2.00', '75.00', '150.00', 'served', '2024-10-31', '20:31:15'),
(257, 188, 46, '1.00', '840.00', '840.00', 'served', '2024-10-31', '20:31:15'),
(258, 188, 47, '1.00', '840.00', '840.00', 'served', '2024-10-31', '20:31:15'),
(259, 188, 50, '3.00', '75.00', '225.00', 'served', '2024-10-31', '20:31:15'),
(260, 188, 57, '5.00', '880.00', '4400.00', 'served', '2024-10-31', '20:31:15'),
(261, 188, 56, '5.00', '840.00', '4200.00', 'served', '2024-10-31', '20:31:15'),
(262, 188, 58, '4.00', '880.00', '3520.00', 'served', '2024-10-31', '20:31:15'),
(274, 197, 58, '1.00', '880.00', '880.00', 'served', '2024-11-02', '20:31:15'),
(275, 197, 52, '1.00', '75.00', '75.00', 'served', '2024-11-02', '20:31:15'),
(276, 198, 51, '2.00', '25.00', '50.00', 'served', '2024-11-02', '20:31:15'),
(277, 199, 51, '1.00', '25.00', '25.00', 'served', '2024-11-02', '20:31:15'),
(278, 200, 51, '1.00', '25.00', '25.00', 'served', '2024-11-03', '20:31:15'),
(279, 201, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(280, 202, 51, '2.00', '25.00', '50.00', 'served', '2024-11-03', '20:31:15'),
(281, 203, 52, '2.00', '75.00', '150.00', 'served', '2024-11-03', '20:31:15'),
(282, 204, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(283, 205, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(284, 206, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(285, 207, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(286, 208, 51, '1.00', '25.00', '25.00', 'served', '2024-11-03', '20:31:15'),
(288, 210, 52, '2.00', '75.00', '150.00', 'served', '2024-11-03', '20:31:15'),
(289, 211, 51, '2.00', '25.00', '50.00', 'served', '2024-11-03', '20:31:15'),
(290, 212, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(291, 212, 51, '2.00', '25.00', '50.00', 'served', '2024-11-03', '20:31:15'),
(292, 213, 51, '1.00', '25.00', '25.00', 'served', '2024-11-03', '20:31:15'),
(293, 213, 52, '1.00', '75.00', '75.00', 'served', '2024-11-03', '20:31:15'),
(294, 214, 52, '2.00', '75.00', '150.00', 'served', '2024-11-03', '20:31:15'),
(295, 214, 53, '1.00', '2.00', '2.00', 'served', '2024-11-03', '20:31:15'),
(296, 215, 51, '2.00', '25.00', '50.00', 'served', '2024-11-03', '20:31:15'),
(297, 215, 53, '1.00', '2.00', '2.00', 'served', '2024-11-03', '20:31:15'),
(298, 216, 52, '2.00', '75.00', '150.00', 'served', '2024-11-03', '20:31:15'),
(299, 217, 55, '1.00', '5.00', '5.00', 'served', '2024-11-03', '20:31:15'),
(300, 217, 58, '1.00', '880.00', '880.00', 'served', '2024-11-03', '20:31:15'),
(301, 217, 53, '2.00', '2.00', '4.00', 'served', '2024-11-03', '20:31:15'),
(302, 217, 51, '1.00', '25.00', '25.00', 'served', '2024-11-03', '20:31:15'),
(303, 217, 47, '0.75', '840.00', '630.00', 'served', '2024-11-03', '20:31:15'),
(304, 217, 46, '0.50', '840.00', '420.00', 'served', '2024-11-03', '20:31:15'),
(305, 218, 46, '2.00', '840.00', '1680.00', 'served', '2024-11-04', '20:31:15'),
(306, 219, 47, '0.75', '840.00', '630.00', 'served', '2024-11-05', '07:37:47'),
(307, 220, 50, '2.00', '75.00', '150.00', 'served', '2024-11-05', '07:49:04'),
(308, 221, 52, '4.00', '75.00', '300.00', 'served', '2024-11-05', '07:49:28'),
(309, 222, 53, '1.00', '2.00', '2.00', 'served', '2024-11-05', '07:49:49'),
(310, 223, 52, '1.00', '75.00', '75.00', 'served', '2024-11-05', '08:02:47'),
(311, 224, 46, '2.50', '840.00', '2100.00', 'served', '2024-11-05', '21:24:19'),
(312, 225, 46, '1.00', '840.00', '840.00', 'served', '2024-11-05', '21:27:11'),
(313, 226, 55, '1.00', '5.00', '5.00', 'served', '2024-11-06', '06:28:16'),
(314, 227, 57, '1.00', '880.00', '880.00', 'served', '2024-11-06', '07:03:42'),
(315, 228, 47, '0.75', '840.00', '630.00', 'served', '2024-11-06', '07:04:05'),
(316, 229, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '07:12:40'),
(317, 230, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '07:12:52'),
(318, 231, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '07:24:38'),
(319, 232, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '07:25:07'),
(320, 233, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '07:26:35'),
(321, 234, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '07:26:45'),
(322, 235, 54, '1.00', '880.00', '880.00', 'served', '2024-11-06', '07:30:04'),
(323, 236, 50, '1.00', '75.00', '75.00', 'served', '2024-11-06', '07:32:01'),
(324, 237, 50, '1.00', '75.00', '75.00', 'served', '2024-11-06', '07:32:56'),
(325, 238, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '07:46:34'),
(326, 239, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '07:46:52'),
(327, 240, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '07:49:35'),
(328, 241, 56, '0.25', '840.00', '210.00', 'served', '2024-11-06', '07:53:55'),
(329, 242, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '08:01:46'),
(330, 243, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '08:01:54'),
(331, 244, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '08:02:03'),
(332, 245, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '08:05:05'),
(333, 245, 52, '2.00', '75.00', '150.00', 'served', '2024-11-06', '08:05:05'),
(334, 246, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '08:12:43'),
(335, 247, 55, '1.00', '5.00', '5.00', 'served', '2024-11-06', '08:12:51'),
(336, 248, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '08:12:59'),
(337, 247, 47, '1.00', '840.00', '840.00', 'served', '2024-11-06', '08:32:32'),
(338, 249, 47, '1.00', '840.00', '840.00', 'served', '2024-11-06', '08:57:02'),
(339, 250, 55, '1.00', '5.00', '5.00', 'served', '2024-11-06', '08:58:54'),
(340, 251, 47, '1.00', '840.00', '840.00', 'served', '2024-11-06', '10:08:28'),
(341, 252, 47, '2.00', '840.00', '1680.00', 'served', '2024-11-06', '13:15:25'),
(342, 253, 58, '1.00', '880.00', '880.00', 'served', '2024-11-06', '13:16:35'),
(343, 253, 56, '2.00', '840.00', '1680.00', 'served', '2024-11-06', '13:16:35'),
(344, 253, 57, '9.00', '880.00', '7920.00', 'served', '2024-11-06', '13:16:35'),
(345, 253, 54, '0.25', '880.00', '220.00', 'served', '2024-11-06', '13:16:35'),
(346, 253, 47, '0.50', '840.00', '420.00', 'served', '2024-11-06', '13:16:35'),
(347, 254, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '19:37:17'),
(362, 260, 55, '1.00', '5.00', '5.00', 'served', '2024-11-06', '21:06:51'),
(363, 250, 53, '1.00', '2.00', '2.00', 'served', '2024-11-06', '21:07:59'),
(365, 260, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '21:09:51'),
(369, 260, 59, '1.00', '500.00', '500.00', 'served', '2024-11-06', '22:17:48'),
(370, 260, 52, '1.00', '75.00', '75.00', 'served', '2024-11-06', '22:19:00'),
(405, 280, 55, '1.00', '5.00', '5.00', 'served', '2024-11-07', '06:15:50'),
(408, 280, 57, '1.00', '880.00', '880.00', 'served', '2024-11-07', '07:30:50'),
(415, 282, 55, '1.00', '5.00', '5.00', 'served', '2024-11-07', '22:14:55'),
(416, 282, 57, '0.75', '880.00', '660.00', 'served', '2024-11-07', '22:14:55'),
(417, 283, 57, '0.25', '880.00', '220.00', 'served', '2024-11-07', '22:16:38'),
(418, 284, 56, '1.00', '840.00', '840.00', 'served', '2024-11-07', '23:09:18'),
(419, 284, 59, '3.00', '180.00', '540.00', 'served', '2024-11-07', '23:09:18'),
(420, 284, 58, '1.00', '450.00', '450.00', 'served', '2024-11-07', '23:09:18'),
(421, 285, 59, '2.00', '180.00', '360.00', 'served', '2024-11-07', '23:23:07'),
(422, 286, 46, '0.75', '880.00', '660.00', 'served', '2024-11-07', '23:31:14'),
(423, 286, 47, '1.00', '840.00', '840.00', 'served', '2024-11-07', '23:31:14'),
(424, 286, 57, '5.00', '450.00', '2250.00', 'served', '2024-11-07', '23:31:14'),
(425, 286, 60, '0.25', '450.00', '112.50', 'served', '2024-11-07', '23:31:14'),
(426, 287, 61, '1.00', '880.00', '880.00', 'served', '2024-11-07', '23:40:11'),
(427, 287, 63, '1.00', '880.00', '880.00', 'served', '2024-11-07', '23:40:11'),
(428, 287, 46, '1.00', '880.00', '880.00', 'served', '2024-11-07', '23:40:11'),
(429, 287, 46, '1.00', '880.00', '880.00', 'served', '2024-11-07', '23:43:20'),
(430, 287, 63, '1.00', '880.00', '880.00', 'served', '2024-11-07', '23:43:20'),
(431, 287, 61, '0.25', '880.00', '220.00', 'served', '2024-11-07', '23:43:20'),
(432, 288, 47, '1.00', '840.00', '840.00', 'served', '2024-11-07', '23:54:19'),
(433, 289, 57, '1.00', '450.00', '450.00', 'served', '2024-11-07', '23:54:34'),
(435, 291, 48, '6.00', '245.00', '1470.00', 'served', '2024-11-08', '01:42:34'),
(445, 294, 48, '1.00', '245.00', '245.00', 'served', '2024-11-08', '03:29:31'),
(446, 295, 48, '1.00', '245.00', '245.00', 'served', '2024-11-08', '07:32:04'),
(447, 296, 47, '1.00', '840.00', '840.00', 'prepare', '2024-11-08', '07:33:29'),
(448, 297, 48, '2.00', '245.00', '490.00', 'served', '2024-11-08', '07:40:21'),
(449, 297, 47, '1.00', '840.00', '840.00', 'served', '2024-11-08', '07:40:53'),
(453, 299, 47, '1.00', '300.00', '300.00', 'served', '2024-11-08', '09:49:23'),
(454, 300, 47, '1.00', '300.00', '300.00', 'served', '2024-11-08', '09:53:56'),
(455, 301, 63, '0.50', '880.00', '440.00', 'served', '2024-11-08', '12:19:55'),
(456, 301, 61, '0.50', '880.00', '440.00', 'served', '2024-11-08', '12:19:55'),
(457, 301, 46, '0.25', '880.00', '220.00', 'served', '2024-11-08', '12:19:55'),
(458, 302, 64, '0.25', '880.00', '220.00', 'served', '2024-11-08', '14:40:31'),
(459, 302, 63, '1.00', '880.00', '880.00', 'served', '2024-11-08', '14:40:31'),
(460, 302, 48, '1.00', '245.00', '245.00', 'served', '2024-11-08', '14:43:40'),
(461, 302, 49, '1.00', '75.00', '75.00', 'served', '2024-11-08', '14:44:40'),
(464, 304, 51, '1.00', '25.00', '25.00', 'prepare', '2024-11-13', '20:01:46'),
(465, 304, 48, '2.00', '245.00', '490.00', 'prepare', '2024-11-13', '20:02:08'),
(466, 304, 57, '0.25', '470.00', '117.50', 'prepare', '2024-11-13', '20:02:22'),
(467, 305, 46, '0.25', '880.00', '220.00', 'served', '2024-11-21', '13:13:07'),
(468, 306, 48, '1.00', '245.00', '245.00', 'served', '2024-11-21', '19:58:03'),
(469, 307, 46, '1.00', '880.00', '880.00', 'prepare', '2024-11-21', '21:28:18'),
(470, 308, 54, '4.00', '880.00', '3520.00', 'served', '2024-11-23', '07:56:10'),
(471, 309, 46, '1.00', '880.00', '880.00', 'served', '2024-11-23', '09:51:57'),
(472, 309, 47, '1.00', '300.00', '300.00', 'served', '2024-11-23', '09:52:23'),
(473, 309, 46, '0.25', '880.00', '220.00', 'served', '2024-11-23', '09:52:46'),
(474, 309, 47, '0.25', '300.00', '75.00', 'served', '2024-11-23', '09:53:30'),
(475, 310, 53, '1.00', '25.00', '25.00', 'served', '2024-11-23', '09:58:33'),
(476, 310, 51, '1.00', '25.00', '25.00', 'served', '2024-11-23', '09:58:46'),
(477, 311, 47, '0.25', '300.00', '75.00', 'prepare', '2024-11-23', '10:06:49'),
(478, 312, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:07:23'),
(479, 313, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:15:53'),
(480, 313, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:17:32'),
(481, 313, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:36:23'),
(482, 313, 48, '1.00', '245.00', '245.00', 'prepare', '2024-11-23', '10:36:57'),
(483, 313, 46, '0.25', '880.00', '220.00', 'prepare', '2024-11-23', '10:37:17'),
(484, 313, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:39:10'),
(485, 314, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:39:29'),
(486, 314, 46, '0.25', '880.00', '220.00', 'prepare', '2024-11-23', '10:39:29'),
(487, 312, 50, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:39:42'),
(488, 314, 50, '1.00', '75.00', '75.00', 'prepare', '2024-11-23', '10:42:01'),
(489, 315, 46, '0.50', '880.00', '440.00', 'served', '2024-11-24', '21:38:24'),
(490, 316, 47, '1.00', '300.00', '300.00', 'served', '2024-11-25', '08:03:59'),
(491, 317, 49, '1.00', '75.00', '75.00', 'served', '2024-11-25', '08:29:44'),
(492, 318, 49, '2.00', '75.00', '150.00', 'served', '2024-11-25', '08:48:07'),
(493, 319, 47, '1.50', '300.00', '450.00', 'served', '2024-11-25', '08:50:36'),
(494, 320, 48, '1.00', '245.00', '245.00', 'prepare', '2024-11-25', '08:51:00'),
(495, 321, 46, '0.75', '880.00', '660.00', 'prepare', '2024-11-25', '08:52:05'),
(496, 322, 48, '2.00', '245.00', '490.00', 'prepare', '2024-11-25', '09:06:30'),
(497, 317, 50, '1.00', '75.00', '75.00', 'served', '2024-11-25', '09:10:32'),
(498, 317, 52, '2.00', '75.00', '150.00', 'served', '2024-11-25', '09:10:50'),
(499, 317, 47, '1.00', '300.00', '300.00', 'served', '2024-11-25', '09:25:14'),
(500, 323, 48, '1.00', '245.00', '245.00', 'prepare', '2024-11-25', '09:25:49'),
(501, 323, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-25', '09:26:20'),
(502, 324, 46, '0.25', '880.00', '220.00', 'prepare', '2024-11-25', '09:29:14'),
(503, 322, 51, '1.00', '25.00', '25.00', 'prepare', '2024-11-25', '09:30:18'),
(504, 325, 57, '2.00', '470.00', '940.00', 'served', '2024-11-26', '21:42:39'),
(505, 325, 53, '2.00', '25.00', '50.00', 'served', '2024-11-26', '21:42:39'),
(506, 325, 48, '1.00', '245.00', '245.00', 'served', '2024-11-26', '21:43:23'),
(507, 325, 49, '1.00', '75.00', '75.00', 'served', '2024-11-26', '21:43:46'),
(508, 326, 51, '2.00', '25.00', '50.00', 'served', '2024-11-26', '21:46:58'),
(509, 326, 53, '1.00', '25.00', '25.00', 'served', '2024-11-26', '21:47:03'),
(510, 327, 46, '0.50', '880.00', '440.00', 'served', '2024-11-27', '06:19:30'),
(511, 328, 53, '1.00', '25.00', '25.00', 'served', '2024-11-28', '08:23:43'),
(512, 329, 46, '1.00', '880.00', '880.00', 'served', '2024-11-28', '10:10:36'),
(513, 330, 46, '1.00', '880.00', '880.00', 'served', '2024-11-28', '10:10:59'),
(514, 331, 47, '1.00', '300.00', '300.00', 'prepare', '2024-11-28', '12:35:10'),
(515, 331, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-28', '12:35:28'),
(516, 331, 47, '0.75', '300.00', '225.00', 'prepare', '2024-11-28', '12:36:00'),
(517, 332, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-28', '12:36:23'),
(518, 331, 47, '1.00', '300.00', '300.00', 'prepare', '2024-11-28', '12:37:07'),
(519, 331, 50, '2.00', '75.00', '150.00', 'prepare', '2024-11-28', '12:37:41'),
(520, 333, 49, '1.00', '75.00', '75.00', 'prepare', '2024-11-28', '12:37:57'),
(521, 334, 50, '1.00', '75.00', '75.00', 'prepare', '2024-11-28', '12:38:16'),
(522, 334, 47, '1.00', '300.00', '300.00', 'prepare', '2024-11-28', '12:38:32'),
(523, 335, 56, '0.25', '880.00', '220.00', 'prepare', '2024-11-28', '12:39:13'),
(524, 336, 47, '1.00', '300.00', '300.00', 'prepare', '2024-11-28', '12:41:20'),
(525, 335, 47, '1.00', '300.00', '300.00', 'prepare', '2024-11-28', '12:41:32'),
(526, 337, 48, '2.00', '245.00', '490.00', 'prepare', '2024-11-28', '12:41:48'),
(527, 338, 47, '0.25', '300.00', '75.00', 'prepare', '2024-11-28', '12:44:43'),
(528, 338, 51, '2.00', '25.00', '50.00', 'prepare', '2024-11-28', '12:44:57'),
(529, 339, 51, '2.00', '25.00', '50.00', 'prepare', '2024-11-28', '12:45:14'),
(530, 340, 53, '1.00', '25.00', '25.00', 'served', '2024-12-05', '14:42:57'),
(531, 341, 54, '4.00', '880.00', '3520.00', 'served', '2024-12-05', '14:43:06'),
(532, 342, 53, '1.00', '25.00', '25.00', 'served', '2024-12-05', '14:43:33'),
(533, 343, 50, '2.00', '75.00', '150.00', 'served', '2024-12-05', '14:52:29'),
(534, 343, 46, '2.00', '880.00', '1760.00', 'served', '2024-12-05', '14:52:29'),
(535, 344, 56, '0.50', '880.00', '440.00', 'served', '2024-12-05', '14:52:51'),
(536, 345, 50, '1.00', '75.00', '75.00', 'served', '2024-12-05', '14:55:48'),
(537, 345, 51, '1.00', '25.00', '25.00', 'served', '2024-12-05', '14:55:48'),
(539, 346, 48, '2.00', '245.00', '490.00', 'prepare', '2024-12-06', '17:36:18'),
(540, 347, 57, '1.00', '470.00', '470.00', 'prepare', '2024-12-06', '17:36:27'),
(541, 347, 47, '1.00', '300.00', '300.00', 'prepare', '2024-12-06', '17:37:34'),
(542, 347, 48, '1.00', '245.00', '245.00', 'prepare', '2024-12-06', '17:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discounted_amount` decimal(10,2) DEFAULT NULL,
  `cash_tendered` decimal(10,2) NOT NULL,
  `change_due` decimal(10,2) NOT NULL,
  `payment_status` enum('paid','credit') NOT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `credit_note` text DEFAULT NULL,
  `payment_date` date DEFAULT current_timestamp(),
  `payment_time` time DEFAULT current_timestamp(),
  `collectibles` enum('Y','N') NOT NULL DEFAULT 'N',
  `paid_as_group` varchar(50) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `username`, `total_amount`, `discounted_amount`, `cash_tendered`, `change_due`, `payment_status`, `discount_type`, `credit_note`, `payment_date`, `payment_time`, `collectibles`, `paid_as_group`) VALUES
(23, 148, NULL, '210.00', '0.00', '300.00', '90.00', 'paid', NULL, NULL, '2024-10-26', '06:22:05', 'N', 'none'),
(24, 149, NULL, '735.00', '0.00', '800.00', '65.00', 'paid', NULL, NULL, '2024-10-26', '08:32:24', 'N', 'none'),
(25, 149, NULL, '735.00', '0.00', '800.00', '65.00', 'paid', NULL, NULL, '2024-10-26', '08:32:32', 'N', 'none'),
(26, 149, NULL, '735.00', '0.00', '800.00', '65.00', 'paid', NULL, NULL, '2024-10-26', '08:32:49', 'N', 'none'),
(27, 150, NULL, '420.00', '0.00', '500.00', '80.00', 'paid', NULL, NULL, '2024-10-26', '08:33:22', 'N', 'none'),
(28, 151, NULL, '2.00', '0.00', '0.00', '0.00', 'paid', NULL, NULL, '2024-10-26', '08:39:30', 'N', 'none'),
(29, 152, NULL, '420.00', '0.00', '0.00', '0.00', 'paid', NULL, NULL, '2024-10-26', '08:40:23', 'N', 'none'),
(30, 153, NULL, '25.00', '0.00', '55.00', '30.00', 'paid', NULL, NULL, '2024-10-26', '08:54:34', 'N', 'none'),
(31, 154, NULL, '245.00', '0.00', '255.00', '10.00', 'paid', NULL, NULL, '2024-10-26', '10:47:19', 'N', 'none'),
(32, 155, NULL, '75.00', '0.00', '75.00', '0.00', 'paid', NULL, NULL, '2024-10-26', '10:57:31', 'N', 'none'),
(33, 156, NULL, '2.00', '1.60', '5.00', '3.40', 'paid', NULL, NULL, '2024-10-26', '10:59:27', 'N', 'none'),
(34, 157, NULL, '3360.00', '2688.00', '2700.00', '12.00', 'paid', NULL, NULL, '2024-10-26', '12:17:27', 'N', 'none'),
(35, 159, NULL, '840.00', NULL, '1000.00', '10.00', 'paid', NULL, 'mahalin mo naman ako kahit kunti', '2024-10-26', '16:04:45', 'N', 'v7wgDTWq'),
(36, 158, NULL, '150.00', NULL, '1000.00', '10.00', 'paid', NULL, 'mahalin moko', '2024-10-26', '21:08:34', 'N', 'v7wgDTWq'),
(37, 160, NULL, '840.00', NULL, '2000.00', '280.00', 'paid', NULL, ' ', '2024-10-26', '21:12:20', 'N', '8S4Vv94n'),
(38, 161, NULL, '245.00', '0.00', '250.00', '5.00', 'paid', NULL, NULL, '2024-10-26', '21:13:05', 'N', 'none'),
(39, 162, NULL, '490.00', '0.00', '500.00', '10.00', 'paid', NULL, NULL, '2024-10-28', '08:51:58', 'N', 'none'),
(40, 165, NULL, '540.00', NULL, '540.00', '0.00', 'paid', NULL, 'nne', '2024-10-28', '13:33:20', 'N', 'czj7gvH8'),
(41, 164, NULL, '880.00', NULL, '2000.00', '280.00', 'paid', NULL, 'asdasd', '2024-10-28', '14:55:39', 'N', '8S4Vv94n'),
(42, 166, NULL, '1120.00', NULL, '1200.00', '80.00', 'paid', NULL, '  ', '2024-10-28', '14:57:48', 'N', 'zuiyJiMC'),
(43, 167, NULL, '840.00', NULL, '900.00', '60.00', 'paid', NULL, 'asdasdad', '2024-10-28', '20:27:29', 'N', 'qegOqNTW'),
(44, 168, NULL, '245.00', NULL, '250.00', '5.00', 'paid', NULL, 'asdasd', '2024-10-28', '20:37:18', 'N', 'mFMAAjXH'),
(45, 178, NULL, '865.00', '0.00', '900.00', '35.00', 'paid', NULL, NULL, '2024-10-30', '08:21:42', 'N', 'none'),
(46, 174, NULL, '445.00', '0.00', '500.00', '55.00', 'paid', NULL, NULL, '2024-10-30', '10:39:51', 'N', 'none'),
(47, 175, NULL, '215.00', '0.00', '500.00', '285.00', 'paid', NULL, NULL, '2024-10-30', '10:40:12', 'N', 'none'),
(48, 177, NULL, '220.00', '0.00', '250.00', '30.00', 'paid', NULL, NULL, '2024-10-30', '10:40:27', 'N', 'none'),
(49, 176, NULL, '220.00', '0.00', '500.00', '280.00', 'paid', NULL, NULL, '2024-10-30', '10:44:08', 'N', 'none'),
(50, 179, NULL, '840.00', '672.00', '1000.00', '160.00', 'paid', NULL, NULL, '2024-10-30', '10:44:18', 'N', 'none'),
(51, 182, NULL, '3520.00', NULL, '3600.00', '55.00', 'paid', NULL, 'werewr', '2024-10-31', '05:26:15', 'N', 'jQaMoaZu'),
(52, 187, NULL, '6870.00', '0.00', '7000.00', '130.00', 'paid', NULL, NULL, '2024-10-31', '07:22:38', 'N', 'none'),
(53, 188, NULL, '14025.00', '0.00', '15000.00', '975.00', 'paid', NULL, NULL, '2024-10-31', '07:30:09', 'N', 'none'),
(54, 197, NULL, '955.00', NULL, '0.00', '0.00', '', NULL, 'ugma na', '2024-11-02', '06:26:59', 'N', 'none'),
(55, 198, NULL, '50.00', NULL, '0.00', '0.00', '', NULL, 'asdasd', '2024-11-02', '10:15:09', 'N', 'none'),
(56, 199, NULL, '25.00', NULL, '0.00', '0.00', 'paid', NULL, 'yes\n', '2024-11-02', '10:20:27', 'N', 'none'),
(57, 200, NULL, '25.00', NULL, '0.00', '0.00', 'paid', NULL, 'yes', '2024-11-03', '05:09:56', 'N', 'none'),
(58, 201, NULL, '75.00', NULL, '0.00', '0.00', 'paid', NULL, 'asdasd', '2024-11-03', '05:24:14', 'Y', 'none'),
(59, 201, NULL, '75.00', NULL, '100.00', '25.00', 'paid', NULL, NULL, '2024-11-03', '08:38:41', 'N', 'none'),
(60, 199, NULL, '25.00', NULL, '50.00', '25.00', 'paid', NULL, NULL, '2024-11-03', '08:40:00', 'N', 'none'),
(61, 203, NULL, '150.00', NULL, '0.00', '0.00', 'paid', NULL, 'yessss', '2024-11-03', '09:05:02', 'Y', 'none'),
(62, 202, NULL, '50.00', NULL, '0.00', '0.00', 'paid', NULL, 'no', '2024-11-03', '09:06:07', 'Y', 'none'),
(63, 202, NULL, '200.00', NULL, '500.00', '300.00', 'paid', NULL, NULL, '2024-11-03', '09:06:42', 'N', 'none'),
(64, 203, NULL, '200.00', NULL, '500.00', '300.00', 'paid', NULL, NULL, '2024-11-03', '09:06:42', 'N', 'none'),
(65, 204, NULL, '75.00', NULL, '200.00', '50.00', 'paid', NULL, 'as', '2024-11-03', '09:26:04', 'Y', 'none'),
(66, 205, NULL, '75.00', NULL, '200.00', '50.00', 'paid', NULL, 'asa', '2024-11-03', '09:26:08', 'Y', 'none'),
(67, 207, NULL, '75.00', NULL, '0.00', '0.00', 'paid', NULL, 'none', '2024-11-03', '09:40:55', 'Y', 'none'),
(68, 206, NULL, '75.00', NULL, '0.00', '0.00', 'paid', NULL, 'none', '2024-11-03', '09:40:59', 'Y', 'none'),
(69, 208, NULL, '25.00', NULL, '3600.00', '55.00', 'paid', NULL, 'asdasd', '2024-11-03', '09:49:59', 'Y', 'jQaMoaZu'),
(70, 210, NULL, '150.00', '0.00', '200.00', '50.00', 'paid', NULL, NULL, '2024-11-03', '20:50:03', 'N', 'none'),
(71, 211, NULL, '50.00', '40.00', '50.00', '10.00', 'paid', NULL, NULL, '2024-11-03', '20:52:28', 'N', 'none'),
(72, 212, NULL, '125.00', '0.00', '150.00', '25.00', 'paid', NULL, NULL, '2024-11-03', '21:04:07', 'N', 'none'),
(73, 213, NULL, '100.00', '80.00', '100.00', '20.00', 'paid', NULL, NULL, '2024-11-03', '21:05:49', 'N', 'none'),
(74, 214, NULL, '152.00', '121.60', '150.00', '28.40', 'paid', NULL, NULL, '2024-11-03', '21:09:04', 'N', 'none'),
(75, 215, NULL, '52.00', '0.00', '100.00', '48.00', 'paid', NULL, NULL, '2024-11-03', '22:14:00', 'N', 'none'),
(76, 216, NULL, '150.00', '0.00', '200.00', '50.00', 'paid', NULL, NULL, '2024-11-03', '22:18:43', 'N', 'none'),
(77, 217, NULL, '1964.00', '1571.20', '2000.00', '36.00', 'paid', NULL, NULL, '2024-11-03', '22:50:43', 'N', 'none'),
(78, 218, NULL, '1680.00', '0.00', '2000.00', '320.00', 'paid', NULL, NULL, '2024-11-04', '17:00:08', 'N', 'none'),
(79, 219, NULL, '630.00', NULL, '1000.00', '370.00', 'paid', NULL, 'ugma na haha', '2024-11-05', '07:42:30', 'Y', 'aeKpzK8c'),
(80, 221, NULL, '300.00', NULL, '500.00', '195.00', 'paid', NULL, 'Yes', '2024-11-05', '07:50:31', 'Y', 'VdLlBsYV'),
(81, 222, NULL, '2.00', '0.00', '5.00', '3.00', 'paid', NULL, NULL, '2024-11-05', '07:51:25', 'N', 'none'),
(82, 220, NULL, '150.00', NULL, '1000.00', '775.00', 'paid', NULL, 'okay', '2024-11-05', '07:54:55', 'Y', 'wVRXCb8o'),
(83, 223, NULL, '75.00', NULL, '1000.00', '775.00', 'paid', NULL, 'Thank you for the ice cream', '2024-11-05', '08:03:25', 'Y', 'wVRXCb8o'),
(84, 224, NULL, '2100.00', '1680.00', '2000.00', '320.00', 'paid', NULL, NULL, '2024-11-05', '21:24:52', 'N', 'none'),
(85, 225, NULL, '840.00', '672.00', '850.00', '178.00', 'paid', NULL, NULL, '2024-11-05', '21:34:49', 'N', 'none'),
(86, 226, NULL, '5.00', NULL, '500.00', '195.00', 'paid', NULL, 'yes', '2024-11-06', '06:28:31', 'Y', 'VdLlBsYV'),
(87, 227, NULL, '880.00', NULL, '2000.00', '490.00', 'paid', NULL, ' ', '2024-11-06', '07:04:23', 'Y', 'uHKrOBWp'),
(88, 228, NULL, '630.00', NULL, '2000.00', '490.00', 'paid', NULL, 'yes', '2024-11-06', '07:04:33', 'Y', 'uHKrOBWp'),
(89, 229, NULL, '75.00', NULL, '100.00', '23.00', 'paid', NULL, 'no', '2024-11-06', '07:13:12', 'Y', 'jJLdaRs4'),
(90, 230, NULL, '2.00', NULL, '100.00', '23.00', 'paid', NULL, ' ', '2024-11-06', '07:13:24', 'Y', 'jJLdaRs4'),
(91, 231, NULL, '2.00', NULL, '100.00', '23.00', 'paid', NULL, ' ', '2024-11-06', '07:25:24', 'Y', 'NKMnZM1Z'),
(92, 232, NULL, '75.00', NULL, '100.00', '23.00', 'paid', NULL, ' ', '2024-11-06', '07:25:32', 'Y', 'NKMnZM1Z'),
(93, 233, NULL, '75.00', NULL, '100.00', '23.00', 'paid', NULL, ' ', '2024-11-06', '07:27:23', 'Y', 'WHzOiOwZ'),
(94, 234, NULL, '2.00', NULL, '100.00', '23.00', 'paid', NULL, ' ', '2024-11-06', '07:27:28', 'Y', 'WHzOiOwZ'),
(95, 235, NULL, '880.00', NULL, '1000.00', '120.00', 'paid', NULL, ' ', '2024-11-06', '07:30:13', 'Y', 'iCspJJrq'),
(96, 236, NULL, '75.00', NULL, '100.00', '25.00', 'paid', NULL, ' ', '2024-11-06', '07:32:12', 'Y', 'ZG67bdnh'),
(97, 237, NULL, '75.00', NULL, '100.00', '25.00', 'paid', NULL, '123', '2024-11-06', '07:33:05', 'Y', 'NNYlJR0U'),
(98, 238, NULL, '75.00', NULL, '100.00', '25.00', 'paid', NULL, ' ', '2024-11-06', '07:50:47', 'Y', 'ENJV4Z60'),
(99, 239, NULL, '2.00', NULL, '5.00', '3.00', 'paid', NULL, ' ', '2024-11-06', '07:52:29', 'Y', 'JjYUKAkk'),
(100, 240, NULL, '2.00', NULL, '250.00', '38.00', 'paid', NULL, '1', '2024-11-06', '07:52:34', 'Y', '6hh8GBQN'),
(101, 241, NULL, '210.00', NULL, '250.00', '38.00', 'paid', NULL, 'sdasd', '2024-11-06', '07:54:05', 'Y', '6hh8GBQN'),
(102, 242, NULL, '75.00', NULL, '1000.00', '925.00', 'paid', NULL, ' ', '2024-11-06', '08:02:24', 'Y', 'AfMmlRTv'),
(103, 243, NULL, '2.00', NULL, '200.00', '46.00', 'paid', NULL, ' ', '2024-11-06', '08:02:29', 'Y', 'va1QZ4M9'),
(104, 244, NULL, '75.00', NULL, '100.00', '25.00', 'paid', NULL, ' ', '2024-11-06', '08:02:33', 'Y', '8AxvqdCW'),
(105, 245, NULL, '152.00', NULL, '200.00', '46.00', 'paid', NULL, ' ', '2024-11-06', '08:05:16', 'Y', 'va1QZ4M9'),
(106, 246, NULL, '75.00', NULL, '100.00', '23.00', 'paid', NULL, ' ', '2024-11-06', '08:13:17', 'Y', 'Xz3Q3Vt1'),
(107, 247, NULL, '5.00', NULL, '10.00', '5.00', 'paid', NULL, 'yees', '2024-11-06', '08:13:24', 'Y', '7DVOIx79'),
(108, 248, NULL, '2.00', NULL, '100.00', '23.00', 'paid', NULL, 'asd', '2024-11-06', '08:13:30', 'Y', 'Xz3Q3Vt1'),
(109, 249, NULL, '840.00', NULL, '1000.00', '160.00', 'paid', NULL, ' ', '2024-11-06', '08:57:15', 'Y', 'o0jDHglG'),
(110, 250, NULL, '5.00', NULL, '10.00', '3.00', 'paid', NULL, ' ', '2024-11-06', '08:59:15', 'Y', 'GH2uKjCy'),
(111, 251, NULL, '840.00', NULL, '3000.00', '480.00', 'paid', NULL, 'no', '2024-11-06', '10:08:42', 'Y', 'oM7Y9lLg'),
(112, 252, NULL, '1680.00', NULL, '3000.00', '480.00', 'paid', NULL, '2000', '2024-08-14', '13:15:37', 'Y', 'oM7Y9lLg'),
(113, 253, NULL, '11120.00', NULL, '50000.00', '38880.00', 'paid', NULL, '100', '2024-11-06', '13:16:51', 'Y', 'nJlE9ngt'),
(114, 254, NULL, '2.00', NULL, '10.00', '3.00', 'paid', NULL, 'okay\n', '2024-11-06', '19:37:38', 'Y', 'GH2uKjCy'),
(115, 280, NULL, '885.00', '0.00', '1000.00', '115.00', 'paid', NULL, NULL, '2024-11-07', '09:30:45', 'N', 'none'),
(116, 282, NULL, '665.00', '532.00', '1000.00', '468.00', 'paid', NULL, NULL, '2024-11-07', '22:15:39', 'N', 'none'),
(117, 284, NULL, '1830.00', '0.00', '500.00', '0.00', 'paid', NULL, NULL, '2024-11-07', '23:12:20', 'N', 'none'),
(118, 285, NULL, '360.00', '0.00', '500.00', '140.00', 'paid', NULL, NULL, '2024-11-07', '23:25:34', 'N', 'none'),
(119, 283, NULL, '220.00', NULL, '100.00', '0.00', 'paid', NULL, 'ugma na', '2024-11-07', '23:26:03', 'Y', 'nXayfuMm'),
(120, 286, NULL, '3862.50', '0.00', '4000.00', '137.50', 'paid', NULL, NULL, '2024-11-07', '23:34:27', 'N', 'none'),
(121, 287, NULL, '4620.00', NULL, '5000.00', '380.00', 'paid', NULL, 'sa friday', '2024-11-07', '23:52:43', 'Y', 'B487RkRo'),
(122, 288, NULL, '840.00', '0.00', '1000.00', '160.00', 'paid', NULL, NULL, '2024-11-07', '23:57:11', 'N', 'none'),
(123, 289, NULL, '450.00', '0.00', '500.00', '50.00', 'paid', NULL, NULL, '2024-11-07', '23:57:23', 'N', 'none'),
(124, 291, NULL, '1470.00', '0.00', '1500.00', '30.00', 'paid', NULL, NULL, '2024-11-08', '01:43:46', 'N', 'none'),
(125, 294, NULL, '245.00', NULL, '200.00', '0.00', 'paid', NULL, ' ', '2024-11-08', '03:40:58', 'Y', 'TZiz5zOc'),
(126, 295, NULL, '245.00', '196.00', '300.00', '104.00', 'paid', NULL, NULL, '2024-11-08', '08:45:13', 'N', 'none'),
(127, 299, NULL, '300.00', NULL, '300.00', '0.00', 'paid', NULL, 'next week na bayad', '2024-11-08', '09:50:56', 'Y', 'pL43cdey'),
(128, 300, NULL, '300.00', NULL, '300.00', '0.00', 'paid', NULL, ' ', '2024-11-08', '09:55:12', 'Y', 'hOPpLVPw'),
(129, 301, NULL, '1100.00', NULL, '1500.00', '400.00', 'paid', NULL, 'next week na bayad', '2024-11-08', '12:20:56', 'Y', '8AR2LKxJ'),
(130, 302, NULL, '1420.00', '1136.00', '1500.00', '364.00', 'paid', NULL, NULL, '2024-11-08', '14:48:51', 'N', 'none'),
(131, 297, '\nuser_admin', '1330.00', NULL, '1500.00', '170.00', 'paid', NULL, 'yes', '2024-11-08', '14:49:24', 'Y', 'lLPhO5KX'),
(132, 305, 'user_kitchen', '220.00', '0.00', '300.00', '80.00', 'paid', NULL, NULL, '2024-11-21', '18:46:54', 'N', 'none'),
(133, 306, 'user_kitchen', '245.00', NULL, '300.00', '55.00', 'paid', NULL, 'Helllo', '2024-11-21', '19:59:02', 'Y', 'aVUjis1v'),
(134, 308, 'user_admin', '3520.00', '0.00', '4000.00', '480.00', 'paid', NULL, NULL, '2024-11-23', '07:59:06', 'N', 'none'),
(135, 309, 'user_admin', '1475.00', NULL, '1500.00', '25.00', 'paid', NULL, 'first\n', '2024-11-23', '09:54:10', 'Y', 'ezlCUVAL'),
(136, 310, 'user_admin\nuser_admin', '50.00', NULL, '100.00', '50.00', 'paid', NULL, 'tes', '2024-11-23', '09:59:09', 'Y', '0UKRu1ub'),
(137, 315, 'user_admin\nadmin_god15', '440.00', NULL, '500.00', '60.00', 'paid', NULL, 'yes', '2024-11-24', '21:39:24', 'Y', 'CMZdrsi0'),
(138, 316, 'user_kitchen\nadmin_god15', '300.00', NULL, '1000.00', '700.00', 'paid', NULL, 'okay', '2024-11-25', '09:34:14', 'Y', 'SCYXPqh8'),
(139, 317, 'user_kitchen', '600.00', '0.00', '1000.00', '400.00', 'paid', NULL, NULL, '2024-11-25', '09:35:11', 'N', 'none'),
(140, 318, 'user_kitchen\nkitchen god3', '150.00', NULL, '200.00', '50.00', 'paid', NULL, 'okay', '2024-11-25', '09:35:52', 'Y', '29VclnWO'),
(141, 325, 'kitchen god2', '1310.00', NULL, '0.00', '0.00', 'credit', NULL, 'haha', '2024-11-26', '21:45:25', 'Y', 'none'),
(142, 326, 'kitchen god2\nadmin_god15\nadmin_god15', '75.00', NULL, '100.00', '25.00', 'paid', NULL, 'Hello', '2024-11-26', '21:47:34', 'Y', 'aihAMXJp'),
(143, 328, 'kitchen god2', '25.00', '22.50', '50.00', '27.50', 'paid', NULL, NULL, '2024-11-28', '10:09:43', 'N', 'none'),
(144, 329, 'kitchen god3', '880.00', '704.00', '1000.00', '296.00', 'paid', 'PWD', NULL, '2024-11-28', '10:26:10', 'N', 'none'),
(145, 330, 'kitchen god3', '880.00', '792.00', '1000.00', '208.00', 'paid', 'Senior', NULL, '2024-11-28', '10:26:32', 'N', 'none'),
(146, 340, 'kitchen god2', '25.00', '22.50', '50.00', '27.50', 'paid', 'Senior', NULL, '2024-12-05', '14:45:42', 'N', 'none'),
(147, 342, 'kitchen god2', '25.00', NULL, '0.00', '0.00', 'credit', NULL, 'okay', '2024-12-05', '14:49:29', 'Y', 'none'),
(148, 341, 'kitchen god2', '3520.00', NULL, '0.00', '0.00', 'credit', NULL, 'toms na', '2024-12-05', '14:50:20', 'Y', 'none'),
(149, 343, 'kitchen god2', '1910.00', NULL, '0.00', '0.00', 'credit', NULL, 'lunes na', '2024-12-05', '14:53:35', 'Y', 'none'),
(150, 344, 'kitchen god2', '440.00', '352.00', '500.00', '148.00', 'paid', 'PWD', NULL, '2024-12-05', '14:54:23', 'N', 'none'),
(151, 345, 'kitchen god2', '100.00', NULL, '0.00', '0.00', 'credit', NULL, 'asdasd', '2024-12-05', '14:57:27', 'Y', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `stock_name` varchar(100) NOT NULL,
  `stock_quantity` decimal(10,2) NOT NULL,
  `stock_unit` enum('KG','Pieces') DEFAULT NULL,
  `stock_date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `stock_quantity`, `stock_unit`, `stock_date_added`, `stock_status`) VALUES
(1, 'Shrimp', '43.00', 'KG', '2024-09-21 03:27:48', 'active'),
(2, 'Parrot fish', '10.50', 'KG', '2024-09-07 04:21:17', 'active'),
(3, 'Red horse', '25.50', 'Pieces', '2024-09-21 03:29:21', 'active'),
(4, 'Royal litro', '17.00', 'Pieces', '2024-09-11 12:29:34', 'active'),
(5, 'Tamban tuloy', '55.00', 'KG', '2024-09-04 06:51:13', 'active'),
(6, 'San miguel', '55.00', 'Pieces', '2024-09-03 06:51:20', 'active'),
(7, 'Bangus', '72.00', 'KG', '2024-09-04 05:17:27', 'active'),
(8, 'Nukos', '3.25', 'KG', '2024-09-11 11:28:20', 'active'),
(9, 'Coke litro', '0.00', 'Pieces', '2024-09-18 23:56:02', 'active'),
(10, 'Tamban', '53.00', 'KG', '2024-09-09 22:14:49', 'active'),
(11, 'Eggs', '8.00', 'Pieces', '2024-09-06 04:20:04', 'active'),
(12, 'Flour', '43.00', 'KG', '2024-09-07 06:56:04', 'active'),
(13, 'Sprite', '1.00', 'Pieces', '2024-09-09 22:15:08', 'active'),
(14, 'Coke mismo', '0.00', 'Pieces', '2024-09-18 17:55:09', 'active'),
(22, 'Kamatis', '7.00', 'Pieces', '2024-10-10 01:55:11', 'active'),
(23, 'Test', '12.50', 'KG', '2024-10-11 00:19:16', 'active'),
(24, 'Mango float', '46.00', 'Pieces', '2024-10-20 19:45:06', 'active'),
(25, 'Shell', '100.00', 'KG', '2024-11-07 07:49:20', 'inactive'),
(26, 'Fish', '95.75', 'KG', '2024-11-07 07:51:23', 'inactive'),
(27, 'Royal mismo', '193.00', 'Pieces', '2024-11-07 08:59:13', 'inactive'),
(28, 'Kilaw', '10.00', 'KG', '2024-11-07 12:48:04', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `history_id` int(11) NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `updated_quantity` decimal(10,2) DEFAULT NULL,
  `previous_quantity` decimal(10,2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_action_type` enum('insert','update') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_history`
--

INSERT INTO `stock_history` (`history_id`, `stock_id`, `username`, `updated_quantity`, `previous_quantity`, `updated_at`, `last_action_type`) VALUES
(25, 2, NULL, '15.00', '10.00', '2024-09-25 17:39:34', 'update'),
(26, 1, NULL, '3.00', '2.00', '2024-09-25 17:39:45', 'insert'),
(27, 1, NULL, '20.00', '5.00', '2024-09-25 17:49:32', 'insert'),
(28, 1, NULL, '10.00', '25.00', '2024-09-25 18:01:48', 'update'),
(29, 1, NULL, '10.00', '10.00', '2024-09-25 19:36:09', 'insert'),
(30, 1, NULL, '15.00', '20.00', '2024-09-27 08:06:38', 'update'),
(31, 1, NULL, '10.00', '15.00', '2024-09-27 08:06:47', 'insert'),
(32, 1, NULL, '26.00', '25.00', '2024-09-27 12:09:13', 'update'),
(33, 1, NULL, '4.00', '26.00', '2024-09-27 12:09:42', 'insert'),
(34, 1, NULL, '5.00', '30.00', '2024-09-29 19:11:08', 'insert'),
(35, 2, NULL, '10.00', '15.00', '2024-10-10 13:29:11', 'update'),
(36, 2, NULL, '5.00', '10.00', '2024-10-10 13:29:16', 'update'),
(37, 2, NULL, '5.00', '5.00', '2024-10-10 13:29:26', 'insert'),
(38, 2, NULL, '9.00', '10.00', '2024-10-10 13:29:38', 'update'),
(39, 13, NULL, '15.00', '17.00', '2024-10-11 14:07:41', 'update'),
(40, 1, NULL, '0.50', '24.00', '2024-10-11 14:17:58', 'insert'),
(41, 3, NULL, '0.50', '25.00', '2024-10-11 14:39:40', 'insert'),
(42, 22, NULL, '5.00', '-1.00', '2024-10-12 20:02:33', 'insert'),
(43, 13, NULL, '5.00', '12.00', '2024-10-12 20:03:25', 'update'),
(44, 1, NULL, '5.00', '22.13', '2024-10-12 20:05:13', 'update'),
(45, 1, NULL, '3.00', '5.00', '2024-10-12 20:10:58', 'update'),
(46, 13, NULL, '3.00', '5.00', '2024-10-12 20:11:05', 'update'),
(47, 8, NULL, '3.00', '20.50', '2024-10-12 20:20:32', 'update'),
(48, 9, NULL, '3.00', '15.00', '2024-10-12 20:24:00', 'update'),
(49, 22, NULL, '10.00', '4.00', '2024-10-13 13:48:44', 'insert'),
(50, 23, NULL, '15.00', '1.50', '2024-10-13 13:49:15', 'insert'),
(51, 1, NULL, '15.00', '3.00', '2024-10-13 13:49:32', 'insert'),
(52, 2, NULL, '15.00', '9.00', '2024-10-13 13:49:38', 'update'),
(53, 8, NULL, '14.00', '3.00', '2024-10-13 13:49:44', 'update'),
(54, 9, NULL, '15.00', '3.00', '2024-10-13 13:49:54', 'update'),
(55, 13, NULL, '15.00', '3.00', '2024-10-13 13:50:01', 'update'),
(56, 22, NULL, '15.00', '-4.00', '2024-10-13 15:17:30', 'insert'),
(57, 22, NULL, '11.00', '-1.00', '2024-10-13 15:20:53', 'insert'),
(58, 9, NULL, '9.00', '1.00', '2024-10-13 15:50:08', 'insert'),
(59, 13, NULL, '0.00', '15.00', '2024-10-13 18:59:45', 'update'),
(60, 1, NULL, '18.00', '18.00', '2024-10-13 19:00:57', 'update'),
(61, 1, NULL, '0.00', '18.00', '2024-10-13 19:01:05', 'update'),
(62, 1, NULL, '5.00', '0.00', '2024-10-13 19:35:17', 'insert'),
(63, 1, NULL, '0.00', '5.00', '2024-10-13 19:59:28', 'update'),
(64, 1, NULL, '5.00', '0.00', '2024-10-13 20:36:58', 'insert'),
(65, 13, NULL, '5.00', '0.00', '2024-10-13 21:57:08', 'insert'),
(66, 13, NULL, '1.00', '-1.00', '2024-10-16 18:18:19', 'update'),
(67, 13, NULL, '1.00', '-1.00', '2024-10-16 18:19:28', 'update'),
(68, 13, NULL, '5.00', '-1.00', '2024-10-16 18:41:32', 'update'),
(69, 1, NULL, '20.00', '0.00', '2024-10-17 19:49:27', 'insert'),
(70, 9, NULL, '20.00', '0.00', '2024-10-17 19:49:53', 'insert'),
(71, 13, NULL, '10.00', '0.00', '2024-10-17 19:50:01', 'insert'),
(72, 22, NULL, '20.00', '0.00', '2024-10-17 19:50:14', 'insert'),
(73, 13, NULL, '6.00', '9.00', '2024-10-18 05:50:57', 'insert'),
(74, 9, NULL, '0.00', '18.75', '2024-10-18 20:02:25', 'update'),
(75, 2, NULL, '0.00', '13.00', '2024-10-18 21:24:25', 'update'),
(76, 1, NULL, '15.00', '18.25', '2024-10-19 11:09:18', 'update'),
(77, 8, NULL, '15.00', '13.75', '2024-10-19 11:09:26', 'update'),
(78, 1, NULL, '10.00', '19.51', '2024-10-21 11:03:30', 'update'),
(79, 8, NULL, '10.00', '19.51', '2024-10-21 11:03:37', 'update'),
(80, 8, NULL, '25.00', '27.00', '2024-10-21 19:02:52', 'update'),
(81, 1, NULL, '5.00', '15.00', '2024-10-23 02:13:49', 'insert'),
(82, 1, NULL, '5.00', '0.00', '2024-10-29 08:55:30', 'insert'),
(83, 1, NULL, '10.00', '0.00', '2024-10-31 07:21:23', 'insert'),
(84, 2, NULL, '10.00', '0.00', '2024-10-31 07:21:28', 'insert'),
(85, 13, NULL, '10.00', '0.00', '2024-10-31 07:21:37', 'update'),
(86, 22, NULL, '10.00', '3.00', '2024-10-31 10:34:37', 'insert'),
(87, 22, NULL, '20.00', '0.00', '2024-10-31 11:02:05', 'insert'),
(88, 1, NULL, '15.00', '0.00', '2024-11-03 22:49:21', 'insert'),
(89, 2, NULL, '15.00', '0.00', '2024-11-03 22:49:31', 'insert'),
(90, 4, NULL, '15.00', '0.00', '2024-11-03 22:49:36', 'insert'),
(91, 13, NULL, '10.00', '0.00', '2024-11-03 22:49:44', 'insert'),
(92, 4, NULL, '20.00', '0.00', '2024-11-06 08:01:21', 'insert'),
(93, 2, NULL, '1.00', '0.00', '2024-11-06 22:31:27', 'insert'),
(94, 2, NULL, '10.00', '1.00', '2024-11-06 22:31:57', 'insert'),
(95, 1, NULL, '50.00', '0.00', '2024-11-07 22:16:49', 'insert'),
(96, 1, NULL, '40.00', '50.00', '2024-11-07 22:17:08', 'update'),
(97, 24, NULL, '80.00', '0.00', '2024-11-07 22:36:55', 'update'),
(98, 27, NULL, '110.00', '100.00', '2024-11-07 23:59:23', 'insert'),
(99, 27, NULL, '220.00', '210.00', '2024-11-07 23:59:55', 'insert'),
(100, 27, NULL, '200.00', '430.00', '2024-11-08 00:00:14', 'update'),
(101, 27, NULL, '200.00', '200.00', '2024-11-08 08:33:11', 'update'),
(102, 2, NULL, '30.00', '0.00', '2024-11-08 08:34:53', 'insert'),
(103, 9, NULL, '15.00', '0.00', '2024-11-08 08:35:11', 'insert'),
(104, 14, NULL, '10.00', '0.00', '2024-11-08 08:35:23', 'insert'),
(105, 13, NULL, '10.00', '0.00', '2024-11-08 08:35:47', 'insert'),
(106, 4, NULL, '20.00', '0.00', '2024-11-08 09:44:36', 'update'),
(107, 8, NULL, '6.50', '6.25', '2024-11-08 14:08:18', 'update'),
(108, 1, NULL, '30.49', '30.50', '2024-11-08 14:32:09', 'update'),
(109, 1, NULL, '30.24', '30.24', '2024-11-08 15:09:09', 'insert'),
(110, 1, NULL, '40.00', '60.48', '2024-11-08 15:09:21', 'update'),
(111, 1, NULL, '30.00', '39.50', '2024-11-21 06:25:11', 'update'),
(112, 1, 'user_admin', '10.00', '30.00', '2024-11-21 12:17:59', 'insert'),
(113, 1, 'camps', '50.00', '40.00', '2024-11-21 12:26:48', 'insert'),
(114, 1, 'camps', '50.00', '90.00', '2024-11-21 12:44:29', 'update'),
(115, 2, 'camps', '20.00', '29.00', '2024-11-21 15:48:06', 'update'),
(116, 7, 'user_admin', '4.00', '76.00', '2024-11-22 19:35:22', 'insert'),
(117, 1, 'admin god', '5.00', '45.00', '2024-11-28 11:52:27', 'insert'),
(118, 28, 'admin_god15', '120.00', '100.00', '2024-12-06 15:49:45', 'insert'),
(119, 28, 'admin_god15', '10.00', '220.00', '2024-12-06 15:50:24', 'update');

-- --------------------------------------------------------

--
-- Table structure for table `table_numbers`
--

CREATE TABLE `table_numbers` (
  `table_id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_numbers`
--

INSERT INTO `table_numbers` (`table_id`, `table_number`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(35, 12),
(41, 13),
(42, 14),
(43, 15),
(47, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`account_username`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD UNIQUE KEY `security_code` (`security_code`);

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
-- Indexes for table `menu_order_count`
--
ALTER TABLE `menu_order_count`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_order_id` (`order_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Indexes for table `table_numbers`
--
ALTER TABLE `table_numbers`
  ADD PRIMARY KEY (`table_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=348;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=543;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `table_numbers`
--
ALTER TABLE `table_numbers`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_item_stocks`
--
ALTER TABLE `menu_item_stocks`
  ADD CONSTRAINT `fk_menu_item_stocks_menu_item` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`item_id`),
  ADD CONSTRAINT `fk_menu_item_stocks_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`),
  ADD CONSTRAINT `menu_item_stocks_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_item_stocks_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_order_count`
--
ALTER TABLE `menu_order_count`
  ADD CONSTRAINT `menu_order_count_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD CONSTRAINT `stock_history_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`stock_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
