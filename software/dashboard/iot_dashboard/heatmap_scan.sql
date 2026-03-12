-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 02:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jeruk`
--

-- --------------------------------------------------------

--
-- Table structure for table `heatmap_scan`
--

CREATE TABLE `heatmap_scan` (
  `id` int(11) NOT NULL,
  `baris` tinyint(4) NOT NULL,
  `sisi` enum('A','B') NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heatmap_scan`
--

INSERT INTO `heatmap_scan` (`id`, `baris`, `sisi`, `value`, `created_at`) VALUES
(1, 1, 'B', 80, '2026-01-11 14:06:34'),
(2, 2, 'A', 100, '2026-01-11 14:06:34'),
(3, 3, 'B', 15, '2026-01-11 14:06:34'),
(4, 4, 'A', 40, '2026-01-11 14:06:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `heatmap_scan`
--
ALTER TABLE `heatmap_scan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `heatmap_scan`
--
ALTER TABLE `heatmap_scan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
