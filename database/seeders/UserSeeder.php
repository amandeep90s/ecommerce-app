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
        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super-admin');

        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Manager
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

        // Create Vendor
        $vendor = User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567893',
            'email_verified_at' => now(),
        ]);
        $vendor->assignRole('vendor');

        // Create Customer Support
        $support = User::create([
            'name' => 'Support User',
            'email' => 'support@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567894',
            'email_verified_at' => now(),
        ]);
        $support->assignRole('customer-support');

        // Create Customer
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567895',
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');

        // Create additional sample customers
        for ($i = 1; $i <= 5; $i++) {
            $customer = User::create([
                'name' => "Customer $i",
                'email' => "customer$i@example.com",
                'password' => Hash::make('password'),
                'phone' => '+123456789'.(5 + $i),
                'email_verified_at' => now(),
            ]);
            $customer->assignRole('customer');
        }
    }
}
