<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satuan {{ $mode == 'all' ? '(Semua)' : '(Aktif)' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f7f9fb;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        h2 {
            font-weight: 600;
            color: #0d6efd;
        }
        table {
            border-radius: 8px;
            overflow: hidden;
        }
        .btn-switch {
            border-radius: 8px;
            font-weight: 500;
        }
        footer {
            margin-top: 40px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
@include('components.navbar')

<div class="container">
    <h2 class="mb-4 text-center">
        Daftar Satuan {{ $mode == 'all' ? '(Semua)' : '(Aktif Saja)' }}
    </h2>

    <div class="text-center mb-4">
        <a href="{{ url('/satuan') }}" class="btn btn-success btn-switch me-2">Satuan Aktif</a>
        <a href="{{ url('/satuan/all') }}" class="btn btn-primary btn-switch">Semua Satuan</a>
    </div>

    <table class="table table-bordered table-striped shadow-sm bg-white">
        <thead class="table-light">
            <tr class="text-center">
                <th>ID</th>
                <th>Nama Satuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($satuan as $s)
            <tr>
                <td class="text-center">{{ $s->idsatuan }}</td>
                <td>{{ $s->nama_satuan }}</td>
                <td class="text-center">
                    <span class="badge {{ $s->status == 1 ? 'bg-success' : 'bg-secondary' }}">
                        {{ $s->status == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; {{ date('Y') }} PBD App - Satuan View</p>
</footer>

</body>
</html>
