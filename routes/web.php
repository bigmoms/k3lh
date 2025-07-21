<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguangeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\MenusController;
use App\Http\Controllers\Admin\DivisionsController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HistoryStorageController;
use App\Http\Controllers\McuController;
use App\Http\Controllers\SettingNotifikasiController;
use App\Http\Controllers\UploadController;

// use App\Http\Controllers\Frontend\BlogController;
// use App\Http\Controllers\Frontend\HomepageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'GetMenus'])->name('home');

Route::middleware(['auth',  'checkUserActive', 'GetMenus'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        //======================= Menus ======================================
        Route::get('/menus', [MenusController::class, 'index'])->name('menus.index');
        Route::get('/getmenus', [MenusController::class, 'getmenus'])->name('menus.getmenus');
        Route::post('/menus', [MenusController::class, 'store'])->name('menus.store');
        Route::put('/menus/{menus}', [MenusController::class, 'update'])->name('menus.update');
        Route::get('/menus/{id}/edit', [MenusController::class, 'edit'])->name('menus.edit');

        Route::get('/divisi', [DivisionsController::class, 'index'])->name('divisi.index');
        Route::get('/divisi/sinkron', [DivisionsController::class, 'getData'])->name('divisi.sinkron');
        Route::get('/divisi/search', [DivisionsController::class, 'searchDivisi'])->name('divisi.search');


        //Change User Password
        Route::put('user/change-password', [UserController::class, 'changePassword'])->name('user.change_password');

        //Role and Permission Changes
        Route::get('role/{id}/assign-permission', [RoleController::class, 'assignPermission'])->name('role.assign.permission');
        Route::put('role/{id}/permission', [RoleController::class, 'updatePermission'])->name('update.role.permission');
        Route::get('user/{id}/assign-permission', [UserController::class, 'assignPermission'])->name('user.assign.permission');
        Route::put('user/{id}/permission', [UserController::class, 'updatePermission'])->name('update.user.permission');
        Route::get('user/{id}/assign-role', [UserController::class, 'assignRole'])->name('user.assign.role');
        Route::put('user/{id}/role', [UserController::class, 'updateRole'])->name('update.user.role');

        //User Route Resources
        Route::resource('user', UserController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);

        //Blog Resources
        Route::resource('category', CategoryController::class);
        Route::resource('post', PostController::class);

        //User Profile
        Route::get('profile/edit', [ProfileController::class, 'index'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::group(['prefix' => 'setting_notifikasi'], function () {
            Route::get('/', [SettingNotifikasiController::class, 'index'])->name('notif.index');
            Route::get('/json', [SettingNotifikasiController::class, 'json'])->name('notif.json');
            Route::get('/modal', [SettingNotifikasiController::class, 'modal'])->name('notif.modal');
            Route::post('/store', [SettingNotifikasiController::class, 'store'])->name('notif.store');
            Route::get('/push', [SettingNotifikasiController::class, 'push'])->name('notif.push');
            Route::get('/hapus', [SettingNotifikasiController::class, 'hapus'])->name('notif.hapus');
        });

        Route::group(['prefix' => 'mcu'], function () {
            Route::get('/', [McuController::class, 'index'])->name('mcu.index');
            Route::get('/json', [McuController::class, 'json'])->name('mcu.json');
            Route::get('/modal', [McuController::class, 'modal'])->name('mcu.modal');
            Route::post('/store', [McuController::class, 'store'])->name('mcu.store');
            Route::get('/push', [McuController::class, 'push'])->name('mcu.push');
            Route::get('/hapus', [McuController::class, 'hapus'])->name('mcu.hapus');
            Route::post('/import', [McuController::class, 'import'])->name('mcu.import');
        });

        Route::group(['prefix' => 'folders'], function () {
            Route::get('/', [FolderController::class, 'index'])->name('folders.index');
            Route::get('/modal', [FolderController::class, 'modal'])->name('folders.create');
            Route::post('/store', [FolderController::class, 'store'])->name('folders.store');
            Route::post('/upload-file', [UploadController::class, 'upload'])->name('upload.file');
            Route::get('/pengajuan', [FolderController::class, 'pengajuan']);
        });

        Route::group(['prefix' => 'history_storage'], function () {
            Route::get('/', [HistoryStorageController::class, 'index']);
            Route::get('/json', [HistoryStorageController::class, 'json']);
            Route::post('/terima/{id}', [HistoryStorageController::class, 'terima']);
            Route::post('/tolak/{id}', [HistoryStorageController::class, 'tolak']);
        });
    });
});
require base_path('routes/workpermit.php');
require base_path('routes/inspeksi.php');
require base_path('routes/lingkungan.php');
