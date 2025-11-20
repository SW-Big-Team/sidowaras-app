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
    :root {
      --sw-primary: #3b82f6;
      --sw-primary-dark: #2563eb;
      --sw-primary-soft: #eff6ff;
      --sw-text: #1e293b;
      --sw-surface: #ffffff;
      --sw-surface-alt: #f8fafc;
      --sw-border: #e2e8f0;
      --sw-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--sw-surface-alt);
      color: var(--sw-text);
      overflow-x: hidden; /* Prevent horizontal scroll */
    }

    /* --- SIDEBAR LOGIC --- */
    .sidenav {
      z-index: 3000 !important; /* High, but below the toggle button */
      transition: transform 0.3s ease-in-out;
    }

    /* Mobile: Hidden by default (Off-screen left) */
    @media (max-width: 1199px) {
        body:not(.g-sidenav-show) .sidenav {
            transform: translateX(-120%) !important;
        }
        body.g-sidenav-show .sidenav {
            transform: translateX(0) !important;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        
        /* Dark Backdrop for Mobile */
        body.g-sidenav-show::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2999; /* Behind sidebar */
            backdrop-filter: blur(2px);
        }
    }

    /* Desktop: Standard Behavior */
    @media (min-width: 1200px) {
      body.g-sidenav-show .main-content {
        margin-left: 17.125rem;
      }
      body.g-sidenav-hidden .main-content {
        margin-left: 0 !important;
      }
      body.g-sidenav-hidden .sidenav {
        transform: translateX(-120%);
      }
    }

    /* Navbar Styling */
    .navbar-main {
        position: sticky !important;
        top: 0 !important;
        z-index: 1030 !important;
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(12px) !important;
    }

    /* Utility */
    .text-primary { color: var(--sw-primary) !important; }
    .bg-primary { background-color: var(--sw-primary) !important; }
    a, button, .card, .nav-link { transition: all 0.2s ease-in-out; }
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
    document.addEventListener('DOMContentLoaded', function () {
      
      // 1. CONFIGURATION
      const body = document.body;
      const className = 'g-sidenav-show';
      const mobileBreakPoint = 1200;

      // 2. HELPER: UPDATE ICON
      function updateToggleIcon(isShown) {
         const icon = document.querySelector('#sidebarToggleBtn i');
         if(icon) {
             icon.textContent = isShown ? 'close' : 'menu';
             icon.style.transform = isShown ? 'rotate(90deg)' : 'rotate(0deg)';
         }
      }

      // 3. INITIAL STATE (On Load)
      function initSidebarState() {
        const savedState = localStorage.getItem('sidebarState');
        const isMobile = window.innerWidth < mobileBreakPoint;

        if (isMobile) {
          // Mobile default: HIDDEN unless explicitly shown
          // However, usually on mobile load we want it hidden regardless of last state to save space
          body.classList.remove(className);
          updateToggleIcon(false);
        } else {
          // Desktop: Respect saved state
          if (savedState === 'hidden') {
            body.classList.remove(className);
          } else {
            body.classList.add(className);
          }
        }
      }

      // 4. GLOBAL TOGGLE FUNCTION
      window.toggleSidebar = function () {
        const isShown = body.classList.contains(className);
        
        if (isShown) {
          body.classList.remove(className);
          localStorage.setItem('sidebarState', 'hidden');
          updateToggleIcon(false);
        } else {
          body.classList.add(className);
          localStorage.setItem('sidebarState', 'show');
          updateToggleIcon(true);
        }
      };

      // 5. CLICK OUTSIDE TO CLOSE (Mobile Only)
      document.addEventListener('click', function (event) {
        const isMobile = window.innerWidth < mobileBreakPoint;
        if (!isMobile) return; // Do nothing on desktop

        // Only if sidebar is currently open
        if (body.classList.contains(className)) {
            const sidebar = document.querySelector('.sidenav');
            const toggleBtn = document.getElementById('sidebarToggleBtn');

            // Check if the click was OUTSIDE sidebar AND OUTSIDE toggle button
            const clickedInsideSidebar = sidebar && sidebar.contains(event.target);
            const clickedToggle = toggleBtn && toggleBtn.contains(event.target);

            if (!clickedInsideSidebar && !clickedToggle) {
                window.toggleSidebar(); // Reuse the toggle function to close it
            }
        }
      });

      // 6. INIT
      initSidebarState();

      // --- OTHER UTILITIES ---

      // Resize Handler
      let resizeTimer;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initSidebarState, 200);
      });

      // Notification Logic
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
           if (link && link !== '#' && !link.includes('#')) window.location.href = link;
           else location.reload();
        });
      };

      // Session Check
      setInterval(() => {
        fetch("/session/check")
          .then(res => res.json())
          .then(data => {
            if (!data.authenticated) {
              window.location.href = "/login";
            }
          }).catch(() => { });
      }, 30000); // Changed to 30s to reduce server load
    });
  </script>
</body>
</html>