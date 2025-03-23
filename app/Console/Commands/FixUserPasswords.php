<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserPasswords extends Command
{
    protected $signature = 'users:fix-passwords';
    protected $description = 'Fix improperly hashed passwords for existing users';

    public function handle()
    {
        $this->info('Starting password fix process...');
        
        // This is just a safety check - we won't actually rehash all passwords
        // as we don't know the original values
        $users = User::all();
        
        $this->info("Found {$users->count()} users in the database.");
        $this->info("If you're having issues with specific users, you should reset their passwords manually.");
        
        $this->info("To reset a specific user's password, use: php artisan users:reset-password {email}");
        
        return Command::SUCCESS;
    }
}
