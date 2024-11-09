-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 06:40 PM
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
  `serial_num` int(25) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `email` varchar(80) NOT NULL,
  `phone_num` varchar(20) NOT NULL,
  `h_password` varchar(75) NOT NULL,
  `role` varchar(20) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `validation` varchar(10) NOT NULL,
  `login_count` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `serial_num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `date_created`, `updated_at`, `validation`, `login_count`) VALUES
(39, 10010, 'adona1', 'adrian', 'adrian@gmail.com', '09184025526', '$2y$10$aCFXyCmDS3dEiGzviTK2qu7HcNhSnklADjqqqQQ0zL6aFpKszp/Ee', 'IT_Support', '2024-10-29 19:28:53', '2024-10-29 19:28:53', 'validated', 0),
(40, 10011, ' ', 'Admin', 'mdjbikes23@gmail.com', '09109123123', '$2y$10$Jny/q8zSG5xcerTdDUKcY.jsmIbmAj02YcnBPm33g2UmTnAN1Dc7a', 'Admin', '2024-10-29 19:33:41', '2024-10-29 19:33:41', 'validated', 0),
(41, 10012, 'molinyawe', 'kent', 'kent@gmail.com', '2147483647', '$2y$10$qDu2lI8M5t9xIPlC5xsp/O981pmSO2NUgxY4h8j7yqdsBK5sB0kCu', 'IT_Support', '2024-10-29 20:33:06', '2024-10-29 20:33:06', '', 0),
(42, 10013, 'Vicencio', 'Kyle', 'kyle@gmail.com', '09096561324', '$2y$10$nIAIM4UW9ArbbdRbWYRQS.GNAGMY1k4K2wvk0ELAeFRnGliIXIaiy', 'user', '2024-10-29 23:05:12', '2024-10-29 23:05:12', 'Validated', 0),
(47, 10015, 'De luna Luna', 'Vivien', 'vivien@gmail.com', '32132132132', '$2y$10$Z0ZV53O2Vn.IcpfY46yayuMINJLv4d7Nmi/UOXezH9roMlZIwKcx6', 'user', '2024-10-30 19:17:35', '2024-10-30 19:17:35', 'Validated', 0),
(53, 10016, 'test', 'user', 'user@gmail.com', '46546546465', '$2y$10$QppPvLKMmdvRrj6jF2G2BuYSsX4PHGAoEemRd2WVOEcWv.mRCJy3G', 'user', '2024-10-31 03:58:30', '2024-10-31 03:58:30', 'Validated', 0),
(54, 10017, 'molinyawe', 'kent', 'ian@gmail.com', '76812378615', '$2y$10$ij0DnDJoxGWOvI2twidpuOUxbSogfJeMneUSuZVp4AuF908dZ0ToS', 'user', '2024-11-06 21:10:39', '2024-11-06 21:10:39', '', 0),
(60, 10018, 'adona', 'adrian', 'adrian2zero@gmail.com', '09184025526', '$2y$10$9eBj4bxyOxJASKVbaM4pqusK0HUeLAJDFoDEuYhRJYcn7zn8fs3RS', 'user', '2024-11-07 23:53:36', '2024-11-07 23:53:36', 'Validated', 0),
(61, 10019, 'adona', 'adrian', 'adrianadona@gmail.com', '09184025526', '$2y$10$PpsIxD4BsQBwzy/QOcD7ke8iGvRcSqhl94zG7XLKsM7EBdKrLCy5W', 'user', '2024-11-08 04:24:40', '2024-11-08 04:24:40', '', 0),
(62, 10020, 'adona', 'adrian', 'adrian2@gmail.com', '12312312312', '$2y$10$v/EEvkqoBQLRTxNWMwxUl.1Vd7HFi8Z6r0fSJcwKtf5.okmGJL5IG', 'user', '2024-11-09 09:50:29', '2024-11-09 16:50:29', '', 0),
(63, 10021, 'adona', 'adrian', 'adrian3@gmail.com', '12312312312', '$2y$10$nYVPrdCjsGLSBkPnlr5DLO1DBf2JuQV5SdkL2mOYKXkvLtcqw3Dk.', 'user', '2024-11-09 09:53:11', '2024-11-09 16:53:11', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ledger_tb`
--

CREATE TABLE `ledger_tb` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(100) NOT NULL,
  `due_date` datetime NOT NULL,
  `due_to_be_paid` int(100) NOT NULL,
  `due_paid` int(100) NOT NULL,
  `due_missed` int(100) NOT NULL,
  `due_paid_date` datetime NOT NULL,
  `dues_remaining` int(100) NOT NULL,
  `due_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_tb`
--

