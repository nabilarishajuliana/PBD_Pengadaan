<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>

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
    <h2 class="mb-4 text-center">Daftar User</h2>

    <table class="table table-bordered table-striped shadow-sm bg-white">
        <thead class="table-light">
            <tr class="text-center">
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $u)
            <tr>
                <td class="text-center">{{ $u->iduser }}</td>
                <td>{{ $u->username }}</td>
                <td class="text-center">{{ $u->nama_role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; {{ date('Y') }} PBD App - User View</p>
</footer>

</body>
</html>
