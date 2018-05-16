-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: 172.17.0.2:3306
-- Generation Time: Apr 16, 2018 at 11:46 AM
-- Server version: 5.7.21
-- PHP Version: 7.0.29-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--
CREATE DATABASE IF NOT EXISTS `capstone` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `capstone`;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `bid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `seats` int(6) NOT NULL,
  `uid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`bid`, `name`, `seats`, `uid`) VALUES
(4, 'Computer Science', 250, 'PUN_144411_LPU_A1'),
(5, 'Hotel Management', 350, 'PUN_144411_LPU_A1'),
(6, 'Hotel Management', 250, 'PUN_144411_LPU_A1_1');

-- --------------------------------------------------------

--
-- Table structure for table `universityDB`
--

CREATE TABLE `universityDB` (
  `uid` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `state` varchar(20) NOT NULL,
  `pincode` int(6) NOT NULL,
  `address` varchar(200) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '0',
  `phone` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `universityDB`
--

INSERT INTO `universityDB` (`uid`, `name`, `photo`, `email`, `state`, `pincode`, `address`, `type`, `phone`) VALUES
('PUN_144411_LPU_A1', 'Lovely Professional University', 'PUN_144411_LPU_A1.jpg', 'admin@lpu.com', 'Punjab', 144411, 'Jalandhar-Delhi G.T. Road', 0, 9779211167),
('PUN_144411_LPU_A1_1', 'Lovely Business School', 'PUN_144411_LPU_A1_1.jpg', 'admin@lpu.com', 'Punjab', 144411, 'Jalandhar-Delhi G.T. Road', 1, 9779211167),
('PUN_144411_LPU_A3', 'Lovel Pro Uni', 'PUN_144411_LPU_A3.jpg', 'admin@lpu.com', 'Punjab', 144411, 'Jalandhar-Delhi G.T. Road', 0, 9779211167);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`) VALUES
(4, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `universityDB`
--
ALTER TABLE `universityDB`
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;--
-- Database: `ubookstore`
--
CREATE DATABASE IF NOT EXISTS `ubookstore` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ubookstore`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `seller` int(11) NOT NULL,
  `pic` varchar(300) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `sem` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `allowed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bid`, `name`, `author`, `price`, `seller`, `pic`, `description`, `degree`, `branch`, `sem`, `type`, `allowed`) VALUES
