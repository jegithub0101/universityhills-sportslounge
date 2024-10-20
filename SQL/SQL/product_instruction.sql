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
-- Table structure for table `product_instruction`
--

CREATE TABLE `product_instruction` (
  `tracking_no` varchar(150) NOT NULL,
  `instruction` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_instruction`
--

INSERT INTO `product_instruction` (`tracking_no`, `instruction`) VALUES
('Uh57730', 'pitapita'),
('Uh31530', 'pokeeeee'),
('Uh87890', 'pota'),
('Uh99640', 'piso'),
('Uh8870', ''),
('Uh57050', 'one lang po yung sisig'),
('Uh18850', ''),
('Uh28731', ''),
('Uh5270', 'no tofu'),
('Uh53992', ''),
('Uh52173', ''),
('Uh76593', 'penge pong sinigang na langaw'),
('Uh44204', ''),
('Uh79888', ''),
('Uh33054', ''),
('Uh40727', ''),
('Uh90952', 'pakisama ito'),
('Uh19618', ''),
('Uh20318', 'pakibilis'),
('Uh75316', ''),
('Uh3068', ''),
('Uh45069', ''),
('Uh11460', ''),
('Uh25780', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus commodo ipsum in mi tincidunt dignissim. Maecenas vitae rhoncus nibh. Vivamus semper mattis porttitor. Donec semper, lacus eget posuere'),
('Uh91670', ''),
('Uh12664', ''),
('Uh67165', ''),
('Uh20884', ''),
('Uh53935', ''),
('Uh94344', ''),
('Uh21270', ''),
('Uh51345', ''),
('Uh41224', ''),
('Uh33202', 'malamig pls!!!!!!'),
('Uh82618', ''),
('Uh56108', ''),
('Uh79819', ''),
('Uh72361', ''),
('Uh25063', ''),
('Uh88244', ''),
('Uh62923', ''),
('Uh33493', ''),
('Uh44153', ''),
('Uh74166', ''),
('Uh8903', ''),
('Uh22106', ''),
('Uh94393', ''),
('Uh81206', ''),
('Uh20096', ''),
('Uh27799', ''),
('Uh52380', ''),
('Uh482', ''),
('Uh43186', ''),
('Uh86666', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
