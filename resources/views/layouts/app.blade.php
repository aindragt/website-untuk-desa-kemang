<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi Desa Kemang, Kecamatan Pangkalan Kuras, Kabupaten Pelalawan, Riau.">
    <title>@yield('title', 'Beranda') — Desa Kemang, Kab. Pelalawan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:ital,wght@0,400;0,500;1,400&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/css/glightbox.min.css">

    @stack('styles')
</head>
<body>

    <nav class="navbar" id="navbar" x-data="{ mobileMenuOpen: false }">
        <div class="container navbar__inner">
            <a href="{{ route('home') }}" class="navbar__brand" data-no-swup>
                {{-- <div class="navbar__logo">DK</div> --}}
                    <div class="logo">
                        @if(file_exists(public_path('logo/logo-pelalawan.png')))
                            <img src="{{ asset('logo/logo-pelalawan.png') }}"
                                width="33" height="33" class="object-contain">
                        @else
                            <div class="kop-logo-teks">KAB.<br>PELA<br>LAWAN</div>
                        @endif
                    </div>
                <div>
                    <div class="navbar__name">Desa Kemang</div>
                    <div class="navbar__sub">Kab. Pelalawan · Riau</div>
                </div>
            </a>

            <button class="navbar__toggle" id="navToggle" aria-label="Menu" @click="mobileMenuOpen = !mobileMenuOpen">
                <span></span><span></span><span></span>
            </button>

            <ul class="navbar__menu" id="navMenu" :class="{ 'open': mobileMenuOpen }" @click.away="mobileMenuOpen = false">
                <li><a href="{{ route('home') }}"         class="{{ request()->routeIs('home')        ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('profil') }}"       class="{{ request()->routeIs('profil')      ? 'active' : '' }}">Profil Desa</a></li>
                <li><a href="{{ route('statistik') }}"    class="{{ request()->routeIs('statistik')   ? 'active' : '' }}">Statistik</a></li>

                <li><a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita.*')    ? 'active' : '' }}">Berita</a></li>
                <li><a href="{{ route('layanan.index') }}" class="{{ request()->routeIs('layanan.*')  ? 'active' : '' }}">Layanan Surat</a></li>
                <li><a href="{{ route('kontak') }}"       class="{{ request()->routeIs('kontak')      ? 'active' : '' }}">Kontak</a></li>
            </ul>
        </div>
    </nav>

    {{-- Swup membungkus konten utama --}}
    <main id="swup" class="transition-fade">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer__motif"></div>
        <div class="container footer__inner">
            <div class="footer__grid">
                <div class="footer__col footer__col--brand">
                    {{-- <div class="footer__logo">DK</div> --}}
                    <div class="logo">
                        @if(file_exists(public_path('logo/logo-pelalawan.png')))
                            <img src="{{ asset('logo/logo-pelalawan.png') }}"
                                width="33" height="33" class="object-contain">
                        @else
                            <div class="kop-logo-teks">KAB.<br>PELA<br>LAWAN</div>
                        @endif
                    </div>
                    <h3 class="footer__desa">Desa Kemang</h3>
                    <p class="footer__alamat">Kecamatan Pangkalan Kuras<br>Kabupaten Pelalawan, Riau</p>
                    <p class="footer__alamat mt-2">
                        📞 +62 822-8575-3837<br>
                        ✉ desakemang.pelalawan@gmail.com
                    </p>
                </div>
                <div class="footer__col">
                    <h4 class="footer__col-title">Navigasi</h4>
                    <ul class="footer__links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('profil') }}">Profil Desa</a></li>
                        <li><a href="{{ route('statistik') }}">Statistik Desa</a></li>

                        <li><a href="{{ route('berita.index') }}">Berita</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer__col">
                    <h4 class="footer__col-title">Lembaga Desa</h4>
                    <ul class="footer__links">
                        <li><span>BPD Desa Kemang</span></li>
                        <li><span>TP. PKK Desa Kemang</span></li>
                        <li><span>Karang Taruna</span></li>
                        <li><span>Kelompok Tani</span></li>
                        <li><span>Lembaga Adat Melayu</span></li>
                    </ul>
                </div>
                <div class="footer__col">
                    <h4 class="footer__col-title">Jam Pelayanan</h4>
                    <ul class="footer__links footer__jam">
                        <li><span>Senin</span><span>08.00 – 15.30</span></li>
                        <li><span>Selasa</span><span>08.00 – 15.30</span></li>
                        <li><span>Rabu</span><span>08.00 – 15.30</span></li>
                        <li><span>Kamis</span><span>08.00 – 15.30</span></li>
                        <li><span>Jumat</span><span>08.00 – 11.30</span></li>
                        <li><span>Sabtu – Minggu</span><span>Tutup</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <p>© {{ date('Y') }} Pemerintah Desa Kemang · Kabupaten Pelalawan, Riau. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    {{-- CDN Libraries --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/js/glightbox.min.js"></script>

    {{-- Swup: page transitions --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swup/4.6.0/Swup.min.js"></script>

    @stack('scripts')
</body>
</html>
