{{-- Sidebar Toggle Button (Mobile & Desktop) --}}
<div class="sidebar-toggle-plugin">
  <a class="sidebar-toggle-button text-dark position-fixed px-3 py-2" id="sidebarToggleBtn" onclick="toggleSidebar()">
    <i class="material-symbols-rounded py-2">menu</i>
  </a>
</div>

<style>
/* Sidebar Toggle Button Styles - Matching Configurator Style */
.sidebar-toggle-plugin {
  position: fixed;
  right: 20px;
  bottom: 20px; /* Position at bottom (below configurator) */
  z-index: 990;
}

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
  text-decoration: none;
  border: none;
}

.sidebar-toggle-button:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.24);
}

.sidebar-toggle-button:active {
  transform: scale(0.95);
}

.sidebar-toggle-button i {
  font-size: 24px;
  color: #344767;
  transition: transform 0.3s ease;
  margin: 0;
  padding: 16px 0 !important;
}

/* Rotate icon when sidebar is hidden */
.g-sidenav-hidden .sidebar-toggle-button i {
  transform: rotate(180deg);
}

/* Show button on all screen sizes */
.sidebar-toggle-button {
  display: flex !important;
}

/* Animation for smooth transition */
.sidebar-toggle-button {
  animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  50% {
    opacity: 1;
    transform: scale(1.05);
  }
  70% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  }
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

/* Tooltip arrow */
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
  
  /* Adjust position for mobile */
  .sidebar-toggle-plugin {
    bottom: 100px; /* Slightly adjusted for mobile */
  }
}

