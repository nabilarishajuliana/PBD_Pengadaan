<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Penerimaan #{{ $header->idpenerimaan }}</title>
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
    <h3>Detail Penerimaan #{{ $header->idpenerimaan }}</h3>
    <div>
      <a href="{{ url('/penerimaan') }}" class="btn btn-secondary">Kembali</a>
    </div>
  </div>

  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4"><strong>Pengadaan:</strong> {{ $header->idpengadaan ?? '-' }}</div>
        <div class="col-md-4"><strong>Tanggal:</strong> {{ date('Y-m-d H:i', strtotime($header->created_at)) }}</div>
        <div class="col-md-4"><strong>Operator:</strong> {{ $header->username }}</div>
      </div>
      <div class="mt-2"><strong>Vendor:</strong> {{ $header->nama_vendor ?? '-' }}</div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th class="text-end">Harga Satuan Terima</th>
            <th class="text-center">Jumlah Terima</th>
            <th class="text-end">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @foreach ($items as $it)
            <tr>
              <td class="align-middle text-center">{{ $no++ }}</td>
              <td class="align-middle">{{ $it->nama_barang }}</td>
              <td class="align-middle text-center">{{ $it->nama_satuan }}</td>
              <td class="align-middle text-end">Rp{{ number_format($it->harga_satuan_terima,0,',','.') }}</td>
              <td class="align-middle text-center">{{ $it->jumlah_terima }}</td>
              <td class="align-middle text-end">Rp{{ number_format($it->sub_total_terima,0,',','.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
