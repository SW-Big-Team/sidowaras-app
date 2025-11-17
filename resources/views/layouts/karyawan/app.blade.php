
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  {{-- Penting untuk AJAX/Fetch --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <title>@yield('title', 'Dashboard Karyawan - Sidowaras App')</title>

  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Symbols -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Main CSS -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

  <style>
    :root {
      --sw-primary: #1d4ed8;
      --sw-primary-dark: #1e3a8a;
      --sw-primary-soft: #e0e7ff;
      --sw-accent: #0ea5e9;
      --sw-text: #0f172a;
      --sw-muted: #64748b;
      --sw-border: rgba(15, 23, 42, 0.08);
      --sw-card-radius: 1rem;
      --sw-surface: #ffffff;
      --sw-surface-alt: #f8fafc;
      --sw-shadow-soft: 0 10px 30px rgba(15, 23, 42, 0.08);
      --sw-shadow-strong: 0 18px 45px rgba(15, 23, 42, 0.12);
    }

    * {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
      min-height: 100vh;
      overflow-x: hidden;
      color: var(--sw-text);
    }

    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background: radial-gradient(circle at top right, rgba(14, 165, 233, 0.08), transparent 45%);
      pointer-events: none;
      z-index: -1;
    }

    .main-content {
      background: transparent;
      transition: margin-left 0.3s ease;
      position: relative;
    }

    a,
    button {
      transition: color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    a:focus-visible,
    button:focus-visible,
    .form-control:focus-visible {
      outline: 3px solid rgba(37, 99, 235, 0.35);
      outline-offset: 2px;
    }

    /* SIDENAV ------------------------------------------------ */
    .sidenav {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 1050;
      transition: transform 0.3s ease;
      background: var(--sw-surface);
      border: 1px solid var(--sw-border);
      box-shadow: var(--sw-shadow-soft);
    }

    .sidenav .navbar-brand {
      border-radius: 0.85rem;
      background: linear-gradient(135deg, #ffffff 0%, #f4f6fb 100%);
      border: 1px solid rgba(15, 23, 42, 0.04);
    }

    .sidenav .navbar-brand span {
      color: var(--sw-text);
    }

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
        margin-left: 17rem;
      }
    }

    @media (max-width: 1199.98px) {
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

      .g-sidenav-show::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        z-index: 1049;
        animation: sw-fadeIn 0.25s ease-out;
      }

      @keyframes sw-fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }
    }

    /* NAV COMPONENTS ---------------------------------------- */
    .karyawan-nav-section-title {
      font-size: 0.75rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      margin: 1rem 0 0.5rem;
      color: var(--sw-muted);
      font-weight: 600;
    }

    .karyawan-nav-link {
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      display: flex;
      align-items: center;
      font-weight: 500;
      color: var(--sw-text);
      border: 1px solid transparent;
    }

    .karyawan-nav-link .icon {
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 0.85rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 0.75rem;
      background: var(--sw-surface-alt);
      color: var(--sw-primary);
      font-size: 1.25rem;
    }

    .karyawan-nav-link:hover {
      background: rgba(37, 99, 235, 0.08);
      border-color: rgba(29, 78, 216, 0.15);
      transform: translateX(3px);
    }

    .karyawan-nav-link.active {
      background: rgba(29, 78, 216, 0.12);
      border-color: rgba(29, 78, 216, 0.35);
      color: var(--sw-primary-dark);
      box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.4);
    }

    .karyawan-nav-link.active .icon {
      background: var(--sw-primary);
      color: #fff;
      box-shadow: 0 6px 12px rgba(29, 78, 216, 0.25);
    }

    .karyawan-navbar {
      background: rgba(255, 255, 255, 0.92);
      border: 1px solid var(--sw-border);
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.05);
      border-radius: 1rem;
      backdrop-filter: blur(10px);
      position: sticky;
      top: 1rem;
      z-index: 1020;
    }

    .karyawan-navbar__actions > * + * {
      margin-left: 0.75rem;
    }

    .karyawan-navbar__icon-btn {
      border: 1px solid var(--sw-border);
      border-radius: 0.85rem;
      padding: 0.6rem;
      background: var(--sw-surface);
      color: var(--sw-text);
      position: relative;
    }

    .karyawan-navbar__icon-btn:hover {
      border-color: rgba(29, 78, 216, 0.3);
      color: var(--sw-primary);
      background: rgba(226, 232, 240, 0.5);
    }

    .badge-soft {
      background: rgba(37, 99, 235, 0.12);
      color: var(--sw-primary);
      border-radius: 999px;
      padding: 0.15rem 0.5rem;
      font-size: 0.7rem;
      font-weight: 600;
    }

    /* CARD & BUTTONS ---------------------------------------- */
    .card {
      border: 1px solid var(--sw-border);
      border-radius: var(--sw-card-radius);
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-2px);
      box-shadow: var(--sw-shadow-soft);
    }

    .card-header {
      border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    }

    .btn-primary {
      background: var(--sw-primary);
      border-color: var(--sw-primary);
      border-radius: 0.85rem;
      font-weight: 600;
    }

    .btn-primary:hover {
      background: var(--sw-primary-dark);
      border-color: var(--sw-primary-dark);
    }

    .btn-outline-primary {
      border-radius: 0.85rem;
      border-color: rgba(29, 78, 216, 0.35);
      color: var(--sw-primary);
      font-weight: 600;
    }

    .btn-outline-primary:hover {
      background: rgba(29, 78, 216, 0.08);
      color: var(--sw-primary-dark);
    }

    .page-header {
      background: var(--sw-surface);
      border: 1px solid var(--sw-border);
      border-radius: 1rem;
      padding: 1.5rem;
      box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
    }

    .page-header h4 {
      font-weight: 700;
      margin-bottom: 0.35rem;
    }

    .page-header p {
      color: var(--sw-muted);
    }

    .stats-card-icon {
      width: 3rem;
      height: 3rem;
      border-radius: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--sw-primary-soft);
      color: var(--sw-primary);
      font-size: 1.5rem;
    }

    .table-responsive table {
      border-radius: 1rem;
      overflow: hidden;
    }

    .table thead th {
      font-size: 0.7rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      color: var(--sw-muted);
      border-bottom-width: 1px;
    }

    .table tbody td {
      vertical-align: middle;
    }

    /* CONFIGURATOR & SIDEBAR TOGGLE ------------------------- */
    .fixed-plugin-button {
      position: fixed;
      right: 1.25rem;
      bottom: 1.25rem;
      width: 54px;
      height: 54px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--sw-surface);
      border: 1px solid var(--sw-border);
      box-shadow: 0 10px 24px rgba(15, 23, 42, 0.2);
      cursor: pointer;
    }

    .fixed-plugin-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 16px 30px rgba(15, 23, 42, 0.25);
    }

    .sidebar-toggle-plugin {
      position: fixed;
      right: 1.25rem;
      bottom: calc(1.25rem + 54px + 14px);
      z-index: 1060;
    }

    .sidebar-toggle-button {
      width: 54px;
      height: 54px;
      background: var(--sw-surface);
      border: 1px solid var(--sw-border);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 24px rgba(15, 23, 42, 0.2);
    }

    .sidebar-toggle-button .material-symbols-rounded {
      color: var(--sw-text);
      font-size: 24px;
    }

    .sidebar-toggle-button:hover {
      transform: translateY(-1px);
      border-color: rgba(29, 78, 216, 0.35);
    }

    .sidebar-toggle-button::before {
      content: attr(data-tooltip);
      position: absolute;
      right: 70px;
      background: rgba(15, 23, 42, 0.85);
      color: #fff;
      padding: 6px 12px;
      border-radius: 0.5rem;
      font-size: 0.75rem;
      opacity: 0;
      pointer-events: none;
    }

    .sidebar-toggle-button:hover::before {
      opacity: 1;
    }

    @media (max-width: 575.98px) {
      .fixed-plugin-button,
      .sidebar-toggle-button {
        width: 48px;
        height: 48px;
      }

      .sidebar-toggle-plugin {
        right: 1rem;
        bottom: calc(1rem + 48px + 12px);
      }

      .sidebar-toggle-button::before,
      .sidebar-toggle-button::after {
        display: none;
      }
    }
  </style>

  @stack('styles')
