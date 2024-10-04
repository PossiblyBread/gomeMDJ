-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 06:44 PM
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
(19, 'products_tb/cat-in-box.png', 'asghc', 'g', 'fghjk', 'ghjk', 'jhkg', 'hjg', 'jghk', 'ghj', 'ghjk', 'hgj', 'hjgk', 'h', 'ghjk', 'hjhk', 'kghj', 'hkgj', 'kghj', 'ghj', 'ghjk', 'ghjk', 'kghj', '', 'ghjk', 'ghjk', 'ghjkgk', 'hjgh', 'kghjk', '', 'ghjkgh', 'g', 'hjkhjg', 'ghjk', 'ghj', 'gjkh', 'ghkj', 'hjgk', 'gjhk'),
(20, 'products_tb/cat3.jpg', 'ujft', 'ghuk', 'vbj', 'vgj', 'ftyu', 'vhj', 'vgjh', 'tudy', 'cvghj', 'vbn m', 'jftgyh', 'vhjbm ', 'jvh', 'yftjv', 'ft', 'gjhk', 'jfgh', 'fhjg', 'fghj', 'jfgh', 'vgjh', 'vb', 'vg', 'fjgh', 'fjgfjg', 'hg', 'htyjd', 'ty', 'hj', 'bhkg', 'tukfgckujhmjg', 'fvkuyt', 'dfiukt', 'dfik7u,tfuk', ',ygfvouikly', 'iolyg', 'ol8iytg');

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
(113, '1', '1', 1, '10000000', 'Technical', '1', 'Pending', 'P1', '2024-10-02 14:11:09'),
(114, '2', '2', 2, '10000001', 'Technical', '2', 'Pending', 'P1', '2024-10-02 14:11:11'),
(115, '3', '3', 3, '10000002', 'Technical', '3', 'Pending', 'P1', '2024-10-02 14:11:14');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ledger_tb`
--
ALTER TABLE `ledger_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_tb`
--
ALTER TABLE `products_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
