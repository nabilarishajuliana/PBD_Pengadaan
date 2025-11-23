<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar Penerimaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f7f9fb;font-family:Poppins, sans-serif}
    .container{margin-top:40px}
    .card{border-radius:10px}
    .badge-status-N{background:#ffc107;color:#000}
    .badge-status-F{background:#28a745;color:#fff}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <h2 class="mb-4 text-center">📦 Daftar Penerimaan</h2>

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('superadmin.pengadaan') }}" class="btn btn-outline-secondary">📋 Lihat Pengadaan</a>
    <a href="{{ route('superadmin.penerimaan.create') }}" class="btn btn-primary">➕ Buat Penerimaan Baru</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th class="text-center">ID</th>
            <th>Tanggal</th>
            <th class="text-center">ID Pengadaan</th>
            <th>Vendor</th>
            <th class="text-center">Status</th>
            <th class="text-center">Operator</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($penerimaan as $p)
            <tr>
              <td class="align-middle text-center">{{ $p->idpenerimaan }}</td>
              <td class="align-middle">{{ date('d M Y H:i', strtotime($p->created_at)) }}</td>
              <td class="align-middle text-center">
                <a href="{{ route('superadmin.pengadaan.show', $p->idpengadaan) }}" class="text-decoration-none">
                  #{{ $p->idpengadaan }}
                </a>
              </td>
              <td class="align-middle">{{ $p->nama_vendor }}</td>
              <td class="align-middle text-center">
                <span class="badge badge-status-{{ $p->status }}">
                  {{ $p->status == 'N' ? 'Proses' : 'Selesai' }}
                </span>
              </td>
              <td class="align-middle text-center">{{ $p->username }}</td>
              <td class="align-middle text-center">
                <a href="{{ route('superadmin.penerimaan.show', $p->idpenerimaan) }}" class="btn btn-sm btn-primary">
                  👁️ Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                📭 Belum ada data penerimaan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>