-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2025 at 08:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k3lh_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_pembatalan`
--

CREATE TABLE `approval_pembatalan` (
  `id` bigint UNSIGNED NOT NULL,
  `pengajuan_pembatalan_id` bigint UNSIGNED DEFAULT NULL,
  `approver_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `permission_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_penyelesaian`
--

CREATE TABLE `approval_penyelesaian` (
  `id` bigint UNSIGNED NOT NULL,
  `pengajuan_penyelesaian_id` bigint UNSIGNED DEFAULT NULL,
  `approver_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `permission_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_penyelesaian`
--

INSERT INTO `approval_penyelesaian` (`id`, `pengajuan_penyelesaian_id`, `approver_id`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`, `permission_name`, `level`) VALUES
(27, 12, 3, 'approved', 'approve', '2025-05-29 14:27:25', '2025-05-29 13:36:24', '2025-05-29 14:27:25', 'approval-pengawas', 1),
(28, 12, 6, 'approved', 'approve', '2025-05-29 14:27:57', '2025-05-29 14:27:25', '2025-05-29 14:27:57', 'approval-area', 2),
(29, 12, 7, 'approved', 'approve', '2025-05-29 14:29:13', '2025-05-29 14:27:57', '2025-05-29 14:29:13', 'approval-she_officer', 3),
(30, 12, 8, 'approved', 'approve', '2025-05-29 14:29:44', '2025-05-29 14:29:13', '2025-05-29 14:29:44', 'approval-she_manager', 4);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'maximem', 'maximem', '2025-03-23 21:10:22', '2025-03-23 23:46:51'),
(2, 'ut', 'ut', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(3, 'nemo', 'nemo', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(4, 'sit', 'sit', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(5, 'reiciendis', 'reiciendis', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(6, 'recusandae', 'recusandae', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(7, 'vel', 'vel', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(8, 'ullam', 'ullam', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(9, 'occaecati', 'occaecati', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(10, 'ut', 'ut', '2025-03-23 21:10:22', '2025-03-23 21:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `cek_materi_inspeksi`
--

CREATE TABLE `cek_materi_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `jadwal_inspeksi_id` bigint UNSIGNED NOT NULL,
  `sub_kategori_id` bigint UNSIGNED NOT NULL,
  `status` enum('S','TS') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'S: Sesuai, TS: Tidak Sesuai',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cek_materi_inspeksi`
--

INSERT INTO `cek_materi_inspeksi` (`id`, `jadwal_inspeksi_id`, `sub_kategori_id`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(38, 10, 1, 'S', NULL, '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(39, 10, 2, 'TS', 'perbaiki', '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(40, 10, 3, 'S', NULL, '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(41, 10, 4, 'TS', 'perbaiki', '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(42, 10, 5, 'S', NULL, '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(43, 10, 11, 'S', NULL, '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(44, 11, 1, 'S', NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46'),
(45, 11, 2, 'S', NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46'),
(46, 11, 3, 'S', NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46'),
(47, 11, 4, 'S', NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46'),
(48, 11, 5, 'S', NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46'),
(49, 11, 11, 'S', NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46');

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `id` int NOT NULL,
  `shortnm` varchar(100) DEFAULT NULL,
  `longnm` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lokasi_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `nama_divisi`, `created_at`, `updated_at`, `lokasi_id`) VALUES
(41, 'ACCOUNTING', '2025-06-04 08:38:29', '2025-06-04 08:38:29', 3),
(42, 'FINANCE', '2025-06-04 08:38:29', '2025-06-04 08:38:29', 3),
(43, 'HOTEL', '2025-06-04 08:38:29', '2025-06-04 08:38:29', 3),
(44, 'HUMAN CAPITAL', '2025-06-04 16:05:02', '2025-06-04 16:05:02', 4),
(45, 'CORPORATE SECRETARY', '2025-06-04 16:05:02', '2025-06-04 16:05:02', 4);

-- --------------------------------------------------------

--
-- Table structure for table `divisi_inspeksi`
--

CREATE TABLE `divisi_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi_inspeksi`
--

INSERT INTO `divisi_inspeksi` (`id`, `nama_divisi`, `nama_manager`, `lokasi`, `alamat`, `email`, `phone`, `created_at`, `updated_at`, `unit`) VALUES
(1, 'Divisi Operasional Hotel', 'Budi Santoso', 'Gedung A Lantai 3', 'Jl. Melati No. 10, Jakarta', 'operasional@ptcontoh.com', '02188888888', '2025-04-23 16:09:29', '2025-04-23 16:09:29', 'Unit Hotel'),
(2, 'Divisi Keuangan', 'Siti Aminah', 'Gedung B Lantai 2', 'Jl. Mawar No. 5, Jakarta', 'keuangan@ptcontoh.com', '02199999999', '2025-04-23 16:09:29', '2025-04-23 16:09:29', 'Unit Keuangan'),
(3, 'Divisi Teknik', 'Agus Wijaya', 'Workshop Utama', 'Jl. Cempaka No. 20, Jakarta', 'teknik@ptcontoh.com', '02177777777', '2025-04-23 16:09:29', '2025-04-23 16:09:29', 'Unit Teknik'),
(4, 'Divisi K3LH', 'Dewi Ratnasari', 'Gedung C Lantai 1', 'Jl. Kenanga No. 12, Jakarta', 'k3lh@ptcontoh.com', '02166666666', '2025-04-23 16:09:29', '2025-04-23 16:09:29', 'Unit K3LH'),
(5, 'Divisi IT Support', 'Fajar Nugroho', 'Gedung IT Center', 'Jl. Tulip No. 8, Jakarta', 'it@ptcontoh.com', '02155555555', '2025-04-23 16:09:29', '2025-04-23 16:09:29', 'Unit IT');

-- --------------------------------------------------------

--
-- Table structure for table `divisi_inspeksi_user`
--

CREATE TABLE `divisi_inspeksi_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `divisi_inspeksi_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi_inspeksi_user`
--

INSERT INTO `divisi_inspeksi_user` (`id`, `user_id`, `divisi_inspeksi_id`, `created_at`, `updated_at`) VALUES
(1, 9, 42, '2025-06-05 04:15:34', '2025-06-05 04:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `divisi_lingkungan`
--

CREATE TABLE `divisi_lingkungan` (
  `id` bigint UNSIGNED NOT NULL,
  `lokasi_id` bigint UNSIGNED NOT NULL,
  `nama_divisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi_lingkungan`
--

INSERT INTO `divisi_lingkungan` (`id`, `lokasi_id`, `nama_divisi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Divisi IT', '2025-05-13 13:32:06', '2025-05-13 13:32:06'),
(2, 1, 'Divisi Marketing', '2025-05-13 13:32:18', '2025-05-13 13:32:18'),
(3, 2, 'Divisi Sarana', '2025-05-13 13:32:41', '2025-05-13 13:32:41'),
(4, 2, 'Divisi Humas', '2025-05-13 13:32:50', '2025-05-13 13:32:50'),
(5, 2, 'Divisi Acounting', '2025-05-14 05:36:18', '2025-05-14 05:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `path`, `folder_id`, `created_at`, `updated_at`) VALUES
(1, 'document (1).pdf', 'folder_a/h7SGdFyHBJIer5HLsHPYVq9SkeY3NcEoj1Vde4pT.pdf', 1, '2025-05-14 18:57:45', '2025-05-14 18:57:45'),
(2, 'almuhyi fajar jaya-resume (2).pdf', 'folder_bfolder_b_1/ThnjTKw4nF8y3XmPuK7yXsj42eoAyDlXldNT8MyN.pdf', 3, '2025-05-19 03:09:39', '2025-05-19 03:09:39'),
(3, 'almuhyi fajar jaya-resume (2).pdf', 'folder_bfolder_b_1/Cv4oZxbmqpZNUDaU6XlZu0cL8lvKmON0LEQlwsHH.pdf', 3, '2025-05-19 03:09:49', '2025-05-19 03:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Folder A', NULL, '2025-05-14 18:49:37', '2025-05-14 18:49:37'),
(2, 'Folder B', NULL, '2025-05-19 03:08:45', '2025-05-19 03:08:45'),
(3, 'Folder B 1', 2, '2025-05-19 03:08:58', '2025-05-19 03:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_inspeksi`
--

CREATE TABLE `hasil_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `jadwal_inspeksi_id` bigint UNSIGNED DEFAULT NULL,
  `hasil_inspeksi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hasil_gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil_inspeksi`
--

INSERT INTO `hasil_inspeksi` (`id`, `jadwal_inspeksi_id`, `hasil_inspeksi`, `hasil_gambar`, `created_at`, `updated_at`) VALUES
(26, 10, 'atap bocor', 'uploads/hasil_inspeksi/1749095366_kesehatan-mental1.jpg', '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(27, 10, 'cat kotor', 'uploads/hasil_inspeksi/1749095367_kesehatan-mental1.jpg', '2025-06-04 20:49:27', '2025-06-04 20:49:27'),
(28, 11, 'cat kering', 'uploads/hasil_inspeksi/1749098446_kesehatan-mental1.jpg', '2025-06-04 21:40:46', '2025-06-04 21:40:46');

-- --------------------------------------------------------

--
-- Table structure for table `history_storage`
--

CREATE TABLE `history_storage` (
  `id` int NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `history_storage`
--

INSERT INTO `history_storage` (`id`, `nip`, `nama`, `nama_file`, `path_file`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, '7', 'Krystina Mayert', 'document (1).pdf', 'folder_a/h7SGdFyHBJIer5HLsHPYVq9SkeY3NcEoj1Vde4pT.pdf', 2, NULL, '2025-05-15 01:58:00', '2025-05-15 01:58:37'),
(4, '7', 'Krystina Mayert', 'document (1).pdf', 'folder_a/h7SGdFyHBJIer5HLsHPYVq9SkeY3NcEoj1Vde4pT.pdf', 3, 'reject', '2025-05-15 01:58:17', '2025-05-15 01:58:44'),
(5, '7', 'Krystina Mayert', 'document (1).pdf', 'folder_a/h7SGdFyHBJIer5HLsHPYVq9SkeY3NcEoj1Vde4pT.pdf', 2, NULL, '2025-05-19 08:45:48', '2025-05-19 08:46:53'),
(6, '7', 'Krystina Mayert', 'document (1).pdf', 'folder_a/h7SGdFyHBJIer5HLsHPYVq9SkeY3NcEoj1Vde4pT.pdf', 2, NULL, '2025-05-19 10:10:39', '2025-05-19 10:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `hse_monthly_reports`
--

CREATE TABLE `hse_monthly_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `work_schedule_id` bigint UNSIGNED DEFAULT NULL,
  `hari_kerja_bulan_lalu` int DEFAULT '0',
  `hari_kerja_bulan_ini` int DEFAULT '0',
  `hari_kerja_total` int DEFAULT '0',
  `manhours_lembur_bulan_lalu` int DEFAULT '0',
  `manhours_lembur_bulan_ini` int DEFAULT '0',
  `manhours_lembur_total` int DEFAULT '0',
  `manhours_subkon_bulan_lalu` int DEFAULT '0',
  `manhours_subkon_bulan_ini` int DEFAULT '0',
  `manhours_subkon_total` int DEFAULT '0',
  `total_manhours_bulan_lalu` int DEFAULT '0',
  `total_manhours_bulan_ini` int DEFAULT '0',
  `total_manhours_total` int DEFAULT '0',
  `pekerja_kontraktor_utama` int DEFAULT '0',
  `pekerja_subkon` int DEFAULT '0',
  `total_pekerja` int DEFAULT '0',
  `hse_manager` int DEFAULT '0',
  `hse_coordinator` int DEFAULT '0',
  `hse_supervisor` int DEFAULT '0',
  `safety_engineer` int DEFAULT '0',
  `safety_officer` int DEFAULT '0',
  `safety_inspector` int DEFAULT '0',
  `safety_administration` int DEFAULT '0',
  `safety_man` int DEFAULT '0',
  `paramedis` int DEFAULT '0',
  `kasus_insiden_bulan_ini` int DEFAULT '0',
  `kasus_insiden_total` int DEFAULT '0',
  `fatality_bulan_ini` int DEFAULT '0',
  `fatality_total` int DEFAULT '0',
  `disability_bulan_ini` int DEFAULT '0',
  `disability_total` int DEFAULT '0',
  `medical_bulan_ini` int DEFAULT '0',
  `medical_total` int DEFAULT '0',
  `first_aid_bulan_ini` int DEFAULT '0',
  `first_aid_total` int DEFAULT '0',
  `property_damage_bulan_ini` int DEFAULT '0',
  `property_damage_total` int DEFAULT '0',
  `traffic_accident_bulan_ini` int DEFAULT '0',
  `traffic_accident_total` int DEFAULT '0',
  `near_miss_bulan_ini` int DEFAULT '0',
  `near_miss_total` int DEFAULT '0',
  `lost_time_bulan_ini` int DEFAULT '0',
  `lost_time_total` int DEFAULT '0',
  `kasus_penyakit_bulan_ini` int DEFAULT '0',
  `kasus_penyakit_total` int DEFAULT '0',
  `penyakit_kerja_bulan_ini` int DEFAULT '0',
  `penyakit_kerja_total` int DEFAULT '0',
  `penyakit_hubungan_kerja_bulan_ini` int DEFAULT '0',
  `penyakit_hubungan_kerja_total` int DEFAULT '0',
  `penyakit_biasa_bulan_ini` int DEFAULT '0',
  `penyakit_biasa_total` int DEFAULT '0',
  `lost_time_penyakit_bulan_ini` int DEFAULT '0',
  `lost_time_penyakit_total` int DEFAULT '0',
  `kasus_pencemaran_bulan_ini` int DEFAULT '0',
  `kasus_pencemaran_total` int DEFAULT '0',
  `pencemaran_air_bulan_ini` int DEFAULT '0',
  `pencemaran_air_total` int DEFAULT '0',
  `pencemaran_udara_bulan_ini` int DEFAULT '0',
  `pencemaran_udara_total` int DEFAULT '0',
  `bahaya_temuan_lalu` int DEFAULT '0',
  `bahaya_temuan_bulan_ini` int DEFAULT '0',
  `bahaya_temuan_total` int DEFAULT '0',
  `bahaya_selesai_lalu` int DEFAULT '0',
  `bahaya_selesai_bulan_ini` int DEFAULT '0',
  `bahaya_selesai_total` int DEFAULT '0',
  `bahaya_sisa_lalu` int DEFAULT '0',
  `bahaya_sisa_bulan_ini` int DEFAULT '0',
  `bahaya_sisa_total` int DEFAULT '0',
  `inspeksi_temuan_lalu` int DEFAULT '0',
  `inspeksi_temuan_bulan_ini` int DEFAULT '0',
  `inspeksi_temuan_total` int DEFAULT '0',
  `inspeksi_selesai_lalu` int DEFAULT '0',
  `inspeksi_selesai_bulan_ini` int DEFAULT '0',
  `inspeksi_selesai_total` int DEFAULT '0',
  `inspeksi_sisa_lalu` int DEFAULT '0',
  `inspeksi_sisa_bulan_ini` int DEFAULT '0',
  `inspeksi_sisa_total` int DEFAULT '0',
  `alat_temuan_lalu` int DEFAULT '0',
  `alat_temuan_bulan_ini` int DEFAULT '0',
  `alat_temuan_total` int DEFAULT '0',
  `alat_selesai_lalu` int DEFAULT '0',
  `alat_selesai_bulan_ini` int DEFAULT '0',
  `alat_selesai_total` int DEFAULT '0',
  `alat_sisa_lalu` int DEFAULT '0',
  `alat_sisa_bulan_ini` int DEFAULT '0',
  `alat_sisa_total` int DEFAULT '0',
  `kegiatan_bulan_ini` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pelatihan_bulan_ini` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `induction_bulan_ini` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ringkasan_permasalahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `daftar_lampiran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rencana_bulan_depan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hse_monthly_reports`
--

INSERT INTO `hse_monthly_reports` (`id`, `work_schedule_id`, `hari_kerja_bulan_lalu`, `hari_kerja_bulan_ini`, `hari_kerja_total`, `manhours_lembur_bulan_lalu`, `manhours_lembur_bulan_ini`, `manhours_lembur_total`, `manhours_subkon_bulan_lalu`, `manhours_subkon_bulan_ini`, `manhours_subkon_total`, `total_manhours_bulan_lalu`, `total_manhours_bulan_ini`, `total_manhours_total`, `pekerja_kontraktor_utama`, `pekerja_subkon`, `total_pekerja`, `hse_manager`, `hse_coordinator`, `hse_supervisor`, `safety_engineer`, `safety_officer`, `safety_inspector`, `safety_administration`, `safety_man`, `paramedis`, `kasus_insiden_bulan_ini`, `kasus_insiden_total`, `fatality_bulan_ini`, `fatality_total`, `disability_bulan_ini`, `disability_total`, `medical_bulan_ini`, `medical_total`, `first_aid_bulan_ini`, `first_aid_total`, `property_damage_bulan_ini`, `property_damage_total`, `traffic_accident_bulan_ini`, `traffic_accident_total`, `near_miss_bulan_ini`, `near_miss_total`, `lost_time_bulan_ini`, `lost_time_total`, `kasus_penyakit_bulan_ini`, `kasus_penyakit_total`, `penyakit_kerja_bulan_ini`, `penyakit_kerja_total`, `penyakit_hubungan_kerja_bulan_ini`, `penyakit_hubungan_kerja_total`, `penyakit_biasa_bulan_ini`, `penyakit_biasa_total`, `lost_time_penyakit_bulan_ini`, `lost_time_penyakit_total`, `kasus_pencemaran_bulan_ini`, `kasus_pencemaran_total`, `pencemaran_air_bulan_ini`, `pencemaran_air_total`, `pencemaran_udara_bulan_ini`, `pencemaran_udara_total`, `bahaya_temuan_lalu`, `bahaya_temuan_bulan_ini`, `bahaya_temuan_total`, `bahaya_selesai_lalu`, `bahaya_selesai_bulan_ini`, `bahaya_selesai_total`, `bahaya_sisa_lalu`, `bahaya_sisa_bulan_ini`, `bahaya_sisa_total`, `inspeksi_temuan_lalu`, `inspeksi_temuan_bulan_ini`, `inspeksi_temuan_total`, `inspeksi_selesai_lalu`, `inspeksi_selesai_bulan_ini`, `inspeksi_selesai_total`, `inspeksi_sisa_lalu`, `inspeksi_sisa_bulan_ini`, `inspeksi_sisa_total`, `alat_temuan_lalu`, `alat_temuan_bulan_ini`, `alat_temuan_total`, `alat_selesai_lalu`, `alat_selesai_bulan_ini`, `alat_selesai_total`, `alat_sisa_lalu`, `alat_sisa_bulan_ini`, `alat_sisa_total`, `kegiatan_bulan_ini`, `pelatihan_bulan_ini`, `induction_bulan_ini`, `ringkasan_permasalahan`, `daftar_lampiran`, `rencana_bulan_depan`, `created_at`, `updated_at`) VALUES
(13, 50, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '2025-05-29 13:17:07', '2025-05-29 13:17:07'),
(14, 51, 3, 4, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '2025-05-29 13:17:55', '2025-05-29 13:17:55'),
(15, 52, 7, 2, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '2025-05-29 13:23:37', '2025-05-29 13:23:37'),
(17, 54, 0, 2, 2, 0, 384, 384, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '2025-06-02 05:02:15', '2025-06-02 05:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `identifikasi_aspek_dampak_lingkungan`
--

CREATE TABLE `identifikasi_aspek_dampak_lingkungan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_pengukuran_id` bigint UNSIGNED NOT NULL,
  `aktifitas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aspek_lingkungan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dampak_lingkungan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `risiko_lingkungan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `na_be` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_awal` tinyint UNSIGNED DEFAULT NULL,
  `c_awal` tinyint UNSIGNED DEFAULT NULL,
  `total_awal` tinyint UNSIGNED DEFAULT NULL,
  `l_akhir` tinyint UNSIGNED DEFAULT NULL,
  `c_akhir` tinyint UNSIGNED DEFAULT NULL,
  `total_akhir` tinyint UNSIGNED DEFAULT NULL,
  `tingkat_risiko_awal` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tingkat_risiko_akhir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengendalian_saat_ini` text COLLATE utf8mb4_unicode_ci,
  `pengendalian_lanjutan` text COLLATE utf8mb4_unicode_ci,
  `peluang` text COLLATE utf8mb4_unicode_ci,
  `peraturan_perundangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `no_dampak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `identifikasi_aspek_dampak_lingkungan`
--

INSERT INTO `identifikasi_aspek_dampak_lingkungan` (`id`, `user_id`, `batch_id`, `lokasi_pengukuran_id`, `aktifitas`, `aspek_lingkungan`, `dampak_lingkungan`, `risiko_lingkungan`, `na_be`, `l_awal`, `c_awal`, `total_awal`, `l_akhir`, `c_akhir`, `total_akhir`, `tingkat_risiko_awal`, `tingkat_risiko_akhir`, `pengendalian_saat_ini`, `pengendalian_lanjutan`, `peluang`, `peraturan_perundangan`, `created_at`, `updated_at`, `tahun`, `no_dampak`) VALUES
(7, 9, '4606581a-579f-475d-9cf2-9fdb7a0e6603', 3, 'Perkantoran', 'Timbulan\r\nlimbah padat\r\nnon organik', 'Pencemaran\r\ntanah', 'Merusak\r\nestetika dan\r\npenampilan', 'N', 3, 1, 3, 3, 1, 3, 'L', 'L', 'Pengumpulan\r\ndan\r\npembuangan ke\r\nTPA', 'Pengawasan rutin', NULL, 'PP No. 82 Thn\n2001', '2025-06-05 00:57:36', '2025-06-05 01:02:28', 2025, 'HTRK 1'),
(8, 9, '4606581a-579f-475d-9cf2-9fdb7a0e6603', 3, 'Penjagaan di Pos', 'Paparan debu', 'Pencemaran\r\nudara', 'Penurunan\r\nkualitas\r\nudara/kebersih\r\nan udara', 'N', 4, 1, 4, 4, 1, 4, 'L', 'L', 'Penghijauan,\r\npengukuran\r\nkualitas udara', 'Pelaksanaan\nProgram\nPenghijauan', NULL, 'PP NO. 22\nTAHUN 2021', '2025-06-05 00:57:36', '2025-06-05 01:02:28', 2025, 'HTRK 5');

-- --------------------------------------------------------

--
-- Table structure for table `ipbr`
--

CREATE TABLE `ipbr` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `lokasi_pengukuran_id` bigint UNSIGNED NOT NULL,
  `aktivitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `potensi_bahaya` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dampak_k3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l` tinyint UNSIGNED NOT NULL,
  `c` tinyint UNSIGNED NOT NULL,
  `total` tinyint UNSIGNED NOT NULL,
  `tingkat_risiko` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengendalian_saat_ini` text COLLATE utf8mb4_unicode_ci,
  `l_after` tinyint UNSIGNED DEFAULT NULL,
  `c_after` tinyint UNSIGNED DEFAULT NULL,
  `total_after` tinyint UNSIGNED DEFAULT NULL,
  `tingkat_risiko_after` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_n` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peraturan_perundangan` text COLLATE utf8mb4_unicode_ci,
  `pengendalian_lanjutan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tahun` year DEFAULT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resiko_k3` text COLLATE utf8mb4_unicode_ci,
  `no_dampak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peluang` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_inspeksi`
--

CREATE TABLE `jadwal_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `divisi_inspeksi_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_inspeksi` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `catatan` text,
  `status` enum('dijadwalkan','disetujui','selesai','dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'dijadwalkan',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_akhir` enum('menunggu_verifikasi','selesai') DEFAULT 'menunggu_verifikasi',
  `verifikasi_oleh` bigint UNSIGNED DEFAULT NULL,
  `verifikasi_tanggal` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_inspeksi`
--

INSERT INTO `jadwal_inspeksi` (`id`, `divisi_inspeksi_id`, `tanggal_inspeksi`, `jam_mulai`, `jam_selesai`, `catatan`, `status`, `created_by`, `created_at`, `updated_at`, `status_akhir`, `verifikasi_oleh`, `verifikasi_tanggal`) VALUES
(10, 42, '2025-06-10', '10:00:00', '12:00:00', NULL, 'selesai', 7, '2025-06-04 20:26:35', '2025-06-05 00:18:22', 'selesai', 7, '2025-06-05 00:18:22'),
(11, 41, '2025-06-12', '12:00:00', '14:00:00', NULL, 'dijadwalkan', 7, '2025-06-04 21:34:03', '2025-06-04 21:34:03', 'menunggu_verifikasi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_inspeksi_approvals`
--

CREATE TABLE `jadwal_inspeksi_approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `jadwal_inspeksi_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('approved','rejected') NOT NULL,
  `keterangan` text,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_lokasi`
--

CREATE TABLE `jadwal_lokasi` (
  `id` bigint UNSIGNED NOT NULL,
  `jadwal_id` bigint UNSIGNED NOT NULL,
  `lokasi_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_lokasi`
--

INSERT INTO `jadwal_lokasi` (`id`, `jadwal_id`, `lokasi_id`, `created_at`, `updated_at`) VALUES
(14, 12, 3, '2025-06-05 00:27:55', '2025-06-05 00:27:55'),
(15, 12, 4, '2025-06-05 00:27:55', '2025-06-05 00:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pengukuran`
--

CREATE TABLE `jadwal_pengukuran` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal_pengukuran` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('dijadwalkan','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'dijadwalkan',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `status_akhir` enum('menunggu_verifikasi','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'menunggu_verifikasi',
  `verifikasi_oleh` bigint UNSIGNED DEFAULT NULL,
  `verifikasi_tanggal` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_pengukuran`
--

INSERT INTO `jadwal_pengukuran` (`id`, `tanggal_pengukuran`, `jam_mulai`, `jam_selesai`, `catatan`, `status`, `created_by`, `status_akhir`, `verifikasi_oleh`, `verifikasi_tanggal`, `created_at`, `updated_at`) VALUES
(12, '2025-06-12', '12:00:00', '14:00:00', NULL, 'dijadwalkan', 7, 'menunggu_verifikasi', NULL, NULL, '2025-06-05 00:27:55', '2025-06-05 00:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_classifications`
--

CREATE TABLE `job_classifications` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_classifications`
--

INSERT INTO `job_classifications` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Kerja Panas', NULL, '2025-03-14 03:15:40', '2025-03-14 03:15:40'),
(13, 'Ketinggian', NULL, '2025-03-14 03:45:39', '2025-03-14 03:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `job_classification_safety_equipment`
--

CREATE TABLE `job_classification_safety_equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `job_classification_id` bigint UNSIGNED DEFAULT NULL,
  `safety_equipment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_classification_safety_equipment`
--

INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES
(24, 6, 3, '2025-03-17 03:58:07', '2025-03-17 03:58:07'),
(25, 6, 4, '2025-03-17 03:58:07', '2025-03-17 03:58:07'),
(26, 6, 10, '2025-03-17 03:58:07', '2025-03-17 03:58:07'),
(27, 6, 5, '2025-03-17 03:58:07', '2025-03-17 03:58:07'),
(28, 6, 11, '2025-03-17 03:58:07', '2025-03-17 03:58:07'),
(29, 13, 3, '2025-03-17 15:27:03', '2025-03-17 15:27:03'),
(30, 13, 4, '2025-03-17 15:27:03', '2025-03-17 15:27:03'),
(31, 13, 6, '2025-03-17 15:27:03', '2025-03-17 15:27:03'),
(32, 13, 7, '2025-03-17 15:27:03', '2025-03-17 15:27:03'),
(33, 13, 5, '2025-03-17 15:27:03', '2025-03-17 15:27:03'),
(35, 13, 9, '2025-03-17 15:27:03', '2025-03-17 15:27:03'),
(36, 6, 8, '2025-03-17 15:30:58', '2025-03-17 15:30:58'),
(37, 13, 10, '2025-03-17 15:31:08', '2025-03-17 15:31:08'),
(38, 13, 11, '2025-03-17 15:31:08', '2025-03-17 15:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nik`, `nama`) VALUES
(1, '2000045', 'MOKHAMAD  HASIM'),
(2, '2900024', 'NURIYATUL HIDAYAH'),
(3, '2000037', 'YUYUN PRASETYAWATI'),
(4, '2000053', 'NURIL MUSTAROKHAH'),
(5, '2000035', 'RIZQI LILIATI'),
(6, '2000051', 'ISKANDAR'),
(7, '2000067', 'FATHULLAH'),
(8, '2000030', 'NUR WIJAYANTO'),
(9, '2000069', 'SITI NUROHMATUN'),
(10, '2000046', 'ARY JULIA HARINI'),
(11, '2900036', 'KARTIKA APRILIANI'),
(12, '2000028', 'SATYA TERUNA'),
(13, '2900038', 'ANUNG NUGROHO'),
(14, '2000090', 'AYEP SOFYAN'),
(15, '2900004', 'KHANSA KAMILA'),
(16, '2000100', 'AGUS JOHANSYAH'),
(17, '2000093', 'SRI DEWI NUGRAHA'),
(18, '2000084', 'ANDI AZIS. US'),
(19, '2000073', 'NANA STIANA'),
(20, '2000082', 'MURAD'),
(21, '2000089', 'AGUS WIDIATMOKO'),
(22, '2000105', 'SLAMET SUHARTONO'),
(23, '2000072', 'AYI HERDIANA'),
(24, '2000019', 'JOKO BUDI SUSILO'),
(25, '2000141', 'UBAIDILLAH'),
(26, '2000109', 'VERDI WIANSYAH'),
(27, '2000143', 'AMPERA, US.'),
(28, '2000137', 'MAD SAFE\'I'),
(29, '2000878', 'AHMAD IQBAL'),
(30, '2900037', 'ABDUL LUTHFI MADJID'),
(31, '2000125', 'MULYADI'),
(32, '2210713', 'IIP ARIEF BUDIMAN'),
(33, '2000138', 'FATUROJI'),
(34, '2000166', 'GUNADI'),
(35, '2000145', 'IRFAN HARTAJI'),
(36, '2600109', 'MOHAMMAD TAUFIK HIDAYAT'),
(37, '2000163', 'FATHURROHMAN HB'),
(38, '2000175', 'SYECH HASAN'),
(39, '2000172', 'AJUDIN ISRO'),
(40, '2600099', 'VENA INDARIANI'),
(41, '2000196', 'SUWANTO'),
(42, '2000168', 'NURDIN'),
(43, '2000171', 'DONNY FAIZAL'),
(44, '2000167', 'SAHIDI'),
(45, '2000162', 'ANTOMI PURNAWAN'),
(46, '2000193', 'RULI KASRUDIN'),
(47, '2000191', 'YANNE EVA NURLITA'),
(48, '2000178', 'INU NUGRAHA'),
(49, '2000064', 'ANNA LESTIANA'),
(50, '2000066', 'SUKINO'),
(51, '2000233', 'RAHMATIKA'),
(52, '2002042', 'WIDODO'),
(53, '2000209', 'DINI PANGESTIKA'),
(54, '2000235', 'JON HERI'),
(55, '2000230', 'IRVAN HANAFI'),
(56, '2000234', 'NIA AZIZAH'),
(57, '2000199', 'NANANG MULYANA'),
(58, '2600147', 'MUHAMMAD RIZKY'),
(59, '2000200', 'RATIMAH'),
(60, '2002043', 'ARDIAN'),
(61, '2000169', 'WAHYUDI'),
(62, '2400004', 'HERMAWAN KRISNA PUTRA'),
(63, '2200020', 'ANDI YOSHENDY DJOKO S'),
(64, '2400008', 'NUR AMANIYAH'),
(65, '2000225', 'WAHYUKA NUR CAHYA'),
(66, '2200021', 'PRIYO BUDIANTO'),
(67, '2200023', 'SRIYANI PUSPA KINASIH'),
(68, '2200024', 'H EMBAY MULYA SYARIEF'),
(69, '2111460', 'ANDIKA BRANIDEL'),
(70, '2400001', 'ARRY SETYARTO'),
(71, '2100214', 'BAY BOWIE'),
(72, '2400010', 'ARI ASTIANA'),
(73, '2110670', 'LUKMAN HAKIM'),
(74, '2400003', 'ACHMAD INDRA PRASASTIAWAN'),
(75, '2400007', 'REKIY PUTRA'),
(76, '2111267', 'CUCU LASUBAN'),
(77, '2000098', 'SAEFUL ROCHMAN'),
(78, '2400016', 'EVY ZULFIKAR HILMAN'),
(79, '2400017', 'RADEN REZA GANESHA P'),
(80, '2600156', 'JAYANTI INDAH PUTRI'),
(81, '2600023', 'IDA MARYANA'),
(82, '2600035', 'MUHAMAD SAMSUDIN'),
(83, '2600005', 'IRWAN MAULANA HIDAYAT'),
(84, '2600046', 'RADEN ANDI WIDODO'),
(85, '2600003', 'ADE FARID'),
(86, '2600031', 'FERDIANSYAH TAFTAZANI'),
(87, '2400018', 'LAURENTIUS DWIKI ADI NARAHARYYA'),
(88, '2600025', 'MISYAIR'),
(89, '2500005', 'BOYKE WIBOWO MUKIYAT'),
(90, '2600043', 'TRI HANDOKO'),
(91, '2600056', 'RUDY HANDOKO'),
(92, '2900016', 'WISNU ADHI PRABOWO'),
(93, '2000177', 'HENI MULYANI'),
(94, '2600063', 'ASEP ROHMAT'),
(95, '2000165', 'ANDRI KURNIA RACHMAN'),
(96, '2600095', 'JAHRUDIN'),
(97, '2600115', 'SUROHIM'),
(98, '2600112', 'INDRA AGUSTIAN'),
(99, '2600128', 'FANNY PRASILIA'),
(100, '2600117', 'MAR\'I MUAMAR'),
(101, '2600120', 'ANGGUN MARATUS SOLIKHA'),
(102, '2600125', 'ARIS MAY RISQI'),
(103, '2600127', 'ANDRIAWAN SUPRIATNA'),
(104, '2600139', 'NAISYA RIZKINA DARAJAT'),
(105, '2600113', 'ALI ROHMAN'),
(106, '2600136', 'SUGIYANA'),
(107, '2600134', 'ANDRI MUHAMAD SYAH'),
(108, '2600158', 'PURBOYO ANANDA'),
(109, '2000103', 'NELSON POLUAKAN'),
(110, '2900012', 'IR. ANDI ISVANDIAR MULUK'),
(111, '2600135', 'NOVAL RIZKI'),
(112, '2600100', 'ABDUL RAHMANSYAH'),
(113, '2000049', 'NUGROHO INDRA SETIAWAN'),
(114, '2210760', 'SYAFIQ HADI'),
(115, '2900007', 'LINA YUNIATI SANTOSA'),
(116, '2900003', 'NURHADINI'),
(117, '2600132', 'DIAN PUSPITA SARI'),
(118, '333', 'Manager'),
(119, '2400009', 'MAFTUHI'),
(120, '2000202', 'YAYAN JULIANSYAH'),
(121, '000', 'IT Engineer'),
(122, '2000173', 'HADIAN HERDIANSYAH'),
(123, '2000192', 'MUHAMMAD YUNUS'),
(124, '2100200', 'INA KURNIAWATI AMELIA'),
(125, '2600024', 'M. NURMANSYAH'),
(126, '2000194', 'SUPRIADI'),
(127, '2000217', 'FIRLY DIANANDA'),
(128, '2900013', 'IVA NURJANAH'),
(129, '20011812', 'DIAN RUSDIANTO'),
(130, '2600142', 'SICILYA MERYKE'),
(131, '2600143', 'NUGROHO PRANOTO EDY'),
(132, '2900024', 'NURIYATUL HIDAYAH'),
(133, '2900018', 'INDRA LESMANA'),
(134, '2900017', 'MUHAMMAD IRFANSYAH POHAN'),
(135, '2900021', 'TIWIK ZUHRIAH'),
(136, '2900023', 'RAMDHANY YUDIASARI ADI PUTRI'),
(137, '2900020', 'SAEFULLOH'),
(138, '2900019', 'NADZAR HIJRIAWAN YACHYA SHOLECH'),
(139, '2900022', 'MIA ANISYA'),
(140, '2600144', 'LUCKY AGUSMAN SALIM'),
(141, '2000120', 'YOHA ARISTIAN'),
(142, '2400012', 'DIANA NUR AZIIZAH'),
(143, '2200026', 'REZA JAYA WARDHANA'),
(144, '2900020', 'SAEFULLOH'),
(145, '2400013', 'IMAM'),
(146, '444', 'Direksi'),
(147, '2900017', 'MUHAMMAD IRFANSYAH POHAN'),
(148, '2000113', 'AHMAD SUFIYAN'),
(149, '2900019', 'NADZAR HIJRIAWAN YACHYA SHOLECH'),
(150, '2000188', 'BUDI HARYADI'),
(151, '2000101', 'AGUS SYAHRUNA'),
(152, '2600111', 'IMAM EKA YASA'),
(153, '2000094', 'HERMAN AJI'),
(154, '2000198', 'IVAN YULIAN'),
(155, '2000021', 'DENY KUNTADI'),
(156, '2000034', 'LEILA NURSANTY'),
(157, '2900005', 'SUHERMAT'),
(158, '2000133', 'ROHANI'),
(159, '2900023', 'RAMDHANY YUDIASARI ADI PUTRI'),
(160, '2100256', 'ADITYA DARMAWAN'),
(161, '2000181', 'JEANI ROSDIANI'),
(162, '2002049', 'PAINO'),
(163, '2600143', 'NUGROHO PRANOTO EDY'),
(164, '2600140', 'JOKO TRIONO'),
(165, '2000179', 'SALAHUDIN'),
(166, '2600028', 'HARRY FUZAKI'),
(167, '2000197', 'ACHMAD TAUFANI'),
(168, '2400011', 'SATWIKA NARAHUTAMA'),
(169, '2400002', 'HARY RAHAYU'),
(170, '2900010', 'AHMAD SIDIQ SULAEMAN'),
(171, '2000119', 'CUCU NURDIN'),
(172, '2000026', 'INDRA HARDI'),
(173, '2400019', 'ELVIN RILDA FERNANDO'),
(174, '2111268', 'HERI HERYANA'),
(175, '2600022', 'ADI HENDRIANA'),
(176, '2000134', 'SRI ANDRIANI'),
(177, '2400006', 'DWI SUGENG UTOMO'),
(178, '2000144', 'SUHARNO'),
(179, '2900033', 'INDAH INDRIYANI'),
(180, '2600142', 'SICILYA MERYKE'),
(181, '2000140', 'BACHTIAR SOLEH'),
(182, '2900032', 'ISMA NAHDIA'),
(183, '2600144', 'LUCKY AGUSMAN SALIM'),
(184, '2000207', 'UCUP SUPRIATNA'),
(185, '2002048', 'ENDANG MANSYUR'),
(186, '2900031', 'YASMIN YUMNAA TSUROYYA'),
(187, '2000114', 'YAYAD SURADI'),
(188, '2000236', 'TRI SEPTIAWATI WIRDANINGSIH'),
(189, '2600105', 'SAPTONO'),
(190, '2000176', 'SAMSUL NANDAR'),
(191, '2400021', 'TIWIK ZUHRIAH'),
(192, '2000038', 'YERINA BOER'),
(193, '2600001', 'IIM ABDUL HAKIM'),
(194, '2000106', 'VALDY ROESMAHYONO'),
(195, '2600011', 'EKO WAHYUDI'),
(196, '2400014', 'FAJAR SURYANTO'),
(197, '2000070', 'MUHAMMAD ZAKKI'),
(198, '2400015', 'RAHMAT IAS'),
(199, '2600069', 'DEDI MAULANA'),
(200, '2000063', 'BAMBAM IBRAHIM'),
(201, '2900034', 'HARYADI'),
(202, '2000300', 'Nur Wijayanto'),
(203, '2900022', 'MIA ANISYA'),
(204, '2600080', 'WETI LIYATI'),
(205, '2600021', 'WAHID'),
(206, '2000102', 'SATIBI'),
(207, '2900028', 'ALIFFIAN GUSMA HENDRA'),
(208, '2600027', 'JUHENDI RIZQI'),
(209, '2000085', 'OLEH SALAHUDIN'),
(210, '2900015', 'BENNY SULISTIONO, S.E, M.M.'),
(211, '2000205', 'HARTONO'),
(212, '2600044', 'IMAM SAFEI'),
(213, '2000206', 'SUHENDAR'),
(214, '2600137', 'HARY YUNISA'),
(215, '2000099', 'YONI HESTY PRABOWO'),
(216, '2000231', 'RATU NIA NIHLATUN NISA'),
(217, '2000154', 'WISNU SASONGKO PUTRO'),
(218, '2600146', 'AHMAD HUSNAENI'),
(219, '2600055', 'SUPENDI'),
(220, '2000042', 'SUGENG RAHARDJO'),
(221, '555', 'Kadiv HC'),
(222, '2000088', 'M. SYAFEI'),
(223, '2000216', 'SILVIANITA PERMANDA'),
(224, '2000147', 'RATU SUSANTY'),
(225, '2000107', 'HENDI RUSTADI'),
(226, '2600124', 'FREDERIK MANUEL NAINGGOLAN'),
(227, '2110501', 'MASLIANDRI'),
(228, '2600057', 'MUHAMMAD IQBAL'),
(229, '2000111', 'LARASATI'),
(230, '2600141', 'RIKI SUHENDRIK'),
(231, '2000226', 'LAZUARDI ARSY'),
(232, '2000142', 'AAN SUHAEMI'),
(233, '2000075', 'AGUNG LAKSONO NUGROHO'),
(234, '222', 'Tester (DEV)'),
(235, '2400005', 'MUTHIA AZALIA'),
(236, '2600050', 'CHINTAMI RISTIANA'),
(237, '2000087', 'JOKO SUPRIANTO'),
(238, '2600150', 'RATNO SETIAWAN'),
(239, '2000122', 'KHAERUDIN'),
(240, '2000015', 'USEP SUPRIYADI'),
(241, '2600129', 'KEVIN RAMADHAN'),
(242, '2000211', 'SARTIKA'),
(243, '2000223', 'YULIA C'),
(244, '2000052', 'SLAMET EKO'),
(245, '111', 'Employee'),
(246, '2900014', 'MUHAMMAD SANJAYA'),
(247, '2000153', 'RIZAL AMIR'),
(248, '2900025', 'ARYO SUMARSONO'),
(249, '2000055', 'ELLY YULIUS MINDARA'),
(250, '2000213', 'PANJI BUANA PRATAMA'),
(251, '9800163', 'Iwan Supriyatno'),
(252, '9800165', 'Pradnatirta Syamsu Adjie'),
(253, '2600067', 'AANG KUSRONI'),
(254, '2000228', 'MUHAMMAD FATHUROZI'),
(255, '2000227', 'SITI BALQIS ARROHMAH'),
(256, '2110922', 'SYAMSUL MA\'ARIF'),
(257, '2600019', 'SOHARI'),
(258, '2600151', 'IMAM MUHAMAD RAMADHAN'),
(259, '2600153', 'ARBI BATTI NURAHMAN PRAMUDJI'),
(260, '2600154', 'INTAN NADE WINATA'),
(261, '12345678', 'Rusdianto (Test)'),
(262, '2000229', 'MUCHAMMAD FACHRI MAULANA'),
(263, '2000104', 'TB. BENNY KURNIAWAN'),
(264, '2600119', 'SUHENDRA'),
(265, '2000048', 'DEDI IRWAN. S'),
(266, '2000187', 'AGUS WAHYUDI'),
(267, '2600054', 'SULIS TAOVIK VAOZI'),
(268, '2600081', 'SANWANI'),
(269, '2000127', 'AHMAD IQBAL'),
(270, '2600122', 'AGUS PUJIANTO'),
(271, '2600138', 'GAGAS ALFIANA'),
(272, '2001142', 'AAN SUHAEMI'),
(273, '2200185', 'NIA NINFA NOVIA'),
(274, '2600148', 'KHRISNA DEWA SAKTI'),
(275, '2500010', 'RURY ILHAM'),
(276, '2000218', 'FARAH DINAH HANDRIANI'),
(277, '2600088', 'RENI RAHMAWATI'),
(278, '2900115', 'BENNY SULISTIONO, S.E, M.M.'),
(279, '2000095', 'SUSAEDI'),
(280, '2900026', 'KARINA ADIKUSUMANINGTYAS'),
(281, '2210256', 'GERSANG TARIGAN'),
(282, '2900027', 'SEILA DELFINA HARIANJA'),
(283, '2600155', 'IIM HERMAWAN'),
(284, '2112298', 'EKA IRAWAN, ST'),
(285, '2600160', 'KURNIAWAN YUDHO R'),
(286, '2000164', 'YUNI WITRIANI'),
(287, '2000097', 'RIZKIE  WULANSARI'),
(288, '2000201', 'SACHRUL PURNAMA'),
(289, '3456789', 'auora'),
(290, '2600152', 'BUDI SENTOSO'),
(291, '2600159', 'JUHANDA'),
(292, '2900039', 'ABDUL RIFAI'),
(293, '2900030', 'RIDWAN SATRIA WICAKSANA'),
(294, '2000186', 'SALMAN'),
(295, '2600121', 'DEDE KURNIADI'),
(296, '2600123', 'SANDY EKA HADIPUTRA'),
(297, '2600079', 'SAHRUDIN'),
(298, '2600118', 'TAUFIK HIDAYAH'),
(299, '2600029', 'SYAFIIN'),
(300, '2000132', 'WAWAN SETIAWAN'),
(301, '2000130', 'HAMAMI A'),
(302, '2500018', 'KIKI MARZUKI'),
(303, '2900029', 'IRFAN FAUZAN'),
(304, '2600157', 'MULYA JATIASMARA'),
(305, '2600002', 'WAGIYO'),
(306, '2100107', 'HENDI RUSTADI'),
(307, '2000185', 'EDI YANTO'),
(308, '2400020', 'GUSNETY MUMTAZ'),
(309, '2600145', 'Yuda Feryandi'),
(310, '2000108', 'HANDI HARIVAN'),
(311, '2000204', 'SUPRIYANTO'),
(312, '2200025', 'MOCH TAUFIK NURDAIMAN'),
(313, '2000116', 'NURYASIN MUSTOFA KASTOERI'),
(314, '2900018', 'INDRA LESMANA'),
(315, '2000146', 'DIKI MEISANO SYAEFUDIN'),
(316, '2600149', 'LILI KUSNADI'),
(317, '2210000', 'Bagus'),
(318, '2000183', 'MUSTAUFIK HIDAYATULLOH'),
(319, '2210324', 'DAZUL HERMAN'),
(320, '2900035', 'RIZWAN RAMADHAN WIBIKSANA'),
(321, '2600017', 'DEDEN HIDAYAT');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_inspeksi`
--

CREATE TABLE `kategori_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_inspeksi`
--

INSERT INTO `kategori_inspeksi` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Kondisi Keselamatan Umum', '2025-05-01 15:17:39', '2025-05-18 19:15:21'),
(2, 'Pencegahan & Pengendalian Kebakaran', '2025-05-01 16:03:17', '2025-05-01 16:03:17'),
(3, 'Kesehatan & Lingkungan Kerja', '2025-05-02 02:41:35', '2025-05-02 02:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `lokasis`
--

CREATE TABLE `lokasis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasis`
--

INSERT INTO `lokasis` (`id`, `nama_lokasi`, `created_at`, `updated_at`) VALUES
(3, 'Wisma Group', '2025-06-04 07:48:18', '2025-06-04 07:48:18'),
(4, 'Human Capital', '2025-06-04 16:03:54', '2025-06-04 16:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_pengukuran`
--

CREATE TABLE `lokasi_pengukuran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi_pengukuran`
--

INSERT INTO `lokasi_pengukuran` (`id`, `nama_lokasi`, `alamat`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Wisma Grup', NULL, NULL, '2025-05-13 13:30:41', '2025-05-13 13:30:41'),
(2, 'Perhotelan', NULL, NULL, '2025-05-13 13:32:31', '2025-05-13 13:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `materihead`
--

CREATE TABLE `materihead` (
  `id` int NOT NULL,
  `groupnm` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `mcu`
--

CREATE TABLE `mcu` (
  `id` int NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_mcu` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcu`
--

INSERT INTO `mcu` (`id`, `nik`, `nama`, `file_mcu`, `tanggal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '2000226', 'LAZUARDI ARSY', 'mcu/alF17581B0123AzPFrfH2Aidx1sj6anPiUug7Z9h.pdf', '2025-04-26', 'Example MCU', '2025-04-26 16:33:58', '2025-04-26 16:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `mcu_records`
--

CREATE TABLE `mcu_records` (
  `id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `a` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `b` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `c` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `d` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `e` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `f` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `g` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `h` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `i` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `j` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `k` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `l` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `m` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `n` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `o` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `p` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `q` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `r` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `s` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `t` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `u` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `v` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `w` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `x` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `y` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `z` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `aa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ab` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ac` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ae` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `af` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `aj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ak` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `al` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `am` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `an` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ap` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `aq` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `as` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `au` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `av` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `aw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ay` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `az` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ba` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bb` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `be` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bf` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bq` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `br` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bv` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bx` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `by` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ca` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cb` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ce` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cf` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ch` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ci` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ck` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `co` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cq` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ct` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cv` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cx` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `da` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `db` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `de` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `df` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `di` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `do` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dq` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ds` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `du` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dv` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dx` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ea` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `eb` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ec` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ee` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ef` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `eg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `eh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcu_records`
--

INSERT INTO `mcu_records` (`id`, `created_at`, `updated_at`, `a`, `b`, `c`, `d`, `e`, `f`, `g`, `h`, `i`, `j`, `k`, `l`, `m`, `n`, `o`, `p`, `q`, `r`, `s`, `t`, `u`, `v`, `w`, `x`, `y`, `z`, `aa`, `ab`, `ac`, `ad`, `ae`, `af`, `ag`, `ah`, `ai`, `aj`, `ak`, `al`, `am`, `an`, `ao`, `ap`, `aq`, `ar`, `as`, `at`, `au`, `av`, `aw`, `ax`, `ay`, `az`, `ba`, `bb`, `bc`, `bd`, `be`, `bf`, `bg`, `bh`, `bi`, `bj`, `bk`, `bl`, `bm`, `bn`, `bo`, `bp`, `bq`, `br`, `bs`, `bt`, `bu`, `bv`, `bw`, `bx`, `by`, `bz`, `ca`, `cb`, `cc`, `cd`, `ce`, `cf`, `cg`, `ch`, `ci`, `cj`, `ck`, `cl`, `cm`, `cn`, `co`, `cp`, `cq`, `cr`, `cs`, `ct`, `cu`, `cv`, `cw`, `cx`, `cy`, `cz`, `da`, `db`, `dc`, `dd`, `de`, `df`, `dg`, `dh`, `di`, `dj`, `dk`, `dl`, `dm`, `dn`, `do`, `dp`, `dq`, `dr`, `ds`, `dt`, `du`, `dv`, `dw`, `dx`, `dy`, `dz`, `ea`, `eb`, `ec`, `ed`, `ee`, `ef`, `eg`, `eh`) VALUES
(1, '2025-05-23 06:58:51', '2025-05-23 06:58:51', '1', '18/02/2025', NULL, NULL, NULL, NULL, NULL, 'SILOAM HOSPITALS LIPPO VILLAGE', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'tidak', 'tidak', 'ya: Durasi: >90 menit', 'Extreme temperature:Heat: Yes ,Non-ionizing radiation: Yes ,Dust: Yes ,Manual handling: Yes ,Akward posture: Yes ,Repetitive movement: Yes ,Static position: Yes ,Microorganism: Yes ,Insect: Yes ,Excessive workload: Yes ,Long working hour: Yes ,Workplace violence: Yes ,Conflicts at the workplace: Yes', 'Extreme temperature:Heat: Yes ,Dust: Yes ,Manual handling: Yes ,Akward posture: Yes ,Repetitive movement: Yes ,Static position: Yes ,Microorganism: Yes ,Insect: Yes ,Excessive workload: Yes ,Long working hour: Yes ,Workplace violence: Yes ,Conflicts at the workplace: Yes', '114', '70', '60', '163.5', '66.8', '24.99', 'Overweight', '91', '-', 'Normal', 'Normal', 'Normal', 'Normal', '20/20', '20/20', 'Normal', 'Tidak Ikterik', 'Tidak Anemis', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Simetris', 'Simetris', 'Simetris', 'Simetris', 'Normal', 'Normal', 'Normal', 'Negative ischemic response', 'Skoliosis vertebra thorakalis ke kanan', 'Normal', '-', 'Asam urat meningkat, Kolesterol LDL meningkat, Urinalisis Abnormal', 'Diet rendah asam urat/purin (hindari jeroan, alkohol, seafood), Olahraga teratur minimal 3 kali seminggu (kurang lebih 30menit tiap kali olahraga), Diet rendah lemak (kurangi  gorengan, daging merah, fast food, produk daging olahan, keju, es krim, santan, mentega dan margarin), Perbanyak minum air putih 8 gelas atau 2 liter per hari, Tidak menahan buang air kecil', 'Konsultasi dokter Spesialis Penyakit Dalam', 'Sementara Tidak Fit', 'LDL 226.3', '15.4', '45.4', '5.1', '9.0', '0', '3', '3', '44', '42', '8', '366', '10', '88.5', '30.0', '33.9', '33', '27', '-', '-', '28', '0.99', '93', '8.0', '293', '293', '48.9', '48.9', '226.3', '89', '5.99', '-', '-', '-', '103', '-', '-', '-', '-', 'Kuning Tua', 'Agak Keruh', '1.022', '5.0', '2+', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Normal', 'Negatif', '1+', '7.7', '528.20', '0.40', '0.9', '0.0', 'Negatif'),
(2, '2025-05-23 06:58:51', '2025-05-23 06:58:51', '2', '18/02/2025', NULL, NULL, NULL, NULL, NULL, 'SILOAM HOSPITALS LIPPO VILLAGE', 'ya, Vitamin D, Metformin, clopidogrel', '-', 'ya', '-', 'ya', '-', 'Hepatitis A, ya,Hepatitis B, ya,Influenza, ya', 'tidak', 'ya', '-', 'ya', '-', 'tidak', 'ya: sejak usia 27 tahun', 'ya: Durasi: >90 menit', 'Static position: Yes ,Prolonged computer work: Yes', 'Static position: Yes ,Prolonged computer work: Yes', '120', '75', '74', '168', '71.8', '25.44', 'Obese 1', '74', 'Jari tengah tangan kanan bangun tidur terasa kaku', 'Normal', 'Normal', 'Normal', 'Normal', '20/30', '20/30', 'Normal', 'Tidak Ikterik', 'Tidak Anemis', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Abnormal, Calculus (karang gigi)', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Tidak Simetris, -', 'Tidak Simetris, -', 'Tidak Simetris, -', 'Tidak Simetris, -', 'Normal', 'Normal', 'Normal', 'Abnormal, Suggestive Positive Ischemic Response', 'Skoliosis vertebra thorakalis ke kanan', 'Fatty liver grade I, Kalsifikasi prostat', '-', 'Fatty liver grade I, Skoliosis ringan thoracal ke kanan, Abnormal Treadmill Test, Diabetes mellitus dalam pengobatan, Anomali refraksi, Calculus gigi, Trigger finger, BMI (Body Mass Index) : Obesitas Class I, Laju endap darah (ESR) meningkat, Eosinofil meningkat, Kalsifikasi prostat, Gula darah puasa meningkat, SGPT meningkat', 'Diet rendah lemak dan kolesterol, Hindari mengangkat beban berat, DSCT coroner, Echocardiography, Minum obat teratur, Evaluasi gula darah dan cek HbA1c, Diet rendah karbohidrat/gula, Hindari konsumsi nasi dalam porsi banyak , hindari minum-minuman manis berkalori tinggi, bersoda, dan madu, Gunakan kacamata sesuai visus dan kontrol mata setiap 1 tahun, Scalling, Diet rendah kalori, Turunkan berat badan, Olahraga rutin 5 kali seminggu dengan durasi masing-masing minimal 30 menit, Istirahat cukup, Tingkatkan daya tahan tubuh, Hindari pencetus alergi bila terdapat riwayat alergi, Periksa Total PSA / Free PSA, Evaluasi gula darah dan cek HbA1c, Diet rendah karbohidrat/gula, Hindari konsumsi nasi dalam porsi banyak , hindari minum-minuman manis berkalori tinggi, bersoda, dan madu, Evaluasi fungsi hati', 'Konsultasi dokter Spesialis Jantung, Kontrol teratur ke dokter Spesialis Penyakit Dalam, Konsultasi dokter Spesialis Mata, Konsultasi dokter Gigi untuk perawatan gigi, Konsultasi dokter Spesialis Ortopedi, Konsultasi dokter Spesialis Gizi Klinik, Konsultasi ke dokter Spesialis Urologi', 'Sementara Tidak Fit', 'Suggestive positive Ischemic Response', '14.6', '43.1', '4.8', '8.2', '1', '8', '2', '48', '33', '8', '257', '47', '89.4', '30.3', '33.9', '38', '75', '-', '-', '19', '0.96', '97', '3.6', '159', '159', '44.6', '44.6', '99.4', '75', '3.57', '-', '-', '-', '168', '-', '-', '-', '-', 'Kuning', 'Bersih / Jernih', '1.006', '7.0', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Normal', 'Negatif', 'Negatif', '0.1', '0.10', '0.30', '0.0', '0.0', 'Negatif'),
(3, '2025-05-23 06:58:51', '2025-05-23 06:58:51', '3', '18/02/2025', NULL, NULL, NULL, NULL, NULL, 'SILOAM HOSPITALS LIPPO VILLAGE', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'ya', '-', 'tidak', 'ya: Sejak 20 tahun', 'ya: Durasi: >90 menit', 'Noise: Yes ,Extreme temperature:Heat: Yes ,Extreme temperature:Cold: Yes ,Repetitive movement: Yes ,Microorganism: Yes ,Rodent: Yes ,Conflicts at the workplace: Yes', 'Repetitive movement: Yes ,Prolonged computer work: Yes ,Microorganism: Yes ,Rodent: Yes ,Conflicts at the workplace: Yes', '110', '66', '64', '178', '65.5', '20.67', 'Normal', '81', '-', 'Normal', 'Normal', 'Normal', 'Normal', '20/20', '20/20', 'Normal', 'Tidak Ikterik', 'Tidak Anemis', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Abnormal, Calculus', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Simetris', 'Simetris', 'Simetris', 'Simetris', 'Normal', 'Normal', 'Normal', 'Negative Ischemic Response', 'Normal', 'Fatty Liver', '-', 'Kebiasaan merokok, Kolesterol total dan LDL meningkat, Anemia, Fatty liver, Calculus gigi', 'Berhenti merokok, Olahraga teratur minimal 3 kali seminggu (kurang lebih 30menit tiap kali olahraga), Diet rendah lemak (kurangi  gorengan, daging merah, fast food, produk daging olahan, keju, es krim, santan, mentega dan margarin), Cek ulang lipid profile / kolesterol 3 bulan depan, Evaluasi anemia, Diet tinggi zat besi (sayuran hijau seperti bayam, brokoli, edamame, kacang merah, tahu, ikan seperti salmon, tuna, sarden), Diet rendah lemak atau kolesterol, Scalling', 'Konsultasi dokter Spesialis Penyakit Dalam, Konsultasi dokter Gigi untuk perawatan gigi', 'Fit dengan Catatan', 'null', '11.7', '37.0', '4.1', '5.6', '1', '10', '2', '55', '25', '7', '258', '17', '90.0', '28.5', '31.6', '20', '17', '-', '-', '19', '1.17', '83', '4.8', '213', '213', '57.7', '57.7', '131.1', '121', '3.69', '-', '-', '-', '87', '-', '-', '-', '-', 'Kuning', 'Bersih / Jernih', '1.008', '6.5', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Normal', 'Negatif', 'Negatif', '0.5', '1.20', '0.40', '0.0', '0.0', 'Negatif'),
(4, '2025-05-23 06:58:51', '2025-05-23 06:58:51', '4', '18/02/2025', NULL, NULL, NULL, NULL, NULL, 'SILOAM HOSPITALS LIPPO VILLAGE', 'ya, Amlodipine', 'ya', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'tidak', 'ya: 10 batang/ hari', 'tidak', '-', '-', '143', '90', '66', '170', '74.1', '25.64', 'Obese 1', '94', '-', 'Normal', 'Normal', 'Normal', 'Buta Warna Parsial', '20/20 + kaca mata', '20/20 + kaca mata', 'Normal', 'Tidak Ikterik', 'Tidak Anemis', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Abnormal, Calculus (karang gigi)', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Simetris', 'Simetris', 'Simetris', 'Simetris', 'Normal', 'Normal', 'Normal', 'Negative ischemic response', 'Normal', 'Fatty liver', '-', 'LDL kolesterol meningkat dan HDL kolesterol menurun, Buta warna parsial (Defisiensi merah dan hijau), Hipertensi dalam pengobatan, Calculus gigi, Kebiasaan merokok, BMI (Body Mass Index) : Obesitas Class I, Fatty liver, Asam urat meningkat', 'Olahraga teratur minimal 3 kali seminggu (kurang lebih 30menit tiap kali olahraga), Diet rendah lemak atau kolesterol, Perbanyak asupan Omega 3, Hindari pekerjaan yang membutuhkan ketelitian warna, Minum obat teratur, Diet rendah garam dan evaluasi tekanan darah, Scalling, Berhenti merokok, Diet rendah kalori, Turunkan berat badan, Diet rendah lemak atau kolesterol, Diet rendah asam urat/purin (hindari jeroan, alkohol, seafood)', 'Konsultasi dokter Spesialis Mata, Konsultasi dokter Gigi untuk perawatan gigi, Konsultasi dokter Spesialis Penyakit Dalam', 'Fit dengan Restriksi', 'null', '14.6', '43.5', '4.9', '8.1', '1', '6', '2', '64', '21', '6', '278', '10', '88.1', '29.6', '33.6', '28', '41', '-', '-', '24', '0.98', '95', '8.5', '166', '166', '35', '35.0', '108.4', '113', '4.74', '-', '-', '-', '92', '-', '-', '-', '-', 'Kuning', 'Bersih / Jernih', '1.018', '7.0', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Negatif', '1', 'Negatif', 'Negatif', '1.7', '2.50', '0.90', '0.0', '0.0', 'Negatif'),
(5, '2025-05-23 06:58:52', '2025-05-23 06:58:52', '5', '18/02/2025', NULL, NULL, NULL, NULL, NULL, 'SILOAM HOSPITALS LIPPO VILLAGE', 'ya, Amlodipine', 'ya', '-', '-', '-', '-', 'Hepatitis A, ya,Hepatitis B, ya,Influenza, ya', 'ya', '-', '-', 'ya', '-', '-', 'ya: sejak umur 20 tahun', 'tidak', '-', 'Extreme temperature:Heat: Yes ,Repetitive movement: Yes', '134', '88', '63', '159', '50.1', '19.82', 'Normal', '74', '-', 'Normal', 'Normal', 'Normal', 'Buta Warna Parsial', '20/20', '20/20', 'Normal', 'Tidak Ikterik', 'Tidak Anemis', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Abnormal, Calculus, Radix', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Simetris', 'Simetris', 'Simetris', 'Simetris', 'Normal', 'Normal', 'Normal', 'Negative Ischemic Response', 'TB Paru aktif (Tidak Tampak Kardiomegali)', 'Normal', '-', 'Calculus dan Radix, LDL kolesterol sedikit meningkat, TB Paru Aktif, Urinalisis Abnormal, Hipertensi dalam pengobatan, Buta warna parsial (Defisiensi merah dan hijau), Kebiasaan merokok', 'Scalling, Ekstraksi gigi, Olahraga teratur minimal 3 kali seminggu (kurang lebih 30menit tiap kali olahraga), Diet rendah lemak (kurangi  gorengan, daging merah, fast food, produk daging olahan, keju, es krim, santan, mentega dan margarin), Lakukan pemeriksaan lanjutan sputum BTA 2x atau Genexpert, Perbanyak minum air putih 8 gelas atau 2 liter per hari, Tidak menahan buang air kecil, Minum obat teratur, Diet rendah garam dan evaluasi tekanan darah, Hindari pekerjaan yang membutuhkan ketelitian warna, Berhenti merokok', 'Konsultasi dokter Gigi untuk perawatan gigi, Konsultasi dokter Spesialis Penyakit Dalam bila ada keluhan, Konsultasi dokter Spesialis Paru, Konsultasi dokter Spesialis Jantung, Konsultasi dokter Spesialis Mata', 'Sementara Tidak Fit', 'TB Paru aktif', '14.9', '44.5', '5.0', '6.5', '1', '3', '2', '48', '37', '9', '315', '21', '89.7', '30.0', '33.5', '21', '13', '-', '-', '25', '1.00', '92', '5.6', '191', '191', '58.2', '58.2', '112.2', '103', '3.28', '-', '-', '-', '88', '-', '-', '-', '-', 'Kuning', 'Agak Keruh', '1.010', '6.0', '1+', 'Negatif', 'Negatif', 'Negatif', 'Negatif', 'Normal', 'Negatif', 'Negatif', '1.2', '15.00', '0.60', '0.1', '0.0', 'Negatif');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `sortid` smallint DEFAULT NULL,
  `displaytext` varchar(50) DEFAULT NULL,
  `basedir` varchar(100) DEFAULT NULL,
  `linkaddress` varchar(50) DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Krakatau Sarana Properti', NULL, '#', '1', '2025-03-28 09:56:02', '2025-04-15 19:08:05'),
(2, 1, 1, 'Administrasi', 'Setting', '#', '1', '2025-03-28 10:37:55', '2025-04-15 19:08:08'),
(3, 2, 1, 'Menu Aplikasi', NULL, '/admin/menus', '1', '2025-03-28 14:47:04', '2025-04-15 18:49:07'),
(4, 2, 2, 'Role', NULL, '/admin/role', '1', '2025-03-28 14:47:26', '2025-04-15 18:49:19'),
(5, 2, 3, 'Role Menu', NULL, '0', '0', '2025-03-28 14:48:04', '2025-04-19 09:44:26'),
(6, 1, 2, 'Master Data', 'Category', '#', '1', '2025-03-28 14:48:18', '2025-04-15 19:08:10'),
(7, 6, 1, 'Unit Kerja', NULL, '0', '1', '2025-03-28 14:48:40', '2025-06-04 21:07:30'),
(8, 6, 2, 'Vendor Menajemen', NULL, '/admin/vendors', '1', '2025-03-28 14:49:08', '2025-04-15 18:49:36'),
(9, 6, 3, 'Klasifikasi Pekerjaan', NULL, '/admin/klasifikasi-pekerjaan', '1', '2025-03-28 14:49:25', '2025-04-15 19:53:02'),
(10, 6, 4, 'Pekerjaan', NULL, '/admin/purchase-orders', '1', '2025-03-28 14:49:53', '2025-04-16 06:45:55'),
(11, 1, 3, 'Work Permit', 'Document', '#', '1', '2025-03-28 14:50:26', '2025-04-15 19:08:13'),
(12, 11, 1, 'Pengajuan', NULL, '/permit/po', '1', '2025-03-28 14:51:07', '2025-04-16 19:07:54'),
(13, 11, 2, 'Monitoring', NULL, '/permit/jam-kerja', '1', '2025-03-28 14:51:20', '2025-05-07 13:04:33'),
(14, 1, 4, 'Inspeksi K3LH', 'Info-circle', '#', '1', '2025-03-28 14:52:40', '2025-04-15 19:08:15'),
(15, 2, 4, 'User Manajemen', NULL, '/admin/user', '1', '2025-03-31 04:39:49', '2025-04-19 02:40:30'),
(16, 14, 1, 'Jadwal Inspeksi', NULL, '/inspeksi/jadwal-inspeksi', '1', '2025-04-01 07:39:40', '2025-05-11 04:45:50'),
(17, 14, 2, 'Hasil Inspeksi', NULL, '/inspeksi/hasil-inspeksi', '1', '2025-04-01 07:40:10', '2025-05-11 06:34:11'),
(19, 14, 3, 'Kategori Inspeksi', NULL, '/inspeksi/kategori-inspeksi', '1', '2025-05-10 20:27:20', '2025-05-10 20:27:51'),
(20, 1, 5, 'Pengukuran Kualitas Kerja', 'Info-circle', '#', '1', '2025-05-12 15:08:34', '2025-05-13 20:30:27'),
(21, 20, 1, 'Lokasi', NULL, '/lingkungan/lokasi-divisi', '1', '2025-05-12 15:09:32', '2025-06-04 07:46:36'),
(22, 20, 2, 'Jadwal Pengukuran', NULL, '/lingkungan/jadwal-pengukuran', '1', '2025-05-13 13:59:33', '2025-05-13 13:59:33'),
(23, 20, 3, 'Hasil Pengukuran', NULL, '/lingkungan/hasil-pengukuran', '1', '2025-05-14 11:01:00', '2025-05-14 11:01:00'),
(24, 11, 5, 'MCU', NULL, '/admin/mcu', '1', '2025-03-28 14:51:20', '2025-05-08 16:55:28'),
(25, 11, 6, 'PKL', NULL, '/admin/folders', '1', '2025-03-28 14:51:20', '2025-05-08 16:55:29'),
(26, 11, 8, 'Setting Notifikasi', NULL, '/admin/setting_notifikasi', '1', '2025-05-08 16:49:51', '2025-05-09 13:00:32'),
(27, 11, 7, 'History PKL', NULL, '/admin/history_storage', '1', '2025-05-08 16:49:51', '2025-05-09 13:06:32'),
(28, 20, 4, 'IADL', NULL, '/lingkungan/iadl', '1', '2025-05-24 13:06:46', '2025-05-24 13:06:46'),
(29, 20, 5, 'IPBR', NULL, '/lingkungan/ipbr', '1', '2025-05-25 16:55:58', '2025-05-25 16:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_24_043206_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 2),
(8, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 8),
(8, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('010c0bb6-f4f9-4f09-b103-ac8bc4d84866', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 11:06:31', '2025-04-14 11:06:31'),
('0b821273-0b71-4cfe-9aec-560f8432008c', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 11:06:30', '2025-04-14 11:06:30'),
('1181f3d2-6700-49dd-9ac1-8278aa80a49d', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTM=\"}', NULL, '2025-04-09 11:40:30', '2025-04-09 11:40:30'),
('3cf12dc2-7299-4fa0-88ea-c990793a97ac', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', '2025-04-14 06:55:27', '2025-04-09 21:01:59', '2025-04-14 06:55:27'),
('41cde5d2-6825-44e6-b95d-f7466ef95c3b', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 10:56:31', '2025-04-14 10:56:31'),
('436238c6-3e7d-40ea-98a5-4f80c8ca3e33', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTM=\"}', '2025-04-09 11:40:43', '2025-04-09 11:40:30', '2025-04-09 11:40:43'),
('5360c3fe-f918-4662-924e-08fc0fe2c822', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', '2025-04-14 06:57:08', '2025-04-09 21:02:00', '2025-04-14 06:57:08'),
('558695c6-da45-475e-b436-5c9415c3848f', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 11:06:30', '2025-04-14 11:06:30'),
('5a377e75-2d94-42f2-963d-9f3eaa93bf0f', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', '2025-04-09 20:52:44', '2025-04-09 20:48:32', '2025-04-09 20:52:44'),
('5d63fd95-a143-49bc-8468-a304f9b203a2', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', '2025-04-14 06:56:12', '2025-04-09 21:02:00', '2025-04-14 06:56:12'),
('6a63a496-d1b5-4a9e-aaa0-81b02c028561', 'App\\Notifications\\PurchaseOrderCreatedNotification', 'App\\Models\\User', 2, '{\"title\":\"PO Baru Diterbitkan\",\"message\":\"PO No. PO\\/IV\\/2025\\/001 telah diterbitkan.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/vendor\\/po\"}', '2025-04-09 05:52:36', '2025-04-09 05:52:02', '2025-04-09 05:52:36'),
('6d712a8b-ee81-42c1-a64b-41346d12850e', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTM=\"}', NULL, '2025-04-09 11:40:30', '2025-04-09 11:40:30'),
('83e4533d-4020-4412-bec9-a369c49e5337', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTM=\"}', NULL, '2025-04-09 11:40:30', '2025-04-09 11:40:30'),
('8bdeb4b9-d9e9-4547-b5ae-36d7a511d338', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', '2025-04-09 20:50:25', '2025-04-09 20:48:32', '2025-04-09 20:50:25'),
('9e6669ed-7477-4a2a-a0a6-915c999ea845', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 10:56:31', '2025-04-14 10:56:31'),
('a911473b-b5d5-4913-bba5-b282e637425b', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-09 21:02:00', '2025-04-09 21:02:00'),
('ad7cba4c-f93b-43e0-99b9-ace24f910896', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 11:06:30', '2025-04-14 11:06:30'),
('afb8c5d8-60cb-466a-b61a-bef4a91b0545', 'App\\Notifications\\PurchaseOrderCreatedNotification', 'App\\Models\\User', 2, '{\"title\":\"PO Baru Diterbitkan\",\"message\":\"PO No. PO\\/IV\\/2025\\/002 telah diterbitkan.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/vendor\\/po\"}', NULL, '2025-04-09 20:41:28', '2025-04-09 20:41:28'),
('bfa64935-df1c-4c47-ad89-7c28ffa25f15', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', '2025-04-09 20:51:37', '2025-04-09 20:48:32', '2025-04-09 20:51:37'),
('c23e724c-f75f-49df-978a-88700a838378', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-09 20:48:32', '2025-04-09 20:48:32'),
('c77155b7-5fa3-4bf2-b85f-d3d51a3f5aa6', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 10:56:31', '2025-04-14 10:56:31'),
('e5def70c-b4dd-4bb1-b865-8abb1c07d62f', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 10:56:31', '2025-04-14 10:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_pembatalan`
--

CREATE TABLE `pengajuan_pembatalan` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_order_id` bigint UNSIGNED DEFAULT NULL,
  `pengaju_id` bigint UNSIGNED DEFAULT NULL,
  `alasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('diajukan','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'diajukan',
  `dibatalkan_oleh` enum('pengawas','pemilik_area','she_officer','she_manager') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disetujui_pada` timestamp NULL DEFAULT NULL,
  `ditolak_pada` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_penyelesaian`
--

CREATE TABLE `pengajuan_penyelesaian` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_order_id` bigint UNSIGNED NOT NULL,
  `alasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('draft','selesai') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_penyelesaian`
--

INSERT INTO `pengajuan_penyelesaian` (`id`, `purchase_order_id`, `alasan`, `created_at`, `updated_at`, `status`) VALUES
(12, 32, 'Pengajuan penyelesaian pekerjaan oleh vendor', '2025-05-29 13:36:24', '2025-05-29 14:29:44', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `pengukuran_lingkungan`
--

CREATE TABLE `pengukuran_lingkungan` (
  `id` bigint UNSIGNED NOT NULL,
  `jadwal_id` bigint UNSIGNED NOT NULL,
  `divisi_id` bigint UNSIGNED NOT NULL,
  `cahaya_1` float DEFAULT NULL,
  `cahaya_2` float DEFAULT NULL,
  `cahaya_3` float DEFAULT NULL,
  `cahaya_rata2` float DEFAULT NULL,
  `suhu_1` float DEFAULT NULL,
  `suhu_2` float DEFAULT NULL,
  `suhu_3` float DEFAULT NULL,
  `suhu_rata2` float DEFAULT NULL,
  `kelembaban_1` float DEFAULT NULL,
  `kelembaban_2` float DEFAULT NULL,
  `kelembaban_3` float DEFAULT NULL,
  `kelembaban_rata2` float DEFAULT NULL,
  `kebisingan_1` float DEFAULT NULL,
  `kebisingan_2` float DEFAULT NULL,
  `kebisingan_3` float DEFAULT NULL,
  `kebisingan_rata2` float DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengukuran_lingkungan`
--

INSERT INTO `pengukuran_lingkungan` (`id`, `jadwal_id`, `divisi_id`, `cahaya_1`, `cahaya_2`, `cahaya_3`, `cahaya_rata2`, `suhu_1`, `suhu_2`, `suhu_3`, `suhu_rata2`, `kelembaban_1`, `kelembaban_2`, `kelembaban_3`, `kelembaban_rata2`, `kebisingan_1`, `kebisingan_2`, `kebisingan_3`, `kebisingan_rata2`, `catatan`, `created_at`, `updated_at`) VALUES
(25, 12, 41, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, NULL, '2025-06-05 00:47:03', '2025-06-05 00:47:03'),
(26, 12, 42, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, NULL, '2025-06-05 00:47:03', '2025-06-05 00:47:03'),
(27, 12, 43, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, NULL, '2025-06-05 00:47:03', '2025-06-05 00:47:03'),
(28, 12, 44, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, NULL, '2025-06-05 00:47:03', '2025-06-05 00:47:03'),
(29, 12, 45, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 112, 119.33, NULL, '2025-06-05 00:47:03', '2025-06-05 00:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'login', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(2, 'login store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(3, 'logout', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(4, 'password request', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(5, 'password reset', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(6, 'password email', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(7, 'password update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(8, 'register', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(9, 'register store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(10, 'user profile information update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(11, 'user password update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(12, 'password confirm', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(13, 'password confirmation', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(14, 'password confirm store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(15, 'two factor login', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(16, 'two factor login store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(17, 'two factor enable', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(18, 'two factor confirm', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(19, 'two factor disable', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(20, 'two factor qr code', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(21, 'two factor secret key', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(22, 'two factor recovery codes', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(23, 'generated::6sfiafdgprd0j6ph', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(24, 'sanctum csrf cookie', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(25, 'livewire update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(26, 'generated::8t1qufjktgpxvsvt', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(27, 'generated::f0araebyl7yhou4g', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(28, 'livewire upload file', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(29, 'livewire preview file', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(30, 'ignition healthcheck', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(31, 'ignition executesolution', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(32, 'ignition updateconfig', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(33, 'generated::qz3ejkzmacw3eirb', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(34, 'generated::iu7zjge4fsuz2ytc', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(35, 'dashboard', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(36, 'menus index', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(37, 'menus getmenus', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(38, 'menus store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(39, 'user change_password', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(40, 'role assign permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(41, 'update role permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(42, 'user assign permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(43, 'update user permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(44, 'user assign role', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(45, 'update user role', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(46, 'user index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(47, 'user create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(48, 'user store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(49, 'user show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(50, 'user edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(51, 'user update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(52, 'user destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(53, 'permission index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(54, 'permission create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(55, 'permission store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(56, 'permission show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(57, 'permission edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(58, 'permission update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(59, 'permission destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(60, 'role index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(61, 'role create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(62, 'role store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(63, 'role show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(64, 'role edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(65, 'role update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(66, 'role destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(67, 'category index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(68, 'category create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(69, 'category store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(70, 'category show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(71, 'category edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(72, 'category update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(73, 'category destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(74, 'post index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(75, 'post create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(76, 'post store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(77, 'post show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(78, 'post edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(79, 'post update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(80, 'post destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(81, 'profile edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(82, 'profile update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(83, 'home', 'web', NULL, NULL),
(86, 'permit.po.progres', 'web', NULL, NULL),
(87, 'permit.po.create', 'web', NULL, NULL),
(88, 'approval-pengawas', 'web', NULL, NULL),
(89, 'approval-area', 'web', NULL, NULL),
(90, 'approval-she_officer', 'web', NULL, NULL),
(91, 'approval-she_manager', 'web', NULL, NULL),
(92, 'akses-she', 'web', NULL, NULL),
(93, 'jamkerja-create', 'web', NULL, NULL),
(94, 'approval-she', 'web', NULL, NULL),
(95, 'pengajuan-pembatalan', 'web', NULL, NULL),
(96, 'permit.po.selesaikan', 'web', NULL, NULL),
(97, 'lihat-po-sebagai-vendor', 'web', NULL, NULL),
(98, 'lihat-semua-po', 'web', NULL, NULL),
(99, 'buat-jadwal-pengukuran', 'web', NULL, NULL),
(100, 'buat-hasil-inspeksi', 'web', NULL, NULL),
(101, 'buat-jadwal-inspeksi', 'web', NULL, NULL),
(102, 'lihat-inspeksi-sendiri', 'web', NULL, NULL),
(103, 'tindaklanjut-inspeksi', 'web', NULL, NULL),
(104, 'menyelesaikan-inspeksi', 'web', NULL, NULL),
(105, 'lihat_semua_iadl', 'web', NULL, NULL),
(106, 'edit-iadl', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions_copy1`
--

CREATE TABLE `permissions_copy1` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions_copy1`
--

INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'login', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(2, 'login store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(3, 'logout', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(4, 'password request', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(5, 'password reset', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(6, 'password email', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(7, 'password update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(8, 'register', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(9, 'register store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(10, 'user profile information update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(11, 'user password update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(12, 'password confirm', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(13, 'password confirmation', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(14, 'password confirm store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(15, 'two factor login', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(16, 'two factor login store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(17, 'two factor enable', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(18, 'two factor confirm', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(19, 'two factor disable', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(20, 'two factor qr code', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(21, 'two factor secret key', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(22, 'two factor recovery codes', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(23, 'generated::6sfiafdgprd0j6ph', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(24, 'sanctum csrf cookie', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(25, 'livewire update', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(26, 'generated::8t1qufjktgpxvsvt', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(27, 'generated::f0araebyl7yhou4g', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(28, 'livewire upload file', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(29, 'livewire preview file', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(30, 'ignition healthcheck', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(31, 'ignition executesolution', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(32, 'ignition updateconfig', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(33, 'generated::qz3ejkzmacw3eirb', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(34, 'generated::iu7zjge4fsuz2ytc', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(35, 'dashboard', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(36, 'menus index', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(37, 'menus getmenus', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(38, 'menus store', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(39, 'user change_password', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(40, 'role assign permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(41, 'update role permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(42, 'user assign permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(43, 'update user permission', 'web', '2025-04-01 06:51:01', '2025-04-01 06:51:01'),
(44, 'user assign role', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(45, 'update user role', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(46, 'user index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(47, 'user create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(48, 'user store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(49, 'user show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(50, 'user edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(51, 'user update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(52, 'user destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(53, 'permission index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(54, 'permission create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(55, 'permission store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(56, 'permission show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(57, 'permission edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(58, 'permission update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(59, 'permission destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(60, 'role index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(61, 'role create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(62, 'role store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(63, 'role show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(64, 'role edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(65, 'role update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(66, 'role destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(67, 'category index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(68, 'category create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(69, 'category store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(70, 'category show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(71, 'category edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(72, 'category update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(73, 'category destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(74, 'post index', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(75, 'post create', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(76, 'post store', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(77, 'post show', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(78, 'post edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(79, 'post update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(80, 'post destroy', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(81, 'profile edit', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(82, 'profile update', 'web', '2025-04-01 06:51:02', '2025-04-01 06:51:02'),
(83, 'home', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Et culpa a non dolores minus.', 'et-culpa-a-non-dolores-minus', 'Est natus quaerat ut harum. Sed aut impedit doloribus rem quia. Sint ratione aliquid nobis qui perferendis. Rerum quis fugit distinctio et.', 'post/example-image.jpg', 3, 6, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(2, 'Ducimus odit ea atque.', 'ducimus-odit-ea-atque', 'Aut hic at rem quidem. Voluptate consequatur corrupti voluptatibus voluptate. Non consequatur pariatur qui impedit placeat vel veniam. Deleniti aut est amet totam.', 'post/example-image.jpg', 3, 2, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(3, 'Et accusantium sint iusto.', 'et-accusantium-sint-iusto', 'Dicta eius cum voluptatibus vel aut ipsa laborum at. Qui in nisi ab. At quae qui pariatur est.', 'post/example-image.jpg', 9, 1, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(4, 'Et aut cum eaque impedit sint quaerat sapiente.', 'et-aut-cum-eaque-impedit-sint-quaerat-sapiente', 'Facilis eveniet sit nostrum sunt consequuntur velit ut. Sed repudiandae inventore ad vitae sed. Fuga error et recusandae vitae.', 'post/example-image.jpg', 8, 9, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(5, 'Ab cumque quia est incidunt.', 'ab-cumque-quia-est-incidunt', 'Sunt magni sit totam. Cumque fugit aspernatur perspiciatis aut voluptas est corporis quis. Aperiam libero ipsa qui numquam. Aut dolores aut aut debitis libero.', 'post/example-image.jpg', 7, 6, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(6, 'Ut eius omnis ut est.', 'ut-eius-omnis-ut-est', 'Et in sit fugit rem ipsam animi et perferendis. Rem est sapiente enim non inventore. Dicta vero laudantium repellendus atque error culpa omnis. Aliquid aperiam voluptas a est ducimus minus non.', 'post/example-image.jpg', 3, 3, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(7, 'Incidunt quia et sint neque esse error.', 'incidunt-quia-et-sint-neque-esse-error', 'Et ut eum ducimus iure. Quia qui libero voluptatem similique et non nam ullam. Ad et qui qui rerum quod. Nesciunt neque quia ad illum perspiciatis non blanditiis.', 'post/example-image.jpg', 8, 2, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(8, 'Aspernatur dolore nesciunt ut voluptas asperiores qui.', 'aspernatur-dolore-nesciunt-ut-voluptas-asperiores-qui', 'Et molestiae consequatur rerum. Consequatur reiciendis sapiente ex tenetur eum ut magni. Voluptatem suscipit ut nulla officia est amet et. Nemo exercitationem aut incidunt omnis sed et.', 'post/example-image.jpg', 1, 5, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(9, 'Unde harum atque unde quisquam ducimus consectetur.', 'unde-harum-atque-unde-quisquam-ducimus-consectetur', 'Quaerat nostrum quia totam nihil nihil laudantium delectus. Et quidem et ex est sit. Placeat delectus ea sequi totam sit ipsum et officiis. Qui dolorum fugiat quam officia non magnam et.', 'post/example-image.jpg', 10, 7, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(10, 'Ut doloribus accusamus provident modi.', 'ut-doloribus-accusamus-provident-modi', 'Voluptatibus aliquam aliquid ullam et vitae voluptas non. Sed sequi iste esse amet occaecati et quasi. Deleniti est amet dignissimos reiciendis iusto velit et.', 'post/example-image.jpg', 1, 10, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(11, 'Officia molestiae veritatis reprehenderit quia quaerat maiores.', 'officia-molestiae-veritatis-reprehenderit-quia-quaerat-maiores', 'Atque optio iure voluptatibus quaerat eveniet. Deleniti a recusandae quaerat debitis ex voluptates eaque. Voluptatem et nostrum sint neque suscipit et sunt.', 'post/example-image.jpg', 7, 4, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(12, 'Aperiam saepe repellendus voluptatem dolorem quis et.', 'aperiam-saepe-repellendus-voluptatem-dolorem-quis-et', 'Sed consectetur sed ut consectetur. Aut odit quia inventore rerum sequi distinctio. Rerum ut placeat sed eos vel et.', 'post/example-image.jpg', 6, 7, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(13, 'Cum ducimus commodi debitis sint impedit architecto.', 'cum-ducimus-commodi-debitis-sint-impedit-architecto', 'Cum aliquid quisquam earum asperiores. Non vitae quo quam expedita. Autem et totam animi nam expedita et. Illum quaerat quibusdam aut ut.', 'post/example-image.jpg', 9, 1, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(14, 'Dicta voluptatem dolorum debitis iure incidunt.', 'dicta-voluptatem-dolorum-debitis-iure-incidunt', 'Sint tempora rerum ut. Eligendi sed amet id est dicta enim. Rerum consequatur aut possimus recusandae. Pariatur eos excepturi velit pariatur est quaerat. Rerum et illo consequatur et maiores tempora.', 'post/example-image.jpg', 6, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(15, 'Velit quia ad reiciendis est quia perferendis reprehenderit.', 'velit-quia-ad-reiciendis-est-quia-perferendis-reprehenderit', 'Atque ducimus corrupti nulla doloribus. Vitae vel facilis aperiam consectetur. Labore quam qui in neque impedit sed illum fugiat.', 'post/example-image.jpg', 8, 9, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(16, 'Officiis suscipit animi soluta voluptatem in.', 'officiis-suscipit-animi-soluta-voluptatem-in', 'Sit nulla qui commodi optio et possimus beatae. Voluptas a odit neque culpa nihil cupiditate iusto. Enim ipsam sed inventore mollitia ad adipisci. Dicta vitae vitae omnis maxime nam architecto.', 'post/example-image.jpg', 2, 10, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(17, 'Et aut est libero ut.', 'et-aut-est-libero-ut', 'Perspiciatis beatae fuga est molestiae qui quibusdam. Ut unde qui aut consequuntur eos impedit dolor eaque. Repellat aut alias animi eum. Tempora odit autem tempora et doloribus quos.', 'post/example-image.jpg', 10, 10, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(18, 'Et rerum id maxime sunt.', 'et-rerum-id-maxime-sunt', 'Adipisci dignissimos nesciunt natus ut. Aut eum consequuntur ex commodi voluptatem. Tempore pariatur pariatur ad earum facilis. Soluta porro qui aut est similique asperiores eveniet.', 'post/example-image.jpg', 1, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(19, 'Dolores et aperiam non culpa dolore aliquid repudiandae aspernatur.', 'dolores-et-aperiam-non-culpa-dolore-aliquid-repudiandae-aspernatur', 'Vitae minima eos occaecati aliquam sint nihil illum. Quasi ab quis ullam qui laborum officiis.', 'post/example-image.jpg', 3, 2, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(20, 'Dignissimos ipsa minima voluptate magnam.', 'dignissimos-ipsa-minima-voluptate-magnam', 'Modi animi quaerat sed. Ut rerum et modi eaque. Beatae ea et aliquam aut qui voluptas qui mollitia.', 'post/example-image.jpg', 2, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(21, 'Expedita perferendis beatae nostrum et nulla vel sint.', 'expedita-perferendis-beatae-nostrum-et-nulla-vel-sint', 'Est earum error ut deserunt. Ducimus corporis quasi facilis beatae inventore.', 'post/example-image.jpg', 2, 2, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(22, 'Repellendus distinctio dolores corrupti velit eos.', 'repellendus-distinctio-dolores-corrupti-velit-eos', 'Suscipit eos reiciendis eaque consequatur sunt voluptates ut. Dicta ab ad nobis fuga eos totam est. Recusandae suscipit dolores optio cupiditate. Consectetur hic nostrum inventore aut possimus nemo.', 'post/example-image.jpg', 3, 10, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(23, 'Autem nulla velit delectus voluptatem.', 'autem-nulla-velit-delectus-voluptatem', 'Quasi labore nam sequi totam odio non accusamus voluptatem. Dolor aut corporis illo odio. Placeat aut aliquam voluptatem atque repellat.', 'post/example-image.jpg', 8, 2, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(24, 'Iusto rem iure doloribus nisi vitae nihil voluptas.', 'iusto-rem-iure-doloribus-nisi-vitae-nihil-voluptas', 'Accusamus vitae tempora itaque ab non. Voluptatem voluptatum quod tempora rerum dolores. Quibusdam aut minima occaecati exercitationem occaecati aperiam molestias.', 'post/example-image.jpg', 1, 8, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(25, 'Eligendi consequatur autem recusandae et earum.', 'eligendi-consequatur-autem-recusandae-et-earum', 'Nemo laudantium ut laborum quasi dicta ea. Aut magnam et sit. Dignissimos sunt fugiat impedit quasi vero repellat.', 'post/example-image.jpg', 6, 3, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(26, 'Nemo sit odio facilis eos optio quod commodi.', 'nemo-sit-odio-facilis-eos-optio-quod-commodi', 'Iste nostrum architecto fugit. Quaerat unde omnis omnis voluptas. Ipsam dolor rerum temporibus aut expedita. Qui reprehenderit aut voluptas dolor doloremque.', 'post/example-image.jpg', 6, 1, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(27, 'Porro dolorem et eum sunt cumque natus.', 'porro-dolorem-et-eum-sunt-cumque-natus', 'Ea consequatur repellat quam eum neque enim. Hic dolor sed qui. Molestiae quidem molestiae perspiciatis aperiam vel quod placeat. Consequatur aut sed rerum aperiam quam.', 'post/example-image.jpg', 3, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(28, 'Repellendus occaecati corrupti dolor et a occaecati.', 'repellendus-occaecati-corrupti-dolor-et-a-occaecati', 'Impedit modi est est quibusdam rerum recusandae reprehenderit. Fuga sapiente laudantium qui quas mollitia. Modi nesciunt consectetur cupiditate nulla porro repudiandae quo.', 'post/example-image.jpg', 7, 10, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(29, 'Nesciunt minima consectetur recusandae dolor.', 'nesciunt-minima-consectetur-recusandae-dolor', 'Cum laborum omnis exercitationem natus. Repudiandae tempore autem quae quas excepturi fugit ratione. Ab laudantium magnam aut.', 'post/example-image.jpg', 10, 9, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(30, 'Soluta occaecati placeat eaque eius soluta.', 'soluta-occaecati-placeat-eaque-eius-soluta', 'Aut deserunt impedit quos illo doloribus odio. Rerum repudiandae in suscipit voluptas. Neque praesentium voluptatem aut id. Deserunt et quis sint consequatur at eum.', 'post/example-image.jpg', 6, 4, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(31, 'Qui ut aliquam placeat corporis numquam.', 'qui-ut-aliquam-placeat-corporis-numquam', 'Veritatis reiciendis voluptas ducimus nemo cupiditate. Quia optio et eos facilis nam quia eos. Et aliquid placeat assumenda et ab quo.', 'post/example-image.jpg', 3, 6, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(32, 'Est sapiente ipsa et voluptatem aut veniam magni.', 'est-sapiente-ipsa-et-voluptatem-aut-veniam-magni', 'Harum totam sed itaque placeat. Nemo eos dolor est. Voluptas vel voluptas ipsum et repudiandae omnis omnis. Est sed rerum deserunt rerum neque sapiente.', 'post/example-image.jpg', 2, 1, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(33, 'Veniam qui iusto quaerat explicabo velit assumenda.', 'veniam-qui-iusto-quaerat-explicabo-velit-assumenda', 'Sed itaque eum provident assumenda. Explicabo nobis corporis aut eaque. Ea unde itaque eveniet iusto ipsam. Facilis et mollitia saepe sed doloribus aut.', 'post/example-image.jpg', 10, 3, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(34, 'Iste qui sunt voluptatum quia quo.', 'iste-qui-sunt-voluptatum-quia-quo', 'Cum corporis corrupti dignissimos cumque voluptatum. Est ut qui cupiditate placeat suscipit. Et ut voluptate doloribus unde harum. Quia et necessitatibus voluptas unde maxime ut.', 'post/example-image.jpg', 10, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(35, 'Accusamus repudiandae dolores est voluptatem.', 'accusamus-repudiandae-dolores-est-voluptatem', 'Officiis dolores saepe ab cumque. Placeat qui numquam amet quam. Asperiores nesciunt est earum reiciendis. Aliquam voluptatem dolores nisi nam.', 'post/example-image.jpg', 7, 7, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(36, 'Accusantium hic eveniet dolor exercitationem alias.', 'accusantium-hic-eveniet-dolor-exercitationem-alias', 'Fugit ratione aut id aliquid vero. Harum quod et repellendus. Et tempore quia sunt aut tempore ullam omnis. Atque voluptate et in cum et.', 'post/example-image.jpg', 9, 9, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(37, 'Architecto ad dignissimos sit tempora consequuntur.', 'architecto-ad-dignissimos-sit-tempora-consequuntur', 'Non id iure delectus itaque. Autem expedita eligendi consequuntur. Eligendi consequatur aut et minus nisi rem.', 'post/example-image.jpg', 7, 8, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(38, 'Dolor est qui maiores nihil minus quia.', 'dolor-est-qui-maiores-nihil-minus-quia', 'Est tenetur cupiditate repellat. Minus omnis adipisci ut itaque et nihil a. Expedita et omnis consequatur alias rerum aut. Eum eum veniam quia sed corporis cupiditate.', 'post/example-image.jpg', 4, 7, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(39, 'Nisi sit modi ipsam omnis sit neque.', 'nisi-sit-modi-ipsam-omnis-sit-neque', 'Expedita deleniti aspernatur placeat tenetur assumenda aut laborum. Autem minima voluptas cum in. Nisi sunt saepe quo veritatis facere eos. Voluptas quasi quod accusamus nostrum architecto vel.', 'post/example-image.jpg', 5, 4, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(40, 'Impedit quam suscipit incidunt non consequatur porro vero amet.', 'impedit-quam-suscipit-incidunt-non-consequatur-porro-vero-amet', 'Enim ratione inventore consectetur ut ipsa autem modi. Qui ut ut officia neque in enim sunt. Quo voluptate sint qui debitis vero voluptates fugiat deserunt.', 'post/example-image.jpg', 10, 4, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(41, 'Eum soluta iure adipisci.', 'eum-soluta-iure-adipisci', 'Id quo laudantium temporibus consequuntur assumenda dolorem. Qui voluptas quis voluptas nihil omnis magnam. Debitis amet minus omnis ea.', 'post/example-image.jpg', 8, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(42, 'Est et earum impedit qui.', 'est-et-earum-impedit-qui', 'Similique ut illum facere sed dolor. Qui magnam maiores est quas harum rerum. Non facere officia alias eius esse facilis ad. Quod sed aspernatur qui optio in aperiam.', 'post/example-image.jpg', 10, 1, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(43, 'Repellat nisi voluptas necessitatibus quos et.', 'repellat-nisi-voluptas-necessitatibus-quos-et', 'Quasi ea velit sed ut totam eaque. Aut consectetur explicabo itaque quam ut assumenda eaque quaerat. Aut voluptatem ut eaque aliquam sint placeat. Et veniam a iusto quisquam at est et.', 'post/example-image.jpg', 9, 10, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(44, 'Sint aut velit illum at.', 'sint-aut-velit-illum-at', 'Veniam illo maxime reiciendis quibusdam. Ut officiis officiis eos dignissimos quibusdam omnis.', 'post/example-image.jpg', 4, 9, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(45, 'Quis saepe officiis nam voluptatum tempore sunt delectus.', 'quis-saepe-officiis-nam-voluptatum-tempore-sunt-delectus', 'Fugit voluptatem quam ut. Ullam quia eum nisi corporis vitae.', 'post/example-image.jpg', 3, 7, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(46, 'Quis voluptas suscipit est culpa eligendi error.', 'quis-voluptas-suscipit-est-culpa-eligendi-error', 'Nemo voluptas qui eum ullam quibusdam hic. Cumque odio enim rerum facilis id excepturi. Libero veritatis aspernatur recusandae laudantium et reiciendis.', 'post/example-image.jpg', 3, 10, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(47, 'Accusamus earum error corporis.', 'accusamus-earum-error-corporis', 'Amet velit odit labore aut quas eveniet. Omnis ex modi iusto nam. Dolores minus suscipit quas delectus voluptas rerum magni velit.', 'post/example-image.jpg', 2, 5, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(48, 'Voluptas amet ea qui est.', 'voluptas-amet-ea-qui-est', 'Et laboriosam fuga est corporis. Itaque magni ut provident fugiat debitis. Aut impedit ut saepe. Delectus voluptate pariatur qui aut necessitatibus autem.', 'post/example-image.jpg', 6, 5, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(49, 'Necessitatibus consequatur perspiciatis quo praesentium in natus.', 'necessitatibus-consequatur-perspiciatis-quo-praesentium-in-natus', 'Fugit earum est dolor minima. Laudantium et dolor velit quia.', 'post/example-image.jpg', 2, 3, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(50, 'Illo voluptatem quae id non corporis fugiat voluptatem aliquid.', 'illo-voluptatem-quae-id-non-corporis-fugiat-voluptatem-aliquid', 'Cupiditate velit praesentium fuga accusantium quia. Est non hic sed officiis eaque earum quisquam. Tempora incidunt facere quia illo. Et reprehenderit consequatur quis suscipit iure.', 'post/example-image.jpg', 5, 9, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(51, 'At dolores sint cupiditate commodi earum sequi et.', 'at-dolores-sint-cupiditate-commodi-earum-sequi-et', 'Tempore distinctio nobis ut unde. Et nesciunt quia tenetur. Est non repudiandae ullam eligendi. Nesciunt voluptatem in consectetur totam rerum quia.', 'post/example-image.jpg', 6, 8, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(52, 'Officia adipisci porro id.', 'officia-adipisci-porro-id', 'Consequuntur est delectus aut quis omnis sint. Omnis est maxime temporibus magnam dignissimos quia. Assumenda sunt illo quae at sit ad. Nihil et libero voluptas et.', 'post/example-image.jpg', 7, 6, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(53, 'A quo molestiae provident explicabo.', 'a-quo-molestiae-provident-explicabo', 'Quas sit quia suscipit dolor voluptatum. Et quo magni dignissimos eos. Natus cum libero asperiores voluptatibus et beatae ut exercitationem. Consequatur eum incidunt dolore enim labore quasi harum.', 'post/example-image.jpg', 6, 5, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(54, 'Fugiat fugit et quibusdam sit aperiam.', 'fugiat-fugit-et-quibusdam-sit-aperiam', 'Alias sunt minima voluptatem aut temporibus ut ea tenetur. Id quo excepturi consequuntur totam. Quae eum laudantium itaque laborum deserunt ducimus. Corrupti minima aut neque beatae corrupti officia.', 'post/example-image.jpg', 9, 5, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(55, 'Aut quia molestiae reiciendis quia vitae porro.', 'aut-quia-molestiae-reiciendis-quia-vitae-porro', 'Quam aliquid quia temporibus vitae. Eveniet ducimus ea adipisci nemo nihil molestias aut. Qui nihil mollitia natus. Et molestiae deserunt culpa fuga.', 'post/example-image.jpg', 3, 4, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(56, 'Est ut temporibus hic eaque.', 'est-ut-temporibus-hic-eaque', 'Ad aspernatur blanditiis architecto aut aliquam nostrum. Vel aspernatur quo nulla ut quam saepe. Est quod eum non ut. Possimus dolor in in facere ut. Autem rerum vero aliquid eaque enim ab.', 'post/example-image.jpg', 5, 10, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(57, 'Consequatur beatae et qui.', 'consequatur-beatae-et-qui', 'Aut in animi in consequatur iusto et culpa quis. Fugiat autem ut saepe. Quo placeat consequuntur eaque. Ipsa quis eum aperiam architecto libero modi iste.', 'post/example-image.jpg', 9, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(58, 'Consequuntur et dolores repellendus eum.', 'consequuntur-et-dolores-repellendus-eum', 'Eveniet at sed rerum ullam unde. Qui sed incidunt dolorum tenetur sit voluptatem. Qui et odit nemo ut quam sint. Porro odit eligendi totam error laborum quis.', 'post/example-image.jpg', 10, 3, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(59, 'Sed dolorum dolore et delectus velit sequi adipisci.', 'sed-dolorum-dolore-et-delectus-velit-sequi-adipisci', 'Sed molestiae consequatur sit ut laudantium. Autem sit officia reiciendis quia at sed distinctio. Aut assumenda sunt qui fugiat illo.', 'post/example-image.jpg', 6, 10, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(60, 'Non veniam voluptatem repellat.', 'non-veniam-voluptatem-repellat', 'Quia sit et possimus est quas. Dolor soluta cumque ut labore aperiam. Rerum animi et qui.', 'post/example-image.jpg', 6, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(61, 'Quis modi nesciunt dolor error quasi fuga.', 'quis-modi-nesciunt-dolor-error-quasi-fuga', 'Dolores velit modi quaerat quia tenetur magni ex aut. Eaque rerum maiores sit eos. Excepturi assumenda enim dolorum.', 'post/example-image.jpg', 3, 1, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(62, 'Soluta nulla optio ex non cupiditate non hic.', 'soluta-nulla-optio-ex-non-cupiditate-non-hic', 'Ut nihil quibusdam culpa officia ratione. Eius consequatur alias est et. Necessitatibus qui repellat nam animi ducimus. Blanditiis quidem id totam molestias.', 'post/example-image.jpg', 8, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(63, 'Impedit quo ad ut quo voluptatibus.', 'impedit-quo-ad-ut-quo-voluptatibus', 'Aliquam ea repellat exercitationem nesciunt iste. Voluptate voluptates debitis maiores voluptas veniam mollitia et. Quo repudiandae est aliquid nulla.', 'post/example-image.jpg', 8, 8, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(64, 'Et ipsum asperiores explicabo error.', 'et-ipsum-asperiores-explicabo-error', 'Qui sint at dicta quis quia. Pariatur omnis voluptatibus natus et nisi error. Eaque et voluptas ea non vitae est quisquam.', 'post/example-image.jpg', 7, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(65, 'Quasi nisi pariatur qui occaecati quasi.', 'quasi-nisi-pariatur-qui-occaecati-quasi', 'Eos eos est minus enim doloremque. Fugit nemo quae quas quia quis animi numquam. Porro accusantium quae voluptas.', 'post/example-image.jpg', 4, 5, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(66, 'Ipsa et voluptas odit blanditiis.', 'ipsa-et-voluptas-odit-blanditiis', 'Neque vel ad alias. Distinctio ut eum sapiente sed quasi odit. Cumque et tenetur expedita dolorum voluptatem aut iusto. Architecto totam consequatur ut voluptatibus.', 'post/example-image.jpg', 2, 1, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(67, 'Quidem ut fugiat qui ratione deleniti.', 'quidem-ut-fugiat-qui-ratione-deleniti', 'Itaque vero quia excepturi dolor eaque nobis et. Voluptas at iste eum consequatur atque corrupti.', 'post/example-image.jpg', 7, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(68, 'Esse praesentium illum consequatur quis.', 'esse-praesentium-illum-consequatur-quis', 'Aperiam porro quia necessitatibus vel. Temporibus molestias repellendus dolorum voluptatem nemo. Illo placeat et suscipit omnis. Molestias culpa a vel ullam est.', 'post/example-image.jpg', 6, 9, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(69, 'Soluta sed aut qui tempora.', 'soluta-sed-aut-qui-tempora', 'Cum et sapiente dolores. Quibusdam eos quo voluptatem id ut doloremque. Corrupti ut aliquam iure possimus accusantium incidunt. Magnam rerum consequatur sunt quae qui vel ratione.', 'post/example-image.jpg', 6, 8, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(70, 'Quos animi explicabo qui.', 'quos-animi-explicabo-qui', 'Tempora deserunt quibusdam numquam aperiam. Quisquam quis animi aut facilis. Occaecati atque perferendis quis est doloremque vero repudiandae. Aliquam alias aspernatur possimus non dolorum.', 'post/example-image.jpg', 7, 7, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(71, 'Temporibus reiciendis alias aut.', 'temporibus-reiciendis-alias-aut', 'Sapiente accusamus ipsum similique maiores. Qui aut ratione vel dolor. Sunt officia velit minus est. Et et enim et sint voluptatem.', 'post/example-image.jpg', 5, 3, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(72, 'Odit ea architecto sed minus deserunt error et.', 'odit-ea-architecto-sed-minus-deserunt-error-et', 'Facilis quis sunt quisquam. At libero optio excepturi. Sint illo earum et quaerat et ab tempore consequatur. Ut laborum nemo qui omnis.', 'post/example-image.jpg', 9, 5, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(73, 'Vitae et omnis a ut quidem.', 'vitae-et-omnis-a-ut-quidem', 'Illum earum aliquid rerum sit fuga aut. Quo numquam ab est eligendi voluptatem optio dolore. Dolor omnis recusandae modi. Non saepe nihil et voluptates ab molestiae aliquid molestias.', 'post/example-image.jpg', 5, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(74, 'Ab tempora at ab ut.', 'ab-tempora-at-ab-ut', 'Nostrum animi iusto nostrum. Veniam autem dolores quaerat qui voluptatem maiores occaecati. Exercitationem delectus dolorem aliquam omnis.', 'post/example-image.jpg', 3, 7, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(75, 'Sit alias sint illo sint ex.', 'sit-alias-sint-illo-sint-ex', 'Iusto qui dolores deserunt vitae recusandae ab neque vel. Dolor aut sunt vitae. Repellat quos quasi dolor ut accusantium voluptatem dignissimos et. Dolores voluptatem et delectus saepe voluptates.', 'post/example-image.jpg', 10, 10, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(76, 'Distinctio voluptatem voluptas accusantium ut et veritatis.', 'distinctio-voluptatem-voluptas-accusantium-ut-et-veritatis', 'Voluptatibus doloremque eum vel et provident corrupti nostrum ea. Sint eum veritatis rem cumque. Omnis accusamus et maxime et illo molestias.', 'post/example-image.jpg', 3, 3, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(77, 'Quis minima aspernatur id dolor possimus.', 'quis-minima-aspernatur-id-dolor-possimus', 'Est at consequatur beatae iure quisquam labore laborum. Aliquam rerum quis ullam molestiae animi expedita accusamus non. Iure esse aut dolor aperiam. Voluptatem nemo aut officia culpa est aliquam.', 'post/example-image.jpg', 5, 5, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(78, 'Natus amet rerum deleniti autem molestiae.', 'natus-amet-rerum-deleniti-autem-molestiae', 'Illum et laudantium aperiam illo veritatis facilis itaque. Magnam dolore cupiditate quis quae. Sit quaerat non natus accusantium magni et.', 'post/example-image.jpg', 7, 3, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(79, 'Eos ipsa omnis sed.', 'eos-ipsa-omnis-sed', 'Tempore pariatur voluptatem necessitatibus ut similique est vero. Cupiditate fugiat ut expedita eveniet natus. Eveniet veritatis asperiores sed natus earum temporibus harum.', 'post/example-image.jpg', 9, 7, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(80, 'Omnis totam accusantium exercitationem dolore asperiores.', 'omnis-totam-accusantium-exercitationem-dolore-asperiores', 'Modi tempora officia nemo sint error dolor suscipit suscipit. Sint enim sit est omnis. Est nisi dicta exercitationem dolore.', 'post/example-image.jpg', 9, 7, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(81, 'Sint nemo vitae ratione voluptatem quis.', 'sint-nemo-vitae-ratione-voluptatem-quis', 'Alias quis aut reprehenderit et exercitationem harum. Exercitationem repudiandae nemo voluptate sunt. Et qui in in distinctio. Facere dolores error veritatis doloribus sed dolorem.', 'post/example-image.jpg', 1, 10, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(82, 'Omnis impedit occaecati ipsam quos.', 'omnis-impedit-occaecati-ipsam-quos', 'Doloribus modi architecto eos et itaque. Qui odit voluptate et maxime nemo debitis quam. Nihil aut quia voluptates reprehenderit eveniet rerum. Et ad ipsam ad sit explicabo quasi.', 'post/example-image.jpg', 6, 4, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(83, 'Excepturi exercitationem et nobis dolorem.', 'excepturi-exercitationem-et-nobis-dolorem', 'Quo consectetur qui pariatur aliquid. Perspiciatis eligendi harum eum inventore nostrum ipsum accusantium natus. Et autem mollitia voluptas. Reprehenderit placeat omnis eum tempora provident.', 'post/example-image.jpg', 2, 4, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(84, 'Velit vel explicabo aut.', 'velit-vel-explicabo-aut', 'Ipsa quaerat quod nemo laborum sunt doloremque veniam. Reprehenderit ipsam ut et incidunt voluptate. Mollitia quia illum sunt eveniet.', 'post/example-image.jpg', 7, 5, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(85, 'Reiciendis porro distinctio dolorum reprehenderit et est.', 'reiciendis-porro-distinctio-dolorum-reprehenderit-et-est', 'Et molestiae aut omnis quidem. Sunt distinctio et officia sint perferendis nisi. Quod perspiciatis id ipsam dignissimos numquam et iste. Saepe ducimus unde mollitia reiciendis.', 'post/example-image.jpg', 4, 3, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(86, 'Fugit dolorum repellat placeat fugit excepturi quos quo.', 'fugit-dolorum-repellat-placeat-fugit-excepturi-quos-quo', 'Voluptas ut suscipit quae quos omnis nobis. Beatae non iure voluptatem ut enim. Neque beatae aperiam error aut. Voluptatem dolorem aliquid quod.', 'post/example-image.jpg', 3, 7, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(87, 'Tenetur velit veritatis quis qui dolor nobis tenetur.', 'tenetur-velit-veritatis-quis-qui-dolor-nobis-tenetur', 'Et delectus blanditiis doloremque beatae explicabo sint maiores autem. Vel veritatis voluptas quae et exercitationem. Nesciunt ratione praesentium ipsa id dolore.', 'post/example-image.jpg', 3, 10, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(88, 'Maxime tempora ab eius pariatur beatae quis.', 'maxime-tempora-ab-eius-pariatur-beatae-quis', 'At aut est magni ratione veniam voluptate ut. Cumque omnis quae quidem vitae non eius. Adipisci earum quisquam et fugit similique.', 'post/example-image.jpg', 10, 9, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(89, 'Maiores est illo perspiciatis consequatur dignissimos.', 'maiores-est-illo-perspiciatis-consequatur-dignissimos', 'Aspernatur voluptatum beatae facilis nisi natus. Quia aut iste et voluptatibus deserunt sequi aliquid. Debitis sunt possimus quas labore doloremque sed ut. Ut a accusamus et sint est.', 'post/example-image.jpg', 7, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(90, 'Ut sequi nihil aut.', 'ut-sequi-nihil-aut', 'Accusantium et consequatur aut neque nobis odit. Id voluptatem amet ab. Quam architecto expedita quisquam blanditiis officiis tempore odio atque.', 'post/example-image.jpg', 10, 8, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(91, 'Ea ipsam iste eveniet molestiae molestiae.', 'ea-ipsam-iste-eveniet-molestiae-molestiae', 'Sint rem corporis consequatur nostrum vero labore consectetur. Accusamus harum sunt est est repellat id odit. At non aut delectus exercitationem.', 'post/example-image.jpg', 5, 8, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(92, 'Aut est inventore autem voluptas provident.', 'aut-est-inventore-autem-voluptas-provident', 'Consequatur vel quaerat corrupti rerum. Error esse eum et cumque error nisi ipsam. Quidem rem quidem nihil. Nihil porro id enim beatae et nostrum.', 'post/example-image.jpg', 4, 2, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(93, 'Nemo et rerum cupiditate consequuntur voluptatibus veniam.', 'nemo-et-rerum-cupiditate-consequuntur-voluptatibus-veniam', 'Ipsa praesentium et dolore quibusdam rem. Explicabo placeat eius nemo hic tenetur eos iusto. Eum nihil eum illo et sunt deleniti.', 'post/example-image.jpg', 8, 5, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(94, 'Cupiditate voluptatem eum ut laboriosam.', 'cupiditate-voluptatem-eum-ut-laboriosam', 'Ullam sit omnis quia sequi impedit quaerat aut. Voluptatem consequatur inventore odit et. Unde dolore est aut quos molestias.', 'post/example-image.jpg', 1, 4, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(95, 'Sed non totam sed voluptatibus magni.', 'sed-non-totam-sed-voluptatibus-magni', 'Dolorum omnis porro aut sit doloremque in. Ratione est molestias quod sit corrupti impedit. Blanditiis laboriosam molestiae iusto dolores.', 'post/example-image.jpg', 4, 5, 'process', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(96, 'Consectetur fuga aut deleniti cum molestiae.', 'consectetur-fuga-aut-deleniti-cum-molestiae', 'Eum voluptatem facilis necessitatibus et. Ut nihil voluptatem et consectetur est. Fugiat incidunt delectus vel facilis. Numquam eos eos architecto et iusto alias.', 'post/example-image.jpg', 6, 9, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(97, 'Perspiciatis ut voluptatem dolorum praesentium quis unde.', 'perspiciatis-ut-voluptatem-dolorum-praesentium-quis-unde', 'Architecto neque consequuntur veritatis assumenda ducimus sed est. Quis odit eligendi nisi maxime sunt. Pariatur accusantium libero nemo fuga ducimus corporis qui. Vel facere at earum vel iusto quia.', 'post/example-image.jpg', 4, 2, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(98, 'Ut consequatur veniam minus.', 'ut-consequatur-veniam-minus', 'Fugiat sit excepturi consequatur cupiditate aperiam reiciendis in. Mollitia debitis sit corporis nam. Placeat quia libero aut.', 'post/example-image.jpg', 8, 6, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(99, 'Nam consequatur qui quidem voluptatem.', 'nam-consequatur-qui-quidem-voluptatem', 'Sint ut saepe possimus soluta et accusamus. Omnis et id corrupti est sit ducimus voluptatem. Perferendis eaque tempore quisquam quia iure nihil labore quia.', 'post/example-image.jpg', 3, 10, 'published', '2025-03-23 21:10:22', '2025-03-23 21:10:22'),
(100, 'Placeat aut fuga temporibus ducimus voluptas.', 'placeat-aut-fuga-temporibus-ducimus-voluptas', 'Eveniet enim aut aut sint voluptatem atque. Nesciunt ut occaecati voluptatibus voluptas tenetur placeat. Quod sunt qui eum dolor accusantium. Qui doloribus at consequatur.', 'post/example-image.jpg', 4, 8, 'draft', '2025-03-23 21:10:22', '2025-03-23 21:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `nama_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pekerjaan` enum('jasa_perorangan','jasa_non_perorangan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_pekerjaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `status` enum('draft','active','cancelled','completed','submitted') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `vendor_id`, `nama_pekerjaan`, `jenis_pekerjaan`, `area_pekerjaan`, `lokasi_pekerjaan`, `detail_pekerjaan`, `tanggal_mulai`, `tanggal_akhir`, `created_by`, `status`, `is_deleted`, `created_at`, `updated_at`, `no_po`) VALUES
(32, 1, 'Pemasangan Plafon', 'jasa_perorangan', 'Gedung B', 'KSP', 'Pemasangan Plafon', '2025-03-17', '2025-05-17', 1, 'completed', 0, '2025-05-17 07:46:22', '2025-06-03 02:24:50', 'PO/V/2025/002'),
(33, 2, 'Pemasangan Beton', 'jasa_perorangan', 'Gedung C', 'KSP', 'Pemasangan Beton', '2025-03-17', '2025-06-17', 1, 'active', 0, '2025-05-17 07:46:51', '2025-06-02 05:01:13', 'PO/V/2025/003');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_job_classification`
--

CREATE TABLE `purchase_order_job_classification` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_order_id` bigint UNSIGNED DEFAULT NULL,
  `job_classification_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_job_classification`
--

INSERT INTO `purchase_order_job_classification` (`id`, `purchase_order_id`, `job_classification_id`) VALUES
(61, 32, 13),
(62, 33, 6);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(2, 'Purchasing', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(3, 'Pengawas', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(4, 'Pemilik Area', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(5, 'SHE Officer', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(6, 'SHE Manager', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(7, 'Vendor', 'web', '2025-04-22 00:10:14', '2025-04-22 00:10:14'),
(8, 'User Inspeksi', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(29, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(74, 1),
(75, 1),
(83, 1),
(87, 1),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(86, 3),
(88, 3),
(98, 3),
(86, 4),
(89, 4),
(98, 4),
(86, 5),
(90, 5),
(92, 5),
(94, 5),
(95, 5),
(98, 5),
(99, 5),
(100, 5),
(101, 5),
(104, 5),
(105, 5),
(106, 5),
(86, 6),
(91, 6),
(98, 6),
(86, 7),
(87, 7),
(93, 7),
(96, 7),
(97, 7),
(102, 8),
(103, 8);

-- --------------------------------------------------------

--
-- Table structure for table `role_menu_route`
--

CREATE TABLE `role_menu_route` (
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `routename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `role_menu_route`
--

INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 2, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 3, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 4, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 5, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 6, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 7, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 8, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 9, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 10, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 11, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 12, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 13, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 14, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 15, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 16, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 17, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 18, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 19, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 20, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 21, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 22, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 23, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 24, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 25, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 26, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(1, 27, NULL, '2025-05-14 18:45:44', '2025-05-14 18:45:44'),
(2, 1, NULL, '2025-05-14 20:55:26', '2025-05-14 20:55:26'),
(2, 6, NULL, '2025-05-14 20:55:26', '2025-05-14 20:55:26'),
(2, 10, NULL, '2025-05-14 20:55:26', '2025-05-14 20:55:26'),
(3, 1, NULL, '2025-05-06 09:38:56', '2025-05-06 09:38:56'),
(3, 11, NULL, '2025-05-06 09:38:56', '2025-05-06 09:38:56'),
(3, 12, NULL, '2025-05-06 09:38:56', '2025-05-06 09:38:56'),
(3, 13, NULL, '2025-05-06 09:38:56', '2025-05-06 09:38:56'),
(4, 1, NULL, '2025-04-18 11:49:57', '2025-04-18 11:49:57'),
(4, 11, NULL, '2025-04-18 11:49:57', '2025-04-18 11:49:57'),
(4, 12, NULL, '2025-04-18 11:49:57', '2025-04-18 11:49:57'),
(4, 13, NULL, '2025-04-18 11:49:57', '2025-04-18 11:49:57'),
(5, 1, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 11, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 12, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 13, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 14, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 16, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 17, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 18, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 19, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 20, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 21, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 22, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 23, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(5, 28, NULL, '2025-05-24 13:08:01', '2025-05-24 13:08:01'),
(6, 1, NULL, '2025-05-07 12:17:06', '2025-05-07 12:17:06'),
(6, 11, NULL, '2025-05-07 12:17:06', '2025-05-07 12:17:06'),
(6, 12, NULL, '2025-05-07 12:17:06', '2025-05-07 12:17:06'),
(6, 13, NULL, '2025-05-07 12:17:06', '2025-05-07 12:17:06'),
(7, 1, NULL, '2025-04-30 13:29:11', '2025-04-30 13:29:11'),
(7, 11, NULL, '2025-04-30 13:29:11', '2025-04-30 13:29:11'),
(7, 12, NULL, '2025-04-30 13:29:11', '2025-04-30 13:29:11'),
(7, 13, NULL, '2025-04-30 13:29:11', '2025-04-30 13:29:11'),
(7, 18, NULL, '2025-04-30 13:29:11', '2025-04-30 13:29:11'),
(8, 1, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25'),
(8, 14, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25'),
(8, 17, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25'),
(8, 20, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25'),
(8, 23, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25'),
(8, 28, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25'),
(8, 29, NULL, '2025-05-25 16:56:25', '2025-05-25 16:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `safety_equipment`
--

CREATE TABLE `safety_equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `safety_equipment`
--

INSERT INTO `safety_equipment` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(3, 'Sepatu Safety', 'apd', '2025-03-14 03:15:40', '2025-03-14 03:15:40'),
(4, 'Helm Keselamatan', 'apd', '2025-03-14 03:15:40', '2025-03-14 03:15:40'),
(5, 'LOGO (Log Out Tag Out)', 'perlengkapan_darurat', '2025-03-14 03:15:40', '2025-03-14 03:15:40'),
(6, 'Full Body Harness', 'apd', '2025-03-14 03:45:39', '2025-03-14 03:45:39'),
(7, 'Sarung Tangan Katun', 'apd', '2025-03-14 03:45:39', '2025-03-14 03:45:39'),
(8, 'Rambu K3', 'perlengkapan_darurat', '2025-03-14 03:45:39', '2025-03-14 03:45:39'),
(9, 'Jaring Keselamatan', 'perlengkapan_darurat', '2025-03-14 03:45:39', '2025-03-14 03:45:39'),
(10, 'Sarung Tangan Karet', 'apd', '2025-03-16 20:28:11', '2025-03-16 20:28:11'),
(11, 'APAR', 'perlengkapan_darurat', '2025-03-16 20:28:11', '2025-03-16 20:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('58G4o58Pyz2iKU6ZVVxJPgEWLdm6awFd9BaGrLrX', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUWFpUVFKRFViNGFRV0xPQ3RsWlVFdmowcE5GeVlaczAwYlJlTW1YQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1742942430),
('cJh3pL1bVPqIqJZ3YJibc6Az4Ar1XIaPRL2K84R6', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGY5b3lRYnNadjBlaWF1OWxxdUp4NUZKbGFJYXBhTGNoWHRsYUdYciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly9rM2xoLmt1L3VzZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1742804757),
('r8XzLnQdmtP3mYEpTxK7Y5jt1mo2MLUAhfInU55A', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDhuakMxQzRtdHd3TGlEdWN5SUFFa0RmT09TR29OT3c2UmN0NVJmeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly9rM2xoLmt1L2xvZ2luIjt9fQ==', 1743153036),
('ZVhU7TR3W2477V0uKvJkxIYLmybsxNemSBlsf0Qa', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNnZwSzY5RDVsTm02NzJIeTJUVWRuVGxCUE5lTW81SGZMb2t6cVYzMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL21jdSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1746166720);

-- --------------------------------------------------------

--
-- Table structure for table `set_notif`
--

CREATE TABLE `set_notif` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `link_video` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `link_audio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `set_notif`
--

INSERT INTO `set_notif` (`id`, `title`, `body`, `link_video`, `link_audio`, `created_at`, `updated_at`) VALUES
(1, 'Streching', 'Lakukan Streching selama 2 menit', 'videos/NQoqwaCgi95d2dAavdOqXTnuWwXQlDkeZS3Q3Czj.mp4', 'audios/Xf7zGUNdaPKR7VlZTbegQOAMVyQHZ3XL880UUYKz.mp3', NULL, '2025-04-15 13:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori_inspeksi`
--

CREATE TABLE `sub_kategori_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `nama_sub_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_kategori_inspeksi`
--

INSERT INTO `sub_kategori_inspeksi` (`id`, `kategori_id`, `nama_sub_kategori`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pelindung peralatan / mesin', '2025-05-01 16:01:44', '2025-05-01 16:01:44'),
(2, 1, 'Permukaan jalan & tempat kerja : kondisi, pengamanan', '2025-05-01 16:06:30', '2025-05-18 19:16:43'),
(3, 2, 'Fire detection & alarm system, al : Instalasi, kesesuaian, pengujian', '2025-05-01 16:08:12', '2025-05-01 16:08:12'),
(4, 2, 'Sprinkler system, al : kelayakan, pemeliharaan', '2025-05-01 16:09:07', '2025-05-01 16:09:07'),
(5, 3, 'B3, al label, penempatan, MSDS & penanggulangan kebocoran', '2025-05-02 02:41:52', '2025-05-02 02:41:52'),
(11, 3, 'TEs', '2025-05-19 02:35:29', '2025-05-19 02:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `tindak_lanjut_inspeksi`
--

CREATE TABLE `tindak_lanjut_inspeksi` (
  `id` bigint UNSIGNED NOT NULL,
  `hasil_inspeksi_id` bigint UNSIGNED DEFAULT NULL,
  `saran_perbaikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `target_penyelesaian` date DEFAULT NULL,
  `status` enum('pending','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `telah_diperbaiki` tinyint(1) DEFAULT '0',
  `foto_perbaikan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `catatan_perbaikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tindak_lanjut_inspeksi`
--

INSERT INTO `tindak_lanjut_inspeksi` (`id`, `hasil_inspeksi_id`, `saran_perbaikan`, `target_penyelesaian`, `status`, `telah_diperbaiki`, `foto_perbaikan`, `created_at`, `updated_at`, `catatan_perbaikan`) VALUES
(26, 26, 'perbaiki', '2025-06-20', 'selesai', 1, 'perbaikan_foto/7FvKDFQaSVSsbzTzrUmTHJzwBZaOrlUPqzbnoZFw.jpg', '2025-06-04 20:49:27', '2025-06-05 00:11:38', 'oke'),
(27, 27, 'cat ulang', '2025-06-20', 'selesai', 1, 'perbaikan_foto/twmicsmpdnPECxrGqTdWpXLjAYPc9hkx3nfR2Ouk.jpg', '2025-06-04 20:49:27', '2025-06-05 00:12:11', 'oke'),
(28, 28, 'perbaiki', '2025-06-20', 'pending', 0, NULL, '2025-06-04 21:40:46', '2025-06-04 21:40:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_vendor` tinyint DEFAULT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$DiZnzhI7M3OpavIO7na.8.mkHE1valXD72qb9Yns/x6xhQ6jr7c5y', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:16', '2025-05-02 03:23:53'),
(2, 'Vendor', 'almuhyifajar1945@gmail.com', NULL, '$2y$10$tuvkReJiG7RH3H2F84V3heT694OB5VfU4qqG4epmKTwbaWKVtIrIK', 2, 1, 1, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-05-07 23:15:59'),
(3, 'Pengawas', 'demo1@example.org', NULL, '$2y$10$pn2Z0JZJs2JWwxCXqw9ksuf8KoRkYLoo4FyIBOwpTSMoV9WcwBXC6', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-04-22 09:19:35'),
(4, 'Buford Ryan', 'jwisoky@example.com', NULL, '$2y$10$IiYeE0aB4FSXSkmVfDTyuuFf4clWjV/tz0gl2/mHNu5I4gIvlGSJa', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-04-22 14:15:01'),
(5, 'Elton Kautzer', 'towne.elouise@example.net', NULL, '$2y$10$AavN0Re7O8mlCkSLFexf2eddEeR9FirORwjPTTeOBXMVM.ZXOfUsa', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-04-22 14:15:02'),
(6, 'Giuseppe Wilderman V', 'brandy.luettgen@example.net', NULL, '$2y$10$pnuiSe6kg0UYebnkkPshvuZ4WKx4RpcsSJYOd/TEm4uRhkIKn45im', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-04-22 14:15:02'),
(7, 'Krystina Mayert', 'ratke.amparo@example.org', NULL, '$2y$10$4jbUgXdbAyeKzvULhLNfLuElyPgXwbRMwgEVMh5ZTXEzf2csC8A32', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-04-22 14:15:02'),
(8, 'Prof. Liza Gerlach DVM', 'smith.william@example.org', NULL, '$2y$10$gjBMlfe3irpto3iCV4tQguF2pNftnBQ4zkSlrINVSMh3AZM5wc6PS', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-04-22 14:15:03'),
(9, 'Karlie Abshire', 'halojoyko@gmail.com', NULL, '$2y$10$4ZWSSqqShgZaqm9mRFLUq.2170gxYfRb40L4pm7U.wTPqydv9njIq', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-23 21:10:21', '2025-05-11 05:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_lokasi_lingkungan`
--

CREATE TABLE `user_lokasi_lingkungan` (
  `id` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lokasi_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_lokasi_lingkungan`
--

INSERT INTO `user_lokasi_lingkungan` (`id`, `user_id`, `lokasi_id`, `created_at`, `updated_at`) VALUES
(1, 9, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint UNSIGNED NOT NULL,
  `kd_vendor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `kd_vendor`, `vendor_name`, `address`, `city`, `province`, `npwp`, `phone`, `email`, `direksi`, `created_at`, `updated_at`) VALUES
(1, '999999', 'PT VENDOR TEST', 'Jl. Testing No. 99', 'Jakarta', 'DKI Jakarta', '000000000000000', '02112345678', 'testvendor@gmail.com', 'TEST MANAGER', '2025-03-14 00:13:01', '2025-03-14 00:13:01'),
(2, '111111', 'PT TEST', 'serang', 'Serang', 'Banten', '000000000000001', '02212345678', 'almuhyifajar1945@gmail.com', 'MUHI', NULL, '2025-03-18 05:49:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vrolesmenus`
-- (See below for the actual view)
--
CREATE TABLE `vrolesmenus` (
`id` int
,`parent_id` int
,`sortid` smallint
,`displaytext` varchar(50)
,`basedir` varchar(100)
,`linkaddress` varchar(50)
,`is_active` enum('0','1')
,`role_id` int
,`routename` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `work_permits`
--

CREATE TABLE `work_permits` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_order_id` bigint UNSIGNED DEFAULT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengawas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pengawas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_struktur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','submitted','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `induction_date` date DEFAULT NULL,
  `last_rejected_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_dokumen` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permits`
--

INSERT INTO `work_permits` (`id`, `purchase_order_id`, `vendor_id`, `telepon_pemohon`, `pengawas`, `telepon_pengawas`, `lampiran_struktur`, `status`, `created_at`, `updated_at`, `induction_date`, `last_rejected_by`, `no_dokumen`) VALUES
(33, 32, 2, '08977777', 'muhi', '08977777', 'work_permits/H3FCafAYBmtn7PBqtOWIl9J58zR8LIXUEdpOZEUI.png', 'approved', '2025-05-29 04:49:34', '2025-05-29 04:56:28', '2025-05-18', NULL, '0003/SHE/2025'),
(34, 33, 2, '08971000238', 'muhi', '08971000238', 'work_permits/7hYHsVO8eaH3HdRTAadwy7si9jZggUDcszWae0QS.jpg', 'approved', '2025-05-30 07:50:07', '2025-05-30 10:56:28', '2025-05-18', NULL, '0003/SHE/2025');

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_approvals`
--

CREATE TABLE `work_permit_approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `work_permit_id` bigint UNSIGNED DEFAULT NULL,
  `approver_id` bigint UNSIGNED DEFAULT NULL,
  `permission_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `catatan_safety` text COLLATE utf8mb4_unicode_ci,
  `catatan_lain` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_approvals`
--

INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `permission_name`, `level`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`, `catatan_safety`, `catatan_lain`) VALUES
(111, 33, 3, 'approval-pengawas', 1, 'approved', 'approve', '2025-05-29 04:51:48', '2025-05-29 04:50:41', '2025-05-29 04:51:48', NULL, NULL),
(112, 33, 6, 'approval-area', 2, 'approved', 'approve', '2025-05-29 04:53:15', '2025-05-29 04:51:48', '2025-05-29 04:53:15', NULL, NULL),
(113, 33, 7, 'approval-she_officer', 3, 'approved', 'approve', '2025-05-29 04:55:50', '2025-05-29 04:53:15', '2025-05-29 04:55:50', 'approve', 'approve'),
(114, 33, 8, 'approval-she_manager', 4, 'approved', 'approve', '2025-05-29 04:56:28', '2025-05-29 04:55:50', '2025-05-29 04:56:28', NULL, NULL),
(115, 34, 3, 'approval-pengawas', 1, 'approved', 'approve', '2025-05-30 10:47:16', '2025-05-30 10:46:23', '2025-05-30 10:47:16', NULL, NULL),
(116, 34, 6, 'approval-area', 2, 'approved', 'approve', '2025-05-30 10:47:45', '2025-05-30 10:47:16', '2025-05-30 10:47:45', NULL, NULL),
(117, 34, 7, 'approval-she_officer', 3, 'approved', 'approve', '2025-05-30 10:54:23', '2025-05-30 10:47:45', '2025-05-30 10:54:23', 'tes', 'tes'),
(118, 34, 8, 'approval-she_manager', 4, 'approved', 'approve', '2025-05-30 10:56:28', '2025-05-30 10:54:23', '2025-05-30 10:56:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_approval_levels`
--

CREATE TABLE `work_permit_approval_levels` (
  `id` int NOT NULL,
  `permission_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_approval_levels`
--

INSERT INTO `work_permit_approval_levels` (`id`, `permission_name`, `level`, `created_at`, `updated_at`) VALUES
(1, 'approval-pengawas', 1, '2025-05-06 09:55:23', '2025-05-06 09:55:23'),
(2, 'approval-area', 2, '2025-05-06 09:55:23', '2025-05-06 09:55:23'),
(3, 'approval-she_officer', 3, '2025-05-06 09:55:23', '2025-05-06 09:55:23'),
(4, 'approval-she_manager', 4, '2025-05-06 09:55:23', '2025-05-06 09:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_equipment`
--

CREATE TABLE `work_permit_equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `work_permit_id` bigint UNSIGNED DEFAULT NULL,
  `kategori` enum('alat','mesin','material','alat_berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `lampiran_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_equipment`
--

INSERT INTO `work_permit_equipment` (`id`, `work_permit_id`, `kategori`, `nama`, `jumlah`, `lampiran_foto`, `created_at`, `updated_at`) VALUES
(32, 33, 'alat', 'kabel', 1, NULL, '2025-05-29 04:50:16', '2025-05-29 04:50:16'),
(33, 34, 'alat', 'kabel', 1, NULL, '2025-05-30 07:51:10', '2025-05-30 07:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_jsa`
--

CREATE TABLE `work_permit_jsa` (
  `id` bigint UNSIGNED NOT NULL,
  `work_permit_id` bigint UNSIGNED DEFAULT NULL,
  `tahapan` enum('persiapan','mobilisasi','pelaksanaan','finishing') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_jsa`
--

INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES
(131, 33, 'persiapan', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(132, 33, 'mobilisasi', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(133, 33, 'pelaksanaan', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(134, 33, 'finishing', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(135, 34, 'persiapan', '2025-05-30 10:46:23', '2025-05-30 10:46:23'),
(136, 34, 'mobilisasi', '2025-05-30 10:46:23', '2025-05-30 10:46:23'),
(137, 34, 'pelaksanaan', '2025-05-30 10:46:23', '2025-05-30 10:46:23'),
(138, 34, 'finishing', '2025-05-30 10:46:23', '2025-05-30 10:46:23');

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_jsa_sub`
--

CREATE TABLE `work_permit_jsa_sub` (
  `id` bigint UNSIGNED NOT NULL,
  `jsa_id` bigint UNSIGNED DEFAULT NULL,
  `sub_tahapan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifikasi_bahaya` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengendalian_risiko` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_jsa_sub`
--

INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `identifikasi_bahaya`, `pengendalian_risiko`, `created_at`, `updated_at`) VALUES
(131, 131, 'awal1', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(132, 132, 'kedua', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(133, 133, 'awal1', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(134, 134, 'awal1', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-29 04:50:41', '2025-05-29 04:50:41'),
(135, 135, 'Pengajuan Work Permit', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-30 10:46:23', '2025-05-30 10:46:23'),
(136, 136, 'Pengajuan Work Permit', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-30 10:46:23', '2025-05-30 10:46:23'),
(137, 137, 'Pengajuan Work Permit', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-30 10:46:23', '2025-05-30 10:46:23'),
(138, 138, 'Pengajuan Work Permit', '\"Pengajuan Work Permit\"', '\"Pengajuan Work Permit\"', '2025-05-30 10:46:23', '2025-05-30 10:46:23');

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_workers`
--

CREATE TABLE `work_permit_workers` (
  `id` bigint UNSIGNED NOT NULL,
  `work_permit_id` bigint UNSIGNED DEFAULT NULL,
  `jabatan` enum('engineer','surveyor','operator_alat_berat','rigger','teknisi_elektrik','mekanik','welder','fitter','tukang_bangunan','hekiper','helper','safety_officer','lainnya') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_workers`
--

INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES
(1691, 33, 'engineer', 2, '2025-05-29 04:50:01', '2025-05-29 04:50:06'),
(1693, 33, 'operator_alat_berat', 1, '2025-05-29 04:50:06', '2025-05-29 04:50:06'),
(1704, 34, 'engineer', 1, '2025-05-30 07:50:18', '2025-05-30 07:50:21');

-- --------------------------------------------------------

--
-- Table structure for table `work_permit_worker_details`
--

CREATE TABLE `work_permit_worker_details` (
  `id` bigint UNSIGNED NOT NULL,
  `work_permit_worker_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_ktp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampiran_sertifikat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_permit_worker_details`
--

INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES
(152, 1691, 'nabawi', 'uploads/ktp/683849eddeb8a.png', 'uploads/sertifikat/683849edf3153.png', '2025-05-29 04:50:05', '2025-05-29 04:50:06'),
(153, 1691, 'asrul', 'uploads/ktp/683849ee15051.png', 'uploads/sertifikat/683849ee29d7c.png', '2025-05-29 04:50:05', '2025-05-29 04:50:06'),
(154, 1693, 'fajar', 'uploads/ktp/683849eeb5485.png', 'uploads/sertifikat/683849eecaaf7.png', '2025-05-29 04:50:06', '2025-05-29 04:50:06'),
(155, 1704, 'nabawi', 'uploads/ktp/6839c5ad0e3ef.jpg', 'uploads/sertifikat/6839c5ad1802b.jpg', '2025-05-30 07:50:20', '2025-05-30 07:50:21');

-- --------------------------------------------------------

--
-- Table structure for table `work_schedules`
--

CREATE TABLE `work_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `work_permit_id` bigint UNSIGNED DEFAULT NULL,
  `periode_laporan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_approve_she` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `approved_by` int DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `alasan_reject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lampiran_induction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_schedules`
--

INSERT INTO `work_schedules` (`id`, `work_permit_id`, `periode_laporan`, `project_manager`, `status_approve_she`, `approved_by`, `approved_at`, `alasan_reject`, `created_at`, `updated_at`, `lampiran_induction`) VALUES
(50, 33, '2025-03-17 s/d 2025-03-19', 'almuhyi', 'approved', 7, '2025-05-29 20:35:36', NULL, '2025-05-29 13:17:07', '2025-05-29 13:35:36', 'lampiran_induction/isKCNzh4AuyXCYqHGN23dhqjbdGX4MEf2aLcZKrp.png'),
(51, 33, '2025-04-17 s/d 2025-04-20', 'almuhyi', 'approved', 7, '2025-05-29 20:35:53', NULL, '2025-05-29 13:17:55', '2025-05-29 13:35:53', 'lampiran_induction/pFjgY6ix7zyZe3wgP5OB49CZMcwr2vhliS1EOzLB.png'),
(52, 33, '2025-05-16 s/d 2025-05-17', 'almuhyi', 'approved', 7, '2025-05-29 20:36:08', NULL, '2025-05-29 13:23:37', '2025-05-29 13:36:08', 'lampiran_induction/JbY3LptYuGfos3zEdw76vsVuRF9nM3aJhmT7cE1D.png'),
(54, 34, '2025-03-17 s/d 2025-03-18', 'almuhyi', 'pending', NULL, NULL, NULL, '2025-06-02 05:02:14', '2025-06-02 05:02:15', 'lampiran_induction/HroUeW2plqVi1bkNajk2a750tDQuzwTdUDTKjvHF.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `work_schedule_details`
--

CREATE TABLE `work_schedule_details` (
  `id` bigint UNSIGNED NOT NULL,
  `work_schedule_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jumlah_pekerja` int NOT NULL,
  `jam_kerja` int NOT NULL DEFAULT '8',
  `jumlah_jam_kerja_nyata` int GENERATED ALWAYS AS ((`jumlah_pekerja` * `jam_kerja`)) STORED,
  `jumlah_pekerja_lembur` int NOT NULL DEFAULT '0',
  `jam_lembur` int NOT NULL DEFAULT '0',
  `jumlah_jam_lembur` int GENERATED ALWAYS AS ((`jumlah_pekerja_lembur` * `jam_lembur`)) STORED,
  `jumlah_jam_kerja_real` int GENERATED ALWAYS AS ((`jumlah_jam_kerja_nyata` + `jumlah_jam_lembur`)) STORED,
  `cuti` int NOT NULL DEFAULT '0',
  `ijin` int NOT NULL DEFAULT '0',
  `sakit` int NOT NULL DEFAULT '0',
  `alpha` int NOT NULL DEFAULT '0',
  `kehilangan_jam_kerja` int GENERATED ALWAYS AS (((((`cuti` + `ijin`) + `sakit`) + `alpha`) * 8)) STORED,
  `jumlah_total_jam_kerja_aman` int GENERATED ALWAYS AS ((`jumlah_jam_kerja_real` - `kehilangan_jam_kerja`)) STORED,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_schedule_details`
--

INSERT INTO `work_schedule_details` (`id`, `work_schedule_id`, `tanggal`, `jumlah_pekerja`, `jam_kerja`, `jumlah_pekerja_lembur`, `jam_lembur`, `cuti`, `ijin`, `sakit`, `alpha`, `created_at`, `updated_at`) VALUES
(209, 50, '2025-03-17', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:07', '2025-05-29 13:17:07'),
(210, 50, '2025-03-18', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:07', '2025-05-29 13:17:07'),
(211, 50, '2025-03-19', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:07', '2025-05-29 13:17:07'),
(212, 51, '2025-04-17', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:55', '2025-05-29 13:17:55'),
(213, 51, '2025-04-18', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:55', '2025-05-29 13:17:55'),
(214, 51, '2025-04-19', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:55', '2025-05-29 13:17:55'),
(215, 51, '2025-04-20', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:17:55', '2025-05-29 13:17:55'),
(216, 52, '2025-05-16', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:23:37', '2025-05-29 13:23:37'),
(217, 52, '2025-05-17', 14, 8, 10, 8, 0, 0, 0, 0, '2025-05-29 13:23:37', '2025-05-29 13:23:37'),
(220, 54, '2025-03-17', 14, 8, 10, 8, 0, 0, 0, 0, '2025-06-02 05:02:15', '2025-06-02 05:02:15'),
(221, 54, '2025-03-18', 14, 8, 10, 8, 0, 0, 0, 0, '2025-06-02 05:02:15', '2025-06-02 05:02:15');

-- --------------------------------------------------------

--
-- Structure for view `vrolesmenus`
--
DROP TABLE IF EXISTS `vrolesmenus`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vrolesmenus`  AS SELECT `menus`.`id` AS `id`, `menus`.`parent_id` AS `parent_id`, `menus`.`sortid` AS `sortid`, `menus`.`displaytext` AS `displaytext`, `menus`.`basedir` AS `basedir`, `menus`.`linkaddress` AS `linkaddress`, `menus`.`is_active` AS `is_active`, `role_menu_route`.`role_id` AS `role_id`, `role_menu_route`.`routename` AS `routename` FROM (`menus` join `role_menu_route` on((`menus`.`id` = `role_menu_route`.`menu_id`))) WHERE (`menus`.`id` > 1)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_pembatalan`
--
ALTER TABLE `approval_pembatalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_pembatalan_ibfk_1` (`pengajuan_pembatalan_id`),
  ADD KEY `approval_pembatalan_ibfk_2` (`approver_id`);

--
-- Indexes for table `approval_penyelesaian`
--
ALTER TABLE `approval_penyelesaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_approval_penyelesaian_pengajuan` (`pengajuan_penyelesaian_id`),
  ADD KEY `fk_approval_penyelesaian_user` (`approver_id`);

--
-- Indexes for table `cek_materi_inspeksi`
--
ALTER TABLE `cek_materi_inspeksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_inspeksi_id` (`jadwal_inspeksi_id`),
  ADD KEY `sub_kategori_id` (`sub_kategori_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `divisi_inspeksi`
--
ALTER TABLE `divisi_inspeksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi_inspeksi_user`
--
ALTER TABLE `divisi_inspeksi_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisi_inspeksi_user_ibfk_1` (`user_id`),
  ADD KEY `divisi_inspeksi_id` (`divisi_inspeksi_id`);

--
-- Indexes for table `divisi_lingkungan`
--
ALTER TABLE `divisi_lingkungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_folder_id_foreign` (`folder_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folders_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `hasil_inspeksi`
--
ALTER TABLE `hasil_inspeksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_inspeksi_ibfk_1` (`jadwal_inspeksi_id`);

--
-- Indexes for table `history_storage`
--
ALTER TABLE `history_storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hse_monthly_reports`
--
ALTER TABLE `hse_monthly_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hse_monthly_reports_ibfk_1` (`work_schedule_id`);

--
-- Indexes for table `identifikasi_aspek_dampak_lingkungan`
--
ALTER TABLE `identifikasi_aspek_dampak_lingkungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_iadl_user` (`user_id`),
  ADD KEY `identifikasi_aspek_dampak_lingkungan_ibfk_1` (`lokasi_pengukuran_id`);

--
-- Indexes for table `ipbr`
--
ALTER TABLE `ipbr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ipbr_user` (`user_id`),
  ADD KEY `fk_ipbr_lokasi` (`lokasi_pengukuran_id`);

--
-- Indexes for table `jadwal_inspeksi`
--
ALTER TABLE `jadwal_inspeksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_inspeksi_ibfk_1` (`divisi_inspeksi_id`),
  ADD KEY `jadwal_inspeksi_ibfk_2` (`created_by`),
  ADD KEY `fk_verifikasi_oleh` (`verifikasi_oleh`);

--
-- Indexes for table `jadwal_inspeksi_approvals`
--
ALTER TABLE `jadwal_inspeksi_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_inspeksi_approvals_ibfk_1` (`jadwal_inspeksi_id`),
  ADD KEY `jadwal_inspeksi_approvals_ibfk_2` (`user_id`);

--
-- Indexes for table `jadwal_lokasi`
--
ALTER TABLE `jadwal_lokasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `jadwal_lokasi_ibfk_2` (`lokasi_id`);

--
-- Indexes for table `jadwal_pengukuran`
--
ALTER TABLE `jadwal_pengukuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `verifikasi_oleh` (`verifikasi_oleh`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_classifications`
--
ALTER TABLE `job_classifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_classification_safety_equipment`
--
ALTER TABLE `job_classification_safety_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_classification_safety_equipment_job_classification_foreign` (`job_classification_id`),
  ADD KEY `job_classification_safety_equipment_safety_equipment_id_foreign` (`safety_equipment_id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_inspeksi`
--
ALTER TABLE `kategori_inspeksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasis`
--
ALTER TABLE `lokasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi_pengukuran`
--
ALTER TABLE `lokasi_pengukuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materihead`
--
ALTER TABLE `materihead`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcu`
--
ALTER TABLE `mcu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcu_records`
--
ALTER TABLE `mcu_records`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`) USING BTREE;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengajuan_pembatalan`
--
ALTER TABLE `pengajuan_pembatalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_pembatalan_ibfk_1` (`purchase_order_id`),
  ADD KEY `pengajuan_pembatalan_ibfk_2` (`pengaju_id`);

--
-- Indexes for table `pengajuan_penyelesaian`
--
ALTER TABLE `pengajuan_penyelesaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_penyelesaian_po` (`purchase_order_id`);

--
-- Indexes for table `pengukuran_lingkungan`
--
ALTER TABLE `pengukuran_lingkungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `divisi_id` (`divisi_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `permissions_copy1`
--
ALTER TABLE `permissions_copy1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `purchase_order_job_classification`
--
ALTER TABLE `purchase_order_job_classification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_job_unique` (`purchase_order_id`,`job_classification_id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `job_classification_id` (`job_classification_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_menu_route`
--
ALTER TABLE `role_menu_route`
  ADD PRIMARY KEY (`role_id`,`menu_id`);

--
-- Indexes for table `safety_equipment`
--
ALTER TABLE `safety_equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `set_notif`
--
ALTER TABLE `set_notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_kategori_inspeksi`
--
ALTER TABLE `sub_kategori_inspeksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `tindak_lanjut_inspeksi`
--
ALTER TABLE `tindak_lanjut_inspeksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tindak_lanjut_inspeksi_ibfk_1` (`hasil_inspeksi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `user_lokasi_lingkungan`
--
ALTER TABLE `user_lokasi_lingkungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_lokasi_user` (`user_id`),
  ADD KEY `fk_user_lokasi_lokasi` (`lokasi_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_vendor` (`kd_vendor`);

--
-- Indexes for table `work_permits`
--
ALTER TABLE `work_permits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permits_ibfk_1` (`purchase_order_id`),
  ADD KEY `work_permits_ibfk_2` (`vendor_id`);

--
-- Indexes for table `work_permit_approvals`
--
ALTER TABLE `work_permit_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permit_approvals_ibfk_1` (`work_permit_id`),
  ADD KEY `work_permit_approvals_ibfk_2` (`approver_id`);

--
-- Indexes for table `work_permit_approval_levels`
--
ALTER TABLE `work_permit_approval_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_permit_equipment`
--
ALTER TABLE `work_permit_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permit_equipment_ibfk_1` (`work_permit_id`);

--
-- Indexes for table `work_permit_jsa`
--
ALTER TABLE `work_permit_jsa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permit_id` (`work_permit_id`);

--
-- Indexes for table `work_permit_jsa_sub`
--
ALTER TABLE `work_permit_jsa_sub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jsa_id` (`jsa_id`);

--
-- Indexes for table `work_permit_workers`
--
ALTER TABLE `work_permit_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permit_workers_ibfk_1` (`work_permit_id`);

--
-- Indexes for table `work_permit_worker_details`
--
ALTER TABLE `work_permit_worker_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permit_worker_details_ibfk_1` (`work_permit_worker_id`);

--
-- Indexes for table `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_permit_id` (`work_permit_id`);

--
-- Indexes for table `work_schedule_details`
--
ALTER TABLE `work_schedule_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_schedule_id` (`work_schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_pembatalan`
--
ALTER TABLE `approval_pembatalan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `approval_penyelesaian`
--
ALTER TABLE `approval_penyelesaian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `cek_materi_inspeksi`
--
ALTER TABLE `cek_materi_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `divisi_inspeksi`
--
ALTER TABLE `divisi_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `divisi_inspeksi_user`
--
ALTER TABLE `divisi_inspeksi_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `divisi_lingkungan`
--
ALTER TABLE `divisi_lingkungan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hasil_inspeksi`
--
ALTER TABLE `hasil_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `history_storage`
--
ALTER TABLE `history_storage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hse_monthly_reports`
--
ALTER TABLE `hse_monthly_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `identifikasi_aspek_dampak_lingkungan`
--
ALTER TABLE `identifikasi_aspek_dampak_lingkungan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ipbr`
--
ALTER TABLE `ipbr`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_inspeksi`
--
ALTER TABLE `jadwal_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jadwal_inspeksi_approvals`
--
ALTER TABLE `jadwal_inspeksi_approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jadwal_lokasi`
--
ALTER TABLE `jadwal_lokasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jadwal_pengukuran`
--
ALTER TABLE `jadwal_pengukuran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_classifications`
--
ALTER TABLE `job_classifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `job_classification_safety_equipment`
--
ALTER TABLE `job_classification_safety_equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322;

--
-- AUTO_INCREMENT for table `kategori_inspeksi`
--
ALTER TABLE `kategori_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lokasis`
--
ALTER TABLE `lokasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lokasi_pengukuran`
--
ALTER TABLE `lokasi_pengukuran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `materihead`
--
ALTER TABLE `materihead`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mcu`
--
ALTER TABLE `mcu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mcu_records`
--
ALTER TABLE `mcu_records`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengajuan_pembatalan`
--
ALTER TABLE `pengajuan_pembatalan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pengajuan_penyelesaian`
--
ALTER TABLE `pengajuan_penyelesaian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengukuran_lingkungan`
--
ALTER TABLE `pengukuran_lingkungan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `permissions_copy1`
--
ALTER TABLE `permissions_copy1`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `purchase_order_job_classification`
--
ALTER TABLE `purchase_order_job_classification`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `safety_equipment`
--
ALTER TABLE `safety_equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `set_notif`
--
ALTER TABLE `set_notif`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_kategori_inspeksi`
--
ALTER TABLE `sub_kategori_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tindak_lanjut_inspeksi`
--
ALTER TABLE `tindak_lanjut_inspeksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_lokasi_lingkungan`
--
ALTER TABLE `user_lokasi_lingkungan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_permits`
--
ALTER TABLE `work_permits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `work_permit_approvals`
--
ALTER TABLE `work_permit_approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `work_permit_approval_levels`
--
ALTER TABLE `work_permit_approval_levels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `work_permit_equipment`
--
ALTER TABLE `work_permit_equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `work_permit_jsa`
--
ALTER TABLE `work_permit_jsa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `work_permit_jsa_sub`
--
ALTER TABLE `work_permit_jsa_sub`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `work_permit_workers`
--
ALTER TABLE `work_permit_workers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1825;

--
-- AUTO_INCREMENT for table `work_permit_worker_details`
--
ALTER TABLE `work_permit_worker_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `work_schedules`
--
ALTER TABLE `work_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `work_schedule_details`
--
ALTER TABLE `work_schedule_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval_pembatalan`
--
ALTER TABLE `approval_pembatalan`
  ADD CONSTRAINT `approval_pembatalan_ibfk_1` FOREIGN KEY (`pengajuan_pembatalan_id`) REFERENCES `pengajuan_pembatalan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approval_pembatalan_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `approval_penyelesaian`
--
ALTER TABLE `approval_penyelesaian`
  ADD CONSTRAINT `approval_penyelesaian_ibfk_1` FOREIGN KEY (`pengajuan_penyelesaian_id`) REFERENCES `pengajuan_penyelesaian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approval_penyelesaian_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cek_materi_inspeksi`
--
ALTER TABLE `cek_materi_inspeksi`
  ADD CONSTRAINT `cek_materi_inspeksi_ibfk_1` FOREIGN KEY (`jadwal_inspeksi_id`) REFERENCES `jadwal_inspeksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cek_materi_inspeksi_ibfk_2` FOREIGN KEY (`sub_kategori_id`) REFERENCES `sub_kategori_inspeksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `fk_lokasi` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasis` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `divisi_inspeksi_user`
--
ALTER TABLE `divisi_inspeksi_user`
  ADD CONSTRAINT `divisi_inspeksi_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `divisi_inspeksi_user_ibfk_2` FOREIGN KEY (`divisi_inspeksi_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `divisi_lingkungan`
--
ALTER TABLE `divisi_lingkungan`
  ADD CONSTRAINT `divisi_lingkungan_ibfk_1` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi_pengukuran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_inspeksi`
--
ALTER TABLE `hasil_inspeksi`
  ADD CONSTRAINT `hasil_inspeksi_ibfk_1` FOREIGN KEY (`jadwal_inspeksi_id`) REFERENCES `jadwal_inspeksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hse_monthly_reports`
--
ALTER TABLE `hse_monthly_reports`
  ADD CONSTRAINT `hse_monthly_reports_ibfk_1` FOREIGN KEY (`work_schedule_id`) REFERENCES `work_schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `identifikasi_aspek_dampak_lingkungan`
--
ALTER TABLE `identifikasi_aspek_dampak_lingkungan`
  ADD CONSTRAINT `fk_iadl_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `identifikasi_aspek_dampak_lingkungan_ibfk_1` FOREIGN KEY (`lokasi_pengukuran_id`) REFERENCES `lokasis` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `ipbr`
--
ALTER TABLE `ipbr`
  ADD CONSTRAINT `fk_ipbr_lokasi` FOREIGN KEY (`lokasi_pengukuran_id`) REFERENCES `lokasis` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_ipbr_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_inspeksi`
--
ALTER TABLE `jadwal_inspeksi`
  ADD CONSTRAINT `jadwal_inspeksi_ibfk_1` FOREIGN KEY (`verifikasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jadwal_inspeksi_ibfk_2` FOREIGN KEY (`divisi_inspeksi_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `jadwal_inspeksi_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jadwal_inspeksi_approvals`
--
ALTER TABLE `jadwal_inspeksi_approvals`
  ADD CONSTRAINT `jadwal_inspeksi_approvals_ibfk_1` FOREIGN KEY (`jadwal_inspeksi_id`) REFERENCES `jadwal_inspeksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_inspeksi_approvals_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jadwal_lokasi`
--
ALTER TABLE `jadwal_lokasi`
  ADD CONSTRAINT `jadwal_lokasi_ibfk_1` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_pengukuran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_lokasi_ibfk_2` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasis` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `jadwal_pengukuran`
--
ALTER TABLE `jadwal_pengukuran`
  ADD CONSTRAINT `jadwal_pengukuran_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jadwal_pengukuran_ibfk_3` FOREIGN KEY (`verifikasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `job_classification_safety_equipment`
--
ALTER TABLE `job_classification_safety_equipment`
  ADD CONSTRAINT `job_classification_safety_equipment_ibfk_1` FOREIGN KEY (`job_classification_id`) REFERENCES `job_classifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_classification_safety_equipment_ibfk_2` FOREIGN KEY (`safety_equipment_id`) REFERENCES `safety_equipment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_pembatalan`
--
ALTER TABLE `pengajuan_pembatalan`
  ADD CONSTRAINT `pengajuan_pembatalan_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_pembatalan_ibfk_2` FOREIGN KEY (`pengaju_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pengukuran_lingkungan`
--
ALTER TABLE `pengukuran_lingkungan`
  ADD CONSTRAINT `pengukuran_lingkungan_ibfk_1` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_pengukuran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengukuran_lingkungan_ibfk_2` FOREIGN KEY (`divisi_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchase_orders_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `purchase_order_job_classification`
--
ALTER TABLE `purchase_order_job_classification`
  ADD CONSTRAINT `purchase_order_job_classification_ibfk_1` FOREIGN KEY (`job_classification_id`) REFERENCES `job_classifications` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchase_order_job_classification_ibfk_2` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_kategori_inspeksi`
--
ALTER TABLE `sub_kategori_inspeksi`
  ADD CONSTRAINT `sub_kategori_inspeksi_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_inspeksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tindak_lanjut_inspeksi`
--
ALTER TABLE `tindak_lanjut_inspeksi`
  ADD CONSTRAINT `tindak_lanjut_inspeksi_ibfk_1` FOREIGN KEY (`hasil_inspeksi_id`) REFERENCES `hasil_inspeksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_lokasi_lingkungan`
--
ALTER TABLE `user_lokasi_lingkungan`
  ADD CONSTRAINT `fk_user_lokasi_lokasi` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasis` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_user_lokasi_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_permits`
--
ALTER TABLE `work_permits`
  ADD CONSTRAINT `work_permits_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_permits_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_permit_approvals`
--
ALTER TABLE `work_permit_approvals`
  ADD CONSTRAINT `work_permit_approvals_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_permit_approvals_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `work_permit_equipment`
--
ALTER TABLE `work_permit_equipment`
  ADD CONSTRAINT `work_permit_equipment_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_permit_jsa`
--
ALTER TABLE `work_permit_jsa`
  ADD CONSTRAINT `work_permit_jsa_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_permit_jsa_sub`
--
ALTER TABLE `work_permit_jsa_sub`
  ADD CONSTRAINT `work_permit_jsa_sub_ibfk_1` FOREIGN KEY (`jsa_id`) REFERENCES `work_permit_jsa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_permit_workers`
--
ALTER TABLE `work_permit_workers`
  ADD CONSTRAINT `work_permit_workers_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_permit_worker_details`
--
ALTER TABLE `work_permit_worker_details`
  ADD CONSTRAINT `work_permit_worker_details_ibfk_1` FOREIGN KEY (`work_permit_worker_id`) REFERENCES `work_permit_workers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD CONSTRAINT `work_schedules_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_schedule_details`
--
ALTER TABLE `work_schedule_details`
  ADD CONSTRAINT `work_schedule_details_ibfk_1` FOREIGN KEY (`work_schedule_id`) REFERENCES `work_schedules` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
