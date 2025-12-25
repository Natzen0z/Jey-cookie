<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        $statuses = Order::getStatuses();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        $statuses = Order::getStatuses();
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Update order status.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::getStatuses())),
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // If cancelling, restore stock
        if ($newStatus === Order::STATUS_CANCELLED && $oldStatus !== Order::STATUS_CANCELLED) {
            $order->cancel();
            return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Update payment status manually.
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,pending,paid,failed,refunded',
        ]);

        $updates = ['payment_status' => $request->payment_status];

        if ($request->payment_status === Order::PAYMENT_PAID) {
            $updates['paid_at'] = now();
            $updates['payment_reference'] = 'ADMIN-' . time();
            
            // Also update order status to paid
            if ($order->status === Order::STATUS_PENDING) {
                $updates['status'] = Order::STATUS_PAID;
            }
        }

        $order->update($updates);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
