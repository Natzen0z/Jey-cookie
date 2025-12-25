<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('warning', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        // Check if all items are in stock
        $outOfStock = $cartItems->filter(fn($item) => !$item['in_stock']);
        if ($outOfStock->isNotEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Beberapa produk di keranjang tidak tersedia. Silakan perbarui keranjang Anda.');
        }

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'totals', 'user'));
    }

    /**
     * Process the checkout and create order.
     */
    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_phone.required' => 'Nomor telepon wajib diisi.',
            'customer_address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        // Check stock availability again
        foreach ($cartItems as $item) {
            if (!$item['in_stock']) {
                return redirect()->route('cart.index')
                    ->with('error', "Produk {$item['name']} tidak tersedia dalam jumlah yang diminta.");
            }
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_PENDING,
                'subtotal' => $totals['subtotal'],
                'delivery_fee' => $totals['delivery_fee'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email ?? Auth::user()->email,
                'customer_address' => $request->customer_address,
                'payment_method' => 'qris',
                'payment_status' => Order::PAYMENT_UNPAID,
                'notes' => $request->notes,
            ]);

            // Create order items and decrease stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Decrease product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decreaseStock($item['quantity']);
                }
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            // Redirect to payment page
            return redirect()->route('checkout.payment', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Display the payment page with QRIS.
     */
    public function payment(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // If already paid, redirect to order detail
        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pesanan ini sudah dibayar.');
        }

        $order->load('items');

        return view('checkout.payment', compact('order'));
    }

    /**
     * Handle Midtrans payment notification (webhook).
     */
    public function notification(Request $request)
    {
        // This would handle Midtrans webhook notifications
        // For now, we'll implement manual confirmation

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            if ($fraudStatus === 'accept' || $fraudStatus === null) {
                $order->markAsPaid($request->input('transaction_id'));
            }
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire') {
            $order->update(['payment_status' => Order::PAYMENT_FAILED]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Confirm payment manually (for demo purposes).
     */
    public function confirmPayment(Request $request, Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pesanan sudah dibayar sebelumnya.');
        }

        // In real implementation, this would verify with Midtrans API
        // For now, we'll just mark as paid (for demo)
        $order->markAsPaid('MANUAL-' . time());

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda sedang diproses.');
    }

    /**
     * Get cart items with current product data.
     */
    private function getCartItems(array $cart)
    {
        if (empty($cart)) {
            return collect([]);
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return collect($cart)->map(function ($item, $productId) use ($products) {
            $product = $products->get($productId);
            
            return [
                'product_id' => $productId,
                'product' => $product,
                'name' => $product ? $product->name : $item['name'],
                'price' => $product ? $product->price : $item['price'],
                'image' => $product ? $product->image : $item['image'],
                'quantity' => $item['quantity'],
                'subtotal' => ($product ? $product->price : $item['price']) * $item['quantity'],
                'in_stock' => $product && $product->is_active && $product->stock >= $item['quantity'],
            ];
        });
    }

    /**
     * Calculate cart totals.
     */
    private function calculateTotals($cartItems): array
    {
        $subtotal = $cartItems->sum('subtotal');
        $deliveryFee = $subtotal > 0 ? 15000 : 0;
        $discount = 0;

        if ($subtotal >= 100000) {
            $deliveryFee = 0;
        }

        $total = $subtotal + $deliveryFee - $discount;

        return [
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'discount' => $discount,
            'total' => $total,
            'item_count' => $cartItems->sum('quantity'),
        ];
    }
}
