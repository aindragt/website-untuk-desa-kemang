<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin Desa Kemang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

<div class="admin-layout">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand">
            <div class="admin-sidebar__logo">DK</div>
            <div>
                <div class="admin-sidebar__title">Desa Kemang</div>
                <div class="admin-sidebar__sub">Panel Administrasi</div>
            </div>
        </div>

        <nav class="admin-nav">
            <div class="admin-nav__section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="admin-nav__icon">🏠</span> Dashboard
            </a>

            <div class="admin-nav__section">Konten</div>
            <a href="{{ route('admin.berita.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📰</span> Berita
                @php $totalBerita = \App\Models\Berita::count(); @endphp
                @if($totalBerita > 0)
                <span style="margin-left:auto;background:rgba(200,149,42,0.15);color:#8a6010;font-size:0.65rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $totalBerita }}</span>
                @endif
            </a>
            <a href="{{ route('admin.galeri.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">🖼️</span> Galeri Foto
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
                @php $suratBaru = \App\Models\PengajuanSurat::where('status','menunggu')->count(); @endphp
                @if($suratBaru > 0)
                <span style="margin-left:auto;background:rgba(200,149,42,0.15);color:#8a6010;font-size:0.65rem;padding:1px 7px;border-radius:999px;font-weight:600">
                    {{ $suratBaru }}
                </span>
                @endif
            </a>

            <div class="admin-nav__section">Komunikasi</div>
            <a href="{{ route('admin.pesan.index') }}"
               class="admin-nav__link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">✉️</span> Pesan Masuk
                @php $pesanBaru = \App\Models\PesanKontak::where('is_read', false)->count(); @endphp
                @if($pesanBaru > 0)
                <span style="margin-left:auto;background:rgba(220,53,69,0.15);color:#b91c1c;font-size:0.65rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $pesanBaru }}</span>
                @endif
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <a href="{{ route('home') }}" target="_blank"
               style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.4);margin-bottom:0.75rem;transition:color 0.2s">
                <span>🌐</span> Lihat Website
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                        style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.4);background:none;border:none;cursor:pointer;padding:0;font-family:var(--font-ui);transition:color 0.2s"
                        onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="admin-main">
        <div class="admin-topbar">
            <div class="admin-topbar__title">@yield('page-title', 'Dashboard')</div>
            <div class="admin-topbar__user">
                <div class="admin-topbar__avatar">{{ strtoupper(substr(session('admin_username', 'A'), 0, 1)) }}</div>
                <span>{{ session('admin_username', 'Admin') }}</span>
            </div>
        </div>

        <div class="admin-content">

            {{-- Flash messages --}}
            @if(session('success'))
            <div class="alert alert--success" style="margin-bottom:1.25rem">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert--error" style="margin-bottom:1.25rem">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}" data-no-swup></script>
@stack('scripts')
</body>
</html>
