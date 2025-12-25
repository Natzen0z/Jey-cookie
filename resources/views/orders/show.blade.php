@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold">Pesanan #{{ $order->order_number }}</h1>
    <div>
        <span class="badge {{ $order->status_badge_class }} fs-6">{{ ucfirst($order->status) }}</span>
        <span class="badge {{ $order->payment_badge_class }} fs-6">{{ ucfirst($order->payment_status) }}</span>
    </div>
</div>

<div class="row g-4">
    <!-- Order Info -->
    <div class="col-lg-8">
        <!-- Status Timeline -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-timeline me-2"></i> Status Pesanan
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between text-center">
                    @php
                        $statusOrder = ['pending', 'paid', 'processing', 'shipped', 'completed'];
                        $currentIndex = array_search($order->status, $statusOrder);
                        if ($order->status === 'cancelled') $currentIndex = -1;
                    @endphp
                    
                    @foreach(['Pending', 'Paid', 'Processing', 'Shipped', 'Completed'] as $index => $status)
                        <div class="status-step {{ $index <= $currentIndex ? 'active' : '' }}">
                            <div class="status-icon">
                                @if($index <= $currentIndex)
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <i class="fa-solid fa-circle"></i>
                                @endif
                            </div>
                            <small>{{ $status }}</small>
                        </div>
                    @endforeach
                </div>
                
                @if($order->status === 'cancelled')
                    <div class="alert alert-danger mt-3 mb-0">
                        <i class="fa-solid fa-times-circle me-2"></i>
                        Pesanan ini telah dibatalkan.
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-box me-2"></i> Item Pesanan
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product_name }}"
                                                 class="rounded me-2"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <span class="fw-semibold">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->formatted_price }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end fw-semibold">{{ $item->formatted_subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-truck me-2"></i> Alamat Pengiriman
            </div>
            <div class="card-body">
                <p class="fw-bold mb-1">{{ $order->customer_name }}</p>
                <p class="text-muted mb-1">{{ $order->customer_phone }}</p>
                <p class="text-muted mb-0">{{ $order->customer_address }}</p>
                
                @if($order->notes)
                    <hr>
                    <p class="mb-0"><strong>Catatan:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="col-lg-4">
        <div class="checkout-summary">
            <h5 class="fw-bold mb-4">
                <i class="fa-solid fa-receipt me-2"></i> Ringkasan
            </h5>
            
            <table class="table table-borderless">
                <tr>
                    <td class="text-muted">No. Pesanan</td>
                    <td class="text-end fw-semibold">{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Tanggal</td>
                    <td class="text-end">{{ $order->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Metode Pembayaran</td>
                    <td class="text-end text-uppercase">{{ $order->payment_method }}</td>
                </tr>
                @if($order->paid_at)
                    <tr>
                        <td class="text-muted">Dibayar</td>
                        <td class="text-end">{{ $order->paid_at->format('d M Y, H:i') }}</td>
                    </tr>
                @endif
            </table>
            
            <hr>
            
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Subtotal</span>
                <span>{{ $order->formatted_subtotal }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Ongkir</span>
                <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Diskon</span>
                    <span class="text-success">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
            @endif
            
            <hr>
            
            <div class="d-flex justify-content-between mb-4">
                <span class="fw-bold fs-5">Total</span>
                <span class="fw-bold fs-4 text-pink">{{ $order->formatted_total }}</span>
            </div>

            @if($order->status === 'pending' && $order->payment_status === 'unpaid')
                <a href="{{ route('checkout.payment', $order) }}" class="btn btn-pink btn-lg w-100 mb-2">
                    <i class="fa-solid fa-credit-card me-2"></i> Bayar Sekarang
                </a>
                
                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100" 
                            onclick="return confirm('Batalkan pesanan ini?')">
                        <i class="fa-solid fa-times me-2"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
        
        <a href="{{ route('orders.index') }}" class="btn btn-outline-pink w-100 mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Pesanan
        </a>
    </div>
</div>

@endsection

@push('styles')
<style>
    .text-pink {
        color: var(--pink-600);
    }
    
    .status-step {
        flex: 1;
        position: relative;
    }
    
    .status-step::after {
        content: '';
        position: absolute;
        top: 15px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: var(--gray-200);
        z-index: 0;
    }
    
    .status-step:last-child::after {
        display: none;
    }
    
    .status-step.active::after {
        background: var(--pink-500);
    }
    
    .status-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--gray-200);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    
    .status-step.active .status-icon {
        background: var(--pink-500);
    }
</style>
@endpush
