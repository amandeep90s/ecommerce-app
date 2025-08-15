<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in order: foundational data first, then dependent data
        $this->call([
            // Core system data
            RolePermissionSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
            SettingSeeder::class,

            // Product-related master data
            CategorySeeder::class,
            BrandSeeder::class,
            TaxClassSeeder::class,

            // Shipping and logistics
            ShippingMethodSeeder::class,

            // User data (after roles are created)
            UserSeeder::class,

            // Additional seeders can be added here
            // ProductSeeder::class,
            // CouponSeeder::class,
        ]);
    }
}
