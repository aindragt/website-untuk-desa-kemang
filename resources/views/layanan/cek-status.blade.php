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
    <div class="container max-w-[560px]">

        {{-- Form Cek Status --}}
        <form action="{{ route('layanan.cek-status') }}" method="GET"
              class="bg-white border border-[#D9C8A8] rounded-lg p-7 mb-6">
            <h3 class="font-display text-[1rem] text-stone-900 mb-4">🔍 Masukkan Nomor Referensi</h3>
            <div class="flex gap-3">
                <input type="text" name="nomor" class="form-control flex-1 uppercase tracking-wider"
                       value="{{ $nomorReferensi }}"
                       placeholder="Contoh: SKD-2025-00001"
                       oninput="this.value=this.value.toUpperCase()" required>
                <button type="submit" class="btn btn--primary w-auto py-3 px-5 whitespace-nowrap">
                    Cari
                </button>
            </div>
            <p class="font-ui text-[0.72rem] text-stone-500 mt-2">
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
        <div class="bg-hijau rounded-lg p-6 text-center mb-5">
            <div class="font-display text-[1.25rem] text-emas font-bold mb-1">
                {{ $pengajuan->nomor_referensi }}
            </div>
            <div class="font-ui text-[0.75rem] text-white/60">{{ $pengajuan->label_jenis }}</div>
        </div>

        {{-- Progress Status --}}
        @php
            $statuses = ['menunggu','diproses_operator','menunggu_validasi_kades','disetujui'];
            $currentIdx = array_search($pengajuan->status, $statuses);
            if ($pengajuan->status === 'ditolak') $currentIdx = -1;
        @endphp

        @if($pengajuan->status !== 'ditolak')
        <div class="bg-white border border-[#D9C8A8] rounded-lg p-6 mb-5">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-[18px] left-[10%] right-[10%] h-[2px] bg-[#D9C8A8] z-0"></div>
                @foreach(['menunggu'=>['⏳','Menunggu'],'diproses_operator'=>['🔄','Diproses'],'menunggu_validasi_kades'=>['⏱️','Validasi Kades'],'disetujui'=>['✅','Selesai']] as $st => [$ikon, $label])
                @php $idx = array_search($st, $statuses); $done = $currentIdx >= $idx; @endphp
                <div class="text-center relative z-[1] flex-1">
                    <div class="w-9 h-9 rounded-full mx-auto mb-1.5 flex items-center justify-center text-[1rem] border-2 {{ $done ? 'bg-hijau border-hijau text-white' : 'bg-[#D9C8A8] border-[#D9C8A8]' }}">
                        {{ $ikon }}
                    </div>
                    <div class="font-ui text-[0.72rem] {{ $done ? 'font-semibold text-hijau' : 'font-normal text-stone-500' }}">
                        {{ $label }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="alert alert--error mb-5">
            ❌ <strong>Pengajuan Ditolak.</strong>
            @if($pengajuan->catatan_admin)
            Alasan: {{ $pengajuan->catatan_admin }}
            @endif
        </div>
        @endif

        {{-- Detail --}}
        <div class="bg-white border border-[#D9C8A8] rounded-lg p-6">
            <h4 class="font-display text-[0.9rem] text-stone-900 mb-4">Detail Pengajuan</h4>
            @foreach([
                ['Nama',          $pengajuan->nama_lengkap],
                ['Keperluan',     $pengajuan->keperluan],
                ['Tanggal Ajuan', $pengajuan->tanggal_pengajuan],
                ['No. HP',        $pengajuan->no_hp],
            ] as $row)
            <div class="flex justify-between py-2 border-b border-[#D9C8A8]/50 font-ui text-[0.82rem]">
                <span class="text-stone-500">{{ $row[0] }}</span>
                <span class="font-medium text-stone-900">{{ $row[1] }}</span>
            </div>
            @endforeach

            @if($pengajuan->status === 'disetujui')
            <div class="bg-[#ecf7ec] border border-[#7dbf7d] rounded p-4 mt-4 font-ui text-[0.82rem] text-[#2d6a2d]">
                ✅ <strong>Surat Anda sudah selesai diproses!</strong> Silakan datang ke kantor desa dengan membawa dokumen asli dan nomor referensi ini.
            </div>
            @endif
        </div>
        @endif

        <div class="text-center mt-6">
            <a href="{{ route('layanan.index') }}" class="font-ui text-[0.82rem] text-stone-500">
                ← Kembali ke Layanan Surat
            </a>
        </div>

    </div>
</section>

@endsection
