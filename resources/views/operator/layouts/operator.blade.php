<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Operator Desa Kemang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body>

<div class="admin-layout">

    {{-- ===== SIDEBAR OPERATOR ===== --}}
    <aside class="admin-sidebar" id="operatorSidebar">

        {{-- Brand --}}
        <div class="admin-sidebar__brand">
            <div class="admin-sidebar__logo" style="background:var(--hijau-muda);color:#fff">DK</div>
            <div>
                <div class="admin-sidebar__title">Desa Kemang</div>
                <div class="admin-sidebar__sub" style="color:rgba(200,149,42,0.7)">Operator Desa</div>
            </div>
        </div>
        <div class="admin-sidebar__motif"></div>

        {{-- Navigasi --}}
        <nav class="admin-nav">
            <div class="admin-nav__section">Utama</div>
            <a href="{{ route('operator.dashboard') }}"
               class="admin-nav__link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                <span class="admin-nav__icon">🏠</span> Dashboard
            </a>

            <div class="admin-nav__section">Konten</div>
            <a href="{{ route('operator.berita.index') }}"
               class="admin-nav__link {{ request()->routeIs('operator.berita.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📰</span> Berita
            </a>

            <div class="admin-nav__section">Data Desa</div>
            <a href="{{ route('operator.statistik.index') }}"
               class="admin-nav__link {{ request()->routeIs('operator.statistik.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📊</span> Statistik
            </a>


            <div class="admin-nav__section">Layanan</div>
            <a href="{{ route('operator.layanan.index') }}"
               class="admin-nav__link {{ request()->routeIs('operator.layanan.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">📝</span> Pengajuan Surat
                @php $menunggu = \App\Models\PengajuanSurat::where('status','menunggu')->count(); @endphp
                @if($menunggu > 0)
                <span style="margin-left:auto;background:rgba(200,149,42,0.15);color:#7a5c10;font-size:0.62rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $menunggu }}</span>
                @endif
            </a>

            <div class="admin-nav__section">Komunikasi</div>
            <a href="{{ route('operator.pesan.index') }}"
               class="admin-nav__link {{ request()->routeIs('operator.pesan.*') ? 'active' : '' }}">
                <span class="admin-nav__icon">✉️</span> Pesan Masuk
                @php $pesanBaru = \App\Models\PesanKontak::where('is_read', false)->count(); @endphp
                @if($pesanBaru > 0)
                <span style="margin-left:auto;background:rgba(220,53,69,0.12);color:#b91c1c;font-size:0.62rem;padding:1px 7px;border-radius:999px;font-weight:600">{{ $pesanBaru }}</span>
                @endif
            </a>
        </nav>

        {{-- Info user --}}
        <div style="padding:0.75rem 1.25rem;background:rgba(200,149,42,0.06);border-top:1px solid rgba(200,149,42,0.15)">
            <div style="font-family:var(--font-ui);font-size:0.68rem;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:3px">Login sebagai</div>
            <div style="font-family:var(--font-ui);font-size:0.82rem;color:var(--emas);font-weight:500">{{ Auth::check() ? Auth::user()->nama : 'Operator' }}</div>
            <div style="font-family:var(--font-ui);font-size:0.68rem;color:rgba(255,255,255,0.3)">Operator Desa</div>
        </div>

        <div class="admin-sidebar__footer">
            <a href="{{ route('home') }}" target="_blank"
               style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.4);margin-bottom:0.75rem;text-decoration:none"
               onmouseover="this.style.color='var(--emas)'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                <span>🌐</span> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.4);background:none;border:none;cursor:pointer;padding:0;font-family:var(--font-ui)"
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
            <div class="admin-topbar__title">@yield('page-title', 'Dashboard')</div>
            <div class="admin-topbar__user">
                <span class="role-badge-operator">Operator</span>
                <div class="admin-topbar__avatar" style="background:var(--hijau-muda)">
                    {{ strtoupper(substr(Auth::check() ? Auth::user()->nama : 'O', 0, 1)) }}
                </div>
                <span>{{ Auth::check() ? Auth::user()->nama : 'Operator' }}</span>
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
</body>
</html>
