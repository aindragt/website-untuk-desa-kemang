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

        {{-- LIVEWIRE BERITA SEARCH --}}
        <livewire:berita-search />

    </div>
</section>

@endsection
