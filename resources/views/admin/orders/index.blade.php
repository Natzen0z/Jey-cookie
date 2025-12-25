@extends('admin.layout')

@section('title', 'Orders')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Order Management</h4>
        <p class="text-muted mb-0">View and manage customer orders</p>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search order/customer..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">All Payment</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-decoration-none">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td>
                            {{ $order->customer_name }}
                            <br>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                        </td>
                        <td>{{ $order->items->count() }} items</td>
                        <td class="fw-semibold">{{ $order->formatted_total }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $order->payment_badge_class }}">{{ ucfirst($order->payment_status) }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            No orders found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $orders->links() }}
</div>

@endsection
