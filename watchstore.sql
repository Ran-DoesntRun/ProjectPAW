-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 05:42 PM
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
('evan@email.com', '$2y$10$z4UVSxu84Ua4.m354ay7Ae1AOI99bNlYU8AbxOHP6zlGeDZmkUv1C');

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
('email2@email.com', 'user2', 'Ugm', 'Pass', '41274934242');

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
(1, 'Casio Mens Black Analog Watch MTP-VT01L-1B', 477000, 'Casio', 'Hitam', 14, '../product_pict/Casio Mens Black Analog Watch MTP-VT01L-1B (Size_ US Free).jpg'),
(3, 'Fossil FB-01 FS5657 Black Dial Stainless Steel Str', 1608000, 'Fossil', 'Silver', 10, '../product_pict/1l.webp');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idTransaksi` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `tglBeli` datetime NOT NULL,
  `statusBayar` enum('berhasil','proses') NOT NULL,
  `alamatKirim` varchar(255) NOT NULL,
  `idProduk` int(11) DEFAULT NULL,
  `statusPengiriman` enum('berhasil','proses') NOT NULL,
  `total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idTransaksi`, `email`, `jumlah`, `tglBeli`, `statusBayar`, `alamatKirim`, `idProduk`, `statusPengiriman`, `total`) VALUES
(21, 'email2@email.com', 3, '2024-12-16 23:12:44', 'berhasil', 'Ugm', 3, 'proses', 4824000);

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
  MODIFY `idProduk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idTransaksi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
