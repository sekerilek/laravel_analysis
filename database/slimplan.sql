-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2021 at 08:54 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slimplan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodeKaryawan` varchar(191) NOT NULL,
  `TanggalAbsen` date DEFAULT NULL,
  `WaktuAbsen` time DEFAULT NULL,
  `StatusAbsen` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alamatpelanggans`
--

CREATE TABLE `alamatpelanggans` (
  `id` int(11) NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kota` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Provinsi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Negara` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Faks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telepon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoIndeks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alamatpelanggans`
--

INSERT INTO `alamatpelanggans` (`id`, `KodePelanggan`, `Alamat`, `Kota`, `Provinsi`, `Negara`, `Faks`, `Telepon`, `NoIndeks`, `created_at`, `updated_at`) VALUES
(1, 'PLG-001', 'Malang', 'Malang', NULL, NULL, NULL, NULL, 1, '2021-04-22 02:45:30', '2021-04-22 02:45:30'),
(2, 'PLG-002', 'Malang', 'Malang', NULL, NULL, NULL, NULL, 1, '2021-09-03 18:01:16', '2021-09-03 18:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `alatbayarkasirs`
--

CREATE TABLE `alatbayarkasirs` (
  `KodeAlatBayarKasir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UntukPembayaran` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NominalPPN` double NOT NULL,
  `Bayar` double NOT NULL,
  `Kembali` double NOT NULL,
  `Ongkir` double NOT NULL,
  `KodeJenisBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_menu_user`
--

CREATE TABLE `app_menu_user` (
  `user` varchar(191) NOT NULL,
  `menu` varchar(191) NOT NULL,
  `func` varchar(191) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `NomorRekening` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaBank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nomor` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailgajians`
--

CREATE TABLE `detailgajians` (
  `KodeGaji` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeBarang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `HargaBarang` varchar(10) NOT NULL,
  `JumlahBarang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalHargaBarang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EnkripsiKodeGaji` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detailgolongans`
--

CREATE TABLE `detailgolongans` (
  `KodeGolongan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeGolItem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaGolItem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HargaGolItem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detailgolongans`
--

INSERT INTO `detailgolongans` (`KodeGolongan`, `KodeGolItem`, `NamaGolItem`, `HargaGolItem`, `created_at`, `updated_at`) VALUES
('GOL-01', 'GI-001-01', '-', '0', '2021-04-22 05:32:10', '2021-04-22 05:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `KodeDriver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaDriver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`KodeDriver`, `NamaDriver`, `Kontak`, `Status`, `KodeKaryawan`, `created_at`, `updated_at`) VALUES
('DRV-001', 'Yono', '082245497019', 'OPN', 'KAR-001', '2021-04-22 05:40:52', '2021-04-22 05:40:52');

-- --------------------------------------------------------

--
-- Table structure for table `eventlogs`
--

CREATE TABLE `eventlogs` (
  `id` bigint(20) NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam` time NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eventlogs`
--

INSERT INTO `eventlogs` (`id`, `KodeUser`, `Tanggal`, `Jam`, `Keterangan`, `Tipe`, `created_at`, `updated_at`) VALUES
(1, 'adminlestari', '2021-09-04', '10:33:44', 'Tambah item BRS-001', 'OPN', '2021-09-04 03:33:44', '2021-09-04 03:33:44'),
(2, 'adminlestari', '2021-09-04', '10:34:34', 'Tambah item BRS-002', 'OPN', '2021-09-04 03:34:34', '2021-09-04 03:34:34'),
(3, 'adminlestari', '2021-09-04', '10:35:21', 'Tambah item BRS-003', 'OPN', '2021-09-04 03:35:21', '2021-09-04 03:35:21'),
(4, 'adminlestari', '2021-09-04', '10:36:05', 'Tambah item BRS-004', 'OPN', '2021-09-04 03:36:05', '2021-09-04 03:36:05'),
(5, 'adminlestari', '2021-09-04', '10:36:49', 'Tambah item BRS-005', 'OPN', '2021-09-04 03:36:49', '2021-09-04 03:36:49'),
(6, 'adminlestari', '2021-09-04', '10:37:34', 'Tambah item BRS-006', 'OPN', '2021-09-04 03:37:34', '2021-09-04 03:37:34'),
(7, 'adminlestari', '2021-09-04', '10:38:14', 'Tambah item BRS-007', 'OPN', '2021-09-04 03:38:14', '2021-09-04 03:38:14'),
(8, 'adminlestari', '2021-09-04', '10:38:51', 'Tambah item BRS-008', 'OPN', '2021-09-04 03:38:51', '2021-09-04 03:38:51'),
(9, 'adminlestari', '2021-09-04', '10:39:29', 'Tambah item BRS-009', 'OPN', '2021-09-04 03:39:29', '2021-09-04 03:39:29'),
(10, 'adminlestari', '2021-09-04', '10:40:05', 'Tambah item BRS-0010', 'OPN', '2021-09-04 03:40:05', '2021-09-04 03:40:05'),
(11, 'adminlestari', '2021-09-04', '10:40:41', 'Tambah item BRS-011', 'OPN', '2021-09-04 03:40:41', '2021-09-04 03:40:41'),
(12, 'adminlestari', '2021-09-04', '10:42:32', 'Tambah item GLA-001', 'OPN', '2021-09-04 03:42:32', '2021-09-04 03:42:32'),
(13, 'adminlestari', '2021-09-04', '10:44:16', 'Tambah item BWG-001', 'OPN', '2021-09-04 03:44:16', '2021-09-04 03:44:16'),
(14, 'adminlestari', '2021-09-04', '10:44:49', 'Tambah item BWG-002', 'OPN', '2021-09-04 03:44:49', '2021-09-04 03:44:49'),
(15, 'adminlestari', '2021-09-04', '10:46:04', 'Tambah item TPG-001', 'OPN', '2021-09-04 03:46:04', '2021-09-04 03:46:04'),
(16, 'adminlestari', '2021-09-04', '10:46:45', 'Tambah item TPG-002', 'OPN', '2021-09-04 03:46:45', '2021-09-04 03:46:45'),
(17, 'adminlestari', '2021-09-04', '10:47:27', 'Tambah item TPG-003', 'OPN', '2021-09-04 03:47:27', '2021-09-04 03:47:27'),
(18, 'adminlestari', '2021-09-04', '10:48:12', 'Update item BRS-001', 'OPN', '2021-09-04 03:48:12', '2021-09-04 03:48:12'),
(19, 'adminlestari', '2021-09-04', '11:15:09', 'Tambah pemesanan pembelian PO-021090003', 'OPN', '2021-09-04 04:15:09', '2021-09-04 04:15:09'),
(20, 'adminlestari', '2021-09-04', '11:15:16', 'Konfirmasi pemesanan pembelian PO-021090003', 'OPN', '2021-09-04 04:15:16', '2021-09-04 04:15:16'),
(21, 'adminlestari', '2021-09-04', '11:21:35', 'Update item BRS-003', 'OPN', '2021-09-04 04:21:35', '2021-09-04 04:21:35'),
(22, 'adminlestari', '2021-09-04', '11:25:24', 'Update pemesanan pembelian PO-021090003', 'OPN', '2021-09-04 04:25:24', '2021-09-04 04:25:24'),
(23, 'adminlestari', '2021-09-04', '11:25:36', 'Konfirmasi pemesanan pembelian PO-021090003', 'OPN', '2021-09-04 04:25:36', '2021-09-04 04:25:36'),
(24, 'adminlestari', '2021-09-04', '11:28:21', 'Buat penerimaan barang LPB-021090001', 'OPN', '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(25, 'adminlestari', '2021-09-04', '11:28:29', 'Konfirmasi penerimaan barang LPB-021090001', 'OPN', '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(26, 'adminlestari', '2021-09-04', '11:31:29', 'Tambah penjualan kasir KSR-21090001', 'OPN', '2021-09-04 04:31:29', '2021-09-04 04:31:29'),
(27, 'adminlestari', '2021-09-04', '11:36:44', 'Tambah penjualan kasir KSR-21090002', 'OPN', '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(28, 'adminlestari', '2021-09-04', '11:39:27', 'Tambah penjualan kasir KSR-21090003', 'OPN', '2021-09-04 04:39:27', '2021-09-04 04:39:27'),
(29, 'adminlestari', '2021-09-04', '11:47:00', 'Tambah penjualan kasir KSR-21090004', 'OPN', '2021-09-04 04:47:00', '2021-09-04 04:47:00'),
(30, 'adminlestari', '2021-09-04', '11:48:09', 'Tambah penjualan kasir KSR-21090005', 'OPN', '2021-09-04 04:48:09', '2021-09-04 04:48:09'),
(31, 'adminlestari', '2021-09-04', '11:51:29', 'Tambah penjualan kasir KSR-21090006', 'OPN', '2021-09-04 04:51:29', '2021-09-04 04:51:29'),
(32, 'adminlestari', '2021-09-04', '11:52:57', 'Tambah penjualan kasir KSR-21090007', 'OPN', '2021-09-04 04:52:57', '2021-09-04 04:52:57'),
(33, 'adminlestari', '2021-09-04', '11:53:48', 'Tambah penjualan kasir KSR-21090008', 'OPN', '2021-09-04 04:53:48', '2021-09-04 04:53:48'),
(34, 'adminlestari', '2021-09-04', '11:54:42', 'Tambah penjualan kasir KSR-21090009', 'OPN', '2021-09-04 04:54:42', '2021-09-04 04:54:42'),
(35, 'adminlestari', '2021-09-04', '11:57:34', 'Tambah penjualan kasir KSR-21090010', 'OPN', '2021-09-04 04:57:34', '2021-09-04 04:57:34'),
(36, 'adminlestari', '2021-09-04', '11:58:31', 'Tambah penjualan kasir KSR-21090011', 'OPN', '2021-09-04 04:58:31', '2021-09-04 04:58:31'),
(37, 'adminlestari', '2021-09-04', '12:00:24', 'Tambah penjualan kasir KSR-21090012', 'OPN', '2021-09-04 05:00:24', '2021-09-04 05:00:24'),
(38, 'adminlestari', '2021-09-04', '12:01:31', 'Tambah penjualan kasir KSR-21090013', 'OPN', '2021-09-04 05:01:31', '2021-09-04 05:01:31'),
(39, 'adminlestari', '2021-09-04', '12:02:39', 'Tambah penjualan kasir KSR-21090014', 'OPN', '2021-09-04 05:02:39', '2021-09-04 05:02:39'),
(40, 'adminlestari', '2021-09-04', '12:03:42', 'Tambah penjualan kasir KSR-21090015', 'OPN', '2021-09-04 05:03:42', '2021-09-04 05:03:42'),
(41, 'adminlestari', '2021-09-04', '12:05:25', 'Tambah penjualan kasir KSR-21090016', 'OPN', '2021-09-04 05:05:25', '2021-09-04 05:05:25'),
(42, 'adminlestari', '2021-09-04', '12:07:08', 'Tambah penjualan kasir KSR-21090017', 'OPN', '2021-09-04 05:07:08', '2021-09-04 05:07:08'),
(43, 'adminlestari', '2021-09-04', '12:08:03', 'Tambah penjualan kasir KSR-21090018', 'OPN', '2021-09-04 05:08:03', '2021-09-04 05:08:03'),
(44, 'adminlestari', '2021-09-04', '12:08:41', 'Tambah penjualan kasir KSR-21090019', 'OPN', '2021-09-04 05:08:41', '2021-09-04 05:08:41'),
(45, 'adminlestari', '2021-09-04', '12:10:42', 'Tambah penjualan kasir KSR-21090020', 'OPN', '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(46, 'adminlestari', '2021-09-04', '12:11:29', 'Tambah penjualan kasir KSR-21090021', 'OPN', '2021-09-04 05:11:29', '2021-09-04 05:11:29'),
(47, 'adminlestari', '2021-09-04', '12:12:12', 'Tambah penjualan kasir KSR-21090022', 'OPN', '2021-09-04 05:12:12', '2021-09-04 05:12:12'),
(48, 'adminlestari', '2021-09-04', '12:13:03', 'Tambah penjualan kasir KSR-21090023', 'OPN', '2021-09-04 05:13:03', '2021-09-04 05:13:03'),
(49, 'adminlestari', '2021-09-04', '12:14:48', 'Tambah penjualan kasir KSR-21090024', 'OPN', '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(50, 'adminlestari', '2021-09-04', '12:15:49', 'Tambah penjualan kasir KSR-21090025', 'OPN', '2021-09-04 05:15:49', '2021-09-04 05:15:49'),
(51, 'adminlestari', '2021-09-04', '12:17:03', 'Tambah penjualan kasir KSR-21090026', 'OPN', '2021-09-04 05:17:03', '2021-09-04 05:17:03'),
(52, 'adminlestari', '2021-09-04', '12:19:30', 'Tambah penjualan kasir KSR-21090027', 'OPN', '2021-09-04 05:19:30', '2021-09-04 05:19:30'),
(53, 'adminlestari', '2021-09-04', '12:20:46', 'Tambah penjualan kasir KSR-21090028', 'OPN', '2021-09-04 05:20:46', '2021-09-04 05:20:46'),
(54, 'adminlestari', '2021-09-04', '12:21:38', 'Tambah penjualan kasir KSR-21090029', 'OPN', '2021-09-04 05:21:38', '2021-09-04 05:21:38'),
(55, 'adminlestari', '2021-09-04', '12:24:33', 'Tambah penjualan kasir KSR-21090030', 'OPN', '2021-09-04 05:24:33', '2021-09-04 05:24:33'),
(56, 'adminlestari', '2021-09-04', '12:28:08', 'Tambah penjualan kasir KSR-21090031', 'OPN', '2021-09-04 05:28:08', '2021-09-04 05:28:08'),
(57, 'adminlestari', '2021-09-04', '12:29:17', 'Tambah penjualan kasir KSR-21090032', 'OPN', '2021-09-04 05:29:17', '2021-09-04 05:29:17'),
(58, 'adminlestari', '2021-09-04', '12:30:20', 'Tambah penjualan kasir KSR-21090033', 'OPN', '2021-09-04 05:30:20', '2021-09-04 05:30:20'),
(59, 'adminlestari', '2021-09-04', '12:31:18', 'Tambah penjualan kasir KSR-21090034', 'OPN', '2021-09-04 05:31:18', '2021-09-04 05:31:18'),
(60, 'adminlestari', '2021-09-04', '12:32:15', 'Tambah penjualan kasir KSR-21090035', 'OPN', '2021-09-04 05:32:15', '2021-09-04 05:32:15'),
(61, 'adminlestari', '2021-09-04', '12:33:16', 'Tambah penjualan kasir KSR-21090036', 'OPN', '2021-09-04 05:33:16', '2021-09-04 05:33:16'),
(62, 'adminlestari', '2021-09-04', '12:34:36', 'Tambah penjualan kasir KSR-21090037', 'OPN', '2021-09-04 05:34:36', '2021-09-04 05:34:36'),
(63, 'adminlestari', '2021-09-04', '12:35:55', 'Tambah penjualan kasir KSR-21090038', 'OPN', '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(64, 'adminlestari', '2021-09-04', '12:36:35', 'Tambah penjualan kasir KSR-21090039', 'OPN', '2021-09-04 05:36:35', '2021-09-04 05:36:35'),
(65, 'adminlestari', '2021-09-04', '12:37:10', 'Tambah penjualan kasir KSR-21090040', 'OPN', '2021-09-04 05:37:10', '2021-09-04 05:37:10'),
(66, 'adminlestari', '2021-09-04', '12:38:06', 'Tambah penjualan kasir KSR-21090041', 'OPN', '2021-09-04 05:38:06', '2021-09-04 05:38:06'),
(67, 'adminlestari', '2021-09-04', '12:40:27', 'Tambah penjualan kasir KSR-21090042', 'OPN', '2021-09-04 05:40:27', '2021-09-04 05:40:27'),
(68, 'adminlestari', '2021-09-04', '13:26:04', 'Tambah return penerimaan barang RPB-021090001', 'OPN', '2021-09-04 06:26:04', '2021-09-04 06:26:04'),
(69, 'adminlestari', '2021-09-04', '13:27:39', 'Tambah return penerimaan barang RPB-021090002', 'OPN', '2021-09-04 06:27:39', '2021-09-04 06:27:39'),
(70, 'adminlestari', '2021-09-04', '13:31:32', 'Tambah return penerimaan barang RPB-021090001', 'OPN', '2021-09-04 06:31:32', '2021-09-04 06:31:32'),
(71, 'adminlestari', '2021-09-04', '13:32:36', 'Konfirmasi return penerimaan barang RPB-021090001', 'OPN', '2021-09-04 06:32:36', '2021-09-04 06:32:36'),
(72, 'adminlestari', '2021-09-04', '13:35:51', 'Tambah return penerimaan barang RPB-021090002', 'OPN', '2021-09-04 06:35:51', '2021-09-04 06:35:51'),
(73, 'adminlestari', '2021-09-04', '13:36:19', 'Konfirmasi return penerimaan barang RPB-021090002', 'OPN', '2021-09-04 06:36:19', '2021-09-04 06:36:19'),
(74, 'adminlestari', '2021-09-04', '13:40:53', 'Tambah stok masuk SLM-21090001', 'OPN', '2021-09-04 06:40:53', '2021-09-04 06:40:53'),
(75, 'adminlestari', '2021-09-04', '13:46:10', 'Tambah stok keluar SLK-21090001', 'OPN', '2021-09-04 06:46:10', '2021-09-04 06:46:10'),
(76, 'adminlestari', '2021-09-04', '13:49:35', 'Update item BRS-001', 'OPN', '2021-09-04 06:49:35', '2021-09-04 06:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `gajians`
--

CREATE TABLE `gajians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodeGaji` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalGaji` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalLemburHarian` varchar(10) NOT NULL,
  `SubtotalLemburJam` varchar(10) NOT NULL,
  `SubtotalLemburMinggu` varchar(10) NOT NULL,
  `SubtotalBonus` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalHargaBarang` varchar(10) NOT NULL,
  `TotalGaji` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalGaji` date NOT NULL,
  `Status` varchar(10) NOT NULL,
  `EnkripsiKodeGaji` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `golongans`
--

CREATE TABLE `golongans` (
  `KodeGolongan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaGolongan` varchar(191) NOT NULL,
  `UangHadir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LemburHarian` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LemburMinggu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `golongans`
--

INSERT INTO `golongans` (`KodeGolongan`, `NamaGolongan`, `UangHadir`, `LemburHarian`, `LemburMinggu`, `Status`, `created_at`, `updated_at`) VALUES
('GOL-01', 'Karyawan', '0', '0', '0', 'OPN', '2021-04-22 04:17:57', '2021-04-22 05:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `historihargarata`
--

CREATE TABLE `historihargarata` (
  `Tanggal` datetime NOT NULL,
  `KodeItem` varchar(50) NOT NULL,
  `HargaRata` double NOT NULL,
  `KodeTransaksi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hutangs`
--

CREATE TABLE `hutangs` (
  `KodeHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` datetime NOT NULL,
  `KodeSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLPB` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Invoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jumlah` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Term` double NOT NULL,
  `Koreksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kembali` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `InvoiceSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalInvoiceSupplier` date NOT NULL,
  `hutangcol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicehutangdetails`
--

CREATE TABLE `invoicehutangdetails` (
  `id` int(191) NOT NULL,
  `KodeHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLPB` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Subtotal` double NOT NULL,
  `TotalReturn` double NOT NULL DEFAULT 0,
  `KodeInvoiceHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoicehutangdetails`
--

INSERT INTO `invoicehutangdetails` (`id`, `KodeHutang`, `KodeLPB`, `Subtotal`, `TotalReturn`, `KodeInvoiceHutang`, `created_at`, `updated_at`) VALUES
(1, 'IVH-021090001', 'LPB-021090001', 23790600, 2079000, '1', '2021-09-04 04:28:29', '2021-09-04 06:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `invoicehutangs`
--

CREATE TABLE `invoicehutangs` (
  `KodeInvoiceHutang` int(11) NOT NULL,
  `KodeInvoiceHutangShow` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Term` double DEFAULT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoicehutangs`
--

INSERT INTO `invoicehutangs` (`KodeInvoiceHutang`, `KodeInvoiceHutangShow`, `Tanggal`, `KodeSupplier`, `Status`, `Total`, `Keterangan`, `NoFaktur`, `KodeMataUang`, `KodeUser`, `Term`, `KodeLokasi`, `created_at`, `updated_at`) VALUES
(1, 'IVH-021090001', '2021-09-04', 'SUP-001', 'OPN', 23790600, '-', NULL, 'Rp', 'adminlestari', 30, 'GUD-001', '2021-09-04 04:28:29', '2021-09-04 04:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `invoicepiutangdetails`
--

CREATE TABLE `invoicepiutangdetails` (
  `KodePiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Subtotal` double NOT NULL,
  `TotalReturn` double NOT NULL DEFAULT 0,
  `KodeInvoicePiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicepiutangs`
--

CREATE TABLE `invoicepiutangs` (
  `KodeInvoicePiutang` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Term` double DEFAULT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KodeInvoicePiutangShow` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invopnames`
--

CREATE TABLE `invopnames` (
  `Tanggal` datetime NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtyOPN` double NOT NULL,
  `qtyIN` double NOT NULL,
  `qtyOUT` double NOT NULL,
  `qtyInHand` double NOT NULL,
  `qtyOpname` double NOT NULL,
  `qtyBlc` double NOT NULL,
  `HargaRata` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemkonversis`
--

CREATE TABLE `itemkonversis` (
  `id` int(11) NOT NULL,
  `KodeItem` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Konversi` double NOT NULL,
  `HargaBeli` double NOT NULL,
  `HargaJual` double NOT NULL,
  `HargaGrosir` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `itemkonversis`
--

INSERT INTO `itemkonversis` (`id`, `KodeItem`, `KodeSatuan`, `Konversi`, `HargaBeli`, `HargaJual`, `HargaGrosir`, `created_at`, `updated_at`) VALUES
(0, 'BRS-001', 'sak', 1, 236000, 238000, 237500, '2021-09-04 03:33:44', '2021-09-04 06:49:35'),
(0, 'BRS-002', 'sak', 1, 214000, 215000, 215000, '2021-09-04 03:34:34', '2021-09-04 03:34:34'),
(0, 'BRS-003', 'sak', 1, 234000, 235000, 235000, '2021-09-04 03:35:21', '2021-09-04 04:21:35'),
(0, 'BRS-004', 'sak', 1, 225000, 230000, 230000, '2021-09-04 03:36:05', '2021-09-04 03:36:05'),
(0, 'BRS-005', 'sak', 1, 212000, 212500, 212500, '2021-09-04 03:36:49', '2021-09-04 03:36:49'),
(0, 'BRS-006', 'sak', 1, 217000, 217500, 217500, '2021-09-04 03:37:34', '2021-09-04 03:37:34'),
(0, 'BRS-007', 'sak', 1, 212000, 212500, 212500, '2021-09-04 03:38:14', '2021-09-04 03:38:14'),
(0, 'BRS-008', 'sak', 1, 87000, 88000, 88000, '2021-09-04 03:38:51', '2021-09-04 03:38:51'),
(0, 'BRS-009', 'sak', 1, 44000, 44500, 44500, '2021-09-04 03:39:29', '2021-09-04 03:39:29'),
(0, 'BRS-0010', 'sak', 1, 47000, 48000, 48000, '2021-09-04 03:40:05', '2021-09-04 03:40:05'),
(0, 'BRS-011', 'sak', 1, 46000, 46500, 46500, '2021-09-04 03:40:41', '2021-09-04 03:40:41'),
(0, 'GLA-001', 'sak', 1, 538000, 539000, 539000, '2021-09-04 03:42:32', '2021-09-04 03:42:32'),
(0, 'BWG-001', 'kg', 1, 19500, 20000, 20000, '2021-09-04 03:44:16', '2021-09-04 03:44:16'),
(0, 'BWG-002', 'kg', 1, 17000, 18000, 18000, '2021-09-04 03:44:49', '2021-09-04 03:44:49'),
(0, 'TPG-001', 'sak', 1, 178000, 178500, 178500, '2021-09-04 03:46:04', '2021-09-04 03:46:04'),
(0, 'TPG-002', 'sak', 1, 153000, 154000, 154000, '2021-09-04 03:46:45', '2021-09-04 03:46:45'),
(0, 'TPG-003', 'sak', 1, 182000, 183000, 183000, '2021-09-04 03:47:27', '2021-09-04 03:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `KodeItem` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `KodeKategori` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NamaItem` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Alias` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `jenisitem` enum('bahanbaku','bahanjadi') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `KodeUser` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`KodeItem`, `KodeKategori`, `NamaItem`, `Alias`, `jenisitem`, `Keterangan`, `Status`, `KodeUser`, `created_at`, `updated_at`) VALUES
('BRS-001', 'KLA-003', 'menco 25Kg', 'menco  25Kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:33:44', '2021-09-04 06:49:35'),
('BRS-002', 'KLA-003', 'anak gunung 25 kg', 'anak gunung 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:34:34', '2021-09-04 03:34:34'),
('BRS-003', 'KLA-003', 'ladang padi 25 kg', 'ladang padi 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:35:21', '2021-09-04 04:21:35'),
('BRS-004', 'KLA-003', 'naga 25 kg', 'naga 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:36:05', '2021-09-04 03:36:05'),
('BRS-005', 'KLA-003', 'pelangi 25 kg', 'pelangi 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:36:49', '2021-09-04 03:36:49'),
('BRS-006', 'KLA-003', 'lele 25 kg', 'lele 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:37:34', '2021-09-04 03:37:34'),
('BRS-007', 'KLA-003', 'keluarga 25 kg', 'keluarga 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:38:14', '2021-09-04 03:38:14'),
('BRS-008', 'KLA-003', 'anak gunung 10 kg', 'anak gunung 10 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:38:51', '2021-09-04 03:38:51'),
('BRS-009', 'KLA-003', 'anak gunung 5 kg', 'anak gunung 5 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:39:29', '2021-09-04 03:39:29'),
('BRS-0010', 'KLA-003', 'ladang padi 5 kg', 'ladang padi 5 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:40:05', '2021-09-04 03:40:05'),
('BRS-011', 'KLA-003', 'naga 5 kg', 'naga 5 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:40:41', '2021-09-04 03:40:41'),
('GLA-001', 'KLA-005', 'KBA 50 kg', 'KBA 50 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:42:32', '2021-09-04 03:42:32'),
('BWG-001', 'KLA-007', 'kating', 'kating', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:44:16', '2021-09-04 03:44:16'),
('BWG-002', 'KLA-007', 'sinco', 'sinco', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:44:49', '2021-09-04 03:44:49'),
('TPG-001', 'KLA-004', 'Tepung segitiga 25 kg', 'Tepung segitiga 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:46:04', '2021-09-04 03:46:04'),
('TPG-002', 'KLA-004', 'Tepung canting 25 kg', 'Tepung canting 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:46:45', '2021-09-04 03:46:45'),
('TPG-003', 'KLA-004', 'Tepung cakra 25 kg', 'Tepung cakra 25 kg', 'bahanjadi', '-', 'OPN', 'adminlestari', '2021-09-04 03:47:27', '2021-09-04 03:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `jabatans`
--

CREATE TABLE `jabatans` (
  `id` int(10) UNSIGNED NOT NULL,
  `KodeJabatan` varchar(191) NOT NULL,
  `KeteranganJabatan` varchar(191) NOT NULL,
  `Status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatans`
--

INSERT INTO `jabatans` (`id`, `KodeJabatan`, `KeteranganJabatan`, `Status`, `created_at`, `updated_at`) VALUES
(1, 'Sales', 'Sales', 'OPN', '2021-04-22 05:11:27', '2021-04-22 05:11:27'),
(2, 'Driver', 'Driver', 'OPN', '2021-04-22 05:11:34', '2021-04-22 05:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `jenisbayars`
--

CREATE TABLE `jenisbayars` (
  `KodeJenisBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JenisBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` int(10) UNSIGNED NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kota` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telepon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JenisKelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GajiPokok` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeJabatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeGolongan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawans`
--

INSERT INTO `karyawans` (`id`, `KodeKaryawan`, `Nama`, `Alamat`, `Kota`, `Telepon`, `JenisKelamin`, `KodeUser`, `Status`, `GajiPokok`, `KodeJabatan`, `KodeGolongan`, `created_at`, `updated_at`) VALUES
(1, 'KAR-001', 'Yono', '-', 'Malang', '082245497019', 'Laki-laki', 'admin', 'OPN', '0', 'Driver', 'GOL-01', '2021-04-22 05:40:52', '2021-04-22 05:40:52'),
(2, 'KAR-002', 'NN', '-', 'Malang', '085234006574', 'Perempuan', 'admin', 'OPN', '0', 'Sales', 'GOL-01', '2021-04-22 05:41:09', '2021-04-22 05:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `kasbanks`
--

CREATE TABLE `kasbanks` (
  `KodeKasBank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalCheque` date NOT NULL,
  `KodeBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipeBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoLink` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BayarDari` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Untuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeInvoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KodeKasBankID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kasbanks`
--

INSERT INTO `kasbanks` (`KodeKasBank`, `Tanggal`, `Status`, `TanggalCheque`, `KodeBayar`, `TipeBayar`, `NoLink`, `BayarDari`, `Untuk`, `KodeInvoice`, `Keterangan`, `KodeUser`, `Tipe`, `Total`, `created_at`, `updated_at`, `KodeKasBankID`) VALUES
('KM-21090001', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090001', '-', 'adminlestari', 'KS', 435000, '2021-09-04 04:31:29', '2021-09-04 04:31:29', 1),
('KM-21090002', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090002', '-', 'adminlestari', 'KS', 871500, '2021-09-04 04:36:44', '2021-09-04 04:36:44', 2),
('KM-21090003', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090003', '-', 'adminlestari', 'KS', 235000, '2021-09-04 04:39:27', '2021-09-04 04:39:27', 3),
('KM-21090004', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090004', '-', 'adminlestari', 'KS', 361500, '2021-09-04 04:47:00', '2021-09-04 04:47:00', 4),
('KM-21090005', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090005', '-', 'adminlestari', 'KS', 215000, '2021-09-04 04:48:09', '2021-09-04 04:48:09', 5),
('KM-21090006', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-001', 'KSR-21090006', '-', 'adminlestari', 'KS', 336600, '2021-09-04 04:51:29', '2021-09-04 04:51:29', 6),
('KM-21090007', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090007', '-', 'adminlestari', 'KS', 1409000, '2021-09-04 04:52:57', '2021-09-04 04:52:57', 7),
('KM-21090008', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090008', '-', 'adminlestari', 'KS', 46500, '2021-09-04 04:53:48', '2021-09-04 04:53:48', 8),
('KM-21090009', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090009', '-', 'adminlestari', 'KS', 88000, '2021-09-04 04:54:42', '2021-09-04 04:54:42', 9),
('KM-21090010', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090010', '-', 'adminlestari', 'KS', 1313000, '2021-09-04 04:57:34', '2021-09-04 04:57:34', 10),
('KM-21090011', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090011', '-', 'adminlestari', 'KS', 215000, '2021-09-04 04:58:31', '2021-09-04 04:58:31', 11),
('KM-21090012', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090012', '-', 'adminlestari', 'KS', 356000, '2021-09-04 05:00:24', '2021-09-04 05:00:24', 12),
('KM-21090013', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090013', '-', 'adminlestari', 'KS', 539000, '2021-09-04 05:01:31', '2021-09-04 05:01:31', 13),
('KM-21090014', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090014', '-', 'adminlestari', 'KS', 215000, '2021-09-04 05:02:39', '2021-09-04 05:02:39', 14),
('KM-21090015', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090015', '-', 'adminlestari', 'KS', 741000, '2021-09-04 05:03:42', '2021-09-04 05:03:42', 15),
('KM-21090016', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090016', '-', 'adminlestari', 'KS', 352080, '2021-09-04 05:05:25', '2021-09-04 05:05:25', 16),
('KM-21090017', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090017', '-', 'adminlestari', 'KS', 337500, '2021-09-04 05:07:08', '2021-09-04 05:07:08', 17),
('KM-21090018', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090018', '-', 'adminlestari', 'KS', 1425000, '2021-09-04 05:08:03', '2021-09-04 05:08:03', 18),
('KM-21090019', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090019', '-', 'adminlestari', 'KS', 215000, '2021-09-04 05:08:41', '2021-09-04 05:08:41', 19),
('KM-21090020', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090020', '-', 'adminlestari', 'KS', 1103140, '2021-09-04 05:10:42', '2021-09-04 05:10:42', 20),
('KM-21090021', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090021', '-', 'adminlestari', 'KS', 215000, '2021-09-04 05:11:29', '2021-09-04 05:11:29', 21),
('KM-21090022', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090022', '-', 'adminlestari', 'KS', 235000, '2021-09-04 05:12:12', '2021-09-04 05:12:12', 22),
('KM-21090023', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090023', '-', 'adminlestari', 'KS', 425000, '2021-09-04 05:13:03', '2021-09-04 05:13:03', 23),
('KM-21090024', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090024', '-', 'adminlestari', 'KS', 3480000, '2021-09-04 05:14:48', '2021-09-04 05:14:48', 24),
('KM-21090025', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090025', '-', 'adminlestari', 'KS', 1062500, '2021-09-04 05:15:49', '2021-09-04 05:15:49', 25),
('KM-21090026', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090026', '-', 'adminlestari', 'KS', 445000, '2021-09-04 05:17:03', '2021-09-04 05:17:03', 26),
('KM-21090027', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090027', '-', 'adminlestari', 'KS', 337140, '2021-09-04 05:19:30', '2021-09-04 05:19:30', 27),
('KM-21090028', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090028', '-', 'adminlestari', 'KS', 338580, '2021-09-04 05:20:46', '2021-09-04 05:20:46', 28),
('KM-21090029', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090029', '-', 'adminlestari', 'KS', 480000, '2021-09-04 05:21:38', '2021-09-04 05:21:38', 29),
('KM-21090030', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090030', '-', 'adminlestari', 'KS', 237500, '2021-09-04 05:24:33', '2021-09-04 05:24:33', 30),
('KM-21090031', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090031', '-', 'adminlestari', 'KS', 196350, '2021-09-04 05:28:08', '2021-09-04 05:28:08', 31),
('KM-21090032', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090032', '-', 'adminlestari', 'KS', 539000, '2021-09-04 05:29:17', '2021-09-04 05:29:17', 32),
('KM-21090033', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090033', '-', 'adminlestari', 'KS', 215000, '2021-09-04 05:30:20', '2021-09-04 05:30:20', 33),
('KM-21090034', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090034', '-', 'adminlestari', 'KS', 748000, '2021-09-04 05:31:18', '2021-09-04 05:31:18', 34),
('KM-21090035', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090035', '-', 'adminlestari', 'KS', 337140, '2021-09-04 05:32:15', '2021-09-04 05:32:15', 35),
('KM-21090036', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090036', '-', 'adminlestari', 'KS', 230000, '2021-09-04 05:33:16', '2021-09-04 05:33:16', 36),
('KM-21090037', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090037', '-', 'adminlestari', 'KS', 416000, '2021-09-04 05:34:36', '2021-09-04 05:34:36', 37),
('KM-21090038', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090038', '-', 'adminlestari', 'KS', 604000, '2021-09-04 05:35:55', '2021-09-04 05:35:55', 38),
('KM-21090039', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090039', '-', 'adminlestari', 'KS', 430000, '2021-09-04 05:36:35', '2021-09-04 05:36:35', 39),
('KM-21090040', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090040', '-', 'adminlestari', 'KS', 215000, '2021-09-04 05:37:10', '2021-09-04 05:37:10', 40),
('KM-21090041', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090041', '-', 'adminlestari', 'KS', 235000, '2021-09-04 05:38:06', '2021-09-04 05:38:06', 41),
('KM-21090042', '2021-08-30', 'CFM', '2021-08-30', 'Cash', '', '', '', 'PLG-002', 'KSR-21090042', '-', 'adminlestari', 'KS', 539000, '2021-09-04 05:40:27', '2021-09-04 05:40:27', 42);

-- --------------------------------------------------------

--
-- Table structure for table `kasirdetails`
--

CREATE TABLE `kasirdetails` (
  `id` int(11) NOT NULL,
  `KodeKasir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `HargaRata` double NOT NULL,
  `KodeSatuan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kasirdetails`
--

INSERT INTO `kasirdetails` (`id`, `KodeKasir`, `KodeItem`, `Qty`, `Harga`, `HargaRata`, `KodeSatuan`, `NoUrut`, `Subtotal`, `created_at`, `updated_at`) VALUES
(0, 'KSR-21090001', 'BRS-006', 2, 217500, 217500, 'sak', 1, 435000, '2021-09-04 04:31:29', '2021-09-04 04:31:29'),
(0, 'KSR-21090002', 'GLA-001', 1, 539000, 539000, 'sak', 1, 539000, '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(0, 'KSR-21090002', 'TPG-001', 1, 178500, 178500, 'sak', 2, 178500, '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(0, 'KSR-21090002', 'TPG-002', 1, 154000, 154000, 'sak', 3, 154000, '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(0, 'KSR-21090003', 'BRS-003', 1, 235000, 235000, 'sak', 1, 235000, '2021-09-04 04:39:27', '2021-09-04 04:39:27'),
(0, 'KSR-21090004', 'TPG-003', 1, 183000, 183000, 'sak', 1, 183000, '2021-09-04 04:47:00', '2021-09-04 04:47:00'),
(0, 'KSR-21090004', 'TPG-001', 1, 178500, 178500, 'sak', 2, 178500, '2021-09-04 04:47:00', '2021-09-04 04:47:00'),
(0, 'KSR-21090005', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 04:48:09', '2021-09-04 04:48:09'),
(0, 'KSR-21090006', 'BWG-002', 18.7, 18000, 18000, 'kg', 1, 336600, '2021-09-04 04:51:29', '2021-09-04 04:51:29'),
(0, 'KSR-21090007', 'BRS-006', 4, 217500, 217500, 'sak', 1, 870000, '2021-09-04 04:52:57', '2021-09-04 04:52:57'),
(0, 'KSR-21090007', 'GLA-001', 1, 539000, 539000, 'sak', 2, 539000, '2021-09-04 04:52:57', '2021-09-04 04:52:57'),
(0, 'KSR-21090008', 'BRS-011', 1, 46500, 46500, 'sak', 1, 46500, '2021-09-04 04:53:48', '2021-09-04 04:53:48'),
(0, 'KSR-21090009', 'BRS-008', 1, 88000, 88000, 'sak', 1, 88000, '2021-09-04 04:54:42', '2021-09-04 04:54:42'),
(0, 'KSR-21090010', 'GLA-001', 2, 539000, 539000, 'sak', 1, 1078000, '2021-09-04 04:57:34', '2021-09-04 04:57:34'),
(0, 'KSR-21090010', 'BRS-003', 1, 235000, 235000, 'sak', 2, 235000, '2021-09-04 04:57:34', '2021-09-04 04:57:34'),
(0, 'KSR-21090011', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 04:58:31', '2021-09-04 04:58:31'),
(0, 'KSR-21090012', 'BRS-009', 8, 44500, 44500, 'sak', 1, 356000, '2021-09-04 05:00:24', '2021-09-04 05:00:24'),
(0, 'KSR-21090013', 'GLA-001', 1, 539000, 539000, 'sak', 1, 539000, '2021-09-04 05:01:31', '2021-09-04 05:01:31'),
(0, 'KSR-21090014', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 05:02:39', '2021-09-04 05:02:39'),
(0, 'KSR-21090015', 'BWG-001', 19.5, 20000, 20000, 'kg', 1, 390000, '2021-09-04 05:03:42', '2021-09-04 05:03:42'),
(0, 'KSR-21090015', 'BWG-002', 19.5, 18000, 18000, 'kg', 2, 351000, '2021-09-04 05:03:42', '2021-09-04 05:03:42'),
(0, 'KSR-21090016', 'BWG-002', 19.56, 18000, 18000, 'kg', 1, 352080, '2021-09-04 05:05:24', '2021-09-04 05:05:24'),
(0, 'KSR-21090017', 'BWG-002', 18.75, 18000, 18000, 'kg', 1, 337500, '2021-09-04 05:07:08', '2021-09-04 05:07:08'),
(0, 'KSR-21090018', 'BRS-001', 6, 237500, 237500, 'sak', 1, 1425000, '2021-09-04 05:08:03', '2021-09-04 05:08:03'),
(0, 'KSR-21090019', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 05:08:41', '2021-09-04 05:08:41'),
(0, 'KSR-21090020', 'BWG-002', 18.98, 18000, 18000, 'kg', 1, 341640, '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(0, 'KSR-21090020', 'GLA-001', 1, 539000, 539000, 'sak', 2, 539000, '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(0, 'KSR-21090020', 'BRS-009', 5, 44500, 44500, 'sak', 3, 222500, '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(0, 'KSR-21090021', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 05:11:29', '2021-09-04 05:11:29'),
(0, 'KSR-21090022', 'BRS-003', 1, 235000, 235000, 'sak', 1, 235000, '2021-09-04 05:12:12', '2021-09-04 05:12:12'),
(0, 'KSR-21090023', 'BRS-005', 2, 212500, 212500, 'sak', 1, 425000, '2021-09-04 05:13:03', '2021-09-04 05:13:03'),
(0, 'KSR-21090024', 'BRS-006', 10, 217500, 217500, 'sak', 1, 2175000, '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(0, 'KSR-21090024', 'BRS-002', 4, 215000, 215000, 'sak', 2, 860000, '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(0, 'KSR-21090024', 'BRS-009', 10, 44500, 44500, 'sak', 3, 445000, '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(0, 'KSR-21090025', 'BRS-007', 5, 212500, 212500, 'sak', 1, 1062500, '2021-09-04 05:15:49', '2021-09-04 05:15:49'),
(0, 'KSR-21090026', 'BRS-009', 10, 44500, 44500, 'sak', 1, 445000, '2021-09-04 05:17:03', '2021-09-04 05:17:03'),
(0, 'KSR-21090027', 'BWG-002', 18.73, 18000, 18000, 'kg', 1, 337140, '2021-09-04 05:19:30', '2021-09-04 05:19:30'),
(0, 'KSR-21090028', 'BWG-002', 18.81, 18000, 18000, 'kg', 1, 338580, '2021-09-04 05:20:46', '2021-09-04 05:20:46'),
(0, 'KSR-21090029', 'BRS-0010', 10, 48000, 48000, 'sak', 1, 480000, '2021-09-04 05:21:38', '2021-09-04 05:21:38'),
(0, 'KSR-21090030', 'BRS-001', 1, 237500, 237500, 'sak', 1, 237500, '2021-09-04 05:24:33', '2021-09-04 05:24:33'),
(0, 'KSR-21090031', 'TPG-001', 1, 178500, 178500, 'sak', 1, 178500, '2021-09-04 05:28:08', '2021-09-04 05:28:08'),
(0, 'KSR-21090032', 'GLA-001', 1, 539000, 539000, 'sak', 1, 539000, '2021-09-04 05:29:17', '2021-09-04 05:29:17'),
(0, 'KSR-21090033', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 05:30:20', '2021-09-04 05:30:20'),
(0, 'KSR-21090034', 'BWG-001', 37.4, 20000, 20000, 'kg', 1, 748000, '2021-09-04 05:31:18', '2021-09-04 05:31:18'),
(0, 'KSR-21090035', 'BWG-002', 18.73, 18000, 18000, 'kg', 1, 337140, '2021-09-04 05:32:15', '2021-09-04 05:32:15'),
(0, 'KSR-21090036', 'BRS-004', 1, 230000, 230000, 'sak', 1, 230000, '2021-09-04 05:33:16', '2021-09-04 05:33:16'),
(0, 'KSR-21090037', 'BRS-001', 1, 237500, 237500, 'sak', 1, 237500, '2021-09-04 05:34:36', '2021-09-04 05:34:36'),
(0, 'KSR-21090037', 'TPG-001', 1, 178500, 178500, 'sak', 2, 178500, '2021-09-04 05:34:36', '2021-09-04 05:34:36'),
(0, 'KSR-21090038', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(0, 'KSR-21090038', 'BRS-003', 1, 235000, 235000, 'sak', 2, 235000, '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(0, 'KSR-21090038', 'TPG-002', 1, 154000, 154000, 'sak', 3, 154000, '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(0, 'KSR-21090039', 'BRS-002', 2, 215000, 215000, 'sak', 1, 430000, '2021-09-04 05:36:35', '2021-09-04 05:36:35'),
(0, 'KSR-21090040', 'BRS-002', 1, 215000, 215000, 'sak', 1, 215000, '2021-09-04 05:37:10', '2021-09-04 05:37:10'),
(0, 'KSR-21090041', 'BRS-003', 1, 235000, 235000, 'sak', 1, 235000, '2021-09-04 05:38:06', '2021-09-04 05:38:06'),
(0, 'KSR-21090042', 'GLA-001', 1, 539000, 539000, 'sak', 1, 539000, '2021-09-04 05:40:27', '2021-09-04 05:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `kasirreturndetails`
--

CREATE TABLE `kasirreturndetails` (
  `id` int(11) NOT NULL,
  `KodeKasirReturn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKasir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Harga` double NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kasirreturns`
--

CREATE TABLE `kasirreturns` (
  `id` int(11) NOT NULL,
  `KodeKasirReturn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKasir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPN` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `Total` double NOT NULL,
  `Printed` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kasirs`
--

CREATE TABLE `kasirs` (
  `id` int(11) NOT NULL,
  `KodeKasir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodePelanggan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kasirs`
--

INSERT INTO `kasirs` (`id`, `KodeKasir`, `Tanggal`, `KodeLokasi`, `KodeMataUang`, `Status`, `KodeUser`, `Total`, `PPN`, `NilaiPPN`, `Printed`, `Diskon`, `NilaiDiskon`, `Subtotal`, `KodePelanggan`, `Keterangan`, `created_at`, `updated_at`) VALUES
(0, 'KSR-21090001', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 435000, 'tidak', 0, 0, 0, 0, 435000, 'PLG-002', '-', '2021-09-04 04:31:29', '2021-09-04 04:31:29'),
(0, 'KSR-21090002', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 871500, 'tidak', 0, 0, 0, 0, 871500, 'PLG-002', '-', '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(0, 'KSR-21090003', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 235000, 'tidak', 0, 0, 0, 0, 235000, 'PLG-002', '-', '2021-09-04 04:39:27', '2021-09-04 04:39:27'),
(0, 'KSR-21090004', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 361500, 'tidak', 0, 0, 0, 0, 361500, 'PLG-002', '-', '2021-09-04 04:47:00', '2021-09-04 04:47:00'),
(0, 'KSR-21090005', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 04:48:09', '2021-09-04 04:48:09'),
(0, 'KSR-21090006', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 336600, 'tidak', 0, 0, 0, 0, 336600, 'PLG-001', '-', '2021-09-04 04:51:29', '2021-09-04 04:51:29'),
(0, 'KSR-21090007', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 1409000, 'tidak', 0, 0, 0, 0, 1409000, 'PLG-002', '-', '2021-09-04 04:52:57', '2021-09-04 04:52:57'),
(0, 'KSR-21090008', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 46500, 'tidak', 0, 0, 0, 0, 46500, 'PLG-002', '-', '2021-09-04 04:53:48', '2021-09-04 04:53:48'),
(0, 'KSR-21090009', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 88000, 'tidak', 0, 0, 0, 0, 88000, 'PLG-002', '-', '2021-09-04 04:54:42', '2021-09-04 04:54:42'),
(0, 'KSR-21090010', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 1313000, 'tidak', 0, 0, 0, 0, 1313000, 'PLG-002', '-', '2021-09-04 04:57:34', '2021-09-04 04:57:34'),
(0, 'KSR-21090011', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 04:58:31', '2021-09-04 04:58:31'),
(0, 'KSR-21090012', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 356000, 'tidak', 0, 0, 0, 0, 356000, 'PLG-002', '-', '2021-09-04 05:00:24', '2021-09-04 05:00:24'),
(0, 'KSR-21090013', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 539000, 'tidak', 0, 0, 0, 0, 539000, 'PLG-002', '-', '2021-09-04 05:01:31', '2021-09-04 05:01:31'),
(0, 'KSR-21090014', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 05:02:39', '2021-09-04 05:02:39'),
(0, 'KSR-21090015', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 741000, 'tidak', 0, 0, 0, 0, 741000, 'PLG-002', '-', '2021-09-04 05:03:42', '2021-09-04 05:03:42'),
(0, 'KSR-21090016', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 352080, 'tidak', 0, 0, 0, 0, 352080, 'PLG-002', '-', '2021-09-04 05:05:24', '2021-09-04 05:05:24'),
(0, 'KSR-21090017', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 337500, 'tidak', 0, 0, 0, 0, 337500, 'PLG-002', '-', '2021-09-04 05:07:08', '2021-09-04 05:07:08'),
(0, 'KSR-21090018', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 1425000, 'tidak', 0, 0, 0, 0, 1425000, 'PLG-002', '-', '2021-09-04 05:08:03', '2021-09-04 05:08:03'),
(0, 'KSR-21090019', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 05:08:41', '2021-09-04 05:08:41'),
(0, 'KSR-21090020', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 1103140, 'tidak', 0, 0, 0, 0, 1103140, 'PLG-002', '-', '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(0, 'KSR-21090021', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 05:11:29', '2021-09-04 05:11:29'),
(0, 'KSR-21090022', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 235000, 'tidak', 0, 0, 0, 0, 235000, 'PLG-002', '-', '2021-09-04 05:12:12', '2021-09-04 05:12:12'),
(0, 'KSR-21090023', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 425000, 'tidak', 0, 0, 0, 0, 425000, 'PLG-002', '-', '2021-09-04 05:13:03', '2021-09-04 05:13:03'),
(0, 'KSR-21090024', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 3480000, 'tidak', 0, 0, 0, 0, 3480000, 'PLG-002', '-', '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(0, 'KSR-21090025', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 1062500, 'tidak', 0, 0, 0, 0, 1062500, 'PLG-002', '-', '2021-09-04 05:15:49', '2021-09-04 05:15:49'),
(0, 'KSR-21090026', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 445000, 'tidak', 0, 0, 0, 0, 445000, 'PLG-002', '-', '2021-09-04 05:17:03', '2021-09-04 05:17:03'),
(0, 'KSR-21090027', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 337140, 'tidak', 0, 0, 0, 0, 337140, 'PLG-002', '-', '2021-09-04 05:19:30', '2021-09-04 05:19:30'),
(0, 'KSR-21090028', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 338580, 'tidak', 0, 0, 0, 0, 338580, 'PLG-002', '-', '2021-09-04 05:20:46', '2021-09-04 05:20:46'),
(0, 'KSR-21090029', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 480000, 'tidak', 0, 0, 0, 0, 480000, 'PLG-002', '-', '2021-09-04 05:21:38', '2021-09-04 05:21:38'),
(0, 'KSR-21090030', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 237500, 'tidak', 0, 0, 0, 0, 237500, 'PLG-002', '-', '2021-09-04 05:24:33', '2021-09-04 05:24:33'),
(0, 'KSR-21090031', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 196350, 'ya', 17850, 0, 0, 0, 178500, 'PLG-002', '-', '2021-09-04 05:28:08', '2021-09-04 05:28:08'),
(0, 'KSR-21090032', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 539000, 'tidak', 0, 0, 0, 0, 539000, 'PLG-002', '-', '2021-09-04 05:29:16', '2021-09-04 05:29:16'),
(0, 'KSR-21090033', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 05:30:20', '2021-09-04 05:30:20'),
(0, 'KSR-21090034', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 748000, 'tidak', 0, 0, 0, 0, 748000, 'PLG-002', '-', '2021-09-04 05:31:18', '2021-09-04 05:31:18'),
(0, 'KSR-21090035', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 337140, 'tidak', 0, 0, 0, 0, 337140, 'PLG-002', '-', '2021-09-04 05:32:15', '2021-09-04 05:32:15'),
(0, 'KSR-21090036', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 230000, 'tidak', 0, 0, 0, 0, 230000, 'PLG-002', '-', '2021-09-04 05:33:16', '2021-09-04 05:33:16'),
(0, 'KSR-21090037', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 416000, 'tidak', 0, 0, 0, 0, 416000, 'PLG-002', '-', '2021-09-04 05:34:36', '2021-09-04 05:34:36'),
(0, 'KSR-21090038', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 604000, 'tidak', 0, 0, 0, 0, 604000, 'PLG-002', '-', '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(0, 'KSR-21090039', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 430000, 'tidak', 0, 0, 0, 0, 430000, 'PLG-002', '-', '2021-09-04 05:36:35', '2021-09-04 05:36:35'),
(0, 'KSR-21090040', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 215000, 'tidak', 0, 0, 0, 0, 215000, 'PLG-002', '-', '2021-09-04 05:37:10', '2021-09-04 05:37:10'),
(0, 'KSR-21090041', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 235000, 'tidak', 0, 0, 0, 0, 235000, 'PLG-002', '-', '2021-09-04 05:38:06', '2021-09-04 05:38:06'),
(0, 'KSR-21090042', '2021-08-30', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 539000, 'tidak', 0, 0, 0, 0, 539000, 'PLG-002', '-', '2021-09-04 05:40:27', '2021-09-04 05:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `kaslacis`
--

CREATE TABLE `kaslacis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Tanggal` date NOT NULL,
  `Nominal` varchar(20) NOT NULL,
  `Transaksi` varchar(10) NOT NULL,
  `SaldoLaci` varchar(20) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KodeUser` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `KodeKategori` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaKategori` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItemAwal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`KodeKategori`, `NamaKategori`, `KodeItemAwal`, `Status`, `KodeUser`, `created_at`, `updated_at`) VALUES
('KLA-001', 'Hardware', 'HDW', 'DEL', 'admin', '2021-08-14 05:37:19', '2021-09-01 06:57:18'),
('KLA-002', 'Aksesoris', 'AKS', 'DEL', 'admin', '2021-08-14 05:37:42', '2021-09-01 06:57:24'),
('KLA-003', 'BERAS', 'BRS', 'OPN', 'adminlestari', '2021-09-01 04:56:45', '2021-09-01 04:56:45'),
('KLA-004', 'TEPUNG', 'TPG', 'OPN', 'adminlestari', '2021-09-01 05:49:44', '2021-09-01 05:49:44'),
('KLA-005', 'GULA', 'GLA', 'OPN', 'adminlestari', '2021-09-01 05:50:01', '2021-09-01 05:50:01'),
('KLA-006', 'KECAP', 'KCP', 'OPN', 'adminlestari', '2021-09-01 05:50:16', '2021-09-01 05:50:16'),
('KLA-007', 'BAWANG', 'BWG', 'OPN', 'adminlestari', '2021-09-01 05:50:37', '2021-09-01 05:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `keluarmasukbarangs`
--

CREATE TABLE `keluarmasukbarangs` (
  `id` bigint(20) NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JenisTransaksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeTransaksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `HargaRata` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` bigint(20) NOT NULL,
  `indexmov` bigint(20) NOT NULL,
  `saldo` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keluarmasukbarangs`
--

INSERT INTO `keluarmasukbarangs` (`id`, `Tanggal`, `KodeLokasi`, `KodeItem`, `JenisTransaksi`, `KodeTransaksi`, `Qty`, `HargaRata`, `KodeUser`, `idx`, `indexmov`, `saldo`, `created_at`, `updated_at`) VALUES
(1, '2021-09-04', 'GUD-001', 'BRS-001', 'LPB', 'LPB-021090001', 7, '0', 'adminlestari', 1, 1, 7, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(2, '2021-09-04', 'GUD-001', 'BRS-0010', 'LPB', 'LPB-021090001', 10, '0', 'adminlestari', 2, 2, 10, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(3, '2021-09-04', 'GUD-001', 'BRS-002', 'LPB', 'LPB-021090001', 23, '0', 'adminlestari', 3, 3, 23, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(4, '2021-09-04', 'GUD-001', 'BRS-003', 'LPB', 'LPB-021090001', 5, '0', 'adminlestari', 4, 4, 5, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(5, '2021-09-04', 'GUD-001', 'BRS-004', 'LPB', 'LPB-021090001', 1, '0', 'adminlestari', 5, 5, 1, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(6, '2021-09-04', 'GUD-001', 'BRS-005', 'LPB', 'LPB-021090001', 2, '0', 'adminlestari', 6, 6, 2, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(7, '2021-09-04', 'GUD-001', 'BRS-006', 'LPB', 'LPB-021090001', 16, '0', 'adminlestari', 7, 7, 16, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(8, '2021-09-04', 'GUD-001', 'BRS-007', 'LPB', 'LPB-021090001', 5, '0', 'adminlestari', 8, 8, 5, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(9, '2021-09-04', 'GUD-001', 'BRS-008', 'LPB', 'LPB-021090001', 1, '0', 'adminlestari', 9, 9, 1, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(10, '2021-09-04', 'GUD-001', 'BRS-009', 'LPB', 'LPB-021090001', 25, '0', 'adminlestari', 10, 10, 25, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(11, '2021-09-04', 'GUD-001', 'BRS-011', 'LPB', 'LPB-021090001', 1, '0', 'adminlestari', 11, 11, 1, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(12, '2021-09-04', 'GUD-001', 'BWG-001', 'LPB', 'LPB-021090001', 56.9, '0', 'adminlestari', 12, 12, 57, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(13, '2021-09-04', 'GUD-001', 'BWG-002', 'LPB', 'LPB-021090001', 151.65, '0', 'adminlestari', 13, 13, 152, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(14, '2021-09-04', 'GUD-001', 'GLA-001', 'LPB', 'LPB-021090001', 8, '0', 'adminlestari', 14, 14, 8, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(15, '2021-09-04', 'GUD-001', 'TPG-001', 'LPB', 'LPB-021090001', 4, '0', 'adminlestari', 15, 15, 4, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(16, '2021-09-04', 'GUD-001', 'TPG-002', 'LPB', 'LPB-021090001', 3, '0', 'adminlestari', 16, 16, 3, '2021-09-04 04:28:29', '2021-09-04 04:28:29'),
(17, '2021-08-30', 'GUD-001', 'BRS-006', 'KS', 'KSR-21090001', -2, '0', 'adminlestari', 1, 1, 14, '2021-09-04 04:31:29', '2021-09-04 04:31:29'),
(18, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090002', -1, '0', 'adminlestari', 1, 1, 7, '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(19, '2021-08-30', 'GUD-001', 'TPG-001', 'KS', 'KSR-21090002', -1, '0', 'adminlestari', 2, 2, 3, '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(20, '2021-08-30', 'GUD-001', 'TPG-002', 'KS', 'KSR-21090002', -1, '0', 'adminlestari', 3, 3, 2, '2021-09-04 04:36:44', '2021-09-04 04:36:44'),
(21, '2021-08-30', 'GUD-001', 'BRS-003', 'KS', 'KSR-21090003', -1, '0', 'adminlestari', 1, 1, 4, '2021-09-04 04:39:27', '2021-09-04 04:39:27'),
(22, '2021-08-30', 'GUD-001', 'TPG-001', 'KS', 'KSR-21090004', -1, '0', 'adminlestari', 1, 1, 2, '2021-09-04 04:47:00', '2021-09-04 04:47:00'),
(23, '2021-08-30', 'GUD-001', 'TPG-003', 'KS', 'KSR-21090004', -1, '0', 'adminlestari', 2, 2, -1, '2021-09-04 04:47:00', '2021-09-04 04:47:00'),
(24, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090005', -1, '0', 'adminlestari', 1, 1, 22, '2021-09-04 04:48:09', '2021-09-04 04:48:09'),
(25, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090006', -18.7, '0', 'adminlestari', 1, 1, 133, '2021-09-04 04:51:29', '2021-09-04 04:51:29'),
(26, '2021-08-30', 'GUD-001', 'BRS-006', 'KS', 'KSR-21090007', -4, '0', 'adminlestari', 1, 1, 10, '2021-09-04 04:52:57', '2021-09-04 04:52:57'),
(27, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090007', -1, '0', 'adminlestari', 2, 2, 6, '2021-09-04 04:52:57', '2021-09-04 04:52:57'),
(28, '2021-08-30', 'GUD-001', 'BRS-011', 'KS', 'KSR-21090008', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 04:53:48', '2021-09-04 04:53:48'),
(29, '2021-08-30', 'GUD-001', 'BRS-008', 'KS', 'KSR-21090009', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 04:54:42', '2021-09-04 04:54:42'),
(30, '2021-08-30', 'GUD-001', 'BRS-003', 'KS', 'KSR-21090010', -1, '0', 'adminlestari', 1, 1, 3, '2021-09-04 04:57:34', '2021-09-04 04:57:34'),
(31, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090010', -2, '0', 'adminlestari', 2, 2, 4, '2021-09-04 04:57:34', '2021-09-04 04:57:34'),
(32, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090011', -1, '0', 'adminlestari', 1, 1, 21, '2021-09-04 04:58:31', '2021-09-04 04:58:31'),
(33, '2021-08-30', 'GUD-001', 'BRS-009', 'KS', 'KSR-21090012', -8, '0', 'adminlestari', 1, 1, 17, '2021-09-04 05:00:24', '2021-09-04 05:00:24'),
(34, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090013', -1, '0', 'adminlestari', 1, 1, 3, '2021-09-04 05:01:31', '2021-09-04 05:01:31'),
(35, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090014', -1, '0', 'adminlestari', 1, 1, 20, '2021-09-04 05:02:39', '2021-09-04 05:02:39'),
(36, '2021-08-30', 'GUD-001', 'BWG-001', 'KS', 'KSR-21090015', -19.5, '0', 'adminlestari', 1, 1, 38, '2021-09-04 05:03:42', '2021-09-04 05:03:42'),
(37, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090015', -19.5, '0', 'adminlestari', 2, 2, 114, '2021-09-04 05:03:42', '2021-09-04 05:03:42'),
(38, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090016', -19.56, '0', 'adminlestari', 1, 1, 94, '2021-09-04 05:05:25', '2021-09-04 05:05:25'),
(39, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090017', -18.75, '0', 'adminlestari', 1, 1, 75, '2021-09-04 05:07:08', '2021-09-04 05:07:08'),
(40, '2021-08-30', 'GUD-001', 'BRS-001', 'KS', 'KSR-21090018', -6, '0', 'adminlestari', 1, 1, 1, '2021-09-04 05:08:03', '2021-09-04 05:08:03'),
(41, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090019', -1, '0', 'adminlestari', 1, 1, 19, '2021-09-04 05:08:41', '2021-09-04 05:08:41'),
(42, '2021-08-30', 'GUD-001', 'BRS-009', 'KS', 'KSR-21090020', -5, '0', 'adminlestari', 1, 1, 12, '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(43, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090020', -18.98, '0', 'adminlestari', 2, 2, 56, '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(44, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090020', -1, '0', 'adminlestari', 3, 3, 2, '2021-09-04 05:10:42', '2021-09-04 05:10:42'),
(45, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090021', -1, '0', 'adminlestari', 1, 1, 18, '2021-09-04 05:11:29', '2021-09-04 05:11:29'),
(46, '2021-08-30', 'GUD-001', 'BRS-003', 'KS', 'KSR-21090022', -1, '0', 'adminlestari', 1, 1, 2, '2021-09-04 05:12:12', '2021-09-04 05:12:12'),
(47, '2021-08-30', 'GUD-001', 'BRS-005', 'KS', 'KSR-21090023', -2, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:13:03', '2021-09-04 05:13:03'),
(48, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090024', -4, '0', 'adminlestari', 1, 1, 14, '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(49, '2021-08-30', 'GUD-001', 'BRS-006', 'KS', 'KSR-21090024', -10, '0', 'adminlestari', 2, 2, 0, '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(50, '2021-08-30', 'GUD-001', 'BRS-009', 'KS', 'KSR-21090024', -10, '0', 'adminlestari', 3, 3, 2, '2021-09-04 05:14:48', '2021-09-04 05:14:48'),
(51, '2021-08-30', 'GUD-001', 'BRS-007', 'KS', 'KSR-21090025', -5, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:15:49', '2021-09-04 05:15:49'),
(52, '2021-08-30', 'GUD-001', 'BRS-009', 'KS', 'KSR-21090026', -10, '0', 'adminlestari', 1, 1, -8, '2021-09-04 05:17:03', '2021-09-04 05:17:03'),
(53, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090027', -18.73, '0', 'adminlestari', 1, 1, 37, '2021-09-04 05:19:30', '2021-09-04 05:19:30'),
(54, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090028', -18.81, '0', 'adminlestari', 1, 1, 18, '2021-09-04 05:20:46', '2021-09-04 05:20:46'),
(55, '2021-08-30', 'GUD-001', 'BRS-0010', 'KS', 'KSR-21090029', -10, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:21:38', '2021-09-04 05:21:38'),
(56, '2021-08-30', 'GUD-001', 'BRS-001', 'KS', 'KSR-21090030', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:24:33', '2021-09-04 05:24:33'),
(57, '2021-08-30', 'GUD-001', 'TPG-001', 'KS', 'KSR-21090031', -1, '0', 'adminlestari', 1, 1, 1, '2021-09-04 05:28:08', '2021-09-04 05:28:08'),
(58, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090032', -1, '0', 'adminlestari', 1, 1, 1, '2021-09-04 05:29:17', '2021-09-04 05:29:17'),
(59, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090033', -1, '0', 'adminlestari', 1, 1, 13, '2021-09-04 05:30:20', '2021-09-04 05:30:20'),
(60, '2021-08-30', 'GUD-001', 'BWG-001', 'KS', 'KSR-21090034', -37.4, '0', 'adminlestari', 1, 1, 1, '2021-09-04 05:31:18', '2021-09-04 05:31:18'),
(61, '2021-08-30', 'GUD-001', 'BWG-002', 'KS', 'KSR-21090035', -18.73, '0', 'adminlestari', 1, 1, -1, '2021-09-04 05:32:15', '2021-09-04 05:32:15'),
(62, '2021-08-30', 'GUD-001', 'BRS-004', 'KS', 'KSR-21090036', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:33:16', '2021-09-04 05:33:16'),
(63, '2021-08-30', 'GUD-001', 'BRS-001', 'KS', 'KSR-21090037', -1, '0', 'adminlestari', 1, 1, -1, '2021-09-04 05:34:36', '2021-09-04 05:34:36'),
(64, '2021-08-30', 'GUD-001', 'TPG-001', 'KS', 'KSR-21090037', -1, '0', 'adminlestari', 2, 2, 0, '2021-09-04 05:34:36', '2021-09-04 05:34:36'),
(65, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090038', -1, '0', 'adminlestari', 1, 1, 12, '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(66, '2021-08-30', 'GUD-001', 'BRS-003', 'KS', 'KSR-21090038', -1, '0', 'adminlestari', 2, 2, 1, '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(67, '2021-08-30', 'GUD-001', 'TPG-002', 'KS', 'KSR-21090038', -1, '0', 'adminlestari', 3, 3, 1, '2021-09-04 05:35:55', '2021-09-04 05:35:55'),
(68, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090039', -2, '0', 'adminlestari', 1, 1, 10, '2021-09-04 05:36:35', '2021-09-04 05:36:35'),
(69, '2021-08-30', 'GUD-001', 'BRS-002', 'KS', 'KSR-21090040', -1, '0', 'adminlestari', 1, 1, 9, '2021-09-04 05:37:10', '2021-09-04 05:37:10'),
(70, '2021-08-30', 'GUD-001', 'BRS-003', 'KS', 'KSR-21090041', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:38:06', '2021-09-04 05:38:06'),
(71, '2021-08-30', 'GUD-001', 'GLA-001', 'KS', 'KSR-21090042', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 05:40:27', '2021-09-04 05:40:27'),
(72, '2021-09-04', 'GUD-001', 'BRS-002', 'RPB', 'RPB-021090001', -9, '0', 'adminlestari', 1, 1, 0, '2021-09-04 06:32:36', '2021-09-04 06:32:36'),
(73, '2021-09-04', 'GUD-001', 'TPG-002', 'RPB', 'RPB-021090002', -1, '0', 'adminlestari', 1, 1, 0, '2021-09-04 06:36:19', '2021-09-04 06:36:19'),
(74, '2021-09-04', 'GUD-001', 'BRS-001', 'SLM', 'SLM-21090001', 1, '0', 'adminlestari', 0, 0, 0, '2021-09-04 06:40:53', '2021-09-04 06:40:53'),
(75, '2021-09-04', 'GUD-001', 'BWG-001', 'SLK', 'SLK-21090001', -1, '0', 'adminlestari', 0, 1, 0, '2021-09-04 06:46:10', '2021-09-04 06:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `koreksigajians`
--

CREATE TABLE `koreksigajians` (
  `KodeGaji` varchar(191) NOT NULL,
  `Kekurangan` varchar(10) NOT NULL,
  `Kelebihan` varchar(10) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lokasiitems`
--

CREATE TABLE `lokasiitems` (
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Konversi` double NOT NULL,
  `HargaRata` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasis`
--

CREATE TABLE `lokasis` (
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasis`
--

INSERT INTO `lokasis` (`KodeLokasi`, `NamaLokasi`, `Tipe`, `Status`, `KodeUser`, `created_at`, `updated_at`) VALUES
('GUD-001', 'SlimWH', 'INV', 'OPN', 'admin', NULL, '2021-04-27 02:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `matauangs`
--

CREATE TABLE `matauangs` (
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nilai` double NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matauangs`
--

INSERT INTO `matauangs` (`KodeMataUang`, `NamaMataUang`, `Nilai`, `Status`, `KodeUser`, `created_at`, `updated_at`) VALUES
('Rp', 'Rupiah', 1, 'OPN', 'admin', '2020-07-13 04:43:50', '2020-07-13 04:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggans`
--

CREATE TABLE `pelanggans` (
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaPelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Handphone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NIK` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NPWP` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LimitPiutang` double DEFAULT NULL,
  `Diskon` double DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggans`
--

INSERT INTO `pelanggans` (`KodePelanggan`, `NamaPelanggan`, `Kontak`, `Handphone`, `Email`, `NIK`, `NPWP`, `LimitPiutang`, `Diskon`, `Status`, `KodeLokasi`, `KodeUser`, `created_at`, `updated_at`) VALUES
('PLG-001', 'CV Anugerah', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2021-04-22 02:45:30', '2021-04-22 02:45:30'),
('PLG-002', 'NN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'adminlestari', '2021-09-01 05:32:32', '2021-09-03 18:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `pelunasanhutangs`
--

CREATE TABLE `pelunasanhutangs` (
  `KodePelunasanHutangID` int(11) NOT NULL,
  `KodePelunasanHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeInvoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipeBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jumlah` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKasBank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelunasanpiutangs`
--

CREATE TABLE `pelunasanpiutangs` (
  `KodePelunasanPiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodePiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeInvoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipeBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jumlah` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKasBank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KodePelunasanPiutangID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelianlangsungdetails`
--

CREATE TABLE `pembelianlangsungdetails` (
  `KodePembelianLangsung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelianlangsungs`
--

CREATE TABLE `pembelianlangsungs` (
  `KodePembelianLangsung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemesananpembeliandetails`
--

CREATE TABLE `pemesananpembeliandetails` (
  `id` bigint(20) NOT NULL,
  `KodePO` varchar(100) NOT NULL,
  `KodeItem` varchar(100) NOT NULL,
  `KodeSatuan` varchar(191) NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesananpembeliandetails`
--

INSERT INTO `pemesananpembeliandetails` (`id`, `KodePO`, `KodeItem`, `KodeSatuan`, `Qty`, `Harga`, `NoUrut`, `Subtotal`, `created_at`, `updated_at`) VALUES
(1, 'PO-021090001', 'BRS-001', 'sak', 10, 243000, 1, 2430000, '2021-09-03 12:12:07', '2021-09-03 12:21:52'),
(2, 'PO-021090002', 'BRS-002', 'sak', 10, 250000, 1, 2500000, '2021-09-03 15:47:07', '2021-09-03 15:47:07'),
(3, 'PO-021090003', 'BRS-001', 'sak', 7, 236000, 1, 1652000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(4, 'PO-021090003', 'BRS-002', 'sak', 23, 214000, 2, 4922000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(5, 'PO-021090003', 'BRS-004', 'sak', 1, 225000, 3, 225000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(6, 'PO-021090003', 'BRS-005', 'sak', 2, 212000, 4, 424000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(7, 'PO-021090003', 'BRS-006', 'sak', 16, 217000, 5, 3472000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(8, 'PO-021090003', 'BRS-007', 'sak', 5, 212000, 6, 1060000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(9, 'PO-021090003', 'BRS-008', 'sak', 1, 87000, 7, 87000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(10, 'PO-021090003', 'BRS-009', 'sak', 25, 44000, 8, 1100000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(11, 'PO-021090003', 'BRS-0010', 'sak', 10, 47000, 9, 470000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(12, 'PO-021090003', 'BRS-011', 'sak', 1, 46000, 10, 46000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(13, 'PO-021090003', 'GLA-001', 'sak', 8, 538000, 11, 4304000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(14, 'PO-021090003', 'BWG-001', 'kg', 56.9, 19500, 12, 1109550, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(15, 'PO-021090003', 'BWG-002', 'kg', 151.65, 17000, 13, 2578050, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(16, 'PO-021090003', 'TPG-001', 'sak', 4, 178000, 14, 712000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(17, 'PO-021090003', 'TPG-002', 'sak', 3, 153000, 15, 459000, '2021-09-04 04:15:09', '2021-09-04 04:25:24'),
(18, 'PO-021090003', 'BRS-003', 'sak', 5, 234000, 16, 1170000, '2021-09-04 04:25:24', '2021-09-04 04:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `pemesananpembelians`
--

CREATE TABLE `pemesananpembelians` (
  `id` int(11) NOT NULL,
  `KodePO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NilaiPPN` double DEFAULT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double DEFAULT NULL,
  `NilaiDiskon` double DEFAULT NULL,
  `Subtotal` double DEFAULT NULL,
  `KodeSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Expired` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Tanggal` date DEFAULT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeSJ` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesananpembelians`
--

INSERT INTO `pemesananpembelians` (`id`, `KodePO`, `KodeLokasi`, `KodeMataUang`, `Status`, `KodeUser`, `Total`, `PPN`, `NilaiPPN`, `Printed`, `Diskon`, `NilaiDiskon`, `Subtotal`, `KodeSupplier`, `Expired`, `Tanggal`, `Keterangan`, `term`, `KodeSJ`, `NoFaktur`, `created_at`, `updated_at`) VALUES
(3, 'PO-021090003', 'GUD-001', 'Rp', 'CLS', 'adminlestari', 23790600, 'tidak', 0, NULL, 0, 0, 23790600, 'SUP-001', '7', '2021-08-28', '-', '30', NULL, NULL, '2021-09-04 04:15:09', '2021-09-04 04:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `pemesananpenjualans`
--

CREATE TABLE `pemesananpenjualans` (
  `id` int(11) NOT NULL,
  `KodeSO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double DEFAULT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double DEFAULT 0,
  `NilaiDiskon` double DEFAULT 0,
  `Subtotal` double DEFAULT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Expired` double DEFAULT NULL,
  `KodeSales` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `POPelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesananpenjualans`
--

INSERT INTO `pemesananpenjualans` (`id`, `KodeSO`, `Tanggal`, `KodeLokasi`, `KodeMataUang`, `Status`, `KodeUser`, `Total`, `PPN`, `NilaiPPN`, `Printed`, `Diskon`, `NilaiDiskon`, `Subtotal`, `KodePelanggan`, `Expired`, `KodeSales`, `POPelanggan`, `created_at`, `updated_at`, `tgl_kirim`, `term`, `keterangan`, `NoFaktur`) VALUES
(1, 'SO-021090001', '2021-09-04', 'GUD-001', 'Rp', 'CLS', 'adminlestari', 245000, 'tidak', 0, 0, 0, 0, 245000, 'PLG-001', 7, '0', 'PO', '2021-09-03 17:41:10', '2021-09-03 17:48:28', '2021-09-04', '30', '-', NULL),
(2, 'SO-021090002', '2021-09-04', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 252000, 'tidak', 0, 0, 0, 0, 252000, 'PLG-002', 7, '0', 'PO', '2021-09-03 17:59:21', '2021-09-03 17:59:48', '2021-09-04', '30', '-', NULL),
(3, 'SO-021090003', '2021-09-04', 'GUD-001', 'Rp', 'CLS', 'adminlestari', 245000, 'tidak', 0, 0, 0, 0, 245000, 'PLG-002', 7, '0', 'PO', '2021-09-03 18:13:16', '2021-09-03 18:14:29', '2021-09-04', '30', '-', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_penjualan_detail`
--

CREATE TABLE `pemesanan_penjualan_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodeSO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `HargaRata` double NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaanbarangdetails`
--

CREATE TABLE `penerimaanbarangdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodePenerimaanBarang` varchar(100) NOT NULL,
  `KodeItem` varchar(100) NOT NULL,
  `KodeSatuan` varchar(100) DEFAULT NULL,
  `Harga` double DEFAULT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(100) DEFAULT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerimaanbarangdetails`
--

INSERT INTO `penerimaanbarangdetails` (`id`, `KodePenerimaanBarang`, `KodeItem`, `KodeSatuan`, `Harga`, `Qty`, `Keterangan`, `NoUrut`, `created_at`, `updated_at`) VALUES
(1, 'LPB-021090001', 'BRS-001', 'sak', 236000, 7, '-', 1, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(2, 'LPB-021090001', 'BRS-0010', 'sak', 47000, 10, '-', 2, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(3, 'LPB-021090001', 'BRS-002', 'sak', 214000, 23, '-', 3, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(4, 'LPB-021090001', 'BRS-003', 'sak', 234000, 5, '-', 4, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(5, 'LPB-021090001', 'BRS-004', 'sak', 225000, 1, '-', 5, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(6, 'LPB-021090001', 'BRS-005', 'sak', 212000, 2, '-', 6, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(7, 'LPB-021090001', 'BRS-006', 'sak', 217000, 16, '-', 7, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(8, 'LPB-021090001', 'BRS-007', 'sak', 212000, 5, '-', 8, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(9, 'LPB-021090001', 'BRS-008', 'sak', 87000, 1, '-', 9, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(10, 'LPB-021090001', 'BRS-009', 'sak', 44000, 25, '-', 10, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(11, 'LPB-021090001', 'BRS-011', 'sak', 46000, 1, '-', 11, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(12, 'LPB-021090001', 'BWG-001', 'kg', 19500, 56.9, '-', 12, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(13, 'LPB-021090001', 'BWG-002', 'kg', 17000, 151.65, '-', 13, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(14, 'LPB-021090001', 'GLA-001', 'sak', 538000, 8, '-', 14, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(15, 'LPB-021090001', 'TPG-001', 'sak', 178000, 4, '-', 15, '2021-09-04 04:28:21', '2021-09-04 04:28:21'),
(16, 'LPB-021090001', 'TPG-002', 'sak', 153000, 3, '-', 16, '2021-09-04 04:28:21', '2021-09-04 04:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaanbarangreturndetails`
--

CREATE TABLE `penerimaanbarangreturndetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodePenerimaanBarangReturn` varchar(100) NOT NULL,
  `KodeItem` varchar(100) NOT NULL,
  `KodeSatuan` varchar(100) DEFAULT NULL,
  `Harga` double DEFAULT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(100) DEFAULT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerimaanbarangreturndetails`
--

INSERT INTO `penerimaanbarangreturndetails` (`id`, `KodePenerimaanBarangReturn`, `KodeItem`, `KodeSatuan`, `Harga`, `Qty`, `Keterangan`, `NoUrut`, `created_at`, `updated_at`) VALUES
(5, 'RPB-021090001', 'BRS-002', 'sak', 214000, 9, '-', 1, '2021-09-04 06:31:32', '2021-09-04 06:31:32'),
(6, 'RPB-021090002', 'TPG-002', 'sak', 153000, 1, '-', 1, '2021-09-04 06:35:51', '2021-09-04 06:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaanbarangreturns`
--

CREATE TABLE `penerimaanbarangreturns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodePenerimaanBarangReturn` varchar(100) NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(100) NOT NULL,
  `KodeUser` varchar(100) NOT NULL,
  `KodeLokasi` varchar(100) NOT NULL,
  `KodeSupplier` varchar(100) NOT NULL,
  `Keterangan` varchar(191) DEFAULT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(100) NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodePenerimaanBarang` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerimaanbarangreturns`
--

INSERT INTO `penerimaanbarangreturns` (`id`, `KodePenerimaanBarangReturn`, `Tanggal`, `Status`, `KodeUser`, `KodeLokasi`, `KodeSupplier`, `Keterangan`, `Total`, `PPN`, `NilaiPPN`, `Printed`, `Diskon`, `NilaiDiskon`, `Subtotal`, `KodePenerimaanBarang`, `created_at`, `updated_at`) VALUES
(3, 'RPB-021090001', '2021-09-04', 'CFM', 'adminlestari', '', '', '-', 1926000, 'tidak', 0, 0, 0, 0, 1926000, 'LPB-021090001', '2021-09-04 06:31:32', '2021-09-04 06:32:36'),
(4, 'RPB-021090002', '2021-09-04', 'CFM', 'adminlestari', '', '', '-', 153000, 'tidak', 0, 0, 0, 0, 153000, 'LPB-021090001', '2021-09-04 06:35:51', '2021-09-04 06:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaanbarangs`
--

CREATE TABLE `penerimaanbarangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `KodePenerimaanBarang` varchar(100) NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(100) NOT NULL,
  `KodeMataUang` varchar(100) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `KodeUser` varchar(100) DEFAULT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(100) NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodeSupplier` varchar(100) NOT NULL,
  `KodeSales` varchar(191) DEFAULT NULL,
  `TotalItem` varchar(191) DEFAULT NULL,
  `Keterangan` varchar(191) DEFAULT NULL,
  `KodeSJ` varchar(191) DEFAULT NULL,
  `KodePO` varchar(100) NOT NULL,
  `NoFaktur` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerimaanbarangs`
--

INSERT INTO `penerimaanbarangs` (`id`, `KodePenerimaanBarang`, `Tanggal`, `KodeLokasi`, `KodeMataUang`, `Status`, `KodeUser`, `Total`, `PPN`, `NilaiPPN`, `Printed`, `Diskon`, `NilaiDiskon`, `Subtotal`, `KodeSupplier`, `KodeSales`, `TotalItem`, `Keterangan`, `KodeSJ`, `KodePO`, `NoFaktur`, `created_at`, `updated_at`) VALUES
(1, 'LPB-021090001', '2021-09-04', 'GUD-001', 'Rp', 'CFM', 'adminlestari', 0, 'tidak', 0, 0, 0, 0, 23790600, 'SUP-001', 'KAR-002', '16', '-', '-', 'PO-021090003', NULL, '2021-09-04 04:28:21', '2021-09-04 04:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluarantambahans`
--

CREATE TABLE `pengeluarantambahans` (
  `id` int(11) UNSIGNED NOT NULL,
  `KodePengeluaran` varchar(191) NOT NULL,
  `Nama` varchar(191) NOT NULL,
  `Karyawan` varchar(191) NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) NOT NULL,
  `KodeMataUang` varchar(191) NOT NULL,
  `Metode` varchar(191) NOT NULL,
  `Transaksi` varchar(191) NOT NULL,
  `Total` double NOT NULL,
  `KodeUser` varchar(191) NOT NULL,
  `Keterangan` varchar(999) DEFAULT NULL,
  `Status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penggunas`
--

CREATE TABLE `penggunas` (
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalDaftar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Aktif` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualanlangsungdetails`
--

CREATE TABLE `penjualanlangsungdetails` (
  `id` int(11) UNSIGNED NOT NULL,
  `KodePenjualanLangsung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualanlangsungreturndetails`
--

CREATE TABLE `penjualanlangsungreturndetails` (
  `KodePenjualanLangsungReturn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualanlangsungreturns`
--

CREATE TABLE `penjualanlangsungreturns` (
  `KodePenjualanLangsungReturn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` datetime NOT NULL,
  `KodePenjualanLangsung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoIndeks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualanlangsungs`
--

CREATE TABLE `penjualanlangsungs` (
  `KodePenjualanLangsung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoIndeks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pindahgudangdetails`
--

CREATE TABLE `pindahgudangdetails` (
  `KodePindah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pindahgudangs`
--

CREATE TABLE `pindahgudangs` (
  `KodePindah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DariLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` datetime NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutangs`
--

CREATE TABLE `piutangs` (
  `KodePiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` datetime NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Invoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jumlah` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Term` double NOT NULL,
  `Koreksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kembali` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rugilaba`
--

CREATE TABLE `rugilaba` (
  `KodeTransaksi` varchar(255) NOT NULL,
  `TotalLaba` int(25) NOT NULL,
  `TotalRugi` int(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rugilaba`
--

INSERT INTO `rugilaba` (`KodeTransaksi`, `TotalLaba`, `TotalRugi`, `created_at`) VALUES
('KSR-21090001', 0, 0, '2021-09-04 04:31:29'),
('KSR-21090002', 0, 0, '2021-09-04 04:36:44'),
('KSR-21090003', 0, 0, '2021-09-04 04:39:27'),
('KSR-21090004', 0, 0, '2021-09-04 04:47:00'),
('KSR-21090005', 0, 0, '2021-09-04 04:48:09'),
('KSR-21090006', 0, 0, '2021-09-04 04:51:29'),
('KSR-21090007', 0, 0, '2021-09-04 04:52:57'),
('KSR-21090008', 0, 0, '2021-09-04 04:53:48'),
('KSR-21090009', 0, 0, '2021-09-04 04:54:42'),
('KSR-21090010', 0, 0, '2021-09-04 04:57:34'),
('KSR-21090011', 0, 0, '2021-09-04 04:58:31'),
('KSR-21090012', 0, 0, '2021-09-04 05:00:24'),
('KSR-21090013', 0, 0, '2021-09-04 05:01:31'),
('KSR-21090014', 0, 0, '2021-09-04 05:02:39'),
('KSR-21090015', 0, 0, '2021-09-04 05:03:42'),
('KSR-21090016', 0, 0, '2021-09-04 05:05:24'),
('KSR-21090017', 0, 0, '2021-09-04 05:07:08'),
('KSR-21090018', 0, 0, '2021-09-04 05:08:03'),
('KSR-21090019', 0, 0, '2021-09-04 05:08:41'),
('KSR-21090020', 0, 0, '2021-09-04 05:10:42'),
('KSR-21090021', 0, 0, '2021-09-04 05:11:29'),
('KSR-21090022', 0, 0, '2021-09-04 05:12:12'),
('KSR-21090023', 0, 0, '2021-09-04 05:13:03'),
('KSR-21090024', 0, 0, '2021-09-04 05:14:48'),
('KSR-21090025', 0, 0, '2021-09-04 05:15:49'),
('KSR-21090026', 0, 0, '2021-09-04 05:17:03'),
('KSR-21090027', 0, 0, '2021-09-04 05:19:30'),
('KSR-21090028', 0, 0, '2021-09-04 05:20:46'),
('KSR-21090029', 0, 0, '2021-09-04 05:21:38'),
('KSR-21090030', 0, 0, '2021-09-04 05:24:33'),
('KSR-21090031', 0, 0, '2021-09-04 05:28:08'),
('KSR-21090032', 0, 0, '2021-09-04 05:29:17'),
('KSR-21090033', 0, 0, '2021-09-04 05:30:20'),
('KSR-21090034', 0, 0, '2021-09-04 05:31:18'),
('KSR-21090035', 0, 0, '2021-09-04 05:32:15'),
('KSR-21090036', 0, 0, '2021-09-04 05:33:16'),
('KSR-21090037', 0, 0, '2021-09-04 05:34:36'),
('KSR-21090038', 0, 0, '2021-09-04 05:35:55'),
('KSR-21090039', 0, 0, '2021-09-04 05:36:35'),
('KSR-21090040', 0, 0, '2021-09-04 05:37:10'),
('KSR-21090041', 0, 0, '2021-09-04 05:38:06'),
('KSR-21090042', 0, 0, '2021-09-04 05:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `rugilaba_details`
--

CREATE TABLE `rugilaba_details` (
  `KodeTransaksi` varchar(255) NOT NULL,
  `KodeItem` varchar(255) NOT NULL,
  `Laba` int(25) NOT NULL,
  `Rugi` int(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rugilaba_details`
--

INSERT INTO `rugilaba_details` (`KodeTransaksi`, `KodeItem`, `Laba`, `Rugi`, `created_at`) VALUES
('KSR-21090001', 'BRS-006', 0, 0, '2021-09-04 04:31:29'),
('KSR-21090002', 'GLA-001', 0, 0, '2021-09-04 04:36:44'),
('KSR-21090002', 'TPG-001', 0, 0, '2021-09-04 04:36:44'),
('KSR-21090002', 'TPG-002', 0, 0, '2021-09-04 04:36:44'),
('KSR-21090003', 'BRS-003', 0, 0, '2021-09-04 04:39:27'),
('KSR-21090004', 'TPG-003', 0, 0, '2021-09-04 04:47:00'),
('KSR-21090004', 'TPG-001', 0, 0, '2021-09-04 04:47:00'),
('KSR-21090005', 'BRS-002', 0, 0, '2021-09-04 04:48:09'),
('KSR-21090006', 'BWG-002', 0, 0, '2021-09-04 04:51:29'),
('KSR-21090007', 'BRS-006', 0, 0, '2021-09-04 04:52:57'),
('KSR-21090007', 'GLA-001', 0, 0, '2021-09-04 04:52:57'),
('KSR-21090008', 'BRS-011', 0, 0, '2021-09-04 04:53:48'),
('KSR-21090009', 'BRS-008', 0, 0, '2021-09-04 04:54:42'),
('KSR-21090010', 'GLA-001', 0, 0, '2021-09-04 04:57:34'),
('KSR-21090010', 'BRS-003', 0, 0, '2021-09-04 04:57:34'),
('KSR-21090011', 'BRS-002', 0, 0, '2021-09-04 04:58:31'),
('KSR-21090012', 'BRS-009', 0, 0, '2021-09-04 05:00:24'),
('KSR-21090013', 'GLA-001', 0, 0, '2021-09-04 05:01:31'),
('KSR-21090014', 'BRS-002', 0, 0, '2021-09-04 05:02:39'),
('KSR-21090015', 'BWG-001', 0, 0, '2021-09-04 05:03:42'),
('KSR-21090015', 'BWG-002', 0, 0, '2021-09-04 05:03:42'),
('KSR-21090016', 'BWG-002', 0, 0, '2021-09-04 05:05:24'),
('KSR-21090017', 'BWG-002', 0, 0, '2021-09-04 05:07:08'),
('KSR-21090018', 'BRS-001', 0, 0, '2021-09-04 05:08:03'),
('KSR-21090019', 'BRS-002', 0, 0, '2021-09-04 05:08:41'),
('KSR-21090020', 'BWG-002', 0, 0, '2021-09-04 05:10:42'),
('KSR-21090020', 'GLA-001', 0, 0, '2021-09-04 05:10:42'),
('KSR-21090020', 'BRS-009', 0, 0, '2021-09-04 05:10:42'),
('KSR-21090021', 'BRS-002', 0, 0, '2021-09-04 05:11:29'),
('KSR-21090022', 'BRS-003', 0, 0, '2021-09-04 05:12:12'),
('KSR-21090023', 'BRS-005', 0, 0, '2021-09-04 05:13:03'),
('KSR-21090024', 'BRS-006', 0, 0, '2021-09-04 05:14:48'),
('KSR-21090024', 'BRS-002', 0, 0, '2021-09-04 05:14:48'),
('KSR-21090024', 'BRS-009', 0, 0, '2021-09-04 05:14:48'),
('KSR-21090025', 'BRS-007', 0, 0, '2021-09-04 05:15:49'),
('KSR-21090026', 'BRS-009', 0, 0, '2021-09-04 05:17:03'),
('KSR-21090027', 'BWG-002', 0, 0, '2021-09-04 05:19:30'),
('KSR-21090028', 'BWG-002', 0, 0, '2021-09-04 05:20:46'),
('KSR-21090029', 'BRS-0010', 0, 0, '2021-09-04 05:21:38'),
('KSR-21090030', 'BRS-001', 0, 0, '2021-09-04 05:24:33'),
('KSR-21090031', 'TPG-001', 0, 0, '2021-09-04 05:28:08'),
('KSR-21090032', 'GLA-001', 0, 0, '2021-09-04 05:29:16'),
('KSR-21090033', 'BRS-002', 0, 0, '2021-09-04 05:30:20'),
('KSR-21090034', 'BWG-001', 0, 0, '2021-09-04 05:31:18'),
('KSR-21090035', 'BWG-002', 0, 0, '2021-09-04 05:32:15'),
('KSR-21090036', 'BRS-004', 0, 0, '2021-09-04 05:33:16'),
('KSR-21090037', 'BRS-001', 0, 0, '2021-09-04 05:34:36'),
('KSR-21090037', 'TPG-001', 0, 0, '2021-09-04 05:34:36'),
('KSR-21090038', 'BRS-002', 0, 0, '2021-09-04 05:35:55'),
('KSR-21090038', 'BRS-003', 0, 0, '2021-09-04 05:35:55'),
('KSR-21090038', 'TPG-002', 0, 0, '2021-09-04 05:35:55'),
('KSR-21090039', 'BRS-002', 0, 0, '2021-09-04 05:36:35'),
('KSR-21090040', 'BRS-002', 0, 0, '2021-09-04 05:37:10'),
('KSR-21090041', 'BRS-003', 0, 0, '2021-09-04 05:38:06'),
('KSR-21090042', 'GLA-001', 0, 0, '2021-09-04 05:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `saldos`
--

CREATE TABLE `saldos` (
  `id` int(11) UNSIGNED NOT NULL,
  `KodeTransaksi` varchar(191) NOT NULL,
  `Transaksi` varchar(191) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jumlah` double NOT NULL,
  `Tipe` varchar(191) NOT NULL,
  `SaldoCash` double NOT NULL,
  `SaldoRekening` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `KodeSales` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaSales` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`KodeSales`, `NamaSales`, `Kontak`, `Status`, `KodeKaryawan`, `created_at`, `updated_at`) VALUES
('SAL-001', 'NN', '085234006574', 'OPN', 'KAR-002', '2021-04-22 05:41:10', '2021-04-22 05:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `satuans`
--

CREATE TABLE `satuans` (
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuans`
--

INSERT INTO `satuans` (`KodeSatuan`, `NamaSatuan`, `Status`, `KodeUser`, `created_at`, `updated_at`) VALUES
('kg', 'kilogram', 'OPN', 'adminlestari', '2021-09-01 04:57:27', '2021-09-01 04:57:27'),
('sak', 'sak', 'OPN', 'adminlestari', '2021-09-01 05:56:04', '2021-09-01 05:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `stokkeluardetails`
--

CREATE TABLE `stokkeluardetails` (
  `KodeStokKeluar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stokkeluardetails`
--

INSERT INTO `stokkeluardetails` (`KodeStokKeluar`, `KodeItem`, `KodeSatuan`, `Qty`, `Keterangan`, `NoUrut`, `created_at`, `updated_at`, `id`) VALUES
('SLK-21090001', 'BWG-001', 'kg', 1, '-', 0, '2021-09-04 06:46:10', '2021-09-04 06:46:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stokkeluars`
--

CREATE TABLE `stokkeluars` (
  `KodeStokKeluar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` datetime NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TotalItem` double NOT NULL,
  `Printed` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stokkeluars`
--

INSERT INTO `stokkeluars` (`KodeStokKeluar`, `KodeLokasi`, `Tanggal`, `Keterangan`, `Status`, `KodeUser`, `TotalItem`, `Printed`, `created_at`, `updated_at`) VALUES
('SLK-21090001', 'GUD-001', '2021-09-04 00:00:00', '-', 'CFM', 'adminlestari', 1, 0, '2021-09-04 06:46:10', '2021-09-04 06:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `stokmasukdetails`
--

CREATE TABLE `stokmasukdetails` (
  `KodeStokMasuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stokmasukdetails`
--

INSERT INTO `stokmasukdetails` (`KodeStokMasuk`, `KodeItem`, `KodeSatuan`, `Qty`, `Keterangan`, `NoUrut`, `created_at`, `updated_at`, `id`) VALUES
('SLM-21090001', 'BRS-001', 'sak', 1, '-', 0, '2021-09-04 06:40:53', '2021-09-04 06:40:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stokmasuks`
--

CREATE TABLE `stokmasuks` (
  `KodeStokMasuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TotalItem` double NOT NULL,
  `Printed` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stokmasuks`
--

INSERT INTO `stokmasuks` (`KodeStokMasuk`, `KodeLokasi`, `Tanggal`, `Keterangan`, `Status`, `KodeUser`, `TotalItem`, `Printed`, `created_at`, `updated_at`) VALUES
('SLM-21090001', 'GUD-001', '2021-09-04', '-', 'CFM', 'adminlestari', 1, 0, '2021-09-04 06:40:53', '2021-09-04 06:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `KodeSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaSupplier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Handphone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NIK` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Provinsi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Negara` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`KodeSupplier`, `NamaSupplier`, `Kontak`, `Handphone`, `Email`, `NIK`, `Status`, `KodeLokasi`, `KodeUser`, `Alamat`, `Kota`, `Provinsi`, `Negara`, `created_at`, `updated_at`) VALUES
('SUP-001', 'Sport Station', '0341473440', NULL, NULL, NULL, 'OPN', NULL, 'admin', 'Mall Olympic Garden', 'Malang', NULL, NULL, '2021-04-22 02:30:12', '2021-04-22 02:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `suratjalandetails`
--

CREATE TABLE `suratjalandetails` (
  `id` int(11) NOT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `HargaRata` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suratjalanreturndetails`
--

CREATE TABLE `suratjalanreturndetails` (
  `KodeSuratJalanReturnID` int(11) UNSIGNED NOT NULL,
  `KodeSuratJalanReturn` varchar(191) NOT NULL,
  `KodeSuratJalan` varchar(191) DEFAULT NULL,
  `KodeItem` varchar(191) NOT NULL,
  `KodeSatuan` varchar(191) DEFAULT NULL,
  `Harga` double DEFAULT NULL,
  `Qty` int(11) NOT NULL,
  `Keterangan` varchar(191) DEFAULT NULL,
  `NoUrut` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suratjalanreturns`
--

CREATE TABLE `suratjalanreturns` (
  `KodeSuratJalanReturnID` int(11) UNSIGNED NOT NULL,
  `KodeSuratJalanReturn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodeSuratJalanID` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suratjalans`
--

CREATE TABLE `suratjalans` (
  `KodeSuratJalanID` bigint(20) UNSIGNED NOT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoIndeks` int(11) NOT NULL,
  `Alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Kota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AlamatInvoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KotaInvoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeSopir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nopol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TotalItem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeSO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tambahangajians`
--

CREATE TABLE `tambahangajians` (
  `KodeGaji` varchar(191) NOT NULL,
  `Gaji` varchar(10) NOT NULL,
  `JumlahHariKerja` varchar(10) NOT NULL,
  `LemburHarian` varchar(10) NOT NULL,
  `JumlahLemburHarian` varchar(10) NOT NULL,
  `LemburJam` varchar(10) NOT NULL,
  `JumlahLemburJam` varchar(10) NOT NULL,
  `Bonus` varchar(10) NOT NULL,
  `JumlahBonus` varchar(10) NOT NULL,
  `EnkripsiKodeGaji` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `lokasi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_mac_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `fullname`, `email`, `email_verified_at`, `lokasi`, `last_login`, `status`, `password`, `login_mac_address`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'Admin', 'admin@gmail.com', NULL, 'lestari jaya', '2021-09-01 04:41:23', 'OPN', '$2y$10$cNURO2RX4Xbnl2iUDlJLXO3ntAPVvphgJeEUj2BJeYdpr.CrXkkfK', 'B6-D5-BD-CE-AA-90', NULL, '2020-07-13 04:19:32', '2021-09-01 04:41:24'),
(7, 'adminlestari', 'lestari jaya', '-', '0000-00-00 00:00:00', 'lestari jaya', '2021-09-04 03:14:28', 'OPN', '$2y$10$ajqZauw9GD9fQYL.tpeASe7hJWVVfudyfgUNqbhMajOTKyC1x6slK', 'B6-D5-BD-CE-AA-90', 'lWN0YT6AO9s2zRIJRSnvikDnO0DhXBlCTR8DLmjfrgnj9CxXWvxxLjYswgSo', NULL, '2021-09-04 03:14:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alamatpelanggans`
--
ALTER TABLE `alamatpelanggans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailgolongans`
--
ALTER TABLE `detailgolongans`
  ADD PRIMARY KEY (`KodeGolItem`);

--
-- Indexes for table `eventlogs`
--
ALTER TABLE `eventlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gajians`
--
ALTER TABLE `gajians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `golongans`
--
ALTER TABLE `golongans`
  ADD PRIMARY KEY (`KodeGolongan`);

--
-- Indexes for table `invoicehutangdetails`
--
ALTER TABLE `invoicehutangdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoicehutangs`
--
ALTER TABLE `invoicehutangs`
  ADD PRIMARY KEY (`KodeInvoiceHutang`);

--
-- Indexes for table `invoicepiutangdetails`
--
ALTER TABLE `invoicepiutangdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoicepiutangs`
--
ALTER TABLE `invoicepiutangs`
  ADD PRIMARY KEY (`KodeInvoicePiutang`);

--
-- Indexes for table `jabatans`
--
ALTER TABLE `jabatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kasbanks`
--
ALTER TABLE `kasbanks`
  ADD PRIMARY KEY (`KodeKasBankID`);

--
-- Indexes for table `kaslacis`
--
ALTER TABLE `kaslacis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`KodeKategori`);

--
-- Indexes for table `keluarmasukbarangs`
--
ALTER TABLE `keluarmasukbarangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasis`
--
ALTER TABLE `lokasis`
  ADD PRIMARY KEY (`KodeLokasi`);

--
-- Indexes for table `matauangs`
--
ALTER TABLE `matauangs`
  ADD PRIMARY KEY (`KodeMataUang`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`KodePelanggan`);

--
-- Indexes for table `pelunasanhutangs`
--
ALTER TABLE `pelunasanhutangs`
  ADD PRIMARY KEY (`KodePelunasanHutangID`);

--
-- Indexes for table `pelunasanpiutangs`
--
ALTER TABLE `pelunasanpiutangs`
  ADD PRIMARY KEY (`KodePelunasanPiutangID`);

--
-- Indexes for table `pemesananpembeliandetails`
--
ALTER TABLE `pemesananpembeliandetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesananpembelians`
--
ALTER TABLE `pemesananpembelians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesananpenjualans`
--
ALTER TABLE `pemesananpenjualans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `KodeSO` (`KodeSO`) USING BTREE;

--
-- Indexes for table `pemesanan_penjualan_detail`
--
ALTER TABLE `pemesanan_penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaanbarangdetails`
--
ALTER TABLE `penerimaanbarangdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaanbarangreturndetails`
--
ALTER TABLE `penerimaanbarangreturndetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaanbarangreturns`
--
ALTER TABLE `penerimaanbarangreturns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaanbarangs`
--
ALTER TABLE `penerimaanbarangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluarantambahans`
--
ALTER TABLE `pengeluarantambahans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penggunas`
--
ALTER TABLE `penggunas`
  ADD PRIMARY KEY (`KodeUser`);

--
-- Indexes for table `penjualanlangsungdetails`
--
ALTER TABLE `penjualanlangsungdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualanlangsungs`
--
ALTER TABLE `penjualanlangsungs`
  ADD PRIMARY KEY (`KodePenjualanLangsung`);

--
-- Indexes for table `saldos`
--
ALTER TABLE `saldos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`KodeSatuan`);

--
-- Indexes for table `stokkeluars`
--
ALTER TABLE `stokkeluars`
  ADD PRIMARY KEY (`KodeStokKeluar`);

--
-- Indexes for table `suratjalanreturndetails`
--
ALTER TABLE `suratjalanreturndetails`
  ADD PRIMARY KEY (`KodeSuratJalanReturnID`);

--
-- Indexes for table `suratjalanreturns`
--
ALTER TABLE `suratjalanreturns`
  ADD PRIMARY KEY (`KodeSuratJalanReturnID`);

--
-- Indexes for table `suratjalans`
--
ALTER TABLE `suratjalans`
  ADD PRIMARY KEY (`KodeSuratJalanID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamatpelanggans`
--
ALTER TABLE `alamatpelanggans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eventlogs`
--
ALTER TABLE `eventlogs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `invoicehutangdetails`
--
ALTER TABLE `invoicehutangdetails`
  MODIFY `id` int(191) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoicehutangs`
--
ALTER TABLE `invoicehutangs`
  MODIFY `KodeInvoiceHutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoicepiutangdetails`
--
ALTER TABLE `invoicepiutangdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoicepiutangs`
--
ALTER TABLE `invoicepiutangs`
  MODIFY `KodeInvoicePiutang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatans`
--
ALTER TABLE `jabatans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kasbanks`
--
ALTER TABLE `kasbanks`
  MODIFY `KodeKasBankID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `kaslacis`
--
ALTER TABLE `kaslacis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keluarmasukbarangs`
--
ALTER TABLE `keluarmasukbarangs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `pelunasanhutangs`
--
ALTER TABLE `pelunasanhutangs`
  MODIFY `KodePelunasanHutangID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelunasanpiutangs`
--
ALTER TABLE `pelunasanpiutangs`
  MODIFY `KodePelunasanPiutangID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemesananpembeliandetails`
--
ALTER TABLE `pemesananpembeliandetails`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pemesananpembelians`
--
ALTER TABLE `pemesananpembelians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemesananpenjualans`
--
ALTER TABLE `pemesananpenjualans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemesanan_penjualan_detail`
--
ALTER TABLE `pemesanan_penjualan_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penerimaanbarangdetails`
--
ALTER TABLE `penerimaanbarangdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `penerimaanbarangreturndetails`
--
ALTER TABLE `penerimaanbarangreturndetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penerimaanbarangreturns`
--
ALTER TABLE `penerimaanbarangreturns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penerimaanbarangs`
--
ALTER TABLE `penerimaanbarangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengeluarantambahans`
--
ALTER TABLE `pengeluarantambahans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualanlangsungdetails`
--
ALTER TABLE `penjualanlangsungdetails`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saldos`
--
ALTER TABLE `saldos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suratjalanreturndetails`
--
ALTER TABLE `suratjalanreturndetails`
  MODIFY `KodeSuratJalanReturnID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suratjalanreturns`
--
ALTER TABLE `suratjalanreturns`
  MODIFY `KodeSuratJalanReturnID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suratjalans`
--
ALTER TABLE `suratjalans`
  MODIFY `KodeSuratJalanID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
