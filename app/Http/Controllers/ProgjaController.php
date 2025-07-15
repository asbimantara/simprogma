<?php

namespace App\Http\Controllers;

use App\Models\Progja;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\ProgjaRequest;
use Illuminate\Support\Facades\Auth;

class ProgjaController extends Controller
{
    public function index()
    {
        $progjas = Progja::with(['status', 'user', 'files'])->orderBy('tanggal_pelaksanaan', 'asc')->paginate(10);
        $statuses = \App\Models\Status::all();
        return view('progja.index', compact('progjas', 'statuses'));
    }

    public function create()
    {
        $statuses = Status::all();
        return view('progja.create', compact('statuses'));
    }

    public function store(ProgjaRequest $request)
    {
        $data = $request->validated();
        $request->validate([
            'anggaran' => 'required|numeric|min:0',
        ]);
        // Validasi anggaran maksimal 9.999.999.999
        if (isset($data['anggaran']) && $data['anggaran'] > 9999999999) {
            return back()->withInput()->withErrors(['anggaran' => 'Anggaran maksimal adalah 9.999.999.999']);
        }
        $data['user_id'] = Auth::id();
        $progja = Progja::create($data);

        // Handle file upload proposal
        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $path = $file->store('files/proposal', 'public');
            $progja->files()->create([
                'jenis' => 'proposal',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'uploaded_at' => now(),
            ]);
        }
        // Handle file upload LPJ
        if ($request->hasFile('lpj')) {
            $file = $request->file('lpj');
            $path = $file->store('files/lpj', 'public');
            $progja->files()->create([
                'jenis' => 'lpj',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'uploaded_at' => now(),
            ]);
        }
        return redirect()->route('progja.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function show(Progja $progja)
    {
        return view('progja.show', compact('progja'));
    }

    public function edit(Progja $progja)
    {
        $statuses = Status::all();
        return view('progja.edit', compact('progja', 'statuses'));
    }

    public function update(ProgjaRequest $request, Progja $progja)
    {
        $data = $request->validated();
        $request->validate([
            'anggaran' => 'required|numeric|min:0',
        ]);
        // Validasi anggaran maksimal 9.999.999.999
        if (isset($data['anggaran']) && $data['anggaran'] > 9999999999) {
            return back()->withInput()->withErrors(['anggaran' => 'Anggaran maksimal adalah 9.999.999.999']);
        }
        $progja->update($data);
        // Handle file upload proposal
        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $path = $file->store('files/proposal', 'public');
            $progja->files()->create([
                'jenis' => 'proposal',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'uploaded_at' => now(),
            ]);
        }
        // Handle file upload LPJ
        if ($request->hasFile('lpj')) {
            $file = $request->file('lpj');
            $path = $file->store('files/lpj', 'public');
            $progja->files()->create([
                'jenis' => 'lpj',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'uploaded_at' => now(),
            ]);
        }
        return redirect()->route('progja.index')->with('success', 'Program kerja berhasil diupdate.');
    }

    public function destroy(Progja $progja)
    {
        $progja->delete();
        return redirect()->route('progja.index')->with('success', 'Program kerja berhasil dihapus.');
    }

    // Upload Proposal Methods
    public function uploadProposal(Progja $progja)
    {
        // Jika file proposal sudah tidak ada, hapus juga surat pengantar proposal lama
        $fileProposal = $progja->files()->where('jenis', 'proposal')->first();
        if (!$fileProposal) {
            $progja->files()->where('jenis', 'surat_pengantar')->where('keterangan', 'Surat Pengantar Proposal')->delete();
        }
        return view('progja.upload-proposal', compact('progja'));
    }

    public function storeProposal(Request $request, Progja $progja)
    {
        $request->validate([
            'proposal' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'surat_pengantar' => 'required|file|mimes:pdf|max:2048', // Max 2MB
        ]);

        // Delete existing proposal files if any
        $progja->files()->where('jenis', 'proposal')->delete();
        $progja->files()->where('jenis', 'surat_pengantar')->delete();

        // Upload proposal file
        $proposalFile = $request->file('proposal');
        $proposalPath = $proposalFile->store('files/proposal', 'public');
        
        $progja->files()->create([
            'jenis' => 'proposal',
            'nama_file' => $proposalFile->getClientOriginalName(),
            'path_file' => $proposalPath,
            'uploaded_at' => now(),
        ]);

        // Upload surat pengantar file
        $suratFile = $request->file('surat_pengantar');
        $suratPath = $suratFile->store('files/surat_pengantar', 'public');
        
        $progja->files()->create([
            'jenis' => 'surat_pengantar',
            'keterangan' => 'Surat Pengantar Proposal',
            'nama_file' => $suratFile->getClientOriginalName(),
            'path_file' => $suratPath,
            'uploaded_at' => now(),
        ]);

        // Update status to "Diajukan" after proposal upload
        $progja->update([
            'status_id' => Status::where('nama_status', 'Diajukan')->first()->id ?? 2
        ]);

        return redirect()->route('progja.index')->with('success', 'Proposal dan surat pengantar berhasil diupload.');
    }

