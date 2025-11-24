


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Satuan</title>
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
        .badge-admin {
            background: #17a2b8;
            color: #fff;
            padding: 4px 10px;
            border-radius: 12px;
        }
        .badge-superadmin {
            background: #dc3545;
            color: #fff;
            padding: 4px 10px;
            border-radius: 12px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <h2 class="mb-4 text-center">
        👥 Daftar Satuan
    </h2>

 
    <!-- TOMBOL TOGGLE -->
    <div class="text-center mb-3">
        <div class="btn-group" role="group">
            <a href="{{ route('superadmin.satuan') }}" 
               class="btn {{ $mode != 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                ✅ Satuan Aktif
            </a>
            <a href="{{ route('superadmin.satuan.all') }}" 
               class="btn {{ $mode == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                📋 Semua Satuan
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
                            <th width="35%">Satuan</th>
                            <th class="text-center" width="25%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($satuan as $s)
                        <tr>
                            <td class="text-center align-middle">{{ $s->idsatuan }}</td>
                          
                            <td class="align-middle">
                                <strong class="text-primary">{{ $s->nama_satuan }}</strong>
                            </td>
                            <td class="text-center align-middle">
                                @if($s->status == 1)
                                    <span class="badge bg-success">✅ Aktif</span>
                                @else
                                    <span class="badge bg-secondary">❌ Nonaktif</span>
                                @endif
                            </td>
                         
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                📭 Tidak ada data Satuan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(count($satuan) > 0)
    <div class="alert alert-info mt-3">
        <strong>ℹ️ Keterangan:</strong><br>
        • Total satuan: <strong>{{ count($satuan) }}</strong>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>