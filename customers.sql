-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2017 at 11:57 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_wholesale`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_prefer_time` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `contact_no` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `alternate_no` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL,
  `default_order_id` int(11) NOT NULL,
  `introduce_by` int(10) UNSIGNED NOT NULL,
  `manage_by` int(10) UNSIGNED NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `delivery_prefer_time`, `contact_no`, `alternate_no`, `join_date`, `default_order_id`, `introduce_by`, `manage_by`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'mani', 'singh', '', '13:20', '', '', '2017-01-20 07:46:00', 7, 0, 0, 1, 0, '2017-01-20 02:17:09', '2017-01-25 09:55:51'),
(4, 'sdf', 'sdf', '', '15:40', '', '', '2017-01-31 10:09:00', 0, 1, 1, 0, 0, '2017-01-31 04:39:44', '2017-01-31 04:39:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
