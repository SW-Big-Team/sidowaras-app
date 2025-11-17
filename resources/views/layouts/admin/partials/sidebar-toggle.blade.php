{{-- Sidebar Toggle Button (Mobile & Desktop) --}}
<div class="sidebar-toggle-plugin">
  <button 
    type="button"
    class="sidebar-toggle-button"
    id="sidebarToggleBtn"
    data-tooltip="Tutup Sidebar"
    onclick="toggleSidebar()"
  >
    <i class="material-symbols-rounded">menu</i>
  </button>
</div>


<style>
/* Wrapper: posisi fixed di kanan bawah (DI BAWAH configurator) */
.sidebar-toggle-plugin {
  position: fixed;
  right: 20px;
  bottom: 20px; /* Posisi paling bawah */
  z-index: 2050;
}

/* Tombol bulat */
.sidebar-toggle-button {
  width: 56px;
  height: 56px;
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.16);
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.34, 1.61, 0.7, 1);
  border: none;
  padding: 0;
}

.sidebar-toggle-button i {
  font-size: 24px;
  color: #344767;
  transition: transform 0.3s ease;
}

/* rotate icon when hidden */
.g-sidenav-hidden .sidebar-toggle-button i {
  transform: rotate(180deg);
}

/* Tooltip */
.sidebar-toggle-button::before {
  content: attr(data-tooltip);
  position: absolute;
  right: 70px;
  background: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  font-size: 13px;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
  font-weight: 500;
}

.sidebar-toggle-button:hover::before {
  opacity: 1;
}

.sidebar-toggle-button::after {
  content: '';
  position: absolute;
  right: 60px;
  border: 6px solid transparent;
  border-left-color: rgba(0, 0, 0, 0.8);
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}

.sidebar-toggle-button:hover::after {
  opacity: 1;
}

/* Hide tooltip on mobile */
@media (max-width: 768px) {
  .sidebar-toggle-button::before,
  .sidebar-toggle-button::after {
    display: none;
  }

  .sidebar-toggle-plugin {
    bottom: 16px;
    right: 16px;
  }
}

/* Extra small screens */
@media (max-width: 575px) {
  .sidebar-toggle-plugin {
    bottom: 16px;
    right: 16px;
  }

  .sidebar-toggle-button {
    width: 48px;
    height: 48px;
  }

  .sidebar-toggle-button i {
    font-size: 20px;
  }
}
</style>

<script>
/**
 * Toggle Sidebar Function
 */
function toggleSidebar() {
  const body = document.body;
  const btn = document.getElementById('sidebarToggleBtn');

  if (body.classList.contains('g-sidenav-show')) {
    body.classList.remove('g-sidenav-show');
    body.classList.add('g-sidenav-hidden');
    btn.setAttribute('data-tooltip', 'Buka Sidebar');
    localStorage.setItem('sidebarState', 'hidden');
  } else {
    body.classList.remove('g-sidenav-hidden');
    body.classList.add('g-sidenav-show');
    btn.setAttribute('data-tooltip', 'Tutup Sidebar');
    localStorage.setItem('sidebarState', 'show');
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById('sidebarToggleBtn');
  const body = document.body;
  const isMobile = window.innerWidth < 1200;
  const savedState = localStorage.getItem('sidebarState');

  // inisialisasi state sidebar (kode lamamu di sini boleh tetap dipakai)
  if (isMobile) {
    if (savedState === 'show') {
      body.classList.add('g-sidenav-show');
      body.classList.remove('g-sidenav-hidden');
      btn.setAttribute('data-tooltip', 'Tutup Sidebar');
    } else {
      body.classList.add('g-sidenav-hidden');
      body.classList.remove('g-sidenav-show');
      btn.setAttribute('data-tooltip', 'Buka Sidebar');
    }
  } else {
    if (savedState === 'hidden') {
      body.classList.add('g-sidenav-hidden');
      body.classList.remove('g-sidenav-show');
      btn.setAttribute('data-tooltip', 'Buka Sidebar');
    } else {
      body.classList.add('g-sidenav-show');
      body.classList.remove('g-sidenav-hidden');
      btn.setAttribute('data-tooltip', 'Tutup Sidebar');
    }
  }

  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function(event) {
    if (isMobile && body.classList.contains('g-sidenav-show')) {
      const sidebar = document.querySelector('.sidenav');
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      
      if (sidebar && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
        body.classList.remove('g-sidenav-show');
        body.classList.add('g-sidenav-hidden');
        btn.setAttribute('data-tooltip', 'Buka Sidebar');
        localStorage.setItem('sidebarState', 'hidden');
      }
    }
  });

  // Handle window resize
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      const isNowMobile = window.innerWidth < 1200;
      const savedState = localStorage.getItem('sidebarState');
      
      if (isNowMobile) {
        if (savedState === 'hidden' || !savedState) {
          body.classList.add('g-sidenav-hidden');
          body.classList.remove('g-sidenav-show');
          btn.setAttribute('data-tooltip', 'Buka Sidebar');
        }
      } else {
        if (savedState !== 'hidden') {
          body.classList.add('g-sidenav-show');
          body.classList.remove('g-sidenav-hidden');
          btn.setAttribute('data-tooltip', 'Tutup Sidebar');
        }
      }
    }, 250);
  });
});
</script>
