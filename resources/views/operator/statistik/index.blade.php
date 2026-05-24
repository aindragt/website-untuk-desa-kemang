{{-- resources/views/operator/statistik/index.blade.php --}}
@extends('operator.layouts.operator')
@section('title', 'Kelola Statistik')
@section('page-title', 'Kelola Statistik Desa')

@section('content')
<form action="{{ route('operator.statistik.update') }}" method="POST">
@csrf @method('PUT')

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
    @foreach($data as $kategori => $items)
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">{{ ucfirst($kategori) }}</div>
        </div>
        <div style="padding:1.25rem">
            @foreach($items as $item)
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:0.75rem">
                <input type="hidden" name="statistik[{{ $item->id }}][id]" value="{{ $item->id }}">
                <label style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-2);flex:1">{{ $item->label }}</label>
                <input type="number" name="statistik[{{ $item->id }}][nilai]"
                       value="{{ $item->nilai }}" min="0"
                       class="form-control" style="width:120px;padding:0.4rem 0.75rem;text-align:right">
                <span style="font-size:0.75rem;color:var(--teks-muted);width:30px">{{ $item->satuan }}</span>
                <button type="button" class="btn-sm btn-sm--hapus"
                        onclick="if(confirm('Hapus data ini?')) { var f = document.getElementById('delete-form'); f.action = '{{ route('operator.statistik.destroy', $item) }}'; f.submit(); }"
                        style="padding:0.25rem 0.5rem">🗑</button>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<div style="text-align:right;margin-bottom:1.5rem">
    <button type="submit" class="btn btn--primary" style="width:auto;display:inline-flex">
        💾 Simpan Semua Perubahan
    </button>
</div>
</form>

{{-- Hidden form for delete --}}
<form id="delete-form" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

{{-- Tambah data baru --}}
<div class="admin-card" style="padding:1.25rem;max-width:500px">
    <div style="font-size:0.875rem;font-weight:600;color:var(--teks);margin-bottom:1rem">+ Tambah Data Baru</div>
    <form action="{{ route('operator.statistik.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:0.75rem">
            <div>
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="penduduk">Penduduk</option>
                    <option value="pekerjaan">Pekerjaan</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="agama">Agama</option>
                </select>
            </div>
            <div>
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" class="form-control" value="jiwa" placeholder="jiwa / KK / dll">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 120px;gap:0.75rem;margin-bottom:0.75rem">
            <div>
                <label class="form-label">Label</label>
                <input type="text" name="label" class="form-control" placeholder="Contoh: Balita" required>
            </div>
            <div>
                <label class="form-label">Nilai</label>
                <input type="number" name="nilai" class="form-control" value="0" min="0" required>
            </div>
        </div>
        <button type="submit" class="btn-sm btn-sm--edit">+ Tambah</button>
    </form>
</div>
@endsection
