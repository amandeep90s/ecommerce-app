<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add India as primary country
        Country::create([
            'name' => 'India',
            'iso_code_2' => 'IN',
            'iso_code_3' => 'IND',
            'numeric_code' => '356',
            'phone_code' => '+91',
            'capital' => 'New Delhi',
            'currency_code' => 'INR',
            'currency_name' => 'Indian Rupee',
            'currency_symbol' => '₹',
            'is_active' => true,
        ]);

        // Add neighboring countries for potential future expansion
        $countries = [
            [
                'name' => 'Bangladesh',
                'iso_code_2' => 'BD',
                'iso_code_3' => 'BGD',
                'numeric_code' => '050',
                'phone_code' => '+880',
                'capital' => 'Dhaka',
                'currency_code' => 'BDT',
                'currency_name' => 'Bangladeshi Taka',
                'currency_symbol' => '৳',
                'is_active' => false,
            ],
            [
                'name' => 'Pakistan',
                'iso_code_2' => 'PK',
                'iso_code_3' => 'PAK',
                'numeric_code' => '586',
                'phone_code' => '+92',
                'capital' => 'Islamabad',
                'currency_code' => 'PKR',
                'currency_name' => 'Pakistani Rupee',
                'currency_symbol' => '₨',
                'is_active' => false,
            ],
            [
                'name' => 'Sri Lanka',
                'iso_code_2' => 'LK',
                'iso_code_3' => 'LKA',
                'numeric_code' => '144',
                'phone_code' => '+94',
                'capital' => 'Colombo',
                'currency_code' => 'LKR',
                'currency_name' => 'Sri Lankan Rupee',
                'currency_symbol' => 'Rs',
                'is_active' => false,
            ],
            [
                'name' => 'Nepal',
                'iso_code_2' => 'NP',
                'iso_code_3' => 'NPL',
                'numeric_code' => '524',
                'phone_code' => '+977',
                'capital' => 'Kathmandu',
                'currency_code' => 'NPR',
                'currency_name' => 'Nepalese Rupee',
                'currency_symbol' => 'Rs',
                'is_active' => false,
            ],
            [
                'name' => 'Bhutan',
                'iso_code_2' => 'BT',
                'iso_code_3' => 'BTN',
                'numeric_code' => '064',
                'phone_code' => '+975',
                'capital' => 'Thimphu',
                'currency_code' => 'BTN',
                'currency_name' => 'Bhutanese Ngultrum',
                'currency_symbol' => 'Nu.',
                'is_active' => false,
            ],
            [
                'name' => 'Maldives',
                'iso_code_2' => 'MV',
                'iso_code_3' => 'MDV',
                'numeric_code' => '462',
                'phone_code' => '+960',
                'capital' => 'Malé',
                'currency_code' => 'MVR',
                'currency_name' => 'Maldivian Rufiyaa',
                'currency_symbol' => 'Rf',
                'is_active' => false,
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
