# Requirements Traceability Matrix (RTM) - Toko Roti Jiya

## Functional Requirements

| Req ID | Requirement | Module | Test Case | Status |
|--------|-------------|--------|-----------|--------|
| FR001 | Admin dapat CRUD produk | AdminProductController | TC001-TC004 | ✅ Done |
| FR002 | Pelanggan dapat melihat katalog | ProductController | TC005 | ✅ Done |
| FR002 | Pelanggan dapat mengelola keranjang | CartController | TC006-TC008 | ✅ Done |
| FR002 | Pelanggan dapat checkout | CheckoutController | TC009-TC010 | ✅ Done |
| FR002 | Pembayaran via Midtrans | CheckoutController | TC011 | ✅ Done |
| FR003 | Pelanggan melacak pesanan | OrderController | TC012 | ✅ Done |
| FR003 | Admin ubah status pesanan | AdminOrderController | TC013-TC014 | ✅ Done |
| FR004 | User dapat register | AuthController | TC015 | ✅ Done |
| FR004 | User dapat login | AuthController | TC016 | ✅ Done |
| FR004 | User dapat logout | AuthController | TC017 | ✅ Done |
| FR005 | Admin lihat laporan | AdminDashboardController | TC018 | ✅ Done |

## Non-Functional Requirements

| Req ID | Requirement | Implementation | Status |
|--------|-------------|----------------|--------|
| NFR001 | Load < 3 detik | CDN, Cloudinary | ✅ Done |
| NFR002 | Password enkripsi | Hash::make() | ✅ Done |
| NFR002 | CSRF Protection | @csrf token | ✅ Done |
| NFR003 | Responsif | Bootstrap 5 | ✅ Done |
| NFR003 | Checkout 3 langkah | Cart→Form→Pay | ✅ Done |
| NFR004 | Handle 50 users | Laravel session | ✅ Ready |
| NFR005 | Laravel + MySQL | Laravel 10+ | ✅ Done |
| NFR006 | UI mudah | Indonesian labels | ✅ Done |
| NFR007 | Tabel jelas | Clear columns | ✅ Done |
| NFR008 | Fokus produk | Featured section | ✅ Done |

## Files Mapping

| Req ID | Files |
|--------|-------|
| FR001 | AdminProductController.php, Product.php, admin/products/*.blade.php |
| FR002 | ProductController.php, CartController.php, CheckoutController.php |
| FR003 | OrderController.php, AdminOrderController.php, Order.php |
| FR004 | AuthController.php, User.php, auth/*.blade.php |
| FR005 | AdminDashboardController.php, admin/dashboard.blade.php |
