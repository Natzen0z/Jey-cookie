<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $products = [
            // Cookies
            [
                'category' => 'Cookies',
                'name' => 'Chocolate Chip Cookies',
                'description' => 'Cookies klasik dengan potongan cokelat chip premium yang meleleh di mulut. Renyah di luar, lembut di dalam.',
                'price' => 45000,
                'stock' => 50,
                'weight' => 200,
                'is_featured' => true,
            ],
            [
                'category' => 'Cookies',
                'name' => 'Red Velvet Cookies',
                'description' => 'Cookies red velvet dengan cream cheese frosting yang lembut dan creamy.',
                'price' => 55000,
                'stock' => 30,
                'weight' => 200,
                'is_featured' => true,
            ],
            [
                'category' => 'Cookies',
                'name' => 'Oatmeal Raisin Cookies',
                'description' => 'Cookies sehat dengan oatmeal dan kismis premium. Cocok untuk pecinta rasa klasik.',
                'price' => 40000,
                'stock' => 40,
                'weight' => 200,
            ],
            [
                'category' => 'Cookies',
                'name' => 'Matcha White Chocolate Cookies',
                'description' => 'Perpaduan unik matcha Jepang dengan white chocolate yang creamy.',
                'price' => 60000,
                'stock' => 25,
                'weight' => 200,
                'is_featured' => true,
            ],

            // Cakes
            [
                'category' => 'Cakes',
                'name' => 'Chocolate Lava Cake',
                'description' => 'Kue cokelat dengan isian lava cokelat yang meleleh. Perfect untuk pecinta cokelat.',
                'price' => 85000,
                'stock' => 20,
                'weight' => 300,
                'is_featured' => true,
            ],
            [
                'category' => 'Cakes',
                'name' => 'Strawberry Shortcake',
                'description' => 'Cake lembut dengan lapisan krim dan strawberry segar. Manis dan menyegarkan.',
                'price' => 150000,
                'stock' => 15,
                'weight' => 500,
            ],
            [
                'category' => 'Cakes',
                'name' => 'Tiramisu Cake',
                'description' => 'Tiramisu klasik Italia dengan mascarpone cream dan espresso. Elegan dan lezat.',
                'price' => 175000,
                'stock' => 10,
                'weight' => 600,
            ],
            [
                'category' => 'Cakes',
                'name' => 'Cheesecake New York Style',
                'description' => 'Cheesecake creamy ala New York dengan base biscuit yang renyah.',
                'price' => 160000,
                'stock' => 12,
                'weight' => 500,
                'is_featured' => true,
            ],

            // Brownies
            [
                'category' => 'Brownies',
                'name' => 'Fudgy Chocolate Brownies',
                'description' => 'Brownies cokelat super fudgy dengan topping cokelat leleh.',
                'price' => 65000,
                'stock' => 30,
                'weight' => 300,
                'is_featured' => true,
            ],
            [
                'category' => 'Brownies',
                'name' => 'Salted Caramel Brownies',
                'description' => 'Brownies cokelat dengan drizzle salted caramel yang bikin nagih.',
                'price' => 75000,
                'stock' => 25,
                'weight' => 300,
            ],
            [
                'category' => 'Brownies',
                'name' => 'Nutella Swirl Brownies',
                'description' => 'Brownies dengan swirl Nutella yang melimpah. Favorit semua kalangan.',
                'price' => 70000,
                'stock' => 28,
                'weight' => 300,
            ],

            // Pastries
            [
                'category' => 'Pastries',
                'name' => 'Croissant Butter',
                'description' => 'Croissant klasik Perancis dengan lapisan yang berlapis-lapis dan renyah.',
                'price' => 25000,
                'stock' => 40,
                'weight' => 80,
            ],
            [
                'category' => 'Pastries',
                'name' => 'Pain au Chocolat',
                'description' => 'Croissant dengan isian cokelat premium. Perfect untuk sarapan.',
                'price' => 30000,
                'stock' => 35,
                'weight' => 100,
                'is_featured' => true,
            ],
            [
                'category' => 'Pastries',
                'name' => 'Danish Pastry',
                'description' => 'Danish pastry dengan topping buah-buahan segar dan cream cheese.',
                'price' => 35000,
                'stock' => 30,
                'weight' => 120,
            ],

            // Bread
            [
                'category' => 'Bread',
                'name' => 'Sourdough Bread',
                'description' => 'Roti sourdough artisan dengan crust yang renyah dan tekstur yang chewy.',
                'price' => 45000,
                'stock' => 20,
                'weight' => 400,
            ],
            [
                'category' => 'Bread',
                'name' => 'Brioche Bread',
                'description' => 'Roti brioche yang lembut dan butter-y. Perfect untuk toast atau sandwich.',
                'price' => 40000,
                'stock' => 25,
                'weight' => 350,
            ],
            [
                'category' => 'Bread',
                'name' => 'Cinnamon Roll',
                'description' => 'Cinnamon roll hangat dengan glazing yang manis. Comfort food terbaik.',
                'price' => 28000,
                'stock' => 35,
                'weight' => 150,
                'is_featured' => true,
            ],

            // Special
            [
                'category' => 'Special',
                'name' => 'Hampers Lebaran',
                'description' => 'Paket hampers spesial berisi aneka cookies dan pastry premium untuk Lebaran.',
                'price' => 350000,
                'stock' => 15,
                'weight' => 1500,
            ],
            [
                'category' => 'Special',
                'name' => 'Birthday Cake Custom',
                'description' => 'Kue ulang tahun custom dengan design sesuai keinginan Anda.',
                'price' => 300000,
                'stock' => 10,
                'weight' => 1000,
            ],
        ];

        foreach ($products as $product) {
            $categoryId = $categories[$product['category']] ?? null;
            
            if ($categoryId) {
                Product::create([
                    'category_id' => $categoryId,
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'weight' => $product['weight'] ?? null,
                    'is_active' => true,
                    'is_featured' => $product['is_featured'] ?? false,
                ]);
            }
        }
    }
}
