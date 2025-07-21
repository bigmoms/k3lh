<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\Lingkungan\JadwalController;
use App\Http\Controllers\Lingkungan\HasilController;
use App\Http\Controllers\Lingkungan\IadlController;
use App\Http\Controllers\Lingkungan\IpbrController;
use App\Http\Controllers\Workpermit\DashboardController;


Route::middleware(['auth', 'checkUserActive', 'GetMenus'])->prefix('lingkungan')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("lingkungan.dashboard");

    Route::get('/lokasi-divisi', [LokasiController::class, 'index'])->name("divisi.lokasi.index");
    Route::get('/lokasi-divisi/fetch', [LokasiController::class, 'fetch'])->name('divisi.lokasi.fetch');
    Route::get('/lokasi-divisi/search', [LokasiController::class, 'searchLokasi'])->name("lokasi.search");

    Route::get('/lokasi-divisi/{id}/divisi', [LokasiController::class, 'fetchDivisi'])->name("divisi.lokasi.divisi.fetch");
    Route::post('/lokasi-divisi/{id}/divisi', [LokasiController::class, 'storeDivisi'])->name("divisi.lokasi.divisi.store");

    Route::get('/lokasi-divisi/{id}', [LokasiController::class, 'show'])->name("divisi.lokasi.show");
    Route::post('/lokasi-divisi', [LokasiController::class, 'store'])->name("divisi.lokasi.store");
    Route::put('/lokasi-divisi/{id}', [LokasiController::class, 'update'])->name("divisi.lokasi.update");
    Route::delete('/lokasi-divisi/{id}', [LokasiController::class, 'destroy'])->name("divisi.lokasi.destroy");

    Route::get('/jadwal-pengukuran', [JadwalController::class, 'index'])->name("lingkungan.jadwal.index");
    Route::get('/jadwal-pengukuran/status-count', [JadwalController::class, 'getStatusCount'])->name('lingkungan.jadwal.statusCount');
    Route::get('/jadwal-pengukuran/create', [JadwalController::class, 'create'])->name("lingkungan.jadwal.create");
    Route::post('/jadwal-pengukuran', [JadwalController::class, 'store'])->name("lingkungan.jadwal.store");
    Route::get('/jadwal-pengukuran/fetch', [JadwalController::class, 'fetch'])->name("lingkungan.jadwal.fetch");
    Route::get('/jadwal-pengukuran/{id}', [JadwalController::class, 'show'])->name("lingkungan.jadwal.show");
    Route::get('/jadwal-pengukuran/{id}/preview-nota', [JadwalController::class, 'previewNotaDinas'])->name("lingkungan.jadwal.previewNotaDinas");

    Route::get('/hasil-pengukuran', [HasilController::class, 'index'])->name("lingkungan.hasil.index");
    Route::get('/hasil-pengukuran/fetch', [HasilController::class, 'fetch'])->name("lingkungan.hasil.fetch");
    Route::get('/hasil-pengukuran/create', [HasilController::class, 'create'])->name("lingkungan.hasil.create");
    Route::get('/hasil-lingkungan/get-lokasi-divisi', [HasilController::class, 'getLokasiDivisi'])->name('lingkungan.getLokasiDivisi');
    Route::post('/hasil-pengukuran', [HasilController::class, 'store'])->name("lingkungan.hasil.store");
    Route::get('/hasil-pengukuran/{id}', [HasilController::class, 'show'])->name("lingkungan.hasil.show");
    Route::post('/hasil-pengukuran/perbaikan/{id}', [HasilController::class, 'updatePerbaikan'])->name("lingkungan.lingkungan.perbaikan");
    Route::put('/hasil-pengukuran/selesaikan/{id}', [HasilController::class, 'selesaikanInspeksi'])->name("lingkungan.lingkungan.selesaikan");
    Route::post('/hasil-pengukuran/{id}/konfirmasi', [HasilController::class, 'konfirmasiPenerimaan'])->name('pengukuran.konfirmasi');
    Route::get('/hasil-pengukuran/preview-pdf/{id}', [HasilController::class, 'previewPdf'])->name('pengukuran.previewPdf');


    Route::get('/iadl', [IadlController::class, 'index'])->name("lingkungan.iadl.index");
    Route::get('/iadl/fetch', [IadlController::class, 'fetch'])->name("lingkungan.iadl.fetch");
    Route::get('/iadl/create', [IadlController::class, 'create'])->name("lingkungan.iadl.create");
    Route::post('/iadl', [IadlController::class, 'store'])->name("lingkungan.iadl.store");
    Route::get('/iadl/{id}/detail', [IadlController::class, 'show'])->name("lingkungan.iadl.show");
    Route::get('/iadl/{id}/duplicate', [IadlController::class, 'duplicate'])->name('lingkungan.iadl.duplicate');
    Route::put('/iadl/{id}/peraturan', [IadlController::class, 'updatePeraturan'])->name('lingkungan.iadl.update-peraturan');
    // Route::get('/iadl/row', [IADLController::class, 'row'])->name('lingkungan.iadl.row');
    Route::get('/iadl/aktifitas-row', [IadlController::class, 'aktifitasRow'])->name('lingkungan.iadl.aktifitasRow');
    Route::get('/iadl/kegiatan-row', [IadlController::class, 'kegiatanRow'])->name('lingkungan.iadl.kegiatan-row');
    Route::get('/iadl/{id}/download', [IadlController::class, 'download'])->name('lingkungan.iadl.download');


    Route::get('/ipbr', [IpbrController::class, 'index'])->name("lingkungan.ipbr.index");
    Route::get('/ipbr/fetch', [IpbrController::class, 'fetch'])->name("lingkungan.ipbr.fetch");
    Route::get('/ipbr/create', [IpbrController::class, 'create'])->name("lingkungan.ipbr.create");
    // Route::get('/ipbr/row', [IpbrController::class, 'row'])->name('lingkungan.ipbr.row');
    Route::post('/ipbr', [IpbrController::class, 'store'])->name("lingkungan.ipbr.store");
    Route::get('/ipbr/{id}/detail', [IpbrController::class, 'show'])->name("lingkungan.ipbr.show");
    Route::get('/ipbr/{id}/duplicate', [IpbrController::class, 'duplicate'])->name('lingkungan.ipbr.duplicate');
    Route::put('/ipbr/{id}/peraturan', [IpbrController::class, 'updatePeraturan'])->name('lingkungan.ipbr.update-peraturan');
    Route::get('/ipbr/aktifitas-row', [IpbrController::class, 'aktifitasRow'])->name('lingkungan.ipbr.aktifitasRow');
    Route::get('/ipbr/kegiatan-row', [IpbrController::class, 'kegiatanRow'])->name('lingkungan.ipbr.kegiatan-row');
    Route::get('/ipbr/{id}/download', [IpbrController::class, 'download'])->name('lingkungan.ipbr.download');
});


// Global Notifications
// Route::middleware(['auth', 'checkUserActive'])->group(function () {
//     Route::post('/notifications/read/{id}', function ($id) {
//         $notif = auth()->user()->notifications()->find($id);
//         if ($notif) $notif->markAsRead();
//         return response()->json(['success' => true]);
//     })->name('notifications.read');

//     Route::get('/notifications/mark-all', function () {
//         auth()->user()->unreadNotifications->markAsRead();
//         return back();
//     })->name('notifications.markAll');
// });
