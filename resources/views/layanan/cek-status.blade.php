@extends('layouts.app')
@section('title', 'Cek Status Pengajuan')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Pelacakan</div>
        <h1>Cek Status Pengajuan</h1>
        <p class="page-header__desc">Masukkan nomor referensi yang Anda terima saat mengajukan surat.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <a href="{{ route('layanan.index') }}">Layanan Surat</a>
            <span class="breadcrumb__sep">/</span>
            <span>Cek Status</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container" style="max-width:560px">

        {{-- LIVEWIRE STATUS CHECKER --}}
        <livewire:status-checker />

        <div style="text-align:center;margin-top:1.5rem">
            <a href="{{ route('layanan.index') }}" style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-muted)">
                ← Kembali ke Layanan Surat
            </a>
        </div>

    </div>
</section>

@endsection
