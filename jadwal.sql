-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table jadwal.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `program_study_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_program_study_id_foreign` (`program_study_id`),
  CONSTRAINT `classes_program_study_id_foreign` FOREIGN KEY (`program_study_id`) REFERENCES `program_studies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.classes: ~4 rows (approximately)
INSERT INTO `classes` (`id`, `class_name`, `code`, `description`, `program_study_id`, `created_at`, `updated_at`) VALUES
	(1, 'Kelas A', 'A1', 'Class A number 1', 1, '2024-01-30 08:34:24', '2024-01-30 08:34:24'),
	(2, 'Kelas B', 'B1', 'Class B number 1', 1, '2024-01-30 08:35:17', '2024-01-30 08:35:17'),
	(4, 'test clas', '1', 'asdasd', 1, '2024-05-19 03:59:34', '2024-05-19 03:59:34'),
	(5, 'CLASS D', '12', 'aaaa', 2, '2024-07-24 16:14:40', '2024-07-24 16:14:40');

-- Dumping structure for table jadwal.contents
CREATE TABLE IF NOT EXISTS `contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.contents: ~0 rows (approximately)
INSERT INTO `contents` (`id`, `name`, `code`, `description`, `url`, `other`, `created_at`, `updated_at`) VALUES
	(1, 'title', 'item1', 'UPN Veteran', NULL, NULL, '2024-01-31 06:05:19', '2024-01-31 06:05:19');

-- Dumping structure for table jadwal.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table jadwal.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.migrations: ~26 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(4, '2024_01_21_102827_create_roles_table', 1),
	(5, '2024_01_21_103000_create_program_studies_table', 1),
	(6, '2024_01_21_103238_create_classes_table', 1),
	(7, '2024_01_21_103835_create_users_table', 1),
	(8, '2024_01_21_104119_create_subjects_table', 1),
	(9, '2024_01_21_104321_create_rooms_table', 1),
	(10, '2024_01_21_104423_create_schedules_table', 1),
	(11, '2024_01_21_104423_create_contents_table', 2),
	(12, '2024_01_21_104423_create_contents_table copy', 3),
	(13, '2024_01_31_104423_create_contents_table', 4),
	(14, '2024_01_31_104424_create_contents_table', 5),
	(15, '2024_01_21_104423_create_menus_table', 6),
	(16, '2024_01_31_104423_create_menus_table', 7),
	(17, '2024_01_31_104423_create_menuroles_table', 8),
	(18, '2024_01_31_104424_create_menuroles_table', 9),
	(19, '2024_01_31_104425_create_menuroles_table', 10),
	(20, '2024_01_31_104426_create_menuroles_table', 11),
	(21, '2024_02_03_212900_create_systables_table', 12),
	(22, '2024_02_03_212901_create_systables_table', 13),
	(23, '2024_02_03_213359_create_sys_columns_table', 13),
	(24, '2024_02_03_214127_create_sys_action_table', 13),
	(25, '2024_02_03_215811_create_sys_loguser_table', 13),
	(26, '2024_05_11_192004_create_sys_content_table', 14);

-- Dumping structure for table jadwal.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table jadwal.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table jadwal.program_studies
CREATE TABLE IF NOT EXISTS `program_studies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prodi_name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.program_studies: ~3 rows (approximately)
INSERT INTO `program_studies` (`id`, `prodi_name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Informatikasss', 'Lorem ipsum dolor sit amet', '2024-05-18 10:56:55', '2024-05-14 12:03:09'),
	(2, 'Sistem Informasi', 'Lorem ipsum dolor sit amet', NULL, NULL),
	(10, 'Ilmu Komputers', 'Pendidikan Ilmu Komputer', '2024-02-15 09:14:06', '2024-03-16 02:52:24'),
	(15, 'Test', 'AAABB', '2024-08-02 04:11:19', '2024-08-02 04:12:26');

-- Dumping structure for table jadwal.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.roles: ~4 rows (approximately)
INSERT INTO `roles` (`id`, `role_name`, `level`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'super', 1, NULL, NULL, NULL),
	(2, 'admin', 2, NULL, NULL, NULL),
	(3, 'dosen', 2, NULL, NULL, NULL),
	(4, 'client', 3, NULL, NULL, NULL);

