<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Workpermit\WorkPermitController;
use App\Http\Controllers\Workpermit\DashboardController;
use App\Http\Controllers\Workpermit\PurchaseOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Workpermit\KlasifikasiPekerjaanController;
use App\Http\Controllers\Workpermit\VendorController;
use App\Http\Controllers\Workpermit\JamKerjaController;

// Admin
Route::middleware(['auth', 'checkUserActive', 'GetMenus'])->prefix('admin')->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Vendor
    Route::get('/vendors', [VendorController::class, 'index'])->name('admin.vendors.index');
    Route::get('/vendors/sinkron', [VendorController::class, 'getData'])->name('admin.vendors.sinkron');
    Route::get('/vendors/search', [VendorController::class, 'searchVendors'])->name('admin.vendors.search');

    // Klasifikasi Pekerjaan
    Route::get('/klasifikasi-pekerjaan', [KlasifikasiPekerjaanController::class, 'index'])->name('admin.klasifikasi.index');
    Route::get('/klasifikasi-pekerjaan/fetch', [KlasifikasiPekerjaanController::class, 'fetch'])->name('admin.klasifikasi.fetch');
    Route::get('/klasifikasi-pekerjaan/create', [KlasifikasiPekerjaanController::class, 'create'])->name('admin.klasifikasi.create');
    Route::post('/klasifikasi-pekerjaan', [KlasifikasiPekerjaanController::class, 'store'])->name('admin.klasifikasi.store');
    Route::get('/klasifikasi-pekerjaan/edit/{hash}', [KlasifikasiPekerjaanController::class, 'edit'])->name('admin.klasifikasi.edit');
    Route::post('/klasifikasi-pekerjaan/edit/{hash}', [KlasifikasiPekerjaanController::class, 'update'])->name('admin.klasifikasi.update');
    Route::delete('/klasifikasi-pekerjaan/{hash}', [KlasifikasiPekerjaanController::class, 'destroy'])->name('admin.klasifikasi.destroy');

    // Purchase Orders
    Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchasing.po.index');
    Route::get('/purchase-orders/fetch', [PurchaseOrderController::class, 'fetch'])->name('purchasing.po.fetch');
    Route::get('/purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchasing.po.create');
    Route::post('/purchase-orders', [PurchaseOrderController::class, 'store'])->name('purchasing.po.store');
    Route::post('/purchase-orders/cancel/{hash}', [PurchaseOrderController::class, 'cancel'])->name('purchasing.po.cancel');
    Route::get('/purchase-orders/detail/{hash}', [PurchaseOrderController::class, 'show'])->name('purchasing.po.detail');
    Route::get('/purchase-orders/edit/{hash}', [PurchaseOrderController::class, 'edit'])->name('purchasing.po.edit');
    Route::post('/purchase-orders/edit/{hash}', [PurchaseOrderController::class, 'update'])->name('purchasing.po.update');
});

Route::middleware(['auth', 'checkUserActive', 'GetMenus'])->prefix('permit')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('permit.dashboard');

    // Work Permit
    Route::get('/po', [WorkPermitController::class, 'index'])->name('permit.po.index');
    Route::get('/po/fetch', [WorkPermitController::class, 'fetch'])->name('permit.po.fetch');
    Route::get('/po/progres/{id}', [WorkPermitController::class, 'progres'])->name('permit.po.progres');
    Route::get('/po/progres/{id}/preview-pdf', [WorkPermitController::class, 'previewPdf'])->name('permit.workpermit.previewPdf');

    Route::get('/po/{id}/selesai', [WorkPermitController::class, 'ajukan'])->name("permit.po.selesai");
    Route::post('/penyelesaian/{id}/approve', [WorkPermitController::class, 'approveSelesai'])->name("permit.penyelesaian.approve");

    // Untuk role dengan permission approval (bukan vendor)
    Route::post('/po/{id}/approve', [WorkPermitController::class, 'approve'])->name('permit.po.approve');
    Route::post('/po/{id}/reject', [WorkPermitController::class, 'reject'])->name('permit.po.reject');
    Route::post('/pembatalan/{id}/approve', [WorkPermitController::class, 'approvePembatalan'])->name('permit.pembatalan.approve');
    Route::post('/pembatalan/{id}/reject', [WorkPermitController::class, 'rejectPembatalan'])->name('permit.pembatalan.reject');

    // Untuk role vendor (create dan step PO)
    Route::get('/po/create/{id}', [WorkPermitController::class, 'create'])->name('permit.po.create');
    Route::post('/po/step1', [WorkPermitController::class, 'storeStep1'])->name('permit.po.storeStep1');
    Route::post('/po/step2', [WorkPermitController::class, 'storeStep2'])->name('permit.po.storeStep2');
    Route::post('/po/step3', [WorkPermitController::class, 'storeStep3'])->name('permit.po.storeStep3');
    Route::post('/po/step4', [WorkPermitController::class, 'storeStep4'])->name('permit.po.storeStep4');

    // Jam Kerja Aman
    Route::get('/jam-kerja', [JamKerjaController::class, 'index'])->name('permit.jamkerja.index');
    Route::get('/jam-kerja/fetch', [JamKerjaController::class, 'fetch'])->name('permit.jamkerja.fetch');
    Route::get('/jam-kerja/create/{id}', [JamKerjaController::class, 'create'])->name('permit.jamkerja.create');
    Route::post('/jam-kerja/store', [JamKerjaController::class, 'store'])->name('permit.jamkerja.store');
    Route::get('/jam-kerja/detail/{id}/{periode}', [JamKerjaController::class, 'detail'])->name('permit.jamkerja.detail');
    Route::post('/jam-kerja/{id}/approve-she', [JamKerjaController::class, 'approveShe'])->name('permit.jamkerja.approve');
    Route::post('/jam-kerja/{id}/reject-she', [JamKerjaController::class, 'rejectShe'])->name('permit.jamkerja.reject');
    Route::get('/jam-kerja/preview/{id}/{periode}', [JamKerjaController::class, 'previewPdf'])->name('permit.jamkerja.preview');

    Route::get('/jam-kerja/statistik-bulan', [JamKerjaController::class, 'getStatistikBulan']);

    // Pembatalan oleh SHE Officer
    Route::post('/pembatalan/store', [WorkPermitController::class, 'store'])->name('permit.pembatalan.store');

    Route::get('/po/{encodedId}/print-all-periode', [WorkPermitController::class, 'printAllPeriode'])
        ->name('workpermit.printAllPeriode');
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
