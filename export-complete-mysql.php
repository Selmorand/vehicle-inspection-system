<?php
// Complete MySQL export with ALL tables from migrations

$output_file = 'staging-database-complete-mysql.sql';
$sqlite = new PDO('sqlite:database/database.sqlite');

$sql = "-- Vehicle Inspection System Complete Database Export\n";
$sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// Get ALL tables from SQLite
$tables_query = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
$all_tables = $tables_query->fetchAll(PDO::FETCH_COLUMN);

echo "Found tables: " . implode(', ', $all_tables) . "\n\n";

// Define proper MySQL structure for each table
$mysql_structures = [
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'password_reset_tokens' => "CREATE TABLE `password_reset_tokens` (
        `email` varchar(255) NOT NULL,
        `token` varchar(255) NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'sessions' => "CREATE TABLE `sessions` (
        `id` varchar(255) NOT NULL,
        `user_id` bigint(20) UNSIGNED DEFAULT NULL,
        `ip_address` varchar(45) DEFAULT NULL,
        `user_agent` text DEFAULT NULL,
        `payload` longtext NOT NULL,
        `last_activity` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `sessions_user_id_index` (`user_id`),
        KEY `sessions_last_activity_index` (`last_activity`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'cache' => "CREATE TABLE `cache` (
        `key` varchar(255) NOT NULL,
        `value` mediumtext NOT NULL,
        `expiration` int(11) NOT NULL,
        PRIMARY KEY (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'cache_locks' => "CREATE TABLE `cache_locks` (
        `key` varchar(255) NOT NULL,
        `owner` varchar(255) NOT NULL,
        `expiration` int(11) NOT NULL,
        PRIMARY KEY (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'jobs' => "CREATE TABLE `jobs` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `queue` varchar(255) NOT NULL,
        `payload` longtext NOT NULL,
        `attempts` tinyint(3) UNSIGNED NOT NULL,
        `reserved_at` int(10) UNSIGNED DEFAULT NULL,
        `available_at` int(10) UNSIGNED NOT NULL,
        `created_at` int(10) UNSIGNED NOT NULL,
        PRIMARY KEY (`id`),
        KEY `jobs_queue_index` (`queue`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'job_batches' => "CREATE TABLE `job_batches` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'failed_jobs' => "CREATE TABLE `failed_jobs` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `uuid` varchar(255) NOT NULL,
        `connection` text NOT NULL,
        `queue` text NOT NULL,
        `payload` longtext NOT NULL,
        `exception` longtext NOT NULL,
        `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'clients' => "CREATE TABLE `clients` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) DEFAULT NULL,
        `phone` varchar(255) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

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
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'inspections' => "CREATE TABLE `inspections` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
        `inspector_name` varchar(255) DEFAULT NULL,
        `inspection_date` date DEFAULT NULL,
        `status` varchar(255) DEFAULT 'pending',
        `visual_inspection_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `service_book_available` varchar(255) DEFAULT NULL,
        `service_book_agency_maintained` varchar(255) DEFAULT NULL,
        `service_book_last_service_date` date DEFAULT NULL,
        `service_book_last_service_mileage` int(11) DEFAULT NULL,
        `service_book_notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'body_panel_assessments' => "CREATE TABLE `body_panel_assessments` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `panel_name` varchar(255) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'inspection_images' => "CREATE TABLE `inspection_images` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `image_type` varchar(255) DEFAULT NULL,
        `image_path` varchar(255) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'inspection_reports' => "CREATE TABLE `inspection_reports` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `report_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
        `pdf_path` varchar(255) DEFAULT NULL,
        `generated_at` timestamp NULL DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'interior_assessments' => "CREATE TABLE `interior_assessments` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `component` varchar(255) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'tyres_rims' => "CREATE TABLE `tyres_rims` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `position` varchar(255) DEFAULT NULL,
        `brand` varchar(255) DEFAULT NULL,
        `size` varchar(255) DEFAULT NULL,
        `thread_depth` decimal(5,2) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `rim_condition` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'mechanical_reports' => "CREATE TABLE `mechanical_reports` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `component` varchar(255) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'braking_system' => "CREATE TABLE `braking_system` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `component` varchar(255) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `measurement` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'engine_compartment' => "CREATE TABLE `engine_compartment` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `overall_condition` varchar(255) DEFAULT NULL,
        `oil_level` varchar(255) DEFAULT NULL,
        `coolant_level` varchar(255) DEFAULT NULL,
        `brake_fluid_level` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'engine_compartment_findings' => "CREATE TABLE `engine_compartment_findings` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `engine_compartment_id` bigint(20) UNSIGNED DEFAULT NULL,
        `component` varchar(255) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'physical_hoist_inspections' => "CREATE TABLE `physical_hoist_inspections` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
        `component` varchar(255) DEFAULT NULL,
        `condition` varchar(255) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'migrations' => "CREATE TABLE `migrations` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `migration` varchar(255) NOT NULL,
        `batch` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];

$table_count = 0;
$record_count = 0;

foreach ($all_tables as $table_name) {
    echo "Processing table: $table_name\n";
    
    // Use defined structure or skip if not defined
    if (isset($mysql_structures[$table_name])) {
        $sql .= "DROP TABLE IF EXISTS `$table_name`;\n";
        $sql .= $mysql_structures[$table_name] . ";\n\n";
        $table_count++;
        
        // Export data
        try {
            $data = $sqlite->query("SELECT * FROM $table_name");
            if ($data) {
                while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                    $columns = array_keys($row);
                    $values = array_map(function($v) {
                        if ($v === null) return 'NULL';
                        if (is_numeric($v)) return $v;
                        // Escape single quotes and backslashes
                        return "'" . str_replace(["\\", "'"], ["\\\\", "\\'"], $v) . "'";
                    }, array_values($row));
                    
                    $sql .= "INSERT INTO `$table_name` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
                    $record_count++;
                }
                $sql .= "\n";
            }
        } catch (Exception $e) {
            echo "  Warning: Could not export data - " . $e->getMessage() . "\n";
        }
    } else {
        echo "  Skipping (no MySQL structure defined)\n";
    }
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents($output_file, $sql);
echo "\n✅ Export complete!\n";
echo "Tables exported: $table_count\n";
echo "Records exported: $record_count\n";
echo "File: $output_file\n";
echo "Size: " . number_format(filesize($output_file) / 1024, 2) . " KB\n";
?>