-- Dumping structure for table jadwal.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.rooms: ~15 rows (approximately)
INSERT INTO `rooms` (`id`, `room_name`, `description`, `created_at`, `updated_at`, `is_active`) VALUES
	(1, 'ROOM 1', 'RUANGAN LT 111', '2024-08-01 00:57:24', '2024-08-02 02:54:35', 0),
	(2, 'ROOM 2', 'RUANGAN LT 2', '2024-08-01 00:57:24', '2024-08-01 00:57:25', 1),
	(3, 'ROOM 3', 'RUANGAN LT 3', '2024-08-01 00:58:02', '2024-08-01 00:58:03', 1),
	(10, 'LAB', 'LABORAT', '2024-05-18 02:12:06', '2024-05-18 02:12:06', 1),
	(11, 'AULA', 'AULA UTAMA', '2024-05-18 02:12:06', '2024-05-18 02:12:06', 0),
	(13, 'RUANGAN BASEMENT', 'Ruangan Tambahan', '2024-08-01 15:44:22', '2024-08-01 15:44:22', 0),
	(14, 'tes', 'tes', '2024-08-02 02:25:44', '2024-08-02 02:25:44', 0),
	(15, 'aa', 'aa', '2024-08-02 02:27:47', '2024-08-02 02:27:47', 1),
	(16, 'aa', 'aa', '2024-08-02 02:28:13', '2024-08-02 02:28:13', 1),
	(17, 'bb', 'aa', '2024-08-02 02:31:11', '2024-08-02 02:31:11', 1),
	(18, 'tes', 'tes', '2024-08-02 02:31:42', '2024-08-02 02:31:42', 0),
	(19, 'bb', 'aa', '2024-08-02 02:38:44', '2024-08-02 02:38:44', 0),
	(20, 'bb', 'aa', '2024-08-02 02:39:03', '2024-08-02 02:39:03', 0),
	(21, 'bb', 'aa', '2024-08-02 02:39:16', '2024-08-02 02:39:16', 0),
	(22, 'bb', 'aa', '2024-08-02 02:42:42', '2024-08-02 02:42:42', 1);

-- Dumping structure for table jadwal.schedules
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_class_id_foreign` (`class_id`),
  KEY `schedules_room_id_foreign` (`room_id`),
  KEY `schedules_subject_id_foreign` (`subject_id`),
  KEY `schedules_user_id_foreign` (`user_id`),
  CONSTRAINT `FK_schedules_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.schedules: ~2 rows (approximately)
