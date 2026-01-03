@extends('admin.layout')

@section('title', 'Products')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Product Management</h4>
        <p class="text-muted mb-0">Manage your bakery products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-pink">
        <i class="fa-solid fa-plus me-2"></i> Add Product
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 60px;">Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image_url)
                        <img src="{{ $product->thumbnail_url ?? $product->image_url }}"
                            alt="{{ $product->name }}"
                            class="rounded"
                            style="width: 50px; height: 50px; object-fit: cover;"
                            loading="lazy">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-image text-muted"></i>
                        </div>
                        @endif
                    </td>
                    <td>
                        <span class="fw-semibold">{{ $product->name }}</span>
                        @if($product->is_featured)
                        <span class="badge bg-warning ms-1">Featured</span>
                        @endif
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->formatted_price }}</td>
                    <td>
                        @if($product->stock == 0)
                        <span class="badge bg-danger">Out of Stock</span>
                        @elseif($product->stock < 5)
                            <span class="badge bg-warning">{{ $product->stock }}</span>
                            @else
                            <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                    </td>
                    <td>
                        @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete this product?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        No products found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>

@endsection