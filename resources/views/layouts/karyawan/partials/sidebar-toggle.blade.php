<style>
    .sidebar-toggle-plugin {
        position: fixed;
        bottom: 24px;
        right: 24px;
        /* Max Safe Integer for Z-Index to ensure it's above all overlays/modals */
        z-index: 2147483647; 
        /* Ensures the element accepts clicks even if a parent has pointer-events: none */
        pointer-events: auto; 
    }

    .sidebar-toggle-button {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.18);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        transition: all 0.2s ease-in-out;
        /* specific text settings to prevent icon misalignment */
        text-decoration: none;
        user-select: none; 
        -webkit-tap-highlight-color: transparent; /* Removes mobile tap blue box */
    }

    .sidebar-toggle-button:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    }

    .sidebar-toggle-button i {
        font-size: 28px;
        color: #333;
    }
</style>
<div class="sidebar-toggle-plugin">
    <a class="sidebar-toggle-button" onclick="toggleSidebar()" id="sidebarToggleBtn">
        <i class="material-symbols-rounded">menu</i>
    </a>
</div>

