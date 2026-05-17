@extends('admin.layouts.admin')
@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <div class="admin-card__title">Daftar Berita ({{ $berita->total() }})</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            {{-- Filter cari --}}
            <form action="{{ route('admin.berita.index') }}" method="GET" style="display:flex;gap:6px">
                <input type="text" name="cari" value="{{ $cari }}"
                       class="form-control" placeholder="Cari judul..."
                       style="width:180px;padding:0.4rem 0.75rem">
                <select name="kategori" class="form-control" style="width:140px;padding:0.4rem 0.75rem">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $key => $label)
                        <option value="{{ $key }}" {{ $kategori === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="btn-sm btn-sm--view" type="submit">Cari</button>
                @if($cari || $kategori)
                    <a href="{{ route('admin.berita.index') }}" class="btn-sm btn-sm--hapus">Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.berita.create') }}" class="btn-sm btn-sm--edit">+ Tulis Berita</a>
        </div>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:40%">Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($berita as $b)
            <tr>
                <td>
                    <div style="font-weight:500;color:var(--teks)">{{ Str::limit($b->judul, 60) }}</div>
                </td>
                <td><span class="badge badge--emas">{{ $kategoriList[$b->kategori] ?? $b->kategori }}</span></td>
                <td style="color:var(--teks-2);font-size:0.8rem">{{ $b->penulis }}</td>
                <td style="color:var(--teks-muted);font-size:0.78rem;white-space:nowrap">{{ $b->tanggal_format }}</td>
                <td>
                    @if($b->is_published)
                        <span class="badge badge--hijau">Tayang</span>
                    @else
                        <span class="badge badge--abu">Draft</span>
                    @endif
                </td>
                <td style="white-space:nowrap">
                    <a href="{{ route('admin.berita.edit', $b) }}" class="btn-sm btn-sm--edit">✏️ Edit</a>

                    <form action="{{ route('admin.berita.toggle', $b) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-sm {{ $b->is_published ? 'btn-sm--hapus' : 'btn-sm--view' }}"
                                onclick="return confirm('{{ $b->is_published ? 'Sembunyikan' : 'Tayangkan' }} berita ini?')">
                            {{ $b->is_published ? '🙈 Sembunyikan' : '👁️ Tayangkan' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.berita.destroy', $b) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-sm btn-sm--hapus"
                                onclick="return confirm('Hapus berita ini permanen?')">🗑️ Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:3rem;color:var(--teks-muted)">
                    Belum ada berita. <a href="{{ route('admin.berita.create') }}" style="color:var(--emas)">Tulis sekarang →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($berita->hasPages())
    <div class="admin-pagination">
        <span>{{ $berita->firstItem() }}–{{ $berita->lastItem() }} dari {{ $berita->total() }}</span>
        {{ $berita->withQueryString()->links('pagination::simple-default') }}
    </div>
    @endif
</div>

@endsection