INSERT INTO `schedules` (`id`, `start_date`, `end_date`, `status`, `class_id`, `room_id`, `subject_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(2, '2024-07-24', '2024-07-24', '5', 4, 1, 2, 15, '2024-07-24 01:47:43', '2024-07-31 18:05:29'),
	(3, '2024-07-24', '2024-07-24', '1', 2, 10, 1, 3, '2024-07-24 01:47:43', '2024-07-24 01:47:44'),
	(6, '2024-08-01', '2024-08-03', '', 2, 2, 4, 3, '2024-07-31 18:34:35', '2024-07-31 18:34:35');

-- Dumping structure for table jadwal.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `program_study_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_program_study_id_foreign` (`program_study_id`),
  CONSTRAINT `subjects_program_study_id_foreign` FOREIGN KEY (`program_study_id`) REFERENCES `program_studies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.subjects: ~4 rows (approximately)
INSERT INTO `subjects` (`id`, `code`, `subject_name`, `sks`, `semester`, `program_study_id`, `created_at`, `updated_at`) VALUES
	(1, 'S1', 'Pengenalan Informatika', 2, 1, 1, '2024-01-30 09:09:03', '2024-01-30 09:09:03'),
	(2, 'S1', 'Algoritma Pemrograman', 2, 1, 1, '2024-01-30 09:09:03', '2024-01-30 09:09:03'),
	(3, 'S1', 'Pemrograman Dasar', 3, 1, 1, '2024-01-30 09:09:03', '2024-01-30 09:09:03'),
	(4, 'S1', 'Pemrograman Web', 2, 2, 1, '2024-01-30 09:09:03', '2024-01-30 09:09:03');

-- Dumping structure for table jadwal.sys_action
CREATE TABLE IF NOT EXISTS `sys_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `table_id` bigint(20) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_action_table_id_foreign` (`table_id`),
  CONSTRAINT `sys_action_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `sys_table` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.sys_action: ~0 rows (approximately)

-- Dumping structure for table jadwal.sys_column
CREATE TABLE IF NOT EXISTS `sys_column` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `custom_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_column_table_id_foreign` (`table_id`),
  CONSTRAINT `sys_column_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `sys_table` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.sys_column: ~0 rows (approximately)

-- Dumping structure for table jadwal.sys_content
CREATE TABLE IF NOT EXISTS `sys_content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.sys_content: ~4 rows (approximately)
INSERT INTO `sys_content` (`id`, `name`, `value`, `description`, `url`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'title', 'APLIKASI E-JADWAL FAKULTAS SAINS & TEKNOLOGI', 'aaaa', 0, 1, NULL, '2024-05-17 18:13:44'),
	(2, 'title_2', ' E-Jadwal', '', 0, 0, NULL, NULL),
	(3, 'title_3', 'Fakultas Sains dan Teknologi', 'dasd', 0, 1, '2024-05-17 18:15:21', '2024-05-17 18:15:21'),
	(4, 'logo', '/assets/images/upy.png', 'dasd', 0, 1, '2024-05-17 18:15:21', '2024-05-17 18:15:21');

-- Dumping structure for table jadwal.sys_loguser
CREATE TABLE IF NOT EXISTS `sys_loguser` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `role_id` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.sys_loguser: ~0 rows (approximately)

-- Dumping structure for table jadwal.sys_menu
CREATE TABLE IF NOT EXISTS `sys_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `route` varchar(255) NOT NULL,
  `activeRoute` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.sys_menu: ~17 rows (approximately)
INSERT INTO `sys_menu` (`id`, `name`, `code`, `parent`, `icon`, `route`, `activeRoute`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Dashboard', 'D1', '0', 'bx-home', 'dashboard', NULL, 1, '2024-05-15 04:19:01', '2024-05-15 04:19:01'),
	(2, 'Prodi', 'A1', '0', 'bx-buildings', '', '', 1, '2024-01-31 06:13:00', '2024-01-31 06:13:00'),
	(3, 'Sys Menu', 'A1', '0', 'bx-grid', 'menu.table', 'menu.menus', 1, '2024-01-31 06:13:00', '2024-01-31 06:13:00'),
	(4, 'Program Studi', 'A1', '2', NULL, 'programstudies.table', '', 1, '2024-01-31 06:13:00', '2024-01-31 06:13:00'),
	(5, 'Akademik', 'A1', '0', 'bx-calendar', '', '', 1, '2024-01-31 06:13:00', '2024-01-31 06:13:00'),
	(6, 'Dosen', 'A1', '2', NULL, 'lecturer.table', 'lecturer.lecturers', 1, '2024-01-31 06:13:00', '2024-05-15 07:52:59'),
	(7, 'Mata Kuliah', 'A1', '2', NULL, 'subject.table', '', 1, '2024-01-31 06:13:00', '2024-08-02 02:59:36'),
	(8, 'Ruangan', 'A1', '2', NULL, 'room.table', 'room.rooms', 1, '2024-01-31 06:13:00', '2024-08-01 16:08:48'),
	(9, 'Jadwal', 'A1', '5', NULL, 'schedule.table', 'room.rooms', 1, '2024-01-31 06:13:00', '2024-07-23 16:46:23'),
	(95, 'Sys User', 'U', '0', 'bx-user', 'user.index', NULL, 1, '2024-05-15 08:23:41', '2024-05-17 13:26:04'),
	(96, 'List Menu', 'M1', '3', NULL, 'menu.table', 'menu.menus', 1, '2024-05-17 13:19:12', '2024-05-17 13:19:12'),
	(97, 'Transaction Menu', 'M2', '3', NULL, 'txmenu.table', 'menu.menus', 1, '2024-05-17 13:20:34', '2024-05-17 13:20:34'),
	(98, 'List Role', 'U1', '95', NULL, 'role.table', NULL, 1, '2024-05-17 13:49:16', '2024-05-17 14:18:05'),
	(99, 'List User', 'U2', '95', NULL, 'user.table', NULL, 1, '2024-05-17 13:50:09', '2024-05-17 13:50:09'),
	(105, 'Sys Content', 'SC', '0', 'bx-food-menu', '', '', 1, '2024-05-17 16:41:27', '2024-05-17 16:41:27'),
	(106, 'List Contents', 'SC1', '105', NULL, 'content.table', NULL, 1, '2024-05-17 16:42:14', '2024-05-17 17:51:07'),
	(107, 'Class', 'M3', '2', NULL, 'class.table', NULL, 1, '2024-05-19 03:11:09', '2024-05-19 03:11:09');

-- Dumping structure for table jadwal.sys_table
CREATE TABLE IF NOT EXISTS `sys_table` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.sys_table: ~0 rows (approximately)

-- Dumping structure for table jadwal.tx_menu_roles
CREATE TABLE IF NOT EXISTS `tx_menu_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tx_menu_roles_menu_id_foreign` (`menu_id`),
  KEY `tx_menu_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `tx_menu_roles_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `sys_menu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tx_menu_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.tx_menu_roles: ~24 rows (approximately)
INSERT INTO `tx_menu_roles` (`id`, `menu_id`, `role_id`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, '1', NULL, NULL),
	(2, 95, 1, NULL, '1', NULL, NULL),
	(3, 2, 1, NULL, '1', '2024-05-19 10:23:18', '2024-05-19 10:23:18'),
	(4, 96, 1, NULL, '1', NULL, NULL),
	(5, 97, 1, NULL, '1', NULL, NULL),
	(6, 3, 1, NULL, '1', NULL, NULL),
	(7, 1, 2, 'tes', '1', '2024-07-23 09:04:16', '2024-07-23 09:04:16'),
	(30, 2, 2, NULL, '1', '2024-07-23 09:06:46', '2024-07-23 09:06:46'),
	(31, 6, 2, NULL, '1', '2024-07-23 09:07:01', '2024-07-23 09:07:01'),
	(32, 4, 2, NULL, '1', '2024-07-23 09:08:23', '2024-07-23 09:08:23'),
	(33, 107, 2, NULL, '1', '2024-07-23 09:08:53', '2024-07-23 09:08:53'),
	(34, 95, 2, NULL, '1', '2024-07-23 09:09:43', '2024-07-23 09:09:43'),
	(35, 98, 2, NULL, '1', '2024-07-23 09:09:57', '2024-07-23 09:09:57'),
	(36, 99, 2, NULL, '1', '2024-07-23 09:10:19', '2024-07-23 09:10:19'),
	(38, 2, 3, 'tess dosen', '1', '2024-07-23 13:06:56', '2024-07-23 13:06:56'),
	(39, 4, 3, 'tess dosen', '1', '2024-07-23 13:06:56', '2024-07-23 13:06:56'),
	(40, 6, 3, 'tess dosen', '1', '2024-07-23 13:06:56', '2024-07-23 13:06:56'),
	(41, 107, 3, 'tess dosen', '1', '2024-07-23 13:06:56', '2024-07-23 13:06:56'),
	(42, 5, 1, 'super', '1', '2024-07-23 14:34:01', '2024-07-23 14:34:01'),
	(43, 7, 1, 'super', '1', '2024-07-23 14:34:01', '2024-07-23 14:34:01'),
	(44, 8, 1, 'super', '1', '2024-07-23 14:34:01', '2024-07-23 14:34:01'),
	(45, 9, 1, 'super', '1', '2024-07-23 14:34:01', '2024-07-23 14:34:01'),
	(46, 105, 1, 'superr', '1', '2024-07-23 14:35:04', '2024-07-23 14:35:04'),
	(47, 106, 1, 'superr', '1', '2024-07-23 14:35:04', '2024-07-23 14:35:04');

-- Dumping structure for table jadwal.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nis` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `program_study_id` bigint(20) unsigned DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_program_study_id_foreign` (`program_study_id`),
  CONSTRAINT `users_program_study_id_foreign` FOREIGN KEY (`program_study_id`) REFERENCES `program_studies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table jadwal.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `nis`, `status`, `role_id`, `program_study_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'super@gmail.com', NULL, '$2y$12$evFqLSYJNmbhqLJVkkgZUuXoUfrcI6nVruoJxeFhwfg55gPs/3b.u', NULL, NULL, 1, NULL, NULL, NULL, NULL),
	(2, 'Mas Admin2', 'admin@gmail.com', NULL, '$2y$12$evFqLSYJNmbhqLJVkkgZUuXoUfrcI6nVruoJxeFhwfg55gPs/3b.u', NULL, NULL, 2, NULL, NULL, NULL, NULL),
	(3, 'Puji Astuti, S.Kom., M.Koms', 'dosen@gmail.com', NULL, '$2y$12$NF14q/g37KZoTMVssfk20Ow6xaaZ1vkb/HHTK/pdrpWVJUn9s7aGC', '321890', '1', 3, 1, NULL, NULL, '2024-05-17 19:36:06'),
	(15, 'test4', 'test4@gmail.com', NULL, '$2y$12$HOmpqMGtWGW19WNaZfTbL.La5vXOeFf471PrCy/nDrUA/526dLLa.', '123', '1', 1, 1, NULL, '2024-05-17 12:50:24', '2024-05-17 12:50:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
