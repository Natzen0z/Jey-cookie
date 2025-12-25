@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Products')

@section('content')

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold text-gradient">
            @if(isset($category))
                {{ $category->name }}
            @else
                Semua Produk
            @endif
        </h1>
        <p class="text-muted mb-0">
            @if(isset($category))
                Produk dalam kategori {{ $category->name }}
            @else
                Temukan produk bakery favorit Anda
            @endif
        </p>
    </div>
</div>

<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-lg-3 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-filter me-2"></i> Filter
            </div>
            <div class="card-body">
                <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cari Produk</label>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Nama produk..."
                               value="{{ request('search') }}">
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutkan</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-pink">
                            <i class="fa-solid fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-times me-1"></i> Reset Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories Quick Links -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fa-solid fa-tags me-2"></i> Kategori
            </div>
            <div class="list-group list-group-flush">
                @foreach($categories as $cat)
                    <a href="{{ route('products.category', $cat) }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                        <span class="badge bg-pink-50 text-pink rounded-pill">
                            {{ $cat->products_count ?? $cat->products()->active()->count() }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="col-lg-9">
        @if($products->isEmpty())
            <div class="text-center py-5">
                <div class="mb-3" style="font-size: 4rem;">🔍</div>
                <h4 class="text-muted">Tidak ada produk ditemukan</h4>
                <p class="text-muted">Coba gunakan kata kunci lain atau reset filter</p>
                <a href="{{ route('products.index') }}" class="btn btn-pink">
                    Lihat Semua Produk
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-6 col-md-4">
                        <div class="product-card h-100">
                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                <div class="product-image-wrapper">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="product-image">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=300&h=300&fit=crop" 
                                             alt="{{ $product->name }}" 
                                             class="product-image">
                                    @endif
                                    
                                    @if($product->is_featured)
                                        <span class="product-badge bg-warning">
                                            <i class="fa-solid fa-star"></i> Featured
                                        </span>
                                    @elseif($product->stock == 0)
                                        <span class="product-badge bg-danger">Habis</span>
                                    @elseif($product->isLowStock())
                                        <span class="product-badge bg-warning">Sisa {{ $product->stock }}</span>
                                    @endif
                                </div>
                            </a>
                            
                            <div class="product-info">
                                <span class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                    <h6 class="product-title">{{ $product->name }}</h6>
                                </a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price">{{ $product->formatted_price }}</span>
                                    @if($product->isInStock())
                                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-sm btn-pink" title="Tambah ke Keranjang">
                                                <i class="fa-solid fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-secondary">Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
