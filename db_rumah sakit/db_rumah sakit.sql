-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2023 at 05:27 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rumah sakit`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_admin`
--

CREATE TABLE `data_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(255) DEFAULT NULL,
  `password_admin` varchar(255) DEFAULT NULL,
  `id_dokter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_admin`
--

INSERT INTO `data_admin` (`id_admin`, `nama_admin`, `password_admin`, `id_dokter`) VALUES
(1, 'admin', '123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_apoteker`
--

CREATE TABLE `data_apoteker` (
  `id_apoteker` int(11) NOT NULL,
  `nama_apoteker` varchar(255) DEFAULT NULL,
  `riwayat_apoteker` varchar(255) DEFAULT NULL,
  `alamat_apoteker` varchar(255) DEFAULT NULL,
  `notelp_apoteker` int(11) DEFAULT NULL,
  `password_apoteker` int(11) DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_apoteker`
--

INSERT INTO `data_apoteker` (`id_apoteker`, `nama_apoteker`, `riwayat_apoteker`, `alamat_apoteker`, `notelp_apoteker`, `password_apoteker`, `id_admin`) VALUES
(1, 'a1', 'ads', 'asd', 123, 123, 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_dokter`
--

CREATE TABLE `data_dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(255) DEFAULT NULL,
  `spesialis_dokter` varchar(255) DEFAULT NULL,
  `jk_dokter` enum('laki-laki','perempuan') DEFAULT NULL,
  `notelp_dokter` int(11) DEFAULT NULL,
  `password_dokter` int(11) DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_dokter`
--

INSERT INTO `data_dokter` (`id_dokter`, `nama_dokter`, `spesialis_dokter`, `jk_dokter`, `notelp_dokter`, `password_dokter`, `id_admin`) VALUES
(3, 'santi', 'ads', 'perempuan', 12, 123, 1),
(4, 'b2', 'ad', 'perempuan', 1213, 123, 1),
(5, 'nohel', 'penyakit dalam', 'laki-laki', 123, 123, 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_obat`
--

CREATE TABLE `data_obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `jenis_obat` varchar(255) DEFAULT NULL,
  `golongan_obat` varchar(255) DEFAULT NULL,
  `id_apoteker` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_obat`
--

INSERT INTO `data_obat` (`id_obat`, `nama_obat`, `jenis_obat`, `golongan_obat`, `id_apoteker`) VALUES
(1, 'mefinal', 'tablet', 'narkotika', 1),
(2, 'ampicilin', 'tablet', 'narkotika', 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_obat_pasien`
--

CREATE TABLE `data_obat_pasien` (
  `id_data_obat_pasien` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_obat_pasien`
--

INSERT INTO `data_obat_pasien` (`id_data_obat_pasien`, `id_pasien`, `id_obat`) VALUES
(4, 23, 2),
(5, 17, 2),
(6, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_pasien`
--

CREATE TABLE `data_pasien` (
  `id_pasien` int(11) NOT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `penyakit_pasien` varchar(255) DEFAULT NULL,
  `jk_pasien` enum('laki-laki','perempuan') DEFAULT NULL,
  `umur_pasien` int(11) DEFAULT NULL,
  `password_pasien` int(11) DEFAULT NULL,
  `id_obat` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pasien`
--

INSERT INTO `data_pasien` (`id_pasien`, `nama_pasien`, `penyakit_pasien`, `jk_pasien`, `umur_pasien`, `password_pasien`, `id_obat`, `id_dokter`) VALUES
(16, 'q1', 'tbc', 'laki-laki', 14, 213, 1, 3),
(17, 'ez', 'ads', 'laki-laki', 14, 123, 1, 3),
(18, 'bnn', 'tbc', 'laki-laki', 14, 123, 1, 3),
(19, 'mawar', 'tbc', 'perempuan', 14, 123, 1, 3),
(20, 'zainal', 'tbc', 'laki-laki', 14, 123, 1, 3),
(21, 'abidin', 'tbc', 'laki-laki', 14, 123, 1, 3),
(22, 'vv', 'tbc', 'laki-laki', 14, 123, 1, 3),
(23, 'yss', 'tbc', 'perempuan', 14, 123, 1, 4),
(24, 'xxx', 'tbc', 'perempuan', 14, 123, 1, 4),
(25, 'bnm', 'tbc', 'laki-laki', 14, 123, 1, 4),
(26, 'vbbv', 'tbc', 'perempuan', 14, 123, 1, 4),
(32, 'kkkkkkkkkkkkkkkkk', 'tbc', 'perempuan', 2147483647, 123, 1, 4),
(33, 'nohel', 'tbc', 'laki-laki', 20, 123, 1, 3),
(34, 'budi', 'tbc', 'laki-laki', 21, 123, 1, 4),
(35, 'santi', 'maag', 'perempuan', 20, 123, 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_admin`
--
ALTER TABLE `data_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `data_apoteker`
--
ALTER TABLE `data_apoteker`
  ADD PRIMARY KEY (`id_apoteker`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `data_dokter`
--
ALTER TABLE `data_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `data_obat`
--
ALTER TABLE `data_obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD KEY `id_apoteker` (`id_apoteker`);

--
-- Indexes for table `data_obat_pasien`
--
ALTER TABLE `data_obat_pasien`
  ADD PRIMARY KEY (`id_data_obat_pasien`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indexes for table `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_admin`
--
ALTER TABLE `data_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_apoteker`
--
ALTER TABLE `data_apoteker`
  MODIFY `id_apoteker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_dokter`
--
ALTER TABLE `data_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data_obat`
--
ALTER TABLE `data_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_obat_pasien`
--
ALTER TABLE `data_obat_pasien`
  MODIFY `id_data_obat_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_apoteker`
--
ALTER TABLE `data_apoteker`
  ADD CONSTRAINT `data_apoteker_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `data_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_dokter`
--
ALTER TABLE `data_dokter`
  ADD CONSTRAINT `data_dokter_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `data_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_obat`
--
ALTER TABLE `data_obat`
  ADD CONSTRAINT `data_obat_ibfk_1` FOREIGN KEY (`id_apoteker`) REFERENCES `data_apoteker` (`id_apoteker`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_obat_pasien`
--
ALTER TABLE `data_obat_pasien`
  ADD CONSTRAINT `data_obat_pasien_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `data_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_obat_pasien_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `data_pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD CONSTRAINT `data_pasien_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `data_obat` (`id_obat`),
  ADD CONSTRAINT `data_pasien_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `data_dokter` (`id_dokter`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
