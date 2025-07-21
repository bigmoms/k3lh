<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inspeksi\JadwalInspeksiController;
use App\Http\Controllers\Inspeksi\InspeksiController;
use App\Http\Controllers\Inspeksi\KategoriInspeksiController;
use App\Http\Controllers\Workpermit\DashboardController;


Route::middleware(['auth', 'checkUserActive', 'GetMenus'])->prefix('inspeksi')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("inspeksi.dashboard");

    Route::get('/kategori-inspeksi', [KategoriInspeksiController::class, 'index'])->name("inspeksi.kategori.index");
    Route::get('/kategori-inspeksi/fetch', [KategoriInspeksiController::class, 'fetch'])->name('inspeksi.kategori.fetch');
    Route::post('/kategori-inspeksi', [KategoriInspeksiController::class, 'store'])->name("inspeksi.kategori.store");
    Route::put('/kategori-inspeksi/{id}', [KategoriInspeksiController::class, 'update'])->name("inspeksi.kategori.update");
    Route::delete('/kategori-inspeksi/{id}', [KategoriInspeksiController::class, 'destroy'])->name("inspeksi.kategori.destroy");

    // Subkategori, tapi tetep lewat controller kategori
    Route::get('/kategori-inspeksi/{id}/subkategori', [KategoriInspeksiController::class, 'fetchSubkategori'])->name("inspeksi.kategori.subkategori.fetch");
    Route::post('/kategori-inspeksi/{id}/subkategori', [KategoriInspeksiController::class, 'storeSubkategori'])->name("inspeksi.kategori.subkategori.store");
    Route::put('/kategori-inspeksi/subkategori/{id}', [KategoriInspeksiController::class, 'updateSubkategori'])->name("inspeksi.kategori.subkategori.update");
    Route::delete('/kategori-inspeksi/subkategori/{id}', [KategoriInspeksiController::class, 'destroySubkategori'])->name("inspeksi.kategori.subkategori.destroy");

    Route::get('/jadwal-inspeksi', [JadwalInspeksiController::class, 'index'])->name("inspeksi.jadwal.index");
    Route::get('/jadwal/status-count', [JadwalInspeksiController::class, 'getStatusCount'])->name('inspeksi.jadwal.statusCount');
    Route::get('/jadwal-inspeksi/create', [JadwalInspeksiController::class, 'create'])->name("inspeksi.jadwal.create");
    Route::post('/jadwal-inspeksi', [JadwalInspeksiController::class, 'store'])->name("inspeksi.jadwal.store");
    Route::get('/jadwal-inspeksi/fetch', [JadwalInspeksiController::class, 'fetch'])->name("inspeksi.jadwal.fetch");
    Route::get('/jadwal-inspeksi/{id}', [JadwalInspeksiController::class, 'show'])->name("inspeksi.jadwal.show");
    Route::get('/jadwal-inspeksi/{id}/preview-nota', [JadwalInspeksiController::class, 'previewNotaDinas'])->name("inspeksi.jadwal.previewNotaDinas");

    Route::get('/hasil-inspeksi', [InspeksiController::class, 'index'])->name("inspeksi.hasil.index");
    Route::get('/hasil-inspeksi/fetch', [InspeksiController::class, 'fetch'])->name("inspeksi.hasil.fetch");
    Route::get('/hasil-inspeksi/create', [InspeksiController::class, 'create'])->name("inspeksi.hasil.create");
    Route::post('/hasil-inspeksi', [InspeksiController::class, 'store'])->name("inspeksi.hasil.store");
    Route::get('/hasil-inspeksi/{id}', [InspeksiController::class, 'show'])->name("inspeksi.hasil.show");
    Route::post('/hasil-inspeksi/perbaikan/{id}', [InspeksiController::class, 'updatePerbaikan'])->name("inspeksi.inspeksi.perbaikan");
    Route::put('/hasil-inspeksi/selesaikan/{id}', [InspeksiController::class, 'selesaikanInspeksi'])->name("inspeksi.inspeksi.selesaikan");
    Route::get('/hasil-inspeksi/{id}/preview', [InspeksiController::class, 'previewPdf'])
    ->name('inspeksi.previewPdf');

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
