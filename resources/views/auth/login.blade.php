@extends('layouts.auth')

@section('title', 'Login - SIAKRA')

@section('content')
<!-- Logo Section - Outside Container -->
<div class="logo-section-external">
    <h1 class="logo-title-external">SIAKRA</h1>
    <p class="logo-subtitle-external">Sistem Informasi Agenda Kerja & Rapat</p>
</div>

<div class="login-container">
    <!-- Form Section -->
    <div class="form-section">
        <h2 class="form-title">Masuk ke Akun Anda</h2>
        <p class="form-subtitle">Masukkan email dan password untuk<br>mengakses dashboard</p>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="Masukkan email">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group password-input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Masukkan password">
                    <button type="button" class="password-toggle-btn" id="togglePassword">
                        <i class="fas fa-eye-slash" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <a href="{{ route('password.request') }}" class="forgot-password">Lupa password?</a>
            </div>

            <div class="form-group">
                <label for="captcha" class="form-label">Captcha: <strong>{{ $captchaQuestion ?? ' ? ' }}</strong></label>
                <div class="input-group">
                    <i class="fas fa-shield-alt input-icon"></i>
                    <input type="text"
                           class="form-control @error('captcha') is-invalid @enderror"
                           id="captcha"
                           name="captcha"
                           required
                           placeholder="Jawab pertanyaan di atas"
                           value="{{ old('captcha') }}">
                </div>
                @error('captcha')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection