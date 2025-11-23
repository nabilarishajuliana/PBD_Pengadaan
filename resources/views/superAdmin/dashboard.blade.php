@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="text-center mb-4">
    <h2 class="fw-bold text-primary">👑 Super Admin Dashboard</h2>
    <p class="text-muted">Semua modul tersedia untuk Anda</p>
</div>

<div class="row g-4">

    <!-- Barang -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.barang') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">🧺 Barang</h4>
                <p>Kelola semua data barang</p>
            </div>
        </a>
    </div>

    <!-- Vendor -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.vendor') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">🏢 Vendor</h4>
                <p>Kelola data vendor</p>
            </div>
        </a>
    </div>

    <!-- Margin -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.margin') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">💰 Margin Penjualan</h4>
                <p>Atur margin keuntungan</p>
            </div>
        </a>
    </div>

    <!-- Satuan -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.satuan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">⚖️ Satuan</h4>
                <p>Kelola satuan barang</p>
            </div>
        </a>
    </div>

    <!-- Role -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.role') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">👥 Role</h4>
                <p>Kelola role user</p>
            </div>
        </a>
    </div>

    <!-- User -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.user') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">🙋‍♀️ User</h4>
                <p>Daftar pengguna sistem</p>
            </div>
        </a>
    </div>

    <!-- Transaksi -->
    <div class="col-md-4">
        <a href="{{ route('superadmin.pengadaan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">📦 Pengadaan</h4>
                <p>Lihat transaksi pengadaan</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('superadmin.penerimaan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">📥 Penerimaan</h4>
                <p>Lihat penerimaan barang</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('superadmin.penjualan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">💸 Penjualan</h4>
                <p>Lihat transaksi penjualan</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('superadmin.retur') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">↩️ Retur</h4>
                <p>Lihat retur barang ke vendor</p>
            </div>
        </a>
    </div>

</div>
@endsection
