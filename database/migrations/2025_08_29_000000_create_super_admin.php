<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add is_super_admin column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_super_admin')->default(false)->after('role');
        });

        // Create the super admin account
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@system.local',
            'password' => Hash::make('SuperSecure2025!@#'),
            'role' => 'admin',
            'is_super_admin' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove super admin user
        User::where('email', 'superadmin@system.local')->delete();
        
        // Remove column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_super_admin');
        });
    }
};