<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Jeycookie',
            'email' => 'admin@jeycookie.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Jl. Bakery No. 1, Jakarta',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample customer
        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'address' => 'Jl. Customer No. 1, Jakarta',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}
