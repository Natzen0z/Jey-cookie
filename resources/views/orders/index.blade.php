@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<h1 class="fw-bold text-gradient mb-4">
    <i class="fa-solid fa-box me-2"></i> Pesanan Saya
</h1>

@if($orders->isEmpty())
    <div class="text-center py-5">
        <div class="mb-3" style="font-size: 5rem;">📦</div>
        <h3 class="text-muted">Belum Ada Pesanan</h3>
        <p class="text-muted mb-4">Anda belum memiliki pesanan. Yuk mulai belanja!</p>
        <a href="{{ route('products.index') }}" class="btn btn-pink btn-lg">
            <i class="fa-solid fa-shopping-bag me-2"></i> Mulai Belanja
        </a>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <span class="fw-semibold">{{ $order->order_number }}</span>
                            <br>
                            <small class="text-muted">{{ $order->items->count() }} item</small>
                        </td>
                        <td>
                            {{ $order->created_at->format('d M Y') }}
                            <br>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </td>
                        <td class="fw-bold text-pink">{{ $order->formatted_total }}</td>
                        <td>
                            <span class="badge {{ $order->status_badge_class }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $order->payment_badge_class }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-pink">
                                <i class="fa-solid fa-eye me-1"></i> Detail
                            </a>
                            @if($order->status === 'pending' && $order->payment_status === 'unpaid')
                                <a href="{{ route('checkout.payment', $order) }}" class="btn btn-sm btn-pink">
                                    <i class="fa-solid fa-credit-card me-1"></i> Bayar
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
@endif

@endsection

@push('styles')
<style>
    .text-pink {
        color: var(--pink-600);
    }
</style>
@endpush
