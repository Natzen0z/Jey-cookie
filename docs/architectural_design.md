# Architectural Design - Toko Roti Jiya (Jeycookie)

## 1. System Architecture Overview

Aplikasi Toko Roti Jiya menggunakan arsitektur **MVC (Model-View-Controller)** yang disediakan oleh Laravel Framework.

```
┌─────────────────────────────────────────────────────────────────┐
│                          CLIENT LAYER                            │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐              │
│  │   Browser   │  │   Mobile    │  │   Tablet    │              │
│  │  (Chrome,   │  │  Browser    │  │  Browser    │              │
│  │  Firefox)   │  │             │  │             │              │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘              │
└─────────┼────────────────┼────────────────┼─────────────────────┘
          │                │                │
          └────────────────┼────────────────┘
                           │ HTTP/HTTPS
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      PRESENTATION LAYER                          │
│  ┌─────────────────────────────────────────────────────────┐    │
│  │                   Blade Templates                        │    │
│  │  • layouts/app.blade.php (Main Layout)                  │    │
│  │  • home.blade.php, products/, cart/, checkout/, admin/  │    │
│  └─────────────────────────────────────────────────────────┘    │
│  ┌─────────────────────────────────────────────────────────┐    │
│  │                    Static Assets                         │    │
│  │  Bootstrap 5 | Custom CSS | Font Awesome | Google Fonts │    │
│  └─────────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      APPLICATION LAYER                           │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │  CONTROLLERS: Home, Product, Cart, Checkout, Order, Auth  │  │
│  │  ADMIN: Dashboard, Product, Category, Order               │  │
│  └───────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │  MIDDLEWARE: auth, guest, admin                           │  │
│  └───────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │  SERVICES: MidtransService, OrderConfirmationMail         │  │
│  └───────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                        DATA LAYER                                │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │  MODELS: User, Category, Product, Order, OrderItem        │  │
│  └───────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │  DATABASE: MySQL (users, categories, products, orders)    │  │
│  └───────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  EXTERNAL: Midtrans Payment API | SMTP Email Server             │
└─────────────────────────────────────────────────────────────────┘
```

## 2. Technology Stack

| Layer | Technology |
|-------|------------|
| Frontend | HTML5, CSS3, JavaScript, Bootstrap 5 |
| Backend | PHP 8+, Laravel 10+ |
| Database | MySQL / MariaDB |
| Payment Gateway | Midtrans Snap |
| Email | Laravel Mail (SMTP) |
| Hosting | Railway / Dunia Hosting |

## 3. Data Flow

### Checkout Flow
```
User → Add to Cart → Cart Page → Checkout Form → Create Order 
    → Midtrans Payment → Webhook → Update Status → Send Email
```

### Admin Order Management
```
Admin Login → Dashboard → View Orders → Update Status → Save
```
