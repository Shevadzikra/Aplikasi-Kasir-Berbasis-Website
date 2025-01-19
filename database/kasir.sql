-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 12:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kode_barang` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama`, `harga`, `jumlah`, `kode_barang`) VALUES
(1, 'Bola Basket', 25000, 9, 'AA0011'),
(2, 'Sepatu Nike', 120000, 10, 'AA0022'),
(9, 'Raket', 230000, 7, 'AA0033'),
(12, 'Helm Tempur', 10000, 10, 'AA0044'),
(14, 'Bola Mercon', 2000, 5, 'AA0055'),
(15, 'Playstation 5', 5000000, 2, 'AA0066'),
(17, 'Permen', 3000, 5, 'BB0011'),
(19, 'Buku Tulis', 1000, 9, '8991389220016'),
(226, 'Komik', 5000, 19, '8995757005793'),
(227, 'Lato Lato', 5000, 10, 'BB0022'),
(228, 'AC', 1500000, 3, 'AA0099');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama`) VALUES
(1, 'Admin'),
(2, 'Kasir'),
(3, 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal_waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `nomor` varchar(10) NOT NULL,
  `total` bigint(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bayar` bigint(225) DEFAULT NULL,
  `kembali` bigint(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal_waktu`, `nomor`, `total`, `nama`, `bayar`, `kembali`) VALUES
(39, '2025-01-13 18:59:35', '424258', 6000, 'kasir', 7000, 1000),
(40, '2025-01-13 19:09:42', '860640', 25000, 'kasir', 25000, 0),
(41, '2025-01-13 19:10:32', '840363', 50000, 'kasir', 50000, 0),
(42, '2025-01-13 19:12:31', '804189', 5026000, 'Nayara', 6000000, 974000),
(43, '2025-01-13 19:35:21', '189023', 25000, 'Nayara', 25000, 0),
(44, '2025-01-31 20:03:09', '465377', 25000, 'Nayara', 30000, 5000),
(45, '2025-01-13 20:34:12', '196121', 25000, 'Shevadzikra', 26000, 1000),
(46, '2025-01-13 20:34:43', '458833', 5000000, 'Shevadzikra', 5000000, 0),
(47, '2025-01-31 21:10:34', '823852', 25000, 'Shevadzikra', 26000, 1000),
(56, '2025-01-31 22:40:57', '741960', 5000000, 'Shevadzikra', 7000000, 2000000),
(58, '2025-02-01 05:33:33', '128354', 25000, 'kasir', 35000, 10000),
(59, '2025-02-02 05:33:45', '769009', 25000, 'kasir', 35000, 10000),
(60, '2025-02-04 05:33:50', '615768', 25000, 'kasir', 35000, 10000),
(61, '2025-03-01 05:33:56', '651636', 25000, 'kasir', 35000, 10000),
(62, '2025-03-01 05:34:01', '652247', 25000, 'kasir', 35000, 10000),
(63, '2025-01-19 05:34:05', '400173', 25000, 'kasir', 35000, 10000),
(64, '2025-01-19 05:34:10', '444784', 25000, 'kasir', 35000, 10000),
(65, '2025-01-19 05:34:18', '302232', 25000, 'kasir', 35000, 10000),
(66, '2025-01-19 05:34:23', '435402', 25000, 'kasir', 35000, 10000),
(67, '2025-01-19 05:34:34', '805740', 25000, 'kasir', 35000, 10000),
(68, '2025-01-19 05:34:41', '152454', 25000, 'kasir', 35000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `harga` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id_transaksi_detail`, `id_transaksi`, `id_barang`, `qty`, `total`, `harga`) VALUES
(1, 39, 19, 6, 6000, 1000),
(2, 40, 1, 1, 25000, 25000),
(3, 41, 1, 2, 50000, 25000),
(4, 42, 1, 1, 25000, 25000),
(5, 42, 19, 1, 1000, 1000),
(6, 42, 15, 1, 5000000, 5000000),
(7, 43, 1, 1, 25000, 25000),
(8, 44, 1, 1, 25000, 25000),
(9, 45, 1, 1, 25000, 25000),
(10, 46, 15, 1, 5000000, 5000000),
(26, 58, 1, 1, 25000, 25000),
(27, 59, 1, 1, 25000, 25000),
(28, 60, 1, 1, 25000, 25000),
(29, 61, 1, 1, 25000, 25000),
(30, 62, 1, 1, 25000, 25000),
(31, 63, 1, 1, 25000, 25000),
(32, 64, 1, 1, 25000, 25000),
(33, 65, 1, 1, 25000, 25000),
(34, 66, 1, 1, 25000, 25000),
(35, 67, 1, 1, 25000, 25000),
(36, 68, 1, 1, 25000, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role_id`) VALUES
(1, 'admin', 'admin', '123', 1),
(2, 'kasir', 'kasir', '123', 2),
(7, 'Shevadzikra', 'Shevadzikra', '123', 2),
(8, 'Nayara', 'Nayara', '123', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
