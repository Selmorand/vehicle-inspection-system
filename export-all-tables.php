<?php
// Export all database tables to SQL for staging import

$database = 'vehicle_inspection';
$output_file = 'staging-database-complete.sql';

// Get all migration files to determine table creation order
$migrations = [
    'users',
    'password_reset_tokens',
    'sessions',
    'cache',
    'cache_locks',
    'jobs',
    'job_batches',
    'failed_jobs',
    'clients',
    'vehicles', 
    'inspections',
    'body_panel_assessments',
    'inspection_images',
    'inspection_reports',
    'interior_assessments',
    'tyres_rims',
    'mechanical_reports',
    'braking_system',
    'engine_compartment',
    'engine_compartment_findings',
    'physical_hoist_inspections',
    'migrations'
];

$sql = "-- Vehicle Inspection System Database Export\n";
$sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// Connect to database
$pdo = new PDO('sqlite:database/database.sqlite');

foreach ($migrations as $table) {
    echo "Exporting table: $table\n";
    
    // Get CREATE TABLE statement
    $create = $pdo->query("SELECT sql FROM sqlite_master WHERE type='table' AND name='$table'")->fetch();
    if ($create) {
        // Convert SQLite syntax to MySQL
        $mysql_create = str_replace(
            ['integer', 'datetime', 'blob'],
            ['INT', 'DATETIME', 'LONGBLOB'],
            $create['sql']
        );
        $sql .= "DROP TABLE IF EXISTS `$table`;\n";
        $sql .= $mysql_create . ";\n\n";
        
        // Export data
        $data = $pdo->query("SELECT * FROM $table");
        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
            $columns = array_keys($row);
            $values = array_map(function($v) use ($pdo) {
                return $v === null ? 'NULL' : $pdo->quote($v);
            }, array_values($row));
            
            $sql .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
        }
        $sql .= "\n";
    }
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents($output_file, $sql);
echo "Database exported to $output_file\n";
echo "File size: " . number_format(filesize($output_file) / 1024, 2) . " KB\n";
?>