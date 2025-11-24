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
        // Data barang dari server
        const barangData = {!! json_encode($barangs) !!};
let rowCounter = 0;
let currentMargin = {{ $activeMargin->persen }}; // Langsung ambil dari margin aktif


        $(document).ready(function() {
            $('#margin').select2({
                placeholder: '-- Pilih Margin --',
                minimumResultsForSearch: -1
            });

            

            // Tambah baris pertama otomatis
            addRow();
        });

        function addRow() {
            rowCounter++;

            let options = '<option value="">-- Pilih Barang --</option>';
            barangData.forEach(b => {
                const jenisLabel = b.jenis == 'B' ? '🥫 Bahan' : '🍞 Jadi';
                options += `<option value="${b.idbarang}" 
                            data-nama="${b.nama}"
                            data-harga="${b.harga_beli}" 
                            data-satuan="${b.nama_satuan}"
                            data-stok="${b.stok_tersedia}">
                      ${jenisLabel} ${b.nama} (Stok: ${b.stok_tersedia})
                    </option>`;
            });

            const row = `
    <tr id="row${rowCounter}">
        <td class="text-center align-middle">${rowCounter}</td>
        <td>
            <select name="items[${rowCounter}][idbarang]" class="form-select form-select-sm select-barang" onchange="updateRow(${rowCounter})" required>
                ${options}
            </select>
        </td>
        <td class="align-middle text-center satuan${rowCounter}">-</td>
        <td class="align-middle text-center stok${rowCounter}">-</td>
        <td class="align-middle text-end harga-beli${rowCounter}">Rp 0</td>
        <td class="align-middle text-end harga-jual${rowCounter}">Rp 0</td>
        <td class="align-middle text-end margin${rowCounter}">Rp 0</td>
        <td>
            <input type="hidden" name="items[${rowCounter}][harga_satuan]" class="harga-input${rowCounter}">
            <input type="number" name="items[${rowCounter}][jumlah]" class="form-control form-control-sm text-center jumlah${rowCounter}" 
                   min="1" value="1" onchange="calculateRow(${rowCounter})" disabled required>
        </td>
        <td class="align-middle text-end subtotal${rowCounter}">Rp 0</td>
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

            if (!selectedOption.val()) {
                $(`.satuan${id}`).text('-');
                $(`.stok${id}`).text('-');
                $(`.harga-beli${id}`).text('Rp 0');
                $(`.harga-jual${id}`).text('Rp 0');
                $(`.margin${id}`).text('Rp 0');
                $(`.jumlah${id}`).prop('disabled', true);
                return;
            }

            const hargaBeli = parseInt(selectedOption.data('harga')) || 0;
            const satuan = selectedOption.data('satuan') || '-';
            const stok = parseInt(selectedOption.data('stok')) || 0;

            // Hitung harga jual dengan margin
            const hargaJual = Math.round(hargaBeli + (hargaBeli * currentMargin / 100));
            const marginRp = hargaJual - hargaBeli;

            $(`.satuan${id}`).text(satuan);
            $(`.stok${id}`).html(`<span class="stok-badge">${stok}</span>`);
            $(`.harga-beli${id}`).text('Rp ' + hargaBeli.toLocaleString('id-ID'));
            $(`.harga-jual${id}`).text('Rp ' + hargaJual.toLocaleString('id-ID'));
            $(`.margin${id}`).html(`<span class="text-profit">+Rp ${marginRp.toLocaleString('id-ID')}</span>`);
            $(`.harga-input${id}`).val(hargaJual);

            // Set max jumlah sesuai stok
            $(`.jumlah${id}`).attr('max', stok).prop('disabled', false);

            calculateRow(id);
        }

        function recalculateAllPrices() {
            $('#itemsBody tr').each(function() {
                const id = $(this).attr('id').replace('row', '');
                const select = $(`select[name="items[${id}][idbarang]"]`);

                if (select.val()) {
                    updateRow(id);
                }
            });
        }

        function calculateRow(id) {
            const hargaJual = parseInt($(`.harga-input${id}`).val()) || 0;
            const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;
            const subtotal = hargaJual * jumlah;

            $(`.subtotal${id}`).text('Rp ' + subtotal.toLocaleString('id-ID'));

            calculateTotal();
        }

        function calculateTotal() {
            let grandTotal = 0;
            let totalProfit = 0;

            $('#itemsBody tr').each(function() {
                const id = $(this).attr('id').replace('row', '');
                const select = $(`select[name="items[${id}][idbarang]"]`);

                if (select.val()) {
                    const selectedOption = select.find(':selected');
                    const hargaBeli = parseInt(selectedOption.data('harga')) || 0;
                    const hargaJual = parseInt($(`.harga-input${id}`).val()) || 0;
                    const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;

                    const subtotal = hargaJual * jumlah;
                    const profit = (hargaJual - hargaBeli) * jumlah;

                    grandTotal += subtotal;
                    totalProfit += profit;
                }
            });

            const ppn = grandTotal * 0.10;
            const total = grandTotal + ppn;

            $('#displaySubtotal').text('Rp ' + grandTotal.toLocaleString('id-ID'));
            $('#displayPPN').text('Rp ' + ppn.toLocaleString('id-ID'));
            $('#displayTotal').text('Rp ' + total.toLocaleString('id-ID'));
            $('#displayProfit').text('Rp ' + totalProfit.toLocaleString('id-ID'));
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
        $('#formPenjualan').on('submit', function(e) {
            if ($('#itemsBody tr').length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 barang!');
                return false;
            }

            // Validasi stok
            let stokValid = true;
            $('#itemsBody tr').each(function() {
                const id = $(this).attr('id').replace('row', '');
                const select = $(`select[name="items[${id}][idbarang]"]`);

                if (select.val()) {
                    const selectedOption = select.find(':selected');
                    const stok = parseInt(selectedOption.data('stok')) || 0;
                    const jumlah = parseInt($(`.jumlah${id}`).val()) || 0;
                    const namaBarang = selectedOption.data('nama');

                    if (jumlah > stok) {
                        alert(`Stok ${namaBarang} tidak cukup! Stok tersedia: ${stok}, Jumlah diminta: ${jumlah}`);
                        stokValid = false;
                        return false;
                    }
                }
            });

            if (!stokValid) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>