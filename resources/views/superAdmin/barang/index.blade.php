<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - {{ $mode == 'all' ? 'Semua' : 'Aktif' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f9fb;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            border-radius: 10px;
            border: none;
        }
        .badge-jenis-B {
            background: #17a2b8;
            color: #fff;
        }
        .badge-jenis-J {
            background: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <h2 class="mb-4 text-center">
        📦 Daftar Barang {{ $mode == 'all' ? '(Semua)' : '(Aktif)' }}
    </h2>

    <!-- TOMBOL TOGGLE -->
    <div class="text-center mb-3">
        <div class="btn-group" role="group">
            <a href="{{ route('superadmin.barang') }}" 
               class="btn {{ $mode != 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                ✅ Barang Aktif
            </a>
            <a href="{{ route('superadmin.barang.all') }}" 
               class="btn {{ $mode == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                📋 Semua Barang
            </a>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="8%">ID</th>
                            <th width="30%">Nama Barang</th>
                            <th class="text-center" width="12%">Jenis</th>
                            <th class="text-center" width="12%">Satuan</th>
                            <th class="text-end" width="18%">Harga Beli</th>
                            <th class="text-center" width="12%">Status</th>
                            <!-- <th class="text-center" width="8%">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $b)
                        <tr>
                            <td class="text-center align-middle">{{ $b->idbarang }}</td>
                            <td class="align-middle">{{ $b->nama_barang }}</td>
                            <td class="text-center align-middle">
                                @if($b->jenis == 'B')
                                    <span class="badge badge-jenis-B">🥫 Bahan</span>
                                @else
                                    <span class="badge badge-jenis-J">🍞 Jadi</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">{{ $b->nama_satuan }}</td>
                            <td class="text-end align-middle">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                            <td class="text-center align-middle">
                                @if($b->status == 1)
                                    <span class="badge bg-success">✅ Aktif</span>
                                @else
                                    <span class="badge bg-secondary">❌ Nonaktif</span>
                                @endif
                            </td>
                            <!-- <td class="text-center align-middle">
                                <a href="{{ route('superadmin.kartustok.detail', $b->idbarang) }}" 
                                   class="btn btn-sm btn-info text-white" 
                                   title="Lihat Stok">
                                    📊
                                </a>
                            </td> -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                📭 Tidak ada data barang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(count($barang) > 0)
    <div class="alert alert-info mt-3">
        <strong>ℹ️ Keterangan:</strong><br>
        • <span class="badge badge-jenis-B">Bahan</span> = Bahan baku untuk produksi<br>
        • <span class="badge badge-jenis-J">Jadi</span> = Barang jadi siap jual<br>
        • <strong>Harga Beli</strong> = Harga terakhir dari penerimaan barang
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>