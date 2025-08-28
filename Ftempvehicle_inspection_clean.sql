-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: vehicle_inspection
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `vehicle_inspection`
--

/*!40000 DROP DATABASE IF EXISTS `vehicle_inspection`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `vehicle_inspection` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `vehicle_inspection`;

--
-- Table structure for table `assessment_data`
--

DROP TABLE IF EXISTS `assessment_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assessment_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment_data`
--

LOCK TABLES `assessment_data` WRITE;
/*!40000 ALTER TABLE `assessment_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `assessment_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `body_panel_assessments`
--

DROP TABLE IF EXISTS `body_panel_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `body_panel_assessments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `panel_name` varchar(255) NOT NULL,
  `condition` enum('good','average','bad') DEFAULT NULL,
  `comment_type` varchar(255) DEFAULT NULL,
  `additional_comment` text DEFAULT NULL,
  `other_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `body_panel_assessments_inspection_id_panel_name_index` (`inspection_id`,`panel_name`),
  CONSTRAINT `body_panel_assessments_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `body_panel_assessments`
--

LOCK TABLES `body_panel_assessments` WRITE;
/*!40000 ALTER TABLE `body_panel_assessments` DISABLE KEYS */;
INSERT INTO `body_panel_assessments` VALUES (146,130,'body_panel_lf_mirror','good',NULL,NULL,NULL,'2025-08-16 15:06:10','2025-08-16 15:06:10'),(148,131,'body_panel_fr_fender','average',NULL,NULL,NULL,'2025-08-17 06:01:32','2025-08-17 06:01:32');
/*!40000 ALTER TABLE `body_panel_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `braking_system`
--

DROP TABLE IF EXISTS `braking_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `braking_system` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `position` varchar(20) NOT NULL,
  `pad_life` varchar(10) DEFAULT NULL,
  `pad_condition` varchar(20) DEFAULT NULL,
  `disc_life` varchar(10) DEFAULT NULL,
  `disc_condition` varchar(20) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `braking_system_inspection_id_index` (`inspection_id`),
  CONSTRAINT `braking_system_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `braking_system`
--

LOCK TABLES `braking_system` WRITE;
/*!40000 ALTER TABLE `braking_system` DISABLE KEYS */;
INSERT INTO `braking_system` VALUES (5,131,'front_left','0.90','average','0.75','bad',NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19');
/*!40000 ALTER TABLE `braking_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'John Doe','123-456-7890','john@example.com',NULL,'2025-08-10 05:39:15','2025-08-10 05:39:15'),(10,'Test Client',NULL,NULL,NULL,'2025-08-11 06:13:35','2025-08-11 06:13:35'),(11,'API Test Client',NULL,NULL,NULL,'2025-08-11 09:30:47','2025-08-11 09:30:47'),(12,'HTTP Test Client',NULL,NULL,NULL,'2025-08-11 09:43:53','2025-08-11 09:43:53'),(13,'Test Client',NULL,'test@example.com',NULL,'2025-08-13 09:05:56','2025-08-13 09:05:56');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine_compartment`
--

DROP TABLE IF EXISTS `engine_compartment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine_compartment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `component_type` varchar(50) NOT NULL,
  `condition` varchar(20) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `engine_compartment_inspection_id_component_type_index` (`inspection_id`,`component_type`),
  CONSTRAINT `engine_compartment_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine_compartment`
--

LOCK TABLES `engine_compartment` WRITE;
/*!40000 ALTER TABLE `engine_compartment` DISABLE KEYS */;
/*!40000 ALTER TABLE `engine_compartment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine_compartment_findings`
--

DROP TABLE IF EXISTS `engine_compartment_findings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine_compartment_findings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `finding_type` varchar(50) NOT NULL,
  `is_checked` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `engine_compartment_findings_inspection_id_finding_type_index` (`inspection_id`,`finding_type`),
  CONSTRAINT `engine_compartment_findings_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine_compartment_findings`
--

LOCK TABLES `engine_compartment_findings` WRITE;
/*!40000 ALTER TABLE `engine_compartment_findings` DISABLE KEYS */;
/*!40000 ALTER TABLE `engine_compartment_findings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspection_images`
--

DROP TABLE IF EXISTS `inspection_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inspection_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `image_type` enum('general','specific_area','diagnostic_pdf','service_booklet','tyres_rims','mechanical_report','engine_compartment','physical_hoist') DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inspection_images_inspection_id_image_type_index` (`inspection_id`,`image_type`),
  CONSTRAINT `inspection_images_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=535 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspection_images`
--

LOCK TABLES `inspection_images` WRITE;
/*!40000 ALTER TABLE `inspection_images` DISABLE KEYS */;
INSERT INTO `inspection_images` VALUES (523,130,'specific_area','body_panel_fr-fender','inspections/130/body_panel/body_panel_fr-fender_1755356770_5089.jpg','fr-fender-1755356762855',NULL,NULL,'2025-08-16 15:06:10','2025-08-16 15:06:10'),(524,130,'specific_area','dash','inspections/130/interior/interior_dash_1755357131_9274.jpg','interior_dash_1755357131_9274.jpg',NULL,NULL,'2025-08-16 15:12:11','2025-08-16 15:12:11'),(525,131,'general','visual_1','inspections/131/general/inspection_131_0_1755410022.jpg','visual_image_1.jpg',NULL,NULL,'2025-08-17 05:53:43','2025-08-17 05:53:43'),(527,131,'diagnostic_pdf','diagnostic_report','inspections/131/diagnostic/diagnostic_131_1755410246.pdf','a-test.pdf',NULL,NULL,'2025-08-17 05:57:26','2025-08-17 05:57:26'),(528,131,'diagnostic_pdf','diagnostic_report','inspections/131/diagnostic/diagnostic_131_1755410486.pdf','a-test.pdf',NULL,NULL,'2025-08-17 06:01:26','2025-08-17 06:01:26'),(529,131,'specific_area','body_panel_fr-fender','inspections/131/body_panel/body_panel_fr-fender_1755410492_9743.jpg','fr-fender-1755410048662',NULL,NULL,'2025-08-17 06:01:32','2025-08-17 06:01:32'),(530,131,'specific_area','dash','inspections/131/interior/interior_dash_1755410508_2107.jpg','interior_dash_1755410508_2107.jpg',NULL,NULL,'2025-08-17 06:01:48','2025-08-17 06:01:48'),(531,131,'service_booklet','service_page_1','inspections/131/service-booklet/service_page_1_1755410535.jpg','service_page_1_1755410535.jpg',NULL,NULL,'2025-08-17 06:02:15','2025-08-17 06:02:15'),(532,131,'tyres_rims','front-left','inspections/131/tyres/tyres_131_front-left_68a1707c58585.jpg',NULL,NULL,NULL,'2025-08-17 06:02:36','2025-08-17 06:02:36'),(533,131,'mechanical_report','final-drive-noise','inspections/131/mechanical/mechanical_131_final-drive-noise_68a170a780009.jpg',NULL,NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(534,131,'mechanical_report','brake-front-left','inspections/131/mechanical/mechanical_131_brake-front-left_68a170a78339d.jpg',NULL,NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19');
/*!40000 ALTER TABLE `inspection_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspection_reports`
--

DROP TABLE IF EXISTS `inspection_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inspection_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_phone` varchar(255) DEFAULT NULL,
  `vehicle_make` varchar(255) NOT NULL,
  `vehicle_model` varchar(255) NOT NULL,
  `vehicle_year` varchar(255) DEFAULT NULL,
  `vin_number` varchar(255) DEFAULT NULL,
  `license_plate` varchar(255) DEFAULT NULL,
  `mileage` varchar(255) DEFAULT NULL,
  `inspection_date` date NOT NULL,
  `inspector_name` varchar(255) DEFAULT NULL,
  `report_number` varchar(255) NOT NULL,
  `pdf_filename` varchar(255) DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `status` enum('draft','completed','sent') NOT NULL DEFAULT 'completed',
  `inspection_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`inspection_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inspection_reports_report_number_unique` (`report_number`),
  KEY `inspection_reports_client_name_index` (`client_name`),
  KEY `inspection_reports_vehicle_make_index` (`vehicle_make`),
  KEY `inspection_reports_vin_number_index` (`vin_number`),
  KEY `inspection_reports_report_number_index` (`report_number`),
  KEY `inspection_reports_inspection_date_index` (`inspection_date`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspection_reports`
--

LOCK TABLES `inspection_reports` WRITE;
/*!40000 ALTER TABLE `inspection_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspection_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspections`
--

DROP TABLE IF EXISTS `inspections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inspections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `vehicle_id` bigint(20) unsigned NOT NULL,
  `inspector_name` varchar(255) NOT NULL,
  `inspector_phone` varchar(255) DEFAULT NULL,
  `inspector_email` varchar(255) DEFAULT NULL,
  `inspection_date` date NOT NULL,
  `diagnostic_report` text DEFAULT NULL,
  `service_comments` text DEFAULT NULL,
  `service_recommendations` text DEFAULT NULL,
  `status` enum('draft','completed','sent') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inspections_client_id_foreign` (`client_id`),
  KEY `inspections_vehicle_id_foreign` (`vehicle_id`),
  CONSTRAINT `inspections_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `inspections_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspections`
--

LOCK TABLES `inspections` WRITE;
/*!40000 ALTER TABLE `inspections` DISABLE KEYS */;
INSERT INTO `inspections` VALUES (130,10,118,'Test Inspector',NULL,NULL,'2025-08-15',NULL,NULL,NULL,'draft','2025-08-16 10:51:03','2025-08-16 15:05:53'),(131,10,119,'George',NULL,NULL,'2025-08-17','This is a report','Test','Test','completed','2025-08-17 05:53:42','2025-08-17 06:02:15');
/*!40000 ALTER TABLE `inspections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interior_assessments`
--

DROP TABLE IF EXISTS `interior_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interior_assessments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `component_name` varchar(255) NOT NULL,
  `condition` enum('good','average','bad') NOT NULL DEFAULT 'good',
  `colour` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `interior_assessments_inspection_id_component_name_unique` (`inspection_id`,`component_name`),
  CONSTRAINT `interior_assessments_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interior_assessments`
--

LOCK TABLES `interior_assessments` WRITE;
/*!40000 ALTER TABLE `interior_assessments` DISABLE KEYS */;
INSERT INTO `interior_assessments` VALUES (178,131,'interior_77','average','Grey',NULL,'2025-08-17 06:01:48','2025-08-17 06:01:48');
/*!40000 ALTER TABLE `interior_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mechanical_reports`
--

DROP TABLE IF EXISTS `mechanical_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mechanical_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `condition` varchar(20) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mechanical_reports_inspection_id_index` (`inspection_id`),
  CONSTRAINT `mechanical_reports_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=797 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mechanical_reports`
--

LOCK TABLES `mechanical_reports` WRITE;
/*!40000 ALTER TABLE `mechanical_reports` DISABLE KEYS */;
INSERT INTO `mechanical_reports` VALUES (763,131,'final_drive_noise','bad','Test','2025-08-17 06:03:19','2025-08-17 06:03:19'),(764,131,'instrument_control',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(765,131,'road_holding',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(766,131,'gearbox_operation',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(767,131,'clutch_operation',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(768,131,'general_steering',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(769,131,'engine_performance',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(770,131,'cooling_fan',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(771,131,'footbrake',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(772,131,'engine_noise',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(773,131,'power_steering',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(774,131,'handbrake',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(775,131,'excess_smoke',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(776,131,'warning_lights',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(777,131,'overheating',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(778,131,'auto_changes',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(779,131,'four_wd',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(780,131,'cruise_control',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(781,131,'airconditioning',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(782,131,'heating',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(783,131,'air_suspension',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(784,131,'electric_windows',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(785,131,'sunroof',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(786,131,'central_locking',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(787,131,'vented_seats',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(788,131,'electronic_seats',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(789,131,'control_arm_noise',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(790,131,'brake_noise',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(791,131,'suspension_noise',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(792,131,'oil_leaks',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(793,131,'brake_front_left',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(794,131,'brake_front_right',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(795,131,'brake_rear_left',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19'),(796,131,'brake_rear_right',NULL,NULL,'2025-08-17 06:03:19','2025-08-17 06:03:19');
/*!40000 ALTER TABLE `mechanical_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_31_112706_create_clients_table',1),(5,'2025_07_31_112716_create_vehicles_table',1),(6,'2025_07_31_112724_create_inspections_table',1),(7,'2025_07_31_112732_create_body_panel_assessments_table',1),(8,'2025_07_31_112739_create_inspection_images_table',1),(9,'2025_08_05_090751_create_inspection_reports_table',1),(10,'2025_08_06_141420_make_pdf_fields_nullable_in_inspection_reports_table',1),(11,'2025_08_10_070058_create_assessment_data_table',1),(12,'2025_08_11_100339_add_missing_vehicle_fields_to_vehicles_table',2),(13,'2025_08_11_142702_add_diagnostic_pdf_to_inspection_images_enum',3),(14,'2025_08_12_123352_create_interior_assessments_table',4),(15,'2025_08_12_165933_create_interior_assessments_table',5),(16,'2025_08_13_102655_create_interior_assessments_table',6),(17,'2025_08_14_095814_add_service_booklet_columns_to_inspections_table',7),(18,'2025_08_14_111513_add_service_booklet_to_image_type_enum',8),(19,'2025_08_14_125116_create_tyres_assessments_table',9),(21,'2025_08_14_144539_create_tyres_assessments_table',10),(22,'2025_08_14_140655_add_tyres_rims_to_image_type_enum',11),(23,'2025_08_14_163126_add_missing_fields_to_tyres_assessments_table',12),(24,'2025_08_15_100142_create_tyres_rims_table',13),(25,'2025_08_15_125145_create_mechanical_reports_table',14),(26,'2025_08_15_131547_add_mechanical_and_tyres_to_image_type_enum',15),(27,'2025_08_15_132012_create_braking_system_table',16),(28,'2025_08_15_153032_create_engine_compartment_table',17),(29,'2025_08_15_153048_create_engine_compartment_findings_table',18),(30,'2025_08_15_153108_add_engine_compartment_to_image_type_enum',19),(31,'2025_08_15_174541_create_physical_hoist_inspections_table',20),(32,'2025_08_16_090831_add_physical_hoist_to_image_type_enum',21);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `physical_hoist_inspections`
--

DROP TABLE IF EXISTS `physical_hoist_inspections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `physical_hoist_inspections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `section` varchar(50) NOT NULL,
  `component_name` varchar(100) NOT NULL,
  `primary_condition` enum('Good','Average','Bad','N/A') DEFAULT NULL,
  `secondary_condition` enum('Good','Average','Bad','N/A') DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `physical_hoist_inspections_inspection_id_index` (`inspection_id`),
  KEY `physical_hoist_inspections_section_index` (`section`),
  CONSTRAINT `physical_hoist_inspections_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `physical_hoist_inspections`
--

LOCK TABLES `physical_hoist_inspections` WRITE;
/*!40000 ALTER TABLE `physical_hoist_inspections` DISABLE KEYS */;
/*!40000 ALTER TABLE `physical_hoist_inspections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5QCXpUGoTpjQYk3MFYPpJXEsEOQSRH6rTldWcShY',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2p4RmthamdNS3VSb2RsN2dYM2dNOHZ6UXNsRzFrYmwyVlB4M1hxQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnNwZWN0aW9uL3Zpc3VhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755677513),('pZoLdXDC70Lrq9SgTiXdLEKgl0U727hclZuar91Y',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1g3YWNYeFlNalVlcXprbWJKSFRUczZqbTg5TnRoOHllSml4VTFoMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnNwZWN0aW9uL2VuZ2luZS1jb21wYXJ0bWVudCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755410601),('VdDT3A10nLM2Miil0mxDLkQ0lQlqtBAiOl8KwNxJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3dvWHIwZUx3M1RtOU1jVEZJV3c2d3dlaTY0M0M0Y3VUVVM0T1M2SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRzLzEzMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755410640),('vUd6JgUiGXjxO955u2n8XMhTrKQ1qEWpFs5gRq1h',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVRPYXJpdU9VUzhXUHRPS0tvTGJBSHB2ekNCYWl4eWtIZW9LYzZhTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnNwZWN0aW9uL3Zpc3VhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755694426),('wK2WoZYyRBm9vwUaDu3xGdV40iP5cpZ1Mx3gyy6o',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoidk4ydGFRcnBaRlkxVFRCYklOaU5QU1ViN2pCbGt3cjc3Znl1cWJoSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1755410599);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tyres_assessments`
--

DROP TABLE IF EXISTS `tyres_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tyres_assessments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `component_name` varchar(255) NOT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `tread_depth` varchar(255) DEFAULT NULL,
  `damages` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tyres_assessments_inspection_id_component_name_index` (`inspection_id`,`component_name`),
  CONSTRAINT `tyres_assessments_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tyres_assessments`
--

LOCK TABLES `tyres_assessments` WRITE;
/*!40000 ALTER TABLE `tyres_assessments` DISABLE KEYS */;
/*!40000 ALTER TABLE `tyres_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tyres_rims`
--

DROP TABLE IF EXISTS `tyres_rims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tyres_rims` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) unsigned NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `size` varchar(100) DEFAULT NULL,
  `manufacture` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `tread_depth` varchar(50) DEFAULT NULL,
  `damages` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tyres_rims_inspection_id_index` (`inspection_id`),
  CONSTRAINT `tyres_rims_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tyres_rims`
--

LOCK TABLES `tyres_rims` WRITE;
/*!40000 ALTER TABLE `tyres_rims` DISABLE KEYS */;
INSERT INTO `tyres_rims` VALUES (111,131,'front_left','Test','Test','Test','2mm','puncture','2025-08-17 06:02:36','2025-08-17 06:02:36'),(112,131,'front_right',NULL,NULL,NULL,NULL,NULL,'2025-08-17 06:02:36','2025-08-17 06:02:36'),(113,131,'rear_left',NULL,NULL,NULL,NULL,NULL,'2025-08-17 06:02:36','2025-08-17 06:02:36'),(114,131,'rear_right',NULL,NULL,NULL,NULL,NULL,'2025-08-17 06:02:36','2025-08-17 06:02:36'),(115,131,'spare',NULL,NULL,NULL,NULL,NULL,'2025-08-17 06:02:36','2025-08-17 06:02:36');
/*!40000 ALTER TABLE `tyres_rims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-08-14 12:22:58','$2y$12$JytevQq658AqI8i6B6RXXuLwxeLhrDwYMfhejKMMiMN4G7uP8ryWi','jtYGwZSnb7','2025-08-14 12:22:59','2025-08-14 12:22:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vin` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `doors` varchar(255) DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `engine_number` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicles_vin_unique` (`vin`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'TEST123456789','Toyota','Camry','Sedan',NULL,NULL,NULL,'Automatic','ENG123456','ABC 123 GP',2020,50000,'2025-08-10 05:39:15','2025-08-10 05:39:15'),(3,'TEST123','Honda','Civic','passenger vehicle',NULL,NULL,NULL,'Automatic','ENG123','ABC123',2020,50000,'2025-08-11 06:13:35','2025-08-11 06:13:35'),(5,'TEST-VIN-6899b8df6ab1c','Toyota','Camry','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,2020,50000,'2025-08-11 07:33:19','2025-08-11 07:33:19'),(6,'147852369','Ford','GT','passenger vehicle',NULL,NULL,NULL,'Manual','123654789','321445',1957,12121,'2025-08-11 07:38:48','2025-08-11 07:38:48'),(7,'TEST-VIN-6899c1a702610','Toyota','Camry','SUV','Red','4','Petrol','Manual','ENG123456','ABC123',2020,50000,'2025-08-11 08:10:47','2025-08-11 08:10:47'),(8,'3218','VW','Beetle','passenger vehicle','jug','5 Door','Diesel','Automatic','1235','3232',1900,65987,'2025-08-11 08:20:11','2025-08-11 08:22:18'),(9,'TEST-VIN-6899c570c4b3d','Toyota','Camry','sedan','blue','4','petrol',NULL,'ENG123',NULL,2020,50000,'2025-08-11 08:26:56','2025-08-11 08:26:56'),(10,'12','q','q','passenger vehicle','lk','3 Door','LPG','Manual','11','11',1989,888,'2025-08-11 08:51:51','2025-08-11 08:51:51'),(11,'TEST-VIN-6899cc00bee90','Honda','Civic','sedan','red','4','petrol',NULL,'ENG999',NULL,2023,15000,'2025-08-11 08:54:56','2025-08-11 08:54:56'),(12,'20','Test 20','Test 20','van','Test 20','3 Door','Diesel','Automatic','20','20',2020,20,'2025-08-11 09:12:16','2025-08-11 09:12:16'),(13,'TEST-VIN-6899d10e30b06','Toyota','Camry','sedan',NULL,NULL,NULL,NULL,NULL,NULL,2023,5000,'2025-08-11 09:16:30','2025-08-11 09:16:30'),(14,'APITEST123456789','Toyota','Corolla','passenger vehicle','Red','4','petrol','manual','ENG123456','ABC123GP',2022,50000,'2025-08-11 09:30:47','2025-08-11 09:30:47'),(15,'123654','123654','123654','passenger vehicle','123654','2 Door','LPG','Manual','123654','123654',2025,123654,'2025-08-11 09:33:51','2025-08-15 11:48:17'),(16,'HTTPTEST123456789','Honda','Civic','passenger vehicle','Blue','4','petrol','automatic','ENG789123','XYZ789GP',2021,75000,'2025-08-11 09:43:53','2025-08-11 09:43:53'),(17,'qwert534626636521','jaguar','XJ^','passenger vehicle','fred','3 Door','Diesel','Automatic','32667yhg','iuuw667',1976,12345,'2025-08-11 09:52:50','2025-08-11 09:52:50'),(19,'TEST-VIN-6899e7bd2821b','Toyota','Test','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 10:53:17','2025-08-11 10:53:17'),(20,'TEST-VIN-6899e82bdeb22','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 10:55:07','2025-08-11 10:55:07'),(21,'TEST-VIN-6899eafd747d2','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:07:09','2025-08-11 11:07:09'),(22,'TEST-VIN-6899ec351742b','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:12:21','2025-08-11 11:12:21'),(23,'TEST-VIN-6899ec5a108d8','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:12:58','2025-08-11 11:12:58'),(24,'TEST-VIN-6899eca5d91d3','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:14:13','2025-08-11 11:14:13'),(26,'TEST-VIN-6899ed44d7085','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:16:52','2025-08-11 11:16:52'),(27,'TEST-VIN-6899ed56529bd','masd','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:17:10','2025-08-11 11:17:10'),(28,'TEST-VIN-6899ed74b8091','Mazda','bt250','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:17:40','2025-08-11 11:17:40'),(29,'w','w','w','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:18:07','2025-08-11 11:18:07'),(30,'z','z','z','passenger vehicle',NULL,NULL,NULL,NULL,'z',NULL,NULL,NULL,'2025-08-11 11:18:36','2025-08-11 11:18:36'),(31,'a','a','a','passenger vehicle','a','3 Door','Petrol','Manual','a','a',2000,20000,'2025-08-11 11:19:26','2025-08-11 11:20:39'),(35,'TEST-VIN-6899f12cae5c2','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:33:32','2025-08-11 11:33:32'),(36,'TEST-VIN-6899f13bbee4b','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 11:33:47','2025-08-11 11:33:47'),(42,'TEST-VIN-6899fdf6160a6','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 12:28:06','2025-08-11 12:28:06'),(43,'0123654789kakshdg','Mazda','Bt250','truck','haze','4 Door','Diesel','Manual','2124akjgdyh','qefefd22',2002,198000,'2025-08-11 12:29:35','2025-08-11 12:29:35'),(44,'TEST-VIN-689a000c2b464','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-11 14:37:00','2025-08-11 14:37:00'),(45,'TEST-VIN-689ae5098d730','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 06:54:01','2025-08-12 06:54:01'),(46,'TEST-VIN-689ae8c7377e0','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 07:09:59','2025-08-12 07:09:59'),(47,'TEST-VIN-689ae9adb08ef','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 07:13:49','2025-08-12 07:13:49'),(48,'TEST-VIN-689aeeccee940','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 07:35:40','2025-08-12 07:35:40'),(49,'TEST-VIN-689b14675eeaa','Test Manufacturer','Test Model','truck',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 10:16:07','2025-08-12 10:16:07'),(50,'TEST-VIN-689b15de27b8b','ASas','Test Model','commercial vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 10:22:22','2025-08-12 10:22:22'),(51,'TEST-VIN-689b183e22cb1','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 10:32:30','2025-08-12 10:32:30'),(52,'TEST-VIN-689b1943d4e4f','hat','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 10:36:51','2025-08-12 10:36:51'),(53,'TEST-VIN-689b20b14304b','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 11:08:33','2025-08-12 11:08:33'),(54,'TEST-VIN-689b22e7c513b','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 11:17:59','2025-08-12 11:17:59'),(55,'TEST-VIN-689b32538ccd9','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 12:23:47','2025-08-12 12:23:47'),(56,'TEST-VIN-689b34297e020','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 12:31:37','2025-08-12 12:31:37'),(57,'TEST-VIN-689b3505620c1','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-12 12:35:17','2025-08-12 12:35:17'),(58,'01928374657483920','Mazda','BT250','passenger vehicle','green','5 Door','Diesel','Automatic','09iuuy76','adfas',1987,67890,'2025-08-12 12:36:34','2025-08-12 12:36:34'),(59,'TEST-VIN-689b54cc74eed','Test Manufacturer','Test Model','passenger vehicle',NULL,'2 Door','Petrol','Manual',NULL,NULL,NULL,NULL,'2025-08-12 14:50:52','2025-08-12 14:50:52'),(60,'Test-13','Test-13','Test-13','passenger vehicle','Test-13','2 Door','Petrol','Manual','Test-13','Test-13',2003,1236954,'2025-08-13 06:17:41','2025-08-13 06:17:41'),(61,'TEST-VIN-689c428f33798','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 07:45:19','2025-08-13 07:45:19'),(62,'ANNIE','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,'ANNIE','ANNIE',NULL,NULL,'2025-08-13 08:20:58','2025-08-13 08:20:58'),(63,'TEST-VIN-689c5174306f8','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 08:48:52','2025-08-13 08:48:52'),(64,'TEST1755076345','Test Manufacturer','Test Model','passenger vehicle','Test Colour','4','petrol','automatic',NULL,NULL,2025,50000,'2025-08-13 09:12:25','2025-08-13 09:12:25'),(65,'TEST-VIN-689c59bc19859','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 09:24:12','2025-08-13 09:24:12'),(66,'TEST-VIN-689c5d7dd42f0','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 09:40:13','2025-08-13 09:40:13'),(67,'TEST-VIN-689c5e1342efb','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 09:42:43','2025-08-13 09:42:43'),(68,'Test-4','Test-4','Test-4','passenger vehicle','Test-4','2 Door','Electric','CVT','Test-4','Test-4',1957,12000,'2025-08-13 10:15:14','2025-08-13 10:58:10'),(69,'TEST-VIN-689c6bc9947cc','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 10:41:13','2025-08-13 10:41:13'),(70,'TEST-VIN-689c7e868d0b4','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 12:01:10','2025-08-13 12:01:10'),(71,'test5','test5','test5','passenger vehicle','test5','2 Door','Petrol','Manual','test5','test5',NULL,222,'2025-08-13 12:03:35','2025-08-13 12:03:35'),(72,'Yappy','Yappy','Yappy','van','Yappy','4 Door','Petrol','Manual','Yappy','Yappy',2022,1236,'2025-08-13 12:18:53','2025-08-13 12:18:53'),(73,'TEST-VIN-689c8b0062afe','daddy cool','daddy cool','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 12:54:24','2025-08-13 12:54:24'),(74,'last test today','last test today','last test today','motorcycle','last test today',NULL,'Electric',NULL,'last test today','last test today',1994,11111,'2025-08-13 13:14:06','2025-08-13 13:14:06'),(75,'pillitjies','pillitjies','pillitjies','passenger vehicle',NULL,NULL,NULL,NULL,'pillitjies',NULL,NULL,NULL,'2025-08-13 14:07:33','2025-08-13 14:07:33'),(76,'TEST-VIN-689c9f19eaa90','Test Manufacturer','Test Model','commercial vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 14:20:09','2025-08-13 14:20:09'),(77,'TEST-VIN-689ca1959245b','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 14:30:45','2025-08-13 14:30:45'),(78,'TEST-VIN-689ca4592ae3b','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 14:42:33','2025-08-13 14:42:33'),(79,'TEST-VIN-689ca523ca19f','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-13 14:45:55','2025-08-13 14:45:55'),(80,'George Test 14','George Test 14','George Test 14','passenger vehicle','George Test 14','5 Door','Petrol','Manual','George Test 14','George Test 14',1920,1000,'2025-08-14 05:49:12','2025-08-14 05:49:12'),(81,'TEST-VIN-689d7aee080da','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 05:58:06','2025-08-14 05:58:06'),(82,'TEST-VIN-689d95e44ccf1','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 07:53:08','2025-08-14 07:53:08'),(83,'TEST-VIN-689da7b487f77','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 09:09:08','2025-08-14 09:09:08'),(84,'TEST-VIN-689db4b8856b2','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 10:04:40','2025-08-14 10:04:40'),(85,'Test-1213','Test-1213','Test-1213','passenger vehicle','Test-1213','4 Door','Petrol','Manual','Test-1213','Test-1213',2021,2222,'2025-08-14 10:23:34','2025-08-14 10:23:34'),(86,'testare dog','testare dog','testare dog','passenger vehicle','testare dog','2 Door','Petrol','Manual','testare dog','testare dog',1925,1111,'2025-08-14 10:31:18','2025-08-14 10:31:18'),(87,'TEST-VIN-689dc5883dffb','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 11:16:24','2025-08-14 11:16:24'),(88,'TEST-VIN-689dc72bcfb71','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 11:23:23','2025-08-14 11:23:23'),(89,'TEST-VIN-689dc7949d5ab','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 11:25:08','2025-08-14 11:25:08'),(90,'TEST-VIN-689dc83116399','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 11:27:45','2025-08-14 11:27:45'),(91,'harry','harry','harry','passenger vehicle','harry',NULL,NULL,NULL,'harry','harry',NULL,NULL,'2025-08-14 11:33:25','2025-08-14 11:33:25'),(92,'TEST-VIN-689dd212ec16c','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 12:09:54','2025-08-14 12:09:54'),(93,'TEST-VIN-689dd863251e6','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 12:36:51','2025-08-14 12:36:51'),(94,'TEST-VIN-689dd888a7448','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 12:37:28','2025-08-14 12:37:28'),(95,'TEST-VIN-689ddce62a715','Mananna','Mananna','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 12:56:06','2025-08-14 12:56:06'),(96,'TEST-VIN-689de11922892','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 13:14:01','2025-08-14 13:14:01'),(97,'rest','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 13:30:27','2025-08-14 13:30:27'),(98,'asdfa','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 13:50:04','2025-08-14 13:50:04'),(99,'TEST-VIN-689deb251f9bd','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 13:56:53','2025-08-14 13:56:53'),(100,'TEST-VIN-689def9926816','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-14 14:15:53','2025-08-14 14:15:53'),(101,'150820251','150820251','150820251','passenger vehicle','150820251','4 Door','Diesel','Manual','150820251','150820251',2025,150820251,'2025-08-15 06:44:32','2025-08-15 06:44:32'),(102,'TEST-VIN-689ee7e715792','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 07:55:19','2025-08-15 07:55:19'),(103,'TEST-VIN-689ee9f8090de','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 08:04:08','2025-08-15 08:04:08'),(104,'testing123','testing123','testing123','passenger vehicle','testing123','5 Door','LPG','Manual','testing123','testing123',1956,123,'2025-08-15 08:38:54','2025-08-15 08:38:54'),(105,'TEST-VIN-689ef3397786a','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 08:43:37','2025-08-15 08:43:37'),(106,'TEST-VIN-689ef78a13aeb','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 09:02:02','2025-08-15 09:02:02'),(107,'TEST-VIN-689ef796237e2','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 09:02:14','2025-08-15 09:02:14'),(108,'2015','2015','2015','passenger vehicle','2015','3 Door','Petrol','Automatic','v2015','2015',2015,2015,'2025-08-15 09:10:28','2025-08-15 09:10:28'),(109,'TEST-VIN-689f38cb232b4','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 13:40:27','2025-08-15 13:40:27'),(110,'TEST-VIN-689f4633762e9','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,'Before beer',NULL,NULL,NULL,'2025-08-15 14:37:39','2025-08-15 14:37:39'),(111,'TEST-VIN-689f502601668','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 15:20:06','2025-08-15 15:20:06'),(112,'TEST-VIN-689f5135bce36','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-15 15:24:37','2025-08-15 15:24:37'),(113,'TEST-VIN-68a04ee17886d','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-16 09:26:57','2025-08-16 09:26:57'),(114,'TEST-VIN-68a04ee2c3a2c','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-16 09:26:58','2025-08-16 09:26:58'),(115,'TEST-VIN-68a057ecbaf97','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-16 10:05:32','2025-08-16 10:05:32'),(116,'TEST-VIN-68a05c8b10ea8','Test Manufacturer','Test Model','passenger vehicle','sss',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-16 10:25:15','2025-08-16 10:25:15'),(117,'TEST-VIN-68a05dab23550','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-16 10:30:03','2025-08-16 10:30:03'),(118,'TEST-VIN-68a06297dd099','Test Manufacturer','Test Model','passenger vehicle',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-16 10:51:03','2025-08-16 10:51:03'),(119,'123654789trey','Ferrari','296 GTS','van','Red','2 Door','Petrol','CVT','123654789trey','GB343GP',2024,12000,'2025-08-17 05:53:42','2025-08-17 05:57:26');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'vehicle_inspection'
--

--
-- Dumping routines for database 'vehicle_inspection'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-21 11:58:18
