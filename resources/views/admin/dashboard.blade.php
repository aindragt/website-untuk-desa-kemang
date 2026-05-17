@extends('admin.layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Banner perbedaan akses --}}
<div style="background:linear-gradient(135deg,var(--hijau),var(--hijau-muda));border-radius:var(--radius-lg);padding:1.25rem 1.5rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem">
    <div style="font-size:1.75rem">👑</div>
    <div>
        <div style="font-family:var(--font-display);font-size:0.95rem;color:#fff;margin-bottom:2px">
            Selamat datang, {{ session('user_nama') }}!
        </div>
        <div style="font-family:var(--font-ui);font-size:0.78rem;color:rgba(255,255,255,0.65)">
            Anda login sebagai <strong style="color:var(--emas)">Admin Desa</strong>.
            Semua fitur terbuka — Anda memiliki akses penuh.
        </div>
    </div>
</div>

<div class="admin-stat-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--hijau">📰</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['total_berita'] }}</div>
            <div class="admin-stat-card__lbl">Total Berita</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--emas">✅</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['berita_tayang'] }}</div>
            <div class="admin-stat-card__lbl">Berita Tayang</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--coklat">🖼️</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['total_galeri'] }}</div>
            <div class="admin-stat-card__lbl">Foto Galeri</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon admin-stat-card__icon--merah">✉️</div>
        <div>
            <div class="admin-stat-card__num">{{ $stats['pesan_baru'] }}</div>
            <div class="admin-stat-card__lbl">Pesan Belum Dibaca</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">

    {{-- Berita terbaru --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">Berita Terbaru</div>
            <a href="{{ route('admin.berita.create') }}" class="btn-sm btn-sm--edit">+ Tambah</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beritaTerbaru as $b)
                <tr>
                    <td>
                        <div style="font-weight:500;color:var(--teks);max-width:200px">{{ Str::limit($b->judul, 45) }}</div>
                        <div style="font-size:0.72rem;color:var(--teks-muted);margin-top:2px">{{ $b->tanggal_format }}</div>
                    </td>
                    <td>
                        @if($b->is_published)
                            <span class="badge badge--hijau">Tayang</span>
                        @else
                            <span class="badge badge--abu">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.berita.edit', $b) }}" class="btn-sm btn-sm--edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--teks-muted);padding:2rem">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pesan terbaru --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">Pesan Belum Dibaca</div>
            <a href="{{ route('admin.pesan.index') }}" class="btn-sm btn-sm--view">Lihat Semua</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pengirim</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanTerbaru as $p)
                <tr>
                    <td>
                        <div style="font-weight:500;color:var(--teks)">{{ $p->nama }}</div>
                        <div style="font-size:0.72rem;color:var(--teks-muted)">{{ $p->kontak }}</div>
                    </td>
                    <td style="color:var(--teks-2);font-size:0.8rem">{{ Str::limit($p->pesan, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.pesan.show', $p) }}" class="btn-sm btn-sm--view">Baca</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--teks-muted);padding:2rem">Tidak ada pesan baru. 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
