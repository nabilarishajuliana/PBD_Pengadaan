<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar Penjualan</title>
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
  <h2 class="mb-4 text-center">Daftar Penjualan</h2>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="mb-3 text-end">
    <!-- optional: tombol buat transaksi baru nanti -->
    <!-- <a href="#" class="btn btn-primary">Buat Penjualan</a> -->
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Margin (%)</th>
            <th>Subtotal</th>
            <th>PPN</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($penjualan as $p)
            <tr>
              <td class="align-middle text-center">{{ $p->idpenjualan }}</td>
              <td class="align-middle">{{ date('Y-m-d H:i', strtotime($p->created_at)) }}</td>
              <td class="align-middle text-center">{{ $p->username ?? '-' }}</td>
              <td class="align-middle text-center">{{ $p->margin_persen ?? '-' }}</td>
              <td class="align-middle text-end">Rp{{ number_format($p->subtotal_nilai,0,',','.') }}</td>
              <td class="align-middle text-end">Rp{{ number_format($p->ppn,0,',','.') }}</td>
              <td class="align-middle text-end">Rp{{ number_format($p->total_nilai,0,',','.') }}</td>
              <td class="align-middle text-center">
                <a href="{{ url('/penjualan/'.$p->idpenjualan) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">Belum ada data penjualan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
