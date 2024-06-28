<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/themify-icons/themify-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-override.min.css') }}" />
  <style>
    .profile-icon {
      color: #007bff; /* Warna biru */
      margin-right: 8px; /* Memberikan sedikit ruang antara ikon dan keterangan */
    }
  </style>
</head>

<body>
  @include('sweetalert::alert')
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <div id="app">
    <div class="shadow-header"></div>
    <header class="header-navbar fixed">
      <div class="header-wrapper">
        <div class="header-left">
          <div class="sidebar-toggle action-toggle"><i class="fas fa-bars"></i></div>
        </div>
        <div class="header-content">
          {{-- <div class="notification dropdown me-2">
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="far fa-bell"></i>
              <span class="badge">12</span>
            </a>
            <ul class="dropdown-menu medium">
              <li class="menu-header">
                <a class="dropdown-item" href="#">Notification</a>
              </li>
              <li class="menu-content ps-menu">
                <a href="#">
                  <div class="message-icon text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                  <div class="message-content read">
                    <div class="body">There's incoming event, don't miss it!!</div>
                    <div class="time">Just now</div>
                  </div>
                </a>
                <a href="#">
                  <div class="message-icon text-info">
                    <i class="fas fa-info"></i>
                  </div>
                  <div class="message-content read">
                    <div class="body">Your licence will expired soon</div>
                    <div class="time">3 hours ago</div>
                  </div>
                </a>
                <a href="#">
                  <div class="message-icon text-success">
                    <i class="fas fa-check"></i>
                  </div>
                  <div class="message-content">
                    <div class="body">Successfully register new user</div>
                    <div class="time">8 hours ago</div>
                  </div>
                </a>
              </li>
            </ul>
          </div> --}}
          <div class="dropdown dropdown-menu-end">
            <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="label">
                <span></span>
                <div>
                  @if (Auth::user()->role == 'super_admin')
                    <i class="fas fa-user profile-icon"></i> Super Admin
                  @elseif(Auth::user()->role == 'admin')
                    <i class="fas fa-user profile-icon"></i> Admin
                  @elseif(Auth::user()->role == 'guru')
                    <i class="fas fa-user profile-icon"></i> Guru
                  @else
                    <i class="fas fa-user profile-icon"></i> Siswa
                  @endif
                </div>
              </div>
              <i class="ti-arrow-circle-down"></i>
            </a>
            <ul class="dropdown-menu small">
              <li class="menu-content ps-menu">
                <a href="{{ route('profile.edit') }}">
                  <div class="description"><i class="ti-user"></i> Profile</div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="javascript:void(0)"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">
                    <div class="description"><i class="ti-power-off"></i> Logout</div>
                  </a>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <nav class="main-sidebar ps-menu">
      <div class="sidebar-header">
        <div class="text fs-2">CODEAZY</div>
        <div class="close-sidebar action-toggle">
          <i class="ti-close"></i>
        </div>
      </div>
      @if (Auth::user()->role == 'super_admin')
        @include('layouts.sidebar.super-admin')
      @elseif(Auth::user()->role == 'admin')
        @include('layouts.sidebar.admin')
      @elseif(Auth::user()->role == 'guru')
        @include('layouts.sidebar.guru')
      @else
        @include('layouts.sidebar.siswa')
      @endif
    </nav>
    <main class="main-content">
      @yield('main')
    </main>

    <footer>
      Copyright © 2024 Selpu V.2
      <span> . All rights Reserved</span>
    </footer>
    <div class="overlay action-toggle"></div>
  </div>
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
  <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.min.js') }}"></script>
  <script>
    Main.init();
  </script>
</body>

</html>
