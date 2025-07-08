-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table canary.absensis
DROP TABLE IF EXISTS `absensis`;
CREATE TABLE IF NOT EXISTS `absensis` (
  `id` bigint(20) unsigned NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalAbsen` date DEFAULT NULL,
  `WaktuAbsen` time DEFAULT NULL,
  `StatusAbsen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.absensis: ~0 rows (approximately)
DELETE FROM `absensis`;
/*!40000 ALTER TABLE `absensis` DISABLE KEYS */;
/*!40000 ALTER TABLE `absensis` ENABLE KEYS */;

-- Dumping structure for table canary.alamatpelanggans
DROP TABLE IF EXISTS `alamatpelanggans`;
CREATE TABLE IF NOT EXISTS `alamatpelanggans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kota` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Provinsi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Negara` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Faks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telepon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoIndeks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.alamatpelanggans: ~0 rows (approximately)
DELETE FROM `alamatpelanggans`;
/*!40000 ALTER TABLE `alamatpelanggans` DISABLE KEYS */;
/*!40000 ALTER TABLE `alamatpelanggans` ENABLE KEYS */;

-- Dumping structure for table canary.alatbayarkasirs
DROP TABLE IF EXISTS `alatbayarkasirs`;
CREATE TABLE IF NOT EXISTS `alatbayarkasirs` (
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

-- Dumping data for table canary.alatbayarkasirs: ~0 rows (approximately)
DELETE FROM `alatbayarkasirs`;
/*!40000 ALTER TABLE `alatbayarkasirs` DISABLE KEYS */;
/*!40000 ALTER TABLE `alatbayarkasirs` ENABLE KEYS */;

-- Dumping structure for table canary.app_menu_user
DROP TABLE IF EXISTS `app_menu_user`;
CREATE TABLE IF NOT EXISTS `app_menu_user` (
  `user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `func` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.app_menu_user: ~0 rows (approximately)
DELETE FROM `app_menu_user`;
/*!40000 ALTER TABLE `app_menu_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_menu_user` ENABLE KEYS */;

-- Dumping structure for table canary.banks
DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `NomorRekening` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaBank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nomor` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.banks: ~0 rows (approximately)
DELETE FROM `banks`;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;

-- Dumping structure for table canary.detailgajians
DROP TABLE IF EXISTS `detailgajians`;
CREATE TABLE IF NOT EXISTS `detailgajians` (
  `KodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeBarang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HargaBarang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JumlahBarang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalHargaBarang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EnkripsiKodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.detailgajians: ~0 rows (approximately)
DELETE FROM `detailgajians`;
/*!40000 ALTER TABLE `detailgajians` DISABLE KEYS */;
/*!40000 ALTER TABLE `detailgajians` ENABLE KEYS */;

-- Dumping structure for table canary.detailgolongans
DROP TABLE IF EXISTS `detailgolongans`;
CREATE TABLE IF NOT EXISTS `detailgolongans` (
  `KodeGolongan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeGolItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaGolItem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HargaGolItem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeGolItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.detailgolongans: ~0 rows (approximately)
DELETE FROM `detailgolongans`;
/*!40000 ALTER TABLE `detailgolongans` DISABLE KEYS */;
/*!40000 ALTER TABLE `detailgolongans` ENABLE KEYS */;

-- Dumping structure for table canary.drivers
DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `KodeDriver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaDriver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.drivers: ~0 rows (approximately)
DELETE FROM `drivers`;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;

-- Dumping structure for table canary.ekspedisis
DROP TABLE IF EXISTS `ekspedisis`;
CREATE TABLE IF NOT EXISTS `ekspedisis` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KodeEkspedisi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NamaEkspedisi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Modal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TarifPelanggan` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table canary.ekspedisis: ~0 rows (approximately)
DELETE FROM `ekspedisis`;
/*!40000 ALTER TABLE `ekspedisis` DISABLE KEYS */;
/*!40000 ALTER TABLE `ekspedisis` ENABLE KEYS */;

-- Dumping structure for table canary.eventlogs
DROP TABLE IF EXISTS `eventlogs`;
CREATE TABLE IF NOT EXISTS `eventlogs` (
  `id` bigint(20) NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam` time NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.eventlogs: ~0 rows (approximately)
DELETE FROM `eventlogs`;
/*!40000 ALTER TABLE `eventlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventlogs` ENABLE KEYS */;

-- Dumping structure for table canary.gajians
DROP TABLE IF EXISTS `gajians`;
CREATE TABLE IF NOT EXISTS `gajians` (
  `id` bigint(20) unsigned NOT NULL,
  `KodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalGaji` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalLemburHarian` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalLemburJam` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalLemburMinggu` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalBonus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SubtotalHargaBarang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TotalGaji` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalGaji` date NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EnkripsiKodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.gajians: ~0 rows (approximately)
DELETE FROM `gajians`;
/*!40000 ALTER TABLE `gajians` DISABLE KEYS */;
/*!40000 ALTER TABLE `gajians` ENABLE KEYS */;

-- Dumping structure for table canary.golongans
DROP TABLE IF EXISTS `golongans`;
CREATE TABLE IF NOT EXISTS `golongans` (
  `KodeGolongan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaGolongan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UangHadir` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LemburHarian` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LemburMinggu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeGolongan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.golongans: ~0 rows (approximately)
DELETE FROM `golongans`;
/*!40000 ALTER TABLE `golongans` DISABLE KEYS */;
/*!40000 ALTER TABLE `golongans` ENABLE KEYS */;

-- Dumping structure for table canary.historihargarata
DROP TABLE IF EXISTS `historihargarata`;
CREATE TABLE IF NOT EXISTS `historihargarata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tanggal` datetime NOT NULL,
  `KodeItem` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HargaRata` double NOT NULL,
  `KodeTransaksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.historihargarata: ~0 rows (approximately)
DELETE FROM `historihargarata`;
/*!40000 ALTER TABLE `historihargarata` DISABLE KEYS */;
/*!40000 ALTER TABLE `historihargarata` ENABLE KEYS */;

-- Dumping structure for table canary.hutangs
DROP TABLE IF EXISTS `hutangs`;
CREATE TABLE IF NOT EXISTS `hutangs` (
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

-- Dumping data for table canary.hutangs: ~0 rows (approximately)
DELETE FROM `hutangs`;
/*!40000 ALTER TABLE `hutangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `hutangs` ENABLE KEYS */;

-- Dumping structure for table canary.invoicehutangdetails
DROP TABLE IF EXISTS `invoicehutangdetails`;
CREATE TABLE IF NOT EXISTS `invoicehutangdetails` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `KodeHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLPB` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Subtotal` double NOT NULL,
  `TotalReturn` double NOT NULL DEFAULT '0',
  `KodeInvoiceHutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.invoicehutangdetails: ~0 rows (approximately)
DELETE FROM `invoicehutangdetails`;
/*!40000 ALTER TABLE `invoicehutangdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoicehutangdetails` ENABLE KEYS */;

-- Dumping structure for table canary.invoicehutangs
DROP TABLE IF EXISTS `invoicehutangs`;
CREATE TABLE IF NOT EXISTS `invoicehutangs` (
  `KodeInvoiceHutang` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeInvoiceHutang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.invoicehutangs: ~0 rows (approximately)
DELETE FROM `invoicehutangs`;
/*!40000 ALTER TABLE `invoicehutangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoicehutangs` ENABLE KEYS */;

-- Dumping structure for table canary.invoicepiutangdetails
DROP TABLE IF EXISTS `invoicepiutangdetails`;
CREATE TABLE IF NOT EXISTS `invoicepiutangdetails` (
  `KodePiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Subtotal` double NOT NULL,
  `TotalReturn` double NOT NULL DEFAULT '0',
  `KodeInvoicePiutang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.invoicepiutangdetails: ~0 rows (approximately)
DELETE FROM `invoicepiutangdetails`;
/*!40000 ALTER TABLE `invoicepiutangdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoicepiutangdetails` ENABLE KEYS */;

-- Dumping structure for table canary.invoicepiutangs
DROP TABLE IF EXISTS `invoicepiutangs`;
CREATE TABLE IF NOT EXISTS `invoicepiutangs` (
  `KodeInvoicePiutang` int(11) NOT NULL AUTO_INCREMENT,
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
  `KodeInvoicePiutangShow` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`KodeInvoicePiutang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.invoicepiutangs: ~0 rows (approximately)
DELETE FROM `invoicepiutangs`;
/*!40000 ALTER TABLE `invoicepiutangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoicepiutangs` ENABLE KEYS */;

-- Dumping structure for table canary.invopnames
DROP TABLE IF EXISTS `invopnames`;
CREATE TABLE IF NOT EXISTS `invopnames` (
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

-- Dumping data for table canary.invopnames: ~0 rows (approximately)
DELETE FROM `invopnames`;
/*!40000 ALTER TABLE `invopnames` DISABLE KEYS */;
/*!40000 ALTER TABLE `invopnames` ENABLE KEYS */;

-- Dumping structure for table canary.itemkonversis
DROP TABLE IF EXISTS `itemkonversis`;
CREATE TABLE IF NOT EXISTS `itemkonversis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Konversi` double NOT NULL,
  `HargaBeli` double NOT NULL,
  `HargaJual` double NOT NULL,
  `HargaMember` double NOT NULL,
  `HargaGrosir` double NOT NULL,
  `Grab` double NOT NULL,
  `Shopee` double NOT NULL,
  `Tokopedia` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.itemkonversis: ~5 rows (approximately)
DELETE FROM `itemkonversis`;
/*!40000 ALTER TABLE `itemkonversis` DISABLE KEYS */;
INSERT INTO `itemkonversis` (`id`, `KodeItem`, `KodeSatuan`, `Konversi`, `HargaBeli`, `HargaJual`, `HargaMember`, `HargaGrosir`, `Grab`, `Shopee`, `Tokopedia`, `created_at`, `updated_at`) VALUES
	(1, 'SNK-001', 'PCS', 1, 10000, 11500, 11000, 12000, 0, 0, 0, '2022-12-10 19:53:18', '2022-12-10 19:53:18'),
	(2, 'SNK-002', 'PCS', 1, 9000, 10500, 10000, 11000, 0, 0, 0, '2022-12-10 19:55:38', '2022-12-10 19:55:38'),
	(3, 'SNK-003', 'PCS', 1, 15000, 17000, 16500, 18000, 0, 0, 0, '2022-12-10 19:56:26', '2022-12-10 19:56:26'),
	(4, 'SNK-004', 'PCS', 1, 20000, 22000, 21500, 23000, 0, 0, 0, '2022-12-10 19:57:54', '2023-01-08 18:36:13'),
	(5, 'MNM-001', 'PCS', 1, 9500, 11000, 10500, 10500, 0, 0, 0, '2023-01-29 21:18:36', '2023-01-29 21:28:22');
/*!40000 ALTER TABLE `itemkonversis` ENABLE KEYS */;

-- Dumping structure for table canary.items
DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeRak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKategori` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Alias` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenisitem` enum('bahanbaku','bahanjadi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BatasBawah` double NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalExp` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.items: ~5 rows (approximately)
DELETE FROM `items`;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`ID`, `KodeItem`, `KodeRak`, `Barcode`, `KodeKategori`, `NamaItem`, `Alias`, `jenisitem`, `Keterangan`, `Status`, `BatasBawah`, `KodeUser`, `TanggalExp`, `created_at`, `updated_at`) VALUES
	(1, 'SNK-001', 'Rak-001', 'SNK-001', 'KLA-001', 'Barang A', '-', 'bahanjadi', '-', 'OPN', 0, 'admin', NULL, '2022-12-10 19:53:18', '2022-12-10 19:53:18'),
	(2, 'SNK-002', 'Rak-001', 'SNK-002', 'KLA-001', 'Barang B', '-', 'bahanjadi', '-', 'OPN', 0, 'admin', NULL, '2022-12-10 19:55:38', '2022-12-10 19:55:38'),
	(3, 'SNK-003', 'Rak-001', 'SNK-003', 'KLA-001', 'Barang c', '-', 'bahanjadi', '-', 'OPN', 0, 'admin', NULL, '2022-12-10 19:56:26', '2022-12-10 19:56:26'),
	(4, 'SNK-004', 'Rak-001', 'SNK-004', 'KLA-001', 'Barang D', '-', 'bahanjadi', '-', 'OPN', 0, 'admin', NULL, '2022-12-10 19:57:54', '2023-01-08 18:36:13'),
	(5, 'MNM-001', 'Rak-001', 'MNM-001', 'KLA-003', 'Barang E', '-', 'bahanjadi', '-', 'OPN', 0, 'admin', NULL, '2023-01-29 21:18:36', '2023-01-29 21:28:22');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;

-- Dumping structure for table canary.jabatans
DROP TABLE IF EXISTS `jabatans`;
CREATE TABLE IF NOT EXISTS `jabatans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `KodeJabatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KeteranganJabatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.jabatans: ~0 rows (approximately)
DELETE FROM `jabatans`;
/*!40000 ALTER TABLE `jabatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `jabatans` ENABLE KEYS */;

-- Dumping structure for table canary.jenisbayars
DROP TABLE IF EXISTS `jenisbayars`;
CREATE TABLE IF NOT EXISTS `jenisbayars` (
  `KodeJenisBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JenisBayar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.jenisbayars: ~0 rows (approximately)
DELETE FROM `jenisbayars`;
/*!40000 ALTER TABLE `jenisbayars` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenisbayars` ENABLE KEYS */;

-- Dumping structure for table canary.karyawans
DROP TABLE IF EXISTS `karyawans`;
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.karyawans: ~7 rows (approximately)
DELETE FROM `karyawans`;
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
INSERT INTO `karyawans` (`id`, `KodeKaryawan`, `Nama`, `Alamat`, `Kota`, `Telepon`, `JenisKelamin`, `KodeUser`, `Status`, `GajiPokok`, `KodeJabatan`, `KodeGolongan`, `created_at`, `updated_at`) VALUES
	(3, 'KAR-001', 'bang', 'Jln Dieng', 'MALANG', '-', 'Laki-laki', 'admin', 'DEL', '0', 'Sales', 'GOL-01', '2022-01-27 10:58:25', '2022-01-27 11:05:58'),
	(4, 'KAR-001', 'HANIFAH', '-', 'MALANG', '-', 'Perempuan', 'admin', 'OPN', '0', 'KASIR', 'GOL-01', '2022-02-28 11:26:59', '2022-02-28 11:26:59'),
	(5, 'KAR-002', 'IIS', '-', 'MALANG', '-', 'Perempuan', 'admin', 'OPN', '0', 'DIGITAL MARKETING', 'GOL-01', '2022-02-28 11:27:37', '2022-02-28 11:27:37'),
	(6, 'KAR-003', 'ISNA', '-', 'MALANG', '-', 'Perempuan', 'admin', 'OPN', '0', 'ADM,GUDANG', 'GOL-01', '2022-02-28 11:28:15', '2022-02-28 11:28:15'),
	(7, 'KAR-004', 'SHERLY', '-', 'MALANG', '-', 'Perempuan', 'admin', 'OPN', '0', 'KASIR', 'GOL-01', '2022-02-28 11:28:39', '2022-02-28 11:28:39'),
	(8, 'KAR-005', '-', '-', 'malang', '0', 'Laki-laki', 'KASIR', 'OPN', '0', 'Driver', 'GOL-01', '2022-10-22 18:39:04', '2022-10-22 18:39:04'),
	(9, 'KAR-006', 'SALES A', 'MALANG', 'MALANG', '0', 'Perempuan', 'admin', 'OPN', '0', 'Sales', 'GOL-01', '2023-01-29 21:47:52', '2023-01-29 21:47:52');
/*!40000 ALTER TABLE `karyawans` ENABLE KEYS */;

-- Dumping structure for table canary.kasbanks
DROP TABLE IF EXISTS `kasbanks`;
CREATE TABLE IF NOT EXISTS `kasbanks` (
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
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KodeKasBankID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`KodeKasBankID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kasbanks: ~0 rows (approximately)
DELETE FROM `kasbanks`;
/*!40000 ALTER TABLE `kasbanks` DISABLE KEYS */;
/*!40000 ALTER TABLE `kasbanks` ENABLE KEYS */;

-- Dumping structure for table canary.kasirdetails
DROP TABLE IF EXISTS `kasirdetails`;
CREATE TABLE IF NOT EXISTS `kasirdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeKasir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `HargaRata` double NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kasirdetails: ~0 rows (approximately)
DELETE FROM `kasirdetails`;
/*!40000 ALTER TABLE `kasirdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `kasirdetails` ENABLE KEYS */;

-- Dumping structure for table canary.kasirreturndetails
DROP TABLE IF EXISTS `kasirreturndetails`;
CREATE TABLE IF NOT EXISTS `kasirreturndetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeKasirReturn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKasir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Harga` double NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kasirreturndetails: ~0 rows (approximately)
DELETE FROM `kasirreturndetails`;
/*!40000 ALTER TABLE `kasirreturndetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `kasirreturndetails` ENABLE KEYS */;

-- Dumping structure for table canary.kasirreturns
DROP TABLE IF EXISTS `kasirreturns`;
CREATE TABLE IF NOT EXISTS `kasirreturns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeKasirReturn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKasir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `Total` double NOT NULL,
  `Printed` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kasirreturns: ~0 rows (approximately)
DELETE FROM `kasirreturns`;
/*!40000 ALTER TABLE `kasirreturns` DISABLE KEYS */;
/*!40000 ALTER TABLE `kasirreturns` ENABLE KEYS */;

-- Dumping structure for table canary.kasirs
DROP TABLE IF EXISTS `kasirs`;
CREATE TABLE IF NOT EXISTS `kasirs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeKasir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `Bayar` double NOT NULL,
  `Kembalian` double NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kasirs: ~0 rows (approximately)
DELETE FROM `kasirs`;
/*!40000 ALTER TABLE `kasirs` DISABLE KEYS */;
/*!40000 ALTER TABLE `kasirs` ENABLE KEYS */;

-- Dumping structure for table canary.kaslacis
DROP TABLE IF EXISTS `kaslacis`;
CREATE TABLE IF NOT EXISTS `kaslacis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Tanggal` date NOT NULL,
  `Nominal` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Transaksi` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SaldoLaci` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kaslacis: ~0 rows (approximately)
DELETE FROM `kaslacis`;
/*!40000 ALTER TABLE `kaslacis` DISABLE KEYS */;
INSERT INTO `kaslacis` (`id`, `Tanggal`, `Nominal`, `Transaksi`, `SaldoLaci`, `Status`, `updated_at`, `KodeUser`) VALUES
	(1, '2022-04-18', '500000', 'Masuk', '500000', 'CLS', '2022-04-18 11:16:48', 'KASIR');
/*!40000 ALTER TABLE `kaslacis` ENABLE KEYS */;

-- Dumping structure for table canary.kategoris
DROP TABLE IF EXISTS `kategoris`;
CREATE TABLE IF NOT EXISTS `kategoris` (
  `KodeKategori` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaKategori` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItemAwal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeKategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.kategoris: ~0 rows (approximately)
DELETE FROM `kategoris`;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;

-- Dumping structure for table canary.keluarmasukbarangs
DROP TABLE IF EXISTS `keluarmasukbarangs`;
CREATE TABLE IF NOT EXISTS `keluarmasukbarangs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `saldo` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.keluarmasukbarangs: ~0 rows (approximately)
DELETE FROM `keluarmasukbarangs`;
/*!40000 ALTER TABLE `keluarmasukbarangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `keluarmasukbarangs` ENABLE KEYS */;

-- Dumping structure for table canary.koreksigajians
DROP TABLE IF EXISTS `koreksigajians`;
CREATE TABLE IF NOT EXISTS `koreksigajians` (
  `KodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kekurangan` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kelebihan` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.koreksigajians: ~0 rows (approximately)
DELETE FROM `koreksigajians`;
/*!40000 ALTER TABLE `koreksigajians` DISABLE KEYS */;
/*!40000 ALTER TABLE `koreksigajians` ENABLE KEYS */;

-- Dumping structure for table canary.lokasiitems
DROP TABLE IF EXISTS `lokasiitems`;
CREATE TABLE IF NOT EXISTS `lokasiitems` (
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Konversi` double NOT NULL,
  `HargaRata` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.lokasiitems: ~0 rows (approximately)
DELETE FROM `lokasiitems`;
/*!40000 ALTER TABLE `lokasiitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `lokasiitems` ENABLE KEYS */;

-- Dumping structure for table canary.lokasis
DROP TABLE IF EXISTS `lokasis`;
CREATE TABLE IF NOT EXISTS `lokasis` (
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeLokasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.lokasis: ~0 rows (approximately)
DELETE FROM `lokasis`;
/*!40000 ALTER TABLE `lokasis` DISABLE KEYS */;
/*!40000 ALTER TABLE `lokasis` ENABLE KEYS */;

-- Dumping structure for table canary.matauangs
DROP TABLE IF EXISTS `matauangs`;
CREATE TABLE IF NOT EXISTS `matauangs` (
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nilai` double NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeMataUang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.matauangs: ~0 rows (approximately)
DELETE FROM `matauangs`;
/*!40000 ALTER TABLE `matauangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `matauangs` ENABLE KEYS */;

-- Dumping structure for table canary.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table canary.ongkirs
DROP TABLE IF EXISTS `ongkirs`;
CREATE TABLE IF NOT EXISTS `ongkirs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Kode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Modal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TarifPelanggan` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.ongkirs: ~0 rows (approximately)
DELETE FROM `ongkirs`;
/*!40000 ALTER TABLE `ongkirs` DISABLE KEYS */;
/*!40000 ALTER TABLE `ongkirs` ENABLE KEYS */;

-- Dumping structure for table canary.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table canary.pelanggans
DROP TABLE IF EXISTS `pelanggans`;
CREATE TABLE IF NOT EXISTS `pelanggans` (
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodePelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pelanggans: ~355 rows (approximately)
DELETE FROM `pelanggans`;
/*!40000 ALTER TABLE `pelanggans` DISABLE KEYS */;
INSERT INTO `pelanggans` (`KodePelanggan`, `NamaPelanggan`, `Kontak`, `Handphone`, `Email`, `NIK`, `NPWP`, `LimitPiutang`, `Diskon`, `Status`, `KodeLokasi`, `KodeUser`, `created_at`, `updated_at`) VALUES
	('PLG-001', 'AMELIA', '0838-3457-8700', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 13:15:24', '2022-01-22 13:15:24'),
	('PLG-002', 'ANE', '0816-556-777', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:12:44', '2022-01-22 14:12:44'),
	('PLG-003', 'ANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:16:12', '2022-01-22 14:16:12'),
	('PLG-004', 'AMY', '0812-3333-2744', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:20:49', '2022-01-22 14:20:49'),
	('PLG-005', 'CINDY', '0812-3366-6895', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:32:53', '2022-01-22 14:32:53'),
	('PLG-006', 'KRISTIN', '0858-5377-6478', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:34:56', '2022-01-22 14:34:56'),
	('PLG-007', 'DESINITA', '0899-0335-111', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:36:13', '2022-01-22 14:36:13'),
	('PLG-008', 'DJANUJI', '0812-1712-3410', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:37:23', '2022-01-22 14:37:23'),
	('PLG-009', 'EKA', '0818-383-564', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:39:09', '2022-01-22 14:39:09'),
	('PLG-010', 'ERNI', '0812-3382-401', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:41:28', '2022-01-22 14:41:28'),
	('PLG-011', 'ERNA/SY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:42:13', '2022-01-22 14:42:13'),
	('PLG-012', 'EVELINE', '0812-5981-5889', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:43:24', '2022-01-22 14:43:24'),
	('PLG-013', 'EVI', '0816-552-218', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:45:32', '2022-01-22 14:45:32'),
	('PLG-014', 'FABE', '0812-3539-040', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:46:47', '2022-01-22 14:46:47'),
	('PLG-015', 'FEFE', '0812-5270-316', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:57:56', '2022-01-22 14:57:56'),
	('PLG-016', 'FELANI', '0811-350-579', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 14:59:19', '2022-01-22 14:59:19'),
	('PLG-017', 'FELI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 15:00:43', '2022-01-22 15:00:43'),
	('PLG-018', 'FELICIA', '0815-1606-232', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 15:01:52', '2022-01-22 15:01:52'),
	('PLG-019', 'GINA', '0811-362-727', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 15:02:43', '2022-01-22 15:02:43'),
	('PLG-020', 'GO', '0818-380-816', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 15:04:05', '2022-01-22 15:04:05'),
	('PLG-021', 'IN IN', '0811-366-890', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-01-22 15:07:02', '2022-06-20 17:48:24'),
	('PLG-022', 'INDIRA', '0812-3521-048', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 15:08:07', '2022-01-22 15:08:07'),
	('PLG-023', 'INDRAWATI', '0812-3367-818', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-22 15:10:43', '2022-01-22 15:10:43'),
	('PLG-024', 'IVONE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:39:18', '2022-01-23 10:39:18'),
	('PLG-025', 'JANI', '0812-5251-818', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:40:34', '2022-01-23 10:40:34'),
	('PLG-026', 'JANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:42:03', '2022-01-23 10:42:03'),
	('PLG-027', 'JING JING', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:42:39', '2022-01-23 10:42:39'),
	('PLG-028', 'JOICE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:43:14', '2022-01-23 10:43:14'),
	('PLG-029', 'KARTIKA', '0821-3983-6658', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:44:02', '2022-01-23 10:44:02'),
	('PLG-030', 'KELIK', '0813-3358-8998', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:44:57', '2022-01-23 10:44:57'),
	('PLG-031', 'KRISTANTO', '0822-3465-3857', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:47:38', '2022-01-23 10:47:38'),
	('PLG-032', 'KRISTIN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:48:27', '2022-01-23 10:48:27'),
	('PLG-033', 'LANI', '0838-4841-4631', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:49:29', '2022-01-23 10:49:29'),
	('PLG-034', 'LELI', '0851-0149-5300', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:51:44', '2022-01-23 10:51:44'),
	('PLG-035', 'LIA', '0822-3077-8800', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:52:45', '2022-01-23 10:52:45'),
	('PLG-036', 'LICEN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:53:35', '2022-01-23 10:53:35'),
	('PLG-037', 'LIE HWA', '0818-380-667', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:54:23', '2022-01-23 10:54:23'),
	('PLG-038', 'LILY SAKTI', '0816-551-409', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:55:27', '2022-01-23 10:55:27'),
	('PLG-039', 'LILY TJ', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:56:01', '2022-01-23 10:56:01'),
	('PLG-040', 'LINDA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:56:56', '2022-01-23 10:56:56'),
	('PLG-041', 'LINDA ARBANAT', '0811-365-220', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:57:54', '2022-01-23 10:57:54'),
	('PLG-042', 'LINDA JNE', '0812-3580-606', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 10:58:59', '2022-01-23 10:58:59'),
	('PLG-043', 'LINDA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:01:50', '2022-01-23 11:01:50'),
	('PLG-044', 'LIDYA', '0812-3300-080', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:02:41', '2022-01-23 11:02:41'),
	('PLG-045', 'LISA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:03:24', '2022-01-23 11:03:24'),
	('PLG-046', 'LITA', '0817-0522-889', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:04:21', '2022-01-23 11:04:21'),
	('PLG-047', 'LIU / SILVYA RAJA RAJA', '0877-5980-5055', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:05:11', '2022-01-23 11:05:11'),
	('PLG-048', 'LUCIA', '0818-717-291', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:05:58', '2022-01-23 11:05:58'),
	('PLG-049', 'LUSI', '0858-5127-5161', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:06:48', '2022-01-23 11:06:48'),
	('PLG-050', 'LUSI', '0811-368-768', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:13:09', '2022-01-23 11:13:09'),
	('PLG-051', 'LITA', '0811-3776-000', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 11:14:36', '2022-01-23 11:14:36'),
	('PLG-052', 'MAMA NOLAN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:01:15', '2022-01-23 12:01:15'),
	('PLG-053', 'MAMI MEDI', '0811-363-880', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:02:11', '2022-01-23 12:02:11'),
	('PLG-054', 'MARIAM', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:02:37', '2022-01-23 12:02:37'),
	('PLG-055', 'MAADY', '0818-517-990', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:05:08', '2022-01-23 12:05:08'),
	('PLG-056', 'MEY HWA', '0811-369-397', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:06:03', '2022-01-23 12:06:03'),
	('PLG-057', 'MELA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:07:09', '2022-01-23 12:07:09'),
	('PLG-058', 'MELANI SWEETY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:07:45', '2022-01-23 12:07:45'),
	('PLG-059', 'MEME', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:08:57', '2022-01-23 12:08:57'),
	('PLG-060', 'MINA', '0878-2525-1108', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:09:40', '2022-01-23 12:09:40'),
	('PLG-061', 'MINGFE', '0818-531-112', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:11:17', '2022-01-23 12:11:17'),
	('PLG-062', 'MEYTA', '0812-3310-230', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:12:11', '2022-01-23 12:12:11'),
	('PLG-063', 'MILLY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:12:50', '2022-01-23 12:12:50'),
	('PLG-064', 'NANCY', '0895-6304-55099', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:13:45', '2022-01-23 12:13:45'),
	('PLG-065', 'NANCY', '0822-4516-7722', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:14:54', '2022-01-23 12:14:54'),
	('PLG-066', 'NANIK', '0821-4349-0789', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:16:48', '2022-01-23 12:16:48'),
	('PLG-067', 'NISA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:17:46', '2022-01-23 12:17:46'),
	('PLG-068', 'NOBEL', '0817-197-697', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-23 12:18:35', '2022-01-23 12:18:35'),
	('PLG-069', 'NOVI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 12:56:20', '2022-01-24 12:56:20'),
	('PLG-070', 'ODELIA', '0858-1509-0200', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 12:57:18', '2022-01-24 12:57:18'),
	('PLG-071', 'DR.RAHMA', '0817-5407-889', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 12:58:24', '2022-01-24 12:58:24'),
	('PLG-072', 'RAMZIAH', '0812-3438-4695', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 13:05:07', '2022-01-24 13:05:07'),
	('PLG-073', 'RATNA', '0812-3300-838', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 13:05:49', '2022-01-24 13:05:49'),
	('PLG-074', 'RENA', '0812-3430-0431', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 13:06:28', '2022-01-24 13:06:28'),
	('PLG-075', 'SANTI', '0819-5006-798', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 13:07:15', '2022-01-24 13:07:15'),
	('PLG-076', 'SANTOSO', '0816-4292-241', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 13:08:12', '2022-01-24 13:08:12'),
	('PLG-077', 'SERAFINE', '0811-303-028', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 13:13:11', '2022-01-24 13:13:11'),
	('PLG-078', 'SHERLY', '0856-4673-0125', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:14:31', '2022-01-24 14:14:31'),
	('PLG-079', 'SHIANG', '0813-3312-3458', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:15:59', '2022-01-24 14:15:59'),
	('PLG-080', 'SINTA', '0852-2858-0999', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:18:19', '2022-01-24 14:18:19'),
	('PLG-081', 'SOFIE', '0812-3040-0050', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:20:13', '2022-01-24 14:20:13'),
	('PLG-082', 'STEVANUS', '0896-8293-4595', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:21:09', '2022-01-24 14:21:09'),
	('PLG-083', 'SULI', '0812-5291-937', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:22:24', '2022-01-24 14:22:24'),
	('PLG-084', 'SUSAN', '0896-9674-3589', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:24:06', '2022-01-24 14:24:06'),
	('PLG-085', 'SHURYANTI', '0816-981-111', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:27:12', '2022-01-24 14:27:12'),
	('PLG-086', 'SWEE', '0816-981-111', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:30:32', '2022-01-24 14:30:32'),
	('PLG-087', 'SIOK', '0813-3443-9157', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 14:33:08', '2022-01-24 14:33:08'),
	('PLG-088', 'TINIK', '0812-3580-7670', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:02:48', '2022-01-24 15:02:48'),
	('PLG-089', 'TUTI', '0816-550-294', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:03:53', '2022-01-24 15:03:53'),
	('PLG-090', 'VERA', '0816-550-294', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:07:11', '2022-01-24 15:07:11'),
	('PLG-091', 'VINA', '0818-531-725', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:07:57', '2022-01-24 15:07:57'),
	('PLG-092', 'WANDA', '0899-1348-428', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:08:50', '2022-01-24 15:08:50'),
	('PLG-093', 'WIDYA', '0818-388-087', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:10:45', '2022-01-24 15:10:45'),
	('PLG-094', 'WINNA', '0811-4166-689', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:11:32', '2022-01-24 15:11:32'),
	('PLG-095', 'YENI ARAYA', '0811-303-533', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:12:32', '2022-01-24 15:12:32'),
	('PLG-096', 'YENI CAKE', '0812-3390-287', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:13:35', '2022-01-24 15:13:35'),
	('PLG-097', 'YULAN', '0812-3233-029', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:14:22', '2022-01-24 15:14:22'),
	('PLG-098', 'YULI SAYUR', '0859-5450-0687', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:15:16', '2022-01-24 15:15:16'),
	('PLG-099', 'YULIANA', '0812-3450-1270', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:16:29', '2022-01-24 15:16:29'),
	('PLG-100', 'VIRGIN', '0817-312-617', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:18:58', '2022-01-24 15:18:58'),
	('PLG-101', 'VIVI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:19:53', '2022-01-24 15:19:53'),
	('PLG-102', 'DIANA', '0819-4531-2888', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:21:06', '2022-01-24 15:21:06'),
	('PLG-103', 'JORDAN', '0877-5972-0777', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:22:03', '2022-01-24 15:22:03'),
	('PLG-104', 'MEGA', '0819-4550-8224', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:22:40', '2022-01-24 15:22:40'),
	('PLG-105', 'AI KRISTIN', '0823-2730-2324', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:23:26', '2022-01-24 15:23:26'),
	('PLG-106', 'NIKEN', '0812-1567-7166', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-01-24 15:50:04', '2022-01-24 15:50:04'),
	('PLG-107', 'ROSITA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-02 09:16:51', '2022-03-02 09:16:51'),
	('PLG-108', 'JANI/YANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-02 11:36:49', '2022-03-02 11:36:49'),
	('PLG-109', 'JSOY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-02 11:47:49', '2022-03-02 11:47:49'),
	('PLG-110', 'PB', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-02 11:52:37', '2022-03-04 12:23:22'),
	('PLG-111', 'FENI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-07 18:02:32', '2022-03-07 18:02:32'),
	('PLG-112', 'GOJEK', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-07 18:18:48', '2022-03-07 18:18:48'),
	('PLG-113', 'GRAB', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-07 18:19:05', '2022-03-07 18:19:05'),
	('PLG-114', 'MISS ANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-07 18:26:41', '2022-03-07 18:26:41'),
	('PLG-115', 'SELVIA WLINGI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-08 19:16:57', '2022-03-08 19:16:57'),
	('PLG-116', 'SUSANA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 07:27:17', '2022-03-09 07:27:17'),
	('PLG-117', 'Melani Telur', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 08:08:10', '2022-03-09 08:08:10'),
	('PLG-118', 'MR.CANDRA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 08:59:30', '2022-03-09 08:59:30'),
	('PLG-119', 'LIN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 09:04:13', '2022-03-09 09:04:13'),
	('PLG-120', 'SHERLY TRS', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 10:02:28', '2022-03-09 10:02:28'),
	('PLG-121', 'CIK LIDYA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 15:51:45', '2022-03-09 15:51:45'),
	('PLG-122', 'RUDI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 15:53:30', '2022-03-09 15:53:30'),
	('PLG-123', 'RESS TAZZA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 16:14:24', '2022-03-09 16:14:24'),
	('PLG-124', 'OM TUK', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 16:20:13', '2022-03-09 16:20:13'),
	('PLG-125', 'RESS ANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 16:50:49', '2022-03-09 16:50:49'),
	('PLG-126', 'MEME', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 17:12:10', '2022-03-09 17:12:10'),
	('PLG-127', 'Roza', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 17:39:10', '2022-03-09 17:39:10'),
	('PLG-128', 'Rozi', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 17:39:50', '2022-03-09 17:39:50'),
	('PLG-129', 'STAFF', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-09 17:42:55', '2022-03-09 17:42:55'),
	('PLG-130', 'DIENG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-10 10:19:11', '2022-03-10 10:19:11'),
	('PLG-131', 'DR.IMEL', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 08:45:49', '2022-03-11 08:45:49'),
	('PLG-132', 'LILY CATERING', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 10:35:30', '2022-03-11 10:35:30'),
	('PLG-133', 'RITA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 10:39:45', '2022-03-11 10:39:45'),
	('PLG-134', 'MISS ELSA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 11:04:48', '2022-03-11 11:04:48'),
	('PLG-135', 'OM YOHANES', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 11:13:06', '2022-03-11 11:13:06'),
	('PLG-136', 'RESS MELAN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 15:12:33', '2022-03-11 15:12:33'),
	('PLG-137', 'LIENA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 15:13:16', '2022-03-11 15:13:16'),
	('PLG-138', 'RESS MECU', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 15:14:03', '2022-03-11 15:14:03'),
	('PLG-139', 'NINIK', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 15:31:09', '2022-03-11 15:31:09'),
	('PLG-140', 'SUPINARTI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 16:14:36', '2022-03-11 16:14:36'),
	('PLG-141', 'MISS MELLY', '-', NULL, NULL, '0', '0', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 17:01:15', '2022-03-11 17:01:15'),
	('PLG-142', 'BU MARTA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 18:23:15', '2022-03-11 18:23:15'),
	('PLG-143', 'OCEAN GARDEN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 18:33:55', '2022-03-11 18:33:55'),
	('PLG-144', 'LENI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-11 18:46:13', '2022-03-11 18:46:13'),
	('PLG-145', 'BUNDA PUJI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-12 14:34:33', '2022-03-12 14:34:33'),
	('PLG-146', 'YOGA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-12 14:46:28', '2022-03-12 14:46:28'),
	('PLG-147', 'RESS DEVI', '0', NULL, NULL, '0', '0', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-12 16:02:54', '2022-03-12 16:02:54'),
	('PLG-148', 'BU VERO PILAR', '0', NULL, NULL, '0', '0', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-12 16:08:36', '2022-03-12 16:08:36'),
	('PLG-149', 'LILY VPT', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-12 16:39:32', '2022-03-12 16:39:32'),
	('PLG-150', 'CE SILVI', '0', NULL, NULL, '0', '0', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-13 13:45:05', '2022-03-13 13:45:05'),
	('PLG-151', 'SELINA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-14 11:59:45', '2022-03-14 11:59:45'),
	('PLG-152', 'FEBRY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-14 15:06:07', '2022-03-14 15:06:07'),
	('PLG-153', 'P.ABI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-15 09:51:58', '2022-03-15 09:51:58'),
	('PLG-154', 'IRENE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-15 09:52:37', '2022-03-15 09:52:37'),
	('PLG-155', 'CABANG BLITAR', '085755727018', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-15 10:25:40', '2022-03-15 10:25:40'),
	('PLG-156', 'GIOK LAN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-15 14:16:48', '2022-03-15 14:16:48'),
	('PLG-157', 'Bu Mely', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-17 11:54:31', '2022-03-17 11:54:31'),
	('PLG-158', 'Alens FROZEN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-17 14:02:44', '2022-03-17 14:02:44'),
	('PLG-159', 'LIN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-18 14:12:20', '2022-03-18 14:12:20'),
	('PLG-160', 'GONDO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-18 14:29:26', '2022-03-18 14:29:26'),
	('PLG-161', 'TESSA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-19 09:07:07', '2022-03-19 09:07:07'),
	('PLG-162', 'INDAH', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-19 12:21:17', '2022-03-19 12:21:17'),
	('PLG-163', 'MAMA YUNITA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-22 17:09:35', '2022-03-22 17:09:35'),
	('PLG-164', 'RULLY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-23 11:10:02', '2022-03-23 11:10:02'),
	('PLG-165', 'YANE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-25 11:12:21', '2022-03-25 11:12:21'),
	('PLG-166', 'MISS ITA', '0', NULL, NULL, '0', '0', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-26 12:28:01', '2022-03-26 12:28:01'),
	('PLG-167', 'DIFA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-28 11:32:58', '2022-03-28 11:32:58'),
	('PLG-168', 'YULIA KITCHEN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-28 11:34:36', '2022-03-28 11:34:36'),
	('PLG-169', 'P.DICKY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-28 13:27:08', '2022-03-28 13:27:08'),
	('PLG-170', 'RESS INDAH', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-28 16:11:40', '2022-03-28 16:11:40'),
	('PLG-171', 'P.EKO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-03-29 09:04:32', '2022-03-29 09:04:32'),
	('PLG-172', 'VIVI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-01 13:38:51', '2022-04-01 13:38:51'),
	('PLG-173', 'BU NING', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-02 10:15:38', '2022-04-02 10:15:38'),
	('PLG-174', 'RESS.MELIAWATI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-02 10:29:52', '2022-04-02 10:29:52'),
	('PLG-175', 'SEBLAK PRANK', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-02 10:31:48', '2022-04-02 10:31:48'),
	('PLG-176', 'RESS.LULU', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-02 12:55:33', '2022-04-02 12:55:33'),
	('PLG-177', 'SUGIANTO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-02 13:35:10', '2022-04-02 13:35:10'),
	('PLG-178', 'Ocean Garden', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-05 11:02:56', '2022-04-05 11:02:56'),
	('PLG-179', 'ERVINA FB', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-06 15:27:13', '2022-04-06 15:27:13'),
	('PLG-180', 'RESS ANA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-06 15:42:33', '2022-04-06 15:42:33'),
	('PLG-181', 'RETNO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-07 10:28:34', '2022-04-07 10:28:34'),
	('PLG-182', 'WINA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-08 08:06:57', '2022-04-08 08:06:57'),
	('PLG-183', 'RESS DIAN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-08 14:50:59', '2022-04-08 14:50:59'),
	('PLG-184', 'SILVI/MAMAMIA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-08 14:56:12', '2022-04-08 14:56:12'),
	('PLG-185', 'SHOPEE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-08 15:15:39', '2022-04-08 15:15:39'),
	('PLG-186', 'MEYSA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-11 14:07:49', '2022-04-11 14:07:49'),
	('PLG-187', 'AGNES IG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-13 11:14:22', '2022-04-13 11:14:22'),
	('PLG-188', 'CV SAKTI PUTRA PERDANA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-25 09:20:00', '2022-04-25 09:20:00'),
	('PLG-189', 'IBU LISMA/P.RIZKY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-26 13:01:57', '2022-05-12 14:56:27'),
	('PLG-190', 'NURMA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-28 09:10:08', '2022-04-28 09:10:08'),
	('PLG-191', 'ENY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-28 09:54:58', '2022-04-28 09:54:58'),
	('PLG-192', 'BU IN IN', '082132346520', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-28 12:15:43', '2022-04-28 12:15:43'),
	('PLG-193', 'ANITA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-28 14:03:42', '2022-04-28 14:03:42'),
	('PLG-194', 'MISS PENTA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-28 15:00:22', '2022-04-28 15:00:22'),
	('PLG-195', 'NANDA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-28 15:36:31', '2022-04-28 15:36:31'),
	('PLG-196', 'RESS PENI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-29 09:05:08', '2022-04-29 09:05:08'),
	('PLG-197', 'ANA EY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-29 09:31:37', '2022-04-29 09:31:37'),
	('PLG-198', 'PAK MONA', '0816-550-294', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-29 10:49:24', '2022-04-29 10:49:24'),
	('PLG-199', 'LIDYA FB', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-29 13:21:32', '2022-04-29 13:21:32'),
	('PLG-200', 'RINI FB', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-29 14:59:15', '2022-04-29 14:59:15'),
	('PLG-201', 'FEBE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-30 08:47:28', '2022-04-30 08:47:28'),
	('PLG-202', 'RESS RETNO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-30 09:34:39', '2022-04-30 09:34:39'),
	('PLG-203', 'RISKA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-30 09:56:14', '2022-04-30 09:56:14'),
	('PLG-204', 'CABANG LAWANG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-30 11:16:17', '2022-04-30 11:16:17'),
	('PLG-205', 'GITA', '085785055201', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-30 13:59:36', '2022-04-30 13:59:36'),
	('PLG-206', 'OM IVAN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-04-30 16:00:29', '2022-04-30 16:00:29'),
	('PLG-207', 'MEGA', 'JL.SIMP.BOROBUDUR UTARA 4 NO.2A', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-07 08:36:27', '2022-05-07 08:36:27'),
	('PLG-208', 'RIZKY FB', '0821-4334-3424', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-07 08:52:28', '2022-05-07 08:52:28'),
	('PLG-209', 'B.SIGIT', '0815-5374-9401', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-08 08:15:24', '2022-05-08 08:15:24'),
	('PLG-210', 'INDAH', '085720822216', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-08 09:09:59', '2022-05-08 09:09:59'),
	('PLG-211', 'B.LUKY', '081703778194', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-08 10:05:41', '2022-05-08 10:05:41'),
	('PLG-212', 'MELLY', '0851-0500-1729', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-09 09:03:39', '2022-05-09 09:03:39'),
	('PLG-213', 'AILEN', '0895-4110-65089', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-09 11:27:33', '2022-05-09 11:27:33'),
	('PLG-214', 'STEVANI', '0812-3095-9630', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-09 11:50:49', '2022-05-09 11:50:49'),
	('PLG-215', 'NOVI', '0858-1549-0602', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-09 14:58:17', '2022-05-09 14:58:17'),
	('PLG-216', 'SISKA FB', '0857-1500-2715', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 08:41:56', '2022-05-10 08:41:56'),
	('PLG-217', 'MELINI WIJOYO', '0811-3615-455', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 09:24:22', '2022-05-10 09:24:22'),
	('PLG-218', 'OM DEDY', '082194603960', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 13:17:15', '2022-05-10 13:17:15'),
	('PLG-219', 'OM HALIM', '0818385519', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 13:28:05', '2022-05-10 13:28:05'),
	('PLG-220', 'NIKE', '081233457676', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 13:28:55', '2022-05-10 13:28:55'),
	('PLG-221', 'MISS IKA', '085701521177', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 14:23:16', '2022-05-10 14:23:16'),
	('PLG-222', 'IRMA IG', '0822-2651-5352', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 14:24:38', '2022-05-10 14:24:38'),
	('PLG-223', 'RENI', '081330770009', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-10 16:44:23', '2022-05-10 16:44:23'),
	('PLG-224', 'BU.VICKY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-11 08:22:31', '2022-05-11 08:22:31'),
	('PLG-225', 'SBS CAFE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-11 08:49:45', '2022-05-11 08:49:45'),
	('PLG-226', 'AULIA', '085155217759', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-11 10:25:09', '2022-05-11 10:25:09'),
	('PLG-227', 'BU.NANA', '085366083777', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-11 11:37:18', '2022-05-11 11:37:18'),
	('PLG-228', 'INGE', '085100762431', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-11 16:11:12', '2022-05-11 16:11:12'),
	('PLG-229', 'DINI', '0813-1147-3999', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-11 16:44:37', '2022-05-11 16:44:37'),
	('PLG-230', 'ERNA', '081252660198', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-12 08:03:49', '2022-05-12 08:03:49'),
	('PLG-231', 'ANDREAN', '081260593738', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-12 08:32:02', '2022-05-12 08:32:02'),
	('PLG-232', 'LINA', '0818-0354-8158', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-12 11:10:45', '2022-05-12 11:10:45'),
	('PLG-233', 'LINA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-12 13:33:58', '2022-05-12 13:33:58'),
	('PLG-234', 'KATRIN', '0822-8088-8338', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-12 13:48:27', '2022-05-12 13:48:27'),
	('PLG-235', 'RESS MARIANA', '0813-3444-7414', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-12 14:34:46', '2022-05-12 14:34:46'),
	('PLG-236', 'MISS KRISTIN', '0815-5669-5669', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-13 10:02:53', '2022-05-13 10:02:53'),
	('PLG-237', 'ANDAM', '0856-4950-7567', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-13 12:00:51', '2022-05-13 12:00:51'),
	('PLG-238', 'FEELING', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-13 12:57:00', '2022-05-13 12:57:00'),
	('PLG-239', 'MARETA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-14 10:19:11', '2022-05-14 10:19:11'),
	('PLG-240', 'BEBE', '0858-5557-5870', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-14 12:14:36', '2022-05-14 12:14:36'),
	('PLG-241', 'LISA', '0813-3745-6707', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-17 10:35:56', '2022-05-17 10:35:56'),
	('PLG-242', 'VIVIN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-18 14:47:29', '2022-05-18 14:47:29'),
	('PLG-243', 'TOKPED', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-18 15:18:42', '2022-05-18 15:18:42'),
	('PLG-244', 'REGINA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-18 16:07:07', '2022-05-18 16:07:07'),
	('PLG-245', 'MAADY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-19 15:33:45', '2022-05-19 15:33:45'),
	('PLG-246', 'IK PE', '0816550849', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-20 13:32:12', '2022-06-11 09:14:57'),
	('PLG-247', 'LAILY', '08113601104', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'admin', '2022-05-21 11:28:27', '2022-05-21 11:28:27'),
	('PLG-248', 'KARYA RASA CATERING', '0852-3249-2456', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-23 08:40:54', '2022-05-23 08:42:07'),
	('PLG-249', 'P. OCEAN', '0852-0410-8465', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-23 08:47:01', '2022-05-23 08:47:01'),
	('PLG-250', 'AHMAD', '0881-8566-899', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-23 09:32:33', '2022-05-23 09:32:33'),
	('PLG-251', 'ANIK', '0857-4541-0793', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-23 13:05:06', '2022-05-23 13:05:06'),
	('PLG-252', 'VIVI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-23 13:43:11', '2022-05-23 13:43:11'),
	('PLG-253', 'VINA OCTAVIA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-26 08:55:46', '2022-05-26 08:55:46'),
	('PLG-254', 'RESS VANIA', '0897-3782-730', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-26 15:20:57', '2022-05-26 15:22:04'),
	('PLG-255', 'ADI MUAYTHAI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-27 08:03:18', '2022-05-27 08:03:18'),
	('PLG-256', 'MEGA', '0838-3435-3036', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-27 12:43:54', '2022-05-27 12:43:54'),
	('PLG-257', 'RESS SINTA', '085236638432', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-28 10:54:34', '2022-05-28 10:54:34'),
	('PLG-258', 'ELY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-30 14:35:42', '2022-05-30 14:35:42'),
	('PLG-259', 'MAMA FARLA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-31 14:53:31', '2022-05-31 14:53:31'),
	('PLG-260', 'MAMA EBY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-05-31 15:36:57', '2022-05-31 15:36:57'),
	('PLG-261', 'CI ASYANG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-01 07:55:18', '2022-06-01 07:55:18'),
	('PLG-262', 'P.SUNARYO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-01 08:56:10', '2022-06-01 08:56:10'),
	('PLG-263', 'ALIF/ABON', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-01 14:11:37', '2022-06-01 14:11:37'),
	('PLG-264', 'JASUKE 86', '0817-7505-6158', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-05 08:22:32', '2022-06-05 08:22:32'),
	('PLG-265', 'MAYA', '0822-3015-6538', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-09 10:47:26', '2022-06-09 10:47:26'),
	('PLG-266', 'RESS POPPY', '081333667838', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-14 11:44:17', '2022-06-14 11:44:17'),
	('PLG-267', 'BU INDRA DEWI', '082139816330', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-17 14:47:57', '2022-06-17 14:47:57'),
	('PLG-268', 'CICIL', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-22 12:34:11', '2022-06-22 12:34:11'),
	('PLG-269', 'AYU', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-24 14:13:51', '2022-06-24 14:13:51'),
	('PLG-270', 'IM IM', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-25 09:41:42', '2022-06-25 09:41:42'),
	('PLG-271', 'CAFE KOTAK', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-27 13:24:15', '2022-06-27 13:24:15'),
	('PLG-272', 'ANISA', '0821-3269-0835', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-06-30 09:53:20', '2022-06-30 09:53:20'),
	('PLG-273', 'BU KARNO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-02 08:24:10', '2022-07-02 08:24:10'),
	('PLG-274', 'CE MAYA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-02 10:22:03', '2022-07-02 10:22:03'),
	('PLG-275', 'FANNY', '0811-3666-286', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-05 10:30:07', '2022-07-05 10:30:07'),
	('PLG-276', 'MIRA CIPTA RASA', '0811-2812-431', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-05 15:36:30', '2022-07-05 15:36:30'),
	('PLG-277', 'SILVI SHOPEE', '0838-3451-5995', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-06 10:31:54', '2022-07-06 10:31:54'),
	('PLG-278', 'MEILI IG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-07 13:43:49', '2022-07-07 13:43:49'),
	('PLG-279', 'BU DEWI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-08 10:46:35', '2022-07-08 10:46:35'),
	('PLG-280', 'MISS IKA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-08 10:59:16', '2022-07-08 10:59:16'),
	('PLG-281', 'RIKE MATAHARI CELL', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-18 11:32:05', '2022-07-18 11:32:05'),
	('PLG-282', 'LIMAS', '0818-536-967', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-18 12:49:01', '2022-07-18 12:49:01'),
	('PLG-283', 'CE YASMINE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-20 09:35:14', '2022-07-20 09:35:14'),
	('PLG-284', 'JENIFER SATYA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-21 08:55:13', '2022-07-21 08:55:13'),
	('PLG-285', 'BEA', '0896-3922-2356', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-22 11:25:47', '2022-07-22 11:25:47'),
	('PLG-286', 'VERA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-22 14:22:36', '2022-07-22 14:22:36'),
	('PLG-287', 'RESS B.NING', '085785967600', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-25 09:32:31', '2022-07-25 09:32:31'),
	('PLG-288', 'EVI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-26 08:56:07', '2022-07-26 08:56:07'),
	('PLG-289', 'AYU MEGA PANIN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-28 11:28:23', '2022-07-28 11:28:23'),
	('PLG-290', 'SINTA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-30 08:17:08', '2022-07-30 08:17:08'),
	('PLG-291', 'MEME WIDODO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-30 09:29:45', '2022-07-30 09:29:45'),
	('PLG-292', 'TINA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-07-30 16:01:42', '2022-07-30 16:01:42'),
	('PLG-293', 'DR. CONNIE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-04 11:05:00', '2022-08-04 11:05:00'),
	('PLG-294', 'Karti Widjaja', '08125246278', NULL, NULL, '0', '0', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-04 12:42:03', '2022-08-04 12:42:03'),
	('PLG-295', 'LIE LIE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-04 15:29:33', '2022-08-04 15:29:33'),
	('PLG-296', 'NIA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-04 15:36:34', '2022-08-04 15:36:34'),
	('PLG-297', 'MAMA WIKA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-06 12:30:18', '2022-08-06 12:30:18'),
	('PLG-298', 'RESS BERNIKE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-06 16:42:48', '2022-08-06 16:42:48'),
	('PLG-299', 'MARIA LUKMAN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-08 14:26:28', '2022-08-08 14:26:28'),
	('PLG-300', 'FANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-08 15:31:50', '2022-08-09 09:18:51'),
	('PLG-301', 'RESS NAYA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-09 13:48:39', '2022-08-09 13:48:39'),
	('PLG-302', 'REBECCA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-10 14:03:52', '2022-08-10 14:03:52'),
	('PLG-303', 'MAMA SHANUM', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-13 15:06:36', '2022-08-13 15:06:36'),
	('PLG-304', 'MILEA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-15 12:17:34', '2022-08-15 12:17:34'),
	('PLG-305', 'MEY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-15 14:32:58', '2022-08-15 14:32:58'),
	('PLG-306', 'YOHANA', '0813-5843-2013', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-15 15:47:27', '2022-08-15 15:47:27'),
	('PLG-307', 'YUNI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-16 08:15:40', '2022-08-16 08:15:40'),
	('PLG-308', 'RESS NANA', '0817-5401-983', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-16 16:11:39', '2022-08-27 09:57:27'),
	('PLG-309', 'MARIYA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-17 09:15:17', '2022-08-17 09:15:17'),
	('PLG-310', 'ALISA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-18 12:15:39', '2022-08-18 12:15:39'),
	('PLG-311', 'Vera', '0812-2430-8787', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-20 09:28:42', '2022-08-20 09:28:42'),
	('PLG-312', 'B.BUDI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-20 11:57:28', '2022-08-20 11:57:28'),
	('PLG-313', 'Rosa', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-23 14:39:22', '2022-08-23 14:39:22'),
	('PLG-314', 'DEVI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-24 09:27:27', '2022-08-24 09:27:27'),
	('PLG-315', 'TRIJATA KOFFIE', '0857-4930-8820', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-24 10:18:42', '2022-08-24 10:18:42'),
	('PLG-316', 'MELANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-27 15:13:33', '2022-08-27 15:13:33'),
	('PLG-317', 'WIDYAWATI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-30 15:34:22', '2022-08-30 15:34:22'),
	('PLG-318', 'BHE HWA', '0', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-08-31 10:40:18', '2022-08-31 12:55:31'),
	('PLG-319', 'Cik Dewi Mama ce Lita', '08988442888', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-03 11:38:21', '2022-09-03 11:38:21'),
	('PLG-320', 'RESS KHARISA', '082245474751', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-03 11:40:22', '2022-09-03 11:40:22'),
	('PLG-321', 'MARRY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-05 14:39:55', '2022-09-05 14:39:55'),
	('PLG-322', 'IRINE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-05 14:40:37', '2022-09-05 14:40:37'),
	('PLG-323', 'FRANSISCA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-07 09:08:54', '2022-09-07 09:08:54'),
	('PLG-324', 'MEGAWATI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-07 10:19:25', '2022-09-07 10:19:25'),
	('PLG-325', 'RIZKY ALBY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-08 14:18:30', '2022-09-08 14:18:30'),
	('PLG-326', 'CE KEZIA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-08 14:30:41', '2022-09-08 14:30:41'),
	('PLG-327', 'TEKLIE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-08 16:30:25', '2022-09-08 16:30:25'),
	('PLG-328', 'P.BEKTI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-08 16:34:20', '2022-09-08 16:34:20'),
	('PLG-329', 'CAROLINE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-09 11:01:28', '2022-09-09 11:01:28'),
	('PLG-330', 'HERLINA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-13 15:09:22', '2022-09-13 15:09:22'),
	('PLG-331', 'TK.PARKIT', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-15 14:37:20', '2022-09-15 14:37:20'),
	('PLG-332', 'DIANA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-16 14:57:12', '2022-09-16 14:57:12'),
	('PLG-333', 'IGA LARAS', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-17 13:22:45', '2022-09-17 13:22:45'),
	('PLG-334', 'LELI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-17 15:35:45', '2022-09-17 15:35:45'),
	('PLG-335', 'YENNY', '081937951988', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-20 10:27:34', '2022-09-20 10:27:34'),
	('PLG-336', 'RESS SANT SANT', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-21 09:40:39', '2022-09-21 09:40:39'),
	('PLG-337', 'OM ADI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-21 12:31:02', '2022-09-21 12:31:02'),
	('PLG-338', 'Oma Milly', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-22 08:43:20', '2022-09-22 08:43:20'),
	('PLG-339', 'CE ANI', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-26 09:30:33', '2022-09-26 10:14:07'),
	('PLG-340', 'ELY', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-26 10:56:07', '2022-09-26 10:56:07'),
	('PLG-341', 'P.NANANG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-27 16:50:43', '2022-09-27 16:50:43'),
	('PLG-342', 'RIKA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-09-28 13:46:34', '2022-09-28 13:46:34'),
	('PLG-343', 'ITA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-01 11:44:49', '2022-10-01 11:44:49'),
	('PLG-344', 'INCHIE', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-01 11:46:04', '2022-10-01 11:46:04'),
	('PLG-345', 'RESS.JESSICA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-03 09:44:25', '2022-10-03 09:44:25'),
	('PLG-346', 'IDA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-04 13:24:01', '2022-10-04 13:24:01'),
	('PLG-347', 'ANIK', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-06 11:22:58', '2022-10-06 11:22:58'),
	('PLG-348', 'NOVIA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-15 08:14:28', '2022-10-15 08:14:28'),
	('PLG-349', 'MEEFANG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-15 08:15:53', '2022-10-15 08:15:53'),
	('PLG-350', 'KO LEO', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-18 07:59:30', '2022-10-18 07:59:30'),
	('PLG-351', 'IN IN', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-20 09:39:47', '2022-10-20 09:39:47'),
	('PLG-352', 'Ress Sahrul Seblak', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-25 08:46:35', '2022-10-25 08:46:35'),
	('PLG-353', 'ENDANG', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-25 16:31:46', '2022-10-25 16:31:46'),
	('PLG-354', 'Pien', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-27 11:34:49', '2022-10-27 11:34:49'),
	('PLG-355', 'MISS YOLANDA', '-', NULL, NULL, '-', '-', NULL, NULL, 'OPN', NULL, 'KASIR', '2022-10-28 12:08:51', '2022-10-28 12:08:51');
/*!40000 ALTER TABLE `pelanggans` ENABLE KEYS */;

-- Dumping structure for table canary.pelunasanhutangs
DROP TABLE IF EXISTS `pelunasanhutangs`;
CREATE TABLE IF NOT EXISTS `pelunasanhutangs` (
  `KodePelunasanHutangID` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodePelunasanHutangID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pelunasanhutangs: ~0 rows (approximately)
DELETE FROM `pelunasanhutangs`;
/*!40000 ALTER TABLE `pelunasanhutangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pelunasanhutangs` ENABLE KEYS */;

-- Dumping structure for table canary.pelunasanpiutangs
DROP TABLE IF EXISTS `pelunasanpiutangs`;
CREATE TABLE IF NOT EXISTS `pelunasanpiutangs` (
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
  `KodePelunasanPiutangID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`KodePelunasanPiutangID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pelunasanpiutangs: ~0 rows (approximately)
DELETE FROM `pelunasanpiutangs`;
/*!40000 ALTER TABLE `pelunasanpiutangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pelunasanpiutangs` ENABLE KEYS */;

-- Dumping structure for table canary.pembelianlangsungdetails
DROP TABLE IF EXISTS `pembelianlangsungdetails`;
CREATE TABLE IF NOT EXISTS `pembelianlangsungdetails` (
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

-- Dumping data for table canary.pembelianlangsungdetails: ~0 rows (approximately)
DELETE FROM `pembelianlangsungdetails`;
/*!40000 ALTER TABLE `pembelianlangsungdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembelianlangsungdetails` ENABLE KEYS */;

-- Dumping structure for table canary.pembelianlangsungs
DROP TABLE IF EXISTS `pembelianlangsungs`;
CREATE TABLE IF NOT EXISTS `pembelianlangsungs` (
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

-- Dumping data for table canary.pembelianlangsungs: ~0 rows (approximately)
DELETE FROM `pembelianlangsungs`;
/*!40000 ALTER TABLE `pembelianlangsungs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembelianlangsungs` ENABLE KEYS */;

-- Dumping structure for table canary.pemesananpembeliandetails
DROP TABLE IF EXISTS `pemesananpembeliandetails`;
CREATE TABLE IF NOT EXISTS `pemesananpembeliandetails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `KodePO` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pemesananpembeliandetails: ~0 rows (approximately)
DELETE FROM `pemesananpembeliandetails`;
/*!40000 ALTER TABLE `pemesananpembeliandetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesananpembeliandetails` ENABLE KEYS */;

-- Dumping structure for table canary.pemesananpembelians
DROP TABLE IF EXISTS `pemesananpembelians`;
CREATE TABLE IF NOT EXISTS `pemesananpembelians` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pemesananpembelians: ~0 rows (approximately)
DELETE FROM `pemesananpembelians`;
/*!40000 ALTER TABLE `pemesananpembelians` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesananpembelians` ENABLE KEYS */;

-- Dumping structure for table canary.pemesananpenjualans
DROP TABLE IF EXISTS `pemesananpenjualans`;
CREATE TABLE IF NOT EXISTS `pemesananpenjualans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeSO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MALANG',
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'RP',
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `NilaiPPN` double DEFAULT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double DEFAULT '0',
  `NilaiDiskon` double DEFAULT '0',
  `Subtotal` double DEFAULT NULL,
  `Bayar` int(11) NOT NULL,
  `Kembalian` int(11) NOT NULL,
  `KodePelanggan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Expired` double DEFAULT NULL,
  `KodeSales` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `POPelanggan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `KodeSO` (`KodeSO`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pemesananpenjualans: ~0 rows (approximately)
DELETE FROM `pemesananpenjualans`;
/*!40000 ALTER TABLE `pemesananpenjualans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesananpenjualans` ENABLE KEYS */;

-- Dumping structure for table canary.pemesanan_penjualan_detail
DROP TABLE IF EXISTS `pemesanan_penjualan_detail`;
CREATE TABLE IF NOT EXISTS `pemesanan_penjualan_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodeSO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Qty` double NOT NULL,
  `Harga` double NOT NULL,
  `Subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pemesanan_penjualan_detail: ~0 rows (approximately)
DELETE FROM `pemesanan_penjualan_detail`;
/*!40000 ALTER TABLE `pemesanan_penjualan_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesanan_penjualan_detail` ENABLE KEYS */;

-- Dumping structure for table canary.penerimaanbarangdetails
DROP TABLE IF EXISTS `penerimaanbarangdetails`;
CREATE TABLE IF NOT EXISTS `penerimaanbarangdetails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodePenerimaanBarang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Harga` double DEFAULT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penerimaanbarangdetails: ~0 rows (approximately)
DELETE FROM `penerimaanbarangdetails`;
/*!40000 ALTER TABLE `penerimaanbarangdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerimaanbarangdetails` ENABLE KEYS */;

-- Dumping structure for table canary.penerimaanbarangreturndetails
DROP TABLE IF EXISTS `penerimaanbarangreturndetails`;
CREATE TABLE IF NOT EXISTS `penerimaanbarangreturndetails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodePenerimaanBarangReturn` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Harga` double DEFAULT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penerimaanbarangreturndetails: ~0 rows (approximately)
DELETE FROM `penerimaanbarangreturndetails`;
/*!40000 ALTER TABLE `penerimaanbarangreturndetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerimaanbarangreturndetails` ENABLE KEYS */;

-- Dumping structure for table canary.penerimaanbarangreturns
DROP TABLE IF EXISTS `penerimaanbarangreturns`;
CREATE TABLE IF NOT EXISTS `penerimaanbarangreturns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodePenerimaanBarangReturn` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSupplier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double NOT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodePenerimaanBarang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penerimaanbarangreturns: ~0 rows (approximately)
DELETE FROM `penerimaanbarangreturns`;
/*!40000 ALTER TABLE `penerimaanbarangreturns` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerimaanbarangreturns` ENABLE KEYS */;

-- Dumping structure for table canary.penerimaanbarangs
DROP TABLE IF EXISTS `penerimaanbarangs`;
CREATE TABLE IF NOT EXISTS `penerimaanbarangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodePenerimaanBarang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeUser` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NilaiPPN` double NOT NULL,
  `Printed` double DEFAULT NULL,
  `Diskon` double NOT NULL,
  `NilaiDiskon` double NOT NULL,
  `Subtotal` double NOT NULL,
  `KodeSupplier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSales` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TotalItem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeSJ` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodePO` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoFaktur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penerimaanbarangs: ~0 rows (approximately)
DELETE FROM `penerimaanbarangs`;
/*!40000 ALTER TABLE `penerimaanbarangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerimaanbarangs` ENABLE KEYS */;

-- Dumping structure for table canary.pengeluarantambahans
DROP TABLE IF EXISTS `pengeluarantambahans`;
CREATE TABLE IF NOT EXISTS `pengeluarantambahans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `KodePengeluaran` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Karyawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Metode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Transaksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(999) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pengeluarantambahans: ~0 rows (approximately)
DELETE FROM `pengeluarantambahans`;
/*!40000 ALTER TABLE `pengeluarantambahans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengeluarantambahans` ENABLE KEYS */;

-- Dumping structure for table canary.penggunas
DROP TABLE IF EXISTS `penggunas`;
CREATE TABLE IF NOT EXISTS `penggunas` (
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalDaftar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Aktif` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penggunas: ~0 rows (approximately)
DELETE FROM `penggunas`;
/*!40000 ALTER TABLE `penggunas` DISABLE KEYS */;
/*!40000 ALTER TABLE `penggunas` ENABLE KEYS */;

-- Dumping structure for table canary.penjualanlangsungdetails
DROP TABLE IF EXISTS `penjualanlangsungdetails`;
CREATE TABLE IF NOT EXISTS `penjualanlangsungdetails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penjualanlangsungdetails: ~0 rows (approximately)
DELETE FROM `penjualanlangsungdetails`;
/*!40000 ALTER TABLE `penjualanlangsungdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `penjualanlangsungdetails` ENABLE KEYS */;

-- Dumping structure for table canary.penjualanlangsungreturndetails
DROP TABLE IF EXISTS `penjualanlangsungreturndetails`;
CREATE TABLE IF NOT EXISTS `penjualanlangsungreturndetails` (
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

-- Dumping data for table canary.penjualanlangsungreturndetails: ~0 rows (approximately)
DELETE FROM `penjualanlangsungreturndetails`;
/*!40000 ALTER TABLE `penjualanlangsungreturndetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `penjualanlangsungreturndetails` ENABLE KEYS */;

-- Dumping structure for table canary.penjualanlangsungreturns
DROP TABLE IF EXISTS `penjualanlangsungreturns`;
CREATE TABLE IF NOT EXISTS `penjualanlangsungreturns` (
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

-- Dumping data for table canary.penjualanlangsungreturns: ~0 rows (approximately)
DELETE FROM `penjualanlangsungreturns`;
/*!40000 ALTER TABLE `penjualanlangsungreturns` DISABLE KEYS */;
/*!40000 ALTER TABLE `penjualanlangsungreturns` ENABLE KEYS */;

-- Dumping structure for table canary.penjualanlangsungs
DROP TABLE IF EXISTS `penjualanlangsungs`;
CREATE TABLE IF NOT EXISTS `penjualanlangsungs` (
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodePenjualanLangsung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.penjualanlangsungs: ~0 rows (approximately)
DELETE FROM `penjualanlangsungs`;
/*!40000 ALTER TABLE `penjualanlangsungs` DISABLE KEYS */;
/*!40000 ALTER TABLE `penjualanlangsungs` ENABLE KEYS */;

-- Dumping structure for table canary.pindahgudangdetails
DROP TABLE IF EXISTS `pindahgudangdetails`;
CREATE TABLE IF NOT EXISTS `pindahgudangdetails` (
  `KodePindah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.pindahgudangdetails: ~0 rows (approximately)
DELETE FROM `pindahgudangdetails`;
/*!40000 ALTER TABLE `pindahgudangdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `pindahgudangdetails` ENABLE KEYS */;

-- Dumping structure for table canary.pindahgudangs
DROP TABLE IF EXISTS `pindahgudangs`;
CREATE TABLE IF NOT EXISTS `pindahgudangs` (
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

-- Dumping data for table canary.pindahgudangs: ~0 rows (approximately)
DELETE FROM `pindahgudangs`;
/*!40000 ALTER TABLE `pindahgudangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pindahgudangs` ENABLE KEYS */;

-- Dumping structure for table canary.piutangs
DROP TABLE IF EXISTS `piutangs`;
CREATE TABLE IF NOT EXISTS `piutangs` (
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

-- Dumping data for table canary.piutangs: ~0 rows (approximately)
DELETE FROM `piutangs`;
/*!40000 ALTER TABLE `piutangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `piutangs` ENABLE KEYS */;

-- Dumping structure for table canary.prod_hasilproduksidetail
DROP TABLE IF EXISTS `prod_hasilproduksidetail`;
CREATE TABLE IF NOT EXISTS `prod_hasilproduksidetail` (
  `no` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodeResep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeProduksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `QtyHasil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.prod_hasilproduksidetail: ~0 rows (approximately)
DELETE FROM `prod_hasilproduksidetail`;
/*!40000 ALTER TABLE `prod_hasilproduksidetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_hasilproduksidetail` ENABLE KEYS */;

-- Dumping structure for table canary.prod_hasilproduksiheader
DROP TABLE IF EXISTS `prod_hasilproduksiheader`;
CREATE TABLE IF NOT EXISTS `prod_hasilproduksiheader` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodeProduksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeResep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeGolongan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jenis` varchar(19) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalProduksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.prod_hasilproduksiheader: ~0 rows (approximately)
DELETE FROM `prod_hasilproduksiheader`;
/*!40000 ALTER TABLE `prod_hasilproduksiheader` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_hasilproduksiheader` ENABLE KEYS */;

-- Dumping structure for table canary.prod_hutangdetail
DROP TABLE IF EXISTS `prod_hutangdetail`;
CREATE TABLE IF NOT EXISTS `prod_hutangdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IDHutang` int(11) NOT NULL,
  `KodeKaryawan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeGolongan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `QtyBuku_Nutuk` double NOT NULL,
  `QtyCek_Nutuk` double NOT NULL,
  `QtyHutang_Nutuk` double NOT NULL,
  `Gaji_Nutuk` double NOT NULL,
  `QtyBuku_Packing` double NOT NULL,
  `QtyCek_Packing` double NOT NULL,
  `QtyHutang_Packing` double NOT NULL,
  `Gaji_Packing` double NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table canary.prod_hutangdetail: ~0 rows (approximately)
DELETE FROM `prod_hutangdetail`;
/*!40000 ALTER TABLE `prod_hutangdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_hutangdetail` ENABLE KEYS */;

-- Dumping structure for table canary.prod_hutangheader
DROP TABLE IF EXISTS `prod_hutangheader`;
CREATE TABLE IF NOT EXISTS `prod_hutangheader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TanggalAwal` date NOT NULL,
  `TanggalAkhir` date NOT NULL,
  `TanggalGajian` date NOT NULL,
  `Status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table canary.prod_hutangheader: ~0 rows (approximately)
DELETE FROM `prod_hutangheader`;
/*!40000 ALTER TABLE `prod_hutangheader` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_hutangheader` ENABLE KEYS */;

-- Dumping structure for table canary.prod_produksidetail
DROP TABLE IF EXISTS `prod_produksidetail`;
CREATE TABLE IF NOT EXISTS `prod_produksidetail` (
  `idProduksiDetail` int(11) NOT NULL AUTO_INCREMENT,
  `KodeProduksi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeResep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'bahan baku/setengah jadi',
  `KodeSatuan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Qty` double NOT NULL,
  `QtyCek` double DEFAULT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idProduksiDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table canary.prod_produksidetail: ~0 rows (approximately)
DELETE FROM `prod_produksidetail`;
/*!40000 ALTER TABLE `prod_produksidetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_produksidetail` ENABLE KEYS */;

-- Dumping structure for table canary.prod_produksiheader
DROP TABLE IF EXISTS `prod_produksiheader`;
CREATE TABLE IF NOT EXISTS `prod_produksiheader` (
  `IDProduksi` int(11) NOT NULL AUTO_INCREMENT,
  `KodeResep` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeProduksi` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeGolongan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jenis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalInput` date DEFAULT NULL,
  `TanggalCek` date DEFAULT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IDProduksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table canary.prod_produksiheader: ~0 rows (approximately)
DELETE FROM `prod_produksiheader`;
/*!40000 ALTER TABLE `prod_produksiheader` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_produksiheader` ENABLE KEYS */;

-- Dumping structure for table canary.prod_resepdetail
DROP TABLE IF EXISTS `prod_resepdetail`;
CREATE TABLE IF NOT EXISTS `prod_resepdetail` (
  `KodeResep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'bahan baku/setengah jadi',
  `KodeSatuan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoUrut` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `IDResepDetail` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDResepDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table canary.prod_resepdetail: ~0 rows (approximately)
DELETE FROM `prod_resepdetail`;
/*!40000 ALTER TABLE `prod_resepdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_resepdetail` ENABLE KEYS */;

-- Dumping structure for table canary.prod_resepheader
DROP TABLE IF EXISTS `prod_resepheader`;
CREATE TABLE IF NOT EXISTS `prod_resepheader` (
  `IDResep` int(11) NOT NULL AUTO_INCREMENT,
  `KodeResep` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Qty` double DEFAULT NULL,
  `KodeSatuan` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IDResep`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table canary.prod_resepheader: ~0 rows (approximately)
DELETE FROM `prod_resepheader`;
/*!40000 ALTER TABLE `prod_resepheader` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_resepheader` ENABLE KEYS */;

-- Dumping structure for table canary.rak
DROP TABLE IF EXISTS `rak`;
CREATE TABLE IF NOT EXISTS `rak` (
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL DEFAULT '0',
  `status` set('OPN','DEL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPN',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.rak: ~0 rows (approximately)
DELETE FROM `rak`;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;

-- Dumping structure for table canary.rakdetail
DROP TABLE IF EXISTS `rakdetail`;
CREATE TABLE IF NOT EXISTS `rakdetail` (
  `rak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table canary.rakdetail: ~0 rows (approximately)
DELETE FROM `rakdetail`;
/*!40000 ALTER TABLE `rakdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `rakdetail` ENABLE KEYS */;

-- Dumping structure for table canary.raktambahan
DROP TABLE IF EXISTS `raktambahan`;
CREATE TABLE IF NOT EXISTS `raktambahan` (
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL DEFAULT '0',
  `status` set('OPN','DEL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPN',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table canary.raktambahan: ~0 rows (approximately)
DELETE FROM `raktambahan`;
/*!40000 ALTER TABLE `raktambahan` DISABLE KEYS */;
/*!40000 ALTER TABLE `raktambahan` ENABLE KEYS */;

-- Dumping structure for table canary.raktambahandetail
DROP TABLE IF EXISTS `raktambahandetail`;
CREATE TABLE IF NOT EXISTS `raktambahandetail` (
  `rak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table canary.raktambahandetail: ~0 rows (approximately)
DELETE FROM `raktambahandetail`;
/*!40000 ALTER TABLE `raktambahandetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `raktambahandetail` ENABLE KEYS */;

-- Dumping structure for table canary.resep
DROP TABLE IF EXISTS `resep`;
CREATE TABLE IF NOT EXISTS `resep` (
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` json DEFAULT NULL,
  `status` set('OPN','DEL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPN',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table canary.resep: ~0 rows (approximately)
DELETE FROM `resep`;
/*!40000 ALTER TABLE `resep` DISABLE KEYS */;
/*!40000 ALTER TABLE `resep` ENABLE KEYS */;

-- Dumping structure for table canary.resepdetail
DROP TABLE IF EXISTS `resepdetail`;
CREATE TABLE IF NOT EXISTS `resepdetail` (
  `resep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table canary.resepdetail: ~0 rows (approximately)
DELETE FROM `resepdetail`;
/*!40000 ALTER TABLE `resepdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `resepdetail` ENABLE KEYS */;

-- Dumping structure for table canary.rugilaba
DROP TABLE IF EXISTS `rugilaba`;
CREATE TABLE IF NOT EXISTS `rugilaba` (
  `KodeTransaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TotalLaba` int(25) NOT NULL,
  `TotalRugi` int(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.rugilaba: ~0 rows (approximately)
DELETE FROM `rugilaba`;
/*!40000 ALTER TABLE `rugilaba` DISABLE KEYS */;
/*!40000 ALTER TABLE `rugilaba` ENABLE KEYS */;

-- Dumping structure for table canary.rugilaba_details
DROP TABLE IF EXISTS `rugilaba_details`;
CREATE TABLE IF NOT EXISTS `rugilaba_details` (
  `KodeTransaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeItem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Laba` int(25) NOT NULL,
  `Rugi` int(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.rugilaba_details: ~0 rows (approximately)
DELETE FROM `rugilaba_details`;
/*!40000 ALTER TABLE `rugilaba_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `rugilaba_details` ENABLE KEYS */;

-- Dumping structure for table canary.saldos
DROP TABLE IF EXISTS `saldos`;
CREATE TABLE IF NOT EXISTS `saldos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `KodeTransaksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Transaksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Jumlah` double NOT NULL,
  `Tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SaldoCash` double NOT NULL,
  `SaldoRekening` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.saldos: ~0 rows (approximately)
DELETE FROM `saldos`;
/*!40000 ALTER TABLE `saldos` DISABLE KEYS */;
/*!40000 ALTER TABLE `saldos` ENABLE KEYS */;

-- Dumping structure for table canary.sales
DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `KodeSales` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaSales` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeKaryawan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.sales: ~0 rows (approximately)
DELETE FROM `sales`;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;

-- Dumping structure for table canary.satuans
DROP TABLE IF EXISTS `satuans`;
CREATE TABLE IF NOT EXISTS `satuans` (
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaSatuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeSatuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.satuans: ~0 rows (approximately)
DELETE FROM `satuans`;
/*!40000 ALTER TABLE `satuans` DISABLE KEYS */;
/*!40000 ALTER TABLE `satuans` ENABLE KEYS */;

-- Dumping structure for table canary.stokkeluardetails
DROP TABLE IF EXISTS `stokkeluardetails`;
CREATE TABLE IF NOT EXISTS `stokkeluardetails` (
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

-- Dumping data for table canary.stokkeluardetails: ~0 rows (approximately)
DELETE FROM `stokkeluardetails`;
/*!40000 ALTER TABLE `stokkeluardetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `stokkeluardetails` ENABLE KEYS */;

-- Dumping structure for table canary.stokkeluars
DROP TABLE IF EXISTS `stokkeluars`;
CREATE TABLE IF NOT EXISTS `stokkeluars` (
  `KodeStokKeluar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` datetime NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TotalItem` double NOT NULL,
  `Printed` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeStokKeluar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.stokkeluars: ~0 rows (approximately)
DELETE FROM `stokkeluars`;
/*!40000 ALTER TABLE `stokkeluars` DISABLE KEYS */;
/*!40000 ALTER TABLE `stokkeluars` ENABLE KEYS */;

-- Dumping structure for table canary.stokmasukdetails
DROP TABLE IF EXISTS `stokmasukdetails`;
CREATE TABLE IF NOT EXISTS `stokmasukdetails` (
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

-- Dumping data for table canary.stokmasukdetails: ~0 rows (approximately)
DELETE FROM `stokmasukdetails`;
/*!40000 ALTER TABLE `stokmasukdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `stokmasukdetails` ENABLE KEYS */;

-- Dumping structure for table canary.stokmasuks
DROP TABLE IF EXISTS `stokmasuks`;
CREATE TABLE IF NOT EXISTS `stokmasuks` (
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

-- Dumping data for table canary.stokmasuks: ~0 rows (approximately)
DELETE FROM `stokmasuks`;
/*!40000 ALTER TABLE `stokmasuks` DISABLE KEYS */;
/*!40000 ALTER TABLE `stokmasuks` ENABLE KEYS */;

-- Dumping structure for table canary.suppliers
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
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

-- Dumping data for table canary.suppliers: ~0 rows (approximately)
DELETE FROM `suppliers`;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;

-- Dumping structure for table canary.suratjalandetails
DROP TABLE IF EXISTS `suratjalandetails`;
CREATE TABLE IF NOT EXISTS `suratjalandetails` (
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

-- Dumping data for table canary.suratjalandetails: ~0 rows (approximately)
DELETE FROM `suratjalandetails`;
/*!40000 ALTER TABLE `suratjalandetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `suratjalandetails` ENABLE KEYS */;

-- Dumping structure for table canary.suratjalanreturndetails
DROP TABLE IF EXISTS `suratjalanreturndetails`;
CREATE TABLE IF NOT EXISTS `suratjalanreturndetails` (
  `KodeSuratJalanReturnID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `KodeSuratJalanReturn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KodeItem` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeSatuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Harga` double DEFAULT NULL,
  `Qty` double NOT NULL,
  `Keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoUrut` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeSuratJalanReturnID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.suratjalanreturndetails: ~0 rows (approximately)
DELETE FROM `suratjalanreturndetails`;
/*!40000 ALTER TABLE `suratjalanreturndetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `suratjalanreturndetails` ENABLE KEYS */;

-- Dumping structure for table canary.suratjalanreturns
DROP TABLE IF EXISTS `suratjalanreturns`;
CREATE TABLE IF NOT EXISTS `suratjalanreturns` (
  `KodeSuratJalanReturnID` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeSuratJalanReturnID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.suratjalanreturns: ~0 rows (approximately)
DELETE FROM `suratjalanreturns`;
/*!40000 ALTER TABLE `suratjalanreturns` DISABLE KEYS */;
/*!40000 ALTER TABLE `suratjalanreturns` ENABLE KEYS */;

-- Dumping structure for table canary.suratjalans
DROP TABLE IF EXISTS `suratjalans`;
CREATE TABLE IF NOT EXISTS `suratjalans` (
  `KodeSuratJalanID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KodeSuratJalan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `KodeLokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeMataUang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KodeUser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `PPN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ongkir` double NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KodeSuratJalanID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.suratjalans: ~0 rows (approximately)
DELETE FROM `suratjalans`;
/*!40000 ALTER TABLE `suratjalans` DISABLE KEYS */;
/*!40000 ALTER TABLE `suratjalans` ENABLE KEYS */;

-- Dumping structure for table canary.tambahangajians
DROP TABLE IF EXISTS `tambahangajians`;
CREATE TABLE IF NOT EXISTS `tambahangajians` (
  `KodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gaji` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JumlahHariKerja` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LemburHarian` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JumlahLemburHarian` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LemburJam` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JumlahLemburJam` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Bonus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JumlahBonus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EnkripsiKodeGaji` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.tambahangajians: ~0 rows (approximately)
DELETE FROM `tambahangajians`;
/*!40000 ALTER TABLE `tambahangajians` DISABLE KEYS */;
/*!40000 ALTER TABLE `tambahangajians` ENABLE KEYS */;

-- Dumping structure for table canary.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canary.users: ~7 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `fullname`, `email`, `email_verified_at`, `lokasi`, `last_login`, `status`, `password`, `login_mac_address`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'admin', 'Admin', 'admin@gmail.com', NULL, 'lestari jaya', '2023-03-23 21:18:34', 'OPN', '$2y$10$.6YID8x0kwQX/eNRPpBfiObh8qkUKnzIgfwaydZPkxBqKwVIo/Vaq', '4C-BB-58-3A-5F-C4', NULL, '2020-07-13 11:19:32', '2023-03-23 21:18:35'),
	(7, 'adminlestari', 'lestari jaya', '-', '0000-00-00 00:00:00', 'lestari jaya', '2022-03-01 14:33:46', 'DEL', '$2y$10$ajqZauw9GD9fQYL.tpeASe7hJWVVfudyfgUNqbhMajOTKyC1x6slK', 'D0-37-45-CC-9F-0C', 'PppMHIvkyxrUTE6ONV5XRusnXd3HPlBAcVa2N2uimIzBSRditrxuChxLi7Qg', NULL, '2022-03-01 14:33:47'),
	(8, 'christ', 'christ', NULL, NULL, NULL, NULL, 'DEL', '$2y$10$D2wPjIwXVuc.7SNVxMsPdeOPME0aW6wSG.0LOLtkDfXTsocNGeRXC', NULL, NULL, '2021-10-10 01:47:47', '2021-10-10 01:47:47'),
	(9, 'KASIR', 'KASIR', NULL, NULL, NULL, '2022-11-28 20:48:42', 'OPN', '$2y$10$ajx3b1zBSOux97agLDzMRugRVRXstaJKY1H1Meeg8zCZ4/3uNWjMW', '80-A5-89-8B-4B-E9', NULL, '2022-01-20 13:22:20', '2022-11-28 20:48:44'),
	(10, 'pimpinan', 'Ardi', NULL, NULL, NULL, '2022-03-29 08:13:51', 'OPN', '$2y$10$ZvGyrsMxsRemdgByT4nHF..faKP8XUkEL0m13TQUTKVJqHeB.wane', 'D0-37-45-CC-9F-0C', NULL, '2022-03-26 19:40:52', '2022-03-29 08:13:52'),
	(11, 'admin1', 'admin1', NULL, NULL, NULL, '2022-08-20 19:18:11', 'OPN', '$2y$10$Vl/LSs5MJplV0P64FyaI0eYppaP/UlAZfnjB7mLupls0xtpaRKFUS', 'D0-37-45-CC-9F-0C', NULL, '2022-08-19 19:01:43', '2022-08-20 19:18:12'),
	(12, 'drift', 'drift', NULL, NULL, NULL, '2023-01-29 20:47:13', 'OPN', '$2y$10$.52wo.11ROFOOACA2Cj2UuljQ4FXHbnglHDCNeQZNcw2nAPiKJ0Um', '80-A5-89-8B-4B-E9', NULL, '2023-01-29 19:44:29', '2023-01-29 20:47:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
