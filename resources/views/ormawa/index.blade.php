@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .ormawa-card {
        background: #ffffffcc;
        border: 1.5px solid #b2dfdb;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.08);
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
    }
    .ormawa-title {
        color: #00897b;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 2.1rem;
        letter-spacing: 1px;
    }
    .ormawa-icon {
        font-size: 3.2rem;
        color: #26a69a;
        margin-bottom: 0.7rem;
    }
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="ormawa-card text-center">
                <div class="ormawa-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h2 class="ormawa-title">Daftar Ormawa</h2>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background:rgba(0,137,123,0.07); border:0; font-size:1.15em;">
                        <span><strong>HMPS Informatika</strong> <span class="text-muted">(admin@simprogma.test)</span></span>
                    </li>
                </ul>
                <div class="alert alert-info" style="background: linear-gradient(90deg, #e3f2fd 60%, #b2ebf2 100%); border-left: 6px solid #42a5f5; color: #1976d2; font-size:1.08em;">
                    <i class="fas fa-info-circle me-2"></i>
                    Untuk saat ini, pengaturan program kerja (<b>progja</b>) hanya untuk <b>HMPS Informatika</b> terlebih dahulu.<br>
                    Ormawa lain akan menyusul pada update berikutnya.
                </div>
                <div class="alert alert-warning mt-3" style="background: linear-gradient(90deg, #fffde7 60%, #ffe082 100%); border-left: 6px solid #ffb300; color: #795548; font-size:1.05em;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <b>Catatan:</b> Ke depannya, Ormawa <u>tidak dapat melakukan registrasi sendiri</u>.<br>
                    Username dan password hanya akan diberikan oleh <b>pihak kampus</b>.<br>
                    Aplikasi ini <b>bukan untuk umum</b>, hanya untuk internal Ormawa yang terdaftar resmi di kampus.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 