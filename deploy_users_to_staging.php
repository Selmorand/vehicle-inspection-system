<?php
// Script to deploy local users with known passwords to staging server
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get the known seeded users from local database
$users = [
    [
        'name' => 'Admin User',
        'email' => 'admin@alphainspections.co.za',
        'password' => 'admin123',
        'role' => 'admin'
    ],
    [
        'name' => 'John Inspector', 
        'email' => 'inspector@alphainspections.co.za',
        'password' => 'inspector123',
        'role' => 'inspector'
    ],
    [
        'name' => 'Jane User',
        'email' => 'user@alphainspections.co.za', 
        'password' => 'user123',
        'role' => 'user'
    ]
];

// Create SQL to insert/update users on staging
$sql = "-- Deploy known users to staging server\n";
$sql .= "-- Run this on staging database: alphains_production\n\n";

foreach ($users as $user) {
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
    
    $sql .= "-- User: {$user['name']} ({$user['email']}) - Password: {$user['password']}\n";
    $sql .= "INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) \n";
    $sql .= "VALUES ('{$user['name']}', '{$user['email']}', '{$hashedPassword}', '{$user['role']}', NOW(), NOW(), NOW())\n";
    $sql .= "ON DUPLICATE KEY UPDATE \n";
    $sql .= "  password = '{$hashedPassword}',\n";
    $sql .= "  role = '{$user['role']}',\n";
    $sql .= "  updated_at = NOW();\n\n";
}

// Save SQL file
file_put_contents('deploy_users.sql', $sql);

echo "=== DEPLOYMENT READY ===\n";
echo "Created: deploy_users.sql\n\n";

echo "Known users with passwords:\n";
foreach ($users as $user) {
    echo "- {$user['name']}: {$user['email']} / {$user['password']} ({$user['role']})\n";
}

echo "\n=== DEPLOYMENT COMMANDS ===\n";
echo "1. Upload deploy_users.sql to staging server\n";
echo "2. Run on staging server:\n";
echo "   mysql -u alphains_piet -p'LIBRA#@!*libra3218' alphains_production < deploy_users.sql\n\n";

echo "Or run via SSH:\n";
echo "scp -P 22000 deploy_users.sql alphains@alphainspections.co.za:/home/alphains/\n";
echo "ssh -p 22000 alphains@alphainspections.co.za \"mysql -u alphains_piet -p'LIBRA#@!*libra3218' alphains_production < /home/alphains/deploy_users.sql\"\n";
?>