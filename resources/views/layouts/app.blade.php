<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jeycookie') }} - @yield('title', 'Fresh Bakery')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @stack('styles')
</head>

<body class="bg-soft-peach">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="brand-badge">🍪</div>
                <span class="ms-2 brand-text">Jeycookie</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fa-solid fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fa-solid fa-cookie-bite me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
                            <i class="fa-solid fa-info-circle me-1"></i> About
                        </a>
                    </li>
                    
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ request()->is('cart') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-shopping-cart"></i>
                            @php
                                $cartCount = count(session('cart', []));
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>

                <!-- Auth Section -->
                <div class="ms-lg-3 d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-pink">
                            <i class="fa-solid fa-sign-in-alt me-1"></i> Login
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-pink dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fa-solid fa-box me-2"></i> My Orders
                                    </a>
                                </li>
                                @if(Auth::user()->is_admin)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fa-solid fa-gauge me-2"></i> Admin Panel
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
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
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="brand-badge-footer">🍪</div>
                        <span class="ms-2 fs-4 fw-bold">Jeycookie</span>
                    </div>
                    <p class="text-muted">Fresh homemade bakery products made with love. Premium ingredients, baked fresh daily.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Categories</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">Donuts</a></li>
                        <li><a href="#">Cakes</a></li>
                        <li><a href="#">Brownies</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Contact Us</h6>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i> Jakarta, Indonesia</li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2"></i> +62 812-3456-7890</li>
                        <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i> hello@jeycookie.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center text-muted">
                <small>&copy; {{ date('Y') }} Jeycookie. All rights reserved. Freshly baked with <i class="fa-solid fa-heart text-danger"></i></small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
