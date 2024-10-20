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
-- Table structure for table `pool_accepted`
--

CREATE TABLE `pool_accepted` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT 150
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pool_accepted`
--

INSERT INTO `pool_accepted` (`id`, `cid`, `table_number`, `price`) VALUES
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 5, 150),
(0, NULL, 3, 150),
(0, NULL, 6, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150),
(0, NULL, 3, 150);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
