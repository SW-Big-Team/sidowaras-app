<footer class="footer-modern">
    <div class="container-fluid">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="brand-icon">
                    <i class="material-symbols-rounded">local_pharmacy</i>
                </div>
                <div class="brand-text">
                    <span class="brand-name">Sidowaras App</span>
                    <span class="brand-tagline">Sistem Manajemen Apotek Modern</span>
                </div>
            </div>
            <div class="footer-copyright">
                © <script>document.write(new Date().getFullYear())</script> dikembangkan oleh
                <a href="#" class="team-link">SW-Big-Team</a>
            </div>
            <div class="footer-links">
                <a href="#" class="footer-link"><i class="material-symbols-rounded">info</i> Tentang</a>
                <a href="#" class="footer-link"><i class="material-symbols-rounded">description</i> Dokumentasi</a>
                <a href="#" class="footer-link"><i class="material-symbols-rounded">verified_user</i> Lisensi</a>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-modern { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-top: 1px solid #e2e8f0; padding: 1.25rem 0; margin-top: auto; }
.footer-inner { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.footer-brand { display: flex; align-items: center; gap: 10px; }
.brand-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.brand-icon i { color: white; font-size: 18px; }
.brand-text { display: flex; flex-direction: column; }
.brand-name { font-weight: 700; font-size: 0.85rem; color: #1e293b; }
.brand-tagline { font-size: 0.7rem; color: #64748b; }
.footer-copyright { font-size: 0.8rem; color: #64748b; }
.team-link { color: #3b82f6; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.team-link:hover { color: #1d4ed8; }
.footer-links { display: flex; gap: 16px; }
.footer-link { display: inline-flex; align-items: center; gap: 4px; font-size: 0.8rem; color: #64748b; text-decoration: none; transition: all 0.2s; }
.footer-link i { font-size: 16px; }
.footer-link:hover { color: #3b82f6; }
@media (max-width: 768px) { .footer-inner { flex-direction: column; text-align: center; } .footer-links { justify-content: center; } }
</style>
