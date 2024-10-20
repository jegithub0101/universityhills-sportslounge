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
-- Table structure for table `pool_table_number`
--

CREATE TABLE `pool_table_number` (
  `pool_table_number` int(11) NOT NULL,
  `table_number` int(11) DEFAULT NULL,
  `time_reserved` time DEFAULT NULL,
  `time_playing` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `status` varchar(120) DEFAULT NULL,
  `occupied` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pool_table_number`
--

INSERT INTO `pool_table_number` (`pool_table_number`, `table_number`, `time_reserved`, `time_playing`, `time_end`, `status`, `occupied`) VALUES
(1, NULL, NULL, NULL, NULL, 'empty', 'empty'),
(2, NULL, NULL, NULL, NULL, 'empty', 'empty'),
(3, NULL, NULL, NULL, NULL, 'empty', 'empty');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
