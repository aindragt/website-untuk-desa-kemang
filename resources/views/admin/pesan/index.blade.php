{{-- resources/views/admin/pesan/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan Masuk')

@section('content')
<div class="admin-card">
    <div class="admin-card__header">
        <div class="admin-card__title">Semua Pesan ({{ $pesan->total() }})</div>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Pengirim</th>
                <th>Kontak</th>
                <th>Pesan</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesan as $p)
            <tr style="{{ !$p->is_read ? 'font-weight:500' : '' }}">
                <td style="color:var(--teks)">{{ $p->nama }}</td>
                <td style="font-size:0.78rem;color:var(--teks-2)">{{ $p->kontak }}</td>
                <td style="font-size:0.8rem;color:var(--teks-2)">{{ Str::limit($p->pesan, 60) }}</td>
                <td style="font-size:0.75rem;color:var(--teks-muted);white-space:nowrap">
                    {{ $p->created_at->diffForHumans() }}
                </td>
                <td>
                    @if(!$p->is_read)
                        <span class="badge badge--merah">Baru</span>
                    @else
                        <span class="badge badge--abu">Dibaca</span>
                    @endif
                </td>
                <td style="white-space:nowrap">
                    <a href="{{ route('admin.pesan.show', $p) }}" class="btn-sm btn-sm--view">📖 Baca</a>
                    <form action="{{ route('admin.pesan.destroy', $p) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-sm btn-sm--hapus"
                                onclick="return confirm('Hapus pesan ini?')">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--teks-muted)">Tidak ada pesan masuk.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($pesan->hasPages())
    <div class="admin-pagination">{{ $pesan->links('pagination::simple-default') }}</div>
    @endif
</div>
@endsection


{{-- ============================================================ --}}
{{-- resources/views/admin/pesan/show.blade.php                   --}}
{{-- Simpan file ini sebagai file terpisah: admin/pesan/show.blade.php --}}
{{-- ============================================================ --}}
