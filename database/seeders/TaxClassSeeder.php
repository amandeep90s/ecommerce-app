<?php

namespace Database\Seeders;

use App\Models\TaxClass;
use Illuminate\Database\Seeder;

class TaxClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxClasses = [
            [
                'name' => 'GST 0%',
                'description' => 'Zero rated goods (Essential items like basic food grains, milk, etc.)',
                'is_active' => true,
            ],
            [
                'name' => 'GST 5%',
                'description' => 'Low rate goods (Essential items like packaged food items, tea, coffee, etc.)',
                'is_active' => true,
            ],
            [
                'name' => 'GST 12%',
                'description' => 'Standard rate goods (Processed food, mobile phones, etc.)',
                'is_active' => true,
            ],
            [
                'name' => 'GST 18%',
                'description' => 'Standard rate goods (Most goods and services)',
                'is_active' => true,
            ],
            [
                'name' => 'GST 28%',
                'description' => 'Luxury goods and sin goods (Cars, luxury items, tobacco, etc.)',
                'is_active' => true,
            ],
            [
                'name' => 'IGST 18%',
                'description' => 'Integrated GST for inter-state transactions',
                'is_active' => true,
            ],
            [
                'name' => 'Tax Free',
                'description' => 'Exempt from all taxes',
                'is_active' => true,
            ],
        ];

        foreach ($taxClasses as $taxClass) {
            TaxClass::create($taxClass);
        }
    }
}
