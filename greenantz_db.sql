-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 08:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenantz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `sale_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `product_id`, `quantity`, `total_income`, `sale_date`) VALUES
(1, 1, 50, 0.00, '2024-06-13'),
(2, 2, 50, 949.50, '2024-06-13'),
(3, 3, 50, 799.50, '2024-06-13'),
(4, 4, 50, 999.50, '2024-06-13'),
(5, 5, 50, 1249.50, '2024-06-13'),
(6, 6, 50, 549.50, '2024-06-13'),
(7, 7, 50, 899.50, '2024-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `login_audit`
--

CREATE TABLE `login_audit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_type` enum('login','logout','new user registration') DEFAULT NULL,
  `event_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_audit`
--

INSERT INTO `login_audit` (`id`, `user_id`, `event_type`, `event_time`) VALUES
(1, 14, 'new user registration', '2024-06-10 16:02:32'),
(2, 1, 'login', '2024-06-10 16:03:07'),
(3, 1, 'logout', '2024-06-10 16:22:02'),
(4, 2, 'login', '2024-06-10 16:22:13'),
(5, 2, 'logout', '2024-06-10 16:23:01'),
(6, 1, 'login', '2024-06-10 16:23:06'),
(7, 1, 'logout', '2024-06-10 16:41:59'),
(8, 12, 'login', '2024-06-10 16:42:29'),
(9, 12, 'logout', '2024-06-10 16:43:13'),
(10, 1, 'login', '2024-06-10 16:43:18'),
(11, 2, 'login', '2024-06-12 15:14:00'),
(12, 2, 'logout', '2024-06-12 15:38:59'),
(13, 1, 'login', '2024-06-12 15:39:25'),
(14, 1, 'logout', '2024-06-12 15:40:32'),
(15, 3, 'login', '2024-06-12 15:40:37'),
(16, 2, 'login', '2024-06-13 12:28:46'),
(17, 2, 'login', '2024-06-13 13:00:01'),
(18, 2, 'logout', '2024-06-13 13:08:34'),
(19, 2, 'login', '2024-06-13 13:11:03'),
(20, 2, 'logout', '2024-06-13 13:11:22'),
(21, 3, 'login', '2024-06-13 13:11:55'),
(22, 3, 'logout', '2024-06-13 13:12:02'),
(23, 1, 'login', '2024-06-13 13:12:07'),
(24, 1, 'logout', '2024-06-13 13:56:39'),
(25, 15, 'new user registration', '2024-06-13 14:36:38'),
(26, 16, 'new user registration', '2024-06-13 14:38:15'),
(27, 17, 'new user registration', '2024-06-13 14:44:19'),
(28, 18, 'new user registration', '2024-06-13 14:47:03'),
(29, 19, 'new user registration', '2024-06-13 14:47:53'),
(30, 20, 'new user registration', '2024-06-13 14:48:58'),
(31, 21, 'new user registration', '2024-06-13 14:54:29'),
(32, 22, 'new user registration', '2024-06-13 14:59:47'),
(33, 22, 'login', '2024-06-13 15:05:26'),
(34, 23, 'new user registration', '2024-06-13 15:15:29'),
(35, 24, 'new user registration', '2024-06-13 15:18:50'),
(36, 25, 'new user registration', '2024-06-13 15:19:57'),
(37, 25, 'login', '2024-06-13 15:20:26'),
(38, 25, 'logout', '2024-06-13 15:21:25'),
(39, 1, 'login', '2024-06-13 15:21:31'),
(40, 1, 'logout', '2024-06-13 15:22:13'),
(41, 25, 'login', '2024-06-13 15:22:18'),
(42, 25, 'logout', '2024-06-13 15:22:45'),
(43, 1, 'login', '2024-06-13 15:23:52'),
(44, 1, 'logout', '2024-06-13 15:26:04'),
(45, 2, 'login', '2024-06-13 15:26:13'),
(46, 2, 'logout', '2024-06-13 15:27:26'),
(47, 1, 'login', '2024-06-13 15:27:45'),
(48, 1, 'logout', '2024-06-13 15:28:08'),
(49, 25, 'login', '2024-06-13 15:28:13'),
(50, 25, 'logout', '2024-06-13 15:45:56'),
(51, 1, 'login', '2024-06-13 15:46:01'),
(52, 1, 'logout', '2024-06-13 15:48:19'),
(53, 26, 'new user registration', '2024-06-13 16:40:31'),
(54, 26, 'login', '2024-06-13 16:41:04'),
(55, 1, 'login', '2024-06-13 16:42:09'),
(56, 26, 'logout', '2024-06-13 17:07:04'),
(57, 1, 'login', '2024-06-13 17:07:08'),
(58, 2, 'login', '2024-06-13 17:07:48'),
(59, 26, 'login', '2024-06-13 17:41:46'),
(60, 1, '', '2024-06-13 18:01:39'),
(61, 1, '', '2024-06-13 18:02:35'),
(62, 1, '', '2024-06-13 18:10:57'),
(63, 1, '', '2024-06-13 18:14:44'),
(64, 1, 'logout', '2024-06-13 18:15:46'),
(65, 3, 'login', '2024-06-13 18:15:54'),
(66, 3, 'logout', '2024-06-13 18:17:30'),
(67, 1, 'login', '2024-06-13 18:17:33'),
(68, 1, 'logout', '2024-06-13 18:21:15'),
(69, 5, 'login', '2024-06-13 18:21:21'),
(70, 5, 'logout', '2024-06-13 18:21:43'),
(71, 1, 'login', '2024-06-13 18:22:02'),
(72, 1, 'logout', '2024-06-13 18:27:04'),
(73, 5, 'login', '2024-06-13 18:29:22'),
(74, 1, 'login', '2024-06-13 18:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 600, 12.99),
(2, 1, 5, 600, 24.99);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','cancelled','finished') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `status`, `total_amount`) VALUES
(1, 2, '2024-05-27 19:16:37', 'pending', 22788.00),
(2, 2, '2024-05-27 19:23:22', 'pending', 9995.00),
(3, 2, '2024-05-27 19:30:35', 'pending', 999.50),
(4, 3, '2024-05-27 20:30:27', 'pending', 4996.50),
(5, 4, '2024-05-27 21:36:17', 'pending', 11394.00),
(6, 4, '2024-05-27 21:41:59', 'pending', 799.50),
(7, 2, '2024-05-27 21:44:34', 'pending', 1948.50),
(8, 4, '2024-05-27 21:50:31', 'pending', 3198.00),
(9, 2, '2024-05-27 22:43:07', 'pending', 649.50),
(10, 2, '2024-05-27 22:53:19', 'pending', 649.50),
(11, 2, '2024-05-27 22:58:54', 'pending', 649.50),
(12, 2, '2024-05-27 23:00:15', 'pending', 1948.50),
(13, 2, '2024-05-27 23:01:19', 'pending', 649.50),
(14, 2, '2024-05-27 23:06:02', 'pending', 1948.50),
(15, 3, '2024-05-27 23:20:00', 'pending', 649.50),
(16, 3, '2024-05-27 23:21:01', 'pending', 649.50),
(17, 3, '2024-05-27 23:22:11', 'pending', 10444.50),
(18, 3, '2024-05-27 23:29:33', 'pending', 12742.50),
(19, 3, '2024-05-27 23:33:21', 'pending', 649.50),
(20, 3, '2024-05-27 23:33:48', 'pending', 16237.50),
(21, 3, '2024-05-27 23:56:16', 'pending', 9093.00),
(22, 2, '2024-05-28 00:59:10', 'pending', 4546.50),
(23, 6, '2024-05-28 01:14:39', 'pending', 25534.50),
(24, 2, '2024-06-10 10:22:54', 'pending', 18590.00),
(25, 12, '2024-06-10 10:42:57', 'pending', 2598.00),
(26, 12, '2024-06-10 10:43:10', 'pending', 2598.50),
(27, 2, '2024-06-12 09:14:32', 'pending', 2548.50),
(28, 2, '2024-06-12 09:37:11', 'pending', 4947.00),
(29, 2, '2024-06-12 09:38:54', 'pending', 1599.00),
(30, 3, '2024-06-12 09:52:26', 'pending', 2598.00),
(31, 2, '2024-06-13 06:28:57', 'pending', 649.50),
(32, 25, '2024-06-13 09:21:17', 'pending', 11394.00),
(33, 26, '2024-06-13 10:42:59', 'pending', 2049.00),
(34, 2, '2024-06-13 11:08:39', 'pending', 549.50),
(35, 2, '2024-06-13 11:18:31', 'pending', 799.50),
(36, 2, '2024-06-13 11:25:59', 'pending', 999.50),
(37, 2, '2024-06-13 11:29:48', 'pending', 899.50),
(38, 26, '2024-06-13 11:41:57', 'pending', 649.50),
(39, 26, '2024-06-13 11:45:12', 'pending', 649.50),
(40, 3, '2024-06-13 12:16:34', 'pending', 649.50),
(41, 5, '2024-06-13 12:21:37', 'pending', 649.50),
(42, 5, '2024-06-13 12:29:32', 'pending', 949.50),
(43, 5, '2024-06-13 12:33:18', 'pending', 799.50),
(44, 5, '2024-06-13 12:34:56', 'pending', 3398.00),
(45, 5, '2024-06-13 12:41:29', 'pending', 1599.00),
(46, 5, '2024-06-13 12:45:40', 'pending', 6096.50),
(47, 5, '2024-06-13 12:50:31', 'pending', 6096.50);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(10) NOT NULL,
  `image_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `stock`, `image_path`) VALUES
