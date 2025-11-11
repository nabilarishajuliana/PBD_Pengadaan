<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #ffffff;">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="{{ url('/') }}" style="color:#2a2a2a; font-size:1.3rem;">
      🌿 PBD App
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
            🏠 Dashboard
          </a>
        </li>

        <!-- Data Master -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('barang*','vendor*','margin*','satuan*','role*','user*') ? 'active' : '' }}" 
             href="#" id="masterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            🧾 Data Master
          </a>
          <ul class="dropdown-menu shadow-sm border-0 rounded-3">
            <li><a class="dropdown-item" href="{{ url('/barang') }}">🧺 Barang</a></li>
            <li><a class="dropdown-item" href="{{ url('/vendor') }}">🏢 Vendor</a></li>
            <li><a class="dropdown-item" href="{{ url('/margin') }}">💰 Margin Penjualan</a></li>
            <li><a class="dropdown-item" href="{{ url('/satuan') }}">⚖️ Satuan</a></li>
            <li><a class="dropdown-item" href="{{ url('/role') }}">👥 Role</a></li>
            <li><a class="dropdown-item" href="{{ url('/user') }}">🙋‍♀️ User</a></li>
          </ul>
        </li>

        <!-- Transaksi -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('pengadaan*','penerimaan*','penjualan*','retur*') ? 'active' : '' }}" 
             href="#" id="transaksiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            💼 Transaksi
          </a>
          <ul class="dropdown-menu shadow-sm border-0 rounded-3">
            <li><a class="dropdown-item" href="{{ url('/pengadaan') }}">📦 Pengadaan</a></li>
            <li><a class="dropdown-item" href="{{ url('/penerimaan') }}">📥 Penerimaan</a></li>
            <li><a class="dropdown-item" href="{{ url('/penjualan') }}">💸 Penjualan</a></li>
            <li><a class="dropdown-item" href="{{ url('/retur') }}">📤 Retur</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
  .navbar {
      font-family:'Poppins',sans-serif;
      font-size:15px;
      backdrop-filter:blur(8px);
  }
  .nav-link {
      color:#2f3640;
      font-weight:500;
      transition:all .2s ease;
      padding:8px 14px;
      border-radius:10px;
  }
  .nav-link:hover {
      color:#1a73e8;
      background:rgba(26,115,232,0.05);
  }
  .nav-link.active {
      color:#1a73e8;
      background:rgba(26,115,232,0.12);
      font-weight:600;
  }
  .dropdown-menu {
      font-size:14px;
  }
  .dropdown-item {
      color:#2f3640;
      border-radius:6px;
      padding:8px 15px;
  }
  .dropdown-item:hover {
      background:#f5f7fa;
      color:#1a73e8;
  }
</style>
