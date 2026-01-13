# Perubahan SRS Toko Roti Jiya

Dokumen ini berisi daftar perubahan yang perlu dilakukan pada SRS untuk menyesuaikan dengan implementasi aktual aplikasi Jeycookie.

---

## 1. Section 1.3 - Batasan Produk

### Sebelum:
> - Integrasi pihak ketiga (WhatsApp API, email automation, dll)

### Sesudah:
> - Integrasi pihak ketiga (WhatsApp API, ~~email automation~~, dll)
> 
> **Catatan:** Email automation sudah diimplementasikan menggunakan `OrderConfirmationMail.php` untuk mengirim konfirmasi pesanan ke pelanggan.

---

## 2. Section 2.5 - Batasan Desain dan Implementasi

### Sebelum:
> Pembayaran menggunakan bukti transfer, bukan integrasi otomatis.

### Sesudah:
> ~~Pembayaran menggunakan bukti transfer, bukan integrasi otomatis.~~
> 
> **Perubahan:** Pembayaran menggunakan **Midtrans Payment Gateway** dengan opsi:
> - GoPay
> - QRIS
> - Bank Transfer
> - Kartu Kredit/Debit
> - Dan metode lainnya yang didukung Midtrans

---

## 3. Section 3.4 - Communication Interface

### Sebelum:
> - Protokol HTTP/HTTPS
> - Upload file (bukti pembayaran)
> - Tidak ada integrasi API eksternal

### Sesudah:
> - Protokol HTTP/HTTPS
> - ~~Upload file (bukti pembayaran)~~ → Pembayaran otomatis via Midtrans
> - ~~Tidak ada integrasi API eksternal~~ → **Terintegrasi dengan Midtrans API**

---

## 4. Section 3.1 - User Interfaces

### Halaman yang sudah diimplementasikan (tambahkan ke SRS):

| No | Halaman | Status |
|----|---------|--------|
| 1 | Halaman Home | ✅ Sudah ada di SRS |
| 2 | Halaman Katalog Produk | ✅ Sudah ada di SRS |
| 3 | Halaman Detail Produk | ✅ Sudah ada di SRS |
| 4 | Halaman Keranjang | ✅ Sudah ada di SRS |
| 5 | Halaman Checkout | ✅ Sudah ada di SRS |
| 6 | Halaman Upload Bukti Pembayaran | ❌ Diganti dengan Midtrans Payment |
| 7 | Dashboard Admin | ✅ Sudah ada di SRS |
| 8 | **Halaman About Us** | ⚠️ **Perlu ditambahkan** |
| 9 | **Halaman Partnership** | ⚠️ **Perlu ditambahkan** |
| 10 | **Halaman Guest Checkout** | ⚠️ **Perlu ditambahkan** |
| 11 | **Halaman Order History** | ⚠️ **Perlu ditambahkan** |
| 12 | **Halaman Order Detail** | ⚠️ **Perlu ditambahkan** |

---

## 5. FR002 - Transaksi Pembelian

### Sebelum:
> Pelanggan dapat Melihat Katalog, Mengelola Keranjang, Checkout, dan Melakukan Pembayaran (Multi-payment)

### Sesudah:
> Pelanggan dapat:
> - Melihat Katalog Produk
> - Mengelola Keranjang Belanja
> - Checkout **(termasuk Guest Checkout tanpa login)**
> - Melakukan Pembayaran **(via Midtrans Payment Gateway)**

---

## 6. Teknologi yang Digunakan (Update Section 2.4)

### Tambahkan:
| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 10+ |
| Database | MySQL |
| Payment Gateway | **Midtrans** (Sandbox/Production) |
| Email | Laravel Mail |
| CSS Framework | Bootstrap 5 |
| Fonts | Google Fonts (Playfair Display, Poppins) |
| Icons | Font Awesome 6 |
| Hosting | Railway / Dunia Hosting |

---

## Ringkasan Perubahan

| Kategori | Perubahan |
|----------|-----------|
| Payment | Bukti Transfer → Midtrans Payment Gateway |
| Email | Tidak ada → Email Konfirmasi Otomatis |
| API | Tidak ada → Midtrans API Integration |
| Halaman | +5 halaman baru (About, Partnership, Guest Checkout, Order History, Order Detail) |
| Guest Checkout | Tidak ada → Tersedia |

---

*Dokumen ini dibuat pada: 13 Januari 2026*
