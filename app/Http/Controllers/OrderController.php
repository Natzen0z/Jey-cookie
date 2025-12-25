<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        $orders = Order::forUser(Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure user owns this order (or is admin)
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if order can be cancelled
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        $order->cancel();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
