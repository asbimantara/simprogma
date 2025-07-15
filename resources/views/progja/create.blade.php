@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Program Kerja</h2>
    <form action="{{ route('progja.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_progja" class="form-label">Nama Progja</label>
            <input type="text" name="nama_progja" id="nama_progja" class="form-control" value="{{ old('nama_progja') }}" required maxlength="100">
            <div class="form-text"><span id="counter-nama_progja">100/0</span> karakter</div>
        </div>
        <div class="mb-3">
            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
            <input type="text" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control" value="{{ old('tanggal_pelaksanaan') }}" required readonly placeholder="Pilih tanggal pelaksanaan">
        </div>
        <div class="mb-3">
            <label for="sasaran" class="form-label">Sasaran</label>
            <input type="text" name="sasaran" id="sasaran" class="form-control" value="{{ old('sasaran') }}" required maxlength="100">
            <div class="form-text"><span id="counter-sasaran">100/0</span> karakter</div>
        </div>
        <div class="mb-3">
            <label for="hasil" class="form-label">Hasil yang Dicapai</label>
            <textarea name="hasil" id="hasil" class="form-control" maxlength="255">{{ old('hasil') }}</textarea>
            <div class="form-text"><span id="counter-hasil">255/0</span> karakter</div>
        </div>
        <div class="mb-3">
            <label for="indikator" class="form-label">Indikator Keberhasilan</label>
            <textarea name="indikator" id="indikator" class="form-control" maxlength="255">{{ old('indikator') }}</textarea>
            <div class="form-text"><span id="counter-indikator">255/0</span> karakter</div>
        </div>
        <div class="mb-3">
            <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" id="penanggung_jawab" class="form-control" value="{{ old('penanggung_jawab') }}" required maxlength="100">
            <div class="form-text"><span id="counter-penanggung_jawab">100/0</span> karakter</div>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori Progja</label>
            <select name="kategori" id="kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="RAB" {{ old('kategori') == 'RAB' ? 'selected' : '' }}>RAB</option>
                <option value="NON RAB" {{ old('kategori') == 'NON RAB' ? 'selected' : '' }}>NON RAB</option>
                <option value="Biasa" {{ old('kategori') == 'Biasa' ? 'selected' : '' }}>Progja Biasa</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="anggaran" class="form-label">Anggaran</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" name="anggaran" id="anggaran" class="form-control" value="{{ old('anggaran') }}" required maxlength="10" pattern="[0-9]*" inputmode="numeric">
            </div>
            <div class="form-text"><span id="counter-anggaran">10/0</span> karakter</div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('anggaran');
            const counter = document.getElementById('counter-anggaran');
            input.addEventListener('input', function() {
                // Hanya angka, tanpa titik
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
                counter.textContent = (10 - this.value.length) + '/' + this.value.length;
            });
            counter.textContent = (10 - input.value.length) + '/' + input.value.length;
        });
        </script>
        @php
            $isAdmin = auth()->user()->role === 'admin';
            $hasStatus = $statuses->count() > 0;
        @endphp
        @if($isAdmin)
            <div class="mb-3">
                <label for="status_id" class="form-label">Status</label>
                @if($hasStatus)
                    <select name="status_id" id="status_id" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->nama_status }}</option>
                        @endforeach
                    </select>
                @else
                    <div class="alert alert-warning">Belum ada data status. Hubungi admin untuk menambah status!</div>
                @endif
            </div>
        @else
            @if($hasStatus)
                <input type="hidden" name="status_id" value="{{ $statuses->first()->id }}">
            @else
                <div class="alert alert-warning">Belum ada data status. Hubungi admin untuk menambah status!</div>
            @endif
        @endif
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('progja.index') }}" class="btn btn-secondary">Batal</a>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateCounter(id, max) {
            const input = document.getElementById(id);
            const counter = document.getElementById('counter-' + id);
            function setCounter() {
                let length;
                if (id === 'anggaran') {
                    length = input.value.replace(/\D/g, '').length;
                } else {
                    length = input.value.length;
                }
                let sisa = Math.max(0, max - length);
                counter.textContent = sisa + '/' + Math.min(length, max);
            }
            input.addEventListener('input', setCounter);
            setCounter();
        }
        updateCounter('nama_progja', 100);
        updateCounter('sasaran', 100);
        updateCounter('hasil', 255);
        updateCounter('indikator', 255);
        updateCounter('penanggung_jawab', 100);
        updateCounter('anggaran', 10);
    });
    </script>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr('#tanggal_pelaksanaan', {
        dateFormat: 'Y-m-d',
        allowInput: false,
        disableMobile: true
    });
});
</script>
@endpush 