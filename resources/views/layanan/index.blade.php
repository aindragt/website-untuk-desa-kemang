@extends('layouts.app')
@section('title', 'Layanan Surat')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Pelayanan Publik</div>
        <h1>Layanan Surat Desa</h1>
        <p class="page-header__desc">
            Ajukan surat keterangan secara online. Isi formulir, submit, dan
            surat Anda akan diproses oleh perangkat desa.
        </p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <span>Layanan Surat</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

{{-- INFO ALUR --}}
<section style="background:var(--krem);padding:2rem 0">
    <div class="container">
        <div style="display:flex;align-items:center;justify-content:center;gap:0;flex-wrap:wrap">
            @foreach([
                ['1', '📝', 'Pilih Jenis Surat', 'Pilih surat yang dibutuhkan'],
                ['2', '✍️', 'Isi Formulir', 'Lengkapi data diri dengan benar'],
                ['3', '📨', 'Submit',  'Kirim pengajuan secara online'],
                ['4', '⏳', 'Menunggu Proses', 'Admin desa memproses surat'],
                ['5', '🏢', 'Ambil ke Kantor', 'Surat siap diambil di kantor desa'],
            ] as $i => $step)
            <div style="display:flex;align-items:center">
                <div style="text-align:center;padding:0 1rem">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--hijau);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1rem;margin:0 auto 0.4rem">
                        {{ $step[1] }}
                    </div>
                    <div style="font-family:var(--font-ui);font-size:0.72rem;font-weight:600;color:var(--teks);margin-bottom:2px">{{ $step[2] }}</div>
                    <div style="font-family:var(--font-ui);font-size:0.65rem;color:var(--teks-muted)">{{ $step[3] }}</div>
                </div>
                @if($i < 4)
                <div style="width:32px;height:2px;background:var(--emas);flex-shrink:0"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="motif-divider"></div>

{{-- DAFTAR LAYANAN --}}
<section class="section">
    <div class="container">
        <div style="text-align:center;margin-bottom:3rem">
            <div class="section-eyebrow" style="justify-content:center">Pilih Layanan</div>
            <h2 class="section-title">Jenis Surat yang Tersedia</h2>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(480px,1fr));gap:1.5rem">
            @foreach($layanan as $item)
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;display:flex;flex-direction:column">
                <div style="background:var(--hijau);padding:1.5rem;display:flex;align-items:center;gap:1rem">
                    <div style="font-size:2rem;width:52px;height:52px;background:rgba(255,255,255,0.15);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        {{ $item['ikon'] }}
                    </div>
                    <div>
                        <h3 style="font-family:var(--font-display);font-size:1.05rem;color:#fff;margin-bottom:2px">{{ $item['judul'] }}</h3>
                        <p style="font-family:var(--font-ui);font-size:0.75rem;color:rgba(255,255,255,0.65)">{{ $item['deskripsi'] }}</p>
                    </div>
                </div>
                <div style="padding:1.25rem;flex:1;display:flex;flex-direction:column;gap:1rem">
                    <div>
                        <div style="font-family:var(--font-ui);font-size:0.7rem;font-weight:600;color:var(--teks-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem">Syarat Dokumen</div>
                        <ul style="display:flex;flex-direction:column;gap:4px">
                            @foreach($item['syarat'] as $syarat)
                            <li style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-2);display:flex;align-items:flex-start;gap:6px">
                                <span style="color:var(--emas);margin-top:1px;flex-shrink:0">✓</span>{{ $syarat }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div style="margin-top:auto;padding-top:1rem;border-top:1px solid var(--border)">
                        <a href="{{ route('layanan.form', $item['kode']) }}"
                           style="display:flex;align-items:center;justify-content:center;gap:8px;background:var(--emas);color:var(--hijau-tua);font-family:var(--font-ui);font-size:0.82rem;font-weight:700;letter-spacing:0.05em;padding:0.75rem;border-radius:var(--radius);transition:background 0.2s"
                           onmouseover="this.style.background='#e8b84b'" onmouseout="this.style.background='var(--emas)'">
                            Ajukan Sekarang →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CEK STATUS --}}
        <div style="margin-top:3rem;background:var(--krem);border-radius:var(--radius-lg);padding:2rem;text-align:center">
            <div style="font-size:1.5rem;margin-bottom:0.5rem">🔍</div>
            <h3 style="font-family:var(--font-display);font-size:1.1rem;color:var(--teks);margin-bottom:0.4rem">Sudah pernah mengajukan?</h3>
            <p style="font-family:var(--font-ui);font-size:0.85rem;color:var(--teks-muted);margin-bottom:1.25rem">
                Cek status pengajuan surat Anda menggunakan nomor referensi.
            </p>
            <a href="{{ route('layanan.cek-status') }}"
               style="display:inline-flex;align-items:center;gap:8px;background:var(--hijau);color:#fff;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;padding:0.65rem 1.5rem;border-radius:var(--radius)">
                🔍 Cek Status Pengajuan
            </a>
        </div>
    </div>
</section>

@endsection
