<?php

// Temporary script to reset inspector password on staging
// DELETE THIS FILE AFTER USE!

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::where('email', 'inspector@alphainspections.co.za')->first();

    if ($user) {
        $user->password = Hash::make('password123');
        $user->save();
        echo "✅ Password reset successfully for: " . $user->email . "\n";
        echo "🔑 New password: password123\n";
        echo "⚠️  DELETE THIS FILE NOW!\n";
    } else {
        echo "❌ User not found!\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}