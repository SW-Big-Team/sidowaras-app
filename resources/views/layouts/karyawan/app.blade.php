<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <title>@yield('title', 'Dashboard Karyawan - Sidowaras App')</title>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

  <style>
    /* Custom Professional Styles */
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }
    
    /* Sidebar Toggle Styles */
    .sidenav {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 1050;
      transition: transform 0.3s ease;
    }
    
    /* Desktop Behavior */
    @media (min-width: 1200px) {
      .g-sidenav-show .sidenav {
        transform: translateX(0);
      }
      
      .g-sidenav-hidden .sidenav {
        transform: translateX(-100%);
      }
      
      .g-sidenav-hidden .main-content {
        margin-left: 0 !important;
      }
      
      .g-sidenav-show .main-content {
        margin-left: 17.125rem;
      }
    }
    
    /* Mobile/Tablet Behavior */
    @media (max-width: 1199px) {
      .sidenav {
        transform: translateX(-100%);
      }
      
      .g-sidenav-show .sidenav {
        transform: translateX(0) !important;
      }
      
      .g-sidenav-hidden .sidenav {
        transform: translateX(-100%) !important;
      }
      
      .main-content {
        margin-left: 0 !important;
      }
      
      /* Backdrop overlay when sidebar is open on mobile */
      .g-sidenav-show::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1049;
        animation: fadeIn 0.3s ease;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }
    }
    
    .main-content {
      background: transparent;
      transition: margin-left 0.3s ease;
      position: relative;
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
      background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(6, 182, 212, 0.3);
    }
    
    .page-header {
      background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
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
  
  @include('layouts.karyawan.partials.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('layouts.karyawan.partials.navbar')

    <div class="container-fluid py-4">
      @yield('content')
      @include('layouts.karyawan.partials.footer')
    </div>
  </main>

  @include('layouts.karyawan.partials.notifications-modal')
  
  {{-- THE EXTERNAL TOGGLE BUTTON --}}
  @include('layouts.karyawan.partials.sidebar-toggle')

  <script src="{{ asset('assets/js/core/popper.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}" defer></script>

  @stack('scripts')

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    
    // Notification functions
    function markAsRead(notifId) {
      const link = event.currentTarget.href;
      event.preventDefault();
      
      fetch(`/notifications/${notifId}/read`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      }).then(() => {
        if (link && link !== '#' && !link.includes('#')) {
          window.location.href = link;
        } else {
          location.reload();
        }
      });
      return false;
    }

    // Session Check
    setInterval(() => {
    fetch("/session/check")
        .then(res => res.json())
        .then(data => {
        if (!data.authenticated) {
            window.location.href = "/login";
        }
        }).catch(() => { });
    }, 30000);
  </script>
</body>
</html>