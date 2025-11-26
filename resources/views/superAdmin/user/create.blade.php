<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat User Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f9fb;
            font-family: Poppins, sans-serif;
        }
        .container { margin-top: 40px; }
        .card { border-radius: 12px; }
        .form-label { font-weight: 600; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>➕ Buat User Baru</h3>
        <a href="{{ route('superadmin.user') }}" class="btn btn-secondary">⬅ Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

            <form action="{{ route('superadmin.user.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">👤 Username</label>
                    <input type="text" name="username" class="form-control" required autocomplete="off">
                </div>

                <div class="mb-3">
                    <label class="form-label">🔒 Password (Tidak dienkripsi)</label>
                    <input type="text" name="password" class="form-control" required autocomplete="off">
                </div>

                <div class="mb-3">
                    <label class="form-label">🎭 Role User</label>
                    <select name="idrole" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->idrole }}">{{ ucfirst($r->nama_role) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-primary btn-lg">💾 Simpan User</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
