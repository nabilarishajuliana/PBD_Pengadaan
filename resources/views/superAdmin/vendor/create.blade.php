<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Vendor Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* body {
            background: #f7f9fb;
            font-family: 'Poppins', sans-serif;
        }
        .container { margin-top: 40px; } */
        .card { border-radius: 12px; }
        .form-label { font-weight: 600; }
        body {
            background: #f7f9fb;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        /* .card {
            border-radius: 10px;
            border: none;
        } */

        .badge-admin {
            background: #17a2b8;
            color: #fff;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .badge-superadmin {
            background: #dc3545;
            color: #fff;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

@include('components.navbar')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>➕ Tambah Vendor</h3>
        <a href="{{ route('superadmin.vendor') }}" class="btn btn-secondary">⬅ Kembali</a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi Kesalahan:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('superadmin.vendor.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">🏢 Nama Vendor</label>
                    <input type="text" name="nama_vendor" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">📘 Badan Hukum</label>
                    <select name="badan_hukum" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="P">PT (Perseroan Terbatas)</option>
                        <option value="C">CV (Persekutuan Komanditer)</option>
                        <option value="U">UD (Usaha Dagang)</option>
                        <option value="F">Firma</option>
                        <option value="O">Perorangan</option>
                    </select>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-primary btn-lg">💾 Simpan Vendor</button>
                </div>

            </form>

        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
