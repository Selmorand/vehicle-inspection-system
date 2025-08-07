<?php
/**
 * Web-based Artisan Command Runner
 * 
 * SECURITY WARNING: DELETE THIS FILE IMMEDIATELY AFTER USE!
 * This file allows running artisan commands via web browser.
 * 
 * Usage: Upload to staging server and visit https://alpha.selpro.co.za/artisan-web.php
 */

// Prevent timeout
set_time_limit(300);

// Navigate to Laravel directory
chdir(__DIR__);

// Check if we're in the right place
if (!file_exists('artisan')) {
    die("Error: artisan file not found. Make sure this file is in the Laravel root directory.");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Artisan Command Runner</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #4f959b; }
        h2 { color: #333; border-bottom: 2px solid #4f959b; padding-bottom: 10px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .delete-warning { background: #dc3545; color: white; padding: 20px; border-radius: 5px; text-align: center; font-size: 18px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Artisan Command Runner</h1>
        
        <div class="warning">
            <strong>⚠️ Security Warning:</strong> This file provides direct access to artisan commands. 
            Delete it immediately after use!
        </div>

        <?php
        // Function to run command and capture output
        function runCommand($command, $title) {
            echo "<h2>$title</h2>";
            
            $output = [];
            $return_var = 0;
            
            exec($command . ' 2>&1', $output, $return_var);
            
            $status = $return_var === 0 ? 'success' : 'error';
            $icon = $return_var === 0 ? '✅' : '❌';
            
            echo "<p class='$status'>$icon Status: " . ($return_var === 0 ? 'Success' : 'Failed (Code: ' . $return_var . ')') . "</p>";
            echo "<pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";
            
            return $return_var === 0;
        }

        // Check current environment
        echo "<h2>Environment Check</h2>";
        echo "<pre>";
        echo "PHP Version: " . phpversion() . "\n";
        echo "Laravel Path: " . getcwd() . "\n";
        echo "Artisan Exists: " . (file_exists('artisan') ? 'Yes' : 'No') . "\n";
        echo ".env Exists: " . (file_exists('.env') ? 'Yes' : 'No') . "\n";
        echo "</pre>";

        // Run commands
        $success = true;

        // Generate application key
        if (runCommand('php artisan key:generate', '🔑 Generating Application Key')) {
            echo "<p class='success'>Application key generated successfully!</p>";
        } else {
            $success = false;
        }

        // Run migrations
        if (runCommand('php artisan migrate --force', '📊 Running Database Migrations')) {
            echo "<p class='success'>Database migrations completed!</p>";
        } else {
            $success = false;
            echo "<p class='error'>Migration failed. Check database credentials in .env file.</p>";
        }

        // Clear configuration cache
        runCommand('php artisan config:clear', '🧹 Clearing Configuration Cache');

        // Clear application cache
        runCommand('php artisan cache:clear', '🧹 Clearing Application Cache');

        // Clear view cache
        runCommand('php artisan view:clear', '🧹 Clearing View Cache');

        // Clear route cache (might fail on some hosts)
        runCommand('php artisan route:clear', '🧹 Clearing Route Cache');

        // Final status
        echo "<h2>Summary</h2>";
        if ($success) {
            echo "<p class='success' style='font-size: 20px;'>✅ All critical commands completed successfully!</p>";
            echo "<p>Your staging environment should now be properly configured.</p>";
            echo "<p>Next steps:</p>";
            echo "<ul>";
            echo "<li>Visit <a href='/'>https://alpha.selpro.co.za</a> to test the application</li>";
            echo "<li>Visit <a href='/staging-test.php'>https://alpha.selpro.co.za/staging-test.php</a> for diagnostics</li>";
            echo "<li><strong>DELETE THIS FILE IMMEDIATELY!</strong></li>";
            echo "</ul>";
        } else {
            echo "<p class='error' style='font-size: 20px;'>❌ Some commands failed. Please check the output above.</p>";
        }
        ?>

        <div class="delete-warning">
            🚨 CRITICAL SECURITY WARNING 🚨<br>
            DELETE THIS FILE (artisan-web.php) IMMEDIATELY!<br>
            Leaving this file on your server is a serious security risk.
        </div>
    </div>
</body>
</html>