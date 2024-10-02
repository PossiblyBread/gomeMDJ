-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 07:19 PM
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
-- Database: `web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(255) NOT NULL,
  `Serial_Num` int(8) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_num` varchar(11) NOT NULL,
  `h_password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Serial_Num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `date_time`) VALUES
(16, 10000001, 'bing', 'bong', 'bingbong@gmail.com', '12312312312', '$2y$10$zPXO2vZkPjqQYvVE3rnDM.FrzQ0MMio4LSsOjQ/.Yy36RxBtbQPn.', '', '2024-08-21 13:33:25'),
(17, 10000001, 'waw', 'wew', 'wew@gmail.com', '12345678910', '$2y$10$ZfHOjTfmcz40JXl7lO/JEeg.a.hMBAn1.DPIAols73wn2elaiBeBW', '', '2024-08-21 13:33:25'),
(21, 0, 'adona', 'adrian', 'adona@gmail.com', '09091212123', '$2y$10$lzRPBTZhncq/4XZrM31UJ.2eb5c4zjb8fSyXnZ6UK4uyP6ICK3ZGu', '', '2024-08-21 13:33:53'),
(22, 0, 'bread', 'bnread', 'bread@gmail.comn', '09121231234', '$2y$10$reDP.yPur2bu5zWgATvHheRCDrtyCD/u.Nql9tOgxNRj3TAzV7Ud.', '', '2024-08-21 13:41:05'),
(23, 0, 'man', 'boy', 'manboy@gmail.com', '123123', '$2y$10$pW/ql43GQH2qcEFdr0g2neCx/ZsPBH3kIBMlLPAJLonhOp7WlgEJi', 'user', '2024-08-21 13:55:29'),
(24, 0, '', '', '', '', '', 'User', '2024-09-02 03:30:50'),
(25, 0, '', '', '', '', '', 'IT Support', '2024-09-02 03:31:19'),
(26, 0, '', '', '', '', '', 'IT Support', '2024-09-05 12:02:32'),
(27, 0, 'Molinyawe', 'Kent', 'kent@gmail.com', '09098765432', '$2y$10$RkczzdyO9E7qklY37bgDVesbILrw4pxYCiURpUvBGJpTKWCxoltUW', '', '2024-09-07 12:39:01'),
(29, 0, 'Adrian', 'Adon', 'adrian@gmail.com', '09090909090', '$2y$10$GllKsDOuuxhfvh/quZDbReNRAxcvdMfCS4eSWMstu4eSusZVJdXXO', 'user', '2024-09-10 15:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_tb`
--

CREATE TABLE `ledger_tb` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `due_date` datetime NOT NULL,
  `due_to_be_paid` int(255) NOT NULL,
  `due_paid` int(255) NOT NULL,
  `due_missed` int(255) NOT NULL,
  `due_paid_date` datetime NOT NULL,
  `dues_remaining` int(255) NOT NULL,
  `due_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_tb`
--

