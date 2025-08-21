<?php
// Direct database setup script
echo "<pre>";
echo "Creating database tables...\n";

$host = 'localhost';
$dbname = 'alphains_staging';
$username = 'alphains_staging';
$password = '~cMS4%Xn!g1c';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connected successfully!\n\n";
    
    // Create sessions table (the one causing the error)
    $sql = "CREATE TABLE IF NOT EXISTS sessions (
        id VARCHAR(255) PRIMARY KEY,
        user_id BIGINT UNSIGNED NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        payload LONGTEXT NOT NULL,
        last_activity INTEGER NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "✅ Sessions table created\n";
    
    // Create cache table
    $sql = "CREATE TABLE IF NOT EXISTS cache (
        `key` VARCHAR(255) PRIMARY KEY,
        value MEDIUMTEXT NOT NULL,
        expiration INTEGER NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "✅ Cache table created\n";
    
    // Create cache_locks table
    $sql = "CREATE TABLE IF NOT EXISTS cache_locks (
        `key` VARCHAR(255) PRIMARY KEY,
        owner VARCHAR(255) NOT NULL,
        expiration INTEGER NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "✅ Cache locks table created\n";
    
    echo "\n🎉 Basic tables created! Try accessing the site now.\n";
    
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>