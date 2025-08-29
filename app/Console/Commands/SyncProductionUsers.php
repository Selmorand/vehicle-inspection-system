<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SyncProductionUsers extends Command
{
    protected $signature = 'users:sync-from-production 
                            {--reset-passwords : Reset all passwords to test values}
                            {--preserve-admin : Keep admin accounts unchanged}';
    
    protected $description = 'Safely sync user structure from production (without real passwords)';

    public function handle()
    {
        if (app()->environment('production')) {
            $this->error('❌ Cannot run this command in production!');
            return 1;
        }

        $this->info('🔄 Starting safe user sync from production...');
        
        // This would connect to production DB (read-only)
        // In reality, you'd export from production and import here
        $this->syncUserStructure();
        
        if ($this->option('reset-passwords')) {
            $this->resetAllPasswords();
        }
        
        $this->info('✅ User sync completed!');
        return 0;
    }

    private function syncUserStructure()
    {
        $this->info('📋 Copying user structure (emails/names only)...');
        
        // Example: Import user list from production export
        $productionUsers = [
            // This would come from a production DB export
            ['name' => 'John Inspector', 'email' => 'john@company.com', 'role' => 'inspector'],
            ['name' => 'Jane Admin', 'email' => 'jane@company.com', 'role' => 'admin'],
        ];

        foreach ($productionUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('TestPassword123!'), // Safe default
                    'role' => $userData['role'],
                ]
            );
            
            $this->line("→ Synced: {$userData['email']}");
        }
    }

    private function resetAllPasswords()
    {
        $this->info('🔐 Resetting all passwords to test values...');
        
        $defaultPasswords = [
            'admin' => 'AdminTest123!',
            'inspector' => 'InspectorTest123!',
        ];

        User::chunk(100, function ($users) use ($defaultPasswords) {
            foreach ($users as $user) {
                $password = $defaultPasswords[$user->role] ?? 'TestUser123!';
                $user->password = Hash::make($password);
                $user->save();
                
                $this->line("→ Reset password for: {$user->email}");
            }
        });
    }
}