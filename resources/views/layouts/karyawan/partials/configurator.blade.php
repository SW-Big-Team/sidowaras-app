<div class="fixed-plugin">
  <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" aria-label="Pengaturan tampilan">
    <i class="material-symbols-rounded py-2">settings</i>
  </a>
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header pb-0 pt-3 border-0">
      <div class="float-start">
        <h5 class="mt-3 mb-0">Pengaturan Tampilan</h5>
        <p class="text-sm text-muted">Personalisasi sesuai preferensi Anda.</p>
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
      <div>
        <h6 class="mb-0">Tampilan Sidebar</h6>
        <p class="text-sm text-muted">Pilih warna dasar sidebar yang nyaman.</p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-sm btn-outline-secondary" data-class="bg-white" onclick="sidebarType(this)">Default</button>
        <button class="btn btn-sm btn-outline-secondary" data-class="bg-transparent" onclick="sidebarType(this)">Transparan</button>
        <button class="btn btn-sm btn-outline-secondary" data-class="bg-gradient-dark" onclick="sidebarType(this)">Gelap</button>
      </div>
      <p class="text-xs text-muted mt-2">Pengaturan ini hanya berlaku di desktop.</p>

      <div class="mt-4 d-flex align-items-center">
        <div>
          <h6 class="mb-0">Navbar tetap</h6>
          <p class="text-sm text-muted mb-0">Jaga navbar di posisi atas saat scroll.</p>
        </div>
        <div class="form-check form-switch ms-auto">
          <input class="form-check-input" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
        </div>
      </div>

      <div class="mt-3 d-flex align-items-center">
        <div>
          <h6 class="mb-0">Tema redup</h6>
          <p class="text-sm text-muted mb-0">Aktifkan mode gelap yang lembut.</p>
        </div>
        <div class="form-check form-switch ms-auto">
          <input class="form-check-input" type="checkbox" id="dark-version" onclick="darkMode(this)">
        </div>
      </div>

      <hr class="horizontal dark my-sm-4">
      <div class="text-center">
        <p class="text-sm text-muted mb-1">Sidowaras App v1.0</p>
        <p class="text-xs text-muted mb-0">© 2025 SW-Big-Team</p>
      </div>
    </div>
  </div>
</div>
