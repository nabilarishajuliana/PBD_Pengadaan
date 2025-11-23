<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Buat Pengadaan Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    body{background:#f7f9fb;font-family:Poppins, sans-serif}
    .container{margin-top:40px}
    .card{border-radius:10px}
    .form-label{font-weight:600}
    .table-bordered th{background:#f8f9fa}
    .btn-delete{color:#dc3545;cursor:pointer}
    .select2-container .select2-selection--single{height:38px;padding:5px}
  </style>
</head>
<body>
    @include('components.navbar')

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>➕ Buat Pengadaan Baru</h3>
    <a href="{{ route('superadmin.pengadaan') }}" class="btn btn-secondary">⬅️ Kembali</a>
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

  <form action="{{ route('superadmin.pengadaan.store') }}" method="POST" id="formPengadaan">
    @csrf

    <div class="card shadow-sm mb-3">
      <div class="card-header bg-primary text-white">
        <strong>📋 Informasi Pengadaan</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <label class="form-label">🏢 Vendor <span class="text-danger">*</span></label>
            <select name="idvendor" id="vendor" class="form-select" required>
              <option value="">-- Pilih Vendor --</option>
              @foreach($vendors as $v)
                <option value="{{ $v->idvendor }}" {{ old('idvendor') == $v->idvendor ? 'selected' : '' }}>
                  {{ $v->nama_vendor }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">📅 Tanggal</label>
            <input type="text" class="form-control" value="{{ date('d M Y H:i') }}" readonly>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <strong>🛒 Daftar Barang</strong>
        <button type="button" class="btn btn-light btn-sm" onclick="addRow()">➕ Tambah Baris</button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0" id="tableItems">
            <thead class="table-light">
              <tr>
                <th width="5%" class="text-center">#</th>
                <th width="35%">Barang</th>
                <th width="15%">Satuan</th>
                <th width="15%">Harga Satuan</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="15%" class="text-end">Subtotal</th>
                <th width="5%" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody id="itemsBody">
              <!-- Rows akan ditambahkan via JavaScript -->
            </tbody>
            <tfoot class="table-light">
              <tr>
                <td colspan="5" class="text-end"><strong>Subtotal</strong></td>
                <td class="text-end"><strong id="displaySubtotal">Rp 0</strong></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="5" class="text-end"><strong>PPN (10%)</strong></td>
                <td class="text-end"><strong id="displayPPN">Rp 0</strong></td>
                <td></td>
              </tr>
              <tr class="table-success">
                <td colspan="5" class="text-end"><strong>TOTAL</strong></td>
                <td class="text-end"><strong id="displayTotal">Rp 0</strong></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <div class="text-end mt-3">
      <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Pengadaan</button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Data barang dari server
const barangData = @json($barangs);
let rowCounter = 0;

$(document).ready(function() {
    $('#vendor').select2({
        placeholder: '-- Pilih Vendor --',
        allowClear: true
    });
    
    // Tambah baris pertama otomatis
    addRow();
});

function addRow() {
    rowCounter++;
    
    let options = '<option value="">-- Pilih Barang --</option>';
    barangData.forEach(b => {
        options += `<option value="${b.idbarang}" data-harga="${b.harga}" data-satuan="${b.nama_satuan}">${b.nama}</option>`;
    });

    const row = `
    <tr id="row${rowCounter}">
        <td class="text-center align-middle">${rowCounter}</td>
        <td>
            <select name="items[${rowCounter}][idbarang]" class="form-select form-select-sm select-barang" onchange="updateRow(${rowCounter})" required>
                ${options}
            </select>
        </td>
        <td class="align-middle satuan${rowCounter}">-</td>
        <td>
            <input type="number" name="items[${rowCounter}][harga_satuan]" class="form-control form-control-sm harga${rowCounter}" 
                   min="1" onchange="calculateRow(${rowCounter})" required>
        </td>
        <td>
            <input type="number" name="items[${rowCounter}][jumlah]" class="form-control form-control-sm jumlah${rowCounter}" 
                   min="1" value="1" onchange="calculateRow(${rowCounter})" required>
        </td>
        <td class="text-end align-middle subtotal${rowCounter}">Rp 0</td>
        <td class="text-center align-middle">
            <span class="btn-delete" onclick="deleteRow(${rowCounter})">🗑️</span>
        </td>
    </tr>
    `;
    
    $('#itemsBody').append(row);
}

function updateRow(id) {
    const select = $(`select[name="items[${id}][idbarang]"]`);
    const selectedOption = select.find(':selected');
    
    const harga = selectedOption.data('harga') || 0;
    const satuan = selectedOption.data('satuan') || '-';
    
    $(`.satuan${id}`).text(satuan);
    $(`.harga${id}`).val(harga);
    
    calculateRow(id);
}

function calculateRow(id) {
    const harga = parseInt($(`.harga${id}`).val()) || 0;
    const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;
    const subtotal = harga * jumlah;
    
    $(`.subtotal${id}`).text('Rp ' + subtotal.toLocaleString('id-ID'));
    
    calculateTotal();
}

function calculateTotal() {
    let grandTotal = 0;
    
    $('#itemsBody tr').each(function() {
        const id = $(this).attr('id').replace('row', '');
        const harga = parseInt($(`.harga${id}`).val()) || 0;
        const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;
        grandTotal += (harga * jumlah);
    });
    
    const ppn = grandTotal * 0.10;
    const total = grandTotal + ppn;
    
    $('#displaySubtotal').text('Rp ' + grandTotal.toLocaleString('id-ID'));
    $('#displayPPN').text('Rp ' + ppn.toLocaleString('id-ID'));
    $('#displayTotal').text('Rp ' + total.toLocaleString('id-ID'));
}

function deleteRow(id) {
    if ($('#itemsBody tr').length <= 1) {
        alert('Minimal harus ada 1 barang!');
        return;
    }
    
    if (confirm('Hapus baris ini?')) {
        $(`#row${id}`).remove();
        calculateTotal();
        renumberRows();
    }
}

function renumberRows() {
    let no = 1;
    $('#itemsBody tr').each(function() {
        $(this).find('td:first').text(no++);
    });
}

// Validasi sebelum submit
$('#formPengadaan').on('submit', function(e) {
    if ($('#itemsBody tr').length === 0) {
        e.preventDefault();
        alert('Minimal harus ada 1 barang!');
        return false;
    }
    
    if (!$('#vendor').val()) {
        e.preventDefault();
        alert('Vendor harus dipilih!');
        return false;
    }
});
</script>
</body>
</html>