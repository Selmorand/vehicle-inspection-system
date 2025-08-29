<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class EnvironmentUserSeeder extends Seeder
{
    public function run(): void
    {
        $environment = App::environment();
        
        // Different users per environment
        switch($environment) {
            case 'local':
                $this->createLocalUsers();
                break;
            case 'staging':
                $this->createStagingUsers();
                break;
            case 'production':
                // NEVER seed users in production automatically
                echo "⚠️  Production - skipping user seeding\n";
                break;
        }
    }

    private function createLocalUsers()
    {
        echo "🏠 Creating LOCAL development users...\n";
        
        $users = [
            ['name' => 'Dev Admin', 'email' => 'admin@test.local', 'password' => 'admin123', 'role' => 'admin'],
            ['name' => 'Dev Inspector', 'email' => 'inspector@test.local', 'password' => 'inspector123', 'role' => 'inspector'],
            ['name' => 'Test User', 'email' => 'test@test.local', 'password' => 'test123', 'role' => 'inspector'],
        ];

        $this->createUsers($users);
    }

    private function createStagingUsers()
    {
        echo "🔧 Creating STAGING test users...\n";
        
        $users = [
            ['name' => 'Staging Admin', 'email' => 'admin@alphainspections.co.za', 'password' => 'StageAdmin2025!', 'role' => 'admin'],
            ['name' => 'Staging Inspector', 'email' => 'inspector@alphainspections.co.za', 'password' => 'StageInspect2025!', 'role' => 'inspector'],
            ['name' => 'Demo User', 'email' => 'demo@alphainspections.co.za', 'password' => 'DemoUser2025!', 'role' => 'inspector'],
        ];

        $this->createUsers($users);
    }

    private function createUsers(array $users)
    {
        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'] ?? 'inspector',
                ]
            );
            
            echo "✅ Created/Updated: {$user->email}\n";
        }
    }
}