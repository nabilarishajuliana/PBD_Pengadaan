<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Buat Penerimaan Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    body{background:#f7f9fb;font-family:Poppins, sans-serif}
    .container{margin-top:40px}
    .card{border-radius:10px}
    .form-label{font-weight:600}
    .table-bordered th{background:#f8f9fa}
    .select2-container .select2-selection--single{height:38px;padding:5px}
    .info-text{font-size:0.85rem;color:#6c757d}
    .text-warning-custom{color:#856404;background-color:#fff3cd;padding:2px 6px;border-radius:4px;font-size:0.85rem}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>➕ Buat Penerimaan Baru</h3>
    <a href="{{ route('superadmin.penerimaan') }}" class="btn btn-secondary">⬅️ Kembali</a>
  </div>

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
      <strong>Terjadi kesalahan:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(count($pengadaan_list) == 0)
    <div class="alert alert-warning">
      <strong>⚠️ Tidak ada pengadaan yang bisa diterima!</strong><br>
      Semua pengadaan sudah selesai atau belum ada pengadaan baru.
      <a href="{{ route('superadmin.pengadaan.create') }}" class="btn btn-sm btn-primary mt-2">Buat Pengadaan Baru</a>
    </div>
  @else

  <form action="{{ route('superadmin.penerimaan.store') }}" method="POST" id="formPenerimaan">
    @csrf

    <div class="card shadow-sm mb-3">
      <div class="card-header bg-primary text-white">
        <strong>📋 Informasi Penerimaan</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <label class="form-label">📦 Pilih Pengadaan <span class="text-danger">*</span></label>
            <select name="idpengadaan" id="pengadaan" class="form-select" required>
              <option value="">-- Pilih Pengadaan --</option>
              @foreach($pengadaan_list as $pg)
                <option value="{{ $pg->idpengadaan }}" 
                        data-vendor="{{ $pg->nama_vendor }}"
                        data-tanggal="{{ date('d M Y', strtotime($pg->timestamp)) }}"
                        data-total="{{ number_format($pg->total_nilai,0,',','.') }}">
                  #P{{ $pg->idpengadaan }} - {{ $pg->nama_vendor }} ({{ date('d M Y', strtotime($pg->timestamp)) }})
                </option>
              @endforeach
            </select>
            <small class="info-text">Hanya menampilkan pengadaan yang belum selesai</small>
          </div>
          <div class="col-md-6">
            <label class="form-label">📅 Tanggal Penerimaan</label>
            <input type="text" class="form-control" value="{{ date('d M Y H:i') }}" readonly>
          </div>
        </div>

        <div id="pengadaanInfo" class="mt-3 p-3 bg-light rounded" style="display:none">
          <div class="row">
            <div class="col-md-4"><strong>🏢 Vendor:</strong> <span id="infoVendor">-</span></div>
            <div class="col-md-4"><strong>📅 Tgl Pengadaan:</strong> <span id="infoTanggal">-</span></div>
            <div class="col-md-4"><strong>💰 Total Pengadaan:</strong> Rp <span id="infoTotal">-</span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm" id="cardItems" style="display:none">
      <div class="card-header bg-success text-white">
        <strong>🛒 Daftar Barang yang Akan Diterima</strong>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0" id="tableItems">
            <thead class="table-light">
              <tr>
                <th width="3%" class="text-center">#</th>
                <th width="20%">Nama Barang</th>
                <th width="10%" class="text-center">Satuan</th>
                <th width="12%" class="text-center">Jumlah Pesan</th>
                <th width="12%" class="text-center">Sudah Diterima</th>
                <th width="12%" class="text-center">Sisa Belum Diterima</th>
                <th width="13%" class="text-end">Harga Satuan Terima</th>
                <th width="13%" class="text-center">Jumlah Terima</th>
                <th width="5%" class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody id="itemsBody">
              <!-- Rows akan diisi via AJAX -->
            </tbody>
            <tfoot class="table-light">
              <tr class="table-success">
                <td colspan="8" class="text-end"><strong>TOTAL PENERIMAAN</strong></td>
                <td class="text-end"><strong id="displayTotal">Rp 0</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <div class="text-end mt-3" id="btnSubmit" style="display:none">
      <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Penerimaan</button>
    </div>
  </form>

  @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#pengadaan').select2({
        placeholder: '-- Pilih Pengadaan --',
        allowClear: true
    });
    
    // Event ketika pengadaan dipilih
    $('#pengadaan').on('change', function() {
        const idpengadaan = $(this).val();
        
        if (!idpengadaan) {
            $('#pengadaanInfo').hide();
            $('#cardItems').hide();
            $('#btnSubmit').hide();
            return;
        }
        
        // Tampilkan info pengadaan
        const selectedOption = $(this).find(':selected');
        $('#infoVendor').text(selectedOption.data('vendor'));
        $('#infoTanggal').text(selectedOption.data('tanggal'));
        $('#infoTotal').text(selectedOption.data('total'));
        $('#pengadaanInfo').show();
        
        // Load barang via AJAX
        loadBarang(idpengadaan);
    });
});

