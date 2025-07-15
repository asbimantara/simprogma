@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .detail-progja-card {
        background: #ffffffcc;
        border: 1.5px solid #b2dfdb;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.08);
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
    }
    .detail-progja-icon {
        font-size: 2.7rem;
        color: #26a69a;
        margin-bottom: 0.5rem;
    }
    .detail-progja-title {
        color: #00897b;
        font-weight: 600;
    }
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="detail-progja-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="detail-progja-icon"><i class="fas fa-clipboard-list"></i></div>
                    <h2 class="detail-progja-title mb-0">Detail Program Kerja</h2>
                    <div class="btn-group" role="group">
                        @php $isAdmin = auth()->user()->role === 'admin'; @endphp
                        @if($isAdmin)
                            <a href="{{ route('progja.edit', $progja) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <!-- Tombol Hapus dengan trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusProgja">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="modalHapusProgja" tabindex="-1" aria-labelledby="modalHapusProgjaLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="modalHapusProgjaLabel"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <p class="mb-3" style="font-size:1.1em;">Apakah Anda yakin ingin menghapus program kerja ini?</p>
                                    <div class="mb-2">
                                        <i class="fas fa-trash-alt fa-3x text-danger"></i>
                                    </div>
                                    <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                                  </div>
                                  <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('progja.destroy', $progja) }}" method="POST" class="d-inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @else
                            @if(($progja->status->nama_status ?? '') === 'Disetujui')
                                <a href="#" class="btn btn-warning disabled" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger disabled" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            @elseif(($progja->status->nama_status ?? '') === 'Sedang Dikoreksi')
                                <a href="#" class="btn btn-warning disabled" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger disabled" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            @else
                                <a href="{{ route('progja.edit', $progja) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <!-- Tombol Hapus dengan trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusProgja">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                                <!-- Modal Konfirmasi Hapus (user) -->
                                <div class="modal fade" id="modalHapusProgja" tabindex="-1" aria-labelledby="modalHapusProgjaLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="modalHapusProgjaLabel"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                        <p class="mb-3" style="font-size:1.1em;">Apakah Anda yakin ingin menghapus program kerja ini?</p>
                                        <div class="mb-2">
                                            <i class="fas fa-trash-alt fa-3x text-danger"></i>
                                        </div>
                                        <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                                      </div>
                                      <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('progja.destroy', $progja) }}" method="POST" class="d-inline m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(!$isAdmin && ($progja->status->nama_status ?? '') === 'Disetujui')
                    <div class="alert alert-info mt-3">
                        <strong>Program kerja sudah disetujui.</strong><br>
                        Anda tidak dapat mengedit atau menghapus progja ini.<br>
                        Silakan tunggu biro 1 menginfokan pencairan dana di grup Ormawa.
                    </div>
                @endif
                @if(!$isAdmin && ($progja->status_lpj ?? '') === 'Disetujui')
                    <div class="alert alert-success mt-3">
                        <strong>LPJ sudah disetujui.</strong><br>
                        Terimakasih, LPJnya benar, dan ditunggu proposal dan LPJ selanjutnya, semangat.
                    </div>
                @endif
                @if(!$isAdmin && ($progja->status->nama_status ?? '') === 'Sedang Dikoreksi')
                    <div class="alert alert-warning mt-3">
                        <strong>Program kerja sedang dikoreksi.</strong><br>
                        Anda tidak dapat mengedit atau menghapus progja ini sampai proses koreksi selesai.
                    </div>
                @endif
                <div class="mt-4">
                    <dl class="row">
                        <dt class="col-sm-4">Nama Progja</dt>
                        <dd class="col-sm-8">{{ $progja->nama_progja }}</dd>

                        <dt class="col-sm-4">Tanggal Pelaksanaan</dt>
                        <dd class="col-sm-8">{{ $progja->tanggal_pelaksanaan }}</dd>

                        <dt class="col-sm-4">Sasaran</dt>
                        <dd class="col-sm-8">{{ $progja->sasaran }}</dd>

                        <dt class="col-sm-4">Hasil yang Dicapai</dt>
                        <dd class="col-sm-8">{{ $progja->hasil }}</dd>

                        <dt class="col-sm-4">Indikator Keberhasilan</dt>
                        <dd class="col-sm-8">{{ $progja->indikator }}</dd>

                        <dt class="col-sm-4">Penanggung Jawab</dt>
                        <dd class="col-sm-8">{{ $progja->penanggung_jawab }}</dd>

                        <dt class="col-sm-4">Kategori</dt>
                        <dd class="col-sm-8">{{ $progja->kategori }}</dd>

                        <dt class="col-sm-4">Anggaran</dt>
                        <dd class="col-sm-8">Rp {{ number_format($progja->anggaran, 0, ',', '.') }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ $progja->status->nama_status ?? '-' }}</dd>

                        <dt class="col-sm-4">Proposal</dt>
                        <dd class="col-sm-8">
                            @php $proposal = $progja->files->where('jenis','proposal')->first(); @endphp
                            @if($proposal)
                                <a href="{{ asset('storage/'.$proposal->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> Download Proposal
                                </a>
                                <div class="small text-muted mt-1">Nama file: {{ $proposal->nama_file }}</div>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Surat Pengantar Proposal</dt>
                        <dd class="col-sm-8">
                            @php $suratPengantarProposal = $progja->files->where('jenis','surat_pengantar')->where('keterangan', 'Surat Pengantar Proposal')->first(); @endphp
                            @if($suratPengantarProposal)
                                <a href="{{ asset('storage/'.$suratPengantarProposal->path_file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i> Download Surat Pengantar Proposal
                                </a>
                                <div class="small text-muted mt-1">Nama file: {{ $suratPengantarProposal->nama_file }}</div>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </dd>
                        <dt class="col-sm-4">LPJ</dt>
                        <dd class="col-sm-8">
                            @php $lpj = $progja->files->where('jenis','lpj')->first(); @endphp
                            @if($lpj)
                                <a href="{{ asset('storage/'.$lpj->path_file) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-download"></i> Download LPJ
                                </a>
                                <div class="small text-muted mt-1">Nama file: {{ $lpj->nama_file }}</div>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </dd>
                        <dt class="col-sm-4">Surat Pengantar LPJ</dt>
                        <dd class="col-sm-8">
                            @php $suratPengantarLpj = $progja->files->where('jenis','surat_pengantar')->where('keterangan', 'Surat Pengantar LPJ')->first(); @endphp
                            @if($suratPengantarLpj)
                                <a href="{{ asset('storage/'.$suratPengantarLpj->path_file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i> Download Surat Pengantar LPJ
                                </a>
                                <div class="small text-muted mt-1">Nama file: {{ $suratPengantarLpj->nama_file }}</div>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </dd>
                    </dl>
                </div>
                <div class="mt-3">
                    <a href="{{ route('progja.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush 