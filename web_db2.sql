-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 12:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `serial_num` int(11) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `phone_num` varchar(20) DEFAULT NULL,
  `h_password` varchar(75) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `assigned_department` varchar(25) DEFAULT NULL,
  `reset_token_hash` varchar(75) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `validation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `serial_num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `assigned_department`, `reset_token_hash`, `reset_token_expires_at`, `date_created`, `validation`) VALUES
(1, 10000, 'Admin', ' ', 'mdjbikes23@gmail.com', '2147483647', '$2y$10$OyKmhgHFSNFc.dobWOEsfumb7klN.lxrhPRViaR8JSwpNni2UrUAK', 'Admin', '', '2c0334d3be63c9a6b0331ed32851525d156d24ea5d35796761cb6cc622386149', '2024-11-30 09:00:40', '2024-10-29 19:33:41', 'Validated');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_tb`
--

CREATE TABLE `ledger_tb` (
  `id` int(11) NOT NULL,
  `receipt_num` varchar(25) DEFAULT NULL,
  `serial_num` varchar(25) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_num` varchar(15) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `p_model` varchar(50) DEFAULT NULL,
  `p_price` varchar(15) DEFAULT NULL,
  `downpayment` varchar(15) DEFAULT NULL,
  `remaining_balance` varchar(15) DEFAULT NULL,
  `monthly_installment_price` varchar(15) DEFAULT NULL,
  `total_price` varchar(15) DEFAULT NULL,
  `date_time_paid` datetime NOT NULL DEFAULT current_timestamp(),
  `amount_paid` varchar(15) DEFAULT NULL,
  `overdue_penalty` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `products_img_id`
--

CREATE TABLE `products_img_id` (
  `products_img_id` int(11) NOT NULL,
  `products_id` int(11) DEFAULT NULL,
  `Images` varchar(100) DEFAULT NULL,
  `image_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `products_tb`
--

CREATE TABLE `products_tb` (
  `products_id` int(11) NOT NULL,
  `prod_serial_num` int(11) DEFAULT NULL,
  `p_model` text DEFAULT NULL,
  `p_wheels` text DEFAULT NULL,
  `p_motor_power` varchar(25) DEFAULT NULL,
  `p_battery` text DEFAULT NULL,
  `p_max_speed` varchar(25) DEFAULT NULL,
  `p_range` varchar(25) DEFAULT NULL,
  `p_max_load` varchar(25) DEFAULT NULL,
  `p_charging_time` text DEFAULT NULL,
  `p_variants` text DEFAULT NULL,
  `p_other_features` text DEFAULT NULL,
  `p_price` varchar(25) DEFAULT NULL,
  `u_availability` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `promos_tb`
--

CREATE TABLE `promos_tb` (
  `id` int(11) NOT NULL,
  `p_name` varchar(50) DEFAULT NULL,
  `p_image` varchar(100) DEFAULT NULL,
  `p_monthly` varchar(20) DEFAULT NULL,
  `p_year` varchar(10) DEFAULT NULL,
  `total_discount` int(11) DEFAULT NULL,
  `base_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promos_tb`
--

INSERT INTO `promos_tb` (`id`, `p_name`, `p_image`, `p_monthly`, `p_year`, `total_discount`, `base_price`) VALUES
(8, 'Vintage S', '../uploads/1.png', '2870', '12', 34440123, 42000),
(9, 'Standard Cargo', '../uploads/2.png', '5666.67', '12', 68000, 85000),
(10, '123', '../uploads/3.png', '123', '', 0, 0),
(11, '123', '../uploads/4.png', '123', '123', 123, 123),
(12, '123', '../uploads/5.png', '123', '123', 123, 123),
(13, '123', '../uploads/6.png', '123', '123', 123, 123);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `first_name` varchar(75) DEFAULT NULL,
  `last_name` varchar(75) DEFAULT NULL,
  `user_email` varchar(75) DEFAULT NULL,
  `phone_num` varchar(15) DEFAULT NULL,
  `serial_num` int(11) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `t_status` varchar(25) DEFAULT NULL,
  `assigned_to` varchar(75) DEFAULT NULL,
  `priority` varchar(25) DEFAULT NULL,
  `severity` varchar(25) DEFAULT NULL,
  `escalation` varchar(25) DEFAULT NULL,
  `escalation_reason` text DEFAULT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_updates`
--

CREATE TABLE `tickets_updates` (
  `id` int(11) NOT NULL,
  `serial_num` varchar(100) DEFAULT NULL,
  `t_status` varchar(25) DEFAULT NULL,
  `escalation_reason` text DEFAULT NULL,
  `date_time_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `validated_tb`
--

CREATE TABLE `validated_tb` (
  `id` int(11) NOT NULL,
  `serial_num` int(11) DEFAULT NULL,
  `given_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `marital_status` varchar(30) DEFAULT NULL,
  `birth_date` varchar(25) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `tin_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `website_feedback`
--

CREATE TABLE `website_feedback` (
  `id` int(11) NOT NULL,
  `user_type` varchar(35) DEFAULT NULL,
  `feedback_rating` varchar(5) DEFAULT NULL,
  `feedback_comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `products_img_id`
--
ALTER TABLE `products_img_id`
  ADD PRIMARY KEY (`products_img_id`) USING BTREE;

--
-- Indexes for table `products_tb`
--
ALTER TABLE `products_tb`
  ADD PRIMARY KEY (`products_id`) USING BTREE;

--
-- Indexes for table `promos_tb`
--
ALTER TABLE `promos_tb`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tickets_updates`
--
ALTER TABLE `tickets_updates`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `validated_tb`
--
ALTER TABLE `validated_tb`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `website_feedback`
--
ALTER TABLE `website_feedback`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `products_img_id`
--
ALTER TABLE `products_img_id`
  MODIFY `products_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `products_tb`
--
ALTER TABLE `products_tb`
  MODIFY `products_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `promos_tb`
--
ALTER TABLE `promos_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `tickets_updates`
--
ALTER TABLE `tickets_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `validated_tb`
--
ALTER TABLE `validated_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `website_feedback`
--
ALTER TABLE `website_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
