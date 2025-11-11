<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PBD App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">PBD App</a>
            <div class="d-flex">
                <a href="{{ url('/barang') }}" class="btn btn-light btn-sm me-2">Barang Aktif</a>
                <a href="{{ url('/barang/all') }}" class="btn btn-light btn-sm">Semua Barang</a>
            </div>
        </div>
    </nav>

    <main class="container mb-5">
        @yield('content')
    </main>

    <footer class="bg-light text-center text-muted py-3 border-top">
        <small>&copy; {{ date('Y') }} PBD App - by Princess 👑</small>
    </footer>
</body>
</html>