</head>

<body class="g-sidenav-show">
  {{-- SIDEBAR --}}
  @include('layouts.karyawan.partials.sidebar')

  {{-- MAIN CONTENT --}}
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('layouts.karyawan.partials.navbar')

    <div class="container-fluid py-4">
      @yield('content')
      @include('layouts.karyawan.partials.footer')
    </div>
  </main>

  {{-- CONFIGURATOR & TOGGLE SIDEBAR --}}
  @include('layouts.karyawan.partials.configurator')
  @include('layouts.karyawan.partials.notifications-modal')
  @include('layouts.karyawan.partials.sidebar-toggle')

  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}" defer></script>

  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Smooth scrollbar untuk Windows
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = { damping: '0.5' };
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }

      const body = document.body;
      const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');

      // Inisialisasi state sidebar dari localStorage
      function initSidebarState() {
        const savedState = localStorage.getItem('sidebarState');
        const isMobile = window.innerWidth < 1200;

        if (isMobile) {
          if (savedState === 'show') {
            body.classList.add('g-sidenav-show');
            body.classList.remove('g-sidenav-hidden');
            if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Tutup Sidebar');
          } else {
            body.classList.add('g-sidenav-hidden');
            body.classList.remove('g-sidenav-show');
            if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Buka Sidebar');
          }
        } else {
          if (savedState === 'hidden') {
            body.classList.add('g-sidenav-hidden');
            body.classList.remove('g-sidenav-show');
            if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Buka Sidebar');
          } else {
            body.classList.add('g-sidenav-show');
            body.classList.remove('g-sidenav-hidden');
            if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Tutup Sidebar');
          }
        }
      }

      initSidebarState();

      // Global toggle function (dipakai di partial sidebar-toggle)
      window.toggleSidebar = function () {
        const isShown = body.classList.contains('g-sidenav-show');

        if (isShown) {
          body.classList.remove('g-sidenav-show');
          body.classList.add('g-sidenav-hidden');
          if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Buka Sidebar');
          localStorage.setItem('sidebarState', 'hidden');
        } else {
          body.classList.remove('g-sidenav-hidden');
          body.classList.add('g-sidenav-show');
          if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Tutup Sidebar');
          localStorage.setItem('sidebarState', 'show');
        }
      };

      // Klik di luar sidebar (mobile) => tutup sidebar
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
          if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('data-tooltip', 'Buka Sidebar');
          localStorage.setItem('sidebarState', 'hidden');
        }
      });

      // Handle resize => sesuaikan mode mobile/desktop
      let resizeTimer;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initSidebarState, 200);
      });

      // Notification: mark single as read
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

      // Notification: mark all as read
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

      // Session check (bisa kamu kecilin interval kalau terlalu sering)
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
