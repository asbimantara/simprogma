@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
    }
    .progja-card {
        background: #ffffffcc;
        border: 1.5px solid #b2dfdb;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.08);
        padding: 2rem 1.5rem;
        margin-bottom: 2rem;
    }
</style>
<div class="container mt-5">
    <div class="progja-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 style="color:#00897b;">Daftar Program Kerja</h2>
            @php
                $isAdmin = auth()->user()->role === 'admin';
            @endphp
            @if(!$isAdmin)
                <a href="{{ route('progja.create') }}" class="btn btn-primary">Tambah Progja</a>
            @endif
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(!$isAdmin)
            <div class="alert alert-secondary mb-2" style="font-size: 0.95em;">
                <i class="fas fa-info-circle"></i> Urutan daftar program kerja di bawah ini sudah disesuaikan berdasarkan tanggal pelaksanaan.
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">No</th>
                        <th class="text-center" style="max-width: 120px; min-width: 80px;">Nama Progja</th>
                        <th class="text-center" style="width: 100px;">Tanggal</th>
                        <th class="text-center" style="width: 90px;">Kategori</th>
                        <th class="text-center" @if($isAdmin) style="width: 100px;" @else style="width: 140px;" @endif>Anggaran</th>
                        @if(!$isAdmin)
                            <th class="text-center" style="width: 145px;">Aksi Proposal</th>
                        @endif
                        <th class="text-center" style="width: 145px;">Status Proposal</th>
                        @if(!$isAdmin)
                            <th class="text-center" style="width: 145px;">Aksi LPJ</th>
                        @endif
                        <th class="text-center" style="width: 145px;">Status LPJ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($progjas as $progja)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td @if($isAdmin) style="width: 150px;" @else style="max-width: 120px; min-width: 80px;" @endif>
                            <a href="{{ route('progja.show', $progja) }}" class="text-primary fw-bold text-decoration-none" style="display: block; width: 100%; @if($isAdmin) white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; @else white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; @endif">
                                {{ $progja->nama_progja }}
                            </a>
                        </td>
                        <td class="text-center" style="width: 100px;">{{ $progja->tanggal_pelaksanaan }}</td>
                        <td class="text-center" style="width: 90px;">{{ $progja->kategori }}</td>
                        <td @if($isAdmin) style="width: 100px;" @else style="width: 140px;" @endif>Rp {{ number_format($progja->anggaran, 0, ',', '.') }}</td>
                        @if(!$isAdmin)
                            <td style="width: 145px;">
                                @php $proposal = $progja->files->where('jenis','proposal')->first(); $status = $progja->status->nama_status ?? ''; @endphp
                                @if((in_array($status, ['Draft', 'Revisi']) && !$proposal))
                                    <a href="{{ route('progja.upload.proposal', $progja) }}" class="btn btn-sm btn-success @if($status === 'Sedang Dikoreksi' || $status === 'Disetujui') disabled @endif">Upload</a>
                                @elseif($proposal)
                                    <a href="{{ route('progja.upload.proposal', $progja) }}" class="btn btn-sm btn-warning @if($status === 'Sedang Dikoreksi' || $status === 'Disetujui') disabled @endif">Edit</a>
                                    <form action="{{ route('progja.deleteProposal', $progja) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus proposal?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger @if($status === 'Sedang Dikoreksi' || $status === 'Disetujui') disabled @endif">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        @endif
                        <td style="width: 145px; vertical-align: middle;">
                            @php
                                $statusClass = '';
                                $statusNama = $progja->status->nama_status ?? '-';
                                switch($statusNama) {
                                    case 'Draft':
                                        $statusClass = 'badge bg-secondary';
                                        break;
                                    case 'Diajukan':
                                        $statusClass = 'badge bg-warning';
                                        break;
                                    case 'Revisi':
                                        $statusClass = 'badge bg-info';
                                        break;
                                    case 'Disetujui':
                                        $statusClass = 'badge bg-success';
                                        break;
                                    case 'Ditolak':
                                        $statusClass = 'badge bg-danger';
                                        break;
                                    case 'Sedang Dikoreksi':
                                        $statusClass = 'badge bg-primary';
                                        break;
                                    default:
                                        $statusClass = 'badge bg-secondary';
                                }
                            @endphp
                            @if(!$isAdmin)
                                @if($statusNama === 'Draft')
                                    <span class="{{ $statusClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalStatusDraft-{{ $progja->id }}">{{ $statusNama }}</span>
                                    <!-- Modal Draft -->
                                    <div class="modal fade" id="modalStatusDraft-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalStatusDraftLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalStatusDraftLabel-{{ $progja->id }}">Status: Draft</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Anda harus mengajukan proposal bila butuh dana.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @elseif($statusNama === 'Diajukan')
                                    <span class="{{ $statusClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalStatusDiajukan-{{ $progja->id }}">{{ $statusNama }}</span>
                                    <!-- Modal Diajukan -->
                                    <div class="modal fade" id="modalStatusDiajukan-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalStatusDiajukanLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalStatusDiajukanLabel-{{ $progja->id }}">Status: Diajukan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Tunggu admin untuk mengkoreksi, pastikan anda tidak merubah apapun dalam kurun waktu 10 hari sebelum hari H.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @elseif($statusNama === 'Sedang Dikoreksi')
                                    <span class="{{ $statusClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalStatusKoreksi-{{ $progja->id }}">{{ $statusNama }}</span>
                                    <!-- Modal Sedang Dikoreksi -->
                                    <div class="modal fade" id="modalStatusKoreksi-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalStatusKoreksiLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalStatusKoreksiLabel-{{ $progja->id }}">Status: Sedang Dikoreksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Tunggu, admin sedang mengkoreksi, anda tidak dapat mengedit dan menghapus progja.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @elseif($statusNama === 'Disetujui')
                                    <span class="{{ $statusClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalStatusDisetujui-{{ $progja->id }}">{{ $statusNama }}</span>
                                    <!-- Modal Disetujui -->
                                    <div class="modal fade" id="modalStatusDisetujui-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalStatusDisetujuiLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalStatusDisetujuiLabel-{{ $progja->id }}">Status: Disetujui</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Selamat permohonan dana anda disetujui, tunggu biro 1 untuk menghubungi anda lewat grup tentang pencairan dananya kapan, dan jangan lupa setelah hari H sudah harus upload LPJ maksimal h+2 minggu ya, terima kasih.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @elseif($statusNama === 'Revisi')
                                    <span class="{{ $statusClass }}">{{ $statusNama }}</span>
                                @else
                                    <span class="{{ $statusClass }}">{{ $statusNama }}</span>
                                @endif
                            @else
                                <span class="{{ $statusClass }}">{{ $statusNama }}</span>
                            @endif
                            @if(($progja->status->nama_status ?? '') === 'Revisi')
                                <a href="{{ route('progja.keteranganRevisi', $progja) }}" class="btn btn-sm btn-outline-info ms-2">Detail</a>
                            @endif
                            @if(auth()->user()->role == 'admin')
                                <form action="{{ route('progja.updateStatus', $progja) }}" method="POST" style="display:inline; margin-top: 4px;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_id" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto mt-1">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $progja->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->nama_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </td>
                        @if(!$isAdmin)
                            <td style="width: 145px;">
                                @php $lpj = $progja->files->where('jenis','lpj')->first(); $status = $progja->status->nama_status ?? ''; $statusLpj = $progja->status_lpj ?? null; @endphp
                                @if($status === 'Disetujui' && !$lpj)
                                    <a href="{{ route('progja.upload.lpj', $progja) }}" class="btn btn-sm btn-info">Upload</a>
                                @elseif($lpj)
                                    <a href="{{ route('progja.upload.lpj', $progja) }}" class="btn btn-sm btn-warning @if($statusLpj === 'Sedang Dikoreksi' || $statusLpj === 'Disetujui') disabled @endif">Edit</a>
                                    <form action="{{ route('progja.deleteLpj', $progja) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus LPJ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger @if($statusLpj === 'Sedang Dikoreksi' || $statusLpj === 'Disetujui') disabled @endif">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        @endif
                        <td style="width: 145px; vertical-align: middle;">
                            @php
                                $lpjFile = $progja->files->where('jenis', 'lpj')->first();
                                $statusLpj = $progja->status_lpj ?? null;
                                $statusLpjClass = '';
                                switch($statusLpj) {
                                    case 'Draft':
                                        $statusLpjClass = 'badge bg-secondary';
                                        break;
                                    case 'Diajukan':
                                        $statusLpjClass = 'badge bg-warning';
                                        break;
                                    case 'Revisi':
                                        $statusLpjClass = 'badge bg-info';
                                        break;
                                    case 'Disetujui':
                                        $statusLpjClass = 'badge bg-success';
                                        break;
                                    case 'Ditolak':
                                        $statusLpjClass = 'badge bg-danger';
                                        break;
                                    case 'Sedang Dikoreksi':
                                        $statusLpjClass = 'badge bg-primary';
                                        break;
                                    default:
                                        $statusLpjClass = 'badge bg-secondary';
                                }
                            @endphp
                            @if($isAdmin)
                                <span class="{{ $statusLpjClass }}">{{ $statusLpj ?? 'Draft' }}</span>
                                @if($statusLpj === 'Revisi')
                                    <a href="{{ route('progja.keteranganRevisi', $progja) }}?lpj=1" class="btn btn-sm btn-outline-info ms-2">Detail</a>
                                @endif
                                <form action="{{ route('progja.updateStatusLpj', $progja) }}" method="POST" style="display:inline; margin-top: 4px;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_lpj" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto mt-1" @if($progja->status->nama_status !== 'Disetujui') disabled @endif>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Draft" @if($statusLpj=='Draft') selected @endif>Draft</option>
                                        <option value="Diajukan" @if($statusLpj=='Diajukan') selected @endif>Diajukan</option>
                                        <option value="Sedang Dikoreksi" @if($statusLpj=='Sedang Dikoreksi') selected @endif>Sedang Dikoreksi</option>
                                        <option value="Revisi" @if($statusLpj=='Revisi') selected @endif>Revisi</option>
                                        <option value="Disetujui" @if($statusLpj=='Disetujui') selected @endif>Disetujui</option>
                                        <option value="Ditolak" @if($statusLpj=='Ditolak') selected @endif>Ditolak</option>
                                    </select>
                                </form>
                            @else
                                @if($statusLpj === 'Diajukan')
                                    <span class="{{ $statusLpjClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalLpjDiajukan-{{ $progja->id }}">{{ $statusLpj }}</span>
                                    <div class="modal fade" id="modalLpjDiajukan-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalLpjDiajukanLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalLpjDiajukanLabel-{{ $progja->id }}">Status LPJ: Diajukan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Tunggu admin untuk mengkoreksi LPJ Anda. Mohon untuk tidak mengedit dan menghapus maksimal h-10 kegiatan.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @elseif($statusLpj === 'Sedang Dikoreksi')
                                    <span class="{{ $statusLpjClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalLpjKoreksi-{{ $progja->id }}">{{ $statusLpj }}</span>
                                    <div class="modal fade" id="modalLpjKoreksi-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalLpjKoreksiLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalLpjKoreksiLabel-{{ $progja->id }}">Status LPJ: Sedang Dikoreksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Tunggu, admin sedang mengkoreksi LPJ Anda, Anda tidak dapat mengedit atau menghapus LPJ.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @elseif($statusLpj === 'Revisi')
                                    <span class="{{ $statusLpjClass }}">{{ $statusLpj }}</span>
                                    <a href="{{ route('progja.keteranganRevisi', $progja) }}?lpj=1" class="btn btn-sm btn-outline-info ms-2">Detail</a>
                                @elseif($statusLpj === 'Disetujui')
                                    <span class="{{ $statusLpjClass }}" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalLpjDisetujui-{{ $progja->id }}">{{ $statusLpj }}</span>
                                    <div class="modal fade" id="modalLpjDisetujui-{{ $progja->id }}" tabindex="-1" aria-labelledby="modalLpjDisetujuiLabel-{{ $progja->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalLpjDisetujuiLabel-{{ $progja->id }}">Status LPJ: Disetujui</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Selamat, LPJ Anda telah disetujui admin.
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @else
                                    <span class="{{ $statusLpjClass }}">{{ $statusLpj ?? 'Draft' }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada program kerja.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $progjas->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush 