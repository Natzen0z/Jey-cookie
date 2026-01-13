# Toko Roti JIYA (Jeycookie)

[![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql)](https://mysql.com)
[![Midtrans](https://img.shields.io/badge/Payment-Midtrans-00D4AA)](https://midtrans.com)
[![CI](https://github.com/username/jeycookie/actions/workflows/laravel.yml/badge.svg)](https://github.com/username/jeycookie/actions)

Aplikasi e-commerce untuk Toko Roti JIYA, dibangun dengan Laravel Framework.

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Technology Stack](#-technology-stack)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [CI/CD Pipeline](#-cicd-pipeline)
- [Deployment](#-deployment)
- [Dokumentasi](#-dokumentasi)
- [Tim Pengembang](#-tim-pengembang)

---

## ✨ Fitur

### Untuk Pelanggan
- 🛍️ Melihat katalog produk dengan filter kategori
- 🛒 Mengelola keranjang belanja
- 💳 Checkout dengan berbagai metode pembayaran (Midtrans)
- 👤 Guest checkout tanpa perlu login
- 📦 Melacak status pesanan

### Untuk Admin
- 📊 Dashboard dengan statistik penjualan
- 📦 CRUD produk dan kategori
- 📋 Manajemen pesanan
- 📧 Email konfirmasi otomatis

---

## 🛠️ Technology Stack

| Layer | Technology |
|-------|------------|
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap 5 |
| **Backend** | PHP 8.2+, Laravel 10+ |
| **Database** | MySQL / MariaDB |
| **Payment Gateway** | Midtrans Snap |
| **Email** | Laravel Mail (SMTP) |
| **Icons** | Font Awesome 6 |
| **Fonts** | Google Fonts (Playfair Display, Poppins) |
| **CI/CD** | GitHub Actions |
| **Hosting** | Vercel / Railway |

---

## 🚀 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (opsional untuk asset compilation)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/jeycookie.git
   cd jeycookie
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jeycookie
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Migrasi & Seed Database**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

7. **Akses Aplikasi**
   - Frontend: `http://localhost:8000`
   - Admin: `http://localhost:8000/admin` (login sebagai admin)

---

## ⚙️ Konfigurasi

### Midtrans Payment Gateway

```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Email Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@jeycookie.com
MAIL_FROM_NAME="Jeycookie"
```

---

## 🔄 CI/CD Pipeline

### Arsitektur

```
Developer → GitHub → GitHub Actions → Vercel
              │            │            │
           Push/PR    Build & Test   Deploy
```

### GitHub Actions Workflow

File: `.github/workflows/laravel.yml`

Workflow ini berjalan secara otomatis ketika:
- Push ke branch `main`
- Pull request ke branch `main`

**Steps:**
1. Setup PHP 8.2
2. Checkout code
3. Install Composer dependencies
4. Generate application key
5. Setup SQLite database
6. Run PHPUnit/Pest tests

### Branching Strategy

| Branch | Tujuan |
|--------|--------|
| `main` | Production - kode stabil |
| `develop` | Staging - integrasi fitur |
| `feature/*` | Development fitur baru |
| `bugfix/*` | Perbaikan bug |
| `hotfix/*` | Perbaikan urgent production |

Untuk dokumentasi CI/CD lengkap, lihat: [docs/ci_cd_documentation.md](docs/ci_cd_documentation.md)

---

## 🌐 Deployment

### Vercel

| Environment | URL | Branch |
|-------------|-----|--------|
| Production | https://jeycookie.vercel.app | `main` |
| Staging | https://jeycookie-staging.vercel.app | `develop` |

### Rollback

```bash
# Via Git (recommended)
git revert <commit-hash>
git push origin main

# Via Vercel Dashboard
# Pilih deployment sebelumnya → Promote to Production
```

---

## 📚 Dokumentasi

Semua dokumentasi tersedia di folder `docs/`:

| Dokumen | Deskripsi |
|---------|-----------|
| [Architectural Design](docs/architectural_design.md) | Arsitektur sistem (MVC) |
| [Requirements Traceability Matrix](docs/requirements_traceability_matrix.md) | Mapping kebutuhan ke implementasi |
| [Test Cases](docs/test_cases.md) | Daftar test case |
| [User Manual](docs/user_manual.md) | Panduan penggunaan |
| [CI/CD Documentation](docs/ci_cd_documentation.md) | Dokumentasi CI/CD pipeline |

---

## 👥 Tim Pengembang

| NIM | Nama |
|-----|------|
| 2310130009 | Muhammad Irfan Janur Ghifari |
| 2310130007 | Muhammad Kaisar Hudayef |
| 2310130011 | Tafkir Muhtadi |

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

*Dibuat untuk mata kuliah Web Framework - Januari 2026*
