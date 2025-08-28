<?php
echo "<h1>ALPHA Vehicle Inspection - Staging Diagnostic Test</h1>";
echo "<hr>";

// Test 1: PHP Version
echo "<h2>1. PHP Version Test</h2>";
echo "PHP Version: " . phpversion();
if (version_compare(phpversion(), '8.2', '>=')) {
    echo " ✅ OK (8.2+ required)";
} else {
    echo " ❌ FAIL (8.2+ required)";
}
echo "<br><br>";

// Test 2: Laravel Files
echo "<h2>2. Laravel Files Test</h2>";
$laravelFiles = [
    'artisan' => 'Laravel artisan command',
    'app/Http/Controllers/Controller.php' => 'Base Controller',
    'bootstrap/app.php' => 'Laravel bootstrap',
    'config/app.php' => 'Application config',
    'vendor/laravel/framework/src/Illuminate/Foundation/Application.php' => 'Laravel Framework'
];

foreach ($laravelFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}<br>";
    } else {
        echo "❌ MISSING {$description}: {$file}<br>";
    }
}
echo "<br>";

// Test 3: Application Files
echo "<h2>3. Application Files Test</h2>";
$appFiles = [
    'resources/views/dashboard.blade.php' => 'Dashboard view',
    'resources/views/visual-inspection.blade.php' => 'Visual inspection view',
    'resources/views/physical-hoist-inspection.blade.php' => 'Physical hoist inspection view',
    'public/js/inspection-cards.js' => 'InspectionCards JavaScript',
    'public/css/panel-cards.css' => 'Panel cards CSS',
    'app/Http/Controllers/InspectionController.php' => 'Inspection Controller',
    'app/Models/InspectionReport.php' => 'Inspection Report Model'
];

foreach ($appFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}<br>";
    } else {
        echo "❌ MISSING {$description}: {$file}<br>";
    }
}
echo "<br>";

// Test 4: Database Connection
echo "<h2>4. Database Connection Test</h2>";
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=profirea_vehicle_inspection", 
        "profirea_staging", 
        "staging123!@#"
    );
    echo "✅ Database connection successful<br>";
    
    // Test tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " database tables<br>";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}
echo "<br>";

// Test 5: Storage Permissions
echo "<h2>5. Storage Permissions Test</h2>";
$storageWritable = is_writable('storage/app') && is_writable('storage/logs') && is_writable('storage/framework');
if ($storageWritable) {
    echo "✅ Storage directories are writable<br>";
} else {
    echo "❌ Storage directories not writable (set to 755)<br>";
}
echo "<br>";

// Test 6: Environment Configuration
echo "<h2>6. Environment Configuration</h2>";
if (file_exists('.env')) {
    echo "✅ .env file exists<br>";
    $env = file_get_contents('.env');
    if (strpos($env, 'APP_KEY=base64:') !== false && strpos($env, 'YOUR_APP_KEY_WILL_BE_GENERATED') === false) {
        echo "✅ Application key is set<br>";
    } else {
        echo "⚠️ Application key needs to be generated (run artisan-web.php)<br>";
    }
} else {
    echo "❌ .env file missing<br>";
}
echo "<br>";

// Test 7: DomPDF (for report generation)
echo "<h2>7. PDF Generation Test</h2>";
if (file_exists('vendor/dompdf/dompdf/src/Dompdf.php')) {
    echo "✅ DomPDF library is installed<br>";
} else {
    echo "❌ DomPDF library missing<br>";
}
echo "<br>";

// Test 8: Image Assets
echo "<h2>8. Image Assets Test</h2>";
$imageFiles = [
    'public/images/panels/FullVehicle.png' => 'Vehicle diagram',
    'public/images/interior/interiorMain.png' => 'Interior diagram',
    'public/images/logo.png' => 'Company logo'
];

foreach ($imageFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}<br>";
    } else {
        echo "❌ MISSING {$description}: {$file}<br>";
    }
}
echo "<br>";

echo "<hr>";
echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li><strong>If any files are missing:</strong> Re-upload the deployment files</li>";
echo "<li><strong>If database connection fails:</strong> Check database credentials in .env</li>";
echo "<li><strong>If app key needs generation:</strong> Run <a href='/artisan-web.php'>artisan-web.php</a></li>";
echo "<li><strong>If all tests pass:</strong> Visit <a href='/'>the main application</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>Generated: " . date('Y-m-d H:i:s T') . "</small></p>";
?>