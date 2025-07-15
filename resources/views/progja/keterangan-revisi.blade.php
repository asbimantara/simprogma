@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .keterangan-revisi-card {
        background: #ffffffcc;
        border: 1.5px solid #b2dfdb;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.08);
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
    }
    .keterangan-revisi-icon {
        font-size: 2.7rem;
        color: #26a69a;
        margin-bottom: 0.5rem;
    }
    .keterangan-revisi-title {
        color: #00897b;
        font-weight: 600;
    }
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="keterangan-revisi-card">
                <div class="text-center mb-4">
                    <div class="keterangan-revisi-icon"><i class="fas fa-comment-dots"></i></div>
                    <h3 class="keterangan-revisi-title">Keterangan Revisi {{ isset($isLpj) && $isLpj ? 'LPJ' : '' }}</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <h5 class="mb-3">{{ $progja->nama_progja }}</h5>
                <form action="{{ $isAdmin ? (isset($isLpj) && $isLpj ? route('progja.simpanKeteranganRevisi', [$progja, 'lpj' => 1]) : route('progja.simpanKeteranganRevisi', $progja)) : '#' }}" method="POST">
                    @csrf
                    @if($isAdmin)
                        <div class="mb-3">
                            <label for="keterangan_revisi" class="form-label">Isi Keterangan Revisi</label>
                            <textarea name="keterangan_revisi" id="keterangan_revisi" class="form-control" rows="6">{{ old('keterangan_revisi', (isset($isLpj) && $isLpj ? $progja->keterangan_revisi_lpj : $progja->keterangan_revisi)) }}</textarea>
                        </div>
                    @else
                        <div class="mb-3">
                            <label class="form-label">Keterangan Revisi</label>
                            <div class="border rounded p-2 bg-light" style="min-height:120px;">{!! nl2br(e(isset($isLpj) && $isLpj ? $progja->keterangan_revisi_lpj : $progja->keterangan_revisi)) ?: '<span class=\'text-muted\'>Belum ada keterangan revisi.</span>' !!}</div>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('progja.index') }}" class="btn btn-secondary">Kembali</a>
                        @if($isAdmin)
                            <button type="submit" class="btn btn-primary">Selesai</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 