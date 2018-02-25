-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2018 at 06:53 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `phone` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `address`, `password`, `phone`) VALUES
(1, 'Victor', 'Tel Aviv', '1234', '0541651321'),
(2, 'Eliran', 'Raanana', '1234', '0541651325'),
(3, 'Reut', 'Tel Aviv', '1234', '0541651326'),
(4, 'Sara', 'Tel Aviv', '1234', '0541651328'),
(5, 'Gilad', 'Tel Aviv', '1234', '0541651357'),
(6, 'Gal', 'Tel Aviv', '1234', '0541651323'),
(7, 'Shlomi', 'Tel Aviv', '1234', '0541651375'),
(8, 'Joy', 'Tel Aviv', '1234', '0541651385'),
(10, 'Omri', 'Tel aviv', '1234', '0526461471'),
(18, 'Nim', 'Tel aviv', '1234', '0526461'),
(30, 'Shira', 'Rehovot', '5883', '0523698741');

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` int(10) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `image` varchar(60) DEFAULT NULL,
  `company` varchar(60) DEFAULT NULL,
  `color` varchar(60) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `name`, `image`, `company`, `color`, `price`) VALUES
(1, 'Galaxy8', 'galaxy8', 'Samsung', 'black', 499.99),
(2, 'Iphone8', 'iphone8', 'Apple', 'black', 399.99),
(3, 'V9', 'v9', 'LG', 'White', 555),
(4, 'IphoneX', 'iphonex', 'Apple', 'black', 999.99),
(5, 'P10', 'p10', 'Huawei', 'grey', 250),
(6, 'Galaxy7', 'galaxy7', 'Samsung', 'black', 99.99);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `buy_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `phone_id`, `buy_date`) VALUES
(2, 4, 5, '2018-02-12 12:11:10'),
(8, 1, 4, '2018-02-19 14:08:44'),
(11, 2, 1, '2018-02-21 20:55:42'),
(12, 30, 2, '2018-02-22 15:06:21'),
(13, 1, 1, '2018-02-22 18:35:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_idx` (`phone`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