/* Responsive adjustments */
@media (max-width: 575px) {
  .sidebar-toggle-plugin {
    bottom: 90px;
    right: 15px;
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
 * Works for both mobile and desktop
 */
function toggleSidebar() {
  const body = document.body;
  const btn = document.getElementById('sidebarToggleBtn');
  
  // Toggle sidebar visibility class
  if (body.classList.contains('g-sidenav-show')) {
    body.classList.remove('g-sidenav-show');
    body.classList.add('g-sidenav-hidden');
    btn.setAttribute('data-tooltip', 'Buka Sidebar');
    
    // Save state to localStorage
    localStorage.setItem('sidebarState', 'hidden');
  } else {
    body.classList.remove('g-sidenav-hidden');
    body.classList.add('g-sidenav-show');
    btn.setAttribute('data-tooltip', 'Tutup Sidebar');
    
    // Save state to localStorage
    localStorage.setItem('sidebarState', 'show');
  }
}

/**
 * Initialize sidebar state on page load
 */
document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById('sidebarToggleBtn');
  const body = document.body;
  
  // Check if we're on mobile
  const isMobile = window.innerWidth < 1200;
  
  // Get saved state from localStorage
  const savedState = localStorage.getItem('sidebarState');
  
  // On mobile, default to hidden unless saved state says otherwise
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
    // On desktop, default to show unless saved state says otherwise
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
      
      // If click is outside sidebar and not on toggle button
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
      
      if (isNowMobile) {
        // Switch to mobile mode
        const savedState = localStorage.getItem('sidebarState');
        if (savedState === 'hidden' || !savedState) {
          body.classList.add('g-sidenav-hidden');
          body.classList.remove('g-sidenav-show');
          btn.setAttribute('data-tooltip', 'Buka Sidebar');
        }
      } else {
        // Switch to desktop mode
        const savedState = localStorage.getItem('sidebarState');
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

<style>
/* Sidebar Toggle Button Styles */
.sidebar-toggle-button {
  z-index: 1060;
}

.sidebar-toggle-btn {
  bottom: 20px;
  left: 20px;
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, #fb8500 0%, #ffb703 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.34, 1.61, 0.7, 1);
  box-shadow: 0 4px 20px rgba(251, 133, 0, 0.4);
  text-decoration: none;
  z-index: 1060;
}

.sidebar-toggle-btn:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 25px rgba(251, 133, 0, 0.6);
  background: linear-gradient(135deg, #ffb703 0%, #fb8500 100%);
}

.sidebar-toggle-btn:active {
  transform: scale(0.95);
}

.sidebar-toggle-btn i {
  font-size: 24px;
  color: white;
  transition: transform 0.3s ease;
}

/* Rotate icon when sidebar is hidden */
.g-sidenav-hidden .sidebar-toggle-btn i {
  transform: rotate(180deg);
}

/* Hide button on large screens when sidebar is visible */
@media (min-width: 1200px) {
  .g-sidenav-show .sidebar-toggle-btn {
    display: none;
  }
}

/* Always show on mobile/tablet */
@media (max-width: 1199px) {
  .sidebar-toggle-btn {
    display: flex !important;
  }
}

/* Adjust position when sidebar is open on mobile */
@media (max-width: 1199px) {
  .g-sidenav-show .sidebar-toggle-btn {
    left: calc(17.125rem + 20px);
  }
}

/* Animation for smooth transition */
.sidebar-toggle-btn {
  animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  50% {
    opacity: 1;
    transform: scale(1.05);
  }
  70% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  }
}

/* Pulse animation on mobile when sidebar is hidden */
@media (max-width: 1199px) {
  .g-sidenav-hidden .sidebar-toggle-btn {
    animation: pulse 2s infinite;
  }
}

@keyframes pulse {
  0% {
    box-shadow: 0 4px 20px rgba(251, 133, 0, 0.4);
  }
  50% {
    box-shadow: 0 4px 30px rgba(251, 133, 0, 0.7);
  }
  100% {
    box-shadow: 0 4px 20px rgba(251, 133, 0, 0.4);
  }
}

/* Tooltip */
.sidebar-toggle-btn::before {
  content: attr(data-tooltip);
  position: absolute;
  left: 60px;
  background: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}

.sidebar-toggle-btn:hover::before {
  opacity: 1;
}

/* Hide tooltip on mobile */
@media (max-width: 768px) {
  .sidebar-toggle-btn::before {
    display: none;
  }
}
</style>

<script>
/**
 * Toggle Sidebar Function
 * Works for both mobile and desktop
 */
function toggleSidebar() {
  const body = document.body;
  const btn = document.getElementById('sidebarToggleBtn');
  
  // Toggle sidebar visibility class
  if (body.classList.contains('g-sidenav-show')) {
    body.classList.remove('g-sidenav-show');
    body.classList.add('g-sidenav-hidden');
    btn.setAttribute('data-tooltip', 'Buka Menu');
    
    // Save state to localStorage
    localStorage.setItem('sidebarState', 'hidden');
  } else {
    body.classList.remove('g-sidenav-hidden');
    body.classList.add('g-sidenav-show');
    btn.setAttribute('data-tooltip', 'Tutup Menu');
    
    // Save state to localStorage
    localStorage.setItem('sidebarState', 'show');
  }
}

/**
 * Initialize sidebar state on page load
 */
document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById('sidebarToggleBtn');
  const body = document.body;
  
  // Check if we're on mobile
  const isMobile = window.innerWidth < 1200;
  
  // Get saved state from localStorage
  const savedState = localStorage.getItem('sidebarState');
  
  // On mobile, default to hidden unless saved state says otherwise
  if (isMobile) {
    if (savedState === 'show') {
      body.classList.add('g-sidenav-show');
      body.classList.remove('g-sidenav-hidden');
      btn.setAttribute('data-tooltip', 'Tutup Menu');
    } else {
      body.classList.add('g-sidenav-hidden');
      body.classList.remove('g-sidenav-show');
      btn.setAttribute('data-tooltip', 'Buka Menu');
    }
  } else {
    // On desktop, default to show unless saved state says otherwise
    if (savedState === 'hidden') {
      body.classList.add('g-sidenav-hidden');
      body.classList.remove('g-sidenav-show');
      btn.setAttribute('data-tooltip', 'Buka Menu');
    } else {
      body.classList.add('g-sidenav-show');
      body.classList.remove('g-sidenav-hidden');
      btn.setAttribute('data-tooltip', 'Tutup Menu');
    }
  }
  
  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function(event) {
    if (isMobile && body.classList.contains('g-sidenav-show')) {
      const sidebar = document.querySelector('.sidenav');
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      
      // If click is outside sidebar and not on toggle button
      if (sidebar && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
        body.classList.remove('g-sidenav-show');
        body.classList.add('g-sidenav-hidden');
        btn.setAttribute('data-tooltip', 'Buka Menu');
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
      
      if (isNowMobile) {
        // Switch to mobile mode
        if (!body.classList.contains('g-sidenav-hidden')) {
          body.classList.add('g-sidenav-hidden');
          body.classList.remove('g-sidenav-show');
        }
      } else {
        // Switch to desktop mode
        const savedState = localStorage.getItem('sidebarState');
        if (savedState !== 'hidden') {
          body.classList.add('g-sidenav-show');
          body.classList.remove('g-sidenav-hidden');
        }
      }
    }, 250);
  });
});
</script>