(9, 'The Vegeterian', 'Han Kang', '400', 8, 'book0.png', 'A novel', 'B.Tech.', 'Computer Science', 1, 'book', 1),
(10, 'Deviate', 'Tracy Clark', '0', 8, 'book1.jpg', 'The Light Key trilogy.', 'B.Tech.', 'Civil', 1, 'book', 0),
(13, 'A Game of Thrones', 'George Martin', '1001', 9, 'book2.jpg', 'New York Times Bestselling author', 'B.Tech.', 'Mechanical', 2, 'book', 0),
(25, 'File demo 1', 'Admin', '0', 9, 'cleanMain.css', 'demo description', 'B.Tech.', 'Computer Science', 1, 'readingmaterial', 1),
(26, 'De file 5', 'Ajay', '0', 8, 'header0.php', 'hgjgkjgj', 'B.Tech.', 'Computer Science', 1, 'readingmaterial', 0),
(27, 'demo fiele ', 'Admin', '0', 9, 'main.css', 'demo', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 0),
(28, 'demo file sadsa', 'Admin', '0', 9, 'bookSlider.js', 'demo', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 0),
(29, 'dmeo s', 'Admin', '0', 9, 'bookSlider.js', 'dosdmas', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 1),
(30, 'THis is a ViRuS', 'Ajay', '0', 8, 'cleanMain.css', 'vIrUs', 'B.Tech.', 'Computer Science', 1, 'readingmaterial', 1),
(31, 'demo file 111dwe', 'Ajay', '0', 8, 'bootstrap.min.css', 'mode', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 1),
(32, 'file name', 'Ajay', '0', 8, 'bootstrap.min.css', 'demo', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 1),
(33, 'name file', 'Ajay', '0', 8, 'cleanMain.css', 'demo', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 1),
(35, 'demode', 'Ajay', '0', 8, 'cleanMain.css', 'd', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 1),
(36, 'a', 'a', '0', 8, 'back2.jpg', 'a', 'B.Tech.', 'Mechanical', 1, 'book', 0),
(37, 'a', 'Ajay', '0', 8, 'php-reverse-shell.pdf', 'a', 'B.Tech.', 'Mechanical', 1, 'readingmaterial', 1),
(38, 'admin', 'Admin', '0', 9, 'php-reverse-shell.pdf', 'admin213', 'B.Tech.', 'Mechanical', 1, 'programmingcodes', 1),
(39, 'admin123', 'Admin', '0', 9, 'php-reverse-shell.pdf', 'admin`12', 'B.Tech.', 'Mechanical', 1, 'programmingcodes', 0),
(40, 'demoasdmin', 'Admin', '0', 9, 'php-reverse-shell.pdf', 'adsadas', 'B.Tech.', 'Mechanical', 1, 'programmingcodes', 1),
(41, 'demo book', 'dmo', '12312', 9, 'hd-wallpaper-41.jpg', 'demo', 'B.Tech.', 'Mechanical', 1, 'book', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cid`, `uid`, `bid`, `date`, `status`) VALUES
(200, 9, 10, '2018-04-16 01:51:57', 1),
(201, 9, 13, '2018-04-16 01:51:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cid` int(11) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `sem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `degree`, `branch`, `sem`) VALUES
(1, 'B.Tech.', 'Mechanical', 1),
(2, 'B.Tech.', 'Mechanical', 2),
(3, 'B.Tech.', 'Mechanical', 3),
(4, 'B.Tech.', 'Mechanical', 4),
(5, 'B.Tech.', 'Mechanical', 5),
(6, 'B.Tech.', 'Mechanical', 6),
(8, 'B.Tech.', 'Mechanical', 7),
(9, 'B.Tech.', 'Mechanical', 8),
(10, 'B.Tech.', 'Mechanical', 1),
(11, 'B.Tech.', 'Computer Science', 2),
(12, 'B.Tech.', 'Computer Science', 3),
(13, 'B.Tech.', 'Computer Science', 4),
(14, 'B.Tech.', 'Computer Science', 5),
(15, 'B.Tech.', 'Computer Science', 6),
(16, 'B.Tech.', 'Computer Science', 6),
(17, 'B.Tech.', 'Computer Science', 7),
(18, 'B.Tech.', 'Computer Science', 8),
(19, 'B.Tech.', 'Mechanical', 1),
(20, 'B.Tech.', 'Civil', 2),
(21, 'B.Tech.', 'Civil', 3),
(22, 'B.Tech.', 'Civil', 4),
(23, 'B.Tech.', 'Civil', 5),
(24, 'B.Tech.', 'Civil', 6),
(25, 'B.Tech.', 'Civil', 6),
(26, 'B.Tech.', 'Civil', 7),
(27, 'B.Tech.', 'Civil', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `nid` int(11) NOT NULL,
  `msg` varchar(2000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`nid`, `msg`, `date`, `uid`) VALUES
(2, 'Your request for purchase of book,  Deviate was accepted by  Ajay ', '2018-04-08 18:59:50', 9),
(3, 'Your request for purchase of book,  The Vegeterian was rejected by  Ajay ', '2018-04-08 19:13:34', 9),
(4, 'Your request for purchase of book,  A Game of Thrones was rejected by  Admin ', '2018-04-08 19:16:46', 8),
(5, 'Your request for purchase of book,  A Game of Thrones was rejected by  Admin ', '2018-04-08 19:18:59', 8),
(6, 'Your request for purchase of book,  A Game of Thrones was accepted by  Admin ', '2018-04-08 19:19:50', 8),
(7, 'Your request for purchase of book,  Deviate was rejected by  Ajay ', '2018-04-09 03:35:01', 9),
(8, 'Your request for purchase of book, <b> Deviate</b> was accepted by  Ajay ', '2018-04-09 08:59:40', 10),
(9, 'Your request for purchase of book, <b> A Game of Thrones</b> was accepted by  Admin ', '2018-04-11 04:32:25', 8),
(10, 'Your request for purchase of book, <b> Demo book</b> was accepted by  Ajay ', '2018-04-11 08:02:30', 8),
(11, 'Your request for purchase of book, <b> The Vegeterian</b> was accepted by  Admin ', '2018-04-11 18:16:18', 8),
(12, 'Your request for purchase of book, <b> The Vegeterian</b> was accepted by  Admin ', '2018-04-11 18:36:05', 8),
(13, 'Your request for purchase of book, <b> Deviate</b> was accepted by Ajay', '2018-04-16 01:55:56', 9),
(14, 'Your request for purchase of book, <b> The Vegeterian</b> was rejected by Ajay', '2018-04-16 01:55:57', 9),
(15, 'Your request for purchase of book, <b> A Game of Thrones</b> was accepted by Admin', '2018-04-16 01:56:44', 9);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `sid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`sid`, `email`, `date`) VALUES
(1, 'ajaypandita73@gmail.com', '2018-04-11 17:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` bigint(10) NOT NULL,
  `address` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullname`, `phone`, `address`) VALUES
(8, 'ajaypandita73@gmail.com', 'codeample', 'Ajay', 9779211167, 'Jammu'),
(9, 'admin@bookstore.com', 'bookstore', 'Admin', 6239087464, 'anonymous'),
(10, 'maan113@gmail.com', '1234', 'maan', 9876543216, 'demo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `uid` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
