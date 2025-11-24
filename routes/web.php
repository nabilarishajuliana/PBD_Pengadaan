<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\vBarangController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\KartuStokController;



// Route::get('/', function () {
//     return view('welcome');
// });

//cek koneksi
Route::get('/cek-koneksi', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Koneksi database berhasil!";
    } catch (\Exception $e) {
        return "❌ Koneksi database gagal: " . $e->getMessage();
    }
});

/// ===============================================================
/// 🔐 Login & Logout Routes
/// ===============================================================
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


/// ===============================================================
/// 🏠 Dashboard (auto role redirect handled by controller)
/// ===============================================================
// Route::get('/', [DashboardController::class, 'index']);

/// ===============================================================
/// 👑 SUPER ADMIN AREA (semua akses)
/// ===============================================================
// Route::middleware(['auth.custom', 'role:superAdmin'])->group(function () {

//     // Dashboard super admin
//     Route::get('/superadmin/dashboard', fn() => view('superadmin.dashboard'));

//     // Master Data
//     Route::get('/barang', [vBarangController::class, 'index']);
//     Route::get('/barang/all', [vBarangController::class, 'all']);

//     Route::get('/vendor', [VendorController::class, 'index']);
//     Route::get('/vendor/all', [VendorController::class, 'all']);

//     Route::get('/margin', [MarginPenjualanController::class, 'index']);
//     Route::get('/margin/all', [MarginPenjualanController::class, 'all']);

//     Route::get('/satuan', [SatuanController::class, 'index']);
//     Route::get('/satuan/all', [SatuanController::class, 'all']);

//     Route::get('/role', [RoleController::class, 'index']);
//     Route::get('/user', [UserController::class, 'index']);

//     // Transaksi
//     Route::get('/pengadaan', [PengadaanController::class, 'index']);
//     Route::get('/pengadaan/{id}', [PengadaanController::class, 'show'])->whereNumber('id');

//     Route::get('/penerimaan', [PenerimaanController::class, 'index']);
//     Route::get('/penerimaan/{id}', [PenerimaanController::class, 'show'])->whereNumber('id');

//     Route::get('/penjualan', [PenjualanController::class, 'index']);
//     Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->whereNumber('id');

//     Route::get('/retur', [ReturController::class, 'index']);
//     Route::get('/retur/{id}', [ReturController::class, 'show'])->whereNumber('id');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

/// ===============================================================
/// 👑 SUPER ADMIN AREA
/// ===============================================================
Route::middleware(['auth.custom', 'role:superAdmin'])
    ->prefix('superadmin')
    ->as('superadmin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'superAdmin'])->name('dashboard');

        // === MASTER DATA ===
        Route::controller(vBarangController::class)->group(function () {
            Route::get('/barang', 'index')->name('barang');
            Route::get('/barang/all', 'all')->name('barang.all');
        });

        Route::controller(VendorController::class)->group(function () {
            Route::get('/vendor', 'index')->name('vendor');
            Route::get('/vendor/all', 'all')->name('vendor.all');
        });

        Route::controller(MarginPenjualanController::class)->group(function () {
            Route::get('/margin', 'index')->name('margin');
            Route::get('/margin/all', 'all')->name('margin.all');
        });

        Route::controller(SatuanController::class)->group(function () {
            Route::get('/satuan', 'index')->name('satuan');
            Route::get('/satuan/all', 'all')->name('satuan.all');
        });

        Route::get('/role', [RoleController::class, 'index'])->name('role');
        Route::get('/user', [UserController::class, 'index'])->name('user');

        // === TRANSAKSI ===
        Route::controller(PengadaanController::class)->group(function () {
            Route::get('/pengadaan', 'index')->name('pengadaan');
            Route::get('/pengadaan/create', 'create')->name('pengadaan.create'); // ✨ TAMBAH
            Route::post('/pengadaan/store', 'store')->name('pengadaan.store'); // ✨ SIMPAN
            Route::get('/pengadaan/{id}', 'show')->whereNumber('id')->name('pengadaan.show');
        });

        Route::controller(PenerimaanController::class)->group(function () {
            Route::get('/penerimaan', 'index')->name('penerimaan');
            Route::get('/penerimaan/create', 'create')->name('penerimaan.create');
            Route::get('/penerimaan/items/{idpengadaan}', 'getItemsByPengadaan')->whereNumber('idpengadaan')->name('penerimaan.items');
            Route::post('/penerimaan/store', 'store')->name('penerimaan.store');
            Route::get('/penerimaan/{id}', 'show')->whereNumber('id')->name('penerimaan.show');
        });

        Route::controller(PenjualanController::class)->group(function () {
            Route::get('/penjualan', 'index')->name('penjualan');
            Route::get('/penjualan/create', 'create')->name('penjualan.create'); // ✨ TAMBAH
            Route::post('/penjualan/store', 'store')->name('penjualan.store'); // ✨ SIMPAN
            Route::post('/penjualan/calculate-price', 'calculatePrice')->name('penjualan.calculatePrice'); // ✨ AJAX
            Route::get('/penjualan/{id}', 'show')->whereNumber('id')->name('penjualan.show');
        });

        Route::controller(ReturController::class)->group(function () {
            Route::get('/retur', 'index')->name('retur');
            Route::get('/retur/{id}', 'show')->whereNumber('id')->name('retur.show');
        });

        Route::controller(KartuStokController::class)->group(function () {
            Route::get('/kartustok', 'index')->name('kartustok'); // List dengan filter
            Route::get('/kartustok/rekap', 'rekap')->name('kartustok.rekap'); // Rekap stok per barang
            Route::get('/kartustok/detail/{idbarang}', 'detail')->whereNumber('idbarang')->name('kartustok.detail'); // Detail per barang
        });
    });

