-- Vehicle Inspection System Database Export (MySQL Format)
-- Generated: 2025-08-21 08:21:07

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `email_verified_at` timestamp NULL DEFAULT NULL,
        `password` varchar(255) NOT NULL,
        `remember_token` varchar(100) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `users_email_unique` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) DEFAULT NULL,
        `phone` varchar(255) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE `vehicles` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `client_id` bigint(20) UNSIGNED DEFAULT NULL,
        `make` varchar(255) DEFAULT NULL,
        `model` varchar(255) DEFAULT NULL,
        `year` int(11) DEFAULT NULL,
        `vin` varchar(255) DEFAULT NULL,
        `registration` varchar(255) DEFAULT NULL,
        `mileage` int(11) DEFAULT NULL,
        `engine_number` varchar(255) DEFAULT NULL,
        `color` varchar(255) DEFAULT NULL,
        `transmission` varchar(255) DEFAULT NULL,
        `fuel_type` varchar(255) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `vehicles_client_id_foreign` (`client_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `inspections`;
CREATE TABLE `inspections` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
        `inspector_name` varchar(255) DEFAULT NULL,
        `inspection_date` date DEFAULT NULL,
        `status` varchar(255) DEFAULT 'pending',
        `visual_inspection_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`visual_inspection_data`)),
        `notes` text DEFAULT NULL,
        `service_book_available` varchar(255) DEFAULT NULL,
        `service_book_agency_maintained` varchar(255) DEFAULT NULL,
        `service_book_last_service_date` date DEFAULT NULL,
        `service_book_last_service_mileage` int(11) DEFAULT NULL,
        `service_book_notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `inspections_vehicle_id_foreign` (`vehicle_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `inspection_images`;
CREATE TABLE `inspection_images` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `image_type` varchar(255) DEFAULT NULL,
        `image_path` varchar(255) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `inspection_images_inspection_id_foreign` (`inspection_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `migration` varchar(255) NOT NULL,
        `batch` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2025_07_31_112706_create_clients_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2025_07_31_112716_create_vehicles_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2025_07_31_112724_create_inspections_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2025_07_31_112732_create_body_panel_assessments_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2025_07_31_112739_create_inspection_images_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2025_08_05_090751_create_inspection_reports_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2025_08_06_141420_make_pdf_fields_nullable_in_inspection_reports_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2025_08_10_070058_create_assessment_data_table', 5);

SET FOREIGN_KEY_CHECKS=1;
