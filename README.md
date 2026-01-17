# Toko Roti JIYA (Jeycookie)

## Project Overview

Toko Roti JIYA (Jeycookie) is a web-based e-commerce application developed for a bakery business. The application is built using the Laravel PHP framework and provides a complete online shopping experience for customers, as well as comprehensive management tools for administrators.

This project was developed as part of the Web Framework course assignment.

**Berikut link YouTube untuk project ini:** [https://youtu.be/0hs36cG4ZmE](https://youtu.be/0hs36cG4ZmE)

---

## Table of Contents

1. [Features](#1-features)
2. [Technology Stack](#2-technology-stack)
3. [Installation Guide](#3-installation-guide)
4. [Configuration](#4-configuration)
5. [CI/CD Pipeline](#5-cicd-pipeline)
6. [Deployment](#6-deployment)
7. [Documentation](#7-documentation)
8. [Development Team](#8-development-team)
9. [License](#9-license)

---

## 1. Features

### 1.1 Customer Features

The application provides the following features for customers:

- Product catalog browsing with category filtering
- Shopping cart management (add, update, remove items)
- Multiple payment methods through Midtrans payment gateway
- Guest checkout without account registration
- Order tracking and history

### 1.2 Administrator Features

The application provides the following features for administrators:

- Dashboard with sales statistics and analytics
- Product management (Create, Read, Update, Delete)
- Category management
- Order management and status updates
- Automated email confirmation system

---

## 2. Technology Stack

The following technologies were used in the development of this application:

| Component | Technology |
|-----------|------------|
| Frontend Template | Laravel Blade |
| CSS Framework | Bootstrap 5 |
| Backend Framework | Laravel 10+ |
| Programming Language | PHP 8.2+ |
| Database | MySQL / MariaDB |
| Payment Gateway | Midtrans Snap |
| Email Service | Laravel Mail (SMTP) |
| Icons | Font Awesome 6 |
| Typography | Google Fonts (Playfair Display, Poppins) |
| CI/CD | GitHub Actions |
| Hosting Platform | Vercel / Railway |

---

## 3. Installation Guide

### 3.1 Prerequisites

Before installation, ensure the following software is installed on your system:

- PHP version 8.2 or higher
- Composer (PHP dependency manager)
- MySQL or MariaDB database server
- Node.js and NPM (optional, for asset compilation)

### 3.2 Installation Steps

**Step 1: Clone the Repository**

```bash
git clone https://github.com/username/jeycookie.git
cd jeycookie
```

**Step 2: Install PHP Dependencies**

```bash
composer install
```

**Step 3: Configure Environment**

```bash
cp .env.example .env
php artisan key:generate
```

**Step 4: Configure Database Connection**

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jeycookie
DB_USERNAME=root
DB_PASSWORD=
```

**Step 5: Run Database Migrations and Seeders**

```bash
php artisan migrate --seed
```

**Step 6: Start the Development Server**

```bash
php artisan serve
```

**Step 7: Access the Application**

- Customer Interface: `http://localhost:8000`
- Administrator Interface: `http://localhost:8000/admin`

---

## 4. Configuration

### 4.1 Midtrans Payment Gateway

Configure the following environment variables for payment processing:

```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### 4.2 Email Service

Configure the following environment variables for email notifications:

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

## 5. CI/CD Pipeline

### 5.1 Architecture

The CI/CD pipeline follows this workflow:

```
Developer → GitHub Repository → GitHub Actions → Vercel Deployment
```

### 5.2 GitHub Actions Workflow

The workflow configuration is located at `.github/workflows/laravel.yml`.

The pipeline is triggered automatically on:
- Push events to the `main` branch
- Pull request events to the `main` branch

The pipeline executes the following steps:
1. Setup PHP 8.2 environment
2. Checkout source code
3. Install Composer dependencies
4. Generate application key
5. Setup SQLite test database
6. Execute PHPUnit/Pest tests

### 5.3 Branching Strategy

| Branch | Purpose |
|--------|---------|
| `main` | Production-ready code |
| `develop` | Staging and feature integration |
| `feature/*` | New feature development |
| `bugfix/*` | Bug fixes |
| `hotfix/*` | Urgent production fixes |

For complete CI/CD documentation, refer to: [docs/ci_cd_documentation.md](docs/ci_cd_documentation.md)

---

## 6. Deployment

### 6.1 Deployment Environments

| Environment | URL | Branch |
|-------------|-----|--------|
| Production | https://jeycookie.vercel.app | `main` |
| Production (Railway) | https://jey-cookie-production.up.railway.app | `main` |
| Staging | https://jeycookie-staging.vercel.app | `develop` |

### 6.2 Rollback Procedure

To rollback to a previous version:

**Option 1: Git Revert (Recommended)**
```bash
git revert <commit-hash>
git push origin main
```

**Option 2: Vercel Dashboard**
Navigate to the Vercel dashboard, select a previous deployment, and promote it to production.

---

## 7. Documentation

Additional documentation is available in the `docs/` directory:

| Document | Description |
|----------|-------------|
| [Architectural Design](docs/architectural_design.md) | System architecture documentation |
| [Requirements Traceability Matrix](docs/requirements_traceability_matrix.md) | Requirements to implementation mapping |
| [Test Cases](docs/test_cases.md) | Test case documentation |
| [User Manual](docs/user_manual.md) | End-user guide |
| [CI/CD Documentation](docs/ci_cd_documentation.md) | CI/CD pipeline documentation |

---

## 8. Development Team

| Student ID | Name |
|------------|------|
| 2310130009 | Muhammad Irfan Janur Ghifari |
| 2310130007 | Muhammad Kaisar Hudayef |
| 2310130011 | Tafkir Muhtadi |
| 2310120008 | Latifah Fauziya |

---

## 9. License

This project is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

*Document Version: 1.0*
*Last Updated: January 2026*
*Course: Web Framework*
