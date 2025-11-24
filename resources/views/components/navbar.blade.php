<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <!-- BRAND -->
    <a class="navbar-brand fw-bold" href="{{ route('superadmin.dashboard') }}">
      🏪 PBD Inventory
    </a>

    <!-- TOGGLE BUTTON (Mobile) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}"
            href="{{ route('superadmin.dashboard') }}">
            Dashboard
          </a>
        </li>

        <!-- Master Data -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('superadmin/barang*') || request()->is('superadmin/vendor*') || request()->is('superadmin/satuan*') || request()->is('superadmin/margin*') || request()->is('superadmin/user*') || request()->is('superadmin/role*') ? 'active' : '' }}"
            href="#" role="button" data-bs-toggle="dropdown">
            Master Data
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('superadmin.barang') }}">📦 Barang</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.vendor') }}">🏢 Vendor</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.satuan') }}">📏 Satuan</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.margin') }}">📊 Margin</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('superadmin.user') }}">👥 User</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.role') }}">🔐 Role</a></li>
          </ul>
        </li>

        <!-- Transaksi -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('superadmin/pengadaan*') || request()->is('superadmin/penerimaan*') || request()->is('superadmin/penjualan*') || request()->is('superadmin/retur*') ? 'active' : '' }}"
            href="#" role="button" data-bs-toggle="dropdown">
            Transaksi
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('superadmin.pengadaan') }}">🛒 Pengadaan</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.penerimaan') }}">📦 Penerimaan</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.penjualan') }}">💰 Penjualan</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.retur') }}">↩️ Retur</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('superadmin.kartustok') ? 'active' : '' }}"
            href="{{ route('superadmin.kartustok') }}">
            kartu stok
          </a>
        </li>

      </ul>

      <!-- User Info & Logout -->
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            👤 {{ session('username', 'User') }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item disabled">Role: {{ session('nama_role', 'Admin') }}</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">🚪 Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  /* Simple Navbar Styling */
  .navbar {
    padding: 0.75rem 1rem;
  }

  .navbar-brand {
    font-size: 1.25rem;
  }

  .navbar-nav .nav-link {
    padding: 0.5rem 1rem;
    margin: 0 0.2rem;
    border-radius: 5px;
    transition: background 0.2s;
  }

  .navbar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
  }

  .navbar-nav .nav-link.active {
    background: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  .dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .dropdown-item {
    padding: 0.5rem 1rem;
    transition: background 0.2s;
  }

  .dropdown-item:hover {
    background: #f8f9fa;
  }

  @media (max-width: 991px) {
    .navbar-nav {
      padding-top: 0.5rem;
    }
  }
</style>