<?php
/**
 * Production Migration Fix Script
 * 
 * This script safely syncs migration records with existing database tables
 * Run this if you get "table already exists" errors
 * 
 * Usage: php fix_production_migrations.php
 */

echo "========================================\n";
echo "  Production Migration Fix Script\n";
echo "========================================\n\n";

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Checking database connection...\n";

try {
    DB::connection()->getPdo();
    echo "✓ Database connected successfully\n\n";
} catch (\Exception $e) {
    die("✗ Could not connect to the database. Please check your configuration.\n");
}

// Get all existing tables
$tables = array_map('current', DB::select('SHOW TABLES'));
echo "Found " . count($tables) . " existing tables\n\n";

// Get existing migration records
$existingMigrations = DB::table('migrations')->pluck('migration')->toArray();
echo "Found " . count($existingMigrations) . " migration records\n\n";

// Define all migrations that should exist
$expectedMigrations = [
    // Core Laravel migrations
    '2014_10_12_000000_create_users_table' => 'users',
    '2014_10_12_100000_create_password_reset_tokens_table' => 'password_reset_tokens',
    '2019_08_19_000000_create_failed_jobs_table' => 'failed_jobs',
    '2019_12_14_000001_create_personal_access_tokens_table' => 'personal_access_tokens',
    
    // Inspection system migrations
    '2025_06_10_082355_create_inspections_table' => 'inspections',
    '2025_06_20_091139_create_visual_inspections_table' => 'visual_inspections',
    '2025_06_22_134042_create_body_panel_assessments_table' => 'body_panel_assessments',
    '2025_07_12_093241_create_inspection_images_table' => 'inspection_images',
    '2025_08_05_141239_create_interior_assessments_table' => 'interior_assessments',
    '2025_08_06_104542_create_service_booklets_table' => 'service_booklets',
    '2025_08_06_105103_create_tyres_rims_assessments_table' => 'tyres_rims_assessments',
    '2025_08_06_140803_create_mechanical_reports_table' => 'mechanical_reports',
    '2025_08_06_163149_create_braking_systems_table' => 'braking_systems',
    '2025_08_07_094417_create_engine_compartments_table' => 'engine_compartments',
    '2025_08_07_131302_create_engine_compartment_components_table' => 'engine_compartment_components',
    '2025_08_13_093020_create_engine_compartment_findings_table' => 'engine_compartment_findings',
    '2025_08_13_120417_create_interior_assessments_table' => 'interior_assessments',
    '2025_08_15_174541_create_physical_hoist_inspections_table' => 'physical_hoist_inspections',
    '2025_08_16_090831_add_physical_hoist_to_image_type_enum' => null, // Modifies existing table
    
    // New migrations from recent changes
    '2025_08_23_092013_add_caption_to_inspection_images_table' => null, // Modifies existing table
    '2025_08_23_105217_create_engine_verification_table' => 'engine_verification',
    '2025_08_23_125303_create_road_test_table' => 'road_test',
];

echo "========================================\n";
echo "  Analyzing Migrations\n";
echo "========================================\n\n";

$toAdd = [];
$toRun = [];
$alreadyRun = [];

foreach ($expectedMigrations as $migration => $tableName) {
    if (in_array($migration, $existingMigrations)) {
        $alreadyRun[] = $migration;
    } else {
        if ($tableName === null) {
            // This is a modification migration, should be run
            $toRun[] = $migration;
        } else if (in_array($tableName, $tables)) {
            // Table exists but migration not recorded
            $toAdd[] = $migration;
        } else {
            // Table doesn't exist, migration should run normally
            $toRun[] = $migration;
        }
    }
}

// Display status
if (count($alreadyRun) > 0) {
    echo "✓ Already recorded (" . count($alreadyRun) . " migrations)\n";
}

if (count($toAdd) > 0) {
    echo "\n⚠ Tables exist but migrations not recorded:\n";
    foreach ($toAdd as $migration) {
        echo "  - $migration\n";
    }
}

if (count($toRun) > 0) {
    echo "\n→ Migrations to run normally:\n";
    foreach ($toRun as $migration) {
        echo "  - $migration\n";
    }
}

// Ask for confirmation to fix
if (count($toAdd) > 0) {
    echo "\n========================================\n";
    echo "Do you want to mark existing tables as migrated? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    
    if (trim($line) === 'y' || trim($line) === 'Y') {
        $batch = DB::table('migrations')->max('batch') + 1;
        
        foreach ($toAdd as $migration) {
            DB::table('migrations')->insert([
                'migration' => $migration,
                'batch' => $batch
            ]);
            echo "✓ Added: $migration\n";
        }
        
        echo "\n✓ Migration records updated successfully!\n";
        echo "\nYou can now run: php artisan migrate\n";
    } else {
        echo "\nNo changes made.\n";
    }
} else {
    echo "\n✓ No fixes needed! You can run: php artisan migrate\n";
}

echo "\n========================================\n";
echo "  Script Complete\n";
echo "========================================\n";