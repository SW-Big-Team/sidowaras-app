<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <title>@yield('title', 'Dashboard Karyawan - Sidowaras App')</title>

  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <!-- Material Symbols -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Main CSS -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

  <style>
    :root {
      --sw-primary: #3b82f6;
      --sw-primary-dark: #2563eb;
      --sw-primary-soft: #eff6ff;
      --sw-text: #1e293b;
      --sw-muted: #64748b;
      --sw-border: #e2e8f0;
      --sw-surface: #ffffff;
      --sw-surface-alt: #f8fafc;
      --sw-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --sw-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--sw-surface-alt);
      color: var(--sw-text);
    }

    /* Sidebar Styling */
    .sidenav {
      background: var(--sw-surface);
      border-right: 1px solid var(--sw-border);
      box-shadow: none;
      transition: transform 0.3s ease-in-out, opacity 0.2s ease-in-out;
    }

    /* --------- PERBAIKAN UTAMA: HIDE / SHOW SIDEBAR ---------- */

    /* Saat sidebar ditampilkan */
    body.g-sidenav-show .sidenav {
      transform: translateX(0) !important;
      opacity: 1 !important;
      pointer-events: auto !important;
    }

    /* Saat sidebar disembunyikan: keluar layar & tidak bisa diklik */
    body.g-sidenav-hidden .sidenav {
      transform: translateX(-120%) !important;
      opacity: 0 !important;
      pointer-events: none !important;
    }

    /* Main Content Transition */
    .main-content {
      transition: margin-left 0.3s ease-in-out;
    }

    @media (min-width: 1200px) {
      /* Sidebar kelihatan → main-content geser ke kanan */
      body.g-sidenav-show .main-content {
        margin-left: 17.125rem;
      }

      /* Sidebar hilang → main-content full width */
      body.g-sidenav-hidden .main-content {
        margin-left: 0 !important;
      }
    }

    /* Navbar Styling */
    .navbar-main,
      #navbarBlur.navbar-main {
          position: sticky !important;   /* membuat navbar selalu di atas saat scroll */
          top: 0 !important;             /* ditempelkan ke atas */
          z-index: 9999 !important;      /* tertinggi di seluruh halaman */
          background: rgba(255, 255, 255, 0.85) !important;
          backdrop-filter: blur(12px) !important;
      }
      
      /* ===============================
         SIDENAV ADJUST Z-INDEX (lebih rendah)
         =============================== */
      
      .sidenav {
          z-index: 3000 !important;      /* sidebar tetap di bawah navbar */
      }
      
      /* ===============================
         FIX: Plugin panel / floating button
         =============================== */
      
      .fixed-plugin .card {
          z-index: 5000 !important;      /* plugin UI (settings) */
      }
      
      .fixed-plugin-button-nav {
          z-index: 6000 !important;      /* tombol settings navbar */
      }
      
      /* ===============================
         OPTIONAL (lebih rapi)
         =============================== */
      
      .navbar-main {
          border-bottom: 1px solid rgba(226, 232, 240, 0.6) !important;
          box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
        }

    /* Card Styling Override */
    .card {
      box-shadow: var(--sw-shadow-sm);
      border: 1px solid var(--sw-border);
    }

    /* Utility Classes */
    .text-primary { color: var(--sw-primary) !important; }
    .bg-primary { background-color: var(--sw-primary) !important; }
    .bg-primary-subtle { background-color: var(--sw-primary-soft) !important; }
    
    /* Transitions */
    a, button, .card, .nav-link {
      transition: all 0.2s ease-in-out;
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
  @include('layouts.karyawan.partials.sidebar-toggle')

  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" defer></script>

  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}" defer></script>

  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Smooth Scrollbar for Windows
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = { damping: '0.5' };
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }

      const body = document.body;

      // Initialize Sidebar State
      function initSidebarState() {
        const savedState = localStorage.getItem('sidebarState');
        const isMobile = window.innerWidth < 1200;

        if (isMobile) {
          if (savedState === 'show') {
            body.classList.add('g-sidenav-show');
            body.classList.remove('g-sidenav-hidden');
          } else {
            body.classList.add('g-sidenav-hidden');
            body.classList.remove('g-sidenav-show');
          }
        } else {
          if (savedState === 'hidden') {
            body.classList.add('g-sidenav-hidden');
            body.classList.remove('g-sidenav-show');
          } else {
            body.classList.add('g-sidenav-show');
            body.classList.remove('g-sidenav-hidden');
          }
        }
      }

      initSidebarState();

      // Global Sidebar Toggle
      window.toggleSidebar = function () {
        const isShown = body.classList.contains('g-sidenav-show');
        
        if (isShown) {
          body.classList.remove('g-sidenav-show');
          body.classList.add('g-sidenav-hidden');
          localStorage.setItem('sidebarState', 'hidden');
        } else {
          body.classList.remove('g-sidenav-hidden');
          body.classList.add('g-sidenav-show');
          localStorage.setItem('sidebarState', 'show');
        }
      };

      // Close Sidebar on Outside Click (Mobile)
      document.addEventListener('click', function (event) {
        const isMobile = window.innerWidth < 1200;
        if (!isMobile) return;

        if (!body.classList.contains('g-sidenav-show')) return;

        const sidebar = document.querySelector('.sidenav');
        const toggleBtn = document.getElementById('sidebarToggleBtn');

        if (!sidebar) return;

        const clickedInsideSidebar = sidebar.contains(event.target);
        const clickedToggle = toggleBtn && toggleBtn.contains(event.target);

        if (!clickedInsideSidebar && !clickedToggle) {
          body.classList.remove('g-sidenav-show');
          body.classList.add('g-sidenav-hidden');
          localStorage.setItem('sidebarState', 'hidden');
        }
      });

      // Handle Resize
      let resizeTimer;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initSidebarState, 200);
      });

      // Notification: Mark as Read
      window.markAsRead = function (notifId) {
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
      };

      // Notification: Mark All as Read
      window.markAllAsRead = function () {
        event.preventDefault();
        fetch('/notifications/read-all', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        }).then(() => location.reload());
      };

      // Session Check
      setInterval(() => {
        fetch("/session/check")
          .then(res => res.json())
          .then(data => {
            if (!data.authenticated) {
              alert("Sesi Anda telah berakhir atau akun digunakan di tempat lain.");
              window.location.href = "/login";
            }
          })
          .catch(() => { });
      }, 10000);
    });
  </script>
</body>

</html>
