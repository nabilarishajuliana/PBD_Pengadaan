@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="text-center mb-4">
    <h2 class="fw-bold text-primary">📦 Admin Dashboard</h2>
    <p class="text-muted">Anda hanya dapat mengelola transaksi</p>
</div>

<div class="row g-4">

    <div class="col-md-4">
        <a href="{{ route('admin.pengadaan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">📦 Pengadaan</h4>
                <p>Transaksi pembelian barang</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.penerimaan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">📥 Penerimaan</h4>
                <p>Barang yang diterima</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.penjualan') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">💸 Penjualan</h4>
                <p>Transaksi penjualan barang</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.retur') }}" class="text-decoration-none text-dark">
            <div class="p-4 shadow-sm dashboard-card bg-white">
                <h4 class="text-primary">↩️ Retur</h4>
                <p>Retur barang ke vendor</p>
            </div>
        </a>
    </div>

</div>
@endsection
