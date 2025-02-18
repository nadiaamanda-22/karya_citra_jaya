-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 10, 2025 at 03:07 PM
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
-- Database: `db_karya_citra_jaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_customer`
--

CREATE TABLE `t_customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice`
--

CREATE TABLE `t_invoice` (
  `id_invoice` int(11) NOT NULL,
  `no_invoice` varchar(50) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `spg` varchar(100) NOT NULL,
  `tgl_jual` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `term` int(11) NOT NULL,
  `status_pembayaran` varchar(15) NOT NULL,
  `hutang` decimal(20,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `id_rekening` int(11) NOT NULL,
  `subtotal` decimal(20,2) NOT NULL,
  `diskon` decimal(20,2) NOT NULL,
  `ongkir` decimal(20,2) NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `jenis_invoice` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:invoice, 1:invoiceKaca',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice_detail`
--

CREATE TABLE `t_invoice_detail` (
  `id_invoice_detail` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `no_invoice` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_jual` decimal(20,2) NOT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_nominal` decimal(20,2) NOT NULL,
  `jumlah` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice_detail_kaca`
--

CREATE TABLE `t_invoice_detail_kaca` (
  `id_invoice_kaca` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `no_invoice` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_jual` decimal(20,2) NOT NULL,
  `harga_permeter` decimal(20,2) DEFAULT NULL,
  `stok` double NOT NULL,
  `tebal` double NOT NULL,
  `panjang` double NOT NULL,
  `lebar` double NOT NULL,
  `jumlah` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_kelompok_barang`
--

CREATE TABLE `t_kelompok_barang` (
  `id_kelompok` int(11) NOT NULL,
  `kode_kelompok` varchar(10) NOT NULL,
  `nama_kelompok` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_logs`
--

CREATE TABLE `t_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--

CREATE TABLE `t_menu` (
  `id_menu` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`id_menu`, `menu`, `created_at`, `updated_at`) VALUES
(1, 'stok barang', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(2, 'kelompok barang', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(3, 'pembelian barang', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(4, 'customer', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(5, 'supplier', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(6, 'rekening', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(7, 'laporan penjualan', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(8, 'laporan pembelian', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(9, 'laporan stok', '2025-02-08 07:42:00', '2025-02-08 07:42:00'),
(10, 'dashboard', '2025-02-08 10:16:34', '2025-02-08 10:16:34'),
(11, 'invoice', '2025-02-08 10:16:34', '2025-02-08 10:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `t_no_hp`
--

CREATE TABLE `t_no_hp` (
  `id` int(11) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pembelian_barang`
--

CREATE TABLE `t_pembelian_barang` (
  `id_pembelian` int(11) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `term` int(11) NOT NULL,
  `status_pembayaran` varchar(15) NOT NULL,
  `hutang` decimal(20,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `id_rekening` int(11) NOT NULL,
  `subtotal` decimal(20,2) NOT NULL,
  `diskon` decimal(20,2) NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pembelian_brang_detail`
--

CREATE TABLE `t_pembelian_brang_detail` (
  `id_pembelian_detail` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_beli` decimal(20,2) NOT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_nominal` decimal(20,2) NOT NULL,
  `jumlah` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pengaturan`
--

CREATE TABLE `t_pengaturan` (
  `id` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `id_no_hp` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `ttd` varchar(100) NOT NULL,
  `stempel` varchar(100) NOT NULL,
  `format_price` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:desimal, 1:pecahan',
  `copy_nota` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:enable, 1:disable',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_rekening`
--

CREATE TABLE `t_rekening` (
  `id_rekening` int(11) NOT NULL,
  `rekening` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_stok`
--

CREATE TABLE `t_stok` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `id_kelompok` int(11) NOT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga_jual` decimal(20,2) NOT NULL,
  `harga_permeter` decimal(20,2) DEFAULT NULL,
  `harga_beli` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_supplier`
--

CREATE TABLE `t_supplier` (
  `id_supplier` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `password_md5` varchar(200) NOT NULL,
  `role` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:admin, 1:notAdmin',
  `level` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0:crud, 1:addOnly, 2:readOnly',
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id_user`, `nama_user`, `username`, `password`, `password_md5`, `role`, `level`, `image`, `created_at`, `updated_at`) VALUES
(11, 'Admin', 'admin', 'admin123', '0192023a7bbd73250516f069df18b500', '0', '0', '1739082480_3135789.png', '2025-02-09 06:27:16', '2025-02-10 11:58:32'),
(14, 'Riska', 'riska123', 'riska123', 'a61fec1781fc3e2be92403ee1c65342a', '1', '0', '1739195330_3135789.png', '2025-02-10 12:25:43', '2025-02-10 14:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_menu`
--

CREATE TABLE `t_user_menu` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user_menu`
--

INSERT INTO `t_user_menu` (`id`, `id_user`, `id_menu`, `created_at`, `updated_at`) VALUES
(85, 11, 10, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(86, 11, 11, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(87, 11, 1, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(88, 11, 2, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(89, 11, 3, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(90, 11, 4, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(91, 11, 5, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(92, 11, 6, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(93, 11, 7, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(94, 11, 8, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(95, 11, 9, '2025-02-09 06:28:00', '2025-02-09 06:28:00'),
(135, 14, 10, '2025-02-10 14:02:56', '2025-02-10 14:02:56'),
(136, 14, 1, '2025-02-10 14:02:56', '2025-02-10 14:02:56'),
(137, 14, 4, '2025-02-10 14:02:56', '2025-02-10 14:02:56'),
(138, 14, 5, '2025-02-10 14:02:56', '2025-02-10 14:02:56'),
(139, 14, 7, '2025-02-10 14:02:56', '2025-02-10 14:02:56'),
(140, 14, 8, '2025-02-10 14:02:56', '2025-02-10 14:02:56'),
(141, 14, 9, '2025-02-10 14:02:56', '2025-02-10 14:02:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `t_invoice`
--
ALTER TABLE `t_invoice`
  ADD PRIMARY KEY (`id_invoice`);

--
-- Indexes for table `t_invoice_detail`
--
ALTER TABLE `t_invoice_detail`
  ADD PRIMARY KEY (`id_invoice_detail`);

--
-- Indexes for table `t_invoice_detail_kaca`
--
ALTER TABLE `t_invoice_detail_kaca`
  ADD PRIMARY KEY (`id_invoice_kaca`);

--
-- Indexes for table `t_kelompok_barang`
--
ALTER TABLE `t_kelompok_barang`
  ADD PRIMARY KEY (`id_kelompok`);

--
-- Indexes for table `t_logs`
--
ALTER TABLE `t_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_menu`
--
ALTER TABLE `t_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `t_no_hp`
--
ALTER TABLE `t_no_hp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_pembelian_barang`
--
ALTER TABLE `t_pembelian_barang`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `t_pembelian_brang_detail`
--
ALTER TABLE `t_pembelian_brang_detail`
  ADD PRIMARY KEY (`id_pembelian_detail`);

--
-- Indexes for table `t_pengaturan`
--
ALTER TABLE `t_pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_rekening`
--
ALTER TABLE `t_rekening`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indexes for table `t_stok`
--
ALTER TABLE `t_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_supplier`
--
ALTER TABLE `t_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `t_user_menu`
--
ALTER TABLE `t_user_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_invoice`
--
ALTER TABLE `t_invoice`
  MODIFY `id_invoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_invoice_detail`
--
ALTER TABLE `t_invoice_detail`
  MODIFY `id_invoice_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_invoice_detail_kaca`
--
ALTER TABLE `t_invoice_detail_kaca`
  MODIFY `id_invoice_kaca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_kelompok_barang`
--
ALTER TABLE `t_kelompok_barang`
  MODIFY `id_kelompok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_logs`
--
ALTER TABLE `t_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_menu`
--
ALTER TABLE `t_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `t_no_hp`
--
ALTER TABLE `t_no_hp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_pembelian_barang`
--
ALTER TABLE `t_pembelian_barang`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_pembelian_brang_detail`
--
ALTER TABLE `t_pembelian_brang_detail`
  MODIFY `id_pembelian_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_pengaturan`
--
ALTER TABLE `t_pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_rekening`
--
ALTER TABLE `t_rekening`
  MODIFY `id_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_stok`
--
ALTER TABLE `t_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_supplier`
--
ALTER TABLE `t_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `t_user_menu`
--
ALTER TABLE `t_user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
