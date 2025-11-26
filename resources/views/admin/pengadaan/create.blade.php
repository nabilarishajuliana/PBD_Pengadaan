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
  <div class="d-flex justify-content-between mb-3">
    <h3>➕ Buat Pengadaan Baru</h3>
    <a href="{{ route('superadmin.pengadaan') }}" class="btn btn-secondary">⬅️ Kembali</a>
  </div>

  <form action="{{ route('superadmin.pengadaan.store') }}" method="POST" id="formPengadaan">
    @csrf

    <!-- INFORMASI PENGADAAN -->
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
                <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
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

    <!-- TABEL BARANG -->
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <strong>🛒 Daftar Barang</strong>
        <button type="button" class="btn btn-light btn-sm" onclick="addRow()">➕ Tambah Baris</button>
      </div>

      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-light">
            <tr>
              <th class="text-center" width="5%">#</th>
              <th width="35%">Barang</th>
              <th width="15%">Satuan</th>
              <th width="15%">Harga Satuan</th>
              <th width="10%" class="text-center">Jumlah</th>
              <th width="15%" class="text-end">Subtotal</th>
              <th width="5%" class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody id="itemsBody"></tbody>

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
              <td colspan="5" class="text-end"><strong>Total</strong></td>
              <td class="text-end"><strong id="displayTotal">Rp 0</strong></td>
              <td></td>
            </tr>
          </tfoot>

        </table>
      </div>
    </div>

    <div class="text-end mt-3">
      <button class="btn btn-primary btn-lg">💾 Simpan Pengadaan</button>
    </div>

  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// -------- DATA BARANG --------
const barangData = @json($barangs);
let rowCounter = 0;

$(document).ready(function() {
    $('#vendor').select2();
    addRow();
});

// ----------------------------------------------------------
// TAMBAH BARIS BARU
// ----------------------------------------------------------
function addRow() {
    rowCounter++;

    const row = `
    <tr id="row${rowCounter}">
        <td class="text-center align-middle">${rowCounter}</td>

        <td>
            <select name="items[${rowCounter}][idbarang]"
                    class="form-select form-select-sm select-barang sel${rowCounter}"
                    onchange="updateRow(${rowCounter})" required>
                <!-- options dynamic -->
            </select>
        </td>

        <td class="align-middle satuan${rowCounter}">-</td>

        <td>
            <input type="number"
                   name="items[${rowCounter}][harga_satuan]"
                   class="form-control form-control-sm harga${rowCounter}"
                   readonly onkeydown="return false"
                   onwheel="return false"
                   onclick="return false">
        </td>

        <td>
            <input type="number"
                   name="items[${rowCounter}][jumlah]"
                   class="form-control form-control-sm jumlah${rowCounter}"
                   min="1" value="1"
                   onchange="calculateRow(${rowCounter})" required>
        </td>

        <td class="text-end align-middle subtotal${rowCounter}">Rp 0</td>

        <td class="text-center align-middle">
            <span class="btn-delete" onclick="deleteRow(${rowCounter})">🗑️</span>
        </td>
    </tr>`;

    $('#itemsBody').append(row);

    // isi dropdown tanpa duplikasi
    refreshSelectOptions();
}

// ----------------------------------------------------------
// UPDATE ROW KETIKA BARANG DIPILIH
// ----------------------------------------------------------
function updateRow(id) {
    const select = $(`.sel${id}`);
    const harga = select.find(':selected').data('harga') ?? 0;
    const satuan = select.find(':selected').data('satuan') ?? "-";

    $(`.satuan${id}`).text(satuan);
    $(`.harga${id}`).val(harga);

    calculateRow(id);
    refreshSelectOptions(); // update seluruh dropdown agar anti-duplikat
}

// ----------------------------------------------------------
// HITUNG SUBTOTAL PER BARIS
// ----------------------------------------------------------
function calculateRow(id) {
    const harga = parseInt($(`.harga${id}`).val()) || 0;
    const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;

    const subtotal = harga * jumlah;

    $(`.subtotal${id}`).text("Rp " + subtotal.toLocaleString('id-ID'));

    calculateTotal();
}

// ----------------------------------------------------------
// HITUNG TOTAL KESELURUHAN
// ----------------------------------------------------------
function calculateTotal() {
    let total = 0;

    $('#itemsBody tr').each(function() {
        const id = this.id.replace('row', '');
        const harga = parseInt($(`.harga${id}`).val()) || 0;
        const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;
        total += harga * jumlah;
    });

    const ppn = total * 0.10;
    const grandTotal = total + ppn;

    $('#displaySubtotal').text("Rp " + total.toLocaleString('id-ID'));
    $('#displayPPN').text("Rp " + ppn.toLocaleString('id-ID'));
    $('#displayTotal').text("Rp " + grandTotal.toLocaleString('id-ID'));
}

// ----------------------------------------------------------
// HAPUS BARIS
// ----------------------------------------------------------
function deleteRow(id) {
    if ($('#itemsBody tr').length <= 1) {
        alert("Minimal harus ada 1 barang!");
        return;
    }

    $(`#row${id}`).remove();
    calculateTotal();
    refreshSelectOptions(); // setelah hapus, barang kembali muncul
}

// ----------------------------------------------------------
// ANTI DUPLIKAT — UPDATE SEMUA DROPDOWN
// ----------------------------------------------------------
function refreshSelectOptions() {
    // 1. Ambil semua ID barang yang sudah dipilih
    let selectedBarang = [];
    $('.select-barang').each(function() {
        const val = $(this).val();
        if (val) selectedBarang.push(parseInt(val));
    });

    // 2. Update tiap dropdown
    $('.select-barang').each(function() {
        const currentVal = $(this).val(); // barang yg sedang dipilih row tsb
        const select = $(this);

        select.empty();
        select.append(`<option value="">-- Pilih Barang --</option>`);

        barangData.forEach(b => {
            // jika barang sudah dipilih di row lain → jangan tampil
            if (selectedBarang.includes(b.idbarang) && currentVal != b.idbarang) return;

            select.append(
                `<option value="${b.idbarang}" data-harga="${b.harga}" data-satuan="${b.nama_satuan}">
                    ${b.nama}
                </option>`
            );
        });

        // kembalikan value yang aktif
        select.val(currentVal);
    });
}
</script>


</body>
</html>
