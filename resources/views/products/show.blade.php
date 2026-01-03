@extends('layouts.app')

@section('title', $product->name)

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        @if($product->category)
            <li class="breadcrumb-item">
                <a href="{{ route('products.category', $product->category) }}">{{ $product->category->name }}</a>
            </li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row g-4">
    <!-- Product Image -->
    <div class="col-lg-5">
        <div class="product-detail-image">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded-4 shadow">
            @else
                <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=600&h=600&fit=crop" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded-4 shadow">
            @endif
        </div>
    </div>

    <!-- Product Info -->
    <div class="col-lg-7">
        <div class="product-detail-info">
            @if($product->category)
                <a href="{{ route('products.category', $product->category) }}" 
                   class="badge bg-pink-50 text-pink text-decoration-none mb-2">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
            
            <!-- Rating (placeholder) -->
            <div class="mb-3">
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star-half-stroke text-warning"></i>
                <span class="text-muted ms-2">(4.5) • 50+ terjual</span>
            </div>

            <div class="price-box mb-4">
                <span class="display-6 fw-bold text-pink">{{ $product->formatted_price }}</span>
            </div>

            <!-- Stock Status -->
            <div class="mb-4">
                @if($product->stock == 0)
                    <span class="badge bg-danger fs-6">
                        <i class="fa-solid fa-times-circle me-1"></i> Stok Habis
                    </span>
                @elseif($product->isLowStock())
                    <span class="badge bg-warning fs-6">
                        <i class="fa-solid fa-exclamation-triangle me-1"></i> Sisa {{ $product->stock }} item
                    </span>
                @else
                    <span class="badge bg-success fs-6">
                        <i class="fa-solid fa-check-circle me-1"></i> Stok Tersedia
                    </span>
                @endif
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="mb-4">
                    <h6 class="fw-semibold">Deskripsi</h6>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Weight if available -->
            @if($product->weight)
                <div class="mb-4">
                    <p class="text-muted">
                        <i class="fa-solid fa-weight-hanging me-2"></i> 
                        Berat: {{ number_format($product->weight, 0) }} gram
                    </p>
                </div>
            @endif

            <!-- Add to Cart Form -->
            @if($product->isInStock())
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="row g-3 align-items-end">
                        <div class="col-auto">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <div class="input-group" style="width: 140px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" 
                                       class="form-control text-center" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-pink btn-lg w-100">
                                <i class="fa-solid fa-cart-plus me-2"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-warning">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    Produk ini sedang tidak tersedia. Silakan cek kembali nanti.
                </div>
            @endif

            <!-- Quick Info -->
            <div class="row g-3 mt-2">
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <i class="fa-solid fa-truck me-2 text-pink"></i>
                        <small>Pengiriman cepat</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <i class="fa-solid fa-shield-halved me-2 text-pink"></i>
                        <small>Garansi kualitas</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <i class="fa-solid fa-cookie-bite me-2 text-pink"></i>
                        <small>Fresh baked daily</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <i class="fa-solid fa-box me-2 text-pink"></i>
                        <small>Packaging aman</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->isNotEmpty())
    <section class="mt-5">
        <h3 class="fw-bold mb-4">Produk Serupa</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="product-card h-100">
                        <a href="{{ route('products.show', $related) }}" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                @if($related->image_url)
                                    <img src="{{ $related->image_url }}" 
                                         alt="{{ $related->name }}" 
                                         class="product-image"
                                         loading="lazy">
                                @else
                                    <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=300&h=300&fit=crop" 
                                         alt="{{ $related->name }}" 
                                         class="product-image">
                                @endif
                            </div>
                        </a>
                        <div class="product-info">
                            <span class="product-category">{{ $related->category->name ?? '' }}</span>
                            <a href="{{ route('products.show', $related) }}" class="text-decoration-none">
                                <h6 class="product-title">{{ $related->name }}</h6>
                            </a>
                            <span class="product-price">{{ $related->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
    const maxStock = {{ $product->stock }};
    
    function decreaseQty() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }
    
    function increaseQty() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value);
        if (value < maxStock) {
            input.value = value + 1;
        }
    }
</script>
@endpush

@push('styles')
<style>
    .product-detail-image img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
    }
    
    .price-box {
        background: linear-gradient(135deg, var(--pink-50), var(--peach-50));
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        display: inline-block;
    }
    
    .text-pink {
        color: var(--pink-600);
    }
    
    .bg-pink-50 {
        background: var(--pink-50);
    }
</style>
@endpush
