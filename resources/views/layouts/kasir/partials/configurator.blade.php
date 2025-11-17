<div class="fixed-plugin">
  <button 
    type="button"
    class="fixed-plugin-button"
    data-tooltip="Pengaturan Tampilan"
    aria-label="Toggle Configurator"
  >
    <i class="material-symbols-rounded">settings</i>
  </button>
  <div class="card shadow-lg">
    <div class="card-header pb-0 pt-3">
      <div class="float-start">
        <h5 class="mt-3 mb-0">Pengaturan Tampilan</h5>
        <p>Sesuaikan tampilan dashboard Anda.</p>
      </div>
      <div class="float-end mt-4">
        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
          <i class="material-symbols-rounded">clear</i>
        </button>
      </div>
      <!-- End Toggle Button -->
    </div>
    <hr class="horizontal dark my-1">
    <div class="card-body pt-sm-3 pt-0">
      <!-- Sidebar Backgrounds -->
      <div>
        <h6 class="mb-0">Warna Sidebar</h6>
      </div>
      <a href="javascript:void(0)" class="switch-trigger background-color">
        <div class="badge-colors my-2 text-start">
          <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
        </div>
      </a>
      <!-- Sidenav Type -->
      <div class="mt-3">
        <h6 class="mb-0">Tipe Sidebar</h6>
        <p class="text-sm">Pilih tipe sidebar yang Anda inginkan.</p>
      </div>
      <div class="d-flex">
        <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Gelap</button>
        <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparan</button>
        <button class="btn bg-gradient-dark px-3 mb-2 active ms-2" data-class="bg-white" onclick="sidebarType(this)">Putih</button>
      </div>
      <p class="text-sm d-xl-none d-block mt-2">Anda dapat mengubah tipe sidebar hanya pada tampilan desktop.</p>
      <!-- Navbar Fixed -->
      <div class="mt-3 d-flex">
        <h6 class="mb-0">Navbar Tetap</h6>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
          <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
        </div>
      </div>
      <hr class="horizontal dark my-3">
      <div class="mt-2 d-flex">
        <h6 class="mb-0">Terang / Gelap</h6>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
          <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
        </div>
      </div>
      <hr class="horizontal dark my-sm-4">
      <div class="text-center">
        <p class="text-sm text-muted mb-2">Sidowaras App v1.0</p>
        <p class="text-xs text-muted">© 2025 SW-Big-Team</p>
      </div>
    </div>
  </div>
</div>

<style>
/* Configurator Button - Matching Sidebar Toggle Style */
.fixed-plugin {
  position: fixed;
  right: 20px;
  bottom: 90px;
  z-index: 1000;
}

.fixed-plugin-button {
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

.fixed-plugin-button:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.24);
}

.fixed-plugin-button:active {
  transform: scale(0.95);
}

.fixed-plugin-button i {
  font-size: 24px;
  color: #344767;
  transition: transform 0.3s ease;
}

/* Rotate icon when configurator is open */
.show-fixed-plugin .fixed-plugin-button i {
  transform: rotate(180deg);
}

/* Tooltip */
.fixed-plugin-button::before {
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

.fixed-plugin-button:hover::before {
  opacity: 1;
}

/* Tooltip arrow */
.fixed-plugin-button::after {
  content: '';
  position: absolute;
  right: 60px;
  border: 6px solid transparent;
  border-left-color: rgba(0, 0, 0, 0.8);
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}

.fixed-plugin-button:hover::after {
  opacity: 1;
}

/* Configurator Panel */
.fixed-plugin .card {
  position: fixed;
  right: -360px;
  top: 0;
  width: 360px;
  height: 100vh;
  border-radius: 0;
  transition: all 0.3s cubic-bezier(0.34, 1.61, 0.7, 1);
}

.show-fixed-plugin .fixed-plugin .card {
  right: 0;
}

/* Mobile adjustments */
@media (max-width: 768px) {
  .fixed-plugin-button::before,
  .fixed-plugin-button::after {
    display: none;
  }
  
  .fixed-plugin {
    bottom: 80px;
    right: 16px;
  }
  
  .fixed-plugin .card {
    width: 100%;
    right: -100%;
  }
}

/* Extra small screens */
@media (max-width: 575px) {
  .fixed-plugin {
    bottom: 70px;
    right: 16px;
  }
  
  .fixed-plugin-button {
    width: 48px;
    height: 48px;
  }
  
  .fixed-plugin-button i {
    font-size: 20px;
  }
}
</style>
