<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Kartu Stok</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f7f9fb;font-family:Poppins, sans-serif}
    .container{margin-top:40px}
    .card{border-radius:10px}
    .badge-masuk{background:#28a745;color:#fff}
    .badge-keluar{background:#dc3545;color:#fff}
    .badge-retur{background:#ffc107;color:#000}
    .filter-card{background:#f8f9fa;border:1px solid #dee2e6}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <h2 class="mb-4 text-center">📊 Kartu Stok - Riwayat Transaksi</h2>

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

  <!-- FILTER -->
  <div class="card filter-card shadow-sm mb-3">
    <div class="card-body">
      <form action="{{ route('superadmin.kartustok') }}" method="GET" id="formFilter">
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-bold">🔍 Filter Barang</label>
            <select name="idbarang" class="form-select">
              <option value="">-- Semua Barang --</option>
              @foreach($barangs as $b)
                <option value="{{ $b->idbarang }}" {{ $idbarang == $b->idbarang ? 'selected' : '' }}>
                  {{ $b->jenis == 'B' ? '🥫' : '🍞' }} {{ $b->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-bold">📦 Jenis Transaksi</label>
            <select name="jenis_transaksi" class="form-select">
              <option value="">-- Semua --</option>
              <option value="M" {{ $jenis_transaksi == 'M' ? 'selected' : '' }}>Masuk</option>
              <option value="K" {{ $jenis_transaksi == 'K' ? 'selected' : '' }}>Keluar</option>
              <option value="R" {{ $jenis_transaksi == 'R' ? 'selected' : '' }}>Retur</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-bold">📅 Dari Tanggal</label>
            <input type="date" name="tanggal_dari" class="form-control" value="{{ $tanggal_dari }}">
          </div>

          <div class="col-md-2">
            <label class="form-label fw-bold">📅 Sampai Tanggal</label>
            <input type="date" name="tanggal_sampai" class="form-control" value="{{ $tanggal_sampai }}">
          </div>

          <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">🔍 Filter</button>
            <a href="{{ route('superadmin.kartustok') }}" class="btn btn-secondary">🔄 Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- TABLE -->
  <div class="card shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th class="text-center" width="5%">#</th>
              <th width="12%">Tanggal</th>
              <th width="25%">Nama Barang</th>
              <th class="text-center" width="8%">Satuan</th>
              <th class="text-center" width="15%">Jenis Transaksi</th>
              <th class="text-end" width="10%">Masuk</th>
              <th class="text-end" width="10%">Keluar</th>
              <th class="text-end" width="10%">Stok</th>
              <!-- <th class="text-center" width="5%">ID Trx</th> -->
            </tr>
          </thead>
          <tbody>
            @php $no = 1; @endphp
            @forelse($kartu_stok as $k)
              <tr>
                <td class="text-center align-middle">{{ $no++ }}</td>
                <td class="align-middle">{{ date('d M Y H:i', strtotime($k->created_at)) }}</td>
                <td class="align-middle">
                    {{ $k->nama_barang }}
           
                </td>
                <td class="text-center align-middle">{{ $k->nama_satuan }}</td>
                <td class="text-center align-middle">
                  @if($k->jenis_transaksi == 'M')
                    <span class="badge badge-masuk">📥 Masuk</span>
                  @elseif($k->jenis_transaksi == 'K')
                    <span class="badge badge-keluar">📤 Keluar</span>
                  @elseif($k->jenis_transaksi == 'R')
                    <span class="badge badge-retur">↩️ Retur</span>
                  @else
                    <span class="badge bg-secondary">{{ $k->jenis_transaksi }}</span>
                  @endif
                </td>
                <td class="text-end align-middle">
                  @if($k->masuk > 0)
                    <span class="text-success fw-bold">+{{ $k->masuk }}</span>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td class="text-end align-middle">
                  @if($k->keluar > 0)
                    <span class="text-danger fw-bold">-{{ $k->keluar }}</span>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td class="text-end align-middle">
                  <strong>{{ $k->stock }}</strong>
                </td>
                <!-- <td class="text-center align-middle">
                  <small class="text-muted">#{{ $k->idtransaksi }}</small>
                </td> -->
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center py-4 text-muted">
                  📭 Tidak ada data kartu stok.
                  @if($idbarang || $jenis_transaksi || $tanggal_dari || $tanggal_sampai)
                    <br><small>Coba ubah filter atau <a href="{{ route('superadmin.kartustok') }}">reset filter</a></small>
                  @endif
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @if(count($kartu_stok) > 0)
    <div class="alert alert-info mt-3">
      <strong>ℹ️ Keterangan:</strong><br>
      • <span class="badge badge-masuk">Masuk</span> = Barang masuk dari penerimaan<br>
      • <span class="badge badge-keluar">Keluar</span> = Barang keluar karena penjualan<br>
      • <span class="badge badge-retur">Retur</span> = Barang diretur ke vendor<br>
      • <strong>Saldo</strong> = Stok barang setelah transaksi
    </div>
  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>