<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the homepage with categories and featured products.
     */
    public function index()
    {
        // Get active categories with product count
        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->get();

        // Get featured products (or latest active products if none featured)
        $featuredProducts = Product::with('category')
            ->active()
            ->inStock()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        // If no featured products, get latest active products
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with('category')
                ->active()
                ->inStock()
                ->latest()
                ->take(8)
                ->get();
        }

        return view('home', compact('categories', 'featuredProducts'));
    }
}
