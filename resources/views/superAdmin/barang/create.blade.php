<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Baru</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f9fb;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin-top: 40px;
            max-width: 700px;
        }

        .card {
            border-radius: 12px;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-primary {
            border-radius: 8px;
        }
    </style>
</head>

<body>

@include('components.navbar')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>➕ Tambah Barang Baru</h3>
        <a href="{{ route('superadmin.barang') }}" class="btn btn-secondary">⬅ Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Perhatikan input berikut:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>📦 Form Barang</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('superadmin.barang.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                    <select name="jenis" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="B" {{ old('jenis')=='B' ? 'selected' : '' }}>🥫 Bahan</option>
                        <option value="J" {{ old('jenis')=='J' ? 'selected' : '' }}>🍞 Jadi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan <span class="text-danger">*</span></label>
                    <select name="idsatuan" class="form-select" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach($satuan as $s)
                            <option value="{{ $s->idsatuan }}"
                                {{ old('idsatuan') == $s->idsatuan ? 'selected' : '' }}>
                                {{ $s->nama_satuan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Awal (Harga Beli) <span class="text-danger">*</span></label>
                    <input type="number" name="harga" min="0" class="form-control"
                        value="{{ old('harga') }}" required>
                    <small class="text-muted">Harga akan berubah otomatis ketika ada penerimaan barang baru.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ old('status')=='1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                

                <div class="text-end">
                    <button class="btn btn-primary btn-lg">
                        💾 Simpan Barang
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

</body>
</html>
