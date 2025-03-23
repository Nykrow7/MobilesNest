<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserPassword extends Command
{
    protected $signature = 'user:fix-password {email} {password}';
    protected $description = 'Fix a user password directly in the database';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        $user->password = Hash::make($password);
        $user->save();
        
        $this->info("Password for {$email} has been updated successfully!");
        
        // Verify the password was properly hashed
        if (Hash::check($password, $user->password)) {
            $this->info("Password verification successful!");
        } else {
            $this->error("Password verification failed! There might be an issue with the hashing mechanism.");
        }
        
        return 0;
    }
}
