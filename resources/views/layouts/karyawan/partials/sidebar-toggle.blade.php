{{-- Sidebar Toggle Button (Mobile & Desktop) --}}
<style>
    .sidebar-toggle-plugin {
        position: fixed;
        bottom: 24px;    /* bottom right */
        right: 24px;
        z-index: 9999;   /* make sure it's above everything */
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
