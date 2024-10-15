-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 12:44 AM
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

INSERT INTO `accounts` (`id`, `serial_num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `date_time`) VALUES
(30, 10000, 'adona', 'adrian', 'adrian@gmail.com', '09184025526', '$2y$10$O0HVcBoA06RxRgnAWWBDe.UfUP7vv3tPxI4YSWUx4PDtN4gv/0kRu', 'user', '2024-10-11 21:41:30'),
(31, 10000, 'Proxy', 'Admin', 'proxyadmin@gmail.com', '09091234123', '$2y$10$e7lpd1VFjdWwE8Dg/YP0JuMvKpczLuJtizS/bf4ZdedIceUw/1V2K', 'Admin', '2024-10-11 21:46:43'),
(32, 10017, 'notadona', 'adrian', 'adon@gmail.com', '09091818123', '$2y$10$jpzNFU7agX2ehag4BbN8e.xJLHgvOisKt5SeTAKMrU7eGbjhXZpqy', 'IT_Support', '2024-10-12 08:45:09'),
(33, 10019, 'adon3', 'adrian3', 'adrianadona@gmail.com', '09184025526', '$2y$10$25KJamc46FmMC0p8hIF61OmgNbfx0Y32kTbPyK7XvZngTKklmdptu', 'IT_Support', '2024-10-14 05:34:39');

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
  `serial_num` int(25) NOT NULL,
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

INSERT INTO `products_tb` (`id`, `serial_num`, `images`, `p_brand`, `p_model`, `p_year`, `p_type`, `p_frame_size`, `p_wheel_size`, `p_weight`, `p_motor_type`, `p_motor_power`, `p_top_speed`, `p_pedal_assist_levels`, `p_throttle`, `p_battery_type`, `p_battery_capacity`, `p_range`, `p_charge_time`, `p_gears`, `p_brakes`, `p_suspension`, `p_tires`, `p_frame_material`, `p_fork`, `p_handlebars`, `p_display`, `p_lighting`, `p_connectivity`, `p_fenders`, `p_rack`, `p_kickstand`, `p_lock`, `p_accessories`, `p_warranty`, `p_torque`, `p_max_rider_weight`, `p_water_resistance`, `p_base_price`, `p_optional_features`) VALUES
(22, 0, 'products_tb/cat-in-box.png', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_num` int(11) NOT NULL,
  `serial_num` int(25) NOT NULL,
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
(90, 'adrian', 'adona', 2147483647, 10000, 'Technical', 'test 1', 'Pending', 'P1', '2024-10-11 22:50:23'),
(91, 'adrian', 'adona', 2147483647, 10001, 'Technical', 'test1', 'Pending', 'P1', '2024-10-11 22:52:56'),
(92, 'adrian', 'adona', 2147483647, 10002, 'Mechanical', 'test 1', 'Pending', 'P1', '2024-10-11 22:56:43'),
(93, 'adrian', 'asd', 44, 100, 'Technical', 'breafd', 'Pending', 'P1', '2024-10-11 23:11:25'),
(94, 'adrian', 'adona', 44, 10003, 'Technical', 'bread2', 'Pending', 'P1', '2024-10-11 23:15:27'),
(95, 'bread', 'asd', 44, 10004, 'Technical', 'asdas', 'Pending', 'P1', '2024-10-11 23:17:55'),
(96, 'adrian', 'asd', 2147483647, 10005, 'Technical', 'asdads', 'Pending', 'P1', '2024-10-11 23:19:18'),
(97, 'adrian', 'asd', 2147483647, 10006, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', '2024-10-11 23:20:39'),
(98, 'adrian', 'asd', 2147483647, 10007, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', '2024-10-11 23:20:41'),
(99, 'adrian', 'asd', 2147483647, 10008, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', '2024-10-11 23:20:42'),
(100, 'adrian', 'asd', 2147483647, 10009, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', '2024-10-11 23:20:44'),
(101, 'bread', 'magic', 2147483647, 10010, 'Mechanical', '1231', 'Pending', 'P1', '2024-10-11 23:21:56'),
(102, 'adrian', 'adona', 2147483647, 10011, 'Technical', 'jail time', 'Pending', 'P1', '2024-10-11 23:24:41'),
(103, 'adrian', 'adona', 2147483647, 10012, 'Technical', 'magical bread ding dong', 'new', 'P1', '2024-10-11 23:39:51'),
(104, 'adrian', 'adona', 2147483647, 10013, 'Technical', 'vlad', 'new', 'P1', '2024-10-11 23:51:20'),
(105, 'adrian', 'ad', 0, 10014, 'Technical', 'lplpl', 'new', 'P1', '2024-10-12 00:32:46'),
(106, 'adrian', 'adona', 2147483647, 10015, 'Technical', 'asda', 'new', 'P1', '2024-10-12 00:34:06'),
(107, 'adrian', 'adona', 2147483647, 10016, 'Technical', 'asda', 'new', 'P1', '2024-10-12 00:34:10'),
(108, 'new', 'new', 0, 10017, 'Technical', 'new', 'new', 'P1', '2024-10-13 14:08:55'),
(109, 'new', 'new', 0, 10018, 'Technical', 'new', 'new', 'P1', '2024-10-13 14:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_assigned`
--

CREATE TABLE `ticket_assigned` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_num` int(11) NOT NULL,
  `serial_num` int(25) NOT NULL,
  `type` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `t_status` varchar(50) NOT NULL,
  `escalation_stage` varchar(255) NOT NULL,
  `assigned_to_email` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_assigned`
--

INSERT INTO `ticket_assigned` (`id`, `first_name`, `last_name`, `phone_num`, `serial_num`, `type`, `description`, `t_status`, `escalation_stage`, `assigned_to_email`, `date_time`) VALUES
(43, '', '', 2147483647, 10001, 'Technical', 'test1', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 05:48:48'),
(44, '', '', 2147483647, 10005, 'Technical', 'asdads', 'Pending', 'P1', 'adrianadona@gmail.com', '2024-10-14 05:48:51'),
(45, '', '', 44, 10004, 'Technical', 'asdas', 'Pending', 'P1', 'adrianadona@gmail.com', '2024-10-14 05:48:53'),
(46, '', '', 44, 100, 'Technical', 'breafd', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 05:48:54'),
(47, '', '', 2147483647, 10002, 'Mechanical', 'test 1', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 05:48:56'),
(48, '', '', 44, 10003, 'Technical', 'bread2', 'Pending', 'P1', 'adrianadona@gmail.com', '2024-10-14 05:48:59'),
(49, '', '', 0, 0, '', '', 'Pending', 'P1', '', '2024-10-14 05:55:10'),
(50, '', '', 2147483647, 10006, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 05:56:03'),
(51, '', '', 2147483647, 10007, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 05:56:23'),
(52, 'adrian', 'asd', 2147483647, 10008, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 06:01:19'),
(53, 'adrian', 'asd', 2147483647, 10009, 'Technical', 'asdasdasdasdas123', 'Pending', 'P1', 'adrianadona@gmail.com', '2024-10-14 06:01:21'),
(54, 'bread', 'magic', 2147483647, 10010, 'Mechanical', '1231', 'Pending', 'P1', 'adon@gmail.com', '2024-10-14 06:01:23'),
(55, 'adrian', 'adona', 2147483647, 10011, 'Technical', 'jail time', 'Pending', 'P1', 'adrianadona@gmail.com', '2024-10-14 06:01:24');

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
-- Indexes for table `ticket_assigned`
--
ALTER TABLE `ticket_assigned`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_tb`
--
ALTER TABLE `products_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `ticket_assigned`
--
ALTER TABLE `ticket_assigned`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
