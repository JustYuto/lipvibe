-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2020 at 08:17 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vibe`
--
CREATE DATABASE IF NOT EXISTS `vibe`;
USE `vibe`;
-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `adminid` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`adminid`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `mbid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartid`, `pid`, `mbid`, `qty`, `color`) VALUES
(60, 1, 1, 1, '01');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cid`, `brand`) VALUES
(1, 'VIBE');

-- --------------------------------------------------------

--
-- Table structure for table `memberacc`
--

CREATE TABLE `memberacc` (
  `mbid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(80) NOT NULL,
  `zipcode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `memberacc`
--

INSERT INTO `memberacc` (`mbid`, `username`, `password`, `phone`, `email`, `address`, `zipcode`) VALUES
(1, 'haha', '81dc9bdb52d04dc20036dbd8313ed055', '0123456799', 'haha@gmail.com', 'sungai longsss', 63000);

-- --------------------------------------------------------

--
-- Table structure for table `member_order`
--

CREATE TABLE `member_order` (
  `oid` int(10) UNSIGNED NOT NULL,
  `datePurchase` datetime NOT NULL DEFAULT current_timestamp(),
  `dateDelivered` datetime DEFAULT NULL,
  `status` enum('Pending','Processing','Delivered') NOT NULL,
  `mbid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_record`
--

CREATE TABLE `order_record` (
  `oid` int(11) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `totalprice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(6) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `stock` int(6) NOT NULL,
  `pimg` text NOT NULL,
  `color` varchar(12) NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `pname`, `price`, `stock`, `pimg`, `color`, `description`, `category`) VALUES
(1, 'Mulberry Valentine', 70, 204, '01.jpg', '01', 'This is lipstick that the colour is special, its purple colour mix with red colour', 1),
(2, 'Vivi Vibe', 70, 145, '02.jpg', '02', 'This red colour is suitable for all Office Lady to use, it let you to have more powerfulforefoot perforations and tonal Swoosh branding to the sidewalls', 1),
(3, 'Fearless', 70, 343, '03.jpg', '03', 'The real red colour in the fashion  and forever classic. It\'s may match with asian skin person', 1),
(4, 'Puppy Love', 70, 88, '04.jpg', '04', 'A special colour, which is \r\nRed bean paste pink color , it\'s suitable to white and yellow skin person', 1),
(5, 'Pumpkin Gigi', 70, 50, '05.jpg', '05', 'When you put one your lipstick ,just like stole eat the pumpkin, a very healthy colour', 1),
(6, 'Before you', 70, 80, '06.jpg', '06', 'A little more elegant than true red, a colour that can make you become an elegant person', 1),
(7, 'Red Tea', 70, 14, '07.jpg', '07', 'A colour like melted sugar with a\r\nmellow taste. Also hide the color of coffee.', 1),
(8, 'Jelly Pink', 70, 204, '08.jpg', '08', 'A special and nice colour.Using it will make people feel very gentle and easy to approach', 1),
(9, 'Sugar Vivian', 70, 50, '09.jpg', '09', 'A colour like tender artifact, most of the korean people will use this colour.\r\n(Korean style)', 1),
(10, 'Lust for life', 70, 10, '10.jpg', '10', 'Mirror gold with bling blood colour.\r\nSome mix of darkness and a little bit gold colour. It can style with a luxury or street style. ', 1),
(11, 'Fiona', 70, 204, '11.jpg', '11', 'The swag purple colour, and every cool girl should have it. Red and purple be the main colour ,it may given you have an own style.', 1),
(12, 'Jealousy', 70, 50, '12.jpg', '12', 'The mirror bling purple color.\r\nImagine you with your crush at a romantic place meet each other, and you in his eye may be the only one who care about.', 1);

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartid`),
  ADD KEY `cart_ibfk_1` (`pid`),
  ADD KEY `cart_ibfk_2` (`mbid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `memberacc`
--
ALTER TABLE `memberacc`
  ADD PRIMARY KEY (`mbid`);

--
-- Indexes for table `member_order`
--
ALTER TABLE `member_order`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `memberorder_ibfk_2` (`mbid`);

--
-- Indexes for table `order_record`
--
ALTER TABLE `order_record`
  ADD PRIMARY KEY (`oid`,`pid`),
  ADD KEY `oid` (`oid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `category` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `memberacc`
--
ALTER TABLE `memberacc`
  MODIFY `mbid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member_order`
--
ALTER TABLE `member_order`
  MODIFY `oid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`mbid`) REFERENCES `memberacc` (`mbid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_order`
--
ALTER TABLE `member_order`
  ADD CONSTRAINT `member_order_ibfk_2` FOREIGN KEY (`mbid`) REFERENCES `memberacc` (`mbid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_record`
--
ALTER TABLE `order_record`
  ADD CONSTRAINT `order_record_ibfk_3` FOREIGN KEY (`oid`) REFERENCES `member_order` (`oid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_record_ibfk_4` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
