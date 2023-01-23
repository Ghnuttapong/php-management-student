-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2022 at 11:06 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ry_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `user_id`, `updated_at`) VALUES
(1, 'ค่าเลี้ยงดูรายเดือน', 7, '2022-10-31 08:50:03'),
(2, 'ค่าอาหาร', 7, '2022-10-31 08:50:18'),
(3, 'ค่าธรรมเนียมอื่นๆ', 7, '2022-10-31 08:51:00'),
(4, 'ค่าชุดนักเรียน', 7, '2022-10-31 08:51:28'),
(5, 'ค่าชุดพื้นเมือง', 7, '2022-10-31 08:51:41'),
(6, 'ค่าชุดพละ', 7, '2022-10-31 08:51:56'),
(7, 'ค่าชุดวอร์ม', 7, '2022-10-31 08:52:08'),
(8, 'ค่าเสื้อกั๊ก', 7, '2022-10-31 08:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `finances`
--

CREATE TABLE `finances` (
  `id` int(11) NOT NULL,
  `year` varchar(100) DEFAULT NULL,
  `class` varchar(100) NOT NULL,
  `term_fees` int(100) NOT NULL,
  `product_list` text NOT NULL,
  `product_expenses` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `status_study` varchar(100) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `class_year` int(11) DEFAULT NULL,
  `class_room` int(11) DEFAULT NULL,
  `status_expenses` varchar(100) DEFAULT NULL,
  `status_pay` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `role`, `status_study`, `year`, `class`, `class_year`, `class_room`, `status_expenses`, `status_pay`) VALUES
(1, 'admin', 'กำลังศึกษาอยู่', NULL, NULL, NULL, NULL, 'จ่ายครบแล้ว', 'รอยืนยัน'),
(2, 'การเงิน', 'พ้นสภาพนักเรียน', NULL, NULL, NULL, NULL, 'ยังไม่จ่าย', 'สำเร็จ'),
(3, 'ธุรการ', 'สำเร็จการศึกษา', NULL, NULL, NULL, NULL, 'กำลังผ่อนผัน', 'ยืนยันแล้ว'),
(4, 'ทะเบียน', NULL, NULL, NULL, NULL, NULL, NULL, 'ไม่จ่าย'),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'กำลังดำเนินการ'),
(27, NULL, NULL, '1/2565', NULL, NULL, NULL, NULL, NULL),
(28, NULL, NULL, '2/2565', NULL, NULL, NULL, NULL, NULL),
(29, NULL, NULL, '1/2566', NULL, NULL, NULL, NULL, NULL),
(30, NULL, NULL, '2/2566', NULL, NULL, NULL, NULL, NULL),
(31, NULL, NULL, '1/2567', NULL, NULL, NULL, NULL, NULL),
(32, NULL, NULL, '2/2567', NULL, NULL, NULL, NULL, NULL),
(33, NULL, NULL, '1/2568', NULL, NULL, NULL, NULL, NULL),
(34, NULL, NULL, '2/2568', NULL, NULL, NULL, NULL, NULL),
(35, NULL, NULL, '1/2569', NULL, NULL, NULL, NULL, NULL),
(36, NULL, NULL, '2/2569', NULL, NULL, NULL, NULL, NULL),
(37, NULL, NULL, '1/2570', NULL, NULL, NULL, NULL, NULL),
(38, NULL, NULL, '2/2570', NULL, NULL, NULL, NULL, NULL),
(41, NULL, NULL, NULL, 'เตรียมอนุบาล', 1, 1, NULL, NULL),
(42, NULL, NULL, NULL, 'เตรียมอนุบาล', 1, 2, NULL, NULL),
(43, NULL, NULL, NULL, 'เตรียมอนุบาล', 1, 3, NULL, NULL),
(44, NULL, NULL, NULL, 'เตรียมอนุบาล', 1, 4, NULL, NULL),
(45, NULL, NULL, NULL, 'เตรียมอนุบาล', 2, 1, NULL, NULL),
(46, NULL, NULL, NULL, 'เตรียมอนุบาล', 2, 2, NULL, NULL),
(47, NULL, NULL, NULL, 'เตรียมอนุบาล', 2, 3, NULL, NULL),
(48, NULL, NULL, NULL, 'เตรียมอนุบาล', 2, 4, NULL, NULL),
(50, NULL, NULL, NULL, 'เตรียมอนุบาล', 3, 1, NULL, NULL),
(51, NULL, NULL, NULL, 'เตรียมอนุบาล', 3, 2, NULL, NULL),
(52, NULL, NULL, NULL, 'เตรียมอนุบาล', 3, 3, NULL, NULL),
(53, NULL, NULL, NULL, 'เตรียมอนุบาล', 3, 4, NULL, NULL),
(54, NULL, NULL, NULL, 'อนุบาล', 1, 1, NULL, NULL),
(55, NULL, NULL, NULL, 'อนุบาล', 1, 2, NULL, NULL),
(56, NULL, NULL, NULL, 'อนุบาล', 1, 3, NULL, NULL),
(57, NULL, NULL, NULL, 'อนุบาล', 1, 4, NULL, NULL),
(58, NULL, NULL, NULL, 'อนุบาล', 2, 1, NULL, NULL),
(59, NULL, NULL, NULL, 'อนุบาล', 2, 3, NULL, NULL),
(60, NULL, NULL, NULL, 'อนุบาล', 2, 4, NULL, NULL),
(61, NULL, NULL, NULL, 'อนุบาล', 3, 1, NULL, NULL),
(62, NULL, NULL, NULL, 'อนุบาล', 3, 2, NULL, NULL),
(63, NULL, NULL, NULL, 'อนุบาล', 3, 3, NULL, NULL),
(64, NULL, NULL, NULL, 'อนุบาล', 3, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_finance`
--

CREATE TABLE `order_finance` (
  `id` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `std_id` int(11) NOT NULL,
  `expenses` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `p_id` text NOT NULL,
  `p_expenses` int(100) NOT NULL,
  `p_pay` int(11) NOT NULL DEFAULT 0,
  `status` varchar(110) NOT NULL DEFAULT '4',
  `state` int(11) NOT NULL DEFAULT 1,
  `u_fullname` varchar(110) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `detail` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'true',
  `category_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `detail`, `price`, `status`, `category_id`, `user_id`, `updated_at`) VALUES
