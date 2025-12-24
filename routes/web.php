<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgjaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes dinonaktifkan karena halaman kosong
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Progja routes
    Route::resource('progja', ProgjaController::class);
    Route::get('/progja/{progja}/upload/proposal', [ProgjaController::class, 'uploadProposal'])->name('progja.upload.proposal');
    Route::post('/progja/{progja}/upload/proposal', [ProgjaController::class, 'storeProposal'])->name('progja.store.proposal');
    Route::get('/progja/{progja}/upload/lpj', [ProgjaController::class, 'uploadLpj'])->name('progja.upload.lpj');
    Route::post('/progja/{progja}/upload/lpj', [ProgjaController::class, 'storeLpj'])->name('progja.store.lpj');
    Route::patch('/progja/{progja}/status', [ProgjaController::class, 'updateStatus'])->name('progja.updateStatus');
    Route::delete('/progja/{progja}/delete-proposal', [ProgjaController::class, 'deleteProposal'])->name('progja.deleteProposal');
    Route::get('/progja/{progja}/keterangan-revisi', [ProgjaController::class, 'keteranganRevisi'])->name('progja.keteranganRevisi');
    Route::post('/progja/{progja}/keterangan-revisi', [ProgjaController::class, 'simpanKeteranganRevisi'])->name('progja.simpanKeteranganRevisi');
    Route::delete('/progja/{progja}/delete-lpj', [ProgjaController::class, 'deleteLpj'])->name('progja.deleteLpj');
    Route::patch('/progja/{progja}/status-lpj', [ProgjaController::class, 'updateStatusLpj'])->name('progja.updateStatusLpj');
    // Route upload RAB sudah dihapus karena DashboardController tidak ada
    // Route Ormawa (tanpa middleware adminonly, agar tidak error)
    Route::get('/ormawa', [App\Http\Controllers\OrmawaController::class, 'index'])->name('ormawa.index');
});

require __DIR__ . '/auth.php';
