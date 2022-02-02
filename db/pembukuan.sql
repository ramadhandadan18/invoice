-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2022 at 06:32 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembukuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_gaji`
--

CREATE TABLE `master_gaji` (
  `id` int(255) NOT NULL,
  `pegawai_id` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `gaji` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_gaji`
--

INSERT INTO `master_gaji` (`id`, `pegawai_id`, `tanggal`, `gaji`) VALUES
(12, '111', '2021-04-30', 20017000),
(13, '222', '2021-04-30', 20981000),
(14, '333', '2021-04-30', 18064000),
(15, '444', '2021-04-30', 21538000),
(16, '555', '2021-04-30', 15874000),
(17, '111', '2021-05-30', 11447000),
(18, '222', '2021-05-30', 9889000),
(19, '444', '2021-05-30', 11228000),
(20, '333', '2021-05-30', 10115000),
(21, '555', '2021-05-30', 9930000),
(22, '111', '2021-06-30', 11728000),
(23, '222', '2021-06-30', 13052000),
(24, '333', '2021-06-30', 13450000),
(25, '444', '2021-06-30', 13609000),
(26, '555', '2021-06-30', 11660000);

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE `master_kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_kode` varchar(100) DEFAULT NULL,
  `kategori_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kategori_id`, `kategori_kode`, `kategori_nama`) VALUES
(3, 'BAN', 'BAN'),
(4, 'OLI', 'OLI'),
(5, 'SERVIS', 'SERVIS'),
(6, 'SURATKENDARAAN', 'SURAT KENDARAAN'),
(7, 'GARASI', 'GARASI'),
(9, 'SMN/PKG12', 'SMN/PKG12'),
(10, 'LAIN-LAIN', 'LAIN - LAIN');

-- --------------------------------------------------------

--
-- Table structure for table `master_pegawai`
--

