<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Ensure this line is present
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a normal user
      
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'adminuser@example.com',
            'password' => Hash::make('adminpassword'),
            'is_admin' => true, // Set to true for admin
        ]);
    }
}

