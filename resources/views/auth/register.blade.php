@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .register-container {
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 4rem;
        padding-bottom: 2rem;
    }
    .register-card {
        background: #ffffffcc;
        border-radius: 20px;
        box-shadow: 0 4px 32px 0 rgba(44, 62, 80, 0.13);
        display: flex;
        flex-wrap: wrap;
        max-width: 700px;
        width: 100%;
        overflow: hidden;
    }
    .register-left {
        flex: 1 1 340px;
        padding: 2.5rem 2rem 2.5rem 2.5rem;
        background: transparent;
    }
    .register-right {
        flex: 1 1 260px;
        background: linear-gradient(135deg, #e3f2fd 60%, #b2ebf2 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1.5rem;
    }
    .register-title {
        color: #00897b;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 2rem;
        letter-spacing: 1px;
    }
    .register-icon {
        font-size: 3.2rem;
        color: #26a69a;
        margin-bottom: 0.7rem;
    }
    .register-info {
        color: #1976d2;
        font-size: 1.08em;
        margin-bottom: 1.2rem;
        text-align: center;
    }
    .register-btn-login {
        background: #00897b;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 1.05em;
        margin-top: 1.2rem;
        transition: background 0.2s;
    }
    .register-btn-login:hover {
        background: #00695c;
    }
    @media (max-width: 700px) {
        .register-card { flex-direction: column; }
        .register-left, .register-right { padding: 2rem 1rem; }
    }
</style>
<div class="register-container">
    <div class="register-card">
        <div class="register-left">
            <div class="register-title mb-4">
                <i class="fas fa-user-plus register-icon"></i> Register Akun Ormawa
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="/" style="color:#1976d2; font-size:0.98em;">Sudah punya akun?</a>
                    <button type="submit" class="btn btn-primary px-4" style="background:#00897b; border:none;">REGISTER</button>
                </div>
            </form>
        </div>
        <div class="register-right">
            <div class="register-icon mb-2"><i class="fas fa-users"></i></div>
            <div class="register-info">
                Daftarkan akun Ormawa Anda untuk mengakses aplikasi pengelolaan program kerja.<br>
                <span style="color:#00897b; font-weight:600;">Aplikasi ini hanya untuk internal Ormawa kampus.</span>
            </div>
            <a href="/" class="register-btn-login">Login</a>
        </div>
    </div>
</div>
@endsection
