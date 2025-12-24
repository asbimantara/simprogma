@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .dashboard-card {
        background: #ffffffcc;
        border: 1.5px solid #b2dfdb;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.08);
    }
    .dashboard-icon {
        font-size: 3.5rem;
        color: #26a69a;
        margin-bottom: 0.5rem;
    }
    .alert-seruan {
        background: linear-gradient(90deg, #fffde7 60%, #ffe082 100%);
        border-left: 6px solid #ffb300;
        color: #795548;
        font-weight: 500;
        font-size: 1.1em;
    }
    .info-progja {
        background: #e3f2fd;
        border-left: 6px solid #42a5f5;
        border-radius: 10px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    .info-progja-title {
        color: #1976d2;
        font-weight: 600;
        font-size: 1.15em;
        margin-bottom: 0.5rem;
    }
    .info-progja-list li {
        margin-bottom: 0.5rem;
    }
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @php $isAdmin = auth()->user()->role === 'admin';
                 $isUserUtama = auth()->user()->email === 'user@simprogma.test'; @endphp
            @if($isAdmin)
                <div class="dashboard-card p-5 text-center mb-4">
                    <div class="dashboard-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h2 class="mb-3" style="color:#00897b;">Selamat datang, Admin!</h2>
                    <p class="lead" style="color:#388e3c;">Anda dapat mereview, mengubah status, dan memantau seluruh program kerja Ormawa.</p>
                    <hr>
                    <p class="mb-0 text-muted">Gunakan menu progja untuk melihat, mengelola, dan memverifikasi pengajuan program kerja dari seluruh Ormawa.<br>Jika ada kendala, silakan hubungi developer.</p>
                </div>
            @else
                @if(! $isUserUtama)
                <div class="alert alert-warning mb-4 text-center" style="background: linear-gradient(90deg, #fffde7 60%, #ffe082 100%); border-left: 6px solid #ffb300; color: #795548; font-size:1.08em;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <b>Perhatian:</b> Saat ini workspace ini masih milik <b>HMPS Informatika</b>.<br>
                    User lain (termasuk Anda) <b>belum memiliki workspace sendiri</b>.<br>
                    Ke depannya, setiap user/ormawa akan memiliki workspace dan data program kerja masing-masing.
                </div>
                @endif
                <div class="dashboard-card p-5 text-center mb-4">
                    <div class="dashboard-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h2 class="mb-3" style="color:#00897b;">Selamat datang di SIMPROGMA!</h2>
                    <p class="lead" style="color:#388e3c;">Semoga harimu menyenangkan dan penuh semangat untuk berkontribusi dalam organisasi.</p>
                    <hr>
                    <p class="mb-0 text-muted">Gunakan menu progja untuk mengelola program kerja, melihat status pengajuan, dan fitur lainnya.<br>Jika ada kendala, silakan hubungi admin.</p>
                </div>
                <div class="alert alert-seruan mb-4 text-center">
                    <i class="fas fa-bullhorn me-2"></i>
                    <span>Segera tambah program kerja (progja) sebelum <b>Agustus 2025</b> agar proses pengajuan dan pencairan dana berjalan lancar!</span>
                </div>
                <div class="info-progja">
                    <div class="info-progja-title"><i class="fas fa-info-circle me-1"></i> Perbedaan Progja RAB, Non-RAB, dan Biasa</div>
                    <ul class="info-progja-list ps-3">
                        <li><b>Progja RAB</b>: Progja yang disusun untuk mendapat dana dari UNISNU Jepara. Maksimal <b>4 progja</b> per Ormawa yang digunakan untuk mencairkan dana. Wajib upload Proposal dan LPJ.</li>
                        <li><b>Progja Non-RAB</b>: Kegiatan yang <b>tidak perlu minta anggaran</b> namun wajib dilaporkan dengan LPJ, proposal bisa diganti dengan KAK. Maksimal <b>1 progja</b> Non-RAB per Ormawa.</li>
                        <li><b>Progja Biasa</b>: Sama dengan Non-RAB (tidak minta anggaran), namun <b>tidak perlu Proposal dan LPJ</b>. Cukup diganti dengan <b>KAK (Kerangka Acuan Kegiatan) dan Laporan biasa.</b>.</li>
                    </ul>
                    <div class="text-muted" style="font-size:0.97em;">Setiap Ormawa sudah mendapat anggaran dari UNISNU Jepara. Pastikan memilih jenis progja sesuai kebutuhan dan aturan di atas.</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
