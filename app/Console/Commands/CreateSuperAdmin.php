<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    protected $signature = 'superadmin:create 
                            {--reset : Reset the super admin password}
                            {--show : Show super admin credentials}';
    
    protected $description = 'Create or reset the super admin account for development';

    // Super admin credentials (change these!)
    private const SUPER_ADMIN_EMAIL = 'superadmin@system.local';
    private const SUPER_ADMIN_PASSWORD = 'SuperSecure2025!@#';
    private const SUPER_ADMIN_NAME = 'Super Admin (Dev)';

    public function handle()
    {
        if ($this->option('show')) {
            $this->showCredentials();
            return 0;
        }

        $exists = User::where('email', self::SUPER_ADMIN_EMAIL)->first();

        if ($exists && !$this->option('reset')) {
            $this->warn('Super admin already exists. Use --reset to reset password.');
            $this->showCredentials();
            return 0;
        }

        if ($exists && $this->option('reset')) {
            $this->resetSuperAdmin($exists);
        } else {
            $this->createSuperAdmin();
        }

        return 0;
    }

    private function createSuperAdmin()
    {
        $this->info('Creating super admin account...');

        $user = User::create([
            'name' => self::SUPER_ADMIN_NAME,
            'email' => self::SUPER_ADMIN_EMAIL,
            'password' => Hash::make(self::SUPER_ADMIN_PASSWORD),
            'role' => 'admin',
            'is_super_admin' => true,
        ]);

        $this->info('✅ Super admin created successfully!');
        $this->showCredentials();
    }

    private function resetSuperAdmin($user)
    {
        $this->info('Resetting super admin password...');

        // Temporarily set as super admin to bypass protection
        $user->password = Hash::make(self::SUPER_ADMIN_PASSWORD);
        $user->save();

        $this->info('✅ Super admin password reset successfully!');
        $this->showCredentials();
    }

    private function showCredentials()
    {
        $this->info('');
        $this->info('🔐 SUPER ADMIN CREDENTIALS (DEVELOPMENT ONLY)');
        $this->info('============================================');
        $this->warn('Email:    ' . self::SUPER_ADMIN_EMAIL);
        $this->warn('Password: ' . self::SUPER_ADMIN_PASSWORD);
        $this->info('============================================');
        $this->info('⚠️  Keep these credentials secure!');
        $this->info('⚠️  This account cannot be modified by other users');
        $this->info('');
    }
}