@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="brand-badge mx-auto mb-3" style="width: 64px; height: 64px; font-size: 32px;">🍪</div>
                <h2 class="fw-bold text-gradient">Buat Akun Baru</h2>
                <p class="text-muted">Daftar untuk mulai berbelanja</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-user text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0 @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Nama lengkap Anda"
                               required 
                               autofocus>
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

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
                               required>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon <span class="text-muted">(opsional)</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-phone text-muted"></i>
                        </span>
                        <input type="tel" 
                               class="form-control border-start-0 @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               placeholder="08xxxxxxxxxx">
                    </div>
                    @error('phone')
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
                               placeholder="Minimal 8 karakter"
                               required>
                        <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password', 'toggleIcon1')">
                            <i class="fa-solid fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-lock text-muted"></i>
                        </span>
                        <input type="password" 
                               class="form-control border-start-0" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Ulangi password"
                               required>
                        <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                            <i class="fa-solid fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-pink btn-lg">
                        <i class="fa-solid fa-user-plus me-2"></i> Daftar
                    </button>
                </div>
            </form>

            <div class="auth-divider">
                <span>atau</span>
            </div>

            <div class="text-center">
                <p class="text-muted mb-2">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="btn btn-outline-pink w-100">
                    <i class="fa-solid fa-sign-in-alt me-2"></i> Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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
</script>
@endpush
