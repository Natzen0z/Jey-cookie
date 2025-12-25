<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cookies',
                'description' => 'Aneka cookies lezat dengan berbagai rasa dan bentuk yang menggugah selera.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Cakes',
                'description' => 'Kue ulang tahun dan kue spesial untuk berbagai acara istimewa Anda.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Brownies',
                'description' => 'Brownies cokelat yang lembut dan fudgy dengan berbagai topping.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Pastries',
                'description' => 'Pastry segar dan renyah dengan isian yang beragam.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Bread',
                'description' => 'Roti segar yang dipanggang setiap hari dengan bahan berkualitas.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Special',
                'description' => 'Menu spesial dan limited edition untuk Anda yang suka mencoba hal baru.',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
