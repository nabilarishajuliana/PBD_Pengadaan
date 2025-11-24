<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBD App - @yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: "Poppins", sans-serif;
        }
        .navbar {
            background: white;
        }
        .card {
            border-radius: 14px;
        }
        .dashboard-card {
            transition: all 0.2s ease;
            cursor: pointer;
            border-radius: 15px;
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<!-- <nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
            🌸 PBD App
        </a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-3">
                    <span class="text-secondary">
                        Hi, <strong>{{ session('username') }}</strong>
                        ({{ session('role') }})
                    </span>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav> -->
    @include('components.navbar')


<!-- Page Content -->
<div class="container py-4">
    @yield('content')
</div>

</body>
</html>
