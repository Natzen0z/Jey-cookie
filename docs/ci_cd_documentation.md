# Dokumentasi CI/CD - Toko Roti Jiya (Jeycookie)

## 1. Arsitektur CI/CD Pipeline

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           CI/CD PIPELINE ARCHITECTURE                        │
└─────────────────────────────────────────────────────────────────────────────┘

  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
  │   DEVELOPER  │────▶│    GITHUB    │────▶│   GITHUB     │────▶│   VERCEL     │
  │              │     │  REPOSITORY  │     │   ACTIONS    │     │  DEPLOYMENT  │
  └──────────────┘     └──────────────┘     └──────────────┘     └──────────────┘
         │                    │                    │                    │
         │                    │                    │                    │
    git push            Trigger             Build & Test           Deploy
    git merge           Workflow            Run PHPUnit            Staging/Prod
         │                    │                    │                    │
         ▼                    ▼                    ▼                    ▼
  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
  │  Local Dev   │     │  main branch │     │  CI Pipeline │     │  Live Site   │
  │  Environment │     │  develop     │     │  - Build     │     │  - Staging   │
  │              │     │  feature/*   │     │  - Test      │     │  - Production│
  └──────────────┘     └──────────────┘     └──────────────┘     └──────────────┘
```

### Komponen Utama:

| Komponen | Fungsi |
|----------|--------|
| **GitHub Repository** | Menyimpan source code dan version control |
| **GitHub Actions** | Menjalankan CI/CD workflow otomatis |
| **Vercel** | Platform deployment untuk staging & production |
| **PHPUnit/Pest** | Framework testing untuk quality assurance |

---

## 2. Penjelasan Workflow GitHub Actions

### File: `.github/workflows/laravel.yml`

```yaml
name: Laravel

on:
  push:
    branches: [ "main" ]
  pull_request:
    branches: [ "main" ]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    steps:
    - uses: shivammathur/setup-php@15c43e89cdef867065b0213be354c2841860869e
      with:
        php-version: '8.2'
    - uses: actions/checkout@v4
    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
    - name: Generate key
      run: php artisan key:generate
    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache
    - name: Create Database
      run: |
        mkdir -p database
        touch database/database.sqlite
    - name: Execute tests (Unit and Feature tests) via PHPUnit/Pest
      env:
        DB_CONNECTION: sqlite
        DB_DATABASE: database/database.sqlite
      run: php artisan test
```

### Penjelasan Setiap Step:

| Step | Deskripsi |
|------|-----------|
| **Trigger** | Workflow dijalankan pada `push` atau `pull_request` ke branch `main` |
| **Setup PHP** | Menginstal PHP versi 8.2 menggunakan `shivammathur/setup-php` |
| **Checkout** | Mengunduh source code dari repository |
| **Copy .env** | Menyalin file `.env.example` ke `.env` jika belum ada |
| **Install Dependencies** | Menjalankan `composer install` untuk menginstal dependency PHP |
| **Generate Key** | Membuat application key Laravel |
| **Directory Permissions** | Memberikan permission pada folder `storage` dan `bootstrap/cache` |
| **Create Database** | Membuat database SQLite untuk testing |
| **Execute Tests** | Menjalankan test menggunakan PHPUnit/Pest |

---

## 3. Branching Strategy

### Git Flow Model

```
                                    ┌─────────────────────────────────────┐
                                    │           PRODUCTION                │
                                    │         (main branch)               │
                                    └─────────────────────────────────────┘
                                                    ▲
                                                    │ merge
                                    ┌─────────────────────────────────────┐
                                    │           STAGING                   │
                                    │        (develop branch)             │
                                    └─────────────────────────────────────┘
                                                    ▲
                              ┌─────────────────────┼─────────────────────┐
                              │                     │                     │
                    ┌─────────────────┐   ┌─────────────────┐   ┌─────────────────┐
                    │  feature/auth   │   │ feature/payment │   │  feature/cart   │
                    └─────────────────┘   └─────────────────┘   └─────────────────┘
```

### Branch Types:

| Branch | Tujuan | Naming Convention |
|--------|--------|-------------------|
| **main** | Branch production, kode yang sudah stabil | `main` |
| **develop** | Branch staging untuk integrasi fitur | `develop` |
| **feature/** | Branch untuk pengembangan fitur baru | `feature/nama-fitur` |
| **bugfix/** | Branch untuk perbaikan bug | `bugfix/deskripsi-bug` |
| **hotfix/** | Branch untuk perbaikan urgent di production | `hotfix/deskripsi` |
| **release/** | Branch untuk persiapan release | `release/v1.0.0` |

### Workflow:

1. **Buat Feature Branch**
   ```bash
   git checkout develop
   git pull origin develop
   git checkout -b feature/nama-fitur
   ```

2. **Development & Commit**
   ```bash
   git add .
   git commit -m "feat: deskripsi fitur"
   git push origin feature/nama-fitur
   ```

3. **Create Pull Request**
   - Buat PR dari `feature/nama-fitur` ke `develop`
   - GitHub Actions akan otomatis menjalankan CI pipeline

4. **Merge ke Develop (Staging)**
   ```bash
   git checkout develop
   git merge feature/nama-fitur
   git push origin develop
   ```

5. **Deploy ke Production**
   ```bash
   git checkout main
   git merge develop
   git push origin main
   ```

---

## 4. Cara Kerja Deployment Staging & Production

### Deployment ke Vercel

#### A. Staging Deployment

1. **Trigger**: Push ke branch `develop`
2. **URL**: `https://jeycookie-staging.vercel.app` (atau sesuai konfigurasi)
3. **Environment Variables**:
   ```
   APP_ENV=staging
   APP_DEBUG=true
   MIDTRANS_IS_PRODUCTION=false
   ```

#### B. Production Deployment

1. **Trigger**: Push ke branch `main`
2. **URL**: `https://jeycookie.vercel.app` (atau domain custom)
3. **Environment Variables**:
   ```
   APP_ENV=production
   APP_DEBUG=false
   MIDTRANS_IS_PRODUCTION=true
   ```

### Vercel Configuration

File: `vercel.json` (jika ada)
```json
{
  "version": 2,
  "builds": [
    {
      "src": "public/index.php",
      "use": "vercel-php@0.6.0"
    }
  ],
  "routes": [
    { "src": "/(.*)", "dest": "/public/index.php" }
  ]
}
```

### Deployment Flow:

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│    COMMIT    │────▶│    PUSH      │────▶│   WEBHOOK    │
│              │     │  to GitHub   │     │  to Vercel   │
└──────────────┘     └──────────────┘     └──────────────┘
                                                 │
                                                 ▼
                                         ┌──────────────┐
                                         │    BUILD     │
                                         │   Process    │
                                         └──────────────┘
                                                 │
                            ┌────────────────────┼────────────────────┐
                            │                    │                    │
                            ▼                    ▼                    ▼
                     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
                     │   Install    │     │    Build     │     │   Deploy     │
                     │ Dependencies │     │   Assets     │     │   to CDN     │
                     └──────────────┘     └──────────────┘     └──────────────┘
```

---

## 5. Mekanisme Rollback

### A. Rollback menggunakan Git

#### Rollback ke Commit Sebelumnya
```bash
# Lihat history commit
git log --oneline

# Rollback ke commit tertentu (soft - keep changes)
git reset --soft HEAD~1

# Rollback ke commit tertentu (hard - discard changes)
git reset --hard <commit-hash>

# Push rollback
git push origin main --force
```

#### Revert Commit (Recommended)
```bash
# Revert commit tertentu (membuat commit baru yang membatalkan)
git revert <commit-hash>
git push origin main
```

### B. Rollback di Vercel

1. **Via Vercel Dashboard**
   - Buka Vercel Dashboard
   - Pilih project Jeycookie
   - Klik tab "Deployments"
   - Pilih deployment sebelumnya yang stabil
   - Klik "..." → "Promote to Production"

2. **Via Vercel CLI**
   ```bash
   # Install Vercel CLI
   npm i -g vercel

   # List semua deployment
   vercel ls

   # Rollback ke deployment tertentu
   vercel rollback <deployment-id>
   ```

### C. Rollback Strategy Matrix

| Situasi | Metode Rollback | Command |
|---------|-----------------|---------|
| Bug minor di production | Git Revert | `git revert <hash>` |
| Bug major - perlu cepat | Vercel Rollback | Via Dashboard |
| Feature tidak stabil | Reset ke develop | `git reset --hard origin/develop` |
| Database migration error | Artisan Rollback | `php artisan migrate:rollback` |

### D. Rollback Workflow

```
┌──────────────────────────────────────────────────────────────────┐
│                     ROLLBACK DECISION TREE                        │
└──────────────────────────────────────────────────────────────────┘
                                │
                                ▼
                    ┌───────────────────────┐
                    │  Detect Issue in Prod │
                    └───────────────────────┘
                                │
                    ┌───────────┴───────────┐
                    │                       │
              ┌─────┴─────┐           ┌─────┴─────┐
              │  URGENT?  │           │  URGENT?  │
              │    YES    │           │    NO     │
              └─────┬─────┘           └─────┬─────┘
                    │                       │
                    ▼                       ▼
           ┌────────────────┐     ┌────────────────┐
           │ Vercel Rollback│     │  Git Revert    │
           │ (Instant)      │     │ (New Commit)   │
           └────────────────┘     └────────────────┘
                    │                       │
                    ▼                       ▼
           ┌────────────────┐     ┌────────────────┐
           │ Investigate &  │     │  Fix Bug in    │
           │ Create Hotfix  │     │ Feature Branch │
           └────────────────┘     └────────────────┘
```

---

## 6. Link Aplikasi

| Environment | URL | Status |
|-------------|-----|--------|
| **Production** | https://jeycookie.vercel.app | 🟢 Live |
| **Staging** | https://jeycookie-staging.vercel.app | 🟡 Development |
| **GitHub Repository** | https://github.com/username/jeycookie | 📦 Source |

---

## 7. Environment Variables

### Development (`.env.local`)
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jeycookie
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=SB-Mid-server-xxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxx
MIDTRANS_IS_PRODUCTION=false
```

### Staging (Vercel Environment)
```env
APP_ENV=staging
APP_DEBUG=true
MIDTRANS_IS_PRODUCTION=false
```

### Production (Vercel Environment)
```env
APP_ENV=production
APP_DEBUG=false
MIDTRANS_IS_PRODUCTION=true
```

---

## 8. Troubleshooting

| Problem | Solution |
|---------|----------|
| CI Pipeline Failed | Check GitHub Actions logs, verify `.env.ci` |
| Deployment Failed | Check Vercel logs, verify build command |
| Database Error | Run `php artisan migrate:fresh --seed` |
| Permission Error | Run `chmod -R 777 storage bootstrap/cache` |

---

*Dokumen ini dibuat untuk memenuhi tugas mata kuliah Web Framework*
*Tanggal: 14 Januari 2026*
