<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a user password by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return;
        }
        
        $user->password = Hash::make($password);
        $user->save();
        
        $this->info("Password updated for {$user->name} ({$user->email})");
    }
}
