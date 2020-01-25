-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 25, 2020 at 07:22 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kedai_bakso`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_order` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_masakan` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_order`, `id_transaksi`, `id_masakan`, `qty`, `total`) VALUES
(54, 81, 1, 2, 40000),
(55, 81, 3, 2, 14000),
(56, 82, 3, 2, 14000),
(57, 83, 3, 2, 14000),
(58, 83, 8, 2, 30000),
(59, 83, 9, 2, 40000),
(64, 84, 6, 2, 30000),
(65, 85, 9, 2, 40000),
(66, 85, 9, 2, 40000),
(67, 86, 6, 2, 30000),
(68, 87, 8, 2, 30000),
(69, 87, 8, 2, 30000);

--
-- Triggers `detail_transaksi`
--
DELIMITER $$
CREATE TRIGGER `batal_transaksi` AFTER DELETE ON `detail_transaksi` FOR EACH ROW BEGIN
	UPDATE masakan SET stok = stok + OLD.qty
    WHERE id_masakan = OLD.id_masakan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_transaksi` AFTER INSERT ON `detail_transaksi` FOR EACH ROW BEGIN
	UPDATE masakan SET stok = stok - NEW.qty
    WHERE id_masakan = NEW.id_masakan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'administrator'),
(2, 'kasir'),
(3, 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `masakan`
--

CREATE TABLE `masakan` (
  `id_masakan` int(11) NOT NULL,
  `nama_masakan` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masakan`
--

INSERT INTO `masakan` (`id_masakan`, `nama_masakan`, `harga`, `stok`, `gambar`, `kategori`, `deskripsi`) VALUES
(1, 'Bakso Ayam', 20000, 64, 'bakso_ayam.jpg', 'biasa', 'Bakso ini dibuat dengan bahan utama daging ayam segar yang sudah diolah dengan bahan rempah rempah lainya'),
(3, 'Bakso Ikan', 7000, 57, 'bakso_ikan1.jpg', 'biasa', 'Bakso ini berisikan daging ikan Tengiri yang masih segar langsung dari nelayan dan sudah diolah'),
(6, 'Bakso Kelapa Muda', 15000, 58, 'menu-02.jpg', 'favorit', 'Berbeda dengan wadah lainya, bakso kelapa muda ini menggunakan batok kelapa muda sebagai wadahnya'),
(8, 'Bakso Tahu', 15000, 60, 'bakso_tahu.jpg', 'biasa', 'di buat dengan bahan utama dari Tahu dan bahan lainya, karena tahu banyak mengandung protein dan vitamin'),
(9, 'Bakso Sapi', 20000, 12, 'bakso_sapi.jpg', 'biasa', 'Bakso ini terbuat dari olahan Daging Sapi Segar, dan dengan bumbu rempah rempah lainya'),
(10, 'Bakso Bakar', 20000, 13, 'bakso-03.jpg', 'favorit', 'Bakso ini merupakan Varian dari bakso lainya, bakso bakar ini di sindik seperti lalu di bakar seperti sate'),
(11, 'Bakso Spesial', 30000, 20, 'img002.jpg', 'biasa', 'adsadas asdasd asdas  sdasd');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `total_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `tanggal`, `total_bayar`) VALUES
(81, 7, '2020-01-22', 54000),
(82, 8, '2020-01-22', 14000),
(83, 8, '2020-01-22', 84000),
(84, 7, '2020-01-24', 30000),
(85, 7, '2020-01-24', 80000),
(86, 7, '2020-01-25', 30000),
(87, 7, '2020-01-25', 60000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `id_level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `id_level`) VALUES
(1, 'admin', '$2y$10$MpswdqzkH0V2FJEfSm7iPuV2ImhMbocqMcA/rtQf1yjlmeiFcmXEW', 'Admin', 1),
(5, 'superadmin', '$2y$10$xZi0wZPSwm/VW512Vfgt0eDoy4N7vggsVXLivEEYkRZPMwcxIe2Ea', 'Mang Admin', 1),
(6, 'owner', '$2y$10$jermOQ9Tnknik5O.n0aOEeymhIDi8r4oiZcEQDFmsCd3pHq5a5CJO', 'Owner', 3),
(7, 'kasir', '$2y$10$7F1BHJ65tgY1WrxRx5u4Le08Whdq4HrNyNOH7/wmmhesl6uCTdGJm', 'Kasir', 2),
(8, 'kasir2', '$2y$10$69iuKJ/kCkefZ6DzFV/Ip.z3rCc64bLVdVsOvZgMkPtswW95J2NLy', 'Kasir 2', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `masakan`
--
ALTER TABLE `masakan`
  ADD PRIMARY KEY (`id_masakan`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `masakan`
--
ALTER TABLE `masakan`
  MODIFY `id_masakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
