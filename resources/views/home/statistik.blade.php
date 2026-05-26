@extends('layouts.app')
@section('title', 'Statistik Desa')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Data & Angka</div>
        <h1>Statistik Desa Kemang</h1>
        <p class="page-header__desc">Data kependudukan, pekerjaan, pendidikan, dan agama warga Desa Kemang.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <span>Statistik</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container">

        {{-- KARTU RINGKASAN --}}
        <div class="stat-cards" style="margin-bottom:3rem">
            @php
                $totalPenduduk = $penduduk->where('label','Total Penduduk')->first()?->nilai ?? 0;
                $jmlKk         = $penduduk->where('label','Kepala Keluarga')->first()?->nilai ?? 0;
                $lakiLaki      = $penduduk->where('label','Penduduk Laki-laki')->first()?->nilai ?? 0;
                $perempuan     = $penduduk->where('label','Penduduk Perempuan')->first()?->nilai ?? 0;
            @endphp
            <div class="stat-card stat-card--hijau">
                <div class="stat-card__num" data-counter="{{ $totalPenduduk }}">{{ number_format($totalPenduduk,0,',','.') }}</div>
                <div class="stat-card__lbl">Total Penduduk</div>
            </div>
            <div class="stat-card stat-card--coklat">
                <div class="stat-card__num" data-counter="{{ $jmlKk }}">{{ number_format($jmlKk,0,',','.') }}</div>
                <div class="stat-card__lbl">Kepala Keluarga</div>
            </div>
            <div class="stat-card stat-card--hijau">
                <div class="stat-card__num" data-counter="{{ $lakiLaki }}">{{ number_format($lakiLaki,0,',','.') }}</div>
                <div class="stat-card__lbl">Laki-laki</div>
            </div>
            <div class="stat-card stat-card--coklat">
                <div class="stat-card__num" data-counter="{{ $perempuan }}">{{ number_format($perempuan,0,',','.') }}</div>
                <div class="stat-card__lbl">Perempuan</div>
            </div>
        </div>

        {{-- GRID CHART --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem">

            {{-- Mata Pencaharian --}}
            <div class="chart-box">
                <div class="chart-box__title">Mata Pencaharian</div>
                @php $totalPekerjaan = $pekerjaan->sum('nilai'); @endphp
                @foreach($pekerjaan as $item)
                @php $pct = $totalPekerjaan > 0 ? round($item->nilai / $totalPekerjaan * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <span class="bar-row__label">{{ $item->label }}</span>
                    <div class="bar-row__track">
                        <div class="bar-row__fill" style="background:var(--hijau)" data-width="{{ $pct }}"></div>
                    </div>
                    <span class="bar-row__val">{{ $pct }}%</span>
                </div>
                @endforeach
            </div>

            {{-- Pendidikan --}}
            <div class="chart-box">
                <div class="chart-box__title">Tingkat Pendidikan</div>
                @php $totalPendidikan = $pendidikan->sum('nilai'); @endphp
                @foreach($pendidikan as $item)
                @php $pct = $totalPendidikan > 0 ? round($item->nilai / $totalPendidikan * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <span class="bar-row__label">{{ $item->label }}</span>
                    <div class="bar-row__track">
                        <div class="bar-row__fill" style="background:var(--coklat)" data-width="{{ $pct }}"></div>
                    </div>
                    <span class="bar-row__val">{{ $pct }}%</span>
                </div>
                @endforeach
            </div>

            {{-- Agama --}}
            <div class="chart-box">
                <div class="chart-box__title">Agama</div>
                @php
                    $totalAgama = $agama->sum('nilai');
                    $warna = ['var(--hijau)','var(--coklat)','var(--emas)','var(--hijau-muda)','#888'];
                @endphp
                @foreach($agama as $i => $item)
                @php $pct = $totalAgama > 0 ? round($item->nilai / $totalAgama * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <span class="bar-row__label">{{ $item->label }}</span>
                    <div class="bar-row__track">
                        <div class="bar-row__fill" style="background:{{ $warna[$i % count($warna)] }}" data-width="{{ $pct }}"></div>
                    </div>
                    <span class="bar-row__val">{{ $pct }}%</span>
                </div>
                @endforeach
            </div>

            {{-- Ringkasan Angka --}}
            <div class="chart-box" style="background:var(--hijau)">
                <div class="chart-box__title" style="color:var(--emas)">Ringkasan Data Desa</div>
                @foreach ([
                    ['Luas Wilayah',   '±10.337 Ha'],
                    ['Jumlah Dusun',   '3 Dusun'],
                    ['Jumlah RT/RW',   '12 RT / 4 RW'],
                    ['Jarak ke Kec.',  '±13.5 Km'],
                    ['Jarak ke Kab.',  '±35 Km'],
                ] as $info)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.6rem 0;border-bottom:1px solid rgba(255,255,255,0.1)">
                    <span style="font-family:var(--font-ui);font-size:0.82rem;color:rgba(255,255,255,0.6)">{{ $info[0] }}</span>
                    <span style="font-family:var(--font-ui);font-size:0.85rem;font-weight:600;color:#fff">{{ $info[1] }}</span>
                </div>
                @endforeach
            </div>

        </div>

        <p style="font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted);margin-top:1.5rem;font-style:italic">
            * Data statistik bersumber dari profil desa tahun terakhir. Pembaruan dilakukan secara berkala.
        </p>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Counter animation untuk stat cards
    const counters = document.querySelectorAll('[data-counter]');
    
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-counter'));
        const duration = 2000; // 2 seconds
        const start = Date.now();
        
        const update = () => {
            const elapsed = Date.now() - start;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(target * progress);
            
            element.textContent = new Intl.NumberFormat('id-ID').format(current);
            
            if (progress < 1) {
                requestAnimationFrame(update);
            }
        };
        
        update();
    };
    
    // Trigger counter animation when element is visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    counters.forEach(counter => observer.observe(counter));
    
    // Animate bar charts dengan delay
    const bars = document.querySelectorAll('.bar-row__fill');
    
    bars.forEach((bar, index) => {
        const width = bar.getAttribute('data-width');
        setTimeout(() => {
            bar.style.width = width + '%';
        }, index * 100);
    });
});
</script>
@endpush
