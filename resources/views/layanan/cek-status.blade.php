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

        {{-- Form Cek Status --}}
        <form action="{{ route('layanan.cek-status') }}" method="GET"
              style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.75rem;margin-bottom:1.5rem">
            <h3 style="font-family:var(--font-display);font-size:1rem;color:var(--teks);margin-bottom:1rem">🔍 Masukkan Nomor Referensi</h3>
            <div style="display:flex;gap:0.75rem">
                <input type="text" name="nomor" class="form-control"
                       value="{{ $nomorReferensi }}"
                       placeholder="Contoh: SKD-2025-00001"
                       style="flex:1;text-transform:uppercase;letter-spacing:0.05em"
                       oninput="this.value=this.value.toUpperCase()" required>
                <button type="submit" class="btn btn--primary" style="width:auto;padding:0.75rem 1.25rem;white-space:nowrap">
                    Cari
                </button>
            </div>
            <p style="font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted);margin-top:0.5rem">
                Nomor referensi terdiri dari prefix surat, tahun, dan urutan. Contoh: SKD-2025-00001
            </p>
        </form>

        {{-- Hasil --}}
        @if($nomorReferensi && !$pengajuan)
        <div class="alert alert--error">
            ❌ Nomor referensi <strong>{{ $nomorReferensi }}</strong> tidak ditemukan. Periksa kembali nomor Anda.
        </div>
        @endif

        @if($pengajuan)
        {{-- Status Badge Besar --}}
        <div style="background:var(--hijau);border-radius:var(--radius-lg);padding:1.5rem;text-align:center;margin-bottom:1.25rem">
            <div style="font-family:var(--font-display);font-size:1.25rem;color:var(--emas);font-weight:700;margin-bottom:0.25rem">
                {{ $pengajuan->nomor_referensi }}
            </div>
            <div style="font-family:var(--font-ui);font-size:0.75rem;color:rgba(255,255,255,0.6)">{{ $pengajuan->label_jenis }}</div>
        </div>

        {{-- Progress Status --}}
        @php
            $statuses = ['menunggu','diproses_operator','menunggu_validasi_kades','disetujui'];
            $currentIdx = array_search($pengajuan->status, $statuses);
            if ($pengajuan->status === 'ditolak') $currentIdx = -1;
        @endphp

        @if($pengajuan->status !== 'ditolak')
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.25rem">
            <div style="display:flex;align-items:center;justify-content:space-between;position:relative">
                <div style="position:absolute;top:18px;left:10%;right:10%;height:2px;background:var(--border);z-index:0"></div>
                @foreach(['menunggu'=>['⏳','Menunggu'],'diproses_operator'=>['🔄','Diproses'],'menunggu_validasi_kades'=>['⏱️','Validasi Kades'],'disetujui'=>['✅','Selesai']] as $st => [$ikon, $label])
                @php $idx = array_search($st, $statuses); $done = $currentIdx >= $idx; @endphp
                <div style="text-align:center;position:relative;z-index:1;flex:1">
                    <div style="width:36px;height:36px;border-radius:50%;margin:0 auto 0.4rem;display:flex;align-items:center;justify-content:center;font-size:1rem;
                        background:{{ $done ? 'var(--hijau)' : 'var(--border)' }};
                        border:2px solid {{ $done ? 'var(--hijau)' : 'var(--border)' }}">
                        {{ $ikon }}
                    </div>
                    <div style="font-family:var(--font-ui);font-size:0.72rem;font-weight:{{ $done ? '600' : '400' }};color:{{ $done ? 'var(--hijau)' : 'var(--teks-muted)' }}">
                        {{ $label }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="alert alert--error" style="margin-bottom:1.25rem">
            ❌ <strong>Pengajuan Ditolak.</strong>
            @if($pengajuan->catatan_admin)
            Alasan: {{ $pengajuan->catatan_admin }}
            @endif
        </div>
        @endif

        {{-- Detail --}}
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem">
            <h4 style="font-family:var(--font-display);font-size:0.9rem;color:var(--teks);margin-bottom:1rem">Detail Pengajuan</h4>
            @foreach([
                ['Nama',          $pengajuan->nama_lengkap],
                ['Keperluan',     $pengajuan->keperluan],
                ['Tanggal Ajuan', $pengajuan->tanggal_pengajuan],
                ['No. HP',        $pengajuan->no_hp],
            ] as $row)
            <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:0.5px solid var(--border);font-family:var(--font-ui);font-size:0.82rem">
                <span style="color:var(--teks-muted)">{{ $row[0] }}</span>
                <span style="font-weight:500;color:var(--teks)">{{ $row[1] }}</span>
            </div>
            @endforeach

            @if($pengajuan->status === 'disetujui')
            <div style="background:#ecf7ec;border:1px solid #7dbf7d;border-radius:var(--radius);padding:1rem;margin-top:1rem;font-family:var(--font-ui);font-size:0.82rem;color:#2d6a2d">
                ✅ <strong>Surat Anda sudah selesai diproses!</strong> Silakan datang ke kantor desa dengan membawa dokumen asli dan nomor referensi ini.
            </div>
            @endif
        </div>
        @endif

        <div style="text-align:center;margin-top:1.5rem">
            <a href="{{ route('layanan.index') }}" style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-muted)">
                ← Kembali ke Layanan Surat
            </a>
        </div>

    </div>
</section>

@endsection
