@extends('layouts.app')
@section('title', $berita->judul)

@section('content')

{{-- HEADER --}}
<div class="berita-single__header">
    <div class="container page-header__content">
        <span class="berita-single__kategori">
            {{ \App\Models\Berita::kategoriList()[$berita->kategori] ?? $berita->kategori }}
        </span>
        <h1 class="berita-single__judul">{{ $berita->judul }}</h1>
        <p class="berita-single__meta">
            ✍️ {{ $berita->penulis }} &nbsp;·&nbsp; 📅 {{ $berita->tanggal_format }}
        </p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <a href="{{ route('berita.index') }}">Berita</a>
            <span class="breadcrumb__sep">/</span>
            <span>{{ Str::limit($berita->judul, 40) }}</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 320px;gap:3rem;align-items:start">

            {{-- KONTEN UTAMA --}}
            <div>
                @if($berita->foto)
                <img src="{{ $berita->foto_url }}" alt="{{ $berita->judul }}"
                     style="width:100%;border-radius:var(--radius-lg);margin-bottom:2rem;aspect-ratio:16/9;object-fit:cover">
                @endif

                <div class="berita-single__content">
                    {!! $berita->isi !!}
                </div>

                {{-- BAGIKAN --}}
                <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--border)">
                    <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted);margin-bottom:0.75rem">Bagikan berita ini:</p>
                    <div style="display:flex;gap:0.5rem">
                        @php $url = urlencode(request()->fullUrl()); $teks = urlencode($berita->judul); @endphp
                        <a href="https://wa.me/?text={{ $teks }}%20{{ $url }}" target="_blank"
                           style="font-family:var(--font-ui);font-size:0.78rem;font-weight:600;padding:0.4rem 1rem;background:#25D366;color:#fff;border-radius:999px">
                            💬 WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
                           style="font-family:var(--font-ui);font-size:0.78rem;font-weight:600;padding:0.4rem 1rem;background:#1877F2;color:#fff;border-radius:999px">
                            📘 Facebook
                        </a>
                    </div>
                </div>

                {{-- NAVIGASI KEMBALI --}}
                <div style="margin-top:2rem">
                    <a href="{{ route('berita.index') }}" class="berita-card__link">← Kembali ke Daftar Berita</a>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <aside>
                <div style="background:var(--krem);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem">
                    <div style="font-family:var(--font-display);font-size:0.95rem;color:var(--teks);margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
                        Berita Lainnya
                    </div>
                    @forelse($lainnya as $l)
                    <a href="{{ route('berita.show', $l->slug) }}" style="display:block;margin-bottom:1rem;padding-bottom:1rem;border-bottom:0.5px solid var(--border)">
                        <div style="font-family:var(--font-ui);font-size:0.65rem;color:var(--emas);margin-bottom:3px;text-transform:uppercase;letter-spacing:0.08em">
                            {{ $l->tanggal_format }}
                        </div>
                        <div style="font-family:var(--font-display);font-size:0.875rem;color:var(--teks);line-height:1.4">
                            {{ $l->judul }}
                        </div>
                    </a>
                    @empty
                    <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">Tidak ada berita lain.</p>
                    @endforelse
                </div>

                <div style="background:var(--hijau);border-radius:var(--radius-lg);padding:1.5rem;text-align:center">
                    <div style="font-size:1.75rem;margin-bottom:0.75rem">📬</div>
                    <div style="font-family:var(--font-display);font-size:0.95rem;color:#fff;margin-bottom:0.5rem">Ada pertanyaan?</div>
                    <p style="font-family:var(--font-ui);font-size:0.78rem;color:rgba(255,255,255,0.6);margin-bottom:1rem">Hubungi kami melalui halaman kontak.</p>
                    <a href="{{ route('kontak') }}" style="display:block;background:var(--emas);color:var(--hijau-tua);font-family:var(--font-ui);font-size:0.78rem;font-weight:700;padding:0.6rem;border-radius:var(--radius);letter-spacing:0.05em">
                        Hubungi Kami
                    </a>
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
