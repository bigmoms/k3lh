/*
 Navicat Premium Dump SQL

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50739 (5.7.39)
 Source Host           : localhost:3306
 Source Schema         : k3lh

 Target Server Type    : MySQL
 Target Server Version : 50739 (5.7.39)
 File Encoding         : 65001

 Date: 23/04/2025 01:01:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of categories
-- ----------------------------
BEGIN;
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (1, 'maximem', 'maximem', '2025-03-24 04:10:22', '2025-03-24 06:46:51');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (2, 'ut', 'ut', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (3, 'nemo', 'nemo', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (4, 'sit', 'sit', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (5, 'reiciendis', 'reiciendis', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (6, 'recusandae', 'recusandae', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (7, 'vel', 'vel', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (8, 'ullam', 'ullam', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (9, 'occaecati', 'occaecati', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (10, 'ut', 'ut', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
COMMIT;

-- ----------------------------
-- Table structure for dept
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortnm` varchar(100) DEFAULT NULL,
  `longnm` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dept
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for inspekHead
-- ----------------------------
DROP TABLE IF EXISTS `inspekHead`;
CREATE TABLE `inspekHead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) NOT NULL,
  `tglinspeksi` date DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inspekHead
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job_classification_safety_equipment
-- ----------------------------
DROP TABLE IF EXISTS `job_classification_safety_equipment`;
CREATE TABLE `job_classification_safety_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_classification_id` int(11) NOT NULL,
  `safety_equipment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `job_classification_safety_equipment_job_classification_foreign` (`job_classification_id`) USING BTREE,
  KEY `job_classification_safety_equipment_safety_equipment_id_foreign` (`safety_equipment_id`) USING BTREE,
  CONSTRAINT `job_classification_safety_equipment_job_classification_foreign` FOREIGN KEY (`job_classification_id`) REFERENCES `job_classifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `job_classification_safety_equipment_safety_equipment_id_foreign` FOREIGN KEY (`safety_equipment_id`) REFERENCES `safety_equipment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_classification_safety_equipment
-- ----------------------------
BEGIN;
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (24, 6, 3, '2025-03-17 10:58:07', '2025-03-17 10:58:07');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (25, 6, 4, '2025-03-17 10:58:07', '2025-03-17 10:58:07');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (27, 6, 5, '2025-03-17 10:58:07', '2025-03-17 10:58:07');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (29, 13, 3, '2025-03-17 22:27:03', '2025-03-17 22:27:03');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (30, 13, 4, '2025-03-17 22:27:03', '2025-03-17 22:27:03');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (31, 13, 6, '2025-03-17 22:27:03', '2025-03-17 22:27:03');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (32, 13, 7, '2025-03-17 22:27:03', '2025-03-17 22:27:03');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (33, 13, 5, '2025-03-17 22:27:03', '2025-03-17 22:27:03');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (35, 13, 9, '2025-03-17 22:27:03', '2025-03-17 22:27:03');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (37, 13, 10, '2025-03-17 22:31:08', '2025-03-17 22:31:08');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (38, 13, 11, '2025-03-17 22:31:08', '2025-03-17 22:31:08');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (39, 14, 1, '2025-04-16 11:57:38', '2025-04-16 11:57:38');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (40, 14, 2, '2025-04-16 11:57:38', '2025-04-16 11:57:38');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (41, 14, 3, '2025-04-16 11:57:38', '2025-04-16 11:57:38');
INSERT INTO `job_classification_safety_equipment` (`id`, `job_classification_id`, `safety_equipment_id`, `created_at`, `updated_at`) VALUES (42, 6, 2, '2025-04-16 23:27:21', '2025-04-16 23:27:21');
COMMIT;

-- ----------------------------
-- Table structure for job_classifications
-- ----------------------------
DROP TABLE IF EXISTS `job_classifications`;
CREATE TABLE `job_classifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_classifications
-- ----------------------------
BEGIN;
INSERT INTO `job_classifications` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (6, 'Kerja Panas', NULL, '2025-03-14 10:15:40', '2025-03-14 10:15:40');
INSERT INTO `job_classifications` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (13, 'Ketinggian', NULL, '2025-03-14 10:45:39', '2025-03-14 10:45:39');
INSERT INTO `job_classifications` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (14, 'Lokasi Tinggi', NULL, '2025-04-16 04:57:38', '2025-04-16 04:57:38');
COMMIT;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for materiHead
-- ----------------------------
DROP TABLE IF EXISTS `materiHead`;
CREATE TABLE `materiHead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupnm` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of materiHead
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `sortid` smallint(6) DEFAULT NULL,
  `displaytext` varchar(50) DEFAULT NULL,
  `basedir` varchar(100) DEFAULT NULL,
  `linkaddress` varchar(50) DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menus
-- ----------------------------
BEGIN;
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (1, 0, 1, 'Krakatau Sarana Properti', NULL, '#', '1', '2025-03-28 16:56:02', '2025-04-16 02:08:05');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (2, 1, 1, 'Administrasi', 'Setting', '#', '1', '2025-03-28 17:37:55', '2025-04-16 02:08:08');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (3, 2, 1, 'Menu Aplikasi', NULL, '/admin/menus', '1', '2025-03-28 21:47:04', '2025-04-16 01:49:07');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (4, 2, 2, 'Role', NULL, '/admin/role', '1', '2025-03-28 21:47:26', '2025-04-16 01:49:19');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (5, 2, 3, 'Role Menu', NULL, '0', '0', '2025-03-28 21:48:04', '2025-04-19 16:44:26');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (6, 1, 2, 'Master Data', 'Category', '#', '1', '2025-03-28 21:48:18', '2025-04-16 02:08:10');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (7, 6, 1, 'Unit Kerja', NULL, '#', '1', '2025-03-28 21:48:40', '2025-04-16 02:08:10');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (8, 6, 2, 'Vendor Menajemen', NULL, '/admin/vendors', '1', '2025-03-28 21:49:08', '2025-04-16 01:49:36');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (9, 6, 3, 'Klasifikasi Pekerjaan', NULL, '/admin/klasifikasi-pekerjaan', '1', '2025-03-28 21:49:25', '2025-04-16 02:53:02');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (10, 6, 4, 'Pekerjaan', NULL, '/admin/purchase-orders', '1', '2025-03-28 21:49:53', '2025-04-16 13:45:55');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (11, 1, 3, 'Work Permit', 'Document', '#', '1', '2025-03-28 21:50:26', '2025-04-16 02:08:13');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (12, 11, 1, 'Pengajuan', NULL, '/permit/po', '1', '2025-03-28 21:51:07', '2025-04-17 02:07:54');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (13, 11, 2, 'Monitoring', NULL, '#', '1', '2025-03-28 21:51:20', '2025-04-16 02:08:14');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (14, 1, 4, 'Inspeksi K3LH', 'Info-circle', '#', '1', '2025-03-28 21:52:40', '2025-04-16 02:08:15');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (15, 2, 4, 'User Manajemen', NULL, '/admin/user', '1', '2025-03-31 11:39:49', '2025-04-19 09:40:30');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (16, 14, 1, 'Jadwal Inspeksi', NULL, '#', '1', '2025-04-01 14:39:40', '2025-04-16 02:08:16');
INSERT INTO `menus` (`id`, `parent_id`, `sortid`, `displaytext`, `basedir`, `linkaddress`, `is_active`, `created_at`, `updated_at`) VALUES (17, 14, 2, 'Inspeksi K3LH', NULL, '#', '1', '2025-04-01 14:40:10', '2025-04-16 02:08:18');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2025_03_24_043206_create_permission_tables', 2);
COMMIT;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
BEGIN;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (7, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (8, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (3, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (5, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (2, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (4, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (5, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (2, 'App\\Models\\User', 5);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (3, 'App\\Models\\User', 5);
COMMIT;

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of notifications
-- ----------------------------
BEGIN;
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('010c0bb6-f4f9-4f09-b103-ac8bc4d84866', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 18:06:31', '2025-04-14 18:06:31');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('0b821273-0b71-4cfe-9aec-560f8432008c', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 18:06:30', '2025-04-14 18:06:30');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('1181f3d2-6700-49dd-9ac1-8278aa80a49d', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTM=\"}', NULL, '2025-04-09 18:40:30', '2025-04-09 18:40:30');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('3cf12dc2-7299-4fa0-88ea-c990793a97ac', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', '2025-04-14 13:55:27', '2025-04-10 04:01:59', '2025-04-14 13:55:27');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('41cde5d2-6825-44e6-b95d-f7466ef95c3b', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 17:56:31', '2025-04-14 17:56:31');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('436238c6-3e7d-40ea-98a5-4f80c8ca3e33', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTM=\"}', '2025-04-09 18:40:43', '2025-04-09 18:40:30', '2025-04-09 18:40:43');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('5360c3fe-f918-4662-924e-08fc0fe2c822', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', '2025-04-14 13:57:08', '2025-04-10 04:02:00', '2025-04-14 13:57:08');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('558695c6-da45-475e-b436-5c9415c3848f', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 18:06:30', '2025-04-14 18:06:30');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('5a377e75-2d94-42f2-963d-9f3eaa93bf0f', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', '2025-04-10 03:52:44', '2025-04-10 03:48:32', '2025-04-10 03:52:44');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('5d63fd95-a143-49bc-8468-a304f9b203a2', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', '2025-04-14 13:56:12', '2025-04-10 04:02:00', '2025-04-14 13:56:12');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('6a63a496-d1b5-4a9e-aaa0-81b02c028561', 'App\\Notifications\\PurchaseOrderCreatedNotification', 'App\\Models\\User', 2, '{\"title\":\"PO Baru Diterbitkan\",\"message\":\"PO No. PO\\/IV\\/2025\\/001 telah diterbitkan.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/vendor\\/po\"}', '2025-04-09 12:52:36', '2025-04-09 12:52:02', '2025-04-09 12:52:36');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('6d712a8b-ee81-42c1-a64b-41346d12850e', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTM=\"}', NULL, '2025-04-09 18:40:30', '2025-04-09 18:40:30');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('83e4533d-4020-4412-bec9-a369c49e5337', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/001 telah diajukan.\",\"work_permit_id\":26,\"po_id\":13,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTM=\"}', NULL, '2025-04-09 18:40:30', '2025-04-09 18:40:30');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('8bdeb4b9-d9e9-4547-b5ae-36d7a511d338', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', '2025-04-10 03:50:25', '2025-04-10 03:48:32', '2025-04-10 03:50:25');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('9e6669ed-7477-4a2a-a0a6-915c999ea845', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 17:56:31', '2025-04-14 17:56:31');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('a911473b-b5d5-4913-bba5-b282e637425b', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 3, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pengawas\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-10 04:02:00', '2025-04-10 04:02:00');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('ad7cba4c-f93b-43e0-99b9-ace24f910896', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 18:06:30', '2025-04-14 18:06:30');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('afb8c5d8-60cb-466a-b61a-bef4a91b0545', 'App\\Notifications\\PurchaseOrderCreatedNotification', 'App\\Models\\User', 2, '{\"title\":\"PO Baru Diterbitkan\",\"message\":\"PO No. PO\\/IV\\/2025\\/002 telah diterbitkan.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/vendor\\/po\"}', NULL, '2025-04-10 03:41:28', '2025-04-10 03:41:28');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('bfa64935-df1c-4c47-ad89-7c28ffa25f15', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 4, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pemilik_area\\/po\\/progres\\/MTQ=\"}', '2025-04-10 03:51:37', '2025-04-10 03:48:32', '2025-04-10 03:51:37');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('c23e724c-f75f-49df-978a-88700a838378', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-10 03:48:32', '2025-04-10 03:48:32');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('c77155b7-5fa3-4bf2-b85f-d3d51a3f5aa6', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 5, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_officer\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 17:56:31', '2025-04-14 17:56:31');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES ('e5def70c-b4dd-4bb1-b865-8abb1c07d62f', 'App\\Notifications\\WorkPermitSubmitted', 'App\\Models\\User', 6, '{\"title\":\"Pengajuan Work Permit Baru\",\"message\":\"Work Permit dengan No. PO PO\\/IV\\/2025\\/002 telah diajukan.\",\"work_permit_id\":27,\"po_id\":14,\"submitted_by\":\"PT TEST\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/she_manager\\/po\\/progres\\/MTQ=\"}', NULL, '2025-04-14 17:56:31', '2025-04-14 17:56:31');
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'login', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'login store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (3, 'logout', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (4, 'password request', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (5, 'password reset', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (6, 'password email', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (7, 'password update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (8, 'register', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (9, 'register store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (10, 'user profile information update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (11, 'user password update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (12, 'password confirm', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (13, 'password confirmation', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (14, 'password confirm store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (15, 'two factor login', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (16, 'two factor login store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (17, 'two factor enable', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (18, 'two factor confirm', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (19, 'two factor disable', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (20, 'two factor qr code', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (21, 'two factor secret key', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (22, 'two factor recovery codes', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (23, 'generated::6sfiafdgprd0j6ph', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (24, 'sanctum csrf cookie', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (25, 'livewire update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (26, 'generated::8t1qufjktgpxvsvt', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (27, 'generated::f0araebyl7yhou4g', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (28, 'livewire upload file', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (29, 'livewire preview file', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (30, 'ignition healthcheck', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (31, 'ignition executesolution', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (32, 'ignition updateconfig', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (33, 'generated::qz3ejkzmacw3eirb', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (34, 'generated::iu7zjge4fsuz2ytc', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (35, 'dashboard', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (36, 'menus index', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (37, 'menus getmenus', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (38, 'menus store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (39, 'user change_password', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (40, 'role assign permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (41, 'update role permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (42, 'user assign permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (43, 'update user permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (44, 'user assign role', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (45, 'update user role', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (46, 'user index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (47, 'user create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (48, 'user store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (49, 'user show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (50, 'user edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (51, 'user update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (52, 'user destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (53, 'permission index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (54, 'permission create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (55, 'permission store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (56, 'permission show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (57, 'permission edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (58, 'permission update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (59, 'permission destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (60, 'role index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (61, 'role create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (62, 'role store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (63, 'role show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (64, 'role edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (65, 'role update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (66, 'role destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (67, 'category index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (68, 'category create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (69, 'category store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (70, 'category show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (71, 'category edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (72, 'category update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (73, 'category destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (74, 'post index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (75, 'post create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (76, 'post store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (77, 'post show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (78, 'post edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (79, 'post update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (80, 'post destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (81, 'profile edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (82, 'profile update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (83, 'home', 'web', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for permissions_copy1
-- ----------------------------
DROP TABLE IF EXISTS `permissions_copy1`;
CREATE TABLE `permissions_copy1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions_copy1
-- ----------------------------
BEGIN;
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'login', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'login store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (3, 'logout', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (4, 'password request', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (5, 'password reset', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (6, 'password email', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (7, 'password update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (8, 'register', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (9, 'register store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (10, 'user profile information update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (11, 'user password update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (12, 'password confirm', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (13, 'password confirmation', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (14, 'password confirm store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (15, 'two factor login', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (16, 'two factor login store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (17, 'two factor enable', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (18, 'two factor confirm', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (19, 'two factor disable', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (20, 'two factor qr code', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (21, 'two factor secret key', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (22, 'two factor recovery codes', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (23, 'generated::6sfiafdgprd0j6ph', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (24, 'sanctum csrf cookie', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (25, 'livewire update', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (26, 'generated::8t1qufjktgpxvsvt', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (27, 'generated::f0araebyl7yhou4g', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (28, 'livewire upload file', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (29, 'livewire preview file', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (30, 'ignition healthcheck', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (31, 'ignition executesolution', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (32, 'ignition updateconfig', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (33, 'generated::qz3ejkzmacw3eirb', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (34, 'generated::iu7zjge4fsuz2ytc', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (35, 'dashboard', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (36, 'menus index', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (37, 'menus getmenus', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (38, 'menus store', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (39, 'user change_password', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (40, 'role assign permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (41, 'update role permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (42, 'user assign permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (43, 'update user permission', 'web', '2025-04-01 13:51:01', '2025-04-01 13:51:01');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (44, 'user assign role', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (45, 'update user role', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (46, 'user index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (47, 'user create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (48, 'user store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (49, 'user show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (50, 'user edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (51, 'user update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (52, 'user destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (53, 'permission index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (54, 'permission create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (55, 'permission store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (56, 'permission show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (57, 'permission edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (58, 'permission update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (59, 'permission destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (60, 'role index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (61, 'role create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (62, 'role store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (63, 'role show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (64, 'role edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (65, 'role update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (66, 'role destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (67, 'category index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (68, 'category create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (69, 'category store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (70, 'category show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (71, 'category edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (72, 'category update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (73, 'category destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (74, 'post index', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (75, 'post create', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (76, 'post store', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (77, 'post show', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (78, 'post edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (79, 'post update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (80, 'post destroy', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (81, 'profile edit', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (82, 'profile update', 'web', '2025-04-01 13:51:02', '2025-04-01 13:51:02');
INSERT INTO `permissions_copy1` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (83, 'home', 'web', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of posts
-- ----------------------------
BEGIN;
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (1, 'Et culpa a non dolores minus.', 'et-culpa-a-non-dolores-minus', 'Est natus quaerat ut harum. Sed aut impedit doloribus rem quia. Sint ratione aliquid nobis qui perferendis. Rerum quis fugit distinctio et.', 'post/example-image.jpg', 3, 6, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (2, 'Ducimus odit ea atque.', 'ducimus-odit-ea-atque', 'Aut hic at rem quidem. Voluptate consequatur corrupti voluptatibus voluptate. Non consequatur pariatur qui impedit placeat vel veniam. Deleniti aut est amet totam.', 'post/example-image.jpg', 3, 2, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (3, 'Et accusantium sint iusto.', 'et-accusantium-sint-iusto', 'Dicta eius cum voluptatibus vel aut ipsa laborum at. Qui in nisi ab. At quae qui pariatur est.', 'post/example-image.jpg', 9, 1, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (4, 'Et aut cum eaque impedit sint quaerat sapiente.', 'et-aut-cum-eaque-impedit-sint-quaerat-sapiente', 'Facilis eveniet sit nostrum sunt consequuntur velit ut. Sed repudiandae inventore ad vitae sed. Fuga error et recusandae vitae.', 'post/example-image.jpg', 8, 9, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (5, 'Ab cumque quia est incidunt.', 'ab-cumque-quia-est-incidunt', 'Sunt magni sit totam. Cumque fugit aspernatur perspiciatis aut voluptas est corporis quis. Aperiam libero ipsa qui numquam. Aut dolores aut aut debitis libero.', 'post/example-image.jpg', 7, 6, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (6, 'Ut eius omnis ut est.', 'ut-eius-omnis-ut-est', 'Et in sit fugit rem ipsam animi et perferendis. Rem est sapiente enim non inventore. Dicta vero laudantium repellendus atque error culpa omnis. Aliquid aperiam voluptas a est ducimus minus non.', 'post/example-image.jpg', 3, 3, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (7, 'Incidunt quia et sint neque esse error.', 'incidunt-quia-et-sint-neque-esse-error', 'Et ut eum ducimus iure. Quia qui libero voluptatem similique et non nam ullam. Ad et qui qui rerum quod. Nesciunt neque quia ad illum perspiciatis non blanditiis.', 'post/example-image.jpg', 8, 2, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (8, 'Aspernatur dolore nesciunt ut voluptas asperiores qui.', 'aspernatur-dolore-nesciunt-ut-voluptas-asperiores-qui', 'Et molestiae consequatur rerum. Consequatur reiciendis sapiente ex tenetur eum ut magni. Voluptatem suscipit ut nulla officia est amet et. Nemo exercitationem aut incidunt omnis sed et.', 'post/example-image.jpg', 1, 5, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (9, 'Unde harum atque unde quisquam ducimus consectetur.', 'unde-harum-atque-unde-quisquam-ducimus-consectetur', 'Quaerat nostrum quia totam nihil nihil laudantium delectus. Et quidem et ex est sit. Placeat delectus ea sequi totam sit ipsum et officiis. Qui dolorum fugiat quam officia non magnam et.', 'post/example-image.jpg', 10, 7, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (10, 'Ut doloribus accusamus provident modi.', 'ut-doloribus-accusamus-provident-modi', 'Voluptatibus aliquam aliquid ullam et vitae voluptas non. Sed sequi iste esse amet occaecati et quasi. Deleniti est amet dignissimos reiciendis iusto velit et.', 'post/example-image.jpg', 1, 10, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (11, 'Officia molestiae veritatis reprehenderit quia quaerat maiores.', 'officia-molestiae-veritatis-reprehenderit-quia-quaerat-maiores', 'Atque optio iure voluptatibus quaerat eveniet. Deleniti a recusandae quaerat debitis ex voluptates eaque. Voluptatem et nostrum sint neque suscipit et sunt.', 'post/example-image.jpg', 7, 4, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (12, 'Aperiam saepe repellendus voluptatem dolorem quis et.', 'aperiam-saepe-repellendus-voluptatem-dolorem-quis-et', 'Sed consectetur sed ut consectetur. Aut odit quia inventore rerum sequi distinctio. Rerum ut placeat sed eos vel et.', 'post/example-image.jpg', 6, 7, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (13, 'Cum ducimus commodi debitis sint impedit architecto.', 'cum-ducimus-commodi-debitis-sint-impedit-architecto', 'Cum aliquid quisquam earum asperiores. Non vitae quo quam expedita. Autem et totam animi nam expedita et. Illum quaerat quibusdam aut ut.', 'post/example-image.jpg', 9, 1, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (14, 'Dicta voluptatem dolorum debitis iure incidunt.', 'dicta-voluptatem-dolorum-debitis-iure-incidunt', 'Sint tempora rerum ut. Eligendi sed amet id est dicta enim. Rerum consequatur aut possimus recusandae. Pariatur eos excepturi velit pariatur est quaerat. Rerum et illo consequatur et maiores tempora.', 'post/example-image.jpg', 6, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (15, 'Velit quia ad reiciendis est quia perferendis reprehenderit.', 'velit-quia-ad-reiciendis-est-quia-perferendis-reprehenderit', 'Atque ducimus corrupti nulla doloribus. Vitae vel facilis aperiam consectetur. Labore quam qui in neque impedit sed illum fugiat.', 'post/example-image.jpg', 8, 9, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (16, 'Officiis suscipit animi soluta voluptatem in.', 'officiis-suscipit-animi-soluta-voluptatem-in', 'Sit nulla qui commodi optio et possimus beatae. Voluptas a odit neque culpa nihil cupiditate iusto. Enim ipsam sed inventore mollitia ad adipisci. Dicta vitae vitae omnis maxime nam architecto.', 'post/example-image.jpg', 2, 10, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (17, 'Et aut est libero ut.', 'et-aut-est-libero-ut', 'Perspiciatis beatae fuga est molestiae qui quibusdam. Ut unde qui aut consequuntur eos impedit dolor eaque. Repellat aut alias animi eum. Tempora odit autem tempora et doloribus quos.', 'post/example-image.jpg', 10, 10, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (18, 'Et rerum id maxime sunt.', 'et-rerum-id-maxime-sunt', 'Adipisci dignissimos nesciunt natus ut. Aut eum consequuntur ex commodi voluptatem. Tempore pariatur pariatur ad earum facilis. Soluta porro qui aut est similique asperiores eveniet.', 'post/example-image.jpg', 1, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (19, 'Dolores et aperiam non culpa dolore aliquid repudiandae aspernatur.', 'dolores-et-aperiam-non-culpa-dolore-aliquid-repudiandae-aspernatur', 'Vitae minima eos occaecati aliquam sint nihil illum. Quasi ab quis ullam qui laborum officiis.', 'post/example-image.jpg', 3, 2, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (20, 'Dignissimos ipsa minima voluptate magnam.', 'dignissimos-ipsa-minima-voluptate-magnam', 'Modi animi quaerat sed. Ut rerum et modi eaque. Beatae ea et aliquam aut qui voluptas qui mollitia.', 'post/example-image.jpg', 2, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (21, 'Expedita perferendis beatae nostrum et nulla vel sint.', 'expedita-perferendis-beatae-nostrum-et-nulla-vel-sint', 'Est earum error ut deserunt. Ducimus corporis quasi facilis beatae inventore.', 'post/example-image.jpg', 2, 2, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (22, 'Repellendus distinctio dolores corrupti velit eos.', 'repellendus-distinctio-dolores-corrupti-velit-eos', 'Suscipit eos reiciendis eaque consequatur sunt voluptates ut. Dicta ab ad nobis fuga eos totam est. Recusandae suscipit dolores optio cupiditate. Consectetur hic nostrum inventore aut possimus nemo.', 'post/example-image.jpg', 3, 10, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (23, 'Autem nulla velit delectus voluptatem.', 'autem-nulla-velit-delectus-voluptatem', 'Quasi labore nam sequi totam odio non accusamus voluptatem. Dolor aut corporis illo odio. Placeat aut aliquam voluptatem atque repellat.', 'post/example-image.jpg', 8, 2, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (24, 'Iusto rem iure doloribus nisi vitae nihil voluptas.', 'iusto-rem-iure-doloribus-nisi-vitae-nihil-voluptas', 'Accusamus vitae tempora itaque ab non. Voluptatem voluptatum quod tempora rerum dolores. Quibusdam aut minima occaecati exercitationem occaecati aperiam molestias.', 'post/example-image.jpg', 1, 8, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (25, 'Eligendi consequatur autem recusandae et earum.', 'eligendi-consequatur-autem-recusandae-et-earum', 'Nemo laudantium ut laborum quasi dicta ea. Aut magnam et sit. Dignissimos sunt fugiat impedit quasi vero repellat.', 'post/example-image.jpg', 6, 3, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (26, 'Nemo sit odio facilis eos optio quod commodi.', 'nemo-sit-odio-facilis-eos-optio-quod-commodi', 'Iste nostrum architecto fugit. Quaerat unde omnis omnis voluptas. Ipsam dolor rerum temporibus aut expedita. Qui reprehenderit aut voluptas dolor doloremque.', 'post/example-image.jpg', 6, 1, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (27, 'Porro dolorem et eum sunt cumque natus.', 'porro-dolorem-et-eum-sunt-cumque-natus', 'Ea consequatur repellat quam eum neque enim. Hic dolor sed qui. Molestiae quidem molestiae perspiciatis aperiam vel quod placeat. Consequatur aut sed rerum aperiam quam.', 'post/example-image.jpg', 3, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (28, 'Repellendus occaecati corrupti dolor et a occaecati.', 'repellendus-occaecati-corrupti-dolor-et-a-occaecati', 'Impedit modi est est quibusdam rerum recusandae reprehenderit. Fuga sapiente laudantium qui quas mollitia. Modi nesciunt consectetur cupiditate nulla porro repudiandae quo.', 'post/example-image.jpg', 7, 10, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (29, 'Nesciunt minima consectetur recusandae dolor.', 'nesciunt-minima-consectetur-recusandae-dolor', 'Cum laborum omnis exercitationem natus. Repudiandae tempore autem quae quas excepturi fugit ratione. Ab laudantium magnam aut.', 'post/example-image.jpg', 10, 9, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (30, 'Soluta occaecati placeat eaque eius soluta.', 'soluta-occaecati-placeat-eaque-eius-soluta', 'Aut deserunt impedit quos illo doloribus odio. Rerum repudiandae in suscipit voluptas. Neque praesentium voluptatem aut id. Deserunt et quis sint consequatur at eum.', 'post/example-image.jpg', 6, 4, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (31, 'Qui ut aliquam placeat corporis numquam.', 'qui-ut-aliquam-placeat-corporis-numquam', 'Veritatis reiciendis voluptas ducimus nemo cupiditate. Quia optio et eos facilis nam quia eos. Et aliquid placeat assumenda et ab quo.', 'post/example-image.jpg', 3, 6, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (32, 'Est sapiente ipsa et voluptatem aut veniam magni.', 'est-sapiente-ipsa-et-voluptatem-aut-veniam-magni', 'Harum totam sed itaque placeat. Nemo eos dolor est. Voluptas vel voluptas ipsum et repudiandae omnis omnis. Est sed rerum deserunt rerum neque sapiente.', 'post/example-image.jpg', 2, 1, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (33, 'Veniam qui iusto quaerat explicabo velit assumenda.', 'veniam-qui-iusto-quaerat-explicabo-velit-assumenda', 'Sed itaque eum provident assumenda. Explicabo nobis corporis aut eaque. Ea unde itaque eveniet iusto ipsam. Facilis et mollitia saepe sed doloribus aut.', 'post/example-image.jpg', 10, 3, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (34, 'Iste qui sunt voluptatum quia quo.', 'iste-qui-sunt-voluptatum-quia-quo', 'Cum corporis corrupti dignissimos cumque voluptatum. Est ut qui cupiditate placeat suscipit. Et ut voluptate doloribus unde harum. Quia et necessitatibus voluptas unde maxime ut.', 'post/example-image.jpg', 10, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (35, 'Accusamus repudiandae dolores est voluptatem.', 'accusamus-repudiandae-dolores-est-voluptatem', 'Officiis dolores saepe ab cumque. Placeat qui numquam amet quam. Asperiores nesciunt est earum reiciendis. Aliquam voluptatem dolores nisi nam.', 'post/example-image.jpg', 7, 7, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (36, 'Accusantium hic eveniet dolor exercitationem alias.', 'accusantium-hic-eveniet-dolor-exercitationem-alias', 'Fugit ratione aut id aliquid vero. Harum quod et repellendus. Et tempore quia sunt aut tempore ullam omnis. Atque voluptate et in cum et.', 'post/example-image.jpg', 9, 9, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (37, 'Architecto ad dignissimos sit tempora consequuntur.', 'architecto-ad-dignissimos-sit-tempora-consequuntur', 'Non id iure delectus itaque. Autem expedita eligendi consequuntur. Eligendi consequatur aut et minus nisi rem.', 'post/example-image.jpg', 7, 8, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (38, 'Dolor est qui maiores nihil minus quia.', 'dolor-est-qui-maiores-nihil-minus-quia', 'Est tenetur cupiditate repellat. Minus omnis adipisci ut itaque et nihil a. Expedita et omnis consequatur alias rerum aut. Eum eum veniam quia sed corporis cupiditate.', 'post/example-image.jpg', 4, 7, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (39, 'Nisi sit modi ipsam omnis sit neque.', 'nisi-sit-modi-ipsam-omnis-sit-neque', 'Expedita deleniti aspernatur placeat tenetur assumenda aut laborum. Autem minima voluptas cum in. Nisi sunt saepe quo veritatis facere eos. Voluptas quasi quod accusamus nostrum architecto vel.', 'post/example-image.jpg', 5, 4, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (40, 'Impedit quam suscipit incidunt non consequatur porro vero amet.', 'impedit-quam-suscipit-incidunt-non-consequatur-porro-vero-amet', 'Enim ratione inventore consectetur ut ipsa autem modi. Qui ut ut officia neque in enim sunt. Quo voluptate sint qui debitis vero voluptates fugiat deserunt.', 'post/example-image.jpg', 10, 4, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (41, 'Eum soluta iure adipisci.', 'eum-soluta-iure-adipisci', 'Id quo laudantium temporibus consequuntur assumenda dolorem. Qui voluptas quis voluptas nihil omnis magnam. Debitis amet minus omnis ea.', 'post/example-image.jpg', 8, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (42, 'Est et earum impedit qui.', 'est-et-earum-impedit-qui', 'Similique ut illum facere sed dolor. Qui magnam maiores est quas harum rerum. Non facere officia alias eius esse facilis ad. Quod sed aspernatur qui optio in aperiam.', 'post/example-image.jpg', 10, 1, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (43, 'Repellat nisi voluptas necessitatibus quos et.', 'repellat-nisi-voluptas-necessitatibus-quos-et', 'Quasi ea velit sed ut totam eaque. Aut consectetur explicabo itaque quam ut assumenda eaque quaerat. Aut voluptatem ut eaque aliquam sint placeat. Et veniam a iusto quisquam at est et.', 'post/example-image.jpg', 9, 10, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (44, 'Sint aut velit illum at.', 'sint-aut-velit-illum-at', 'Veniam illo maxime reiciendis quibusdam. Ut officiis officiis eos dignissimos quibusdam omnis.', 'post/example-image.jpg', 4, 9, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (45, 'Quis saepe officiis nam voluptatum tempore sunt delectus.', 'quis-saepe-officiis-nam-voluptatum-tempore-sunt-delectus', 'Fugit voluptatem quam ut. Ullam quia eum nisi corporis vitae.', 'post/example-image.jpg', 3, 7, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (46, 'Quis voluptas suscipit est culpa eligendi error.', 'quis-voluptas-suscipit-est-culpa-eligendi-error', 'Nemo voluptas qui eum ullam quibusdam hic. Cumque odio enim rerum facilis id excepturi. Libero veritatis aspernatur recusandae laudantium et reiciendis.', 'post/example-image.jpg', 3, 10, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (47, 'Accusamus earum error corporis.', 'accusamus-earum-error-corporis', 'Amet velit odit labore aut quas eveniet. Omnis ex modi iusto nam. Dolores minus suscipit quas delectus voluptas rerum magni velit.', 'post/example-image.jpg', 2, 5, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (48, 'Voluptas amet ea qui est.', 'voluptas-amet-ea-qui-est', 'Et laboriosam fuga est corporis. Itaque magni ut provident fugiat debitis. Aut impedit ut saepe. Delectus voluptate pariatur qui aut necessitatibus autem.', 'post/example-image.jpg', 6, 5, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (49, 'Necessitatibus consequatur perspiciatis quo praesentium in natus.', 'necessitatibus-consequatur-perspiciatis-quo-praesentium-in-natus', 'Fugit earum est dolor minima. Laudantium et dolor velit quia.', 'post/example-image.jpg', 2, 3, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (50, 'Illo voluptatem quae id non corporis fugiat voluptatem aliquid.', 'illo-voluptatem-quae-id-non-corporis-fugiat-voluptatem-aliquid', 'Cupiditate velit praesentium fuga accusantium quia. Est non hic sed officiis eaque earum quisquam. Tempora incidunt facere quia illo. Et reprehenderit consequatur quis suscipit iure.', 'post/example-image.jpg', 5, 9, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (51, 'At dolores sint cupiditate commodi earum sequi et.', 'at-dolores-sint-cupiditate-commodi-earum-sequi-et', 'Tempore distinctio nobis ut unde. Et nesciunt quia tenetur. Est non repudiandae ullam eligendi. Nesciunt voluptatem in consectetur totam rerum quia.', 'post/example-image.jpg', 6, 8, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (52, 'Officia adipisci porro id.', 'officia-adipisci-porro-id', 'Consequuntur est delectus aut quis omnis sint. Omnis est maxime temporibus magnam dignissimos quia. Assumenda sunt illo quae at sit ad. Nihil et libero voluptas et.', 'post/example-image.jpg', 7, 6, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (53, 'A quo molestiae provident explicabo.', 'a-quo-molestiae-provident-explicabo', 'Quas sit quia suscipit dolor voluptatum. Et quo magni dignissimos eos. Natus cum libero asperiores voluptatibus et beatae ut exercitationem. Consequatur eum incidunt dolore enim labore quasi harum.', 'post/example-image.jpg', 6, 5, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (54, 'Fugiat fugit et quibusdam sit aperiam.', 'fugiat-fugit-et-quibusdam-sit-aperiam', 'Alias sunt minima voluptatem aut temporibus ut ea tenetur. Id quo excepturi consequuntur totam. Quae eum laudantium itaque laborum deserunt ducimus. Corrupti minima aut neque beatae corrupti officia.', 'post/example-image.jpg', 9, 5, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (55, 'Aut quia molestiae reiciendis quia vitae porro.', 'aut-quia-molestiae-reiciendis-quia-vitae-porro', 'Quam aliquid quia temporibus vitae. Eveniet ducimus ea adipisci nemo nihil molestias aut. Qui nihil mollitia natus. Et molestiae deserunt culpa fuga.', 'post/example-image.jpg', 3, 4, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (56, 'Est ut temporibus hic eaque.', 'est-ut-temporibus-hic-eaque', 'Ad aspernatur blanditiis architecto aut aliquam nostrum. Vel aspernatur quo nulla ut quam saepe. Est quod eum non ut. Possimus dolor in in facere ut. Autem rerum vero aliquid eaque enim ab.', 'post/example-image.jpg', 5, 10, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (57, 'Consequatur beatae et qui.', 'consequatur-beatae-et-qui', 'Aut in animi in consequatur iusto et culpa quis. Fugiat autem ut saepe. Quo placeat consequuntur eaque. Ipsa quis eum aperiam architecto libero modi iste.', 'post/example-image.jpg', 9, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (58, 'Consequuntur et dolores repellendus eum.', 'consequuntur-et-dolores-repellendus-eum', 'Eveniet at sed rerum ullam unde. Qui sed incidunt dolorum tenetur sit voluptatem. Qui et odit nemo ut quam sint. Porro odit eligendi totam error laborum quis.', 'post/example-image.jpg', 10, 3, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (59, 'Sed dolorum dolore et delectus velit sequi adipisci.', 'sed-dolorum-dolore-et-delectus-velit-sequi-adipisci', 'Sed molestiae consequatur sit ut laudantium. Autem sit officia reiciendis quia at sed distinctio. Aut assumenda sunt qui fugiat illo.', 'post/example-image.jpg', 6, 10, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (60, 'Non veniam voluptatem repellat.', 'non-veniam-voluptatem-repellat', 'Quia sit et possimus est quas. Dolor soluta cumque ut labore aperiam. Rerum animi et qui.', 'post/example-image.jpg', 6, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (61, 'Quis modi nesciunt dolor error quasi fuga.', 'quis-modi-nesciunt-dolor-error-quasi-fuga', 'Dolores velit modi quaerat quia tenetur magni ex aut. Eaque rerum maiores sit eos. Excepturi assumenda enim dolorum.', 'post/example-image.jpg', 3, 1, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (62, 'Soluta nulla optio ex non cupiditate non hic.', 'soluta-nulla-optio-ex-non-cupiditate-non-hic', 'Ut nihil quibusdam culpa officia ratione. Eius consequatur alias est et. Necessitatibus qui repellat nam animi ducimus. Blanditiis quidem id totam molestias.', 'post/example-image.jpg', 8, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (63, 'Impedit quo ad ut quo voluptatibus.', 'impedit-quo-ad-ut-quo-voluptatibus', 'Aliquam ea repellat exercitationem nesciunt iste. Voluptate voluptates debitis maiores voluptas veniam mollitia et. Quo repudiandae est aliquid nulla.', 'post/example-image.jpg', 8, 8, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (64, 'Et ipsum asperiores explicabo error.', 'et-ipsum-asperiores-explicabo-error', 'Qui sint at dicta quis quia. Pariatur omnis voluptatibus natus et nisi error. Eaque et voluptas ea non vitae est quisquam.', 'post/example-image.jpg', 7, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (65, 'Quasi nisi pariatur qui occaecati quasi.', 'quasi-nisi-pariatur-qui-occaecati-quasi', 'Eos eos est minus enim doloremque. Fugit nemo quae quas quia quis animi numquam. Porro accusantium quae voluptas.', 'post/example-image.jpg', 4, 5, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (66, 'Ipsa et voluptas odit blanditiis.', 'ipsa-et-voluptas-odit-blanditiis', 'Neque vel ad alias. Distinctio ut eum sapiente sed quasi odit. Cumque et tenetur expedita dolorum voluptatem aut iusto. Architecto totam consequatur ut voluptatibus.', 'post/example-image.jpg', 2, 1, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (67, 'Quidem ut fugiat qui ratione deleniti.', 'quidem-ut-fugiat-qui-ratione-deleniti', 'Itaque vero quia excepturi dolor eaque nobis et. Voluptas at iste eum consequatur atque corrupti.', 'post/example-image.jpg', 7, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (68, 'Esse praesentium illum consequatur quis.', 'esse-praesentium-illum-consequatur-quis', 'Aperiam porro quia necessitatibus vel. Temporibus molestias repellendus dolorum voluptatem nemo. Illo placeat et suscipit omnis. Molestias culpa a vel ullam est.', 'post/example-image.jpg', 6, 9, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (69, 'Soluta sed aut qui tempora.', 'soluta-sed-aut-qui-tempora', 'Cum et sapiente dolores. Quibusdam eos quo voluptatem id ut doloremque. Corrupti ut aliquam iure possimus accusantium incidunt. Magnam rerum consequatur sunt quae qui vel ratione.', 'post/example-image.jpg', 6, 8, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (70, 'Quos animi explicabo qui.', 'quos-animi-explicabo-qui', 'Tempora deserunt quibusdam numquam aperiam. Quisquam quis animi aut facilis. Occaecati atque perferendis quis est doloremque vero repudiandae. Aliquam alias aspernatur possimus non dolorum.', 'post/example-image.jpg', 7, 7, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (71, 'Temporibus reiciendis alias aut.', 'temporibus-reiciendis-alias-aut', 'Sapiente accusamus ipsum similique maiores. Qui aut ratione vel dolor. Sunt officia velit minus est. Et et enim et sint voluptatem.', 'post/example-image.jpg', 5, 3, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (72, 'Odit ea architecto sed minus deserunt error et.', 'odit-ea-architecto-sed-minus-deserunt-error-et', 'Facilis quis sunt quisquam. At libero optio excepturi. Sint illo earum et quaerat et ab tempore consequatur. Ut laborum nemo qui omnis.', 'post/example-image.jpg', 9, 5, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (73, 'Vitae et omnis a ut quidem.', 'vitae-et-omnis-a-ut-quidem', 'Illum earum aliquid rerum sit fuga aut. Quo numquam ab est eligendi voluptatem optio dolore. Dolor omnis recusandae modi. Non saepe nihil et voluptates ab molestiae aliquid molestias.', 'post/example-image.jpg', 5, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (74, 'Ab tempora at ab ut.', 'ab-tempora-at-ab-ut', 'Nostrum animi iusto nostrum. Veniam autem dolores quaerat qui voluptatem maiores occaecati. Exercitationem delectus dolorem aliquam omnis.', 'post/example-image.jpg', 3, 7, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (75, 'Sit alias sint illo sint ex.', 'sit-alias-sint-illo-sint-ex', 'Iusto qui dolores deserunt vitae recusandae ab neque vel. Dolor aut sunt vitae. Repellat quos quasi dolor ut accusantium voluptatem dignissimos et. Dolores voluptatem et delectus saepe voluptates.', 'post/example-image.jpg', 10, 10, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (76, 'Distinctio voluptatem voluptas accusantium ut et veritatis.', 'distinctio-voluptatem-voluptas-accusantium-ut-et-veritatis', 'Voluptatibus doloremque eum vel et provident corrupti nostrum ea. Sint eum veritatis rem cumque. Omnis accusamus et maxime et illo molestias.', 'post/example-image.jpg', 3, 3, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (77, 'Quis minima aspernatur id dolor possimus.', 'quis-minima-aspernatur-id-dolor-possimus', 'Est at consequatur beatae iure quisquam labore laborum. Aliquam rerum quis ullam molestiae animi expedita accusamus non. Iure esse aut dolor aperiam. Voluptatem nemo aut officia culpa est aliquam.', 'post/example-image.jpg', 5, 5, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (78, 'Natus amet rerum deleniti autem molestiae.', 'natus-amet-rerum-deleniti-autem-molestiae', 'Illum et laudantium aperiam illo veritatis facilis itaque. Magnam dolore cupiditate quis quae. Sit quaerat non natus accusantium magni et.', 'post/example-image.jpg', 7, 3, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (79, 'Eos ipsa omnis sed.', 'eos-ipsa-omnis-sed', 'Tempore pariatur voluptatem necessitatibus ut similique est vero. Cupiditate fugiat ut expedita eveniet natus. Eveniet veritatis asperiores sed natus earum temporibus harum.', 'post/example-image.jpg', 9, 7, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (80, 'Omnis totam accusantium exercitationem dolore asperiores.', 'omnis-totam-accusantium-exercitationem-dolore-asperiores', 'Modi tempora officia nemo sint error dolor suscipit suscipit. Sint enim sit est omnis. Est nisi dicta exercitationem dolore.', 'post/example-image.jpg', 9, 7, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (81, 'Sint nemo vitae ratione voluptatem quis.', 'sint-nemo-vitae-ratione-voluptatem-quis', 'Alias quis aut reprehenderit et exercitationem harum. Exercitationem repudiandae nemo voluptate sunt. Et qui in in distinctio. Facere dolores error veritatis doloribus sed dolorem.', 'post/example-image.jpg', 1, 10, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (82, 'Omnis impedit occaecati ipsam quos.', 'omnis-impedit-occaecati-ipsam-quos', 'Doloribus modi architecto eos et itaque. Qui odit voluptate et maxime nemo debitis quam. Nihil aut quia voluptates reprehenderit eveniet rerum. Et ad ipsam ad sit explicabo quasi.', 'post/example-image.jpg', 6, 4, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (83, 'Excepturi exercitationem et nobis dolorem.', 'excepturi-exercitationem-et-nobis-dolorem', 'Quo consectetur qui pariatur aliquid. Perspiciatis eligendi harum eum inventore nostrum ipsum accusantium natus. Et autem mollitia voluptas. Reprehenderit placeat omnis eum tempora provident.', 'post/example-image.jpg', 2, 4, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (84, 'Velit vel explicabo aut.', 'velit-vel-explicabo-aut', 'Ipsa quaerat quod nemo laborum sunt doloremque veniam. Reprehenderit ipsam ut et incidunt voluptate. Mollitia quia illum sunt eveniet.', 'post/example-image.jpg', 7, 5, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (85, 'Reiciendis porro distinctio dolorum reprehenderit et est.', 'reiciendis-porro-distinctio-dolorum-reprehenderit-et-est', 'Et molestiae aut omnis quidem. Sunt distinctio et officia sint perferendis nisi. Quod perspiciatis id ipsam dignissimos numquam et iste. Saepe ducimus unde mollitia reiciendis.', 'post/example-image.jpg', 4, 3, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (86, 'Fugit dolorum repellat placeat fugit excepturi quos quo.', 'fugit-dolorum-repellat-placeat-fugit-excepturi-quos-quo', 'Voluptas ut suscipit quae quos omnis nobis. Beatae non iure voluptatem ut enim. Neque beatae aperiam error aut. Voluptatem dolorem aliquid quod.', 'post/example-image.jpg', 3, 7, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (87, 'Tenetur velit veritatis quis qui dolor nobis tenetur.', 'tenetur-velit-veritatis-quis-qui-dolor-nobis-tenetur', 'Et delectus blanditiis doloremque beatae explicabo sint maiores autem. Vel veritatis voluptas quae et exercitationem. Nesciunt ratione praesentium ipsa id dolore.', 'post/example-image.jpg', 3, 10, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (88, 'Maxime tempora ab eius pariatur beatae quis.', 'maxime-tempora-ab-eius-pariatur-beatae-quis', 'At aut est magni ratione veniam voluptate ut. Cumque omnis quae quidem vitae non eius. Adipisci earum quisquam et fugit similique.', 'post/example-image.jpg', 10, 9, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (89, 'Maiores est illo perspiciatis consequatur dignissimos.', 'maiores-est-illo-perspiciatis-consequatur-dignissimos', 'Aspernatur voluptatum beatae facilis nisi natus. Quia aut iste et voluptatibus deserunt sequi aliquid. Debitis sunt possimus quas labore doloremque sed ut. Ut a accusamus et sint est.', 'post/example-image.jpg', 7, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (90, 'Ut sequi nihil aut.', 'ut-sequi-nihil-aut', 'Accusantium et consequatur aut neque nobis odit. Id voluptatem amet ab. Quam architecto expedita quisquam blanditiis officiis tempore odio atque.', 'post/example-image.jpg', 10, 8, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (91, 'Ea ipsam iste eveniet molestiae molestiae.', 'ea-ipsam-iste-eveniet-molestiae-molestiae', 'Sint rem corporis consequatur nostrum vero labore consectetur. Accusamus harum sunt est est repellat id odit. At non aut delectus exercitationem.', 'post/example-image.jpg', 5, 8, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (92, 'Aut est inventore autem voluptas provident.', 'aut-est-inventore-autem-voluptas-provident', 'Consequatur vel quaerat corrupti rerum. Error esse eum et cumque error nisi ipsam. Quidem rem quidem nihil. Nihil porro id enim beatae et nostrum.', 'post/example-image.jpg', 4, 2, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (93, 'Nemo et rerum cupiditate consequuntur voluptatibus veniam.', 'nemo-et-rerum-cupiditate-consequuntur-voluptatibus-veniam', 'Ipsa praesentium et dolore quibusdam rem. Explicabo placeat eius nemo hic tenetur eos iusto. Eum nihil eum illo et sunt deleniti.', 'post/example-image.jpg', 8, 5, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (94, 'Cupiditate voluptatem eum ut laboriosam.', 'cupiditate-voluptatem-eum-ut-laboriosam', 'Ullam sit omnis quia sequi impedit quaerat aut. Voluptatem consequatur inventore odit et. Unde dolore est aut quos molestias.', 'post/example-image.jpg', 1, 4, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (95, 'Sed non totam sed voluptatibus magni.', 'sed-non-totam-sed-voluptatibus-magni', 'Dolorum omnis porro aut sit doloremque in. Ratione est molestias quod sit corrupti impedit. Blanditiis laboriosam molestiae iusto dolores.', 'post/example-image.jpg', 4, 5, 'process', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (96, 'Consectetur fuga aut deleniti cum molestiae.', 'consectetur-fuga-aut-deleniti-cum-molestiae', 'Eum voluptatem facilis necessitatibus et. Ut nihil voluptatem et consectetur est. Fugiat incidunt delectus vel facilis. Numquam eos eos architecto et iusto alias.', 'post/example-image.jpg', 6, 9, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (97, 'Perspiciatis ut voluptatem dolorum praesentium quis unde.', 'perspiciatis-ut-voluptatem-dolorum-praesentium-quis-unde', 'Architecto neque consequuntur veritatis assumenda ducimus sed est. Quis odit eligendi nisi maxime sunt. Pariatur accusantium libero nemo fuga ducimus corporis qui. Vel facere at earum vel iusto quia.', 'post/example-image.jpg', 4, 2, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (98, 'Ut consequatur veniam minus.', 'ut-consequatur-veniam-minus', 'Fugiat sit excepturi consequatur cupiditate aperiam reiciendis in. Mollitia debitis sit corporis nam. Placeat quia libero aut.', 'post/example-image.jpg', 8, 6, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (99, 'Nam consequatur qui quidem voluptatem.', 'nam-consequatur-qui-quidem-voluptatem', 'Sint ut saepe possimus soluta et accusamus. Omnis et id corrupti est sit ducimus voluptatem. Perferendis eaque tempore quisquam quia iure nihil labore quia.', 'post/example-image.jpg', 3, 10, 'published', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES (100, 'Placeat aut fuga temporibus ducimus voluptas.', 'placeat-aut-fuga-temporibus-ducimus-voluptas', 'Eveniet enim aut aut sint voluptatem atque. Nesciunt ut occaecati voluptatibus voluptas tenetur placeat. Quod sunt qui eum dolor accusantium. Qui doloribus at consequatur.', 'post/example-image.jpg', 4, 8, 'draft', '2025-03-24 04:10:22', '2025-03-24 04:10:22');
COMMIT;

-- ----------------------------
-- Table structure for purchase_order_job_classification
-- ----------------------------
DROP TABLE IF EXISTS `purchase_order_job_classification`;
CREATE TABLE `purchase_order_job_classification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL,
  `job_classification_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `po_job_unique` (`purchase_order_id`,`job_classification_id`) USING BTREE,
  KEY `purchase_order_id` (`purchase_order_id`) USING BTREE,
  KEY `job_classification_id` (`job_classification_id`) USING BTREE,
  CONSTRAINT `job_class_foreign` FOREIGN KEY (`job_classification_id`) REFERENCES `job_classifications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `po_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of purchase_order_job_classification
-- ----------------------------
BEGIN;
INSERT INTO `purchase_order_job_classification` (`id`, `purchase_order_id`, `job_classification_id`) VALUES (2, 1, 13);
INSERT INTO `purchase_order_job_classification` (`id`, `purchase_order_id`, `job_classification_id`) VALUES (26, 1, 14);
COMMIT;

-- ----------------------------
-- Table structure for purchase_orders
-- ----------------------------
DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `nama_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pekerjaan` enum('jasa_perorangan','jasa_non_perorangan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_pekerjaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('draft','active','cancelled','completed','submitted') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `purchase_orders_user_id_foreign` FOREIGN KEY (`created_by`) REFERENCES `permit`.`users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_orders_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `permit`.`vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchase_orders
-- ----------------------------
BEGIN;
INSERT INTO `purchase_orders` (`id`, `vendor_id`, `nama_pekerjaan`, `jenis_pekerjaan`, `area_pekerjaan`, `lokasi_pekerjaan`, `detail_pekerjaan`, `tanggal_mulai`, `tanggal_akhir`, `created_by`, `status`, `is_deleted`, `created_at`, `updated_at`, `no_po`) VALUES (1, 1, 'Perbaikan Kaca Gedung', 'jasa_non_perorangan', 'Wisma Krakatau', 'Wisma Krakatau', 'Memperbaiki Kaca Wisma', '2025-04-16', '2025-08-31', 1, 'draft', 0, '2025-04-16 16:28:30', '2025-04-16 16:28:30', 'PO/IV/2025/001');
COMMIT;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
BEGIN;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (29, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (31, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (32, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (33, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (34, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (35, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (36, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (37, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (38, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (39, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (40, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (41, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (42, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (43, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (44, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (46, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (47, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (48, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (49, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (50, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (51, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (53, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (54, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (55, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (56, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (57, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (58, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (60, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (61, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (62, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (63, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (64, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (65, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (66, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (67, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (68, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (69, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (70, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (71, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (74, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (75, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (83, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (65, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (66, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (67, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (68, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (69, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (70, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (71, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (72, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (73, 2);
COMMIT;

-- ----------------------------
-- Table structure for role_menu_route
-- ----------------------------
DROP TABLE IF EXISTS `role_menu_route`;
CREATE TABLE `role_menu_route` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `routename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_menu_route
-- ----------------------------
BEGIN;
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 1, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 2, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 3, '/admin/menus', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 4, '/admin/role', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 5, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 6, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 7, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 8, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 9, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 10, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 11, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 12, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 13, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 14, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 15, '/admin/user', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (1, 16, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (4, 1, NULL, '2025-04-18 18:49:57', '2025-04-18 18:49:57');
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (4, 11, NULL, '2025-04-18 18:49:57', '2025-04-18 18:49:57');
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (4, 12, NULL, '2025-04-18 18:49:57', '2025-04-18 18:49:57');
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (4, 13, NULL, '2025-04-18 18:49:57', '2025-04-18 18:49:57');
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (8, 1, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (8, 11, '#', NULL, NULL);
INSERT INTO `role_menu_route` (`role_id`, `menu_id`, `routename`, `created_at`, `updated_at`) VALUES (8, 12, '3', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'Super Admin', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'Purchasing', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (3, 'Pengawas', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (4, 'Pemilik Area', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (5, 'SHE Officer', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (6, 'SHE Manager', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (7, 'Vendor', 'web', '2025-04-22 07:10:14', '2025-04-22 07:10:14');
COMMIT;

-- ----------------------------
-- Table structure for safety_equipment
-- ----------------------------
DROP TABLE IF EXISTS `safety_equipment`;
CREATE TABLE `safety_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of safety_equipment
-- ----------------------------
BEGIN;
INSERT INTO `safety_equipment` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES (1, 'Tali', 'apd', '2025-04-16 04:57:38', '2025-04-16 04:57:38');
INSERT INTO `safety_equipment` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES (2, 'Scafolding', 'apd', '2025-04-16 04:57:38', '2025-04-16 04:57:38');
INSERT INTO `safety_equipment` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES (3, 'P3K', 'perlengkapan_darurat', '2025-04-16 04:57:38', '2025-04-16 04:57:38');
INSERT INTO `safety_equipment` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES (4, 'Hazmet', 'apd', '2025-04-16 16:27:21', '2025-04-16 16:27:21');
INSERT INTO `safety_equipment` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES (5, 'Obta Merah', 'perlengkapan_darurat', '2025-04-16 16:27:21', '2025-04-16 16:27:21');
COMMIT;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
BEGIN;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('58G4o58Pyz2iKU6ZVVxJPgEWLdm6awFd9BaGrLrX', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUWFpUVFKRFViNGFRV0xPQ3RsWlVFdmowcE5GeVlaczAwYlJlTW1YQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1742942430);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('cJh3pL1bVPqIqJZ3YJibc6Az4Ar1XIaPRL2K84R6', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGY5b3lRYnNadjBlaWF1OWxxdUp4NUZKbGFJYXBhTGNoWHRsYUdYciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly9rM2xoLmt1L3VzZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1742804757);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('r8XzLnQdmtP3mYEpTxK7Y5jt1mo2MLUAhfInU55A', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDhuakMxQzRtdHd3TGlEdWN5SUFFa0RmT09TR29OT3c2UmN0NVJmeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly9rM2xoLmt1L2xvZ2luIjt9fQ==', 1743153036);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_vendor` tinyint(4) DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$tuvkReJiG7RH3H2F84V3heT694OB5VfU4qqG4epmKTwbaWKVtIrIK', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:16', '2025-04-22 21:14:59');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (2, 'Vendor', 'almuhyifajar1945@gmail.com', NULL, '$2y$10$tuvkReJiG7RH3H2F84V3heT694OB5VfU4qqG4epmKTwbaWKVtIrIK', NULL, 1, 1, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:14:58');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (3, 'Pengawas', 'demo1@example.org', NULL, '$2y$10$pn2Z0JZJs2JWwxCXqw9ksuf8KoRkYLoo4FyIBOwpTSMoV9WcwBXC6', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 16:19:35');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (4, 'Buford Ryan', 'jwisoky@example.com', NULL, '$2y$10$IiYeE0aB4FSXSkmVfDTyuuFf4clWjV/tz0gl2/mHNu5I4gIvlGSJa', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:15:01');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (5, 'Elton Kautzer', 'towne.elouise@example.net', NULL, '$2y$10$AavN0Re7O8mlCkSLFexf2eddEeR9FirORwjPTTeOBXMVM.ZXOfUsa', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:15:02');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (6, 'Giuseppe Wilderman V', 'brandy.luettgen@example.net', NULL, '$2y$10$pnuiSe6kg0UYebnkkPshvuZ4WKx4RpcsSJYOd/TEm4uRhkIKn45im', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:15:02');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (7, 'Krystina Mayert', 'ratke.amparo@example.org', NULL, '$2y$10$4jbUgXdbAyeKzvULhLNfLuElyPgXwbRMwgEVMh5ZTXEzf2csC8A32', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:15:02');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (8, 'Prof. Liza Gerlach DVM', 'smith.william@example.org', NULL, '$2y$10$gjBMlfe3irpto3iCV4tQguF2pNftnBQ4zkSlrINVSMh3AZM5wc6PS', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:15:03');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vendor_id`, `is_active`, `is_vendor`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES (9, 'Karlie Abshire', 'gstokes@example.com', NULL, '$2y$10$4ZWSSqqShgZaqm9mRFLUq.2170gxYfRb40L4pm7U.wTPqydv9njIq', NULL, 1, 0, NULL, NULL, NULL, NULL, '2025-03-24 04:10:21', '2025-04-22 21:15:03');
COMMIT;

-- ----------------------------
-- Table structure for vendors
-- ----------------------------
DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_vendor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direksi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `kd_vendor` (`kd_vendor`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of vendors
-- ----------------------------
BEGIN;
INSERT INTO `vendors` (`id`, `kd_vendor`, `vendor_name`, `address`, `city`, `province`, `npwp`, `phone`, `email`, `direksi`, `created_at`, `updated_at`) VALUES (1, '999999', 'PT VENDOR TEST', 'Jl. Testing No. 99', 'Jakarta', 'DKI Jakarta', '000000000000000', '02112345678', 'testvendor@gmail.com', 'TEST MANAGER', '2025-03-14 07:13:01', '2025-03-14 07:13:01');
INSERT INTO `vendors` (`id`, `kd_vendor`, `vendor_name`, `address`, `city`, `province`, `npwp`, `phone`, `email`, `direksi`, `created_at`, `updated_at`) VALUES (2, '111111', 'PT TEST', 'serang', 'Serang', 'Banten', '000000000000001', '02212345678', 'almuhyifajar1945@gmail.com', 'MUHI', NULL, '2025-03-18 12:49:00');
COMMIT;

-- ----------------------------
-- Table structure for work_permit_approvals
-- ----------------------------
DROP TABLE IF EXISTS `work_permit_approvals`;
CREATE TABLE `work_permit_approvals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_permit_id` int(11) NOT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `role` enum('pengawas','pemilik_area','she_officer','she_manager') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `work_permit_id` (`work_permit_id`),
  KEY `approver_id` (`approver_id`),
  CONSTRAINT `work_permit_approvals_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `permit`.`work_permits` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_permit_approvals_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `permit`.`users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_permit_approvals
-- ----------------------------
BEGIN;
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (1, 12, 3, 'pengawas', 'approved', 'approve', '2025-03-24 10:17:42', '2025-03-23 00:42:47', '2025-03-24 10:17:42');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (5, 12, 4, 'pemilik_area', 'approved', 'oke', '2025-03-24 13:28:49', '2025-03-24 10:17:42', '2025-03-24 13:28:49');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (6, 12, 5, 'she_officer', 'approved', 'approve', '2025-03-24 15:04:10', '2025-03-24 13:16:50', '2025-03-24 15:04:10');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (7, 12, 6, 'she_manager', 'approved', 'approve', '2025-03-24 15:46:43', '2025-03-24 14:18:37', '2025-03-24 15:46:43');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (76, 26, 3, 'pengawas', 'pending', NULL, NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (77, 26, 4, 'pemilik_area', 'pending', NULL, NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (78, 26, 5, 'she_officer', 'pending', NULL, NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (79, 26, 6, 'she_manager', 'pending', NULL, NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (80, 27, 3, 'pengawas', 'approved', 'approve', '2025-04-14 13:54:16', '2025-04-10 03:48:32', '2025-04-14 13:54:16');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (87, 27, 4, 'pemilik_area', 'approved', 'oke approve', '2025-04-14 13:55:34', '2025-04-14 13:54:16', '2025-04-14 13:55:34');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (88, 27, 5, 'she_officer', 'approved', 'approve', '2025-04-14 14:48:54', '2025-04-14 13:55:34', '2025-04-14 14:48:54');
INSERT INTO `work_permit_approvals` (`id`, `work_permit_id`, `approver_id`, `role`, `status`, `keterangan`, `approved_at`, `created_at`, `updated_at`) VALUES (90, 27, 6, 'she_manager', 'approved', 'mantap', '2025-04-14 18:08:17', '2025-04-14 14:48:54', '2025-04-14 18:08:17');
COMMIT;

-- ----------------------------
-- Table structure for work_permit_equipment
-- ----------------------------
DROP TABLE IF EXISTS `work_permit_equipment`;
CREATE TABLE `work_permit_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_permit_id` int(11) NOT NULL,
  `kategori` enum('alat','mesin','material','alat_berat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `lampiran_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `work_permit_id` (`work_permit_id`) USING BTREE,
  CONSTRAINT `work_permit_equipment_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_permit_equipment
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for work_permit_jsa
-- ----------------------------
DROP TABLE IF EXISTS `work_permit_jsa`;
CREATE TABLE `work_permit_jsa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_permit_id` int(11) NOT NULL,
  `tahapan` enum('persiapan','mobilisasi','pelaksanaan','finishing') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `work_permit_id` (`work_permit_id`) USING BTREE,
  CONSTRAINT `work_permit_jsa_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_permit_jsa
-- ----------------------------
BEGIN;
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (34, 12, 'persiapan', '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (35, 12, 'persiapan', '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (36, 12, 'mobilisasi', '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (37, 12, 'pelaksanaan', '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (38, 12, 'finishing', '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (67, 26, 'persiapan', '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (68, 26, 'mobilisasi', '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (69, 26, 'pelaksanaan', '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (70, 26, 'finishing', '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (75, 27, 'persiapan', '2025-04-14 18:06:28', '2025-04-14 18:06:28');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (76, 27, 'mobilisasi', '2025-04-14 18:06:28', '2025-04-14 18:06:28');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (77, 27, 'pelaksanaan', '2025-04-14 18:06:28', '2025-04-14 18:06:28');
INSERT INTO `work_permit_jsa` (`id`, `work_permit_id`, `tahapan`, `created_at`, `updated_at`) VALUES (78, 27, 'finishing', '2025-04-14 18:06:28', '2025-04-14 18:06:28');
COMMIT;

-- ----------------------------
-- Table structure for work_permit_jsa_sub
-- ----------------------------
DROP TABLE IF EXISTS `work_permit_jsa_sub`;
CREATE TABLE `work_permit_jsa_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jsa_id` int(11) NOT NULL,
  `sub_tahapan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_pekerjaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifikasi_bahaya` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengendalian_risiko` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_jsa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `jsa_id` (`jsa_id`) USING BTREE,
  CONSTRAINT `work_permit_jsa_sub_ibfk_1` FOREIGN KEY (`jsa_id`) REFERENCES `work_permit_jsa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_permit_jsa_sub
-- ----------------------------
BEGIN;
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (31, 34, 'awal1', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (32, 35, 'kedua', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (33, 36, 'awal1', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (34, 37, 'awal1', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (35, 38, 'akhir', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-03-23 00:42:47', '2025-03-23 00:42:47');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (64, 67, 'pertama', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (65, 68, 'pertama', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (66, 69, 'pertama', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (67, 70, 'pertama', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-09 18:35:15', '2025-04-09 18:35:15');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (72, 75, 'kedua', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-14 18:06:28', '2025-04-14 18:06:28');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (73, 76, 'kedua', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-14 18:06:28', '2025-04-14 18:06:28');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (74, 77, 'kedua', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-14 18:06:28', '2025-04-14 18:06:28');
INSERT INTO `work_permit_jsa_sub` (`id`, `jsa_id`, `sub_tahapan`, `deskripsi_pekerjaan`, `identifikasi_bahaya`, `pengendalian_risiko`, `lampiran_jsa`, `created_at`, `updated_at`) VALUES (75, 78, 'kedua', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', '\"\\\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\\\"\"', NULL, '2025-04-14 18:06:28', '2025-04-14 18:06:28');
COMMIT;

-- ----------------------------
-- Table structure for work_permit_worker_details
-- ----------------------------
DROP TABLE IF EXISTS `work_permit_worker_details`;
CREATE TABLE `work_permit_worker_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_permit_worker_id` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampiran_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `work_permit_worker_id` (`work_permit_worker_id`) USING BTREE,
  CONSTRAINT `work_permit_worker_details_ibfk_1` FOREIGN KEY (`work_permit_worker_id`) REFERENCES `work_permit_workers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_permit_worker_details
-- ----------------------------
BEGIN;
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (32, 171, 'muhi', 'uploads/ktp/v0XdO1tCxMiVBfTYbpn90s9L63I6CuMl1aLBhDan.png', 'uploads/sertifikat/2Bez8ppd4AQ9Q0mNHV9G5a1oDMhkdOMrpzd1GPq4.png', '2025-03-20 01:12:35', '2025-03-20 01:22:16');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (34, 171, 'fajar', 'uploads/ktp/nq57hWQ4pAJEFqfuTFYQLub3FUFKbkJHRWvZ38FV.png', 'uploads/sertifikat/gWeojILnBlDya4HDdf1Ol4vw3phpQaqyGKk6s52Q.png', '2025-03-20 01:22:16', '2025-03-20 01:22:16');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (36, 202, 'jamal', 'uploads/ktp/X5fysRIFObOCs09kBXCBNpqbUgTOvGjktGq3dN0o.png', 'uploads/sertifikat/533v5PSMWvWLjOwjS61U91c2uCEnIxAU1YISAw9m.png', '2025-03-20 01:27:47', '2025-03-20 01:27:47');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (64, 219, 'juhri', 'uploads/ktp/Fci9r1mMry1ONyaY8aLrDWHfKQOQ1rXizZSjEkJ0.png', 'uploads/sertifikat/ZRfAt6lDHKaGX3qW4rIaIidi8WQnHsgJMiQhbUOy.png', '2025-04-09 18:34:06', '2025-04-09 18:34:06');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (65, 219, 'ahmad', 'uploads/ktp/UtdO2bT2ziTI418KYT93YMXeu7W6wFGXJXSLsxfP.png', 'uploads/sertifikat/WseEk0ZAqidcrwvIadFKbsIRVUnmXUBbBMwnbGr2.png', '2025-04-09 18:34:06', '2025-04-09 18:34:06');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (66, 220, 'jaya', 'uploads/ktp/E4zgs9DDpyfYvUCQ60Hk5DodxApesWzHceVuY0JE.png', 'uploads/sertifikat/MBjURy1fOadgtV1Q1SieyyeAXDDHSVRjDdzP4a3s.png', '2025-04-09 18:34:06', '2025-04-09 18:34:06');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (67, 220, 'fajar', 'uploads/ktp/ydL6WZr4hQTFFe9GJk9KIIoMvcFvntmoLsxq963T.png', 'uploads/sertifikat/hKVvUQuIwMfEAm56nXNgOalvvDtaoG7ToxLKV2HK.png', '2025-04-09 18:34:06', '2025-04-09 18:34:06');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (68, 221, 'ahmad', 'uploads/ktp/WICOquvjfQFX9u79mGsHqBkGT7dX7dBpdswTlqsO.png', 'uploads/sertifikat/2hoy9NzeoWLv5d5aaAkQ1OkVQfqyFafg1FY0bcjf.png', '2025-04-10 03:45:42', '2025-04-10 03:45:42');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (69, 221, 'juhri', 'uploads/ktp/K4124aUbMdOfIfe9M0hrR5XtKM1NkI9YDdUq0awJ.png', 'uploads/sertifikat/M3Sj2tOtmpH99vGWKj6zBC9hJ0usM6zoEDWcfMSQ.png', '2025-04-10 03:45:42', '2025-04-10 03:45:42');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (70, 222, 'fajar', 'uploads/ktp/43s0SJ41iKctmX0zX4zTAoJANClPYdVmGY2BRfFe.png', 'uploads/sertifikat/OGMqtRIDgrrjFSPu1NHVgyihoHaVQK4Ay6fEBJSr.png', '2025-04-10 03:45:42', '2025-04-14 18:05:19');
INSERT INTO `work_permit_worker_details` (`id`, `work_permit_worker_id`, `nama`, `lampiran_ktp`, `lampiran_sertifikat`, `created_at`, `updated_at`) VALUES (71, 222, 'jaya', 'uploads/ktp/Zd55qc7FtNstxf17Bo9ZYs4r8RMwRVOwQa41ht36.png', 'uploads/sertifikat/pYW2jfVTKNPy8Iq2voO8Z6loy5YZTdKl4HupkCrx.png', '2025-04-14 18:05:19', '2025-04-14 18:05:19');
COMMIT;

-- ----------------------------
-- Table structure for work_permit_workers
-- ----------------------------
DROP TABLE IF EXISTS `work_permit_workers`;
CREATE TABLE `work_permit_workers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_permit_id` int(11) NOT NULL,
  `jabatan` enum('engineer','surveyor','operator_alat_berat','rigger','teknisi_elektrik','mekanik','welder','fitter','tukang_bangunan','hekiper','helper','safety_officer','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `work_permit_id` (`work_permit_id`) USING BTREE,
  CONSTRAINT `work_permit_workers_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_permit_workers
-- ----------------------------
BEGIN;
INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES (171, 12, 'welder', 2, '2025-03-20 00:06:00', '2025-03-20 01:12:35');
INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES (202, 12, 'engineer', 1, '2025-03-20 01:22:16', '2025-03-20 01:27:47');
INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES (219, 26, 'engineer', 2, '2025-04-09 18:34:06', '2025-04-09 18:34:06');
INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES (220, 26, 'teknisi_elektrik', 2, '2025-04-09 18:34:06', '2025-04-09 18:34:06');
INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES (221, 27, 'engineer', 2, '2025-04-10 03:45:42', '2025-04-10 03:45:42');
INSERT INTO `work_permit_workers` (`id`, `work_permit_id`, `jabatan`, `jumlah`, `created_at`, `updated_at`) VALUES (222, 27, 'operator_alat_berat', 2, '2025-04-10 03:45:42', '2025-04-14 18:05:19');
COMMIT;

-- ----------------------------
-- Table structure for work_permits
-- ----------------------------
DROP TABLE IF EXISTS `work_permits`;
CREATE TABLE `work_permits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengawas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pengawas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_struktur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','submitted','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `induction_date` date DEFAULT NULL,
  `last_rejected_by` enum('pengawas','pemilik_area','she_officer','she_manager') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `purchase_order_id` (`purchase_order_id`) USING BTREE,
  KEY `vendor_id` (`vendor_id`) USING BTREE,
  CONSTRAINT `work_permits_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_permits_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_permits
-- ----------------------------
BEGIN;
INSERT INTO `work_permits` (`id`, `purchase_order_id`, `vendor_id`, `telepon_pemohon`, `pengawas`, `telepon_pengawas`, `lampiran_struktur`, `status`, `created_at`, `updated_at`, `induction_date`, `last_rejected_by`) VALUES (12, 1, 2, '089712309621', 'asrul', '089712309443', 'work_permits/XWU0Wrnz08fVybvSSN3dbsf1sX3QxOnTdNvEbUas.png', 'approved', '2025-03-18 20:26:34', '2025-04-09 15:33:40', '2025-03-30', 'she_officer');
INSERT INTO `work_permits` (`id`, `purchase_order_id`, `vendor_id`, `telepon_pemohon`, `pengawas`, `telepon_pengawas`, `lampiran_struktur`, `status`, `created_at`, `updated_at`, `induction_date`, `last_rejected_by`) VALUES (26, 13, 2, '089601992073', 'muhi', '089601992073', 'work_permits/MZuYTpXoEUXgXu1zvsimlCU2uhQxZ4Z0bfy6oJfL.png', 'submitted', '2025-04-09 18:33:26', '2025-04-09 18:35:15', NULL, NULL);
INSERT INTO `work_permits` (`id`, `purchase_order_id`, `vendor_id`, `telepon_pemohon`, `pengawas`, `telepon_pengawas`, `lampiran_struktur`, `status`, `created_at`, `updated_at`, `induction_date`, `last_rejected_by`) VALUES (27, 14, 2, '089601992073', 'budi', '089601992073', 'work_permits/Ul2AcUE4I61QKuO4j8dFZjLLIa4b9bKGdrLHLtxy.png', 'approved', '2025-04-10 03:44:42', '2025-04-14 18:08:17', '2025-04-15', 'she_manager');
COMMIT;

-- ----------------------------
-- Table structure for work_schedule_details
-- ----------------------------
DROP TABLE IF EXISTS `work_schedule_details`;
CREATE TABLE `work_schedule_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_schedule_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_pekerja` int(11) NOT NULL,
  `jam_kerja` int(11) NOT NULL DEFAULT '8',
  `jumlah_jam_kerja_nyata` int(11) GENERATED ALWAYS AS ((`jumlah_pekerja` * `jam_kerja`)) STORED,
  `jumlah_pekerja_lembur` int(11) NOT NULL DEFAULT '0',
  `jam_lembur` int(11) NOT NULL DEFAULT '0',
  `jumlah_jam_lembur` int(11) GENERATED ALWAYS AS ((`jumlah_pekerja_lembur` * `jam_lembur`)) STORED,
  `jumlah_jam_kerja_real` int(11) GENERATED ALWAYS AS ((`jumlah_jam_kerja_nyata` + `jumlah_jam_lembur`)) STORED,
  `cuti` int(11) NOT NULL DEFAULT '0',
  `ijin` int(11) NOT NULL DEFAULT '0',
  `sakit` int(11) NOT NULL DEFAULT '0',
  `alpha` int(11) NOT NULL DEFAULT '0',
  `kehilangan_jam_kerja` int(11) GENERATED ALWAYS AS (((((`cuti` + `ijin`) + `sakit`) + `alpha`) * 8)) STORED,
  `jumlah_total_jam_kerja_aman` int(11) GENERATED ALWAYS AS ((`jumlah_jam_kerja_real` - `kehilangan_jam_kerja`)) STORED,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `work_schedule_id` (`work_schedule_id`) USING BTREE,
  CONSTRAINT `work_schedule_details_ibfk_1` FOREIGN KEY (`work_schedule_id`) REFERENCES `work_schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_schedule_details
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for work_schedules
-- ----------------------------
DROP TABLE IF EXISTS `work_schedules`;
CREATE TABLE `work_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_permit_id` int(11) NOT NULL,
  `periode_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_manager` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_approve_she` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `alasan_reject` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `work_permit_id` (`work_permit_id`) USING BTREE,
  CONSTRAINT `work_schedules_ibfk_1` FOREIGN KEY (`work_permit_id`) REFERENCES `work_permits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of work_schedules
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- View structure for vrolesmenus
-- ----------------------------
DROP VIEW IF EXISTS `vrolesmenus`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vrolesmenus` AS select `menus`.`id` AS `id`,`menus`.`parent_id` AS `parent_id`,`menus`.`sortid` AS `sortid`,`menus`.`displaytext` AS `displaytext`,`menus`.`basedir` AS `basedir`,`menus`.`linkaddress` AS `linkaddress`,`menus`.`is_active` AS `is_active`,`role_menu_route`.`role_id` AS `role_id`,`role_menu_route`.`routename` AS `routename` from (`menus` join `role_menu_route` on((`menus`.`id` = `role_menu_route`.`menu_id`))) where (`menus`.`id` > 1);

SET FOREIGN_KEY_CHECKS = 1;
