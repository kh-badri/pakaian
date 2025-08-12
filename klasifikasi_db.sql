-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2025 at 11:21 AM
-- Server version: 5.7.44
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klasifikasi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_tidur`
--

CREATE TABLE `data_tidur` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `durasi_tidur` decimal(4,2) NOT NULL,
  `kualitas_tidur` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `elastisitas` varchar(50) NOT NULL,
  `tekstur` varchar(50) NOT NULL,
  `ketebalan` decimal(5,2) NOT NULL,
  `bahan_kain` varchar(100) NOT NULL,
  `jenis_pakaian` varchar(100) NOT NULL,
  `conf_bahan_kain` float DEFAULT NULL,
  `conf_jenis_pakaian` float DEFAULT NULL,
  `raw_json` json DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `elastisitas`, `tekstur`, `ketebalan`, `bahan_kain`, `jenis_pakaian`, `conf_bahan_kain`, `conf_jenis_pakaian`, `raw_json`, `created_at`, `updated_at`) VALUES
(5, 'Rendah', 'Halus', 1.00, 'Spandeks', 'Kemeja', 0.149346, 0.151166, '{\"input\": {\"tekstur\": \"Halus\", \"ketebalan\": 1, \"elastisitas\": \"Rendah\"}, \"prediction\": {\"bahanKain\": \"Spandeks\", \"confidence\": {\"bahanKain\": 0.14934570404242137, \"jenisPakaian\": 0.15116608875114143}, \"jenisPakaian\": \"Kemeja\"}, \"csrf_test_name\": \"14963f4d860baef8406ebeb205596c86\"}', '2025-08-12 11:14:17', '2025-08-12 11:14:17'),
(6, 'Rendah', 'Halus', 1.00, 'Spandeks', 'Kemeja', 0.149346, 0.151166, '{\"input\": {\"tekstur\": \"Halus\", \"ketebalan\": 1, \"elastisitas\": \"Rendah\"}, \"prediction\": {\"bahanKain\": \"Spandeks\", \"confidence\": {\"bahanKain\": 0.14934570404242137, \"jenisPakaian\": 0.15116608875114143}, \"jenisPakaian\": \"Kemeja\"}, \"csrf_test_name\": \"14963f4d860baef8406ebeb205596c86\"}', '2025-08-12 11:14:40', '2025-08-12 11:14:40'),
(7, 'Rendah', 'Berpori', 1.00, 'Rayon', 'Kemeja', 0.201115, 0.170957, '{\"input\": {\"tekstur\": \"Berpori\", \"ketebalan\": 1, \"elastisitas\": \"Rendah\"}, \"prediction\": {\"bahanKain\": \"Rayon\", \"confidence\": {\"bahanKain\": 0.20111505221751833, \"jenisPakaian\": 0.1709569680540942}, \"jenisPakaian\": \"Kemeja\"}, \"csrf_test_name\": \"14963f4d860baef8406ebeb205596c86\"}', '2025-08-12 11:16:10', '2025-08-12 11:16:10'),
(8, 'Rendah', 'Berpori', 1.00, 'Rayon', 'Kemeja', 0.201115, 0.170957, '{\"input\": {\"tekstur\": \"Berpori\", \"ketebalan\": 1, \"elastisitas\": \"Rendah\"}, \"prediction\": {\"bahanKain\": \"Rayon\", \"confidence\": {\"bahanKain\": 0.20111505221751833, \"jenisPakaian\": 0.1709569680540942}, \"jenisPakaian\": \"Kemeja\"}, \"csrf_test_name\": \"14963f4d860baef8406ebeb205596c86\"}', '2025-08-12 11:16:58', '2025-08-12 11:16:58'),
(9, 'Rendah', 'Berpori', 1.00, 'Rayon', 'Kemeja', 0.201115, 0.170957, '{\"input\": {\"tekstur\": \"Berpori\", \"ketebalan\": 1, \"elastisitas\": \"Rendah\"}, \"prediction\": {\"bahanKain\": \"Rayon\", \"confidence\": {\"bahanKain\": 0.20111505221751833, \"jenisPakaian\": 0.1709569680540942}, \"jenisPakaian\": \"Kemeja\"}, \"csrf_test_name\": \"14963f4d860baef8406ebeb205596c86\"}', '2025-08-12 11:19:09', '2025-08-12 11:19:09'),
(10, 'Rendah', 'Berpori', 1.00, 'Rayon', 'Kemeja', 0.201115, 0.170957, '{\"input\": {\"tekstur\": \"Berpori\", \"ketebalan\": 1, \"elastisitas\": \"Rendah\"}, \"prediction\": {\"bahanKain\": \"Rayon\", \"confidence\": {\"bahanKain\": 0.20111505221751833, \"jenisPakaian\": 0.1709569680540942}, \"jenisPakaian\": \"Kemeja\"}, \"csrf_test_name\": \"4dc2973b4f02c9d43fcc5c4c6b4cb5f9\"}', '2025-08-12 11:20:40', '2025-08-12 11:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(12) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `nama_lengkap`, `email`, `foto`) VALUES
(5, 'badri', '$2y$10$ufHMCOpxBb4qWPM/DNxFp.iWNGrDq6ACJ.X3zJ1VB32M5vj8cZY1O', 'cek cekkk', 'khbadri22@gmail.com', '1753267234_9fe1376f34640f12d145.png'),
(6, 'farhan', '$2y$10$nXm.4vMPCWUCeCoSyrZIb.H1mHHt.yQnkau.XbpdFmrRAKiL.AWfK', 'Farhan Gaoul Nichhh', 'farhan22@gmail.com', '1754924459_6234b2971f89673ef813.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_tidur`
--
ALTER TABLE `data_tidur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_tidur`
--
ALTER TABLE `data_tidur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
