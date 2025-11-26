@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="text-center mb-4">
    <h2 class="fw-bold text-primary">🧑‍💼 Admin Dashboard</h2>
    <p class="text-muted">Anda hanya dapat mengelola transaksi harian</p>
</div>

<div class="row g-4 justify-content-center">

    <!-- Pengadaan -->
    <div class="col-md-5 col-lg-3">
        <a href="{{ route('admin.pengadaan') }}" class="text-decoration-none">
            <div class="p-4 bg-white shadow-sm dashboard-card rounded-4 text-center">
                <h4 class="text-primary mb-1">📦 Pengadaan</h4>
                <small class="text-muted">Transaksi pembelian barang</small>
            </div>
        </a>
    </div>

    <!-- Penerimaan -->
    <div class="col-md-5 col-lg-3">
        <a href="{{ route('admin.penerimaan') }}" class="text-decoration-none">
            <div class="p-4 bg-white shadow-sm dashboard-card rounded-4 text-center">
                <h4 class="text-primary mb-1">📥 Penerimaan</h4>
                <small class="text-muted">Barang yang diterima</small>
            </div>
        </a>
    </div>

    <!-- Penjualan -->
    <div class="col-md-5 col-lg-3">
        <a href="{{ route('admin.penjualan') }}" class="text-decoration-none">
            <div class="p-4 bg-white shadow-sm dashboard-card rounded-4 text-center">
                <h4 class="text-primary mb-1">💸 Penjualan</h4>
                <small class="text-muted">Transaksi penjualan barang</small>
            </div>
        </a>
    </div>

    <!-- Retur -->
    <div class="col-md-5 col-lg-3">
        <a href="{{ route('admin.retur') }}" class="text-decoration-none">
            <div class="p-4 bg-white shadow-sm dashboard-card rounded-4 text-center">
                <h4 class="text-primary mb-1">↩️ Retur</h4>
                <small class="text-muted">Retur barang ke vendor</small>
            </div>
        </a>
    </div>

</div>

@endsection