CREATE TABLE `products_tb` (
  `id` int(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `p_brand` text NOT NULL,
  `p_model` text NOT NULL,
  `p_year` text NOT NULL,
  `p_type` text NOT NULL,
  `p_frame_size` text NOT NULL,
  `p_wheel_size` text NOT NULL,
  `p_weight` text NOT NULL,
  `p_motor_type` text NOT NULL,
  `p_motor_power` text NOT NULL,
  `p_top_speed` text NOT NULL,
  `p_pedal_assist_levels` text NOT NULL,
  `p_throttle` text NOT NULL,
  `p_battery_type` text NOT NULL,
  `p_battery_capacity` text NOT NULL,
  `p_range` text NOT NULL,
  `p_charge_time` text NOT NULL,
  `p_gears` text NOT NULL,
  `p_brakes` text NOT NULL,
  `p_suspension` text NOT NULL,
  `p_tires` text NOT NULL,
  `p_frame_material` text NOT NULL,
  `p_fork` text NOT NULL,
  `p_handlebars` text NOT NULL,
  `p_display` text NOT NULL,
  `p_lighting` text NOT NULL,
  `p_connectivity` text NOT NULL,
  `p_fenders` text NOT NULL,
  `p_rack` text NOT NULL,
  `p_kickstand` text NOT NULL,
  `p_lock` text NOT NULL,
  `p_accessories` text NOT NULL,
  `p_warranty` text NOT NULL,
  `p_torque` text NOT NULL,
  `p_max_rider_weight` text NOT NULL,
  `p_water_resistance` text NOT NULL,
  `p_base_price` text NOT NULL,
  `p_optional_features` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_tb`
--

INSERT INTO `products_tb` (`id`, `images`, `p_brand`, `p_model`, `p_year`, `p_type`, `p_frame_size`, `p_wheel_size`, `p_weight`, `p_motor_type`, `p_motor_power`, `p_top_speed`, `p_pedal_assist_levels`, `p_throttle`, `p_battery_type`, `p_battery_capacity`, `p_range`, `p_charge_time`, `p_gears`, `p_brakes`, `p_suspension`, `p_tires`, `p_frame_material`, `p_fork`, `p_handlebars`, `p_display`, `p_lighting`, `p_connectivity`, `p_fenders`, `p_rack`, `p_kickstand`, `p_lock`, `p_accessories`, `p_warranty`, `p_torque`, `p_max_rider_weight`, `p_water_resistance`, `p_base_price`, `p_optional_features`) VALUES
(13, 'products_tb/Destination branch.png', 'saa', 'dfas', 'sdfaa', 'asfd', 'adsf', 'af', 'asdffd', 'asdf', '', '23', 'adsfv ', '', 'asdf ', 'cq5y3', 'svevtsh', 'awaecrg', 'rthv', 'wacvsrth', 'ctawvsWXC', 'VSTHAWC', 'BDYJAC', 'BCA', 'CACARVSsdt', 'ACAC', 'yvas', 'tavsrvy', 'svyv', 'asdf', '24rt', 'adfs', 'zxcv', '3524', 'adsf', '243', 'asdf', '', '234'),
(14, 'products_tb/Direction Map.png', 'saa', 'dfas', 'sdfaa', 'asfd', 'adsf', 'af', 'asdffd', 'asdf', '', '23', 'adsfv ', '', 'asdf ', 'cq5y3', 'svevtsh', 'awaecrg', 'rthv', 'wacvsrth', 'ctawvsWXC', 'VSTHAWC', 'BDYJAC', 'BCA', 'CACARVSsdt', 'ACAC', 'yvas', 'tavsrvy', 'svyv', 'asdf', '24rt', 'adfs', 'zxcv', '3524', 'adsf', '243', 'asdf', '', '234'),
(15, 'products_tb/Direction Start.png', 'saa', 'dfas', 'sdfaa', 'asfd', 'adsf', 'af', 'asdffd', 'asdf', '', '23', 'adsfv ', '', 'asdf ', 'cq5y3', 'svevtsh', 'awaecrg', 'rthv', 'wacvsrth', 'ctawvsWXC', 'VSTHAWC', 'BDYJAC', 'BCA', 'CACARVSsdt', 'ACAC', 'yvas', 'tavsrvy', 'svyv', 'asdf', '24rt', 'adfs', 'zxcv', '3524', 'adsf', '243', 'asdf', '', '234'),
(16, 'products_tb/Final Use Case.png', 'saa', 'dfas', 'sdfaa', 'asfd', 'adsf', 'af', 'asdffd', 'asdf', '', '23', 'adsfv ', '', 'asdf ', 'cq5y3', 'svevtsh', 'awaecrg', 'rthv', 'wacvsrth', 'ctawvsWXC', 'VSTHAWC', 'BDYJAC', 'BCA', 'CACARVSsdt', 'ACAC', 'yvas', 'tavsrvy', 'svyv', 'asdf', '24rt', 'adfs', 'zxcv', '3524', 'adsf', '243', 'asdf', '', '234'),
(17, 'products_tb/no labels.png', 'saa', 'dfas', 'sdfaa', 'asfd', 'adsf', 'af', 'asdffd', 'asdf', '', '23', 'adsfv ', '', 'asdf ', 'cq5y3', 'svevtsh', 'awaecrg', 'rthv', 'wacvsrth', 'ctawvsWXC', 'VSTHAWC', 'BDYJAC', 'BCA', 'CACARVSsdt', 'ACAC', 'yvas', 'tavsrvy', 'svyv', 'asdf', '24rt', 'adfs', 'zxcv', '3524', 'adsf', '243', 'asdf', '', '234'),
(18, 'products_tb/Adona, Adrian_Cover-Letter.pdf', '13', 'fssdf', '321231', 'hgfh', 'ehr', 'rdd', 'rtd', 'dtyt', 'dtf', 'dtj', 'jfyk', 'yfuf', 'dtyfu', 'dtt', 'jkgtd', 'yfutd', 'jyi', 'uyfyyf', 'ktdktd', 'jytdk', 'kuu', 'u5', 'kutid', 'yy', 'uut', 'uttx', 'tutdyr', 'yree', 'eet', 'yeye', 'yeye', 'ytl', 'kttkgc', '.kjlhjv', 'kkcg', '', 'kykgc');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_num` int(11) NOT NULL,
  `serial_num` varchar(255) NOT NULL,
  `type` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `t_status` varchar(50) NOT NULL,
  `escalation_stage` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `first_name`, `last_name`, `phone_num`, `serial_num`, `type`, `description`, `t_status`, `escalation_stage`, `date_time`) VALUES
(65, '33', '33', 33, '100', 'Billing', '33', 'Pending', 'P1', '2024-09-13 02:50:35'),
(66, '44', '44', 44, '100', 'Technical', '44', 'Pending', 'P1', '2024-09-13 02:51:36'),
(67, '44', '44', 44, '100', 'Technical', '44', 'Pending', 'P1', '2024-09-13 02:58:41'),
(68, 'adrian', 'adona', 2147483647, '100', 'Assist_Req', 'bread', 'Pending', 'P1', '2024-09-14 00:30:55'),
(69, 'adrian', 'adona', 2147483647, '100', 'Assist_Req', 'cheese', 'Pending', 'P1', '2024-09-14 00:35:19'),
(70, '345', '345', 345, '100', 'Mechanical', '345', 'Pending', 'P1', '2024-09-14 01:06:46'),
(71, 'adrian', 'adona', 2147483647, '100', 'Mechanical', 'cheese dog with a long foorlong', 'Pending', 'P1', '2024-09-14 01:16:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_tb`
--
ALTER TABLE `products_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_tb`
--
ALTER TABLE `products_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
