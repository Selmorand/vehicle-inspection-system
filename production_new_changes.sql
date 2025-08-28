-- ========================================
-- Production Database Update Script
-- Vehicle Inspection System - August 2024
-- 
-- This script adds ONLY the new changes
-- All existing data is preserved
-- ========================================

-- Step 1: Add caption column to inspection_images table (if not exists)
SET @dbname = DATABASE();
SET @tablename = 'inspection_images';
SET @columnname = 'caption';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 'Column caption already exists in inspection_images'",
  "ALTER TABLE inspection_images ADD COLUMN caption VARCHAR(255) NULL AFTER area_name"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Step 2: Create road_test table (if not exists)
CREATE TABLE IF NOT EXISTS `road_test` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `speed` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `road_test_inspection_id_foreign` (`inspection_id`),
  CONSTRAINT `road_test_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Step 3: Create engine_verification table (if not exists)
CREATE TABLE IF NOT EXISTS `engine_verification` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `engine_number` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `engine_verification_inspection_id_foreign` (`inspection_id`),
  CONSTRAINT `engine_verification_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Step 4: Add migration records for tables that already exist
-- This prevents "table already exists" errors
INSERT IGNORE INTO migrations (migration, batch) VALUES 
('2025_08_23_092013_add_caption_to_inspection_images_table', (SELECT MAX(batch) + 1 FROM (SELECT batch FROM migrations) AS m)),
('2025_08_23_105217_create_engine_verification_table', (SELECT MAX(batch) + 1 FROM (SELECT batch FROM migrations) AS m)),
('2025_08_23_125303_create_road_test_table', (SELECT MAX(batch) + 1 FROM (SELECT batch FROM migrations) AS m));

-- Step 5: Verify changes
SELECT 'Database updates complete!' as Status;

-- Show what was added
SELECT 'New Tables:' as 'Changes Applied';
SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME IN ('road_test', 'engine_verification');

SELECT 'New Columns:' as '';
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'inspection_images' 
AND COLUMN_NAME = 'caption';