(1, '001', 'ค่าเลี้ยงดูรายเดือนมกราคม', NULL, 100, 'true', 1, '7', '2022-11-08 18:18:43'),
(2, '002', 'ค่าเลี้ยงดูรายเดือนกุมภาพันธ์', '-', 100, 'true', 1, '7', '2022-10-31 08:54:03'),
(3, '003', 'ค่าเลี้ยงดูรายเดือนมีนาคม', '-', 100, 'true', 1, '7', '2022-10-31 08:54:18'),
(4, '004', 'ค่าเลี้ยงดูรายเดือนเมษายน', '-', 100, 'true', 1, '7', '2022-10-31 08:54:40'),
(5, '005', 'ค่าเลี้ยงดูรายเดือนพฤษภาคม', '-', 100, 'true', 1, '7', '2022-10-31 08:54:59'),
(6, '006', 'ค่าเลี้ยงดูรายเดือนมิถุนายน', '-', 100, 'true', 1, '7', '2022-10-31 08:55:22'),
(7, '007', 'ค่าเลี้ยงดูรายเดือนกรกฎาคม', '-', 100, 'true', 1, '7', '2022-10-31 08:55:46'),
(8, '008', 'ค่าเลี้ยงดูรายเดือนสิงหาคม', '-', 100, 'true', 1, '7', '2022-10-31 08:56:06'),
(9, '009', 'ค่าเลี้ยงดูรายเดือนกันยายน', '-', 100, 'true', 1, '7', '2022-10-31 08:56:26'),
(10, '010', 'ค่าเลี้ยงดูรายเดือนตุลาคม', '-', 100, 'true', 1, '7', '2022-10-31 08:56:40'),
(11, '011', 'ค่าเลี้ยงดูรายเดือนพฤศจิกายน', '-', 100, 'true', 1, '7', '2022-10-31 08:56:59'),
(12, '012', 'ค่าเลี้ยงดูรายเดือนธันวาคม', '-', 100, 'true', 1, '7', '2022-10-31 08:57:13'),
(13, '001', 'ค่าอาหารเช้ารายเดือนมกราคม', '-', 100, 'true', 2, '7', '2022-10-31 08:53:42'),
(14, '002', 'ค่าอาหารเช้ารายเดือนกุมภาพันธ์', '-', 100, 'true', 2, '7', '2022-10-31 08:54:03'),
(15, '003', 'ค่าอาหารเช้ารายเดือนมีนาคม', '-', 100, 'true', 2, '7', '2022-10-31 08:54:18'),
(16, '004', 'ค่าอาหารเช้ารายเดือนเมษายน', '-', 100, 'true', 2, '7', '2022-10-31 08:54:40'),
(17, '005', 'ค่าอาหารเช้ารายเดือนพฤษภาคม', '-', 100, 'true', 2, '7', '2022-10-31 08:54:59'),
(18, '006', 'ค่าอาหารเช้าเดือนมิถุนายน', '-', 100, 'true', 2, '7', '2022-10-31 08:55:22'),
(19, '007', 'ค่าอาหารเช้ารายเดือนกรกฎาคม', '-', 100, 'true', 2, '7', '2022-10-31 08:55:46'),
(20, '008', 'ค่าอาหารเช้ารายเดือนสิงหาคม', '-', 100, 'true', 2, '7', '2022-10-31 08:56:06'),
(21, '009', 'ค่าอาหารเช้ารายเดือนกันยายน', '-', 100, 'true', 2, '7', '2022-10-31 08:56:26'),
(22, '010', 'ค่าอาหารเช้ารายเดือนตุลาคม', '-', 100, 'true', 2, '7', '2022-10-31 08:56:40'),
(23, '011', 'ค่าอาหารเช้ารายเดือนพฤศจิกายน', '-', 100, 'true', 2, '7', '2022-10-31 08:56:59'),
(24, '012', 'ค่าอาหารเช้ารายเดือนธันวาคม', '-', 100, 'true', 2, '7', '2022-10-31 08:57:13'),
(25, '013', 'ค่าอาหารว่าง', '-', 100, 'true', 2, '7', '2022-10-31 09:16:34'),
(26, '014', 'ค่าอาหารกลางวัน', '-', 100, 'true', 2, '7', '2022-10-31 09:17:32'),
(27, '001', 'ค่าเรียนภาษาอังกฤษ', '-', 100, 'true', 3, '7', '2022-10-31 09:19:27'),
(28, '002', 'ค่าเรียนว่ายน้ำ', '-', 100, 'true', 3, '7', '2022-10-31 09:19:50'),
(29, '003', 'ค่าห้องเรียนปรับอากาศ', '-', 100, 'true', 3, '7', '2022-10-31 09:20:23'),
(30, '004', 'ค่าชุดรัฐบาลอุดหนุน', '-', 100, 'true', 3, '7', '2022-10-31 09:20:53'),
(31, '001', 'ค่าชุดนักเรียน', 'size s', 100, 'true', 4, '7', '2022-10-31 09:21:42'),
(32, '002', 'ค่าชุดนักเรียน', 'size m', 100, 'true', 4, '7', '2022-10-31 09:22:20'),
(33, '003', 'ค่าชุดนักเรียน', 'size l', 100, 'true', 4, '7', '2022-10-31 09:22:40'),
(34, '004', 'ค่าชุดนักเรียน', 'size xl', 100, 'true', 4, '7', '2022-10-31 09:23:16'),
(35, '005', 'ค่าชุดนักเรียน', 'size xxl', 100, 'true', 4, '7', '2022-10-31 09:24:16'),
(36, '001', 'ค่าชุดพื้นเมือง', '26', 100, 'true', 5, '7', '2022-10-31 09:25:23'),
(37, '002', 'ค่าชุดพื้นเมือง', '28', 100, 'true', 5, '7', '2022-10-31 09:26:08'),
(38, '003', 'ค่าชุดพื้นเมือง', '30', 100, 'true', 5, '8', '2022-11-04 07:16:40'),
(39, '004', 'ค่าชุดพื้นเมือง', '32', 100, 'true', 5, '7', '2022-10-31 09:26:44'),
(40, '005', 'ค่าชุดพื้นเมือง', '34', 100, 'true', 5, '7', '2022-10-31 09:26:59'),
(41, '001', 'ค่าชุดพละ', 'size s', 100, 'true', 6, '7', '2022-10-31 09:21:42'),
(42, '002', 'ค่าชุดพละ', 'size m', 100, 'true', 6, '7', '2022-10-31 09:22:20'),
(43, '003', 'ค่าชุดพละ', 'size l', 100, 'true', 6, '7', '2022-10-31 09:22:40'),
(44, '004', 'ค่าชุดพละ', 'size xl', 100, 'true', 6, '7', '2022-10-31 09:23:16'),
(45, '005', 'ค่าชุดพละ', 'size xxl', 100, 'true', 6, '7', '2022-10-31 09:24:16'),
(46, '001', 'ค่าชุดวอร์ม', 'size s', 100, 'true', 7, '7', '2022-10-31 09:21:42'),
(47, '002', 'ค่าชุดวอร์ม', 'size m', 100, 'true', 7, '7', '2022-10-31 09:22:20'),
(48, '003', 'ค่าชุดวอร์ม', 'size l', 100, 'true', 7, '7', '2022-10-31 09:22:40'),
(49, '004', 'ค่าชุดวอร์ม', 'size xl', 100, 'true', 7, '7', '2022-10-31 09:23:16'),
(50, '005', 'ค่าชุดวอร์ม', 'size xxl', 100, 'true', 7, '7', '2022-10-31 09:24:16'),
(51, '001', 'ค่าเสื้อกั๊ก', 'size s', 100, 'true', 8, '7', '2022-10-31 09:21:42'),
(52, '002', 'ค่าเสื้อกั๊ก', 'size m', 100, 'true', 8, '7', '2022-10-31 09:22:20'),
(53, '003', 'ค่าเสื้อกั๊ก', 'size l', 100, 'true', 8, '7', '2022-10-31 09:22:40'),
(54, '004', 'ค่าเสื้อกั๊ก', 'size xl', 100, 'true', 8, '7', '2022-10-31 09:23:16'),
(55, '005', 'ค่าเสื้อกั๊ก', 'size xxl', 100, 'true', 8, '7', '2022-10-31 09:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `nickname` varchar(200) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `class` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `p_prefix` text NOT NULL,
  `p_firstname` text NOT NULL,
  `p_lastname` text NOT NULL,
  `p_fullname` text NOT NULL,
  `p_relative` varchar(100) NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `note` text DEFAULT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `prefix`, `firstname`, `lastname`, `fullname`, `phone`, `username`, `password`, `role`) VALUES
(7, 'นาย', 'ปฏิพล', 'วงศ์ศรี', 'นายปฏิพล วงศ์ศรี', '0612528280', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finances`
--
ALTER TABLE `finances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_finance`
--
ALTER TABLE `order_finance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `finances`
--
ALTER TABLE `finances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_finance`
--
ALTER TABLE `order_finance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
