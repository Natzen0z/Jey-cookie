@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="brand-badge mx-auto mb-3" style="width: 64px; height: 64px; font-size: 32px;">🍪</div>
                <h2 class="fw-bold text-gradient">Selamat Datang!</h2>
                <p class="text-muted">Login ke akun Jeycookie Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-envelope text-muted"></i>
                        </span>
                        <input type="email" 
                               class="form-control border-start-0 @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="nama@email.com"
                               required 
                               autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-lock text-muted"></i>
                        </span>
                        <input type="password" 
                               class="form-control border-start-0 @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                        <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()">
                            <i class="fa-solid fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">Ingat saya</label>
                    </div>
                </div>

                <input type="hidden" name="admin_login" id="adminLoginField" value="0">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-pink btn-lg">
                        <i class="fa-solid fa-sign-in-alt me-2"></i> Login
                    </button>
                </div>
            </form>

            <div class="auth-divider">
                <span>atau</span>
            </div>

            <div class="text-center">
                <p class="text-muted mb-3">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-pink w-100">
                    <i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang
                </a>
            </div>

            <div class="auth-divider">
                <span></span>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-outline-secondary w-100" onclick="loginAsAdmin()">
                    <i class="fa-solid fa-shield-halved me-2"></i> Login sebagai Admin
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    function loginAsAdmin() {
        document.getElementById('adminLoginField').value = '1';
        document.getElementById('loginForm').submit();
    }
</script>
@endpush
