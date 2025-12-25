<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Jeycookie') }} | @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        :root {
            --pink-500: #ec4899;
            --pink-600: #db2777;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            position: fixed;
            left: 0;
            top: 0;
            padding: 1.5rem;
            z-index: 1000;
        }

        .admin-sidebar .brand {
            display: flex;
            align-items: center;
            padding: 0.5rem 0 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1.5rem;
        }

        .admin-sidebar .brand-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .admin-sidebar .brand-text {
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            margin-left: 0.75rem;
        }

        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.6);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .admin-sidebar .nav-link i {
            width: 24px;
            margin-right: 0.75rem;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: var(--pink-600);
            color: white;
        }

        .admin-sidebar .nav-section {
            color: rgba(255,255,255,0.4);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 1rem 1rem 0.5rem;
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-content {
            padding: 2rem;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid var(--pink-500);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-card p {
            color: #6b7280;
            margin-bottom: 0;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card-header {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        /* Buttons */
        .btn-pink {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            color: white;
            border: none;
            border-radius: 8px;
        }

        .btn-pink:hover {
            background: linear-gradient(135deg, var(--pink-600), #be185d);
            color: white;
        }

        /* Tables */
        .table th {
            font-weight: 600;
            color: #374151;
            background: #f9fafb;
        }

        /* Forms */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.625rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--pink-500);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        }

        /* Badge colors */
        .badge.bg-pending { background: #f59e0b !important; }
        .badge.bg-paid { background: #3b82f6 !important; }
        .badge.bg-processing { background: #8b5cf6 !important; }
        .badge.bg-shipped { background: #6366f1 !important; }
        .badge.bg-completed { background: #10b981 !important; }
        .badge.bg-cancelled { background: #ef4444 !important; }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <nav class="admin-sidebar">
        <div class="brand">
            <div class="brand-icon">🍪</div>
            <span class="brand-text">Jeycookie</span>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            </li>

            <div class="nav-section">Products</div>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                   href="{{ route('admin.products.index') }}">
                    <i class="fa-solid fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                   href="{{ route('admin.categories.index') }}">
                    <i class="fa-solid fa-tags"></i> Categories
                </a>
            </li>

            <div class="nav-section">Orders</div>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                   href="{{ route('admin.orders.index') }}">
                    <i class="fa-solid fa-shopping-cart"></i> Orders
                </a>
            </li>

            <div class="nav-section">Account</div>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fa-solid fa-store"></i> View Store
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <i class="fa-solid fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div>
                <h5 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">{{ Auth::user()->name }}</span>
                <div class="rounded-circle bg-pink-100 p-2">
                    <i class="fa-solid fa-user text-pink"></i>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="admin-content pb-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="admin-content pt-0">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
