<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@shophub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Test customers
        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Ahmed Hassan', 'email' => 'ahmed@example.com'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah@example.com'],
        ];

        foreach ($customers as $customer) {
            User::create([
                'name' => $customer['name'],
                'email' => $customer['email'],
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);
        }
    }
}
