@extends('operator.layouts.operator')
@section('title', 'Kelola Galeri')
@section('page-title', 'Kelola Galeri Foto')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

    {{-- GRID FOTO --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">Foto Tersimpan ({{ $galeri->total() }})</div>
        </div>
        @if($galeri->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:#e8e4d8">
            @foreach($galeri as $foto)
            <div style="background:#fff;padding:0.75rem;position:relative">
                <img src="{{ $foto->foto_url }}" alt="{{ $foto->judul }}"
                     style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:var(--radius);margin-bottom:0.5rem;
                            {{ !$foto->is_active ? 'opacity:0.4;filter:grayscale(1)' : '' }}">
                @if(!$foto->is_active)
                <div style="position:absolute;top:0.75rem;right:0.75rem;background:rgba(0,0,0,0.55);color:#fff;font-size:0.65rem;padding:2px 6px;border-radius:4px">Tersembunyi</div>
                @endif
                <div style="font-size:0.78rem;font-weight:500;color:var(--teks);margin-bottom:2px">{{ Str::limit($foto->judul, 30) }}</div>
                <div style="margin-bottom:6px"><span class="badge badge--emas" style="font-size:0.62rem">{{ $kategoriList[$foto->kategori] ?? $foto->kategori }}</span></div>
                {{-- <div style="display:flex;gap:4px">
                    <form action="{{ route('operator.galeri.toggle', $foto) }}" method="POST" style="flex:1">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-sm {{ $foto->is_active ? 'btn-sm--view' : 'btn-sm--edit' }}"
                                style="width:100%;justify-content:center;font-size:0.68rem">
                            {{ $foto->is_active ? '🙈' : '👁️' }}
                        </button>
                    </form>
                    <form action="{{ route('operator.galeri.destroy', $foto) }}" method="POST" style="flex:1">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-sm btn-sm--hapus"
                                style="width:100%;justify-content:center;font-size:0.68rem"
                                onclick="return confirm('Hapus foto ini?')">🗑️</button>
                    </form>
                </div> --}}
            </div>
            @endforeach
        </div>
        @if($galeri->hasPages())
        <div class="admin-pagination">{{ $galeri->links('pagination::simple-default') }}</div>
        @endif
        @else
        <div style="padding:3rem;text-align:center;color:var(--teks-muted)">Belum ada foto. Upload sekarang →</div>
        @endif
    </div>

    {{-- FORM UPLOAD --}}
    <div class="admin-card" style="padding:1.25rem;position:sticky;top:70px">
        <div style="font-size:0.875rem;font-weight:600;color:var(--teks);margin-bottom:1.25rem">📤 Upload Foto Baru</div>

        <form action="{{ route('operator.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Pilih Foto <span style="color:red">*</span></label>
                <input type="file" name="foto" accept="image/*" class="form-control"
                       style="padding:0.5rem" id="galeriInput" required>
                <img id="galeriPreview" class="foto-preview" alt="Preview">
                <p style="font-size:0.72rem;color:var(--teks-muted);margin-top:4px">JPG/PNG/WebP, maks. 3MB</p>
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Judul Foto <span style="color:red">*</span></label>
                <input type="text" name="judul" class="form-control"
                       value="{{ old('judul') }}" placeholder="Contoh: Gotong Royong Desa" required>
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control">
                    @foreach($kategoriList as $key => $label)
                    @if($key !== 'umum')
                    <option value="{{ $key }}">{{ $label }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:1.25rem">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"
                          placeholder="Opsional...">{{ old('keterangan') }}</textarea>
            </div>
            <button type="submit" class="btn btn--primary" style="font-size:0.82rem;padding:0.7rem">
                📤 Upload Foto
            </button>
        </form>

        @if($errors->any())
        <div class="alert alert--error" style="margin-top:1rem">
            @foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach
        </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
document.getElementById('galeriInput')?.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        const p = document.getElementById('galeriPreview');
        p.src = ev.target.result;
        p.classList.add('show');
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
