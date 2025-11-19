@extends('layouts.auth')

@section('title', 'Reset Password - SIAKRA')

@section('content')
<!-- Logo Section - Outside Container -->
<div class="logo-section-external">
    <h1 class="logo-title-external">SIAKRA</h1>
    <p class="logo-subtitle-external">Sistem Informasi Agenda Kerja & Rapat</p>
</div>

<div class="login-container">
    <!-- Form Section -->
    <div class="form-section">
        <h2 class="form-title">Reset Password</h2>
        <p class="form-subtitle">Masukkan password baru untuk<br>akun Anda</p>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ $email ?? old('email') }}"
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="Email Anda">
                </div>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="Masukkan password baru">
                    <button type="button" class="password-toggle-btn" data-target="password" aria-label="Tampilkan password">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           class="form-control" 
                           id="password-confirm" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Konfirmasi password baru">
                    <button type="button" class="password-toggle-btn" data-target="password-confirm" aria-label="Tampilkan konfirmasi password">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-key me-2"></i>Reset Password
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="forgot-password">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
            </a>
        </div>
    </div>
</div>

<style>
.alert {
    padding: 12px 16px;
    margin-bottom: 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}
</style>
@endsection