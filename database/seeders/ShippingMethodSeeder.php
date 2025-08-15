<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingMethods = [
            [
                'name' => 'Standard Delivery',
                'description' => 'Delivered within 5-7 business days',
                'carrier' => 'India Post',
                'estimated_days_min' => 5,
                'estimated_days_max' => 7,
                'base_cost' => 40.00, // INR
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Express Delivery',
                'description' => 'Delivered within 2-3 business days',
                'carrier' => 'BlueDart',
                'estimated_days_min' => 2,
                'estimated_days_max' => 3,
                'base_cost' => 99.00, // INR
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Same Day Delivery',
                'description' => 'Delivered within the same day (Metro cities only)',
                'carrier' => 'Dunzo',
                'estimated_days_min' => 0,
                'estimated_days_max' => 1,
                'base_cost' => 199.00, // INR
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Next Day Delivery',
                'description' => 'Delivered by next business day',
                'carrier' => 'DTDC',
                'estimated_days_min' => 1,
                'estimated_days_max' => 1,
                'base_cost' => 149.00, // INR
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Free Delivery',
                'description' => 'Free delivery on orders above ₹499',
                'carrier' => 'Ecom Express',
                'estimated_days_min' => 5,
                'estimated_days_max' => 8,
                'base_cost' => 0.00,
                'free_shipping_threshold' => 499.00,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Cash on Delivery',
                'description' => 'Pay when your order is delivered (Additional charges apply)',
                'carrier' => 'India Post',
                'estimated_days_min' => 5,
                'estimated_days_max' => 7,
                'base_cost' => 50.00, // INR
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($shippingMethods as $method) {
            ShippingMethod::create($method);
        }
    }
}
