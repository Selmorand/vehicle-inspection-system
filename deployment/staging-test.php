<?php
/**
 * Simple diagnostic script for staging environment
 * This file can be accessed directly at: https://alpha.selpro.co.za/staging-test.php
 */

echo "<h1>Staging Environment Diagnostic</h1>";
echo "<hr>";

// PHP Version
echo "<h2>PHP Configuration</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
echo "Max Execution Time: " . ini_get('max_execution_time') . "<br>";
echo "Upload Max Filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "<br>";

// Check if Laravel files exist
echo "<h2>Laravel Files</h2>";
$laravel_files = [
    'artisan' => file_exists(__DIR__ . '/artisan'),
    'bootstrap/app.php' => file_exists(__DIR__ . '/bootstrap/app.php'),
    'vendor/autoload.php' => file_exists(__DIR__ . '/vendor/autoload.php'),
    'app/Http/Controllers/ReportController.php' => file_exists(__DIR__ . '/app/Http/Controllers/ReportController.php'),
    '.env' => file_exists(__DIR__ . '/.env')
];

foreach ($laravel_files as $file => $exists) {
    $status = $exists ? "✅ EXISTS" : "❌ MISSING";
    echo "{$file}: {$status}<br>";
}
echo "<br>";

// Check .env file contents (safely)
echo "<h2>Environment Configuration</h2>";
if (file_exists(__DIR__ . '/.env')) {
    $env_content = file_get_contents(__DIR__ . '/.env');
    $env_lines = explode("\n", $env_content);
    
    foreach ($env_lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            
            // Hide sensitive values
            if (in_array($key, ['DB_PASSWORD', 'APP_KEY'])) {
                $value = '[HIDDEN]';
            }
            
            echo "{$key} = {$value}<br>";
        }
    }
} else {
    echo "❌ .env file not found<br>";
}
echo "<br>";

// Test database connection
echo "<h2>Database Connection</h2>";
if (file_exists(__DIR__ . '/.env')) {
    $env_vars = [];
    $env_content = file_get_contents(__DIR__ . '/.env');
    $env_lines = explode("\n", $env_content);
    
    foreach ($env_lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $env_vars[trim($key)] = trim($value, '"\'');
        }
    }
    
    if (isset($env_vars['DB_HOST'], $env_vars['DB_DATABASE'], $env_vars['DB_USERNAME'], $env_vars['DB_PASSWORD'])) {
        try {
            $pdo = new PDO(
                "mysql:host={$env_vars['DB_HOST']};dbname={$env_vars['DB_DATABASE']}", 
                $env_vars['DB_USERNAME'], 
                $env_vars['DB_PASSWORD'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            echo "✅ Database connection successful<br>";
            
            // Check if inspection_reports table exists
            $stmt = $pdo->query("SHOW TABLES LIKE 'inspection_reports'");
            if ($stmt->rowCount() > 0) {
                echo "✅ inspection_reports table exists<br>";
                
                // Check table structure
                $stmt = $pdo->query("DESCRIBE inspection_reports");
                echo "Table columns:<br>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "- {$row['Field']} ({$row['Type']})<br>";
                }
            } else {
                echo "❌ inspection_reports table missing - need to run migrations<br>";
            }
            
        } catch (PDOException $e) {
            echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ Database configuration incomplete in .env<br>";
    }
} else {
    echo "❌ Cannot test database - .env file missing<br>";
}
echo "<br>";

// Check Composer dependencies
echo "<h2>Composer Dependencies</h2>";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✅ Composer autoloader exists<br>";
    
    // Check for specific packages
    $packages_to_check = [
        'barryvdh/laravel-dompdf' => __DIR__ . '/vendor/barryvdh/laravel-dompdf',
        'laravel/framework' => __DIR__ . '/vendor/laravel/framework'
    ];
    
    foreach ($packages_to_check as $package => $path) {
        if (is_dir($path)) {
            echo "✅ {$package} installed<br>";
        } else {
            echo "❌ {$package} missing<br>";
        }
    }
} else {
    echo "❌ Composer dependencies not installed<br>";
}
echo "<br>";

// Check storage permissions
echo "<h2>File Permissions</h2>";
$directories_to_check = [
    'storage' => __DIR__ . '/storage',
    'storage/app' => __DIR__ . '/storage/app',
    'storage/logs' => __DIR__ . '/storage/logs',
    'bootstrap/cache' => __DIR__ . '/bootstrap/cache'
];

foreach ($directories_to_check as $name => $path) {
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path) ? "✅ WRITABLE" : "❌ NOT WRITABLE";
        echo "{$name}: {$perms} ({$writable})<br>";
    } else {
        echo "{$name}: ❌ DIRECTORY MISSING<br>";
    }
}

echo "<hr>";
echo "<p><strong>Generated:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_NAME'] . "</p>";
?>