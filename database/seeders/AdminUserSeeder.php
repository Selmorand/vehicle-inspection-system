<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        $adminEmail = 'admin@alphainspections.co.za';
        
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'), // Change this password!
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: ' . $adminEmail);
            $this->command->info('Password: admin123 (Please change after first login)');
        } else {
            $this->command->info('Admin user already exists.');
        }

        // Create sample inspector if it doesn't exist
        $inspectorEmail = 'inspector@alphainspections.co.za';
        
        if (!User::where('email', $inspectorEmail)->exists()) {
            User::create([
                'name' => 'John Inspector',
                'email' => $inspectorEmail,
                'password' => Hash::make('inspector123'),
                'role' => 'inspector',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Inspector user created successfully!');
            $this->command->info('Email: ' . $inspectorEmail);
            $this->command->info('Password: inspector123');
        }

        // Create sample regular user if it doesn't exist
        $userEmail = 'user@alphainspections.co.za';
        
        if (!User::where('email', $userEmail)->exists()) {
            User::create([
                'name' => 'Jane User',
                'email' => $userEmail,
                'password' => Hash::make('user123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Regular user created successfully!');
            $this->command->info('Email: ' . $userEmail);
            $this->command->info('Password: user123');
        }
    }
}