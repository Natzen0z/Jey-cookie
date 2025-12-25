@extends('admin.layout')

@section('title', 'Order #' . $order->order_number)

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
        <i class="fa-solid fa-arrow-left me-2"></i> Back to Orders
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Order #{{ $order->order_number }}</h4>
    <div>
        <span class="badge bg-{{ $order->status }} fs-6">{{ ucfirst($order->status) }}</span>
        <span class="badge {{ $order->payment_badge_class }} fs-6">{{ ucfirst($order->payment_status) }}</span>
    </div>
</div>

<div class="row g-4">
    <!-- Order Details -->
    <div class="col-lg-8">
        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-user me-2"></i> Customer Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Name:</strong> {{ $order->customer_name }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-0"><strong>Address:</strong><br>{{ $order->customer_address }}</p>
                    </div>
                </div>
                @if($order->notes)
                    <hr>
                    <p class="mb-0"><strong>Notes:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-box me-2"></i> Order Items
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
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
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @endif
                                        {{ $item->product_name }}
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->formatted_price }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ $item->formatted_subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end">Subtotal</td>
                            <td class="text-end">{{ $order->formatted_subtotal }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Delivery Fee</td>
                            <td class="text-end">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</td>
                        </tr>
                        @if($order->discount > 0)
                            <tr>
                                <td colspan="3" class="text-end">Discount</td>
                                <td class="text-end text-success">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-end fw-bold fs-5">{{ $order->formatted_total }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Actions & Info -->
    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-edit me-2"></i> Update Status
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-save me-1"></i> Update Status
                    </button>
                </form>

                <hr>

                <form action="{{ route('admin.orders.payment', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa-solid fa-credit-card me-1"></i> Update Payment
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Info -->
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-info-circle me-2"></i> Order Info
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted">Order Date</td>
                        <td class="text-end">{{ $order->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Payment Method</td>
                        <td class="text-end text-uppercase">{{ $order->payment_method }}</td>
                    </tr>
                    @if($order->paid_at)
                        <tr>
                            <td class="text-muted">Paid At</td>
                            <td class="text-end">{{ $order->paid_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endif
                    @if($order->payment_reference)
                        <tr>
                            <td class="text-muted">Reference</td>
                            <td class="text-end"><code>{{ $order->payment_reference }}</code></td>
                        </tr>
                    @endif
                    @if($order->user)
                        <tr>
                            <td class="text-muted">User</td>
                            <td class="text-end">{{ $order->user->email }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
