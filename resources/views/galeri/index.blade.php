@extends('layouts.app')
@section('title', 'Galeri Foto')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Foto & Dokumentasi</div>
        <h1>Galeri Desa Kemang</h1>
        <p class="page-header__desc">Dokumentasi kegiatan, infrastruktur, budaya, dan keindahan alam Desa Kemang.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <span>Galeri</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container">

        {{-- FILTER KATEGORI --}}
        <div class="filter-tabs">
            @foreach($kategoriList as $key => $label)
            <a href="{{ route('galeri', ['kategori' => $key]) }}"
               class="filter-tab {{ $kategori === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        @if($galeri->count() > 0)
        <div class="galeri-grid">
            @foreach($galeri as $foto)
            <a href="{{ $foto->foto_url }}"
               class="galeri-item glightbox"
               data-gallery="galeri-desa"
               data-title="{{ $foto->judul }}"
               data-description="{{ $foto->keterangan }}">
                <img src="{{ $foto->foto_url }}" alt="{{ $foto->judul }}" loading="lazy">
                <div class="galeri-item__overlay">
                    <span class="galeri-item__label">{{ $foto->judul }}</span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($galeri->hasPages())
        <div class="pagination">
            @if($galeri->onFirstPage())
                <span class="page-item disabled"><span class="page-link">‹</span></span>
            @else
                <a class="page-link" href="{{ $galeri->previousPageUrl() }}">‹</a>
            @endif

            @foreach($galeri->getUrlRange(1, $galeri->lastPage()) as $page => $url)
                @if($page == $galeri->currentPage())
                    <span class="page-item active"><span class="page-link">{{ $page }}</span></span>
                @else
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($galeri->hasMorePages())
                <a class="page-link" href="{{ $galeri->nextPageUrl() }}">›</a>
            @else
                <span class="page-item disabled"><span class="page-link">›</span></span>
            @endif
        </div>
        @endif

        @else
        <div style="text-align:center;padding:5rem 0">
            <div style="font-size:3rem;margin-bottom:1rem">🖼️</div>
            <h3 style="font-family:var(--font-display);color:var(--teks-2);margin-bottom:0.5rem">Belum ada foto</h3>
            <p style="font-family:var(--font-ui);font-size:0.875rem;color:var(--teks-muted)">
                Foto akan ditampilkan setelah diunggah melalui panel administrasi.
            </p>
        </div>
        @endif

    </div>
</section>

@endsection
