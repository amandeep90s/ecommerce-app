<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Popular categories in Indian e-commerce market
        $categories = [
            // Fashion & Apparel
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing, footwear, and fashion accessories',
                'is_active' => true,
                'children' => [
                    ['name' => 'Men\'s Clothing', 'slug' => 'mens-clothing', 'description' => 'Men\'s apparel and accessories'],
                    ['name' => 'Women\'s Clothing', 'slug' => 'womens-clothing', 'description' => 'Women\'s apparel and accessories'],
                    ['name' => 'Kids\' Clothing', 'slug' => 'kids-clothing', 'description' => 'Children\'s apparel and accessories'],
                    ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Shoes, sandals, and slippers'],
                    ['name' => 'Ethnic Wear', 'slug' => 'ethnic-wear', 'description' => 'Traditional Indian clothing'],
                    ['name' => 'Accessories', 'slug' => 'fashion-accessories', 'description' => 'Bags, belts, jewelry, and more'],
                ],
            ],

            // Electronics
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
                'children' => [
                    ['name' => 'Smartphones', 'slug' => 'smartphones', 'description' => 'Mobile phones and accessories'],
                    ['name' => 'Laptops', 'slug' => 'laptops', 'description' => 'Laptops and notebook computers'],
                    ['name' => 'Tablets', 'slug' => 'tablets', 'description' => 'Tablets and e-readers'],
                    ['name' => 'Audio & Headphones', 'slug' => 'audio-headphones', 'description' => 'Speakers, headphones, and audio accessories'],
                    ['name' => 'Cameras', 'slug' => 'cameras', 'description' => 'Digital cameras and accessories'],
                    ['name' => 'Gaming', 'slug' => 'gaming', 'description' => 'Gaming consoles and accessories'],
                ],
            ],

            // Home & Kitchen
            [
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'description' => 'Home appliances and kitchen essentials',
                'is_active' => true,
                'children' => [
                    ['name' => 'Kitchen Appliances', 'slug' => 'kitchen-appliances', 'description' => 'Mixers, grinders, and kitchen gadgets'],
                    ['name' => 'Home Appliances', 'slug' => 'home-appliances', 'description' => 'ACs, refrigerators, washing machines'],
                    ['name' => 'Furniture', 'slug' => 'furniture', 'description' => 'Sofas, beds, tables, and chairs'],
                    ['name' => 'Home Decor', 'slug' => 'home-decor', 'description' => 'Decorative items and home accessories'],
                    ['name' => 'Cookware', 'slug' => 'cookware', 'description' => 'Pots, pans, and cooking utensils'],
                ],
            ],

            // Health & Beauty
            [
                'name' => 'Health & Beauty',
                'slug' => 'health-beauty',
                'description' => 'Health, beauty, and personal care products',
                'is_active' => true,
                'children' => [
                    ['name' => 'Skincare', 'slug' => 'skincare', 'description' => 'Face care and skincare products'],
                    ['name' => 'Makeup', 'slug' => 'makeup', 'description' => 'Cosmetics and makeup products'],
                    ['name' => 'Personal Care', 'slug' => 'personal-care', 'description' => 'Bath, body, and personal hygiene'],
                    ['name' => 'Health Supplements', 'slug' => 'health-supplements', 'description' => 'Vitamins and health supplements'],
                    ['name' => 'Ayurveda', 'slug' => 'ayurveda', 'description' => 'Ayurvedic and herbal products'],
                ],
            ],

            // Sports & Fitness
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Sports equipment and fitness accessories',
                'is_active' => true,
                'children' => [
                    ['name' => 'Cricket', 'slug' => 'cricket', 'description' => 'Cricket equipment and accessories'],
                    ['name' => 'Fitness Equipment', 'slug' => 'fitness-equipment', 'description' => 'Gym and fitness accessories'],
                    ['name' => 'Yoga', 'slug' => 'yoga', 'description' => 'Yoga mats and accessories'],
                    ['name' => 'Outdoor Sports', 'slug' => 'outdoor-sports', 'description' => 'Outdoor games and sports equipment'],
                ],
            ],

            // Books & Media
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, movies, and educational content',
                'is_active' => true,
                'children' => [
                    ['name' => 'Academic Books', 'slug' => 'academic-books', 'description' => 'Educational and academic books'],
                    ['name' => 'Fiction', 'slug' => 'fiction', 'description' => 'Novels and fiction books'],
                    ['name' => 'Non-Fiction', 'slug' => 'non-fiction', 'description' => 'Non-fiction and informational books'],
                    ['name' => 'Regional Literature', 'slug' => 'regional-literature', 'description' => 'Books in regional Indian languages'],
                ],
            ],

            // Grocery & Food
            [
                'name' => 'Grocery & Food',
                'slug' => 'grocery-food',
                'description' => 'Food items and grocery essentials',
                'is_active' => true,
                'children' => [
                    ['name' => 'Staples', 'slug' => 'staples', 'description' => 'Rice, wheat, and basic food items'],
                    ['name' => 'Snacks', 'slug' => 'snacks', 'description' => 'Namkeen, biscuits, and snacks'],
                    ['name' => 'Spices & Condiments', 'slug' => 'spices-condiments', 'description' => 'Indian spices and condiments'],
                    ['name' => 'Beverages', 'slug' => 'beverages', 'description' => 'Tea, coffee, and drinks'],
                    ['name' => 'Organic Foods', 'slug' => 'organic-foods', 'description' => 'Organic and natural food products'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $parentCategory = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $parentCategory->id;
                $childData['is_active'] = true;
                Category::create($childData);
            }
        }
    }
}
