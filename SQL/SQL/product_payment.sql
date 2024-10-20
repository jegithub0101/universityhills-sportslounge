-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 09:03 AM
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
-- Database: `university_hills`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_payment`
--

CREATE TABLE `product_payment` (
  `payment_trackingno` varchar(150) NOT NULL,
  `pid` int(50) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `quantity` int(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_payment`
--

INSERT INTO `product_payment` (`payment_trackingno`, `pid`, `product_name`, `quantity`, `date`) VALUES
('Uh_PAYMENT180060', 124, 'Crab and Corn Soup', 1, '2024-05-04'),
('Uh_PAYMENT180060', 125, 'Mongolian Noodles Solo', 1, '2024-05-04'),
('Uh_PAYMENT504578', 122, 'Oriental Soup', 1, '2024-05-04'),
('Uh_PAYMENT504578', 123, 'Mushroom Soup', 1, '2024-05-04'),
('Uh_PAYMENT6524', 122, 'Oriental Soup', 2, '2024-05-05'),
('Uh_PAYMENT6524', 123, 'Mushroom Soup', 2, '2024-05-05'),
('Uh_PAYMENT6524', 124, 'Crab and Corn Soup', 2, '2024-05-05'),
('Uh_PAYMENT6524', 125, 'Mongolian Noodles Solo', 1, '2024-05-05'),
('Uh_PAYMENT6524', 126, 'Mongolian Noodles Large', 1, '2024-05-05'),
('Uh_PAYMENT6524', 127, 'Mongolian Rice Bowl Solo', 1, '2024-05-05'),
('Uh_PAYMENT6524', 128, 'Mongolian Rice Bowl Large', 1, '2024-05-05'),
('Uh_PAYMENT6524', 129, 'Fish and Chips', 1, '2024-05-05'),
('Uh_PAYMENT6524', 130, 'University Taco Bowl', 1, '2024-05-05'),
('Uh_PAYMENT6524', 141, 'Sisig with Egg', 1, '2024-05-05'),
('Uh_PAYMENT6524', 147, 'San Miguel Light', 1, '2024-05-05'),
('Uh_PAYMENT6524', 152, 'San Miguel Super Dry', 1, '2024-05-05'),
('Uh_PAYMENT6524', 153, 'Red Horse', 1, '2024-05-05'),
('Uh_PAYMENT6524', 154, 'Smirnoff Mule', 1, '2024-05-05'),
('Uh_PAYMENT6524', 184, 'Johnnie Walker Double Black', 3, '2024-05-05'),
('Uh_PAYMENT6524', 185, 'Carlo Rossi', 1, '2024-05-05'),
('Uh_PAYMENT930362', 134, 'Garlic Rice', 2, '2024-05-05'),
('Uh_PAYMENT930362', 148, 'San Miguel Apple', 1, '2024-05-05'),
('Uh_PAYMENT930362', 149, 'San Miguel Lemon', 1, '2024-05-05'),
('Uh_PAYMENT930362', 187, 'Sizzling Tofu', 1, '2024-05-05'),
('Uh_PAYMENT930362', 188, 'Sizzling Hotdog', 1, '2024-05-05'),
('Uh_PAYMENT979310', 122, 'Oriental Soup', 1, '2024-10-09'),
('Uh_PAYMENT979310', 123, 'Mushroom Soup', 1, '2024-10-09'),
('Uh_PAYMENT979310', 147, 'San Miguel Light', 1, '2024-10-09'),
('Uh_PAYMENT979310', 148, 'San Miguel Apple', 1, '2024-10-09'),
('Uh_PAYMENT874922', 130, 'University Taco Bowl', 1, '2024-10-09'),
('Uh_PAYMENT874922', 148, 'San Miguel Apple', 2, '2024-10-09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
