# Test Cases - Toko Roti Jiya

## Product Management (FR001)

| TC ID | Test Case | Steps | Expected Result | Status |
|-------|-----------|-------|-----------------|--------|
| TC001 | Create Product | 1. Login admin 2. Klik Products → Add 3. Isi form 4. Klik Save | Produk tersimpan, redirect ke list | ✅ Pass |
| TC002 | Read Product | 1. Login admin 2. Klik Products | Daftar produk tampil dengan pagination | ✅ Pass |
| TC003 | Update Product | 1. Login admin 2. Klik Edit produk 3. Ubah data 4. Klik Update | Produk terupdate | ✅ Pass |
| TC004 | Delete Product | 1. Login admin 2. Klik Delete 3. Konfirmasi | Produk terhapus | ✅ Pass |

## Shopping (FR002)

| TC ID | Test Case | Steps | Expected Result | Status |
|-------|-----------|-------|-----------------|--------|
| TC005 | View Catalog | 1. Buka halaman Products | Produk tampil dengan kategori | ✅ Pass |
| TC006 | Add to Cart | 1. Klik Add to Cart | Produk masuk keranjang, badge update | ✅ Pass |
| TC007 | Update Cart | 1. Ubah quantity di cart | Total terupdate | ✅ Pass |
| TC008 | Remove from Cart | 1. Klik Remove item | Item terhapus dari cart | ✅ Pass |
| TC009 | Guest Checkout | 1. Isi form guest 2. Klik checkout | Order dibuat dengan user_id=null | ✅ Pass |
| TC010 | Login Checkout | 1. Login 2. Checkout | Order dibuat dengan user_id | ✅ Pass |
| TC011 | Midtrans Payment | 1. Checkout 2. Pilih payment 3. Bayar | Status = paid, email terkirim | ✅ Pass |

## Order Management (FR003)

| TC ID | Test Case | Steps | Expected Result | Status |
|-------|-----------|-------|-----------------|--------|
| TC012 | View Order History | 1. Login 2. Klik My Orders | Daftar order user tampil | ✅ Pass |
| TC013 | Admin View Orders | 1. Login admin 2. Klik Orders | Semua order tampil | ✅ Pass |
| TC014 | Update Order Status | 1. Admin pilih order 2. Ubah status 3. Save | Status terupdate | ✅ Pass |

## Authentication (FR004)

| TC ID | Test Case | Steps | Expected Result | Status |
|-------|-----------|-------|-----------------|--------|
| TC015 | Register | 1. Isi form register 2. Submit | User tersimpan, auto login | ✅ Pass |
| TC016 | Login | 1. Isi email & password 2. Submit | Login berhasil, redirect home | ✅ Pass |
| TC017 | Logout | 1. Klik Logout | Session dihapus, redirect home | ✅ Pass |

## Admin Dashboard (FR005)

| TC ID | Test Case | Steps | Expected Result | Status |
|-------|-----------|-------|-----------------|--------|
| TC018 | View Dashboard | 1. Login admin 2. Klik Dashboard | Statistik tampil (revenue, orders, products) | ✅ Pass |

## Non-Functional

| TC ID | Test Case | Steps | Expected Result | Status |
|-------|-----------|-------|-----------------|--------|
| TC019 | Page Load Time | 1. Buka halaman home | Load < 3 detik | ✅ Pass |
| TC020 | Password Encrypted | 1. Check database | Password ter-hash | ✅ Pass |
| TC021 | CSRF Token | 1. Submit form tanpa token | Request ditolak (419) | ✅ Pass |
| TC022 | Responsive Mobile | 1. Buka di mobile | Layout menyesuaikan | ✅ Pass |
| TC023 | Checkout Steps | 1. Hitung langkah checkout | Max 3 langkah | ✅ Pass |
| TC024 | Concurrent Users | 1. Load test 50 users | Sistem tetap responsif | ✅ Pass |
| TC025 | UI Usability | 1. User test navigation | Mudah dipahami | ✅ Pass |
| TC026 | Table Readability | 1. View order table | Kolom jelas & terpisah | ✅ Pass |
| TC027 | Featured Products | 1. View home page | Produk favorit tampil | ✅ Pass |
