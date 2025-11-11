<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Vendor {{ $mode == 'all' ? '(Semua)' : '(Aktif)' }}</title>

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
        Daftar Vendor {{ $mode == 'all' ? '(Semua)' : '(Aktif Saja)' }}
    </h2>

    <div class="text-center mb-4">
        <a href="{{ url('/vendor') }}" class="btn btn-success btn-switch me-2">Vendor Aktif</a>
        <a href="{{ url('/vendor/all') }}" class="btn btn-primary btn-switch">Semua Vendor</a>
    </div>

    <table class="table table-bordered table-striped shadow-sm bg-white">
        <thead class="table-light">
            <tr class="text-center">
                <th>ID</th>
                <th>Nama Vendor</th>
                <th>Badan Hukum</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendor as $v)
            <tr>
                <td class="text-center">{{ $v->idvendor }}</td>
                <td>{{ $v->nama_vendor }}</td>
                <td class="text-center">{{ $v->badan_hukum }}</td>
                <td class="text-center">
                    <span class="badge {{ $v->status == 'A' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $v->status == 'A' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; {{ date('Y') }} PBD App - Vendor View</p>
</footer>

</body>
</html>