    // Upload LPJ Methods
    public function uploadLpj(Progja $progja)
    {
        return view('progja.upload-lpj', compact('progja'));
    }

    public function storeLpj(Request $request, Progja $progja)
    {
        $request->validate([
            'lpj' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'surat_pengantar' => 'required|file|mimes:pdf|max:2048', // Max 2MB
        ]);

        // Delete existing LPJ and surat pengantar LPJ if any
        $progja->files()->where('jenis', 'lpj')->delete();
        $progja->files()->where('jenis', 'surat_pengantar')->where('keterangan', 'like', '%LPJ%')->delete();

        // Upload LPJ file
        $file = $request->file('lpj');
        $path = $file->store('files/lpj', 'public');
        $progja->files()->create([
            'jenis' => 'lpj',
            'nama_file' => $file->getClientOriginalName(),
            'path_file' => $path,
            'uploaded_at' => now(),
        ]);

        // Upload surat pengantar LPJ file
        $suratFile = $request->file('surat_pengantar');
        $suratPath = $suratFile->store('files/surat_pengantar', 'public');
        $progja->files()->create([
            'jenis' => 'surat_pengantar',
            'keterangan' => 'Surat Pengantar LPJ',
            'nama_file' => $suratFile->getClientOriginalName(),
            'path_file' => $suratPath,
            'uploaded_at' => now(),
        ]);

        // Set status LPJ menjadi Diajukan
        $progja->status_lpj = 'Diajukan';
        $progja->save();

        return redirect()->route('progja.index')->with('success', 'LPJ dan surat pengantar berhasil diupload.');
    }

    public function updateStatus(Request $request, Progja $progja)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);
        $progja->update(['status_id' => $request->status_id]);
        return back()->with('success', 'Status berhasil diubah.');
    }

    public function updateStatusLpj(Request $request, Progja $progja)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $request->validate([
            'status_lpj' => 'required|in:Draft,Diajukan,Sedang Dikoreksi,Revisi,Disetujui,Ditolak',
        ]);
        $progja->status_lpj = $request->status_lpj;
        $progja->save();
        return back()->with('success', 'Status LPJ berhasil diubah.');
    }

    public function deleteProposal(Progja $progja)
    {
        // Hapus file proposal saja
        $proposal = $progja->files()->where('jenis', 'proposal')->first();
        if ($proposal) {
            // Hapus file dari storage jika ada
            \Storage::disk('public')->delete($proposal->path_file);
            $proposal->delete();
        }
        // Hapus juga surat pengantar proposal jika ada
        $progja->files()->where('jenis', 'surat_pengantar')->where('keterangan', 'Surat Pengantar Proposal')->delete();
        // Jika status sebelumnya Diajukan, kembalikan ke Draft
        if ($progja->status && $progja->status->nama_status === 'Diajukan') {
            $draftStatus = \App\Models\Status::where('nama_status', 'Draft')->first();
            if ($draftStatus) {
                $progja->status_id = $draftStatus->id;
                $progja->save();
            }
        }
        return redirect()->route('progja.index')->with('success', 'File proposal berhasil dihapus.');
    }

    public function deleteLpj(Progja $progja)
    {
        // Hapus file LPJ
        $lpj = $progja->files()->where('jenis', 'lpj')->first();
        if ($lpj) {
            \Storage::disk('public')->delete($lpj->path_file);
            $lpj->delete();
        }
        // Hapus surat pengantar LPJ
        $progja->files()->where('jenis', 'surat_pengantar')->where('keterangan', 'Surat Pengantar LPJ')->delete();
        return redirect()->route('progja.index')->with('success', 'File LPJ berhasil dihapus.');
    }

    public function keteranganRevisi(Request $request, Progja $progja)
    {
        $isAdmin = auth()->user()->role === 'admin';
        $isLpj = $request->query('lpj') == 1;
        return view('progja.keterangan-revisi', compact('progja', 'isAdmin', 'isLpj'));
    }

    public function simpanKeteranganRevisi(Request $request, Progja $progja)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $isLpj = $request->query('lpj') == 1;
        $request->validate([
            'keterangan_revisi' => 'nullable|string',
        ]);
        if ($isLpj) {
            $progja->keterangan_revisi_lpj = $request->keterangan_revisi;
        } else {
            $progja->keterangan_revisi = $request->keterangan_revisi;
        }
        $progja->save();
        return redirect()->route('progja.index')->with('success', 'Keterangan revisi berhasil disimpan.');
    }
}
