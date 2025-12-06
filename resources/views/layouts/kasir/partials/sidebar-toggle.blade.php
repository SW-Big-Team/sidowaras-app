{{-- Modern Sidebar Toggle Button --}}
<div class="sidebar-toggle-wrapper">
    <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" data-tooltip="Tutup Sidebar" onclick="toggleSidebar()">
        <i class="material-symbols-rounded">menu</i>
        <span class="toggle-ring"></span>
    </button>
</div>

<style>
.sidebar-toggle-wrapper { position: fixed; right: 20px; bottom: 20px; z-index: 2050; }
.sidebar-toggle-btn { width: 52px; height: 52px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; border-radius: 14px; box-shadow: 0 4px 16px rgba(59,130,246,0.4); cursor: pointer; transition: all 0.3s cubic-bezier(0.34, 1.61, 0.7, 1); border: none; padding: 0; position: relative; overflow: hidden; }
.sidebar-toggle-btn i { font-size: 24px; color: white; transition: transform 0.3s ease; z-index: 2; }
.toggle-ring { position: absolute; width: 100%; height: 100%; border-radius: 14px; border: 2px solid rgba(255,255,255,0.3); animation: pulse-ring 2s ease-out infinite; }
@keyframes pulse-ring { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; } }
.sidebar-toggle-btn:hover { transform: scale(1.1); box-shadow: 0 6px 24px rgba(59,130,246,0.5); }
.sidebar-toggle-btn:active { transform: scale(0.95); }
.g-sidenav-hidden .sidebar-toggle-btn i { transform: rotate(180deg); }

/* Modern Tooltip */
.sidebar-toggle-btn::before { content: attr(data-tooltip); position: absolute; right: 64px; background: #1e293b; color: white; padding: 8px 14px; border-radius: 10px; font-size: 0.8rem; white-space: nowrap; opacity: 0; pointer-events: none; transition: opacity 0.3s ease, transform 0.3s ease; font-weight: 500; transform: translateX(10px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.sidebar-toggle-btn:hover::before { opacity: 1; transform: translateX(0); }
.sidebar-toggle-btn::after { content: ''; position: absolute; right: 56px; border: 6px solid transparent; border-left-color: #1e293b; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
.sidebar-toggle-btn:hover::after { opacity: 1; }

@media (max-width: 768px) { .sidebar-toggle-btn::before, .sidebar-toggle-btn::after { display: none; } .sidebar-toggle-wrapper { bottom: 16px; right: 16px; } .sidebar-toggle-btn { width: 48px; height: 48px; border-radius: 12px; } .sidebar-toggle-btn i { font-size: 22px; } }
@media (max-width: 575px) { .sidebar-toggle-btn { width: 44px; height: 44px; } .sidebar-toggle-btn i { font-size: 20px; } }
</style>

<script>
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
