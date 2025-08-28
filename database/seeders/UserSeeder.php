<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create default users for all environments
        $users = [
            [
                'name' => 'Inspector',
                'email' => 'inspector@alphainspections.co.za',
                'password' => Hash::make('password123'),
                'role' => 'inspector',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@alphainspections.co.za',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        echo "✅ Default users created/updated\n";
    }
}