<?php
// Database setup script for staging
echo "Starting database setup...\n";

// Include Laravel
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

try {
    // Run migrations
    echo "Running migrations...\n";
    $exitCode = \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "Migration output: " . \Illuminate\Support\Facades\Artisan::output();
    
    if ($exitCode === 0) {
        echo "✅ Migrations completed successfully!\n";
    } else {
        echo "❌ Migration failed with exit code: " . $exitCode . "\n";
    }
    
    // Generate app key if not set
    echo "Checking application key...\n";
    if (empty(config('app.key'))) {
        $keyResult = \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
        echo "Key generation result: " . $keyResult . "\n";
    }
    
    echo "✅ Database setup completed!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>