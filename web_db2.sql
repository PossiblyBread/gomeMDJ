-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2024 at 11:18 AM
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
  `reset_token_hash` varchar(75) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `validation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `serial_num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `reset_token_hash`, `reset_token_expires_at`, `date_created`, `validation`) VALUES
(1, 10000, 'Admin', ' ', 'mdjbikes23@gmail.com', '2147483647', '$2y$10$OyKmhgHFSNFc.dobWOEsfumb7klN.lxrhPRViaR8JSwpNni2UrUAK', 'Admin', NULL, NULL, '2024-10-29 19:33:41', 'Validated'),
(67, 10001, 'adona', 'adrian', 'adrian2zero@gmail.com', '09184025526', '$2y$10$7HHG2tBwCCJFTnfyD08dB.510M9hKYKEEMafnJ843gncaIY13ipbe', 'IT_Support', NULL, NULL, '2024-11-19 05:10:05', 'Validated'),
(68, 10002, 'De Luna', 'Vivien', 'delunavivien27@gmail.com', '09995682821', '$2y$10$TFngW/WXwog82MGCkwV6KuxjfA5BChWk63HtqCfocC8/8KOZ2in3S', 'user', NULL, NULL, '2024-11-20 09:10:08', ''),
(69, 10003, 'Vicencio', 'Christian Kyle', 'kristyankayl26@gmail.com', '09214388440', '$2y$10$x9hWZTeqLnRDBO3hGZNtdOq09Px839HCfPbn/M8aA6eS.APWcBKym', 'user', NULL, NULL, '2024-11-20 11:13:34', '');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_tb`
--

CREATE TABLE `ledger_tb` (
  `id` int(11) NOT NULL,
  `receipt_num` varchar(25) NOT NULL,
  `serial_num` varchar(25) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_num` varchar(15) NOT NULL,
  `email` varchar(75) NOT NULL,
  `p_model` varchar(50) NOT NULL,
  `p_price` varchar(15) NOT NULL,
  `downpayment` varchar(15) NOT NULL,
  `remaining_balance` varchar(15) NOT NULL,
  `monthly_installment_price` varchar(15) NOT NULL,
  `total_price` varchar(15) NOT NULL,
  `date_time_paid` datetime NOT NULL DEFAULT current_timestamp(),
  `amount_paid` varchar(15) NOT NULL,
  `overdue_penalty` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ledger_tb`
--

INSERT INTO `ledger_tb` (`id`, `receipt_num`, `serial_num`, `full_name`, `phone_num`, `email`, `p_model`, `p_price`, `downpayment`, `remaining_balance`, `monthly_installment_price`, `total_price`, `date_time_paid`, `amount_paid`, `overdue_penalty`) VALUES
(68, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000.00', '63956.14', '5329.68', '', '2024-11-20 02:27:39', '0.00', ''),
(69, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '53956.14', '5329.68', '10000', '2024-11-20 02:28:00', '10000', '0'),
(70, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '63956.14', '5329.68', '10000', '2024-11-20 02:28:20', '0', '10000'),
(71, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '68956.14', '5329.68', '10000', '2024-11-20 02:28:47', '0', '5000'),
(72, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '73956.14', '5329.68', '10000', '2024-11-20 02:29:21', '0', '5000'),
(73, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '63956.14', '5329.68', '20000', '2024-11-20 02:29:46', '10000', '0'),
(79, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '53956.14', '5329.68', '30000', '2024-11-20 02:33:23', '10000', '0'),
(80, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '53956.14', '5329.68', '35000', '2024-11-20 02:35:22', '5000', '5000'),
(81, 'R-10001', '10001', 'adrian adona', '09184025526', 'adrian2zero@gmail.com', 'AITHUSSA PLUS', '70000', '7000', '0', '5329.68', '88956.14', '2024-11-20 02:36:19', '60000', '0');

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

--
-- Dumping data for table `products_img_id`
--

INSERT INTO `products_img_id` (`products_img_id`, `products_id`, `Images`, `image_type`) VALUES
(77, 101, 'COVER_AITHUSSA PLUS_10000_1731940748.webp', 'cover'),
(78, 101, 'PROD_AITHUSSA PLUS_1731940748_0.webp', 'thumbnail'),
(79, 101, 'PROD_AITHUSSA PLUS_1731940748_1.webp', 'thumbnail'),
(80, 101, 'PROD_AITHUSSA PLUS_1731940748_2.webp', 'thumbnail'),
(81, 101, 'PROD_AITHUSSA PLUS_1731940748_3.webp', 'thumbnail'),
(82, 0, 'COVER_prod 1_1731949834.webp', 'cover'),
(83, 0, 'PROD_prod 1_1731949834_0.webp', 'thumbnail'),
(84, 0, 'PROD_prod 1_1731949834_1.webp', 'thumbnail'),
(85, 0, 'PROD_prod 1_1731949834_2.webp', 'thumbnail'),
(86, 0, 'PROD_prod 1_1731949834_3.webp', 'thumbnail'),
(87, 0, 'COVER_sas_1731950037.webp', 'cover'),
(88, 0, 'PROD_sas_1731950037_0.webp', 'thumbnail'),
(89, 0, 'PROD_sas_1731950037_1.webp', 'thumbnail'),
(90, 0, 'PROD_sas_1731950037_2.webp', 'thumbnail'),
(91, 102, 'COVER_dsdsad_10000_1731950244.webp', 'cover'),
(92, 102, 'PROD_dsdsad_1731950244_0.webp', 'thumbnail'),
(94, 103, 'PROD_product test_1731950361_0.webp', 'thumbnail'),
(95, 103, 'PROD_product test_1731950361_1.webp', 'thumbnail'),
(96, 103, 'PROD_product test_1731950361_2.webp', 'thumbnail'),
(97, 103, 'PROD_product test_1731950361_3.webp', 'thumbnail'),
(98, 103, 'COVER_product test_1731950787.webp', 'cover'),
(99, 104, 'COVER_AITHUSSA PLUS_10000_1731956936.webp', 'cover'),
(100, 105, 'COVER_AURO S_10001_1731957065.webp', 'cover'),
(101, 106, 'COVER_DASHER PLUS_10002_1731957238.webp', 'cover'),
(102, 107, 'COVER_DISCOVERY_10003_1731957431.webp', 'cover'),
(103, 108, 'COVER_ERV2_10004_1731957591.webp', 'cover'),
(104, 109, 'COVER_E-TRUCK CONTAINER_10005_1731957729.webp', 'cover'),
(105, 110, 'COVER_E-TRUCK With ROOF_10006_1731957895.webp', 'cover'),
(106, 111, 'COVER_GC10_10007_1731958072.webp', 'cover'),
(107, 112, 'COVER_LION_10008_1731958225.webp', 'cover'),
(108, 113, 'COVER_MINI RIO PLUS_10009_1731958442.webp', 'cover'),
(109, 114, 'COVER_PRODUCT_10010_1732018498.webp', 'cover');

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

--
-- Dumping data for table `products_tb`
--

INSERT INTO `products_tb` (`products_id`, `prod_serial_num`, `p_model`, `p_wheels`, `p_motor_power`, `p_battery`, `p_max_speed`, `p_range`, `p_max_load`, `p_charging_time`, `p_variants`, `p_other_features`, `p_price`, `u_availability`) VALUES
(104, 10000, 'AITHUSSA PLUS', '3 wheels', '800W', '60V20AH', '45KM', '70', '300', '6-8 Hours', 'White, Black, Blue, Pink', 'Anti-Theft Alarm, Remote Control, Keyless Activation, Reverse Feature, Automatic Wiper, Metal Power Horn, LED Sensor Lights', '70000', 'Available'),
(105, 10001, 'AURO S', '2 wheels', '350W', '48V12AH', '40KM', '45', '120', '6 Hours', 'Red', 'Tube Type Tire', '24000', 'Available'),
(106, 10002, 'DASHER PLUS', '3 wheels', '650W', '48V20AH', '45KM', '50', '150', '6-8 Hours', 'Red,  Navy Blue, Yellow', 'Anti-Theft Alarm, Remote Control, Keyless Activation, Reverse Feature', '43000', 'Available'),
(107, 10003, 'DISCOVERY', '3 wheels', '1800W', '64V100AH', '40KM', '100', '550', '2-3 Hours', 'Green', 'Anti-Theft Alarm, Reverse Feature, Automatic Wiper', '32000', 'Available'),
(108, 10004, 'ERV2', '3 wheels', '350W', '48V20AH', '24-30KM', '', '200', '6-8 Hours', 'Light Blue', 'Automatic Wiper, Reverse Feature, Anti-Theft Alarm', '42800', 'Available'),
(109, 10005, 'E-TRUCK CONTAINER', '3 wheels', '1200W', '70V20AH', '40-50KM', '123', '500', '8-10 Hours', 'Red', 'Anti-Theft Alarm, Keyless Activation, Automatic Wiper, Remote Control, Reverse Feature', '95000', 'Available'),
(110, 10006, 'E-TRUCK With ROOF', '3 wheels', '1200W', '70V20AH', '40-50KM', '', '500', '8-10 Hours', 'Red, Blue, Black', 'Reverse Feature, Keyless Activation, Automatic Wiper, Anti-theft Alarm, Remote Control', '85000', 'Available'),
(111, 10007, 'GC10', '2 wheels', '350W', '48V12AH', '30-40KM', '', '120', '6-8 Hours', 'Yellow, Red, White', 'Anti-Theft Alarm', '19800', 'Available'),
(112, 10008, 'LION', '4 wheels', '1000W', '60V32AH', '35-40KM', '123', '300', '6-8 Hours', 'Red, Pink, Orange, Blue, White', 'Reverse Feature, Anti-Theft Alarm, Tubeless Tire, Automatic Wiper', '88000', 'Available'),
(113, 10009, 'MINI RIO PLUS', '3 wheels', '650W', '48V20AH', '35-45KM', '123', '123', '6-8 Hours', 'Red, Blue', 'Anti-Theft Alarm, Keyless Activation, Reverse Feature, Remote Control, Automatic Wiper', '53000', 'Unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `promos_tb`
--

CREATE TABLE `promos_tb` (
  `id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_image` varchar(100) NOT NULL,
  `p_monthly` varchar(20) NOT NULL,
  `p_year` varchar(10) NOT NULL,
  `total_discount` int(11) NOT NULL,
  `base_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promos_tb`
--

INSERT INTO `promos_tb` (`id`, `p_name`, `p_image`, `p_monthly`, `p_year`, `total_discount`, `base_price`) VALUES
(8, 'Vintage S', '../uploads/1.png', '2870', '12', 34440, 42000),
(9, 'Standard Cargo with Full Roof', '../uploads/2.png', '5666.67', '12', 68000, 85000),
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
  `date_time_updated` datetime DEFAULT NULL,
  `ticket_rating` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_updates`
