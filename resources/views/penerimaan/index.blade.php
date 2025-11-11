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
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <h2 class="mb-4 text-center">Daftar Penerimaan</h2>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="mb-3 text-end">
    <a href="{{ url('/pengadaan') }}" class="btn btn-outline-secondary">Lihat Pengadaan</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Pengadaan</th>
            <th>Vendor</th>
            <th>Status</th>
            <th>Operator</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($penerimaan as $p)
            <tr>
              <td class="align-middle text-center">{{ $p->idpenerimaan }}</td>
              <td class="align-middle">{{ date('Y-m-d H:i', strtotime($p->created_at)) }}</td>
              <td class="align-middle text-center">{{ $p->idpengadaan ?? '-' }}</td>
              <td class="align-middle">{{ $p->nama_vendor ?? '-' }}</td>
              <td class="align-middle text-center">{{ $p->status }}</td>
              <td class="align-middle text-center">{{ $p->username }}</td>
              <td class="align-middle text-center">
                <a href="{{ url('/penerimaan/'.$p->idpenerimaan) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4">Belum ada data penerimaan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