(1, 'Recycled Concrete Hollow Blocks 4', 12.99, 4300, 'pics/recycled hollow block.jpg'),
(2, 'Recycled Concrete Hollow Blocks 6', 18.99, 4750, 'pics/recycled hollow block.jpg'),
(3, 'EcoFriendly Clay Bricks 8', 15.99, 4700, 'pics/ecofriendly bricks.jpg'),
(4, 'EcoFriendly Clay Bricks 12', 19.99, 4500, 'pics/ecofriendly bricks.jpg'),
(5, 'Recycled Concrete Hollow Blocks 12', 24.99, 4850, 'pics/recycled hollow block.jpg'),
(6, 'EcoFriendly Clay Bricks 4', 10.99, 4850, 'uploads/ecofriendly bricks.jpg'),
(7, 'EcoFriendly Clay Bricks 10', 17.99, 4550, 'uploads/ecofriendly bricks.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','finished','cancelled') NOT NULL DEFAULT 'pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `status`, `transaction_date`, `user_id`) VALUES
(1, 1, 50, 12.00, 649.50, 'cancelled', '2024-06-13 12:50:31', 5),
(2, 2, 50, 18.00, 949.50, 'pending', '2024-06-13 12:50:31', 5),
(3, 3, 50, 15.00, 799.50, 'pending', '2024-06-13 12:50:31', 5),
(4, 4, 50, 19.00, 999.50, 'pending', '2024-06-13 12:50:31', 5),
(5, 5, 50, 24.00, 1249.50, 'pending', '2024-06-13 12:50:31', 5),
(6, 6, 50, 10.00, 549.50, 'pending', '2024-06-13 12:50:31', 5),
(7, 7, 50, 17.00, 899.50, 'pending', '2024-06-13 12:50:31', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `cID` int(50) NOT NULL,
  `userType` int(1) NOT NULL,
  `cName` text NOT NULL,
  `cEmail` varchar(50) NOT NULL,
  `cPass` varchar(256) NOT NULL,
  `cPic` varchar(500) NOT NULL,
  `cConNum` int(20) NOT NULL,
  `cAdd` varchar(50) NOT NULL,
  `verification_code` varchar(10) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`cID`, `userType`, `cName`, `cEmail`, `cPass`, `cPic`, `cConNum`, `cAdd`, `verification_code`, `email_verified_at`) VALUES