CREATE TABLE `master_pegawai` (
  `pegawai_id` int(11) NOT NULL,
  `pegawai_no` int(255) DEFAULT NULL,
  `pegawai_nama` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `master_pegawai`
--

INSERT INTO `master_pegawai` (`pegawai_id`, `pegawai_no`, `pegawai_nama`, `gambar`) VALUES
(25, 111, 'MASUD', ''),
(26, 222, 'TEGUH', ''),
(27, 333, 'GITO', ''),
(28, 444, 'JOKO', ''),
(29, 555, 'KRIS', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `mingguan` varchar(255) NOT NULL,
  `qty` float NOT NULL,
  `harga` float NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `pegawai_id`, `tgl_transaksi`, `tanggal`, `kategori`, `mingguan`, `qty`, `harga`, `deskripsi`, `status`) VALUES
(34, 111, '2021-04-03', '2021-04-01', 'LAIN-LAIN', '1', 1, 620000, '', ''),
(35, 111, '2021-04-07', '2021-04-05', 'LAIN-LAIN', '2', 1, 50000, '', ''),
(36, 111, '2021-04-28', '2021-04-26', 'LAIN-LAIN', '5', 1, 2070000, 'PEER', ''),
(37, 111, '2021-04-03', '2021-04-01', 'OLI', '1', 30, 25000, '', ''),
(38, 111, '2021-05-03', '2021-05-03', 'LAIN-LAIN', '1', 1, 1015000, 'PEER', ''),
(40, 111, '2021-05-05', '2021-05-03', 'LAIN-LAIN', '2', 1, 85000, '', ''),
(41, 111, '2021-05-19', '2021-05-17', 'BAN', '3', 1, 500000, 'BAN', ''),
(42, 111, '2021-06-06', '2021-06-03', 'LAIN-LAIN', '1', 1, 520000, '', ''),
(43, 111, '2021-06-16', '2021-06-14', 'LAIN-LAIN', '3', 1, 1977000, 'LAS', ''),
(44, 111, '2021-06-16', '2021-06-14', 'BAN', '3', 5, 885000, 'BAN', ''),
(45, 111, '2021-06-29', '2021-06-28', 'LAIN-LAIN', '5', 1, 195000, '', ''),
(46, 222, '2021-04-03', '2021-04-01', 'LAIN-LAIN', '1', 1, 461000, '', ''),
(47, 222, '2021-04-13', '2021-04-12', 'LAIN-LAIN', '2', 1, 100000, '', ''),
(48, 222, '2021-04-20', '2021-04-19', 'BAN', '3', 2, 2850000, 'GANTI BAN', ''),
(49, 222, '2021-04-21', '2021-04-20', 'LAIN-LAIN', '4', 1, 311000, '', ''),
(50, 222, '2021-04-21', '2021-04-20', 'OLI', '4', 30, 25000, 'GANTI OLI', ''),
(51, 222, '2021-04-24', '2021-04-28', 'LAIN-LAIN', '5', 1, 380000, '', ''),
(52, 222, '2021-04-24', '2021-04-28', 'BAN', '5', 4, 3350000, '', ''),
(53, 222, '2021-04-24', '2021-04-26', 'LAIN-LAIN', '5', 1, 1275000, '', ''),
(54, 222, '2021-04-24', '2021-04-26', 'BAN', '5', 4, 1350000, '', ''),
(55, 222, '2021-05-03', '2021-05-01', 'LAIN-LAIN', '1', 1, 385000, '', ''),
(56, 222, '2021-05-11', '2021-05-10', 'LAIN-LAIN', '2', 1, 85000, '', ''),
(57, 222, '2021-05-25', '2021-05-21', 'LAIN-LAIN', '3', 1, 937500, '', ''),
(58, 222, '2021-05-22', '2021-05-21', 'BAN', '3', 1, 750000, '', ''),
(59, 222, '2021-05-30', '2021-05-28', 'LAIN-LAIN', '4', 1, 2356000, '', ''),
(60, 222, '2021-06-05', '2021-06-04', 'LAIN-LAIN', '1', 1, 200000, '', ''),
(62, 222, '2021-06-20', '2021-06-18', 'LAIN-LAIN', '3', 1, 1452000, '', ''),
(63, 333, '2021-04-01', '2021-04-05', 'LAIN-LAIN', '1', 1, 300000, '', ''),
(64, 333, '2021-04-01', '2021-04-05', 'BAN', '1', 1, 1200000, '', ''),
(65, 333, '2021-04-06', '2021-04-10', 'LAIN-LAIN', '2', 1, 170000, '', ''),
(66, 333, '2021-04-15', '2021-04-17', 'LAIN-LAIN', '3', 1, 830000, '', ''),
(67, 333, '2021-04-18', '2021-04-19', 'LAIN-LAIN', '4', 1, 410000, '', ''),
(68, 333, '2021-04-25', '2021-04-29', 'LAIN-LAIN', '5', 1, 525000, '', ''),
(69, 333, '2021-05-01', '2021-05-03', 'LAIN-LAIN', '1', 1, 346000, '', ''),
(70, 333, '2021-05-05', '2021-05-10', 'LAIN-LAIN', '2', 1, 282000, '', ''),
(71, 333, '2021-05-05', '2021-05-10', 'OLI', '2', 30, 25000, '', ''),
(72, 333, '2021-05-15', '2021-05-17', 'LAIN-LAIN', '3', 1, 384000, '', ''),
(73, 333, '2021-05-25', '2021-05-29', 'LAIN-LAIN', '5', 1, 360000, '', ''),
(74, 333, '2021-06-18', '2021-06-21', 'LAIN-LAIN', '3', 1, 172000, '', ''),
(75, 333, '2021-06-19', '2021-06-21', 'BAN', '3', 2, 1150000, '', ''),
(76, 333, '2021-06-25', '2021-06-29', 'LAIN-LAIN', '4', 1, 50000, '', ''),
(77, 444, '2021-04-05', '2021-04-12', 'LAIN-LAIN', '2', 1, 180000, '', ''),
(78, 444, '2021-04-10', '2021-04-19', 'LAIN-LAIN', '3', 1, 277000, '', ''),
(79, 444, '2021-04-18', '2021-04-19', 'LAIN-LAIN', '4', 1, 145000, '', ''),
(80, 444, '2021-04-18', '2021-04-19', 'BAN', '4', 1, 750000, '', ''),
(81, 444, '2021-04-17', '2021-04-19', 'LAIN-LAIN', '4', 1, 833000, '', ''),
(82, 444, '2021-04-26', '2021-04-29', 'LAIN-LAIN', '5', 1, 1565000, '', ''),
(83, 444, '2021-05-10', '2021-05-15', 'LAIN-LAIN', '2', 1, 371000, '', ''),
(84, 444, '2021-05-10', '2021-05-15', 'OLI', '2', 30, 25000, '', ''),
(85, 444, '2021-05-20', '2021-05-22', 'LAIN-LAIN', '3', 1, 721500, '', ''),
(86, 444, '2021-06-26', '2021-06-29', 'LAIN-LAIN', '4', 1, 262000, '', ''),
(87, 555, '2021-04-01', '2021-04-01', 'LAIN-LAIN', '1', 1, 65000, '', ''),
(88, 555, '2021-04-09', '2021-04-10', 'BAN', '2', 1, 500000, '', ''),
(89, 555, '2021-04-15', '2021-04-17', 'LAIN-LAIN', '3', 1, 550000, '', ''),
(90, 555, '2021-04-21', '2021-04-24', 'LAIN-LAIN', '4', 1, 300000, '', ''),
(91, 555, '2021-04-28', '2021-04-29', 'LAIN-LAIN', '5', 1, 40000, '', ''),
(92, 555, '2021-05-01', '2021-05-01', 'LAIN-LAIN', '1', 1, 80000, '', ''),
(93, 555, '2021-05-07', '2021-05-08', 'LAIN-LAIN', '2', 1, 467000, '', ''),
(94, 555, '2021-05-07', '2021-05-08', 'BAN', '2', 3, 1100000, '', ''),
(95, 555, '2021-05-10', '2021-05-15', 'SERVIS', '3', 1, 1465000, 'AKI', ''),
(96, 555, '2021-06-01', '2021-06-01', 'LAIN-LAIN', '1', 1, 70000, '', ''),
(97, 555, '2021-06-27', '2021-06-29', 'LAIN-LAIN', '5', 1, 115000, '', ''),
(98, 111, '2021-04-30', '2021-04-30', 'GARASI', '4', 1, 4000000, '', ''),
(99, 111, '2021-05-30', '2021-05-30', 'GARASI', '4', 1, 1500000, '', ''),
(100, 111, '2021-06-30', '2021-06-30', 'GARASI', '4', 1, 1500000, '', ''),
(101, 222, '2021-04-30', '2021-04-30', 'GARASI', '4', 1, 3500000, '', ''),
(102, 222, '2021-05-30', '2021-05-30', 'GARASI', '4', 1, 1500000, '', ''),
(103, 222, '2021-06-30', '2021-06-30', 'GARASI', '4', 1, 1500000, '', ''),
(104, 333, '2021-04-30', '2021-04-30', 'GARASI', '4', 1, 3500000, '', ''),
(105, 333, '2021-05-30', '2021-05-30', 'GARASI', '4', 1, 1500000, '', ''),
(106, 333, '2021-06-30', '2021-06-30', 'GARASI', '4', 1, 1500000, '', ''),
(107, 444, '2021-04-30', '2021-04-30', 'GARASI', '4', 1, 3500000, '', ''),
(108, 444, '2021-05-30', '2021-05-30', 'GARASI', '4', 1, 1500000, '', ''),
(109, 444, '2021-06-30', '2021-06-30', 'GARASI', '4', 1, 1500000, '', ''),
(110, 555, '2021-04-30', '2021-04-30', 'GARASI', '4', 1, 3000000, '', ''),
(111, 555, '2021-05-30', '2021-05-30', 'GARASI', '4', 1, 1500000, '', ''),
(112, 555, '2021-06-30', '2021-06-30', 'GARASI', '4', 1, 1500000, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `pegawai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `pegawai_id`) VALUES
(1, 'admin', '47bce5c74f589f4867dbd57e9ca9f808', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_gaji`
--
ALTER TABLE `master_gaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_kategori`
--
ALTER TABLE `master_kategori`
  ADD PRIMARY KEY (`kategori_id`) USING BTREE;

--
-- Indexes for table `master_pegawai`
--
ALTER TABLE `master_pegawai`
  ADD PRIMARY KEY (`pegawai_id`) USING BTREE;

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_gaji`
--
ALTER TABLE `master_gaji`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `master_kategori`
--
ALTER TABLE `master_kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `master_pegawai`
--
ALTER TABLE `master_pegawai`
  MODIFY `pegawai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