Route::middleware(['auth.custom', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::controller(vBarangController::class)->group(function () {
            Route::get('/barang', 'index')->name('barang');
            Route::get('/barang/all', 'all')->name('barang.all');
        });

        // === TRANSAKSI ===
        Route::controller(PengadaanController::class)->group(function () {
            Route::get('/pengadaan', 'index')->name('pengadaan');
            Route::get('/pengadaan/{id}', 'show')->whereNumber('id')->name('pengadaan.show');
        });

        Route::controller(PenerimaanController::class)->group(function () {
            Route::get('/penerimaan', 'index')->name('penerimaan');
            Route::get('/penerimaan/{id}', 'show')->whereNumber('id')->name('penerimaan.show');
        });

        Route::controller(PenjualanController::class)->group(function () {
            Route::get('/penjualan', 'index')->name('penjualan');
            Route::get('/penjualan/{id}', 'show')->whereNumber('id')->name('penjualan.show');
        });

        Route::controller(ReturController::class)->group(function () {
            Route::get('/retur', 'index')->name('retur');
            Route::get('/retur/{id}', 'show')->whereNumber('id')->name('retur.show');
        });
    });
// -------------------------------------------------------------------

// Route::get('/barang', [vBarangController::class, 'index']);     // Barang aktif
// Route::get('/barang/all', [vBarangController::class, 'all']);
// Route::get('/vendor', [VendorController::class, 'index']);
// Route::get('/vendor/all', [VendorController::class, 'all']);

// use App\Http\Controllers\MarginPenjualanController;

// Route::get('/margin', [MarginPenjualanController::class, 'index']);
// Route::get('/margin/all', [MarginPenjualanController::class, 'all']);

// use App\Http\Controllers\SatuanController;

// Route::get('/satuan', [SatuanController::class, 'index']);
// Route::get('/satuan/all', [SatuanController::class, 'all']);

// use App\Http\Controllers\RoleController;

// Route::get('/role', [RoleController::class, 'index']);

// use App\Http\Controllers\UserController;

// Route::get('/user', [UserController::class, 'index']);

// use App\Http\Controllers\DashboardController;

// Route::get('/', [DashboardController::class, 'index']);

// use App\Http\Controllers\PengadaanController;

// Route::get('/pengadaan', [PengadaanController::class, 'index']);
// Route::get('/pengadaan/{id}', [PengadaanController::class, 'show'])->whereNumber('id');


// use App\Http\Controllers\PenerimaanController;

// Route::get('/penerimaan', [PenerimaanController::class, 'index']);
// Route::get('/penerimaan/{id}', [PenerimaanController::class, 'show'])->whereNumber('id');

// use App\Http\Controllers\PenjualanController;

// Route::get('/penjualan', [PenjualanController::class, 'index']);
// Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->whereNumber('id');

// use App\Http\Controllers\ReturController;

// Route::get('/retur', [ReturController::class, 'index']);
// Route::get('/retur/{id}', [ReturController::class, 'show']);
