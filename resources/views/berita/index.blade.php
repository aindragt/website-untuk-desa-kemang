@extends('layouts.app')
@section('title', 'Berita Desa')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Informasi Terkini</div>
        <h1>Berita Desa Kemang</h1>
        <p class="page-header__desc">Ikuti perkembangan terbaru kegiatan, pembangunan, dan kehidupan masyarakat Desa Kemang.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <span>Berita</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container">

        {{-- FILTER & CARI --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem">
            <div class="filter-tabs">
                <a href="{{ route('berita.index') }}"
                   class="filter-tab {{ !$kategori || $kategori === 'semua' ? 'active' : '' }}">
                    Semua
                </a>
                @foreach($kategoriList as $key => $label)
                <a href="{{ route('berita.index', ['kategori' => $key]) }}"
                   class="filter-tab {{ $kategori === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <form action="{{ route('berita.index') }}" method="GET" style="display:flex;gap:8px">
                @if($kategori)
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
                @endif
                <input type="text" name="cari" value="{{ $cari }}" class="form-control"
                       placeholder="Cari berita..." style="width:220px;padding:0.5rem 0.875rem">
                <button type="submit" class="btn btn--primary" style="padding:0.5rem 1rem;width:auto">🔍</button>
            </form>
        </div>

        {{-- HASIL --}}
        @if($cari)
        <p style="font-family:var(--font-ui);font-size:0.85rem;color:var(--teks-muted);margin-bottom:1.5rem">
            Menampilkan hasil pencarian untuk: <strong style="color:var(--teks)">"{{ $cari }}"</strong>
            — {{ $berita->total() }} berita ditemukan
        </p>
        @endif

        @if($berita->count() > 0)
        <div class="berita-grid">
            @foreach($berita as $b)
            <article class="berita-card">
                @if($b->foto)
                    <img src="{{ $b->foto_url }}" alt="{{ $b->judul }}" class="berita-card__thumb" loading="lazy">
                @else
                    <div class="berita-card__thumb--placeholder">
                        @php
                            $ikon = ['umum'=>'📰','pembangunan'=>'🏗️','sosial'=>'🤝','budaya'=>'🎭','kesehatan'=>'🏥','pendidikan'=>'📚'];
                        @endphp
                        {{ $ikon[$b->kategori] ?? '📰' }}
                    </div>
                @endif
                <div class="berita-card__body">
                    <div class="berita-card__meta">
                        <span class="berita-card__kategori">{{ $kategoriList[$b->kategori] ?? $b->kategori }}</span>
                        <span class="berita-card__tanggal">{{ $b->tanggal_format }}</span>
                    </div>
                    <h3 class="berita-card__judul">{{ $b->judul }}</h3>
                    <p class="berita-card__ringkasan">{{ $b->ringkasan_auto }}</p>
                    <a href="{{ route('berita.show', $b->slug) }}" class="berita-card__link">Baca selengkapnya →</a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($berita->hasPages())
        <div class="pagination">
            @if($berita->onFirstPage())
                <span class="page-item disabled"><span class="page-link">‹</span></span>
            @else
                <a class="page-link" href="{{ $berita->previousPageUrl() }}">‹</a>
            @endif

            @foreach($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                @if($page == $berita->currentPage())
                    <span class="page-item active"><span class="page-link">{{ $page }}</span></span>
                @else
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($berita->hasMorePages())
                <a class="page-link" href="{{ $berita->nextPageUrl() }}">›</a>
            @else
                <span class="page-item disabled"><span class="page-link">›</span></span>
            @endif
        </div>
        @endif

        @else
        <div style="text-align:center;padding:4rem 0">
            <div style="font-size:3rem;margin-bottom:1rem">📭</div>
            <h3 style="font-family:var(--font-display);color:var(--teks-2);margin-bottom:0.5rem">Berita tidak ditemukan</h3>
            <p style="font-family:var(--font-ui);font-size:0.875rem;color:var(--teks-muted)">
                Coba ubah kata kunci pencarian atau pilih kategori lain.
            </p>
            <a href="{{ route('berita.index') }}" style="display:inline-block;margin-top:1rem;font-family:var(--font-ui);font-size:0.82rem;color:var(--emas)">Lihat semua berita →</a>
        </div>
        @endif

    </div>
</section>

@endsection
