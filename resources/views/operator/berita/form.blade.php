@extends('operator.layouts.operator')
@section('title', isset($berita) ? 'Edit Berita' : 'Tulis Berita')
@section('page-title', isset($berita) ? 'Edit Berita' : 'Tulis Berita Baru')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
<style>
    .ql-container {
        font-family: 'Lora', Georgia, serif;
        font-size: 0.95rem;
        min-height: 320px;
        border-bottom-left-radius: var(--radius);
        border-bottom-right-radius: var(--radius);
        border-color: var(--border) !important;
    }
    .ql-toolbar {
        border-top-left-radius: var(--radius);
        border-top-right-radius: var(--radius);
        border-color: var(--border) !important;
        background: #faf9f5;
        font-family: var(--font-ui);
    }
    .ql-editor {
        min-height: 320px;
        color: var(--teks);
        line-height: 1.8;
    }
    .ql-editor p { margin-bottom: 0.75rem; }
    .ql-editor.ql-blank::before {
        color: var(--teks-muted);
        font-style: normal;
        font-family: var(--font-ui);
        font-size: 0.875rem;
    }
    .ql-snow .ql-stroke { stroke: var(--teks-2); }
    .ql-snow .ql-fill  { fill:   var(--teks-2); }
    .ql-snow.ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button.ql-active .ql-stroke { stroke: var(--hijau); }
    .ql-snow.ql-toolbar button:hover .ql-fill,
    .ql-snow.ql-toolbar button.ql-active .ql-fill   { fill:   var(--hijau); }
</style>
@endpush

@section('content')

