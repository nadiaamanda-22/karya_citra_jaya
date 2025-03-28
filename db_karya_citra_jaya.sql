-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2025 at 11:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
  `id_customer` int NOT NULL,
  `nama_customer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_customer`
--

INSERT INTO `t_customer` (`id_customer`, `nama_customer`, `no_hp`, `alamat`, `created_at`, `updated_at`) VALUES
(6, 'BP AHMAD', '0182938923', 'BOGOR', '2025-03-10 22:01:14', '2025-03-10 22:01:14'),
(7, 'ABADI JAYA', '01827382837', 'CIBINONG', '2025-03-11 12:47:34', '2025-03-11 12:47:34'),
(8, 'BP SAIFUL', '7288398392', 'CITAYAM', '2025-03-13 21:20:19', '2025-03-13 21:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice`
--

CREATE TABLE `t_invoice` (
  `id_invoice` int NOT NULL,
  `no_invoice` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_customer` int NOT NULL,
  `spg` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_jual` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `term` int NOT NULL,
  `status_pembayaran` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `hutang` decimal(20,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_rekening` int NOT NULL,
  `subtotal` decimal(20,2) NOT NULL,
  `ongkir` decimal(20,2) NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `jenis_invoice` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '0:invoice, 1:invoiceKaca',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_invoice`
--

INSERT INTO `t_invoice` (`id_invoice`, `no_invoice`, `id_customer`, `spg`, `tgl_jual`, `jatuh_tempo`, `term`, `status_pembayaran`, `hutang`, `metode_pembayaran`, `id_rekening`, `subtotal`, `ongkir`, `total`, `jenis_invoice`, `created_at`, `updated_at`) VALUES
(1, 'INV/25030001', 6, 'RISKA', '2025-03-11', '2025-03-11', 0, 'lunas', '0.00', 'tunai', 0, '44000.00', '0.00', '44000.00', '0', '2025-03-10 22:01:44', '2025-03-10 22:01:44'),
(2, 'INV/25030002', 7, 'HILDA', '2025-03-11', '2025-03-11', 0, 'lunas', '0.00', 'tunai', 0, '260000.00', '0.00', '260000.00', '1', '2025-03-11 12:50:08', '2025-03-11 12:50:08'),
(3, 'INV/25030003', 6, 'RISKA', '2025-03-11', '2025-03-11', 0, 'lunas', '0.00', 'tunai', 0, '1156000000.00', '0.00', '1156000000.00', '1', '2025-03-11 12:53:56', '2025-03-11 12:53:56'),
(5, 'INV/25030005', 8, 'RISKA', '2025-03-14', '2025-03-14', 0, 'lunas', '0.00', 'tunai', 0, '51000.00', '0.00', '51000.00', '1', '2025-03-13 21:28:02', '2025-03-13 21:28:02'),
(6, 'INV/25030006', 7, 'RISKA', '2025-03-14', '2025-03-14', 0, 'lunas', '0.00', 'tunai', 0, '337500.00', '0.00', '337500.00', '1', '2025-03-13 21:29:44', '2025-03-13 21:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice_detail`
--

CREATE TABLE `t_invoice_detail` (
  `id_invoice_detail` int NOT NULL,
  `id_invoice` int NOT NULL,
  `no_invoice` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang` int NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_jual` decimal(20,2) NOT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_nominal` decimal(20,2) NOT NULL,
  `jumlah` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_invoice_detail`
--

INSERT INTO `t_invoice_detail` (`id_invoice_detail`, `id_invoice`, `no_invoice`, `id_barang`, `nama_barang`, `harga_jual`, `stok`, `satuan`, `diskon_persen`, `diskon_nominal`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV/25030001', 39, 'RAMBUNCIS BL KANAN', '11000.00', 4, 'BH', 0, '0.00', '44000.00', '2025-03-10 22:01:44', '2025-03-10 22:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice_detail_kaca`
--

CREATE TABLE `t_invoice_detail_kaca` (
  `id_invoice_kaca` int NOT NULL,
  `id_invoice` int NOT NULL,
  `no_invoice` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang` int NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_jual` decimal(20,2) NOT NULL,
  `harga_permeter` decimal(20,2) DEFAULT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `panjang` double NOT NULL,
  `lebar` double NOT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_nominal` decimal(20,2) NOT NULL,
  `jumlah` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_invoice_detail_kaca`
--

INSERT INTO `t_invoice_detail_kaca` (`id_invoice_kaca`, `id_invoice`, `no_invoice`, `id_barang`, `nama_barang`, `harga_jual`, `harga_permeter`, `stok`, `satuan`, `panjang`, `lebar`, `diskon_persen`, `diskon_nominal`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 2, 'INV/25030002', 41, 'POLOS 5MM 122 X 153', '0.00', '160000.00', 2, 'LBR', 0, 0, 0, '0.00', '260000.00', '2025-03-11 12:50:08', '2025-03-11 12:50:08'),
(2, 3, 'INV/25030003', 42, 'POLOS 5MM', '578000000.00', '170000.00', 2, 'LBR', 50, 68, 0, '0.00', '1156000000.00', '2025-03-11 12:53:56', '2025-03-11 12:53:56'),
(4, 4, 'INV/25030004', 42, 'POLOS 5MM', '17849999999999997.00', '170000.00', 3, 'LBR', 0.7, 1.5, 0, '0.00', '5354999999999999.00', '2025-03-13 21:22:27', '2025-03-13 21:22:27'),
(5, 5, 'INV/25030005', 42, 'POLOS 5MM', '25500.00', '170000.00', 2, 'LBR', 0.6, 0.25, 0, '0.00', '51000.00', '2025-03-13 21:28:02', '2025-03-13 21:28:02'),
(6, 6, 'INV/25030006', 38, 'KACA HIJAU', '168750.00', '250000.00', 2, 'LBR', 0.75, 0.9, 0, '0.00', '337500.00', '2025-03-13 21:29:44', '2025-03-13 21:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelompok_barang`
--

CREATE TABLE `t_kelompok_barang` (
  `id_kelompok` int NOT NULL,
  `kode_kelompok` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kelompok` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kelompok_barang`
--

INSERT INTO `t_kelompok_barang` (`id_kelompok`, `kode_kelompok`, `nama_kelompok`, `created_at`, `updated_at`) VALUES
(4, 'A001', 'Alumunium', '2025-02-14 08:57:24', '2025-02-14 08:57:24'),
(5, 'A002', 'Aksesoris', '2025-02-14 08:57:39', '2025-02-14 08:57:39'),
(6, 'K001', 'Kaca', '2025-02-14 08:57:49', '2025-02-14 08:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `t_logs`
--

CREATE TABLE `t_logs` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_logs`
--

INSERT INTO `t_logs` (`id`, `username`, `tanggal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-02-28 13:54:54', 'Mengubah stok barang dengan kode ACP 3MM BB', '2025-02-28 06:54:54', '2025-02-28 06:54:54'),
(2, 'admin', '2025-02-28 14:04:38', 'Menambah stok barang dengan kode 0555 WH', '2025-02-28 07:04:38', '2025-02-28 07:04:38'),
(3, 'admin', '2025-03-01 20:43:28', 'Menambah stok barang dengan kode K002', '2025-03-01 13:43:28', '2025-03-01 13:43:28'),
(4, 'admin', '2025-03-01 20:44:18', 'Menambah stok barang dengan kode RAMBUNCIS BL KANAN', '2025-03-01 13:44:18', '2025-03-01 13:44:18'),
(5, 'admin', '2025-03-10 21:15:51', 'Melakukan pembelian barang dengan no transaksi PB/25030001', '2025-03-10 14:15:51', '2025-03-10 14:15:51'),
(6, 'admin', '2025-03-11 05:01:44', 'Transaksi invoice dengan no invoice INV/25030001', '2025-03-10 22:01:44', '2025-03-10 22:01:44'),
(7, 'admin', '2025-03-11 19:46:05', 'Melakukan pembelian barang dengan no transaksi PB/25030002', '2025-03-11 12:46:05', '2025-03-11 12:46:05'),
(8, 'admin', '2025-03-11 19:48:15', 'Menambah stok barang dengan kode SILICONE BL NTL', '2025-03-11 12:48:15', '2025-03-11 12:48:15'),
(9, 'admin', '2025-03-11 19:49:11', 'Menambah stok barang dengan kode POLOS 5MM', '2025-03-11 12:49:11', '2025-03-11 12:49:11'),
(10, 'admin', '2025-03-11 19:50:08', 'Transaksi invoice kaca dengan no invoice INV/25030002', '2025-03-11 12:50:08', '2025-03-11 12:50:08'),
(11, 'admin', '2025-03-11 19:51:47', 'Menambah stok barang dengan kode KACA POLOS 5MM', '2025-03-11 12:51:47', '2025-03-11 12:51:47'),
(12, 'admin', '2025-03-11 19:53:56', 'Transaksi invoice kaca dengan no invoice INV/25030003', '2025-03-11 12:53:56', '2025-03-11 12:53:56'),
(13, 'admin', '2025-03-14 04:21:15', 'Transaksi invoice kaca dengan no invoice INV/25030004', '2025-03-13 21:21:15', '2025-03-13 21:21:15'),
(14, 'admin', '2025-03-14 04:22:27', 'Melakukan update transaksi invoice kaca dengan no invoice INV/25030004', '2025-03-13 21:22:27', '2025-03-13 21:22:27'),
(15, 'admin', '2025-03-14 04:28:02', 'Transaksi invoice kaca dengan no invoice INV/25030005', '2025-03-13 21:28:02', '2025-03-13 21:28:02'),
(16, 'admin', '2025-03-14 04:29:44', 'Transaksi invoice kaca dengan no invoice INV/25030006', '2025-03-13 21:29:44', '2025-03-13 21:29:44'),
(17, 'admin', '2025-03-14 04:33:44', 'Menghapus invoice kaca dengan no invoice INV/25030004', '2025-03-13 21:33:44', '2025-03-13 21:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--

CREATE TABLE `t_menu` (
  `id_menu` int NOT NULL,
  `menu` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`id_menu`, `menu`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(2, 'invoice', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(3, 'stok barang', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(4, 'kelompok barang', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(5, 'pembelian barang', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(6, 'customer', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(7, 'supplier', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(8, 'rekening', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(9, 'laporan penjualan', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(10, 'laporan pembelian', '2025-03-05 23:26:16', '2025-03-05 23:26:16'),
(11, 'laporan stok', '2025-03-05 23:26:16', '2025-03-05 23:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_no_hp`
--

CREATE TABLE `t_no_hp` (
  `id` int NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_no_hp`
--

INSERT INTO `t_no_hp` (`id`, `no_hp`, `created_at`, `updated_at`) VALUES
(4, '081213780355', '2025-02-11 12:01:33', '2025-02-18 13:52:39'),
(5, '081293124402', '2025-02-18 13:52:54', '2025-02-18 13:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `t_pembelian_barang`
--

CREATE TABLE `t_pembelian_barang` (
  `id_pembelian` int NOT NULL,
  `no_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_supplier` int NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `term` int NOT NULL,
  `status_pembayaran` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hutang` decimal(20,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_rekening` int NOT NULL DEFAULT '0',
  `total` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pembelian_barang`
--

INSERT INTO `t_pembelian_barang` (`id_pembelian`, `no_transaksi`, `id_supplier`, `tgl_pembelian`, `jatuh_tempo`, `term`, `status_pembayaran`, `hutang`, `metode_pembayaran`, `id_rekening`, `total`, `created_at`, `updated_at`) VALUES
(21, 'PB/25030001', 20, '2025-03-10', '2025-03-10', 0, 'lunas', '0.00', 'tunai', 0, '100.00', '2025-03-10 14:15:51', '2025-03-10 14:15:51'),
(22, 'PB/25030002', 20, '2025-03-11', '2025-03-11', 0, 'lunas', '0.00', 'tunai', 0, '1362848.00', '2025-03-11 12:46:05', '2025-03-11 12:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `t_pembelian_barang_detail`
--

CREATE TABLE `t_pembelian_barang_detail` (
  `id_pembelian_detail` int NOT NULL,
  `id_pembelian` int NOT NULL,
  `no_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang` int NOT NULL,
  `nama_barang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_beli` decimal(20,2) NOT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_nominal` decimal(20,2) NOT NULL,
  `jumlah` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pembelian_barang_detail`
--

INSERT INTO `t_pembelian_barang_detail` (`id_pembelian_detail`, `id_pembelian`, `no_transaksi`, `id_barang`, `nama_barang`, `harga_beli`, `stok`, `satuan`, `diskon_persen`, `diskon_nominal`, `jumlah`, `created_at`, `updated_at`) VALUES
(24, 21, 'PB/25030001', 39, 'RAMBUNCIS BL KANAN', '1.00', 100, 'BH', 0, '0.00', '100.00', '2025-03-10 14:15:51', '2025-03-10 14:15:51'),
(25, 22, 'PB/25030002', 39, 'RAMBUNCIS BL KANAN', '1.00', 200, 'BH', 0, '0.00', '200.00', '2025-03-11 12:46:05', '2025-03-11 12:46:05'),
(26, 22, 'PB/25030002', 8, 'silicone', '56777.00', 24, 'bh', 0, '0.00', '1362648.00', '2025-03-11 12:46:05', '2025-03-11 12:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `t_pengaturan`
--

CREATE TABLE `t_pengaturan` (
  `id` int NOT NULL,
  `nama_toko` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_no_hp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ttd` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stempel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `copy_nota` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '0:enable, 1:disable',
  `max_detail_input` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pengaturan`
--

INSERT INTO `t_pengaturan` (`id`, `nama_toko`, `no_telp`, `id_no_hp`, `alamat`, `ttd`, `stempel`, `copy_nota`, `max_detail_input`, `created_at`, `updated_at`) VALUES
(19, 'Karya Citra Jaya', '0990889090', '5,6', 'Bogor', 'no-image.jpg', 'no-image.jpg', '0', 5, '2025-02-23 02:58:45', '2025-02-23 02:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `t_rekening`
--

CREATE TABLE `t_rekening` (
  `id_rekening` int NOT NULL,
  `rekening` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_rekening`
--

INSERT INTO `t_rekening` (`id_rekening`, `rekening`, `created_at`, `updated_at`) VALUES
(5, '12345678 A/N Rokib Afandi', '2025-03-11 12:46:50', '2025-03-11 12:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `t_stok`
--

CREATE TABLE `t_stok` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_barang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_kelompok` int NOT NULL,
  `stok` double NOT NULL,
  `satuan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `harga_jual` decimal(20,2) NOT NULL,
  `harga_permeter` decimal(20,2) DEFAULT NULL,
  `harga_beli` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_stok`
--

INSERT INTO `t_stok` (`id`, `kode_barang`, `nama_barang`, `id_kelompok`, `stok`, `satuan`, `harga_jual`, `harga_permeter`, `harga_beli`, `created_at`, `updated_at`) VALUES
(2, '8309 BL PC', 'casement gunung bl pc ink', 0, 300, 'BTG', '160000.00', '5000.00', '35000.00', '2025-02-14 09:32:24', '2025-02-15 13:49:08'),
(3, 'K001', 'Kaca Polos 5mm', 2, 120, 'lbr', '13000.00', '10000.00', '12000.00', '2025-02-14 13:18:15', '2025-02-15 09:21:00'),
(4, '0560 WH IN', 'Openback Polos 4inch WH INK', 0, 85, 'btg', '80000.00', '5000.00', '70000.00', '2025-02-15 13:46:14', '2025-02-15 13:53:05'),
(5, '0560 WH IN', 'Openback Polos 4inch WH INK', 0, 800, 'btg', '80000.00', '10000.00', '70000.00', '2025-02-15 13:47:15', '2025-02-15 14:16:31'),
(6, '5705 bl pc', 'tiang p lipat', 0, 700, 'btg', '25000.00', '5000.00', '20000.00', '2025-02-15 13:49:57', '2025-02-15 13:50:12'),
(7, 'baut', 'baut 8x3', 0, 80, 'bh', '20000.00', '0.00', '70000.00', '2025-02-15 13:57:33', '2025-02-15 13:58:47'),
(8, 'a0005', 'silicone', 0, 103, 'bh', '80000.00', '15000.00', '56777.00', '2025-02-15 14:11:42', '2025-03-11 12:46:05'),
(9, '0428 BL PC', 'Openback polos 3inch black', 0, 65, 'btg', '80000.00', '8000.00', '70000.00', '2025-02-15 14:34:58', '2025-02-15 14:37:05'),
(14, 'ACP 3MM BB', 'ACP 3MM BB BLACK SOLID', 4, 100, 'LBR', '220000.00', '0.00', '1.00', '2025-02-27 02:57:04', '2025-02-28 06:54:54'),
(15, 'ACP 3MM BB', 'ACP 3MM BB BROWN GLOSS', 4, 100, 'LBR', '220.00', '0.00', '1.00', '2025-02-27 02:58:07', '2025-02-27 02:58:07'),
(16, 'ACP 3MM BB', 'ACP 3MM BB MAPLE', 4, 100, 'LBR', '240.00', '0.00', '1.00', '2025-02-27 02:58:56', '2025-02-27 02:58:56'),
(17, 'ACP 3MM BB', 'ACP 3MM BB WHITE GLOSS', 4, 100, 'LBR', '220.00', '0.00', '1.00', '2025-02-27 03:05:09', '2025-02-27 03:05:09'),
(18, 'ACP 3MM BB', 'ACP 3MM BB BLACK SOLID', 4, 100, 'LBR', '220.00', '0.00', '1.00', '2025-02-27 03:05:49', '2025-02-27 03:05:49'),
(19, 'ACP 3MM BL', 'ACP 3MM BLUE GLOSS', 4, 20, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:06:46', '2025-02-27 03:06:46'),
(20, 'ACP 3MM BR', 'ACP 3MM BROWN GLOSS', 4, 100, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:09:01', '2025-02-27 03:09:01'),
(21, 'ACP 3MM BR', 'ACP 3MM BROWN MOCHA', 4, 20, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:09:46', '2025-02-27 03:09:46'),
(22, 'ACP 3MM DA', 'ACP 3MM DARK GREY', 4, 25, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:10:25', '2025-02-27 03:10:25'),
(23, 'ACP 3MM GR', 'ACP 3MM GREEN LIME', 4, 20, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:11:01', '2025-02-27 03:11:01'),
(24, 'ACP 3MM GR', 'ACP 3MM GREY COIN', 4, 20, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:11:33', '2025-02-27 03:11:33'),
(25, 'ACP 3MM MA', 'ACP 3MM MAHOGANY', 4, 100, 'LBR', '220.00', '0.00', '1.00', '2025-02-27 03:12:10', '2025-02-27 03:12:10'),
(26, 'ACP 3MM MA', 'ACP 3MM MAPLE', 4, 100, 'LBR', '220.00', '0.00', '1.00', '2025-02-27 03:17:25', '2025-02-27 03:17:25'),
(27, 'ACP 3MM OR', 'ACP 3MM ORANGE PAPAYA', 4, 25, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:18:14', '2025-02-27 03:18:14'),
(28, 'ACP 3MM RE', 'ACP 3MM RED GLOSS', 4, 30, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:27:04', '2025-02-27 03:27:04'),
(29, 'ACP 3MM SP', 'ACP 3MM SPARKLING SILVER', 4, 30, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:27:55', '2025-02-27 03:27:55'),
(30, 'ACP 3MM WH', 'ACP 3MM WHITE GLOSS', 4, 250, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:28:45', '2025-02-27 03:28:45'),
(31, 'ACP 3MM WH', 'ACP 3MM WHITE MARBLE', 4, 40, 'LBR', '220.00', '0.00', '1.00', '2025-02-27 03:29:22', '2025-02-27 03:29:22'),
(32, 'ACP 3MM WH', 'ACP 3MM WHITE MILK', 4, 8, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:29:58', '2025-02-27 03:29:58'),
(33, 'ACP 3MM YE', 'ACP 3MM YELLOW MUSTARD', 4, 30, 'LBR', '175.00', '0.00', '1.00', '2025-02-27 03:30:34', '2025-02-27 03:30:34'),
(34, '9056 BL PC', 'AMBANG ATAS DOOR BL PC INK', 4, 3, 'BTG', '203.19', '0.00', '1.00', '2025-02-27 03:36:21', '2025-02-27 03:36:21'),
(35, '9056 BL PC', 'AMBANG ATAS DOOR BL PC', 4, 1, 'BTG', '218.20', '0.00', '1.00', '2025-02-27 03:47:33', '2025-02-27 03:47:33'),
(36, 'AMBANG ATA', 'AMBANG ATAS DOOR BL PC INK', 4, 5, 'BTG', '276.74', '0.00', '1.00', '2025-02-27 03:48:43', '2025-02-27 03:48:43'),
(37, '0555 WH', 'TUTUP GOT WHITE', 4, 0, 'BTG', '50000.00', '0.00', '1.00', '2025-02-28 07:04:38', '2025-02-28 07:04:38'),
(38, 'K002', 'KACA HIJAU', 6, -2, 'LBR', '650000.00', '250000.00', '1.00', '2025-03-01 13:43:28', '2025-03-13 21:29:44'),
(39, 'RAMBUNCIS ', 'RAMBUNCIS BL KANAN', 5, 296, 'BH', '11000.00', '0.00', '1.00', '2025-03-01 13:44:18', '2025-03-11 12:46:05'),
(40, 'SILICONE B', 'SILICONE BLACK NEUTRAL', 5, 70, 'BTL', '25000.00', '0.00', '20000.00', '2025-03-11 12:48:15', '2025-03-11 12:48:15'),
(41, 'POLOS 5MM', 'POLOS 5MM 122 X 153', 6, 98, 'LBR', '130000.00', '160000.00', '1.00', '2025-03-11 12:49:11', '2025-03-11 12:50:08'),
(42, 'KACA POLOS', 'POLOS 5MM', 6, 23, 'LBR', '1.00', '170000.00', '1.00', '2025-03-11 12:51:47', '2025-03-13 21:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `t_supplier`
--

CREATE TABLE `t_supplier` (
  `id_supplier` int NOT NULL,
  `supplier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_supplier`
--

INSERT INTO `t_supplier` (`id_supplier`, `supplier`, `created_at`, `updated_at`) VALUES
(20, 'BINTANG BAUT', '2025-03-10 14:15:28', '2025-03-10 14:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password_md5` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '0:admin, 1:notAdmin',
  `level` enum('0','1','2') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '0:crud, 1:addOnly, 2:readOnly',
  `image` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id_user`, `nama_user`, `username`, `password`, `password_md5`, `role`, `level`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'Admin234!', '871e20d0d5790dcb89e79d148cb58093', '0', '0', 'default.png', '2025-03-07 03:07:04', '2025-03-07 03:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_menu`
--

CREATE TABLE `t_user_menu` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_menu` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user_menu`
--

INSERT INTO `t_user_menu` (`id`, `id_user`, `id_menu`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(2, 1, 2, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(3, 1, 3, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(4, 1, 4, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(5, 1, 5, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(6, 1, 6, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(7, 1, 7, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(8, 1, 8, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(9, 1, 9, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(10, 1, 10, '2025-03-07 03:08:55', '2025-03-07 03:08:55'),
(11, 1, 11, '2025-03-07 03:08:55', '2025-03-07 03:08:55');

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
-- Indexes for table `t_pembelian_barang_detail`
--
ALTER TABLE `t_pembelian_barang_detail`
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
  MODIFY `id_customer` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_invoice`
--
ALTER TABLE `t_invoice`
  MODIFY `id_invoice` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_invoice_detail`
--
ALTER TABLE `t_invoice_detail`
  MODIFY `id_invoice_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_invoice_detail_kaca`
--
ALTER TABLE `t_invoice_detail_kaca`
  MODIFY `id_invoice_kaca` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_kelompok_barang`
--
ALTER TABLE `t_kelompok_barang`
  MODIFY `id_kelompok` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_logs`
--
ALTER TABLE `t_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_menu`
--
ALTER TABLE `t_menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `t_no_hp`
--
ALTER TABLE `t_no_hp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_pembelian_barang`
--
ALTER TABLE `t_pembelian_barang`
  MODIFY `id_pembelian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `t_pembelian_barang_detail`
--
ALTER TABLE `t_pembelian_barang_detail`
  MODIFY `id_pembelian_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `t_pengaturan`
--
ALTER TABLE `t_pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `t_rekening`
--
ALTER TABLE `t_rekening`
  MODIFY `id_rekening` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_stok`
--
ALTER TABLE `t_stok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `t_supplier`
--
ALTER TABLE `t_supplier`
  MODIFY `id_supplier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_user_menu`
--
ALTER TABLE `t_user_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
