@extends('layouts.app')
@section('title', 'Pengajuan Berhasil')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Pengajuan Terkirim</div>
        <h1>Pengajuan Berhasil! 🎉</h1>
        <p class="page-header__desc">Surat Anda sudah diterima dan akan segera diproses oleh perangkat desa.</p>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container" style="max-width:600px">

        {{-- Nomor Referensi --}}
        <div style="background:var(--hijau);border-radius:var(--radius-lg);padding:2rem;text-align:center;margin-bottom:1.5rem">
            <p style="font-family:var(--font-ui);font-size:0.75rem;color:rgba(255,255,255,0.6);letter-spacing:0.1em;text-transform:uppercase;margin-bottom:0.5rem">
                Nomor Referensi Anda
            </p>
            <div style="font-family:var(--font-display);font-size:2rem;color:var(--emas);font-weight:700;letter-spacing:0.05em;margin-bottom:0.75rem">
                {{ $pengajuan->nomor_referensi }}
            </div>
            <p style="font-family:var(--font-ui);font-size:0.78rem;color:rgba(255,255,255,0.6)">
                Simpan nomor ini untuk mengecek status pengajuan Anda
            </p>
        </div>

        {{-- Ringkasan --}}
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem">
            <h3 style="font-family:var(--font-display);font-size:0.95rem;color:var(--teks);margin-bottom:1rem">Ringkasan Pengajuan</h3>
            @foreach([
                ['Jenis Surat',  $pengajuan->label_jenis],
                ['Nama',         $pengajuan->nama_lengkap],
                ['NIK',          $pengajuan->nik],
                ['No. HP',       $pengajuan->no_hp],
                ['Keperluan',    $pengajuan->keperluan],
                ['Status',       $pengajuan->label_status],
                ['Tanggal Ajuan',$pengajuan->tanggal_pengajuan],
            ] as $row)
            <div style="display:flex;justify-content:space-between;padding:0.6rem 0;border-bottom:0.5px solid var(--border);font-family:var(--font-ui);font-size:0.82rem">
                <span style="color:var(--teks-muted)">{{ $row[0] }}</span>
                <span style="font-weight:500;color:var(--teks);text-align:right;max-width:60%">{{ $row[1] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Info selanjutnya --}}
        <div style="background:var(--krem);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1.5rem">
            <h4 style="font-family:var(--font-display);font-size:0.9rem;color:var(--teks);margin-bottom:0.75rem">Langkah Selanjutnya</h4>
            @foreach([
                ['⏳', 'Tunggu konfirmasi', 'Perangkat desa akan memproses pengajuan Anda dalam 1-3 hari kerja.'],
                ['📞', 'Dihubungi via HP', 'Jika diperlukan, perangkat desa akan menghubungi nomor HP Anda.'],
                ['🏢', 'Ambil ke kantor desa', 'Datang ke kantor desa dengan membawa dokumen asli untuk mengambil surat.'],
            ] as $info)
            <div style="display:flex;gap:10px;margin-bottom:0.75rem">
                <span style="font-size:1.1rem;flex-shrink:0">{{ $info[0] }}</span>
                <div>
                    <div style="font-family:var(--font-ui);font-size:0.8rem;font-weight:600;color:var(--teks)">{{ $info[1] }}</div>
                    <div style="font-family:var(--font-ui);font-size:0.78rem;color:var(--teks-muted)">{{ $info[2] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="display:flex;gap:1rem;flex-wrap:wrap">
            <a href="{{ route('layanan.cek-status', ['nomor' => $pengajuan->nomor_referensi]) }}"
               class="btn btn--primary" style="flex:1;justify-content:center">
                🔍 Cek Status Pengajuan
            </a>
            <a href="{{ route('layanan.index') }}"
               style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-muted);display:flex;align-items:center">
                ← Kembali ke Layanan
            </a>
        </div>

    </div>
</section>

@endsection
