@extends('layouts.app')
@section('title', 'Kontak')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Hubungi Kami</div>
        <h1>Kontak & Lokasi</h1>
        <p class="page-header__desc">Kami siap melayani Anda. Kunjungi kantor desa atau kirim pesan melalui formulir berikut.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <span>Kontak</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container">
        <div class="kontak-grid">

            {{-- INFO --}}
            <div>
                <div class="section-eyebrow">Informasi Kontak</div>
                <h2 class="section-title" style="margin-bottom:1.75rem">Kantor Desa Kemang</h2>

                @foreach ([
                    ['📍', 'Alamat', 'Jl. Raya Desa Kemang, Kec. Pangkalan Kuras,<br>Kab. Pelalawan, Riau'],
                    ['📞', 'Telepon', '+62 822-8575-3837'],
                    ['✉️',  'Email',   'desakemang.pelalawan@gmail.com'],
                    ['💬', 'WhatsApp', '+62 822-8575-3837'],
                ] as $info)
                <div class="kontak-info__item">
                    <div class="kontak-info__icon">{{ $info[0] }}</div>
                    <div>
                        <div class="kontak-info__label">{{ $info[1] }}</div>
                        <div class="kontak-info__value">{!! $info[2] !!}</div>
                    </div>
                </div>
                @endforeach

                <div style="background:var(--krem);border-radius:var(--radius-lg);padding:1.25rem;margin-top:0.5rem">
                    <div style="font-family:var(--font-display);font-size:0.95rem;color:var(--teks);margin-bottom:0.75rem">Jam Pelayanan</div>
                    @foreach ([
                        ['Senin – Kamis', '08.00 – 15.30 WIB'],
                        ['Jumat',         '08.00 – 11.30 WIB'],
                        ['Sabtu – Minggu','Tutup'],
                    ] as $jam)
                    <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:0.5px solid var(--border);font-family:var(--font-ui);font-size:0.82rem">
                        <span style="color:var(--teks-2)">{{ $jam[0] }}</span>
                        <span style="font-weight:500;color:var(--teks)">{{ $jam[1] }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Google Maps embed placeholder --}}
                <div style="background:var(--krem-tua);border-radius:var(--radius-lg);aspect-ratio:16/9;margin-top:1.5rem;display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted);text-align:center;padding:1rem">
                    <div>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4256.768693674075!2d101.89925071007437!3d0.31035491490962597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5dd47dd6a474d%3A0xc6f182ef1c3569d!2sKANTOR%20DESA%20KEMANG!5e1!3m2!1sid!2sid!4v1777189432051!5m2!1sid!2sid"                           width="390" 
                            height="260" 
                            style="border:0; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <div>
                <div class="section-eyebrow">Kirim Pesan</div>
                <h2 class="section-title" style="margin-bottom:1.75rem">Formulir Kontak</h2>

                @if(session('success'))
                    <div class="alert alert--success">✅ {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert--error">
                        <ul style="margin:0;padding-left:1.25rem">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="kontak-form">
                    <form action="{{ route('kontak.kirim') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="nama">Nama Lengkap <span style="color:red">*</span></label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="kontak">Email / No. WhatsApp <span style="color:red">*</span></label>
                            <input type="text" id="kontak" name="kontak" class="form-control" placeholder="email@contoh.com atau 0812-xxxx-xxxx" value="{{ old('kontak') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pesan">Pesan <span style="color:red">*</span></label>
                            <textarea id="pesan" name="pesan" class="form-control" placeholder="Tulis pesan, pertanyaan, atau keperluan Anda..." required>{{ old('pesan') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn--primary">
                            📨 Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
