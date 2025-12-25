<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->byCategory($category->id);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display products by category.
     */
    public function byCategory(Category $category)
    {
        $products = Product::with('category')
            ->active()
            ->byCategory($category->id)
            ->latest()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();

        return view('products.index', compact('products', 'categories', 'category'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Ensure product is active
        if (!$product->is_active) {
            abort(404);
        }

        // Load category relationship
        $product->load('category');

        // Get related products from the same category
        $relatedProducts = Product::with('category')
            ->active()
            ->inStock()
            ->byCategory($product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
