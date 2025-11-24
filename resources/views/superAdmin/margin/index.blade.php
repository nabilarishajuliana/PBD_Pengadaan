<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Margin Penjualan - {{ $mode == 'all' ? 'Semua' : 'Aktif' }}</title>
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
        .badge-margin {
            background: #17a2b8;
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 1rem;
        }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <h2 class="mb-4 text-center">
        📊 Margin Penjualan {{ $mode == 'all' ? '(Semua)' : '(Aktif)' }}
    </h2>

    <!-- TOMBOL TOGGLE -->
    <div class="text-center mb-3">
        <div class="btn-group" role="group">
            <a href="{{ route('superadmin.margin') }}" 
               class="btn {{ $mode != 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                ✅ Margin Aktif
            </a>
            <a href="{{ route('superadmin.margin.all') }}" 
               class="btn {{ $mode == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                📋 Semua Margin
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
                            <th class="text-center" width="10%">ID</th>
                            <th class="text-center" width="15%">Margin</th>
                            <th class="text-center" width="15%">Status</th>
                            <th class="text-center" width="20%">Dibuat Oleh</th>
                            <th class="text-center" width="20%">Dibuat Pada</th>
                            <th class="text-center" width="20%">Diperbarui Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($margin as $m)
                        <tr>
                            <td class="text-center align-middle">{{ $m->idmargin_penjualan }}</td>
                            <td class="text-center align-middle">
                                <span class="badge-margin">{{ $m->persen }}%</span>
                            </td>
                            <td class="text-center align-middle">
                                @if($m->status == 1)
                                    <span class="badge bg-success">✅ Aktif</span>
                                @else
                                    <span class="badge bg-secondary">❌ Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <span class="text-primary">{{ $m->dibuat_oleh }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <small>{{ date('d M Y H:i', strtotime($m->created_at)) }}</small>
                            </td>
                            <td class="text-center align-middle">
                                @if($m->updated_at)
                                    <small>{{ date('d M Y H:i', strtotime($m->updated_at)) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                📭 Tidak ada data margin penjualan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(count($margin) > 0)
    <div class="alert alert-info mt-3">
        <strong>ℹ️ Keterangan:</strong><br>
        • <span class="badge bg-success">Aktif</span> = Margin yang digunakan untuk perhitungan harga jual saat ini<br>
        • Hanya <strong>1 margin yang bisa aktif</strong> dalam waktu bersamaan<br>
        • Margin akan ditambahkan ke harga beli barang untuk menentukan harga jual
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>