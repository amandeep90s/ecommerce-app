<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Store Information
            ['key' => 'store_name', 'value' => 'IndiaCart', 'type' => 'string'],
            ['key' => 'store_tagline', 'value' => 'Your Trusted Online Shopping Destination', 'type' => 'string'],
            ['key' => 'store_description', 'value' => 'India\'s premier e-commerce platform offering quality products at affordable prices', 'type' => 'string'],
            ['key' => 'store_email', 'value' => 'info@indiacart.com', 'type' => 'string'],
            ['key' => 'store_phone', 'value' => '+91-1800-123-4567', 'type' => 'string'],
            ['key' => 'store_address', 'value' => 'Tower A, Cyber City, Gurugram, Haryana 122002, India', 'type' => 'string'],

            // Currency Settings
            ['key' => 'default_currency', 'value' => 'INR', 'type' => 'string'],
            ['key' => 'currency_symbol', 'value' => '₹', 'type' => 'string'],
            ['key' => 'currency_position', 'value' => 'before', 'type' => 'string'], // before or after

            // Tax Settings
            ['key' => 'enable_tax', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'tax_inclusive', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'gst_number', 'value' => '07AABCI1234Q1Z5', 'type' => 'string'],

            // Shipping Settings
            ['key' => 'free_shipping_threshold', 'value' => '499', 'type' => 'integer'],
            ['key' => 'default_shipping_cost', 'value' => '40', 'type' => 'integer'],
            ['key' => 'enable_cod', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'cod_charges', 'value' => '50', 'type' => 'integer'],

            // Order Settings
            ['key' => 'order_prefix', 'value' => 'IND', 'type' => 'string'],
            ['key' => 'min_order_amount', 'value' => '100', 'type' => 'integer'],
            ['key' => 'max_order_amount', 'value' => '100000', 'type' => 'integer'],
            ['key' => 'enable_guest_checkout', 'value' => 'true', 'type' => 'boolean'],

            // Inventory Settings
            ['key' => 'low_stock_threshold', 'value' => '10', 'type' => 'integer'],
            ['key' => 'out_of_stock_threshold', 'value' => '0', 'type' => 'integer'],
            ['key' => 'enable_backorders', 'value' => 'false', 'type' => 'boolean'],

            // Customer Settings
            ['key' => 'enable_customer_registration', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'require_email_verification', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'enable_wishlist', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'enable_reviews', 'value' => 'true', 'type' => 'boolean'],

            // Payment Settings
            ['key' => 'enable_razorpay', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'enable_paytm', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'enable_phonepe', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'enable_upi', 'value' => 'true', 'type' => 'boolean'],

            // SEO Settings
            ['key' => 'meta_title', 'value' => 'IndiaCart - Online Shopping for Fashion, Electronics, Home & More', 'type' => 'string'],
            ['key' => 'meta_description', 'value' => 'Shop online at IndiaCart for the latest fashion, electronics, home appliances and more. Free shipping on orders above ₹499. Cash on Delivery available.', 'type' => 'string'],
            ['key' => 'meta_keywords', 'value' => 'online shopping, india, fashion, electronics, home appliances, free shipping, cash on delivery', 'type' => 'string'],

            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/indiacart', 'type' => 'string'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/indiacart', 'type' => 'string'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/indiacart', 'type' => 'string'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/indiacart', 'type' => 'string'],

            // Business Settings
            ['key' => 'business_hours', 'value' => 'Monday to Saturday: 9:00 AM to 8:00 PM', 'type' => 'string'],
            ['key' => 'customer_support_email', 'value' => 'support@indiacart.com', 'type' => 'string'],
            ['key' => 'customer_support_phone', 'value' => '+91-1800-123-4567', 'type' => 'string'],
            ['key' => 'return_policy_days', 'value' => '15', 'type' => 'integer'],
            ['key' => 'replacement_policy_days', 'value' => '7', 'type' => 'integer'],

            // App Settings
            ['key' => 'site_maintenance', 'value' => 'false', 'type' => 'boolean'],
            ['key' => 'timezone', 'value' => 'Asia/Kolkata', 'type' => 'string'],
            ['key' => 'date_format', 'value' => 'd/m/Y', 'type' => 'string'],
            ['key' => 'time_format', 'value' => 'H:i', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
