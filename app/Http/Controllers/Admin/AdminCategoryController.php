<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::withCount('products')
            ->ordered()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure unique slug
        $count = 1;
        $originalSlug = $validated['slug'];
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        // Handle image upload to Cloudinary
        if ($request->hasFile('image')) {
            $cloudinary = app(CloudinaryService::class);
            $result = $cloudinary->upload($request->file('image'), 'categories');
            $validated['image'] = $result['public_id'];
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Update slug if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            $count = 1;
            $originalSlug = $validated['slug'];
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        // Handle image upload to Cloudinary
        if ($request->hasFile('image')) {
            $cloudinary = app(CloudinaryService::class);
            
            // Delete old image
            if ($category->image && $cloudinary->isCloudinaryImage($category->image)) {
                $cloudinary->delete($category->image);
            } elseif ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $result = $cloudinary->upload($request->file('image'), 'categories');
            $validated['image'] = $result['public_id'];
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        // Delete image from Cloudinary or local storage
        if ($category->image) {
            $cloudinary = app(CloudinaryService::class);
            
            if ($cloudinary->isCloudinaryImage($category->image)) {
                $cloudinary->delete($category->image);
            } else {
                Storage::disk('public')->delete($category->image);
            }
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
