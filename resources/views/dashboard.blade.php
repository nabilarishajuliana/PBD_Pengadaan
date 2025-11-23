<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBD App Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
        background-color:#fafafa;
        font-family:'Poppins',sans-serif;
        color:#2f3640;
        min-height:100vh;
    }
    .dashboard-header {
        text-align:center;
        margin-top:60px;
        margin-bottom:40px;
    }
    .dashboard-header h1 {
        font-weight:600;
        color:#1a73e8;
        font-size:2.2rem;
    }
    .dashboard-header h5 {
        color:#6c757d;
        font-weight:400;
        font-size:1rem;
    }
    .dashboard-card {
        background:#fff;
        border:1px solid #e0e0e0;
        border-radius:16px;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
        transition:all .25s ease;
        text-align:center;
        padding:28px 10px;
        cursor:pointer;
    }
    .dashboard-card:hover {
        transform:translateY(-5px);
        box-shadow:0 6px 15px rgba(26,115,232,0.15);
    }
    .dashboard-card h4 {
        color:#1a237e;
        font-weight:600;
        font-size:1.1rem;
        margin-bottom:6px;
    }
    .dashboard-card p {
        color:#6c757d;
        font-size:13px;
    }
    .dashboard-icon {
        font-size:34px;
        margin-bottom:10px;
        color:#1a73e8;
    }
    .dashboard-grid {
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:22px;
    }
    footer {
        text-align:center;
        color:#9e9e9e;
        font-size:14px;
        margin-top:60px;
        padding-bottom:25px;
    }
    footer span {
        color:#1a73e8;
        font-weight:500;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="dashboard-header">
    <h1>home</h1>
  </div>



    <a href="{{ url('/login') }}" class="text-decoration-none text-dark">
      <div class="dashboard-card">
        <div class="dashboard-icon">👥</div>
        <h4>Login</h4>
      </div>
    </a>

    
  </div>

  <!-- <footer>
    <p>&copy; {{ date('Y') }} <span>PBD App</span> | Simple Elegant UI by Princess 👑</p>
  </footer> -->
</div>
</body>
</html>
