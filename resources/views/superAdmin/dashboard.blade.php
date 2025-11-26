@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="text-center mb-5">
    <h1 class="fw-bold">👑 Super Admin Dashboard</h1>
    <p class="text-muted fs-5">Selamat datang, <strong>{{ session('username') }}</strong>! Kelola seluruh sistem dengan mudah.</p>
</div>

<!-- STATISTICS CARDS -->
<!-- <div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <div class="display-4 text-primary">📦</div>
                <h5 class="mt-2 mb-0">Total Barang</h5>
                <p class="text-muted mb-0">-</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <div class="display-4 text-success">💰</div>
                <h5 class="mt-2 mb-0">Penjualan Hari Ini</h5>
                <p class="text-muted mb-0">-</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <div class="display-4 text-warning">📊</div>
                <h5 class="mt-2 mb-0">Stok Menipis</h5>
                <p class="text-muted mb-0">-</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <div class="display-4 text-info">👥</div>
                <h5 class="mt-2 mb-0">Total User</h5>
                <p class="text-muted mb-0">-</p>
            </div>
        </div>
    </div>
</div> -->

<!-- MASTER DATA SECTION -->
<div class="mb-4">
    <h3 class="fw-bold mb-3">📋 Master Data</h3>
    <div class="row g-4">
        <div class="col-md-3">
            <a href="{{ route('superadmin.barang') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">📦</div>
                    <h4 class="text-primary mb-2">Barang</h4>
                    <p>Kelola data barang</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.vendor') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">🏢</div>
                    <h4 class="text-primary mb-2">Vendor</h4>
                    <p>Kelola data vendor</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.satuan') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">📏</div>
                    <h4 class="text-primary mb-2">Satuan</h4>
                    <p>Kelola satuan barang</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.margin') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">📊</div>
                    <h4 class="text-primary mb-2">Margin</h4>
                    <p>Atur margin penjualan</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.user') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">👥</div>
                    <h4 class="text-primary mb-2">User</h4>
                    <p>Kelola pengguna</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.role') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">🔐</div>
                    <h4 class="text-primary mb-2">Role</h4>
                    <p>Kelola role user</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- TRANSAKSI SECTION -->
<div class="mb-4">
    <h3 class="fw-bold mb-3">💼 Transaksi</h3>
    <div class="row g-4">
        <div class="col-md-3">
            <a href="{{ route('superadmin.pengadaan') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">🛒</div>
                    <h4 class="text-success mb-2">Pengadaan</h4>
                    <p>Kelola pengadaan barang</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.penerimaan') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">📥</div>
                    <h4 class="text-info mb-2">Penerimaan</h4>
                    <p>Terima barang dari vendor</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.penjualan') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">💰</div>
                    <h4 class="text-success mb-2">Penjualan</h4>
                    <p>Transaksi penjualan</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('superadmin.retur') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">↩️</div>
                    <h4 class="text-warning mb-2">Retur</h4>
                    <p>Retur barang ke vendor</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- KARTU STOK SECTION -->
<div class="mb-4">
    <h3 class="fw-bold mb-3">📊 Kartu Stok</h3>
    <div class="row g-4">
        
        <div class="col-md-6">
            <a href="{{ route('superadmin.kartustok') }}" class="text-decoration-none">
                <div class="dashboard-card bg-white shadow-sm p-4 text-center">
                    <div class="card-icon">📋</div>
                    <h4 class="text-primary mb-2">Riwayat Transaksi</h4>
                    <p>Lihat riwayat keluar masuk stok</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection