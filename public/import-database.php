<?php
// Import database with proper error handling
echo "<pre>";
echo "Database Import Tool\n";
echo "====================\n\n";

$host = 'localhost';
$dbname = 'alphains_staging';
$username = 'alphains_staging';
$password = '~cMS4%Xn!g1c';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database\n\n";
    
    // First, drop ALL existing tables
    echo "Dropping existing tables...\n";
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
        echo "  Dropped: $table\n";
    }
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "\n";
    
    // Read and execute the SQL file
    $sql_file = 'staging-database-complete-mysql.sql';
    if (!file_exists($sql_file)) {
        die("❌ Error: $sql_file not found. Upload it first!\n");
    }
    
    $sql = file_get_contents($sql_file);
    
    // Split by semicolon but not inside quotes
    $queries = preg_split('/;\s*$/m', $sql);
    
    $success = 0;
    $errors = 0;
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (empty($query)) continue;
        
        try {
            $pdo->exec($query);
            $success++;
            
            // Show progress for CREATE TABLE statements
            if (stripos($query, 'CREATE TABLE') === 0) {
                preg_match('/CREATE TABLE `?(\w+)`?/i', $query, $matches);
                if (isset($matches[1])) {
                    echo "✅ Created table: " . $matches[1] . "\n";
                }
            }
        } catch (PDOException $e) {
            $errors++;
            echo "❌ Error: " . $e->getMessage() . "\n";
            echo "   Query: " . substr($query, 0, 100) . "...\n\n";
        }
    }
    
    echo "\n========================================\n";
    echo "Import Summary:\n";
    echo "  Successful queries: $success\n";
    echo "  Failed queries: $errors\n";
    
    // Show final table list
    echo "\nFinal tables in database:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "  - $table ($count records)\n";
    }
    
} catch(PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>