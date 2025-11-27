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
    .badge-status-N{background:#ffc107;color:#000}
    .badge-status-F{background:#28a745;color:#fff}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📦 Detail Penerimaan #T{{ $header->idpenerimaan }}</h3>
    <div>
      <a href="{{ route('superadmin.penerimaan') }}" class="btn btn-secondary">⬅️ Kembali</a>
    </div>
  </div>

  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <strong>📋 ID Pengadaan:</strong><br>
          <a href="{{ route('superadmin.pengadaan.show', $header->idpengadaan) }}" class="text-primary text-decoration-none">
            #P{{ $header->idpengadaan }}
          </a>
        </div>
        <div class="col-md-3">
          <strong>📅 Tanggal Penerimaan:</strong><br>
          {{ date('d M Y H:i', strtotime($header->created_at)) }}
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
      <div class="mt-3">
        <strong>🏢 Vendor:</strong> <span class="text-primary">{{ $header->nama_vendor }}</span>
      </div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-light">
      <strong>📋 Daftar Barang Diterima</strong>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th class="text-center">#</th>
            <th>Nama Barang</th>
            <th class="text-center">Satuan</th>
            <th class="text-end">Harga Satuan Terima</th>
            <th class="text-center">Jumlah Terima</th>
            <th class="text-end">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          @php 
            $no = 1; 
            $grandTotal = 0;
          @endphp
          @forelse($items as $it)
            @php $grandTotal += $it->sub_total_terima; @endphp
            <tr>
              <td class="align-middle text-center">{{ $no++ }}</td>
              <td class="align-middle">{{ $it->nama_barang }}</td>
              <td class="align-middle text-center">{{ $it->nama_satuan }}</td>
              <td class="align-middle text-end">Rp {{ number_format($it->harga_satuan_terima,0,',','.') }}</td>
              <td class="align-middle text-center">{{ $it->jumlah_terima }}</td>
              <td class="align-middle text-end">Rp {{ number_format($it->sub_total_terima,0,',','.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-3 text-muted">
                📭 Tidak ada item dalam penerimaan ini.
              </td>
            </tr>
          @endforelse
        </tbody>
        <tfoot class="table-light">
          <tr class="table-success">
            <td colspan="5" class="text-end"><strong>TOTAL PENERIMAAN</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($grandTotal,0,',','.') }}</strong></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div class="alert alert-info mt-3">
    <strong>ℹ️ Informasi:</strong> Harga beli barang dan stok di kartu stok sudah otomatis terupdate oleh sistem.
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>