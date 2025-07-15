@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .upload-lpj-card {
        background: #ffffffcc;
        border: 1.5px solid #b2dfdb;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.08);
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
    }
    .upload-lpj-icon {
        font-size: 2.7rem;
        color: #26a69a;
        margin-bottom: 0.5rem;
    }
    .upload-lpj-title {
        color: #00897b;
        font-weight: 600;
    }
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="upload-lpj-card">
                <div class="text-center mb-4">
                    <div class="upload-lpj-icon"><i class="fas fa-file-invoice"></i></div>
                    <h3 class="upload-lpj-title">Upload LPJ - {{ $progja->nama_progja }}</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('progja.store.lpj', $progja) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_progja" class="form-label">Nama Progja</label>
                        <input type="text" class="form-control" id="nama_progja" value="{{ $progja->nama_progja }}" readonly>
                        <div class="form-text">Nama progja tidak dapat diubah</div>
                    </div>
                    @php
                        $fileLpj = $progja->files->where('jenis', 'lpj')->first();
                        $fileSurat = $progja->files->where('jenis', 'surat_pengantar')->where('keterangan', 'Surat Pengantar LPJ')->first();
                    @endphp
                    @if($fileLpj)
                        <div class="mb-2">
                            <span class="text-success">File LPJ sebelumnya: </span>
                            <a href="{{ asset('storage/' . $fileLpj->path_file) }}" target="_blank">{{ $fileLpj->nama_file }}</a>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="lpj" class="form-label">File LPJ (PDF)</label>
                        <div class="mb-2">
                            <small class="text-muted">
                                <strong>Format penulisan:</strong> LPJ_Peldakom_HMPSIF_2025
                            </small>
                        </div>
                        <input type="file" class="form-control @error('lpj') is-invalid @enderror" 
                               id="lpj" name="lpj" accept=".pdf" required>
                        <div class="form-text">Format: PDF, Maksimal: 10MB</div>
                        @error('lpj')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="surat_pengantar" class="form-label">Surat Pengantar LPJ (PDF)</label>
                        @if($fileSurat)
                            <div class="mb-2">
                                <span class="text-success">File Surat Pengantar LPJ sebelumnya: </span>
                                <a href="{{ asset('storage/' . $fileSurat->path_file) }}" target="_blank">{{ $fileSurat->nama_file }}</a>
                            </div>
                        @endif
                        <div class="mb-2">
                            <small class="text-muted">
                                <strong>Format penulisan:</strong> SuratPengantar_LPJ_Peldakom_HMPSIF_2025
                            </small>
                        </div>
                        <input type="file" class="form-control @error('surat_pengantar') is-invalid @enderror" 
                               id="surat_pengantar" name="surat_pengantar" accept=".pdf" required>
                        <div class="form-text">Format: PDF, Maksimal: 2MB</div>
                        @error('surat_pengantar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('progja.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-upload"></i> Upload LPJ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 