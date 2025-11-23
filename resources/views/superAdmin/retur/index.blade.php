<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar Retur</title>
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
  <h2 class="mb-4 text-center">Daftar Retur</h2>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="mb-3 text-end">
    <a href="{{ url('/penerimaan') }}" class="btn btn-outline-secondary">Lihat Penerimaan</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr class="text-center">
            <th>ID Retur</th>
            <th>ID Penerimaan</th>
            <th>Petugas</th>
            <th>Tanggal Retur</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($retur as $r)
            <tr>
              <td class="align-middle text-center">{{ $r->idretur }}</td>
              <td class="align-middle text-center">{{ $r->idpenerimaan }}</td>
              <td class="align-middle text-center">{{ $r->nama_user }}</td>
              <td class="align-middle text-center">{{ date('Y-m-d H:i', strtotime($r->created_at)) }}</td>
              <td class="align-middle text-center">
                <a href="{{ url('/retur/'.$r->idretur) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-4">Belum ada data retur.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
