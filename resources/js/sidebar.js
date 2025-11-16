/**
 * Sidebar Navigation Scripts
 * Handles sidebar interactions and state management
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
});

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    handleSidebarToggle();
    handleActiveState();
    handleKeyboardNavigation();
    handleResponsiveBehavior();
}

/**
 * Handle sidebar toggle functionality
 */
function handleSidebarToggle() {
    const iconSidenav = document.getElementById('iconSidenav');
    const sidenav = document.getElementById('sidenav-main');
    
    if (iconSidenav && sidenav) {
        iconSidenav.addEventListener('click', toggleSidebar);
        iconSidenav.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleSidebar();
            }
        });
    }
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidenav = document.getElementById('sidenav-main');
    if (sidenav) {
        sidenav.classList.toggle('show');
        
        // Update aria-expanded attribute for accessibility
        const isExpanded = sidenav.classList.contains('show');
        document.getElementById('iconSidenav')?.setAttribute('aria-expanded', isExpanded);
    }
}

/**
 * Handle active state management
 */
function handleActiveState() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links except logout
            if (!this.classList.contains('text-danger')) {
                navLinks.forEach(l => {
                    if (!l.classList.contains('text-danger')) {
                        l.classList.remove('active', 'bg-gradient-primary', 'text-white');
                        l.classList.add('text-dark');
                        l.setAttribute('aria-current', 'false');
                    }
                });
                
                // Add active class to clicked link
                this.classList.add('active', 'bg-gradient-primary', 'text-white');
                this.classList.remove('text-dark');
                this.setAttribute('aria-current', 'page');
            }
        });
    });
}

/**
 * Handle keyboard navigation for accessibility
 */
function handleKeyboardNavigation() {
    const navItems = document.querySelectorAll('.navbar-nav .nav-link');
    
    navItems.forEach((item, index) => {
        item.addEventListener('keydown', function(e) {
            let targetIndex;
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    targetIndex = index + 1;
                    if (targetIndex < navItems.length) {
                        navItems[targetIndex].focus();
                    }
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    targetIndex = index - 1;
                    if (targetIndex >= 0) {
                        navItems[targetIndex].focus();
                    }
                    break;
                    
                case 'Home':
                    e.preventDefault();
                    navItems[0].focus();
                    break;
                    
                case 'End':
                    e.preventDefault();
                    navItems[navItems.length - 1].focus();
                    break;
            }
        });
    });
}

/**
 * Handle responsive behavior
 */
function handleResponsiveBehavior() {
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidenav = document.getElementById('sidenav-main');
        const iconSidenav = document.getElementById('iconSidenav');
        
        if (window.innerWidth < 1200) {
            if (sidenav && !sidenav.contains(e.target) && e.target !== iconSidenav) {
                sidenav.classList.remove('show');
            }
        }
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const sidenav = document.getElementById('sidenav-main');
            if (window.innerWidth >= 1200) {
                sidenav?.classList.remove('show');
            }
        }, 250);
    });
}

/**
 * Smooth scroll for sidebar navigation
 */
function smoothScrollSidebar() {
    const sidebarScroll = document.getElementById('sidenav-scrollbar');
    if (sidebarScroll) {
        sidebarScroll.style.scrollBehavior = 'smooth';
    }
}

// Initialize smooth scroll
smoothScrollSidebar();
