<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Buat Penjualan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f7f9fb;
            font-family: Poppins, sans-serif
        }

        .container {
            margin-top: 40px
        }

        .card {
            border-radius: 10px
        }

        .form-label {
            font-weight: 600
        }

        .table-bordered th {
            background: #f8f9fa
        }

        .btn-delete {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem
        }

        .select2-container .select2-selection--single {
            height: 38px;
            padding: 5px
        }

        .badge-margin {
            background: #17a2b8;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px
        }

        .text-profit {
            color: #28a745;
            font-weight: 600
        }

        .stok-badge {
            background: #ffc107;
            color: #000;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85rem
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>➕ Buat Penjualan Baru</h3>
            <a href="{{ route('superadmin.penjualan') }}" class="btn btn-secondary">⬅️ Kembali</a>
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

        @if(count($barangs) == 0)
        <div class="alert alert-warning">
            <strong>⚠️ Tidak ada barang yang bisa dijual!</strong><br>
            Stok barang kosong atau belum ada barang aktif.
            <a href="{{ route('superadmin.penerimaan.create') }}" class="btn btn-sm btn-primary mt-2">Buat Penerimaan Barang</a>
        </div>
        @else

        <form action="{{ route('superadmin.penjualan.store') }}" method="POST" id="formPenjualan">
            @csrf

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <strong>📋 Informasi Penjualan</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">📊 Margin Penjualan <span class="text-danger">*</span></label>
                            <input type="hidden" name="idmargin_penjualan" value="{{ $activeMargin->idmargin_penjualan }}">
                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                <strong>{{ $activeMargin->persen }}%</strong>
                                <span class="badge bg-success ms-2">Aktif</span>
                            </div>
                            <small class="text-muted">Margin akan ditambahkan ke harga beli barang</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">📅 Tanggal Penjualan</label>
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
                                    <th width="4%" class="text-center">#</th>
                                    <th width="20%">Barang</th>
                                    <th width="8%" class="text-center">Satuan</th>
                                    <th width="8%" class="text-center">Stok</th>
                                    <th width="12%" class="text-end">Harga Beli</th>
                                    <th width="12%" class="text-end">Harga Jual</th>
                                    <th width="10%" class="text-end">Margin/Unit</th>
                                    <th width="10%" class="text-center">Jumlah</th>
                                    <th width="12%" class="text-end">Subtotal</th>
                                    <th width="4%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <!-- Rows akan ditambahkan via JavaScript -->
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="8" class="text-end"><strong>Subtotal</strong></td>
                                    <td class="text-end"><strong id="displaySubtotal">Rp 0</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-end"><strong>PPN (10%)</strong></td>
                                    <td class="text-end"><strong id="displayPPN">Rp 0</strong></td>
                                    <td></td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="8" class="text-end"><strong>TOTAL</strong></td>
                                    <td class="text-end"><strong id="displayTotal">Rp 0</strong></td>
                                    <td></td>
                                </tr>
                                <tr class="table-info">
                                    <td colspan="8" class="text-end"><strong>💰 PROFIT KOTOR</strong></td>
                                    <td class="text-end"><strong class="text-profit" id="displayProfit">Rp 0</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Penjualan</button>
            </div>
        </form>

        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
const barangData = {!! json_encode($barangs) !!};
let rowCounter = 0;
let currentMargin = {{ $activeMargin->persen }};

// ========================================================
// Document Ready
// ========================================================
$(document).ready(function () {
    addRow();
});

// ========================================================
// Tambah Baris Penjualan
// ========================================================
function addRow() {
    rowCounter++;

    const rowHTML = `
    <tr id="row${rowCounter}">
        <td class="text-center align-middle">${rowCounter}</td>

        <td>
            <select name="items[${rowCounter}][idbarang]"
                    class="form-select form-select-sm select-barang sel${rowCounter}"
                    onchange="updateRow(${rowCounter})" required>
            </select>
        </td>

        <td class="align-middle text-center satuan${rowCounter}">-</td>
        <td class="align-middle text-center stok${rowCounter}">-</td>
        <td class="align-middle text-end harga-beli${rowCounter}">Rp 0</td>
        <td class="align-middle text-end harga-jual${rowCounter}">Rp 0</td>
        <td class="align-middle text-end margin${rowCounter}">Rp 0</td>

        <td>
            <input type="hidden" name="items[${rowCounter}][harga_satuan]" class="harga-input${rowCounter}">
            <input type="number" 
                   name="items[${rowCounter}][jumlah]" 
                   class="form-control form-control-sm text-center jumlah${rowCounter}" 
                   min="1" value="1"
                   onchange="calculateRow(${rowCounter})"
                   disabled required>
        </td>

        <td class="align-middle text-end subtotal${rowCounter}">Rp 0</td>

        <td class="text-center align-middle">
            <span class="btn-delete" onclick="deleteRow(${rowCounter})">🗑️</span>
        </td>
    </tr>`;

    $("#itemsBody").append(rowHTML);

    // isi dropdown pertama kali
    refreshSelectOptions();
}

// ========================================================
// UPDATE ROW (ketika pilih barang)
// ========================================================
function updateRow(id) {
    const select = $(`.sel${id}`);
    const opt = select.find(":selected");

    if (!opt.val()) {
        resetRow(id);
        return;
    }

    const hargaBeli = parseInt(opt.data("harga")) || 0;
    const satuan = opt.data("satuan") || "-";
    const stok = parseInt(opt.data("stok")) || 0;

    const hargaJual = Math.round(hargaBeli + (hargaBeli * currentMargin / 100));
    const marginRp = hargaJual - hargaBeli;

    $(`.satuan${id}`).text(satuan);
    $(`.stok${id}`).html(`<span class="stok-badge">${stok}</span>`);
    $(`.harga-beli${id}`).text("Rp " + hargaBeli.toLocaleString("id-ID"));
    $(`.harga-jual${id}`).text("Rp " + hargaJual.toLocaleString("id-ID"));
    $(`.margin${id}`).html(`<span class="text-profit">+Rp ${marginRp.toLocaleString("id-ID")}</span>`);

    $(`.harga-input${id}`).val(hargaJual);
    $(`.jumlah${id}`).attr("max", stok).prop("disabled", false);

    calculateRow(id);

    refreshSelectOptions(); // anti duplikat update semua dropdown
}

// Reset row jika user pilih kosong
function resetRow(id) {
    $(`.satuan${id}`).text('-');
    $(`.stok${id}`).text('-');
    $(`.harga-beli${id}`).text("Rp 0");
    $(`.harga-jual${id}`).text("Rp 0");
    $(`.margin${id}`).text("Rp 0");
    $(`.jumlah${id}`).prop("disabled", true).val(1);
    $(`.subtotal${id}`).text("Rp 0");
    calculateTotal();
}

// ========================================================
// Hitung subtotal per row
// ========================================================
function calculateRow(id) {
    const harga = parseInt($(`.harga-input${id}`).val()) || 0;
    const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;

    const subtotal = harga * jumlah;

    $(`.subtotal${id}`).text("Rp " + subtotal.toLocaleString("id-ID"));

    calculateTotal();
}

// ========================================================
// Hitung total keseluruhan
// ========================================================
function calculateTotal() {
    let subtotalAll = 0;
    let totalProfit = 0;

    $("#itemsBody tr").each(function () {
        const id = this.id.replace("row", "");

        const select = $(`.sel${id}`);
        if (!select.val()) return;

        const opt = select.find(":selected");

        const hargaBeli = parseInt(opt.data("harga")) || 0;
        const hargaJual = parseInt($(`.harga-input${id}`).val()) || 0;
        const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;

        const subtotal = hargaJual * jumlah;
        const profit = (hargaJual - hargaBeli) * jumlah;

        subtotalAll += subtotal;
        totalProfit += profit;
    });

    const ppn = subtotalAll * 0.10;
    const total = subtotalAll + ppn;

    $("#displaySubtotal").text("Rp " + subtotalAll.toLocaleString("id-ID"));
    $("#displayPPN").text("Rp " + ppn.toLocaleString("id-ID"));
    $("#displayTotal").text("Rp " + total.toLocaleString("id-ID"));
    $("#displayProfit").text("Rp " + totalProfit.toLocaleString("id-ID"));
}

// ========================================================
// Hapus baris
// ========================================================
function deleteRow(id) {
    if ($("#itemsBody tr").length <= 1) {
        alert("Minimal harus ada 1 barang!");
        return;
    }

    $(`#row${id}`).remove();

    refreshSelectOptions();
    calculateTotal();
}

// ========================================================
// ANTI DUPLIKAT — Update semua dropdown
// ========================================================
function refreshSelectOptions() {
    // Ambil semua barang yang sudah dipilih
    let used = [];

    $(".select-barang").each(function () {
        let val = $(this).val();
        if (val) used.push(parseInt(val));
    });

    // Perbarui semua dropdown
    $(".select-barang").each(function () {

        const current = $(this).val();
        const select = $(this);

        select.empty();
        select.append(`<option value="">-- Pilih Barang --</option>`);

        barangData.forEach(b => {
            if (used.includes(b.idbarang) && current != b.idbarang) return;

            select.append(`
                <option value="${b.idbarang}"
                        data-nama="${b.nama}"
                        data-harga="${b.harga_beli}"
                        data-satuan="${b.nama_satuan}"
                        data-stok="${b.stok_tersedia}">
                        ${b.nama} (Stok: ${b.stok_tersedia})
                </option>
            `);
        });

        // pulihkan value sebelumnya
        select.val(current);
    });
}

// ========================================================
// Validasi sebelum submit
// ========================================================
$('#formPenjualan').on('submit', function(e) {
    let valid = true;

    $("#itemsBody tr").each(function () {
        const id = this.id.replace("row", "");

        const select = $(`.sel${id}`);
        const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;

        if (!select.val()) {
            alert("Ada baris barang yang belum dipilih!");
            valid = false;
            return false;
        }

        const stok = parseInt(select.find(":selected").data("stok")) || 0;

        if (jumlah > stok) {
            alert(`Jumlah penjualan melebihi stok: ${jumlah} > ${stok}`);
            valid = false;
            return false;
        }
    });

    if (!valid) e.preventDefault();
});
</script>

</body>

</html>