-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for avrs
CREATE DATABASE IF NOT EXISTS `avrs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `avrs`;

-- Dumping structure for table avrs.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.admins: ~2 rows (approximately)
INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'superadmin@gmail.com', '$2y$12$cN6Oqxo4rdMjKM7TDN04EOSy3zFdqAnS9zbWqdtidQltivZrLWZc2', NULL, '2025-05-06 18:35:27', '2025-05-06 18:35:27'),
	(3, 'Afiq', 'afiq@gmail.com', '$2y$12$LUjzTudFZxGGOFVXtxjv9elqGc5phmz8mxs.58n4YqRn8AmS0eF0S', NULL, '2025-05-26 08:13:43', '2025-06-10 02:19:40');

-- Dumping structure for table avrs.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table avrs.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.migrations: ~14 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2025_04_06_072633_create_admins_table', 1),
	(7, '2025_05_01_071352_create_rfids_table', 2),
	(8, '2025_05_01_072000_create_visitors_table', 2),
	(9, '2025_05_01_074124_modify_id_in_visitors_table', 2),
	(11, '2025_05_01_074536_modify_visitors_id_column', 3),
	(13, '2025_05_01_073500_create_visits_table', 4),
	(14, '2025_05_01_074625_modify_visitor_id_in_visits_table', 4),
	(15, '2025_05_04_072448_add_valid_period_to_visitors_table', 5),
	(17, '2025_05_27_205237_add_type_to_rfids_table', 6);

-- Dumping structure for table avrs.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.password_resets: ~0 rows (approximately)

-- Dumping structure for table avrs.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table avrs.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table avrs.rfids
CREATE TABLE IF NOT EXISTS `rfids` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rfid_string` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `type` enum('reusable','permanent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reusable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.rfids: ~3 rows (approximately)
INSERT INTO `rfids` (`id`, `rfid_string`, `status`, `type`, `created_at`, `updated_at`) VALUES
	(1, '23bd505', 'inactive', 'reusable', NULL, '2025-05-21 06:11:03'),
	(2, '2975f93', 'inactive', 'reusable', NULL, '2025-05-12 14:59:14'),
	(3, '166bf93', 'inactive', 'reusable', NULL, '2025-05-29 07:08:10');

-- Dumping structure for table avrs.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Sofea Balqis', 'sofea@gmail.com', NULL, '$2y$12$HIEZE7pkvE./0aQWabK4hOXBdHzAzoSbkMuDufkvBHm2DVI7ptsiK', NULL, '2025-05-01 01:06:52', '2025-05-01 01:06:52'),
	(2, 'Kiran', 'kiran@gmail.com', NULL, '$2y$12$yGil81qdC0eRNSHRAP6Hk.7x1Af65ZPnfiLvtdZ.03yQkwlEl1nCC', NULL, '2025-05-13 19:00:58', '2025-05-13 19:00:58');

-- Dumping structure for table avrs.visitors
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ic_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_printed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitor_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_plate` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfid_id` bigint unsigned NOT NULL,
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitors_rfid_id_foreign` (`rfid_id`),
  CONSTRAINT `visitors_rfid_id_foreign` FOREIGN KEY (`rfid_id`) REFERENCES `rfids` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.visitors: ~4 rows (approximately)
INSERT INTO `visitors` (`id`, `ic_number`, `name_printed`, `address_1`, `visitor_type`, `vehicle_plate`, `house_number`, `rfid_id`, `valid_from`, `valid_until`, `created_at`, `updated_at`) VALUES
	(1, '021114101284', 'SOFEA BALQIS', 'NO 18A, KAMPUNG PULAU KERAMAT, MUKIM LESUNG, POKOK SENA, KEDAH 06400', 'occasional', 'WJW1952', 'H01', 2, '2025-05-04 08:36:00', '2025-05-05 15:59:00', '2025-05-04 00:37:09', '2025-05-04 00:37:09'),
	(2, '021114101284', 'SOFEA BALQIS', 'NO 18A, KAMPUNG PULAU KERAMAT, MUKIM LESUNG, POKOK SENA, KEDAH 06400', 'occasional', 'WJW1952', 'H05', 1, '2025-05-04 17:15:00', '2025-05-10 15:59:00', '2025-05-04 09:14:55', '2025-05-04 09:14:55'),
	(3, '030607070636', 'NUR LIYANA SYAMIMI', '830 MK 3, PENGKALAN TAMBANG, PERMATANG PASIR, PERMATANG PAUH, PULAU PINANG 13500', 'frequent', 'PNG123', 'H10', 3, '2025-05-07 06:24:00', '2025-05-28 00:22:00', '2025-05-07 06:24:05', '2025-05-07 06:24:05'),
	(4, '021114101284', 'SOFEA BALQIS', 'NO 18A, KAMPUNG PULAU KERAMAT, MUKIM LESUNG, POKOK SENA, KEDAH 06400', 'frequent', 'QWT123', 'H12', 1, '2025-05-12 15:57:14', '2025-05-20 09:56:00', '2025-05-12 15:57:14', '2025-05-18 15:57:14');

-- Dumping structure for table avrs.visits
CREATE TABLE IF NOT EXISTS `visits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `visitor_id` bigint unsigned NOT NULL,
  `check_in` timestamp NULL DEFAULT NULL,
  `check_out` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_visitor_id_foreign` (`visitor_id`),
  CONSTRAINT `visits_visitor_id_foreign` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.visits: ~56 rows (approximately)
INSERT INTO `visits` (`id`, `visitor_id`, `check_in`, `check_out`, `created_at`, `updated_at`) VALUES
	(1, 1, '2025-05-04 09:07:21', '2025-05-04 09:07:22', '2025-05-04 09:07:21', '2025-05-04 09:07:22'),
	(2, 1, '2025-05-04 09:07:23', '2025-05-04 09:09:15', '2025-05-04 09:07:23', '2025-05-04 09:09:15'),
	(3, 2, '2025-05-04 09:15:19', '2025-05-04 09:15:21', '2025-05-04 09:15:19', '2025-05-04 09:15:21'),
	(4, 2, '2025-05-04 09:15:34', '2025-05-04 09:17:29', '2025-05-04 09:15:34', '2025-05-04 09:17:29'),
	(5, 2, '2025-05-04 09:17:45', '2025-05-04 09:17:54', '2025-05-04 09:17:45', '2025-05-04 09:17:54'),
	(6, 2, '2025-05-04 18:09:23', '2025-05-04 18:09:29', '2025-05-04 18:09:23', '2025-05-04 18:09:29'),
	(7, 2, '2025-05-06 15:23:30', '2025-05-06 15:25:27', '2025-05-06 15:23:30', '2025-05-06 15:25:27'),
	(8, 2, '2025-05-06 15:25:30', '2025-05-06 15:25:31', '2025-05-06 15:25:30', '2025-05-06 15:25:31'),
	(9, 2, '2025-05-06 15:26:39', '2025-05-06 15:28:59', '2025-05-06 15:26:39', '2025-05-06 15:28:59'),
	(10, 2, '2025-05-06 15:29:03', '2025-05-07 06:33:29', '2025-05-06 15:29:03', '2025-05-07 06:33:29'),
	(11, 1, '2025-05-07 06:33:02', '2025-05-07 06:33:41', '2025-05-07 06:33:02', '2025-05-07 06:33:41'),
	(12, 1, '2025-05-07 06:33:45', '2025-05-07 06:35:08', '2025-05-07 06:33:45', '2025-05-07 06:35:08'),
	(13, 1, '2025-05-07 06:35:12', '2025-05-12 14:59:39', '2025-05-07 06:35:12', '2025-05-12 14:59:39'),
	(14, 3, '2025-05-07 06:36:06', '2025-05-07 07:40:55', '2025-05-07 06:36:06', '2025-05-07 07:40:55'),
	(15, 3, '2025-05-07 07:44:44', '2025-05-12 14:59:36', '2025-05-07 07:44:44', '2025-05-12 14:59:36'),
	(16, 2, '2025-05-12 16:42:29', '2025-05-12 17:08:17', '2025-05-12 16:42:29', '2025-05-12 17:08:17'),
	(17, 2, '2025-05-12 16:44:00', '2025-05-12 17:08:28', '2025-05-12 16:44:00', '2025-05-12 17:08:28'),
	(21, 4, '2025-05-12 17:27:04', '2025-05-12 17:56:16', '2025-05-12 17:27:04', '2025-05-12 17:56:16'),
	(22, 4, '2025-05-12 18:12:45', '2025-05-12 18:12:50', '2025-05-12 18:12:45', '2025-05-12 18:12:50'),
	(23, 4, '2025-05-12 18:13:12', '2025-05-12 18:13:31', '2025-05-12 18:13:12', '2025-05-12 18:13:31'),
	(24, 4, '2025-05-12 18:15:12', '2025-05-12 18:44:36', '2025-05-12 18:15:12', '2025-05-12 18:44:36'),
	(25, 4, '2025-05-12 18:46:20', '2025-05-12 18:55:04', '2025-05-12 18:46:20', '2025-05-12 18:55:04'),
	(26, 4, '2025-05-12 18:55:10', '2025-05-12 18:56:03', '2025-05-12 18:55:10', '2025-05-12 18:56:03'),
	(27, 4, '2025-05-12 18:57:45', '2025-05-12 19:05:17', '2025-05-12 18:57:45', '2025-05-12 19:05:17'),
	(37, 4, '2025-05-13 15:08:46', '2025-05-13 15:10:22', '2025-05-13 15:08:46', '2025-05-13 15:10:22'),
	(38, 4, '2025-05-13 15:10:23', '2025-05-13 15:10:24', '2025-05-13 15:10:23', '2025-05-13 15:10:24'),
	(39, 4, '2025-05-13 15:10:25', '2025-05-13 15:10:26', '2025-05-13 15:10:25', '2025-05-13 15:10:26'),
	(40, 4, '2025-05-13 15:10:28', '2025-05-13 15:10:29', '2025-05-13 15:10:28', '2025-05-13 15:10:29'),
	(41, 4, '2025-05-13 15:10:31', '2025-05-13 15:10:32', '2025-05-13 15:10:31', '2025-05-13 15:10:32'),
	(42, 4, '2025-05-13 15:10:33', '2025-05-13 15:16:00', '2025-05-13 15:10:33', '2025-05-13 15:16:00'),
	(43, 4, '2025-05-13 15:16:22', '2025-05-17 07:33:00', '2025-05-13 15:16:22', '2025-05-17 07:33:00'),
	(52, 4, '2025-05-17 07:46:29', '2025-05-17 07:52:29', '2025-05-17 07:46:29', '2025-05-17 07:52:29'),
	(53, 4, '2025-05-17 07:52:43', '2025-05-17 08:03:05', '2025-05-17 07:52:43', '2025-05-17 08:03:05'),
	(54, 4, '2025-05-17 08:38:41', '2025-05-17 08:41:47', '2025-05-17 08:38:41', '2025-05-17 08:41:47'),
	(55, 4, '2025-05-17 08:54:29', '2025-05-17 08:54:33', '2025-05-17 08:54:29', '2025-05-17 08:54:33'),
	(56, 4, '2025-05-17 09:05:02', '2025-05-17 09:10:27', '2025-05-17 09:05:02', '2025-05-17 09:10:27'),
	(57, 4, '2025-05-17 09:11:41', '2025-05-17 09:22:43', '2025-05-17 09:11:41', '2025-05-17 09:22:43'),
	(58, 4, '2025-05-19 14:42:23', '2025-05-19 14:50:56', '2025-05-19 14:42:23', '2025-05-19 14:50:56'),
	(59, 4, '2025-05-19 16:05:03', '2025-05-19 16:10:16', '2025-05-19 16:05:03', '2025-05-19 16:10:16'),
	(60, 4, '2025-05-19 16:11:18', '2025-05-19 16:19:11', '2025-05-19 16:11:18', '2025-05-19 16:19:11'),
	(61, 3, '2025-05-20 01:05:25', '2025-05-16 02:14:25', '2025-05-21 18:43:25', '2025-05-21 18:43:25'),
	(62, 3, '2025-05-20 01:42:25', '2025-05-20 02:10:25', '2025-05-21 18:43:25', '2025-05-21 18:43:25'),
	(63, 3, '2025-05-18 01:41:25', '2025-05-17 02:06:25', '2025-05-21 18:43:25', '2025-05-21 18:43:25'),
	(64, 1, '2025-05-16 01:21:25', '2025-05-18 01:43:25', '2025-05-21 18:43:25', '2025-05-21 18:43:25'),
	(65, 4, '2025-05-16 01:40:25', '2025-05-17 02:07:25', '2025-05-21 18:43:25', '2025-05-21 18:43:25'),
	(66, 1, '2025-05-18 05:01:40', '2025-05-19 06:53:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(67, 1, '2025-05-16 04:51:40', '2025-05-17 06:26:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(68, 3, '2025-05-17 05:41:40', '2025-05-18 07:35:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(69, 1, '2025-05-18 05:27:40', '2025-05-19 06:14:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(70, 4, '2025-05-19 04:44:40', '2025-05-20 05:56:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(71, 3, '2025-05-16 05:22:40', '2025-05-17 06:13:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(72, 1, '2025-05-17 04:57:40', '2025-05-16 06:34:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(73, 2, '2025-05-21 04:47:40', '2025-05-16 06:55:40', '2025-05-21 18:43:40', '2025-05-21 18:43:40'),
	(74, 3, '2025-05-27 13:35:20', '2025-05-29 07:08:10', '2025-05-27 13:35:20', '2025-05-29 07:08:10'),
	(75, 3, '2025-05-27 13:36:33', '2025-06-09 16:53:38', '2025-05-27 13:36:33', '2025-06-09 16:53:38'),
	(76, 3, '2025-06-09 16:58:15', NULL, '2025-06-09 16:58:15', '2025-06-09 16:58:15');

-- Dumping structure for table avrs.websockets_statistics_entries
CREATE TABLE IF NOT EXISTS `websockets_statistics_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int NOT NULL,
  `websocket_message_count` int NOT NULL,
  `api_message_count` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table avrs.websockets_statistics_entries: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
