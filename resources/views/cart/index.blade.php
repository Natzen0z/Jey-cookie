@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

<h1 class="fw-bold text-gradient mb-4">
    <i class="fa-solid fa-shopping-cart me-2"></i> Keranjang Belanja
</h1>

@if($cartItems->isEmpty())
    <div class="text-center py-5">
        <div class="mb-3" style="font-size: 5rem;">🛒</div>
        <h3 class="text-muted">Keranjang Anda Kosong</h3>
        <p class="text-muted mb-4">Yuk, mulai belanja produk favorit Anda!</p>
        <a href="{{ route('products.index') }}" class="btn btn-pink btn-lg">
            <i class="fa-solid fa-shopping-bag me-2"></i> Mulai Belanja
        </a>
    </div>
@else
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fa-solid fa-box me-2"></i>
                        {{ $totals['item_count'] }} Item
                    </span>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('Kosongkan keranjang?')">
                            <i class="fa-solid fa-trash me-1"></i> Kosongkan
                        </button>
                    </form>
                </div>
                <div class="card-body p-0">
                    @foreach($cartItems as $item)
                        <div class="cart-item-row d-flex align-items-center p-3 border-bottom {{ !$item['in_stock'] ? 'bg-light' : '' }}">
                            <!-- Product Image -->
                            <div class="cart-item-image me-3">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="rounded" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=100&h=100&fit=crop" 
                                         alt="{{ $item['name'] }}" 
                                         class="rounded"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="cart-item-info flex-grow-1">
                                <h6 class="mb-1 fw-semibold">
                                    @if($item['product'])
                                        <a href="{{ route('products.show', $item['product']) }}" class="text-decoration-none text-dark">
                                            {{ $item['name'] }}
                                        </a>
                                    @else
                                        {{ $item['name'] }}
                                    @endif
                                </h6>
                                <p class="text-pink fw-bold mb-1">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </p>
                                @if(!$item['in_stock'])
                                    <span class="badge bg-danger">Stok tidak tersedia</span>
                                @endif
                            </div>
                            
                            <!-- Quantity -->
                            <div class="cart-item-quantity me-3">
                                <form action="{{ route('cart.update', $item['product_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm" style="width: 120px;">
                                        <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center" value="{{ $item['quantity'] }}" readonly>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="cart-item-subtotal text-end me-3" style="min-width: 100px;">
                                <span class="fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            
                            <!-- Remove -->
                            <div class="cart-item-remove">
                                <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <a href="{{ route('products.index') }}" class="btn btn-outline-pink mt-3">
                <i class="fa-solid fa-arrow-left me-2"></i> Lanjut Belanja
            </a>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="checkout-summary">
                <h5 class="fw-bold mb-4">
                    <i class="fa-solid fa-receipt me-2"></i> Ringkasan Pesanan
                </h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal ({{ $totals['item_count'] }} item)</span>
                    <span>Rp {{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ongkos Kirim</span>
                    @if($totals['delivery_fee'] == 0)
                        <span class="text-success fw-semibold">GRATIS</span>
                    @else
                        <span>Rp {{ number_format($totals['delivery_fee'], 0, ',', '.') }}</span>
                    @endif
                </div>

                @if($totals['subtotal'] > 0 && $totals['subtotal'] < 100000)
                    <div class="alert alert-info py-2 small">
                        <i class="fa-solid fa-info-circle me-1"></i>
                        Belanja Rp {{ number_format(100000 - $totals['subtotal'], 0, ',', '.') }} lagi untuk gratis ongkir!
                    </div>
                @endif
                
                <hr>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5 text-pink">Rp {{ number_format($totals['total'], 0, ',', '.') }}</span>
                </div>
                
                @auth
                    @php
                        $hasOutOfStock = $cartItems->contains(fn($item) => !$item['in_stock']);
                    @endphp
                    
                    @if($hasOutOfStock)
                        <div class="alert alert-warning">
                            <i class="fa-solid fa-exclamation-triangle me-1"></i>
                            Beberapa produk tidak tersedia. Hapus produk tersebut untuk melanjutkan.
                        </div>
                    @else
                        <a href="{{ route('checkout.index') }}" class="btn btn-pink btn-lg w-100">
                            <i class="fa-solid fa-credit-card me-2"></i> Checkout
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-pink btn-lg w-100">
                        <i class="fa-solid fa-sign-in-alt me-2"></i> Login untuk Checkout
                    </a>
                    <p class="text-center text-muted small mt-2">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                    </p>
                @endauth
            </div>
        </div>
    </div>
@endif

@endsection

@push('styles')
<style>
    .cart-item-row:last-child {
        border-bottom: none !important;
    }
    
    .text-pink {
        color: var(--pink-600);
    }
</style>
@endpush
