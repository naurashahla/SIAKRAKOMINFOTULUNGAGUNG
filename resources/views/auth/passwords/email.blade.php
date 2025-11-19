@extends('layouts.auth')

@section('title', 'Lupa Password - SIAKRA')

@section('content')
<!-- Logo Section - Outside Container -->
<div class="logo-section-external">
    <h1 class="logo-title-external">SIAKRA</h1>
    <p class="logo-subtitle-external">Sistem Informasi Agenda Kerja & Rapat</p>
</div>

<div class="login-container">
    <!-- Form Section -->
    <div class="form-section">
        <h2 class="form-title">Lupa Password</h2>
        <p class="form-subtitle">Masukkan email Anda untuk menerima<br>link reset password</p>
        
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="Masukkan email Anda">
                </div>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-paper-plane me-2"></i>Kirim Link Reset Password
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

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
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