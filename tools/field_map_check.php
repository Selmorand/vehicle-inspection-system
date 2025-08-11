<?php
/**
 * Field Mapping Diagnostic Tool
 * Validates form -> controller -> database -> view field consistency
 */

$expectedFields = [
    'engine_number', 'colour', 'doors', 'fuel_type', 'vehicle_type'
];

echo "[DIAGNOSTIC] Vehicle Inspection Field Mapping Check\n";
echo str_repeat("=", 55) . "\n\n";

$errors = 0;
$basePath = __DIR__ . '/..';

// Check Form Fields
echo "[FORM] Checking Form Fields...\n";
$formFile = $basePath . '/resources/views/visual-inspection.blade.php';
if (file_exists($formFile)) {
    $formContent = file_get_contents($formFile);
    foreach ($expectedFields as $field) {
        if (strpos($formContent, 'name="' . $field . '"') !== false || 
            strpos($formContent, "name='" . $field . "'") !== false) {
            echo "  [OK] $field: Found in form\n";
        } else {
            echo "  [ERROR] $field: Missing from form\n";
            $errors++;
        }
    }
} else {
    echo "  [ERROR] Form file not found\n";
    $errors++;
}
echo "\n";

// Check Controller Validation
echo "[CONTROLLER] Checking Validation Rules...\n";
$controllerFile = $basePath . '/app/Http/Controllers/InspectionController.php';
if (file_exists($controllerFile)) {
    $controllerContent = file_get_contents($controllerFile);
    foreach ($expectedFields as $field) {
        if (strpos($controllerContent, "'" . $field . "'") !== false || 
            strpos($controllerContent, '"' . $field . '"') !== false) {
            echo "  [OK] $field: Found in validation rules\n";
        } else {
            echo "  [ERROR] $field: Missing from validation rules\n";
            $errors++;
        }
    }
} else {
    echo "  [ERROR] Controller file not found\n";
    $errors++;
}
echo "\n";

// Check Database Schema
echo "[DATABASE] Checking Schema...\n";
try {
    // Try to get actual database columns
    $output = shell_exec('cd ' . $basePath . ' && php artisan tinker --execute="echo json_encode(\\Illuminate\\Support\\Facades\\Schema::getColumnListing(\'vehicles\'));" 2>/dev/null');
    if ($output) {
        $columns = json_decode(trim($output), true);
        if (is_array($columns)) {
            foreach ($expectedFields as $field) {
                if (in_array($field, $columns)) {
                    echo "  [OK] $field: Found in vehicles table\n";
                } else {
                    echo "  [ERROR] $field: Missing from vehicles table\n";
                    $errors++;
                }
            }
        } else {
            throw new Exception("Could not parse column listing");
        }
    } else {
        throw new Exception("No output from artisan command");
    }
} catch (Exception $e) {
    // Fallback to migration file search
    $migrationsDir = $basePath . '/database/migrations';
    if (is_dir($migrationsDir)) {
        echo "  [WARN] Using migration files as fallback (database not accessible)\n";
        $migrationFiles = glob($migrationsDir . '/*_*_table.php');
        foreach ($expectedFields as $field) {
            $found = false;
            foreach ($migrationFiles as $file) {
                $migrationContent = file_get_contents($file);
                if ((strpos($migrationContent, 'vehicles') !== false || 
                     strpos($migrationContent, 'inspections') !== false) &&
                    (strpos($migrationContent, "'" . $field . "'") !== false ||
                     strpos($migrationContent, '"' . $field . '"') !== false)) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                echo "  [OK] $field: Found in migration\n";
            } else {
                echo "  [ERROR] $field: Missing from database schema\n";
                $errors++;
            }
        }
    } else {
        echo "  [ERROR] Migrations directory not found\n";
        $errors++;
    }
}
echo "\n";

// Check Report Template
echo "[TEMPLATE] Checking Report Templates...\n";
$reportFiles = [
    $basePath . '/resources/views/reports/web-report.blade.php',
    $basePath . '/resources/views/reports/index.blade.php'
];
foreach ($reportFiles as $reportFile) {
    if (!file_exists($reportFile)) continue;
    
    echo "  Checking: " . basename($reportFile) . "\n";
    $templateContent = file_get_contents($reportFile);
    foreach ($expectedFields as $field) {
        if (strpos($templateContent, '->' . $field) !== false) {
            echo "    [OK] $field: Referenced in template\n";
        } else {
            echo "    [WARN] $field: Not referenced in template\n";
        }
    }
}
echo "\n";

// Check Media Configuration  
echo "[MEDIA] Checking Media Configuration...\n";
$storageConfig = $basePath . '/config/filesystems.php';
$publicStorage = $basePath . '/public/storage';
$storageDir = $basePath . '/storage/app/public';

if (file_exists($storageConfig)) {
    echo "  [OK] Storage config found\n";
} else {
    echo "  [ERROR] Storage configuration missing\n";
    $errors++;
}

if (is_link($publicStorage) || is_dir($publicStorage)) {
    echo "  [OK] Public storage link exists\n";
} else {
    echo "  [WARN] Public storage link missing - run 'php artisan storage:link'\n";
}

if (is_dir($storageDir) && is_writable($storageDir)) {
    echo "  [OK] Storage directory writable\n";
} else {
    echo "  [WARN] Storage directory not writable or missing\n";
}
echo "\n";

// Summary
echo "[SUMMARY] Diagnostic Results\n";
echo str_repeat("=", 25) . "\n";
echo "| Field        | Form | Controller | Database | Template |\n";
echo "|--------------|------|------------|----------|----------|\n";

foreach ($expectedFields as $field) {
    // Form check
    $formCheck = 'FAIL';
    if (file_exists($formFile)) {
        $formContent = file_get_contents($formFile);
        if (strpos($formContent, 'name="' . $field . '"') !== false || 
            strpos($formContent, "name='" . $field . "'") !== false) {
            $formCheck = 'PASS';
        }
    }
    
    // Controller check  
    $controllerCheck = 'FAIL';
    if (file_exists($controllerFile)) {
        $controllerContent = file_get_contents($controllerFile);
        if (strpos($controllerContent, "'" . $field . "'") !== false || 
            strpos($controllerContent, '"' . $field . '"') !== false) {
            $controllerCheck = 'PASS';
        }
    }
    
    // Database check - try Laravel schema inspection if available
    $dbCheck = 'FAIL';
    try {
        // Try to get actual database columns
        $output = shell_exec('cd ' . __DIR__ . '/.. && php artisan tinker --execute="echo json_encode(\\Illuminate\\Support\\Facades\\Schema::getColumnListing(\'vehicles\'));" 2>/dev/null');
        if ($output) {
            $columns = json_decode(trim($output), true);
            if (is_array($columns) && in_array($field, $columns)) {
                $dbCheck = 'PASS';
            }
        }
    } catch (Exception $e) {
        // Fallback to migration file search
        if (is_dir($migrationsDir)) {
            $migrationFiles = glob($migrationsDir . '/*_*_table.php');
            foreach ($migrationFiles as $file) {
                $migrationContent = file_get_contents($file);
                if ((strpos($migrationContent, 'vehicles') !== false || 
                     strpos($migrationContent, 'inspections') !== false) &&
                    (strpos($migrationContent, "'" . $field . "'") !== false ||
                     strpos($migrationContent, '"' . $field . '"') !== false)) {
                    $dbCheck = 'PASS';
                    break;
                }
            }
        }
    }
    
    // Template check
    $templateCheck = 'WARN';
    foreach ($reportFiles as $reportFile) {
        if (file_exists($reportFile)) {
            $templateContent = file_get_contents($reportFile);
            if (strpos($templateContent, '->' . $field) !== false) {
                $templateCheck = 'PASS';
                break;
            }
        }
    }
    
    printf("| %-12s | %-4s | %-10s | %-8s | %-8s |\n", 
        $field, $formCheck, $controllerCheck, $dbCheck, $templateCheck);
}

echo "\n";
if ($errors > 0) {
    echo "[RESULT] $errors errors found - fixes required\n";
    exit(1);
} else {
    echo "[RESULT] All critical checks passed!\n";
    exit(0);
}