CREATE TABLE `products_tb` (
  `id` int(255) NOT NULL,
  `prod_serial_num` int(25) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `p_model` text DEFAULT NULL,
  `p_wheels` text DEFAULT NULL,
  `p_motor_power` int(11) DEFAULT NULL,
  `p_battery` text DEFAULT NULL,
  `p_max_speed` int(11) DEFAULT NULL,
  `p_range` int(11) DEFAULT NULL,
  `p_max_load` int(11) DEFAULT NULL,
  `p_charging_time` text DEFAULT NULL,
  `p_variants` text DEFAULT NULL,
  `p_other_features` text DEFAULT NULL,
  `p_price` int(11) DEFAULT NULL,
  `u_availability` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_tb`
--

INSERT INTO `products_tb` (`id`, `prod_serial_num`, `images`, `p_model`, `p_wheels`, `p_motor_power`, `p_battery`, `p_max_speed`, `p_range`, `p_max_load`, `p_charging_time`, `p_variants`, `p_other_features`, `p_price`, `u_availability`) VALUES
(34, 10005, '../products_tb/11.png', 'catified', '2 wheels', 123, '45', 123, 0, 0, 'fds', 'standing', 'peaopl', 123, ''),
(48, 10007, '../products_tb/7.png', 'scooter', '2 wheels', 450, '12312', 30, 0, 0, 'fds', '', '', 24500, ''),
(49, 10008, '../products_tb/8.png', 'daScoot', '2 wheels', 200, '300', 250, 350, 400, '450', '', '', 150000, ''),
(50, 10009, '../products_tb/9.png', 'green bike', '3 wheels', 100, '250', 200, 300, 350, '5', 'green', 'lights', 160000, ''),
(51, 10010, '../products_tb/10.png', 'red trike', '2 wheels', 3, '3', 3, 3, 3, '3', '', '', 1322, ''),
(52, 10011, '../products_tb/11.png', 'change', '2 wheels', 0, '12312', 123, 123, 123, '123', '', '', 123, NULL),
(53, 10012, '../products_tb/12.png', 'chane2', '2 wheels', 123, '123', 123, 123, 132, '123', '', '', 123, NULL),
(54, 10013, '../products_tb/18.png', 'chane3', '3 wheels', 123, '123', 123, 123, 123, '123', '123', '123', 123, ''),
(55, 10014, '../products_tb/14.png', 'change4', '3 wheels', 123, '132', 123, 123, 123, '123', '', '', 123, NULL),
(56, 10015, '../products_tb/15.png', '123', '4 wheels', 123, '123', 123, 123, 123, '123', '', '', 123, NULL),
(57, 10016, '../products_tb/16.png', '123', '4 wheels', 123, '123', 123, 123, 123, '123', '', '', 123, NULL),
(58, 10017, '../products_tb/16.png', '123', '3 wheels', 123, '123', 123, 123, 123, '123', '', '', 123, ''),
(60, 10018, '../products_tb/18.png', 'Bikerino', '3 wheels', 123, '123', 123, 123, 123, '123', '', '', 80000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promos_tb`
--

CREATE TABLE `promos_tb` (
  `id` int(10) NOT NULL,
  `p_name` varchar(50) DEFAULT NULL,
  `p_image` varchar(100) DEFAULT NULL,
  `p_monthly` varchar(20) DEFAULT NULL,
  `p_year` varchar(10) DEFAULT NULL,
  `total_discount` int(50) DEFAULT NULL,
  `base_price` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promos_tb`
--

INSERT INTO `promos_tb` (`id`, `p_name`, `p_image`, `p_monthly`, `p_year`, `total_discount`, `base_price`) VALUES
(1, 'E-Bike 1', '../products_tb/1.png', '3500', '123', 20, 80000),
(2, 'E-Bike 2', '../products_tb/2.png', '3500', '24', 0, 0),
(3, 'E-Bike 3', '../products_tb/3.png', '2750', '2', 0, 0),
(4, 'E-Bike 4', '../products_tb/4.png', '2000', '2', 0, 0),
(5, 'E-Bike 5', '../products_tb/5.png', '720', '1', 0, 0),
(6, 'E-Bike 6', '../products_tb/6.png', '1720', '1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(100) NOT NULL,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `user_email` varchar(75) NOT NULL,
  `phone_num` varchar(15) NOT NULL,
  `serial_num` int(100) NOT NULL,
  `type` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `t_status` varchar(25) NOT NULL,
  `assigned_to` varchar(75) NOT NULL,
  `priority` varchar(25) NOT NULL,
  `severity` varchar(25) NOT NULL,
  `escalation` varchar(25) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_time_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `first_name`, `last_name`, `user_email`, `phone_num`, `serial_num`, `type`, `description`, `t_status`, `assigned_to`, `priority`, `severity`, `escalation`, `date_time_created`, `date_time_updated`) VALUES
(130, 'Kyle', 'Vicencio', 'kyle@gmail.com', '2147483647', 10014, 'Technical', 'ticket test', 'Closed', 'adrian@gmail.com', '1', '2', '1', '2024-10-29 23:07:02', '2024-11-05 17:15:38'),
(131, 'Kyle', 'Vicencio', 'kyle@gmail.com', '2147483647', 10014, 'Technical', 'ticket test 2', 'Closed', 'adrian@gmail.com', '4', '2', '', '2024-10-29 23:15:13', '2024-11-05 17:15:07'),
(132, 'Kyle', 'Vicencio', 'kyle@gmail.com', '2147483647', 10014, 'Technical', 'ticket test 3', 'Closed', 'adrian@gmail.com', '2', '2', '1', '2024-10-29 23:15:17', '2024-10-30 13:43:07'),
(133, 'Kyle', 'Vicencio', 'kyle@gmail.com', '2147483647', 10014, 'Technical', 'ticket test 4', 'Pending', 'kent@gmail.com', '1', '3', '', '2024-10-29 23:15:21', '2024-10-29 23:23:59'),
(143, 'adrian', 'adona', 'adrianadona@gmail.com', '09292325526', 10017, 'Billing', 'where my money bro', 'Closed', 'adrian@gmail.com', '3', '3', '', '2024-10-30 12:19:23', '2024-10-30 14:03:28'),
(144, 'adrian', 'adona', 'adrianadona@gmail.com', '09092324433', 10018, 'Technical', 'cooldown dest', 'Closed', 'adrian@gmail.com', '1', '1', '1', '2024-10-30 12:22:07', '2024-11-05 17:15:50'),
(145, 'adrian', 'adona', 'adona@gmail.com', '09174025526', 10019, 'Technical', 'ticket cooldown test\n', 'new', '', '', '', '', '2024-10-30 14:34:22', '0000-00-00 00:00:00'),
(146, 'adrian', 'adona', 'adrianadona@gmail.com', '32145698732', 10020, 'Technical', 'ticket test 6 52', 'new', '', '', '', '', '2024-10-30 18:52:41', '0000-00-00 00:00:00'),
(147, 'adrian', 'adona', 'adrianadona@gmail.com', '21321321321', 10021, 'Technical', 'ticket test 7 02', 'new', '', '', '', '', '2024-10-30 19:02:55', '0000-00-00 00:00:00'),
(148, 'adrian', 'adona', 'adrianadona@gmail.com', '32165498732', 10022, 'Technical', 'ticket test 7 34', 'new', '', '', '', '', '2024-10-30 19:34:18', '0000-00-00 00:00:00'),
(149, 'Kyle', 'Vicencio', 'kyle@gmail.com', '32165498732', 10023, 'Technical', 'test 7 38', 'new', '', '', '', '', '2024-10-30 19:38:33', '0000-00-00 00:00:00'),
(150, 'Kyle', 'Vicencio', 'kyle@gmail.com', '12312312312', 10024, 'Mechanical', 'ticket test nov 9', 'new', '', '', '', '', '2024-11-09 05:50:24', '0000-00-00 00:00:00'),
(151, 'Kyle', 'Vicencio', 'kyle@gmail.com', '12312312312', 10025, 'Technical', 'Ticket Test Nov 9', 'new', '', '', '', '', '2024-11-09 20:21:36', '0000-00-00 00:00:00'),
(152, 'adrian', 'adona', 'adrian2zero@gmail.com', '12312312312', 10026, 'Technical', 'Ticket Test innerText', 'new', '', '', '', '', '2024-11-10 00:35:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `validated_tb`
--

CREATE TABLE `validated_tb` (
  `id` int(11) NOT NULL,
  `serial_num` int(25) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `validated_tb`
--

INSERT INTO `validated_tb` (`id`, `serial_num`, `given_name`, `middle_name`, `last_name`, `marital_status`, `birth_date`, `phone_number`, `tin_number`, `email`, `present_address`, `permanent_address`) VALUES
(42, 10013, 'kyle', 'vicencio', 'yes', 'Single', '2024-07-16', '123123123123', '8765876587665', 'kyle123@gmail.com', 'sa bhaya', 'sabahy'),
(47, 10015, 'bread', 'adrian', 'bread', 'Single', '2003-04-29', '09184025526', '123123123123', 'bread@gmail.com', 'bahay', 'bahayy'),
(53, 10016, 'Adrian Jr', 'Labarette', 'Adona', 'Single', '2003-04-29', '09184025526', '123123123123', 'adrian1@gmail.com', 'san pablo ', 'san pablo');

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
-- Indexes for table `promos_tb`
--
ALTER TABLE `promos_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `validated_tb`
--
ALTER TABLE `validated_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_tb`
--
ALTER TABLE `products_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `promos_tb`
--
ALTER TABLE `promos_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `validated_tb`
--
ALTER TABLE `validated_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
