-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 10:16 AM
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
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `tipe_obat` varchar(50) NOT NULL,
  `jumlah_obat` int(11) NOT NULL,
  `harga_obat` decimal(10,2) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `nama_obat`, `tipe_obat`, `jumlah_obat`, `harga_obat`, `total_harga`) VALUES
(29, 29, 'promag', 'pill', 5, 5000.00, 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_transaksi`
--

CREATE TABLE `laporan_transaksi` (
  `id_laporan` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `jumlah_obat` int(11) NOT NULL,
  `tipe_obat` varchar(50) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `status_pembayaran` varchar(10) NOT NULL DEFAULT 'LUNAS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_transaksi`
--

INSERT INTO `laporan_transaksi` (`id_laporan`, `id_transaksi`, `nama_customer`, `nama_obat`, `jumlah_obat`, `tipe_obat`, `total_harga`, `created_at`, `status_pembayaran`) VALUES
(1, 28, 'test2', 'panadol', 1, 'pill', -496000.00, '2025-02-03 15:58:25', 'LUNAS');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `tipe_obat` varchar(255) NOT NULL,
  `harga_obat` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `stock`, `tipe_obat`, `harga_obat`, `created`, `foto`) VALUES
(7, 'amoksilin', 10, 'kapsul', 1000, '2025-02-03 08:53:59', 'assets/storage/cute-astronaut-super-hero-cartoon-vector-icon-illustration_138676-3470.webp'),
(14, 'promag', 29, 'pill', 5000, '2025-02-03 09:16:34', 'assets/storage/didit-delon.png'),
(15, 'panadol', 8, 'pill', 4000, '2025-02-03 08:58:25', 'assets/storage/images (3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status_pembayaran` enum('LUNAS','BELUM LUNAS','','') NOT NULL DEFAULT 'BELUM LUNAS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nama_customer`, `created_at`, `status_pembayaran`) VALUES
(29, 'test2', '2025-02-03 09:16:34', 'BELUM LUNAS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_user` varchar(100) NOT NULL,
  `role` enum('Manager','Staff') NOT NULL DEFAULT 'Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `email`, `password_user`, `role`) VALUES
(1, 'salfa', 'salfa1@email.com', '$2y$10$hmsFpul9y2o1R2qFq22k/OuJMA9Zwno/OP0so65Fh1S3TN2hFlfS.', 'Manager'),
(7, 'Admin', 'admin@email.com', '$2y$10$ETnGrfR1BWDoATUaPgTgn.o3KY/B7Mt3N9LnQGkQUG4zf0lIngmPe', 'Staff'),
(8, 'rizky', 'rizkykodok@email.com', '$2y$10$.ssx0xPniI4hueo00GacKepfygNwkovxCaSdcWDCnIarvQG2X3KPe', 'Manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `laporan_transaksi`
--
ALTER TABLE `laporan_transaksi`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `laporan_transaksi`
--
ALTER TABLE `laporan_transaksi`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
