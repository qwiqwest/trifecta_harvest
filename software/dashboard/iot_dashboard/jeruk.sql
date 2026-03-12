-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 02:44 PM
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
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `a1` int(11) NOT NULL,
  `a2` int(11) NOT NULL,
  `a3` int(11) NOT NULL,
  `a4` int(11) NOT NULL,
  `a5` int(11) NOT NULL,
  `a6` int(11) NOT NULL,
  `a7` int(11) NOT NULL,
  `a8` int(11) NOT NULL,
  `a9` int(11) NOT NULL,
  `a10` int(11) NOT NULL,
  `b1` int(11) NOT NULL,
  `b2` int(11) NOT NULL,
  `b3` int(11) NOT NULL,
  `b4` int(11) NOT NULL,
  `b5` int(11) NOT NULL,
  `b6` int(11) NOT NULL,
  `b7` int(11) NOT NULL,
  `b8` int(11) NOT NULL,
  `b9` int(11) NOT NULL,
  `b10` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`id`, `waktu`, `a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `b1`, `b2`, `b3`, `b4`, `b5`, `b6`, `b7`, `b8`, `b9`, `b10`) VALUES
(1, '2026-01-27 14:33:49', 80, 80, 80, 80, 80, 80, 80, 80, 80, 80, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100),
(2, '2026-01-27 14:34:52', 50, 20, 50, 80, 10, 40, 70, 10, 50, 50, 60, 60, 30, 20, 90, 60, 20, 50, 70, 50);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_scan`
--

CREATE TABLE `hasil_scan` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp(),
  `hasil` int(11) NOT NULL,
  `persentase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_scan`
--

INSERT INTO `hasil_scan` (`id`, `waktu`, `hasil`, `persentase`) VALUES
(7, '2026-01-08 00:00:00', 5, 50),
(8, '2026-01-07 00:00:00', 5, 50),
(9, '2026-01-06 00:00:00', 4, 40),
(10, '2026-01-05 00:00:00', 4, 40),
(11, '2026-01-04 00:00:00', 7, 70),
(12, '2026-01-03 00:00:00', 6, 60),
(13, '2026-01-02 00:00:00', 6, 60),
(14, '2026-01-01 00:00:00', 4, 40),
(15, '2025-12-31 00:00:00', 3, 30),
(16, '2025-12-30 00:00:00', 4, 40),
(17, '2025-12-29 00:00:00', 6, 60),
(18, '2025-12-28 00:00:00', 5, 50),
(19, '2026-01-09 22:02:47', 3, 30),
(20, '2026-01-22 18:49:54', 2, 80);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_scanning`
--

CREATE TABLE `hasil_scanning` (
  `id` int(11) NOT NULL,
  `baris` int(11) DEFAULT NULL,
  `sisi` enum('A','B') DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_scanning`
--

INSERT INTO `hasil_scanning` (`id`, `baris`, `sisi`, `nilai`) VALUES
(1, 1, 'B', 100),
(2, 2, 'B', 80),
(3, 3, 'B', 70),
(4, 4, 'B', 100),
(5, 5, 'B', 90),
(6, 6, 'B', 100),
(7, 7, 'B', 80),
(8, 8, 'B', 100),
(9, 9, 'B', 100),
(10, 10, 'B', 20),
(11, 1, 'A', 30),
(12, 2, 'A', 15),
(13, 5, 'B', 80);

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

-- --------------------------------------------------------

--
-- Table structure for table `scanning`
--

CREATE TABLE `scanning` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Row` int(11) NOT NULL,
  `A` int(11) NOT NULL,
  `B` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scanning`
--

INSERT INTO `scanning` (`id`, `waktu`, `Row`, `A`, `B`) VALUES
(2, '2026-01-23 20:46:04', 1, 80, 20),
(3, '2026-01-24 12:05:16', 2, 80, 20),
(4, '2026-01-24 12:05:16', 3, 60, 40),
(5, '2026-01-24 12:05:16', 4, 50, 20),
(6, '2026-01-24 12:05:16', 5, 20, 20),
(7, '2026-01-24 12:05:16', 6, 10, 70),
(8, '2026-01-24 12:05:16', 7, 30, 90),
(9, '2026-01-24 12:05:16', 8, 90, 90),
(10, '2026-01-24 12:05:16', 9, 25, 25),
(11, '2026-01-24 12:05:16', 10, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `watuuu`
--

CREATE TABLE `watuuu` (
  `timeee` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_scan`
--
ALTER TABLE `hasil_scan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_scanning`
--
ALTER TABLE `hasil_scanning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heatmap_scan`
--
ALTER TABLE `heatmap_scan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scanning`
--
ALTER TABLE `scanning`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hasil_scan`
--
ALTER TABLE `hasil_scan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hasil_scanning`
--
ALTER TABLE `hasil_scanning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `heatmap_scan`
--
ALTER TABLE `heatmap_scan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scanning`
--
ALTER TABLE `scanning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
