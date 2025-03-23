<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetUserPassword extends Command
{
    protected $signature = 'users:reset-password {email}';
    protected $description = 'Reset password for a specific user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return Command::FAILURE;
        }
        
        $password = Str::random(16);
        $user->password = Hash::make($password);
        $user->save();
        
        $this->info("Password for {$email} has been reset to: {$password}");
        $this->info("Please login with this password and change it immediately.");
        
        return Command::SUCCESS;
    }
}
