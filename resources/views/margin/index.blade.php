<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Margin Penjualan {{ $mode == 'all' ? '(Semua)' : '(Aktif)' }}</title>

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
        Margin Penjualan {{ $mode == 'all' ? '(Semua)' : '(Aktif Saja)' }}
    </h2>

    <div class="text-center mb-4">
        <a href="{{ url('/margin') }}" class="btn btn-success btn-switch me-2">Margin Aktif</a>
        <a href="{{ url('/margin/all') }}" class="btn btn-primary btn-switch">Semua Margin</a>
    </div>

    <table class="table table-bordered table-striped shadow-sm bg-white">
        <thead class="table-light">
            <tr class="text-center">
                <th>ID</th>
                <th>Persen</th>
                <th>Dibuat Oleh</th>
                <th>Status</th>
                <th>Dibuat Pada</th>
                <th>Diperbarui Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($margin as $m)
            <tr>
                <td class="text-center">{{ $m->idmargin_penjualan }}</td>
                <td class="text-center">{{ $m->persen }}%</td>
                <td class="text-center">{{ $m->dibuat_oleh }}</td>
                <td class="text-center">
                    <span class="badge {{ $m->status == 1 ? 'bg-success' : 'bg-secondary' }}">
                        {{ $m->status == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="text-center">{{ $m->created_at }}</td>
                <td class="text-center">{{ $m->updated_at ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; {{ date('Y') }} PBD App - Margin Penjualan View</p>
</footer>

</body>
</html>
