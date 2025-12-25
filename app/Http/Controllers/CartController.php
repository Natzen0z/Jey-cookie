<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        return view('cart.index', compact('cartItems', 'totals'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        // Check if product is active and in stock
        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cart = $this->getCart();
        $productId = (string) $product->id;

        // If product already in cart, update quantity
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            
            // Check stock for new quantity
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok produk tidak mencukupi untuk jumlah yang diminta.');
            }
            
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            // Add new item to cart
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        $this->saveCart($cart);

        return back()->with('success', "{$product->name} ditambahkan ke keranjang!");
    }

    /**
     * Update item quantity in cart.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = $this->getCart();
        $productId = (string) $id;

        if (!isset($cart[$productId])) {
            return back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        // Check if product still exists and has enough stock
        $product = Product::find($id);
        if (!$product) {
            unset($cart[$productId]);
            $this->saveCart($cart);
            return back()->with('error', 'Produk tidak lagi tersedia.');
        }

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cart[$productId]['quantity'] = $request->quantity;
        $this->saveCart($cart);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cart = $this->getCart();
        $productId = (string) $id;

        if (isset($cart[$productId])) {
            $name = $cart[$productId]['name'];
            unset($cart[$productId]);
            $this->saveCart($cart);
            return back()->with('success', "{$name} dihapus dari keranjang.");
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Get cart from session.
     */
    private function getCart(): array
    {
        return session('cart', []);
    }

    /**
     * Save cart to session.
     */
    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    /**
     * Get cart items with current product data.
     */
    private function getCartItems(array $cart): Collection
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
    private function calculateTotals(Collection $cartItems): array
    {
        $subtotal = $cartItems->sum('subtotal');
        $deliveryFee = $subtotal > 0 ? 15000 : 0; // Fixed delivery fee
        $discount = 0;

        // Free delivery for orders over 100k
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
