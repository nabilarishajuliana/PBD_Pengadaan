<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\vBarangController;
use App\Http\Controllers\VendorController;



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

Route::get('/barang', [vBarangController::class, 'index']);     // Barang aktif
Route::get('/barang/all', [vBarangController::class, 'all']);
Route::get('/vendor', [VendorController::class, 'index']);
Route::get('/vendor/all', [VendorController::class, 'all']);

use App\Http\Controllers\MarginPenjualanController;

Route::get('/margin', [MarginPenjualanController::class, 'index']);
Route::get('/margin/all', [MarginPenjualanController::class, 'all']);

use App\Http\Controllers\SatuanController;

Route::get('/satuan', [SatuanController::class, 'index']);
Route::get('/satuan/all', [SatuanController::class, 'all']);

use App\Http\Controllers\RoleController;

Route::get('/role', [RoleController::class, 'index']);

use App\Http\Controllers\UserController;

Route::get('/user', [UserController::class, 'index']);

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);

use App\Http\Controllers\PengadaanController;

Route::get('/pengadaan', [PengadaanController::class, 'index']);
Route::get('/pengadaan/{id}', [PengadaanController::class, 'show'])->whereNumber('id');


use App\Http\Controllers\PenerimaanController;

Route::get('/penerimaan', [PenerimaanController::class, 'index']);
Route::get('/penerimaan/{id}', [PenerimaanController::class, 'show'])->whereNumber('id');

use App\Http\Controllers\PenjualanController;

Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->whereNumber('id');

use App\Http\Controllers\ReturController;

Route::get('/retur', [ReturController::class, 'index']);
Route::get('/retur/{id}', [ReturController::class, 'show']);
