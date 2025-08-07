<?php
// IMPORTANT: DELETE THIS FILE AFTER RUNNING!

// Navigate to Laravel directory
chdir(__DIR__);

// Run artisan commands
echo "<h1>Running Artisan Commands for ALPHA Vehicle Inspection</h1>";

// Generate key
echo "<h2>Generating Application Key...</h2>";
exec('php artisan key:generate --force 2>&1', $output1);
echo "<pre>" . implode("\n", $output1) . "</pre>";

// Run migrations
echo "<h2>Running Migrations...</h2>";
exec('php artisan migrate --force 2>&1', $output2);
echo "<pre>" . implode("\n", $output2) . "</pre>";

// Clear caches
echo "<h2>Clearing Caches...</h2>";
exec('php artisan config:clear 2>&1', $output3);
echo "<pre>" . implode("\n", $output3) . "</pre>";

exec('php artisan cache:clear 2>&1', $output4);
echo "<pre>" . implode("\n", $output4) . "</pre>";

exec('php artisan view:clear 2>&1', $output5);
echo "<pre>" . implode("\n", $output5) . "</pre>";

echo "<hr>";
echo "<h2 style='color: green;'>Deployment Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li>Test the application: <a href='/'>Go to Homepage</a></li>";
echo "<li>Test diagnostics: <a href='/staging-test.php'>Run Diagnostics</a></li>";
echo "<li>Test reports: <a href='/reports'>View Reports</a></li>";
echo "</ul>";
echo "<hr>";
echo "<p style='color: red; font-size: 18px;'><strong>IMPORTANT: Delete this file immediately after use!</strong></p>";
?>