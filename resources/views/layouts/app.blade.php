<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBD App - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            background: #f7f9fb;

        }
        .main-content {
            background: #f7f9fb;
            min-height: calc(100vh - 60px);
            margin-top: 60px;
            padding: 2rem 0;
        }
        .dashboard-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border-radius: 15px;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s;
        }
        .dashboard-card:hover::before {
            left: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .dashboard-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
        }
        .dashboard-card p {
            color: #6c757d;
            margin: 0;
            font-size: 0.9rem;
        }
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>

@include('components.navbar')

<div class="main-content">
    <div class="container">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>