<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip if admin user already exists
        if (User::where('email', 'admin@news.com')->exists()) {
            return;
        }

        User::firstOrCreate([
            'email' => 'admin@news.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
