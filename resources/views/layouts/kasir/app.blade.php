<!--
=========================================================
* Sidowaras App - Professional Kasir Dashboard
* Modern Medical/Healthcare Theme
=========================================================
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>@yield('title', 'Dashboard Kasir - Sidowaras App')</title>
  
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
  
  <style>
    /* Custom Professional Styles */
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }
    
    /* Sidebar Toggle Styles */
    .sidenav {
      z-index: 1050;
      transition: transform 0.3s ease, width 0.3s ease;
    }
    
    .g-sidenav-hidden .sidenav {
      transform: translateX(-100%);
    }
    
    @media (min-width: 1200px) {
      .g-sidenav-hidden .main-content {
        margin-left: 0 !important;
      }
      
      .g-sidenav-show .main-content {
        margin-left: 17.125rem;
      }
    }
    
    .main-content {
      background: transparent;
      transition: margin-left 0.3s ease;
    }
    
    .card {
      border: none;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(34, 197, 94, 0.3);
    }
    
    .page-header {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      border-radius: 1rem;
      margin-bottom: 2rem;
      padding: 2rem;
      color: white;
    }
    
    /* Sidebar Hover Effects */
    .sidenav .nav-link {
      transition: all 0.2s ease;
      border-radius: 0.5rem;
      margin: 0 0.5rem;
    }
    
    .sidenav .nav-link:not(.active):hover {
      background-color: #f8f9fa;
      transform: translateX(5px);
    }
  </style>
  
  @stack('styles')
</head>

<body class="g-sidenav-show">
  
  @include('layouts.kasir.partials.sidebar')
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    
    @include('layouts.kasir.partials.navbar')
    
    <div class="container-fluid py-4">
      @yield('content')
      
      @include('layouts.kasir.partials.footer')
    </div>
  </main>
  
  @include('layouts.kasir.partials.configurator')
  
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}"></script>
  
  @stack('scripts')
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    
    setInterval(() => {
        fetch("/session/check")
            .then(res => res.json())
            .then(data => {
                if (!data.authenticated) {
                    alert("Your session has expired or logged in elsewhere.");
                    window.location.href = "/login";
                }
            })
            .catch(() => {});
    }, 10000);
  </script>
</body>

</html>
