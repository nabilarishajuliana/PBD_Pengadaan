<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Penjualan #{{ $header->idpenjualan }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f7f9fb;font-family:Poppins, sans-serif}
    .container{margin-top:40px}
    .card{border-radius:10px}
    .badge-margin{background:#17a2b8;color:#fff;padding:6px 12px;border-radius:4px}
    .profit-info{background:#d4edda;padding:8px 12px;border-radius:4px;font-size:0.9rem}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>💰 Detail Penjualan #{{ $header->idpenjualan }}</h3>
    <div>
      <a href="{{ route('superadmin.penjualan') }}" class="btn btn-secondary">⬅️ Kembali</a>
    </div>
  </div>

  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <strong>📅 Tanggal:</strong><br>
          {{ date('d M Y H:i', strtotime($header->created_at)) }}
        </div>
        <div class="col-md-3">
          <strong>👤 Operator:</strong><br>
          {{ $header->username }}
        </div>
        <div class="col-md-3">
          <strong>📊 Margin Penjualan:</strong><br>
          <span class="badge-margin">{{ $header->margin_persen }}%</span>
        </div>
        <div class="col-md-3">
          <strong>💵 Total Transaksi:</strong><br>
          <span class="text-success fw-bold">Rp {{ number_format($header->total_nilai,0,',','.') }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-light">
      <strong>📋 Daftar Barang Terjual</strong>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-light">
          <tr>
            <th class="text-center">#</th>
            <th>Nama Barang</th>
            <th class="text-center">Satuan</th>
            <th class="text-end">Harga Beli</th>
            <th class="text-end">Harga Jual</th>
            <th class="text-end">Margin/Unit</th>
            <th class="text-center">Jumlah</th>
            <th class="text-end">Subtotal</th>
            <th class="text-end">Profit</th>
          </tr>
        </thead>
        <tbody>
          @php 
            $no = 1; 
            $totalProfit = 0;
          @endphp
          @forelse($items as $it)
            @php 
              $marginPerUnit = $it->harga_satuan - $it->harga_beli;
              $profitItem = $marginPerUnit * $it->jumlah;
              $totalProfit += $profitItem;
            @endphp
            <tr>
              <td class="align-middle text-center">{{ $no++ }}</td>
              <td class="align-middle">{{ $it->nama_barang }}</td>
              <td class="align-middle text-center">{{ $it->nama_satuan }}</td>
              <td class="align-middle text-end text-muted">Rp {{ number_format($it->harga_beli,0,',','.') }}</td>
              <td class="align-middle text-end">Rp {{ number_format($it->harga_satuan,0,',','.') }}</td>
              <td class="align-middle text-end text-success">+Rp {{ number_format($marginPerUnit,0,',','.') }}</td>
              <td class="align-middle text-center">{{ $it->jumlah }}</td>
              <td class="align-middle text-end">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
              <td class="align-middle text-end text-success fw-bold">Rp {{ number_format($profitItem,0,',','.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-3 text-muted">
                📭 Tidak ada item dalam penjualan ini.
              </td>
            </tr>
          @endforelse
        </tbody>
        <tfoot class="table-light">
          <tr>
            <td colspan="7" class="text-end"><strong>Subtotal</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($header->subtotal_nilai,0,',','.') }}</strong></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="7" class="text-end"><strong>PPN (10%)</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($header->ppn,0,',','.') }}</strong></td>
            <td></td>
          </tr>
          <tr class="table-success">
            <td colspan="7" class="text-end"><strong>TOTAL</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($header->total_nilai,0,',','.') }}</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($totalProfit,0,',','.') }}</strong></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div class="alert alert-success mt-3">
    <div class="row">
      <div class="col-md-6">
        <strong>💵 Total Penjualan:</strong> Rp {{ number_format($header->total_nilai,0,',','.') }}
      </div>
      <div class="col-md-6 text-end">
        <strong>📈 Total Keuntungan (Profit):</strong> 
        <span class="text-success fw-bold">Rp {{ number_format($totalProfit,0,',','.') }}</span>
      </div>
    </div>
  </div>

  <div class="alert alert-info">
    <strong>ℹ️ Informasi:</strong> Stok di kartu stok sudah otomatis berkurang sesuai jumlah penjualan.
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>