-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 08:22 AM
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
-- Database: `watchstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin@admin.com', '$2y$10$sfUJj8cpana9pHQTmJmtIuWGpgNJJKeG6EisOhDU7YT3QibJ6g5dm');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `email` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `password` varchar(30) NOT NULL,
  `NoTelp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`email`, `nama`, `alamat`, `password`, `NoTelp`) VALUES
('email2@email.com', 'user2', 'Ugm', 'Pass', '41274934242'),
('pelanggan1@email.com', 'Pelanggan1', 'Alamat Pelanggan 1', 'Pelanggan1!', '082146632798');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idProduk` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` int(8) NOT NULL,
  `merk` varchar(40) NOT NULL,
  `warna` varchar(50) NOT NULL,
  `stock` int(3) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idProduk`, `nama`, `harga`, `merk`, `warna`, `stock`, `foto`) VALUES
(1, 'Casio Mens Black Analog Watch MTP-VT01L-1B', 477000, 'Casio', 'Hitam', 33, '../product_pict/Casio Mens Black Analog Watch MTP-VT01L-1B (Size_ US Free).jpg'),
(3, 'Fossil FB-01 FS5657 Black Dial Stainless Steel Str', 1608000, 'Fossil', 'Silver', 39, '../product_pict/1l.webp'),
(12312, 'Seiko Chronograph SSB449P1 Discover More Black Dia', 4100000, 'Seiko', 'Silver', 5, '../product_pict/jam2.png'),
(312123, 'Casio General MQ-24-7E2LDF Classic Silver Dial Bla', 174000, 'Casio', 'Hitam', 20, '../product_pict/jam1.png'),
(12345212, 'Tsar Bomba Elemental TB8207CF-01 Carbon Fiber Auto', 7399000, 'Tsar Bomba', 'Hitam', 2, '../product_pict/jam3.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idTransaksi` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `tglBeli` datetime NOT NULL,
  `statusBayar` enum('gagal','berhasil','proses') NOT NULL,
  `alamatKirim` varchar(255) NOT NULL,
  `idProduk` int(11) NOT NULL,
  `statusPengiriman` enum('berhasil','gagal','proses') NOT NULL,
  `total` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idTransaksi`, `email`, `jumlah`, `tglBeli`, `statusBayar`, `alamatKirim`, `idProduk`, `statusPengiriman`, `total`) VALUES
(19, 'pelanggan1@email.com', 1, '2025-01-06 14:11:51', 'berhasil', 'Alamat Pelanggan 1', 12345212, 'proses', 7399000),
(20, 'pelanggan1@email.com', 2, '2025-01-06 14:12:28', 'proses', 'Alamat Pelanggan 1', 1, 'proses', 954000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idProduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idTransaksi`),
  ADD KEY `email` (`email`),
  ADD KEY `fk_parent` (`idProduk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idProduk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12345213;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idTransaksi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`idProduk`),
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`email`) REFERENCES `pelanggan` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
