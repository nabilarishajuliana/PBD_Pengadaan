<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Pengadaan #{{ $header->idpengadaan }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f7f9fb;font-family:Poppins, sans-serif}
    .container{margin-top:40px}
    .card{border-radius:10px}
    .info-box{background:#f8f9fa;padding:15px;border-radius:8px;margin-bottom:15px}
    .badge-status-N{background:#ffc107;color:#000}
    .badge-status-F{background:#28a745;color:#fff}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📦 Detail Pengadaan #{{ $header->idpengadaan }}</h3>
    <div>
      <a href="{{ route('superadmin.pengadaan') }}" class="btn btn-secondary">⬅️ Kembali</a>
    </div>
  </div>

  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <strong>🏢 Vendor:</strong><br>
          <span class="text-primary">{{ $header->nama_vendor }}</span>
        </div>
        <div class="col-md-3">
          <strong>📅 Tanggal:</strong><br>
          {{ date('d M Y H:i', strtotime($header->timestamp)) }}
        </div>
        <div class="col-md-3">
          <strong>👤 Operator:</strong><br>
          {{ $header->username }}
        </div>
        <div class="col-md-3">
          <strong>📊 Status:</strong><br>
          <span class="badge badge-status-{{ $header->status }}">
            {{ $header->status == 'N' ? 'Proses' : 'Selesai' }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-light">
      <strong>📋 Daftar Barang</strong>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th class="text-center">#</th>
            <th>Nama Barang</th>
            <th class="text-center">Satuan</th>
            <th class="text-end">Harga Satuan</th>
            <th class="text-center">Jumlah</th>
            <th class="text-end">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @forelse($items as $it)
            <tr>
              <td class="align-middle text-center">{{ $no++ }}</td>
              <td class="align-middle">{{ $it->nama_barang }}</td>
              <td class="align-middle text-center">{{ $it->nama_satuan }}</td>
              <td class="align-middle text-end">Rp {{ number_format($it->harga_satuan,0,',','.') }}</td>
              <td class="align-middle text-center">{{ $it->jumlah }}</td>
              <td class="align-middle text-end">Rp {{ number_format($it->sub_total,0,',','.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-3 text-muted">
                📭 Tidak ada item dalam pengadaan ini.
              </td>
            </tr>
          @endforelse
        </tbody>
        <tfoot class="table-light">
          <tr>
            <td colspan="5" class="text-end"><strong>Subtotal</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($header->subtotal_nilai,0,',','.') }}</strong></td>
          </tr>
          <tr>
            <td colspan="5" class="text-end"><strong>PPN (10%)</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($header->ppn,0,',','.') }}</strong></td>
          </tr>
          <tr class="table-success">
            <td colspan="5" class="text-end"><strong>TOTAL</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($header->total_nilai,0,',','.') }}</strong></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>