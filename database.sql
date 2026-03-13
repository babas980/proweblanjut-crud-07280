-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2026 at 04:04 PM
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
-- Database: `inventory_pwl`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(20) DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` enum('Smartphone','Laptop','Aksesoris','Komponen PC','Perangkat Input','Lainnya') DEFAULT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `kategori`, `harga_jual`, `stok`, `create_at`) VALUES
(5, 'PHN-001', 'iPhone 15 Pro', 'Smartphone', 15000000, 25, '2026-03-11 15:52:08'),
(6, 'PHN-002', 'Samsung S24 Ultra', 'Smartphone', 1850000, 15, '2026-03-11 15:52:08'),
(7, 'INP-001', 'Logitech G Pro Mouse', 'Perangkat Input', 75000, 10, '2026-03-11 15:52:08'),
(8, 'LPT-001', 'MacBook Air M3', 'Laptop', 45000, 50, '2026-03-11 15:52:08'),
(9, 'ACC-001', 'AirPods Pro Gen 2', 'Aksesoris', 15000, 100, '2026-03-11 15:52:08'),
(10, 'LPT-002', 'ASUS ROG Zephyrus', 'Laptop', 165000, 20, '2026-03-11 16:04:20'),
(11, 'INP-002', 'Keychron K6 Wireless', 'Perangkat Input', 450000, 8, '2026-03-11 16:04:20'),
(12, 'CMP-001', 'RTX 4060 Ti MSI', 'Lainnya', 50000, 200, '2026-03-11 16:04:20'),
(13, 'PHN-003', 'Xiaomi 14', 'Smartphone', 1950000, 12, '2026-03-11 16:04:20'),
(14, 'CMP-002', 'SSD NVMe 1TB Samsung', 'Komponen PC', 85000, 30, '2026-03-11 16:04:20'),
(15, 'CMP-003', 'RAM DDR5 32GB', 'Lainnya', 35000, 150, '2026-03-11 16:04:20'),
(16, 'LPT-003', 'Lenovo Legion 5', 'Laptop', 125000, 40, '2026-03-11 16:04:20'),
(17, 'ACC-002', 'Sony WH-1000XM5', 'Aksesoris', 210000, 15, '2026-03-11 16:04:20'),
(18, 'ACC-003', 'Monitor LG 24 inch', 'Lainnya', 12000, 60, '2026-03-11 16:04:20'),
(19, 'INP-003', 'Webcam Razer Kiyo', 'Perangkat Input', 500000, 500, '2026-03-11 16:04:20'),
(20, 'INP-004', 'Razer DeathAdder', 'Perangkat Input', 275000, 10, '2026-03-11 16:04:20'),
(21, 'ACC-004', 'Powerbank Anker 20k', 'Aksesoris', 150000, 25, '2026-03-11 16:04:20'),
(22, 'ACC-005', 'Kabel HDMI 2.1', 'Lainnya', 20000, 100, '2026-03-11 16:04:20'),
(23, 'PHN-004', 'Google Pixel 8', 'Smartphone', 210000, 18, '2026-03-11 16:04:20'),
(24, 'INP-005', 'Webcam Logitech C922', 'Perangkat Input', 350000, 5, '2026-03-11 16:04:20'),
(25, 'CMP-004', 'Motherboard B650', 'Perangkat Input', 8000, 45, '2026-03-11 16:04:20'),
(26, 'LPT-004', 'Dell XPS 13', 'Laptop', 250000, 14, '2026-03-11 16:04:20'),
(27, 'ACC-006', 'Kabel LAN Cat6 10m', 'Komponen PC', 45000, 20, '2026-03-11 16:04:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
