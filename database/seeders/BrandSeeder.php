<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            // Indian Fashion Brands
            ['name' => 'Fabindia', 'slug' => 'fabindia', 'description' => 'Indian ethnic wear and handcrafted products', 'is_active' => true],
            ['name' => 'Biba', 'slug' => 'biba', 'description' => 'Contemporary Indian women\'s wear', 'is_active' => true],
            ['name' => 'W for Woman', 'slug' => 'w-for-woman', 'description' => 'Indian women\'s ethnic and western wear', 'is_active' => true],
            ['name' => 'Manyavar', 'slug' => 'manyavar', 'description' => 'Indian men\'s ethnic wear', 'is_active' => true],
            ['name' => 'Aurelia', 'slug' => 'aurelia', 'description' => 'Women\'s ethnic wear', 'is_active' => true],

            // International Fashion Brands
            ['name' => 'H&M', 'slug' => 'h-m', 'description' => 'Swedish multinational clothing-retail company', 'is_active' => true],
            ['name' => 'Zara', 'slug' => 'zara', 'description' => 'Spanish fast fashion retailer', 'is_active' => true],
            ['name' => 'Nike', 'slug' => 'nike', 'description' => 'American multinational corporation for footwear and apparel', 'is_active' => true],
            ['name' => 'Adidas', 'slug' => 'adidas', 'description' => 'German multinational corporation for sportswear', 'is_active' => true],
            ['name' => 'Levi\'s', 'slug' => 'levis', 'description' => 'American denim and clothing brand', 'is_active' => true],

            // Electronics Brands
            ['name' => 'Samsung', 'slug' => 'samsung', 'description' => 'South Korean multinational electronics company', 'is_active' => true],
            ['name' => 'Apple', 'slug' => 'apple', 'description' => 'American multinational technology company', 'is_active' => true],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi', 'description' => 'Chinese electronics company', 'is_active' => true],
            ['name' => 'OnePlus', 'slug' => 'oneplus', 'description' => 'Chinese smartphone manufacturer', 'is_active' => true],
            ['name' => 'Realme', 'slug' => 'realme', 'description' => 'Chinese smartphone brand', 'is_active' => true],
            ['name' => 'Vivo', 'slug' => 'vivo', 'description' => 'Chinese technology company', 'is_active' => true],
            ['name' => 'Oppo', 'slug' => 'oppo', 'description' => 'Chinese consumer electronics company', 'is_active' => true],

            // Indian Electronics Brands
            ['name' => 'Micromax', 'slug' => 'micromax', 'description' => 'Indian multinational technology company', 'is_active' => true],
            ['name' => 'Boat', 'slug' => 'boat', 'description' => 'Indian consumer electronics brand', 'is_active' => true],
            ['name' => 'Noise', 'slug' => 'noise', 'description' => 'Indian wearables and audio brand', 'is_active' => true],

            // Home Appliances
            ['name' => 'LG', 'slug' => 'lg', 'description' => 'South Korean multinational electronics company', 'is_active' => true],
            ['name' => 'Whirlpool', 'slug' => 'whirlpool', 'description' => 'American multinational home appliances company', 'is_active' => true],
            ['name' => 'Godrej', 'slug' => 'godrej', 'description' => 'Indian conglomerate company', 'is_active' => true],
            ['name' => 'Bajaj', 'slug' => 'bajaj', 'description' => 'Indian multinational conglomerate', 'is_active' => true],
            ['name' => 'IFB', 'slug' => 'ifb', 'description' => 'Indian home appliances company', 'is_active' => true],

            // Beauty & Personal Care
            ['name' => 'Lakme', 'slug' => 'lakme', 'description' => 'Indian cosmetics brand', 'is_active' => true],
            ['name' => 'Himalaya', 'slug' => 'himalaya', 'description' => 'Indian health and personal care brand', 'is_active' => true],
            ['name' => 'Dabur', 'slug' => 'dabur', 'description' => 'Indian consumer goods company', 'is_active' => true],
            ['name' => 'Patanjali', 'slug' => 'patanjali', 'description' => 'Indian consumer goods company', 'is_active' => true],
            ['name' => 'L\'Oreal', 'slug' => 'loreal', 'description' => 'French personal care and cosmetics company', 'is_active' => true],
            ['name' => 'Nivea', 'slug' => 'nivea', 'description' => 'German personal care brand', 'is_active' => true],

            // Food & Grocery Brands
            ['name' => 'Amul', 'slug' => 'amul', 'description' => 'Indian dairy cooperative', 'is_active' => true],
            ['name' => 'Britannia', 'slug' => 'britannia', 'description' => 'Indian food company', 'is_active' => true],
            ['name' => 'Parle', 'slug' => 'parle', 'description' => 'Indian food products company', 'is_active' => true],
            ['name' => 'Haldiram\'s', 'slug' => 'haldirams', 'description' => 'Indian sweets and snacks manufacturer', 'is_active' => true],
            ['name' => 'MTR', 'slug' => 'mtr', 'description' => 'Indian food products company', 'is_active' => true],
            ['name' => 'Tata Tea', 'slug' => 'tata-tea', 'description' => 'Indian tea brand', 'is_active' => true],

            // Books & Education
            ['name' => 'Pearson', 'slug' => 'pearson', 'description' => 'British multinational publishing company', 'is_active' => true],
            ['name' => 'McGraw Hill', 'slug' => 'mcgraw-hill', 'description' => 'American educational publishing company', 'is_active' => true],
            ['name' => 'Arihant', 'slug' => 'arihant', 'description' => 'Indian educational publisher', 'is_active' => true],
            ['name' => 'S. Chand', 'slug' => 's-chand', 'description' => 'Indian educational publisher', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
