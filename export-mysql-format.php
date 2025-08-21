<?php
// Export database in proper MySQL format

$output_file = 'staging-database-mysql.sql';

// Connect to SQLite database
$sqlite = new PDO('sqlite:database/database.sqlite');

$sql = "-- Vehicle Inspection System Database Export (MySQL Format)\n";
$sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
$sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$sql .= "SET time_zone = \"+00:00\";\n\n";

// Manually define MySQL table structures based on Laravel migrations
$tables = [
    'users' => "CREATE TABLE `users` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'clients' => "CREATE TABLE `clients` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) DEFAULT NULL,
        `phone` varchar(255) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'vehicles' => "CREATE TABLE `vehicles` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'inspections' => "CREATE TABLE `inspections` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'inspection_images' => "CREATE TABLE `inspection_images` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `image_type` varchar(255) DEFAULT NULL,
        `image_path` varchar(255) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `inspection_images_inspection_id_foreign` (`inspection_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'migrations' => "CREATE TABLE `migrations` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `migration` varchar(255) NOT NULL,
        `batch` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

// Create tables
foreach ($tables as $table_name => $create_statement) {
    $sql .= "DROP TABLE IF EXISTS `$table_name`;\n";
    $sql .= $create_statement . ";\n\n";
    
    // Export data
    try {
        $data = $sqlite->query("SELECT * FROM $table_name");
        if ($data) {
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                $columns = array_keys($row);
                $values = array_map(function($v) {
                    if ($v === null) return 'NULL';
                    if (is_numeric($v)) return $v;
                    return "'" . str_replace("'", "\\'", $v) . "'";
                }, array_values($row));
                
                $sql .= "INSERT INTO `$table_name` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }
    } catch (Exception $e) {
        echo "Warning: Could not export data from $table_name\n";
    }
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents($output_file, $sql);
echo "Database exported to $output_file (MySQL format)\n";
echo "File size: " . number_format(filesize($output_file) / 1024, 2) . " KB\n";
?>