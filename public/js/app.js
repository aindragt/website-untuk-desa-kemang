// ============================================================
// DESA KEMANG — Main JavaScript (v2 + Page Transitions)
// ============================================================

// --- Swup page transition init ---
// Swup di-load via CDN di layout, kita inisialisasi di sini
function initSwup() {
    if (typeof Swup === 'undefined') return;

    const swup = new Swup({
        containers: ['#swup'],
        animationSelector: '[class*="transition-"]',
        linkSelector: 'a[href]:not([data-no-swup]):not([href^="#"]):not([href^="mailto"]):not([href^="tel"]):not([href^="http"]):not([href^="https"]):not([target="_blank"])',
    });

    // Re-init semua fungsi setiap kali halaman berganti
    swup.hooks.on('page:view', function () {
        initPageFunctions();
    });
}

// --- Semua fungsi yang perlu di-init ulang saat halaman berganti ---
function initPageFunctions() {

    // Navbar: tambah class scrolled saat scroll
    const navbar = document.getElementById('navbar');
    if (navbar) {
        // Set state awal
        navbar.classList.toggle('scrolled', window.scrollY > 20);
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });
    }

    // Navbar: tandai link aktif berdasarkan URL saat ini
    const currentPath = window.location.pathname;
    document.querySelectorAll('.navbar__menu a').forEach(function (link) {
        link.classList.remove('active');
        const linkPath = new URL(link.href, window.location.origin).pathname;
        if (
            linkPath === currentPath ||
            (currentPath.startsWith(linkPath) && linkPath !== '/')
        ) {
            link.classList.add('active');
        }
    });

    // Navbar: mobile toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu   = document.getElementById('navMenu');
    if (navToggle && navMenu) {
        // Clone untuk hapus event listener lama
        const newToggle = navToggle.cloneNode(true);
        navToggle.parentNode.replaceChild(newToggle, navToggle);
        newToggle.addEventListener('click', function () {
            navMenu.classList.toggle('open');
        });
        // Tutup menu saat link diklik (mobile)
        navMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navMenu.classList.remove('open');
            });
        });
    }

    // GLightbox — galeri
    if (typeof GLightbox !== 'undefined') {
        const lightboxElements = document.querySelectorAll('.glightbox');
        if (lightboxElements.length > 0) {
            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
            });
        }
    }

    // Animasi bar chart statistik
    const barFills = document.querySelectorAll('.bar-row__fill[data-width]');
    if (barFills.length > 0) {
        const barObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.width = entry.target.getAttribute('data-width') + '%';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        barFills.forEach(function (el) {
            el.style.width = '0%';
            barObserver.observe(el);
        });
    }

    // Counter animasi hero stats
    document.querySelectorAll('[data-counter]').forEach(function (el) {
        const target   = parseInt(el.getAttribute('data-counter'), 10);
        const duration = 1500;
        const step     = target / (duration / 16);
        let current    = 0;
        const timer = setInterval(function () {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = Math.floor(current).toLocaleString('id-ID');
        }, 16);
    });

    // Profil Tabs
    const profilTabs   = document.querySelectorAll('.profil-tab[data-target]');
    const profilPanels = document.querySelectorAll('.profil-panel');
    if (profilTabs.length > 0) {
        profilPanels.forEach(p => p.style.display = 'none');
        if (profilPanels[0]) profilPanels[0].style.display = 'block';
        if (profilTabs[0]) profilTabs[0].classList.add('active');

        profilTabs.forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                profilTabs.forEach(t => t.classList.remove('active'));
                profilPanels.forEach(p => p.style.display = 'none');
                tab.classList.add('active');
                const target = document.getElementById(tab.getAttribute('data-target'));
                if (target) target.style.display = 'block';
            });
        });
    }

    // Flash message auto-hide
    document.querySelectorAll('.alert').forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity    = '0';
            setTimeout(function () { alert.remove(); }, 500);
        }, 5000);
    });
}

// --- Jalankan saat DOM siap ---
document.addEventListener('DOMContentLoaded', function () {
    initSwup();
    initPageFunctions();
});
