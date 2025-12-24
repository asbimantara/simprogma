@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
        }

        .welcome-container {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 4rem;
            padding-bottom: 2rem;
        }

        .welcome-card {
            background: #ffffffcc;
            border-radius: 20px;
            box-shadow: 0 4px 32px 0 rgba(44, 62, 80, 0.13);
            display: flex;
            flex-wrap: wrap;
            max-width: 700px;
            width: 100%;
            overflow: hidden;
        }

        .welcome-left,
        .welcome-right {
            flex: 1 1 300px;
            min-width: 280px;
            padding: 2.5rem 2rem;
        }

        .welcome-left {
            background: #e0f7fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 1.5px solid #b2dfdb;
        }

        .welcome-right {
            background: #e8f5e9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .welcome-title {
            color: #00897b;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 1.2rem;
            letter-spacing: 1px;
        }

        .welcome-icon {
            font-size: 2.5rem;
            color: #26a69a;
            margin-bottom: 0.7rem;
        }

        .register-btn {
            background: #00897b;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7rem 2.2rem;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 1.2rem;
            transition: background 0.2s;
        }

        .register-btn:hover {
            background: #00695c;
        }

        .welcome-info {
            color: #388e3c;
            font-size: 1.08em;
            margin-top: 1.2rem;
            text-align: center;
        }
    </style>
    <div class="welcome-container">
        <div class="welcome-card">
            <div class="welcome-left">
                <div class="welcome-title mb-4"><i class="fas fa-sign-in-alt me-2"></i>Login ke SIMPROGMA</div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus
                            placeholder="Masukkan email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            placeholder="Masukkan password">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
            </div>
            <div class="welcome-right text-center">
                <div class="welcome-icon mb-2"><i class="fas fa-users"></i></div>
                <div class="welcome-title">Belum punya akun?</div>
                <a href="{{ route('register') }}" class="register-btn">Register</a>
                <div class="welcome-info mt-4">
                    <b>SIMPROGMA</b> adalah aplikasi manajemen program kerja Ormawa UNISNU Jepara.<br>
                    Silakan login untuk mengelola progja, upload proposal/LPJ, dan memantau status pengajuan.<br>
                    <span class="text-muted" style="font-size:0.97em;">Akun hanya diberikan oleh pihak kampus.</span>
                </div>
            </div>
        </div>
    </div>
@endsection