<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <!--<script src="{{ asset('js/app.js') }}" defer></script>-->

  <script src="{{ asset('js/core/jquery.min.js') }}" defer></script>

  <script src="{{ asset('js/core/popper.min.js') }}" defer></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}" defer></script>
  <script src="{{ asset('js/core/bootstrap-material-design.min.js') }}" defer></script>
  <script src="{{ asset('js/dashboard/material-dashboard.js') }}" defer></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" defer></script>
  <script src="{{ asset('js/theme.js') }}" defer></script>
  <!-- Fonts
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <!-- Styles -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dashboard/material-dashboard.css?v=2.1.2') }}" rel="stylesheet">
</head>

<body>
  <div class="wrapper ">
    <div class="sidebar" data-color="green" data-background-color="white">
      <div class="logo"><a href="/" class="simple-text logo-normal">
          <img src="{{ session('imgRuta') }}" style="width: 100%">
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active">
            <a class="nav-link" href="/">
              <i class="material-icons">dashboard</i>
              <p>Inicio</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/profile">
              <i class="material-icons">person</i>
              <p>Perfil</p>
            </a>
          </li>
          @if(Auth::user()->first_login != true)
          <li class="nav-item ">
            <a class="nav-link" href="/invoices">
              <i class="material-icons">content_paste</i>
              <p>Boletas</p>
            </a>
          </li>
          @endif
          @if (Auth::user()->role == 'admin')
          <li class="nav-item ">
            <a class="nav-link" href="/employees">
              <i class="material-icons">persons</i>
              <p>Administrar usuarios</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/logs">
              <i class="material-icons">dashboard</i>
              <p>Historial de registros</p>
            </a>
          </li>
          @endif
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
          <a class="navbar-brand" href="javascript:;">RUC: {{ session('rucSession')}} - {{ session('empSession') }}</a>
          </div>
          <div class="navbar-wrapper">
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="navbar-brand" href="javascript:;">Bienvenido {{ Auth::user()->name }}</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="/profile">Perfil</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          @yield('content')
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <a href="http://www.crt.com.pe/" target="_blank">
            <p>@2020 Commit Rollback Technology - All rights reserved</p>
          </a>
        </div>
      </footer>
    </div>
  </div>
</body>

</html>