--

CREATE TABLE `tickets_updates` (
  `id` int(11) NOT NULL,
  `serial_num` varchar(100) NOT NULL,
  `t_status` varchar(25) NOT NULL,
  `escalation_reason` text NOT NULL,
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

--
-- Dumping data for table `validated_tb`
--

INSERT INTO `validated_tb` (`id`, `serial_num`, `given_name`, `middle_name`, `last_name`, `marital_status`, `birth_date`, `phone_number`, `tin_number`, `email`, `present_address`, `permanent_address`) VALUES
(1, 10000, 'Admin', '', ' ', 'Not Married', '2024-11-18', '09090909090', '', 'mdjadmin23@gmail.com', 'darasa', 'darasa'),
(67, 10001, 'Adrian', 'Labarrete', 'Adona', 'Not Married', '2003-04-29', '09184025526', '', 'adrian2zero@gmail.com', 'San Pablo', 'San Pablo');

-- --------------------------------------------------------

--
-- Table structure for table `website_feedback`
--

CREATE TABLE `website_feedback` (
  `id` int(11) NOT NULL,
  `user_type` varchar(35) NOT NULL,
  `feedback_rating` varchar(5) NOT NULL,
  `feedback_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_feedback`
--

INSERT INTO `website_feedback` (`id`, `user_type`, `feedback_rating`, `feedback_comment`) VALUES
(23, 'Registered User', '0', ''),
(24, 'Validated User', '0', ''),
(25, 'Validated User', '0', ''),
(26, 'Validated User', '0', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `products_img_id`
--
ALTER TABLE `products_img_id`
  MODIFY `products_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `products_tb`
--
ALTER TABLE `products_tb`
  MODIFY `products_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `promos_tb`
--
ALTER TABLE `promos_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `tickets_updates`
--
ALTER TABLE `tickets_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `validated_tb`
--
ALTER TABLE `validated_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `website_feedback`
--
ALTER TABLE `website_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
