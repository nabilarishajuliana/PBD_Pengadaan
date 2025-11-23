<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">PBD App</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        @if(session()->has('username'))
          <li class="nav-item me-2"><span class="nav-link">Hi, {{ session('username') }}</span></li>
          <li class="nav-item"><a class="nav-link text-danger" href="{{ url('/logout') }}">Logout</a></li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>
