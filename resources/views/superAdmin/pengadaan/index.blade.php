<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar Pengadaan</title>
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
  <h2 class="mb-4 text-center">📦 Daftar Pengadaan</h2>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

<div class="mb-3 text-end">
    <a href="{{ route('superadmin.pengadaan.create') }}" class="btn btn-primary">➕ Buat Pengadaan Baru</a>
</div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th class="text-center">ID</th>
            <th>Tanggal</th>
            <th>Vendor</th>
            <th>Status</th>
            <th class="text-end">Subtotal</th>
            <th class="text-end">PPN</th>
            <th class="text-end">Total</th>
            <th class="text-center">Operator</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pengadaan as $p)
            <tr>
              <td class="align-middle text-center">P{{ $p->idpengadaan }}</td>
              <td class="align-middle">{{ date('d M Y H:i', strtotime($p->timestamp)) }}</td>
              <td class="align-middle">{{ $p->nama_vendor }}</td>
              <td class="align-middle text-center">
                <span class="badge badge-status-{{ $p->status }}">
                  {{ $p->status == 'N' ? 'Proses' : 'Selesai' }}
                </span>
              </td>
              <td class="align-middle text-end">Rp {{ number_format($p->subtotal_nilai,0,',','.') }}</td>
              <td class="align-middle text-end">Rp {{ number_format($p->ppn,0,',','.') }}</td>
              <td class="align-middle text-end"><strong>Rp {{ number_format($p->total_nilai,0,',','.') }}</strong></td>
              <td class="align-middle text-center">{{ $p->username }}</td>
              <td class="align-middle text-center">
                <a href="{{ route('superadmin.pengadaan.show', $p->idpengadaan) }}" class="btn btn-sm btn-primary">
                  👁️ Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-4 text-muted">
                📭 Belum ada data pengadaan.
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