<form action="{{ isset($berita) ? route('operator.berita.update', $berita) : route('operator.berita.store') }}"
      method="POST" enctype="multipart/form-data" id="beritaForm">
    @csrf
    @if(isset($berita)) @method('PUT') @endif

    {{-- Field tersembunyi untuk menyimpan isi dari Quill --}}
    <input type="hidden" name="isi" id="isiHidden">

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

        {{-- ===== KOLOM KIRI ===== --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Judul --}}
            <div class="admin-card" style="padding:1.25rem">
                <div class="form-group">
                    <label class="form-label">Judul Berita <span style="color:red">*</span></label>
                    <input type="text" name="judul" class="form-control"
                           value="{{ old('judul', $berita->judul ?? '') }}"
                           placeholder="Tulis judul berita yang menarik..." required>
                </div>
            </div>

            {{-- Editor Quill --}}
            <div class="admin-card" style="padding:1.25rem">
                <label class="form-label" style="margin-bottom:0.6rem;display:block">
                    Isi Berita <span style="color:red">*</span>
                </label>
                <div id="quillEditor">
                    {!! old('isi', $berita->isi ?? '') !!}
                </div>
                @error('isi')
                    <p style="color:#b91c1c;font-size:0.78rem;margin-top:6px">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- ===== KOLOM KANAN ===== --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Publish --}}
            <div class="admin-card" style="padding:1.25rem">
                <div style="font-size:0.8rem;font-weight:600;color:var(--teks);margin-bottom:1rem">
                    Pengaturan Tayang
                </div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem">
                    <input type="checkbox" name="is_published" id="is_published" value="1"
                           {{ old('is_published', $berita->is_published ?? true) ? 'checked' : '' }}
                           style="width:16px;height:16px;accent-color:var(--hijau);cursor:pointer">
                    <label for="is_published" style="font-size:0.82rem;color:var(--teks-2);cursor:pointer">
                        Tayangkan langsung
                    </label>
                </div>
                <button type="submit" class="btn btn--primary" style="font-size:0.85rem;padding:0.7rem 1rem">
                    💾 {{ isset($berita) ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
                </button>
                <a href="{{ route('operator.berita.index') }}"
                   style="display:block;text-align:center;margin-top:0.75rem;font-size:0.78rem;color:var(--teks-muted)">
                    Batal
                </a>
            </div>

            {{-- Kategori & Penulis --}}
            <div class="admin-card" style="padding:1.25rem">
                <div class="form-group" style="margin-bottom:1rem">
                    <label class="form-label">Kategori <span style="color:red">*</span></label>
                    <select name="kategori" class="form-control" required>
                        @foreach($kategoriList as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('kategori', $berita->kategori ?? 'umum') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control"
                           value="{{ old('penulis', $berita->penulis ?? 'Operator Desa') }}">
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="admin-card" style="padding:1.25rem">
                <div class="form-group">
                    <label class="form-label">Ringkasan</label>
                    <textarea name="ringkasan" class="form-control" rows="3"
                              placeholder="Opsional. Jika kosong, otomatis diambil dari awal isi berita.">{{ old('ringkasan', $berita->ringkasan ?? '') }}</textarea>
                    <p style="font-size:0.72rem;color:var(--teks-muted);margin-top:4px">Maks. 500 karakter</p>
                </div>
            </div>

            {{-- Foto --}}
            <div class="admin-card" style="padding:1.25rem">
                <div class="form-group">
                    <label class="form-label">Galeri Foto Berita</label>
                    @if(isset($berita) && $berita->images->count() > 0)
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem">
                            @foreach($berita->images as $img)
                            <div style="border:1px solid var(--border);border-radius:var(--radius);padding:0.5rem;text-align:center;background:#fff">
                                <img src="{{ $img->foto_url }}" style="width:100%;height:80px;object-fit:cover;border-radius:4px;margin-bottom:0.5rem">
                                <div style="display:flex;flex-direction:column;gap:5px;font-size:0.75rem;text-align:left">
                                    <label style="cursor:pointer;display:flex;align-items:center;gap:4px">
                                        <input type="radio" name="utama_foto" value="{{ $img->id }}" {{ $img->is_utama ? 'checked' : '' }} style="accent-color:var(--hijau)"> Utama
                                    </label>
                                    <label style="cursor:pointer;display:flex;align-items:center;gap:4px;color:#b91c1c">
                                        <input type="checkbox" name="delete_fotos[]" value="{{ $img->id }}"> Hapus
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @elseif(isset($berita) && $berita->foto)
                        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:0.5rem;text-align:center;background:#fff;margin-bottom:1rem">
                            <img src="{{ $berita->foto_url }}" style="width:100%;height:100px;object-fit:cover;border-radius:4px;margin-bottom:0.5rem">
                            <span style="font-size:0.75rem;color:var(--teks-muted)">Foto Lama (Bawaan)</span>
                        </div>
                    @endif

                    <label class="form-label">Upload Foto Baru (Bisa Lebih Dari 1)</label>
                    <input type="file" name="fotos[]" multiple accept="image/*" class="form-control"
                           style="padding:0.5rem" id="fotoInput">
                    <p style="font-size:0.72rem;color:var(--teks-muted);margin-top:4px">
                        Pilih beberapa foto sekaligus. JPG/PNG/WebP, maks. 2MB.
                    </p>
                </div>
            </div>

        </div>
    </div>
</form>

@if($errors->any())
<div class="alert alert--error" style="margin-top:1rem">
    <ul style="margin:0;padding-left:1.25rem">
        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---- Init Quill Editor ----
    var quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Tulis isi berita lengkap di sini...',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    // ---- Sinkronisasi isi Quill ke hidden input saat submit ----
    document.getElementById('beritaForm').addEventListener('submit', function (e) {
        var isiHtml = quill.root.innerHTML;

        // Cek apakah editor kosong
        if (quill.getText().trim().length === 0) {
            e.preventDefault();
            quill.root.style.border = '1.5px solid #b91c1c';
            quill.root.focus();
            // Tampilkan pesan error
            var errEl = quill.root.parentNode.parentNode.querySelector('.quill-error');
            if (!errEl) {
                var err = document.createElement('p');
                err.className = 'quill-error';
                err.style.cssText = 'color:#b91c1c;font-size:0.78rem;margin-top:6px';
                err.textContent = 'Isi berita wajib diisi.';
                quill.root.parentNode.parentNode.appendChild(err);
            }
            return;
        }

        document.getElementById('isiHidden').value = isiHtml;
    });

    // ---- Preview foto ----
    document.getElementById('fotoInput')?.addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            var preview = document.getElementById('fotoPreview');
            preview.src = ev.target.result;
            preview.classList.add('show');
        };
        reader.readAsDataURL(file);
    });

});
</script>
@endpush
