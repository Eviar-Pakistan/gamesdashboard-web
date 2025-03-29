<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'mobile_no' => '03001234567', // Replace with a valid number
            'password' => Hash::make('admin123'), // Change to a secure password
            'type' => '0', // If there's a user type field
            'coin_balance' => 1000, // Optional, if applicable
            'code' => "0", // Generates a unique 6-character code
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