function loadBarang(idpengadaan) {
    $('#itemsBody').html('<tr><td colspan="9" class="text-center py-3">⏳ Memuat data...</td></tr>');
    $('#cardItems').show();
    
    $.ajax({
        url: "{{ route('superadmin.penerimaan.items', ':id') }}".replace(':id', idpengadaan),
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                renderBarang(response.data);
                $('#btnSubmit').show();
            } else {
                $('#itemsBody').html('<tr><td colspan="9" class="text-center py-3 text-danger">❌ Semua barang sudah diterima lengkap!</td></tr>');
                $('#btnSubmit').hide();
            }
        },
        error: function() {
            $('#itemsBody').html('<tr><td colspan="9" class="text-center py-3 text-danger">❌ Gagal memuat data barang</td></tr>');
            $('#btnSubmit').hide();
        }
    });
}

function renderBarang(items) {
    let html = '';
    let no = 1;
    
    items.forEach(function(item) {
        html += `
        <tr>
            <td class="text-center align-middle">${no++}</td>
            <td class="align-middle">${item.nama_barang}</td>
            <td class="text-center align-middle">${item.nama_satuan}</td>
            <td class="text-center align-middle">${item.jumlah_pesan}</td>
            <td class="text-center align-middle">${item.sudah_diterima}</td>
            <td class="text-center align-middle">
                <span class="text-warning-custom">${item.sisa_belum_diterima}</span>
            </td>
            <td class="align-middle">
                <input type="hidden" name="items[${item.idbarang}][idbarang]" value="${item.idbarang}">
                <input type="number" 
                       name="items[${item.idbarang}][harga_satuan_terima]" 
                       class="form-control form-control-sm text-end harga-${item.idbarang}" 
                       value="${item.harga_pengadaan}"
                       min="1"
                       onchange="calculateRow(${item.idbarang})" 
                       required>
            </td>
            <td class="align-middle">
                <input type="number" 
                       name="items[${item.idbarang}][jumlah_terima]" 
                       class="form-control form-control-sm text-center jumlah-${item.idbarang}" 
                       value="0"
                       min="0"
                       max="${item.sisa_belum_diterima}"
                       onchange="calculateRow(${item.idbarang})" 
                       required>
                <small class="text-muted">Max: ${item.sisa_belum_diterima}</small>
            </td>
            <td class="text-end align-middle subtotal-${item.idbarang}">Rp 0</td>
        </tr>
        `;
    });
    
    $('#itemsBody').html(html);
}

function calculateRow(idbarang) {
    const harga = parseInt($(`.harga-${idbarang}`).val()) || 0;
    const jumlah = parseInt($(`.jumlah-${idbarang}`).val()) || 0;
    const subtotal = harga * jumlah;
    
    $(`.subtotal-${idbarang}`).text('Rp ' + subtotal.toLocaleString('id-ID'));
    
    calculateTotal();
}

function calculateTotal() {
    let grandTotal = 0;
    
    $('#itemsBody tr').each(function() {
        const row = $(this);
        const hargaInput = row.find('input[name*="[harga_satuan_terima]"]');
        const jumlahInput = row.find('input[name*="[jumlah_terima]"]');
        
        if (hargaInput.length && jumlahInput.length) {
            const harga = parseInt(hargaInput.val()) || 0;
            const jumlah = parseInt(jumlahInput.val()) || 0;
            grandTotal += (harga * jumlah);
        }
    });
    
    $('#displayTotal').text('Rp ' + grandTotal.toLocaleString('id-ID'));
}

// Validasi sebelum submit
$('#formPenerimaan').on('submit', function(e) {
    let hasItems = false;
    
    $('input[name*="[jumlah_terima]"]').each(function() {
        if (parseInt($(this).val()) > 0) {
            hasItems = true;
            return false; // break loop
        }
    });
    
    if (!hasItems) {
        e.preventDefault();
        alert('Minimal harus ada 1 barang yang diterima dengan jumlah > 0!');
        return false;
    }
});
</script>
</body>
</html>