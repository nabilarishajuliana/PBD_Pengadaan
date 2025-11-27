<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Retur #{{ $header[0]->idretur ?? $id }}</title>
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
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Detail Retur #{{ $header[0]->idretur ?? $id }}</h3>
    <a href="{{ url('superadmin/retur') }}" class="btn btn-secondary">Kembali</a>
  </div>

  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      @if (!empty($header))
        <div class="row">
          <div class="col-md-4"><strong>ID Penerimaan:</strong> {{ $header[0]->idpenerimaan }}</div>
          <div class="col-md-4"><strong>Tanggal Retur:</strong> {{ date('Y-m-d H:i', strtotime($header[0]->created_at)) }}</div>
          <div class="col-md-4"><strong>Petugas:</strong> {{ $header[0]->nama_user }}</div>
        </div>
      @endif
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Jumlah Retur</th>
            <th>ID Detail Penerimaan</th>
            <th>ID Penerimaan</th>
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @foreach ($detail as $d)
            <tr>
              <td class="align-middle text-center">{{ $no++ }}</td>
              <td class="align-middle">{{ $d->nama_barang }}</td>
              <td class="align-middle text-center">{{ $d->jumlah }}</td>
              <td class="align-middle text-center">{{ $d->iddetail_penerimaan }}</td>
              <td class="align-middle text-center">{{ $d->idpenerimaan }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
