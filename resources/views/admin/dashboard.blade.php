@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $stats['total_products'] }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="stat-icon bg-pink-50">
                    <i class="fa-solid fa-box text-pink"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $stats['total_orders'] }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-icon bg-blue-50">
                    <i class="fa-solid fa-shopping-cart text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $stats['pending_orders'] }}</h3>
                    <p>Pending Orders</p>
                </div>
                <div class="stat-icon bg-warning-50">
                    <i class="fa-solid fa-clock text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="stat-icon bg-success-50">
                    <i class="fa-solid fa-money-bill-wave text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-shopping-cart me-2"></i> Recent Orders</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentOrders->isEmpty())
                    <div class="text-center py-4 text-muted">
                        No orders yet
                    </div>
                @else
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-decoration-none">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->formatted_total }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-exclamation-triangle text-warning me-2"></i> Low Stock Alert
            </div>
            <div class="card-body p-0">
                @if($lowStockProducts->isEmpty())
                    <div class="text-center py-4 text-muted">
                        All products have sufficient stock
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($lowStockProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-semibold">{{ $product->name }}</span>
                                    <br>
                                    <small class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</small>
                                </div>
                                <span class="badge bg-warning">{{ $product->stock }} left</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fa-solid fa-bolt me-2"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-pink">
                        <i class="fa-solid fa-plus me-2"></i> Add New Product
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fa-solid fa-plus me-2"></i> Add Category
                    </a>
                    <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-outline-warning">
                        <i class="fa-solid fa-clock me-2"></i> View Pending Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .text-pink { color: #ec4899; }
    .bg-pink-50 { background: #fdf2f8; }
    .bg-blue-50 { background: #eff6ff; }
    .bg-warning-50 { background: #fffbeb; }
    .bg-success-50 { background: #f0fdf4; }
</style>
@endpush