(1, 1, 'Frances Eleanor D. Legaspi', 'legaspileanne@gmail.com', '$2y$10$U..lUfxJ5zg5C4imeqh/7eAyx7n63ik9iWQvLQIeCW1VHi8p9/g8y', '', 2147483647, 'pulilan, bulacan', NULL, '2024-06-13 14:09:16'),
(2, 0, 'Jericho Lance Mendoza', 'eko@gmail.com', '$2y$10$2bB8c4DQFiQz2F3NU5.lF.B6UbsFjx0v9c4.ZbuPGrD4b67FOhkb2', 'uploads/27.png', 2147483647, 'Bustos, Bulacan', NULL, '2024-06-13 14:09:16'),
(3, 0, 'Renz Gabriel Orolfo', 'Renz@gmail.com', '$2y$10$tGPcZfxp3HWwqRWHvlyZm.2lYufdemao2eepj3.JIm9upIfL.Zm82', '', 923671239, 'Baliwag, Bulacan', NULL, '2024-06-13 14:09:16'),
(4, 0, 'Justin Dino', 'justin@gmail.com', '$2y$10$KQs/Z.g4AExrqbEK2Lmp8..WhA6EvG6IE3hzkMDqrPK0LuvN1uK6O', '', 912739623, ' Bustos, Bulacan', NULL, '2024-06-13 14:09:16'),
(5, 0, 'Bazil Marantan', 'baz@gmail.com', '$2y$10$LCy5TEagfNdAZc9tPqZxHugz66JSwysrQmLlfUOwJG8JdqO51esd6', '', 2147483647, 'Baliwag, Bulacan', NULL, '2024-06-13 14:09:16'),
(6, 0, 'Nathaniel Garcia', 'nat@gmail.com', '$2y$10$EtyGdbd/iEGu1ukXvAkdI.F1QsW3zgcYtHue09iWtc.uBB4tFlMzG', 'uploads/IMG_2107.jpg', 2147483647, 'San Ildefonso, Bulacan', NULL, '2024-06-13 14:09:16'),
(7, 0, 'Mike Diesel Sulo', 'mike@gmail.com', '$2y$10$KTNwxZOfoBdnF6fux7oO..Br7mYFBQZfKC2dV7shbETWSk.mqTtI6', '', 2147483647, 'San Miguel, Bulacan', NULL, '2024-06-13 14:09:16'),
(8, 0, 'Eydie Altera', 'eyds@gmail.com', '$2y$10$i8hZpijfuUBc1/oi3djbderWd/XrtQ8g.L0iM5QzNypZflhH00Hbm', '', 2147483647, 'Lumbac, Pulian,Bulacan', NULL, '2024-06-13 14:09:16'),
(9, 0, 'Em Bernardino', 'em@gmail.com', '$2y$10$/YrN3YCgxNII0ni0kT.XR.vWNuK27CCuhcWHffEBvuUYq/Q626pxe', '', 2147483647, 'cutcot, pulian, bulacan', NULL, '2024-06-13 14:09:16'),
(10, 0, 'Eleanor Legaspi', 'elle@gmail.com', '$2y$10$4o702xK4aSqOLEsRgQlMi.m9/cC9Rf78prT/Bp7Kog70Ki6nkXY5e', '', 897123577, 'Sampaloc, Manila', NULL, '2024-06-13 14:09:16'),
(11, 1, 'Cecilia Legaspi', 'Cecilia@gmail.com', '$2y$10$ITzJo.AiYiGGIU34zvkgUuwB2ZTRc8wHeXll7zKchRx315TgvJA3a', '', 981238715, 'Gapan, Nueva Ecija', NULL, '2024-06-13 14:09:16'),
(12, 0, 'Reiner Eusebio', 'tenten@gmail.com', '$2y$10$/X7tp0Q3EwMoeAkaYM4rb.gW/Kw.Tzzr3LpsjiIWG3siYPbuKLUSG', '', 2147483647, 'Pulilan, Bulacan', NULL, '2024-06-13 14:09:16'),
(13, 0, 'Destiny Mosqueda', 'des@gmail.com', '$2y$10$0c/PZcS55pVU.bek5Pk49O19GMowv4Jt7iEKT5Lip47K/yKzjYeVC', '', 98236772, 'Pulilan', NULL, '2024-06-13 14:09:16'),
(14, 0, 'Francisco Legaspi Jr.', 'isko@gmail.com', '$2y$10$20EPCNnLUEZVlKnR5K9Juu266ck4.BI1/dytj9pXPg4P5zR7A6b12', '', 2147483647, 'Obando, Bulacan', NULL, '2024-06-13 14:09:16'),
(24, 0, 'Akira Legaspi', 'akira@gmail.com', '$2y$10$hhYVkac7M.GnhHLRZJyy0ONq.WT5HKLNSMABElwN1qBdt70M0lz4O', '', 97665521, 'Pulilan, Bulacan', '149911', NULL),
(25, 0, 'Akira Legaspi', 'hanniehan1995@gmail.com', '$2y$10$s1e41ocGwBLe9yswMuVeL.7YTpFPVhTBnQ9LC5zi3hGBhizQh/.C6', '', 987663215, 'Pulilan, Bulacan', '283714', '2024-06-13 15:20:18'),
(26, 0, 'Renz Orolfo', 'orolforenz7@gmail.com', '$2y$10$3ibzbaMxaX.IwxIul1uxtO0lUKIiqN70Ma0uY0o2.2RcupbPX3uYm', '', 2147483647, 'Baliwag, Bulacan', '280138', '2024-06-13 16:40:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `login_audit`
--
ALTER TABLE `login_audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`cID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_audit`
--
ALTER TABLE `login_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `cID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`cID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`cID`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`cID`),
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
