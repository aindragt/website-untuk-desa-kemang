{{--
=============================================================
resources/views/operator/dashboard.blade.php
=============================================================
--}}
@extends('operator.layouts.operator')
@section('title', 'Dashboard Operator')
@section('page-title', 'Dashboard')

@section('content')

{{-- Banner perbedaan akses --}}
<div style="background:linear-gradient(135deg,var(--hijau),var(--hijau-muda));border-radius:var(--radius-lg);padding:1.25rem 1.5rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem">
    <div style="font-size:1.75rem">🖊️</div>
    <div>
        <div style="font-family:var(--font-display);font-size:0.95rem;color:#fff;margin-bottom:2px">
            Selamat datang, {{ session('user_nama') }}!
        </div>
        <div style="font-family:var(--font-ui);font-size:0.78rem;color:rgba(255,255,255,0.65)">
            Anda login sebagai <strong style="color:var(--emas)">Operator Desa</strong>.
            Beberapa fitur dibatasi — hubungi Admin untuk akses penuh.
        </div>
    </div>
</div>

{{-- Stat cards --}}
<div class="admin-stat-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--emas">⏳</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['pengajuan_menunggu'] }}</div>
            <div class="admin-stat-card__lbl">Surat Menunggu</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--hijau">🔄</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['pengajuan_diproses'] }}</div>
            <div class="admin-stat-card__lbl">Sedang Diproses</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--merah">✉️</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['pesan_baru'] }}</div>
            <div class="admin-stat-card__lbl">Pesan Baru</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--coklat">📰</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['total_berita'] }}</div>
            <div class="admin-stat-card__lbl">Total Berita</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">

    {{-- Pengajuan surat terbaru --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">Pengajuan Surat Terbaru</div>
            <a href="{{ route('operator.layanan.index') }}" class="btn-sm btn-sm--view">Lihat Semua</a>
        </div>
        <table class="admin-table">
            <thead><tr><th>Pemohon</th><th>Jenis</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($pengajuanTerbaru as $p)
                <tr>
                    <td>
                        <div style="font-weight:500;font-size:0.82rem">{{ $p->nama_lengkap }}</div>
                        <div style="font-size:0.7rem;color:var(--teks-muted)">{{ $p->nomor_referensi }}</div>
                    </td>
                    <td style="font-size:0.78rem;color:var(--teks-2)">{{ Str::limit($p->label_jenis, 25) }}</td>
                    <td><span class="badge {{ $p->badge_status }}">{{ $p->label_status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--teks-muted);padding:2rem">Belum ada pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pesan baru --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">Pesan Belum Dibaca</div>
            <a href="{{ route('operator.pesan.index') }}" class="btn-sm btn-sm--view">Lihat Semua</a>
        </div>
        <table class="admin-table">
            <thead><tr><th>Pengirim</th><th>Pesan</th></tr></thead>
            <tbody>
                @forelse($pesanTerbaru as $p)
                <tr>
                    <td>
                        <div style="font-weight:500;font-size:0.82rem">{{ $p->nama }}</div>
                        <div style="font-size:0.7rem;color:var(--teks-muted)">{{ $p->kontak }}</div>
                    </td>
                    <td style="font-size:0.78rem;color:var(--teks-2)">{{ Str::limit($p->pesan, 45) }}</td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center;color:var(--teks-muted);padding:2rem">Tidak ada pesan baru. 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Info fitur yang tidak bisa diakses operator --}}
<div style="margin-top:1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem">
    <div style="font-family:var(--font-ui);font-size:0.78rem;font-weight:600;color:var(--teks-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.75rem">
        ⚠️ Fitur yang memerlukan akses Admin
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem">
        @foreach(['Hapus Berita','Hapus Foto Galeri','Hapus Pengajuan Surat','Hapus Pesan','Kelola Data Statistik','Kelola Akun Operator'] as $f)
        <span style="background:#faf5eb;border:1px solid var(--krem-tua);border-radius:999px;font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted);padding:3px 10px">
            🔒 {{ $f }}
        </span>
        @endforeach
    </div>
</div>

@endsection
