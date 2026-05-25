<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin Desa Kemang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body>

<div class="admin-layout">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="admin-sidebar" id="adminSidebar">

        {{-- Brand --}}
        <div class="admin-sidebar__brand">
            <div class="admin-sidebar__logo">DK</div>
            <div>
                <div class="admin-sidebar__title">Desa Kemang</div>
                <div class="admin-sidebar__sub">Panel Administrasi</div>
            </div>
        </div>
        <div class="admin-sidebar__motif"></div>

        {{-- Navigasi --}}
        <nav class="admin-nav">
            <div class="admin-nav__section">Utama</div>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="admin-nav__icon">🏠</span> Dashboard
            </a>

            <div class="admin-nav__section">Konten</div>
            <a href="{{ route('admin.berita.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📰</span> Berita
                @php $jmlBerita = \App\Models\Berita::count(); @endphp
                @if($jmlBerita > 0)
                <span style="margin-left:auto;background:rgba(200,149,42,0.15);color:#7a5c10;font-size:0.62rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $jmlBerita }}</span>
                @endif
            </a>


            <div class="admin-nav__section">Data Desa</div>
            <a href="{{ route('admin.statistik.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📊</span> Statistik
            </a>

            <div class="admin-nav__section">Layanan</div>
            <a href="{{ route('admin.layanan.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📝</span> Pengajuan Surat
                @php $suratMenungguValidasi = \App\Models\PengajuanSurat::where('status','menunggu_validasi_kades')->count(); @endphp
                @if($suratMenungguValidasi > 0)
                <span style="margin-left:auto;background:rgba(200,149,42,0.15);color:#7a5c10;font-size:0.62rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $suratMenungguValidasi }}</span>
                @endif
            </a>

            <div class="admin-nav__section">Komunikasi</div>
            <a href="{{ route('admin.pesan.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">✉️</span> Pesan Masuk
                @php $pesanBaru = \App\Models\PesanKontak::where('is_read', false)->count(); @endphp
                @if($pesanBaru > 0)
                <span style="margin-left:auto;background:rgba(220,53,69,0.12);color:#b91c1c;font-size:0.62rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $pesanBaru }}</span>
                @endif
            </a>

            <div class="admin-nav__section">Pengaturan</div>
            <a href="{{ route('admin.operator.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.operator.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">👥</span> Kelola Operator
            </a>
        </nav>

        {{-- Info user & logout --}}
        <div style="padding:0.75rem 1.25rem;background:rgba(200,149,42,0.06);border-top:1px solid rgba(200,149,42,0.15)">
            <div style="font-family:var(--font-ui);font-size:0.68rem;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:3px">Login sebagai</div>
            <div style="font-family:var(--font-ui);font-size:0.82rem;color:var(--emas);font-weight:500">{{ Auth::check() ? Auth::user()->nama : 'Administrator' }}</div>
            <div style="font-family:var(--font-ui);font-size:0.68rem;color:rgba(255,255,255,0.3)">Administrator</div>
        </div>

        <div class="admin-sidebar__footer">
            <a href="{{ route('home') }}" target="_blank"
               style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.4);margin-bottom:0.75rem;text-decoration:none;transition:color 0.2s"
               onmouseover="this.style.color='var(--emas)'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                <span>🌐</span> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.4);background:none;border:none;cursor:pointer;padding:0;font-family:var(--font-ui);transition:color 0.2s;width:100%"
                        onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="admin-main">

        {{-- Topbar --}}
        <div class="admin-topbar">
            <div style="display:flex;align-items:center;gap:0.75rem">
                {{-- Tombol toggle sidebar (mobile) --}}
                <button id="sidebarToggle"
                        style="display:none;background:none;border:none;cursor:pointer;padding:4px;flex-direction:column;gap:4px"
                        onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                    <span style="display:block;width:20px;height:2px;background:var(--teks)"></span>
                    <span style="display:block;width:20px;height:2px;background:var(--teks)"></span>
                    <span style="display:block;width:20px;height:2px;background:var(--teks)"></span>
                </button>
                <div class="admin-topbar__title">@yield('page-title', 'Dashboard')</div>
            </div>
            <div class="admin-topbar__user">
                <span class="role-badge-admin">Admin</span>
                <div class="admin-topbar__avatar">
                    {{ strtoupper(substr(Auth::check() ? Auth::user()->nama : 'A', 0, 1)) }}
                </div>
                <span style="font-size:0.82rem;color:var(--teks-2)">{{ Auth::check() ? Auth::user()->nama : 'Administrator' }}</span>
            </div>
        </div>

        {{-- Flash messages --}}
        <div style="padding:0 1.75rem">
            @if(session('success'))
            <div class="alert alert--success" style="margin-top:1.25rem">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert--error" style="margin-top:1.25rem">❌ {{ session('error') }}</div>
            @endif
        </div>

        <div class="admin-content">
            @yield('content')
        </div>
    </div>

</div>

@stack('scripts')
<script>
    // Tampilkan tombol toggle sidebar di mobile
    if (window.innerWidth <= 768) {
        document.getElementById('sidebarToggle').style.display = 'flex';
    }
</script>
</body>
</html>
