@extends('layouts.app')
@section('title', 'Ajukan ' . $judulSurat)

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Formulir Pengajuan</div>
        <h1>{{ $judulSurat }}</h1>
        <p class="page-header__desc">Isi formulir di bawah dengan data yang benar dan lengkap.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <a href="{{ route('layanan.index') }}">Layanan Surat</a>
            <span class="breadcrumb__sep">/</span>
            <span>{{ $judulSurat }}</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container" style="max-width:780px">

        @if($errors->any())
        <div class="alert alert--error" style="margin-bottom:1.5rem">
            <strong style="display:block;margin-bottom:0.4rem">Mohon periksa kembali:</strong>
            <ul style="margin:0;padding-left:1.25rem">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('layanan.submit', $jenis) }}" method="POST">
            @csrf

            {{-- ===== DATA DIRI ===== --}}
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.75rem;margin-bottom:1.5rem">
                <h3 style="font-family:var(--font-display);font-size:1rem;color:var(--teks);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
                    📋 Data Diri Pemohon
                </h3>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control"
                               value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP" required>
                    </div>

                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">NIK (Nomor Induk Kependudukan) <span style="color:red">*</span></label>
                        <input type="text" name="nik" class="form-control" maxlength="16"
                               value="{{ old('nik') }}" placeholder="16 digit angka sesuai KTP"
                               oninput="this.value=this.value.replace(/\D/g,'')" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tempat Lahir <span style="color:red">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control"
                               value="{{ old('tempat_lahir') }}" placeholder="Contoh: Pangkalan Kuras" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir <span style="color:red">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                               value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin <span style="color:red">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Agama <span style="color:red">*</span></label>
                        <select name="agama" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($agama as $ag)
                            <option value="{{ $ag }}" {{ old('agama') === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pekerjaan <span style="color:red">*</span></label>
                        <input type="text" name="pekerjaan" class="form-control"
                               value="{{ old('pekerjaan') }}" placeholder="Contoh: Petani, Wiraswasta" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. HP / WhatsApp <span style="color:red">*</span></label>
                        <input type="text" name="no_hp" class="form-control"
                               value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx"
                               oninput="this.value=this.value.replace(/[^0-9\-+]/g,'')" required>
                    </div>

                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Alamat Lengkap <span style="color:red">*</span></label>
                        <textarea name="alamat" class="form-control" rows="2"
                                  placeholder="Nama jalan, RT/RW, dusun" required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ===== KEPERLUAN KHUSUS ===== --}}
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.75rem;margin-bottom:1.5rem">
                <h3 style="font-family:var(--font-display);font-size:1rem;color:var(--teks);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
                    📄 Keperluan Surat
                </h3>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Keperluan / Tujuan Surat <span style="color:red">*</span></label>
                        <input type="text" name="keperluan" class="form-control"
                               value="{{ old('keperluan') }}"
                               placeholder="Contoh: Pembukaan rekening bank, Beasiswa, dll" required>
                    </div>

                    {{-- Field tambahan khusus surat usaha --}}
                    @if($jenis === 'usaha')
                    <div class="form-group">
                        <label class="form-label">Nama Usaha <span style="color:red">*</span></label>
                        <input type="text" name="nama_usaha" class="form-control"
                               value="{{ old('nama_usaha') }}" placeholder="Nama toko/usaha Anda" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Usaha <span style="color:red">*</span></label>
                        <input type="text" name="jenis_usaha" class="form-control"
                               value="{{ old('jenis_usaha') }}" placeholder="Contoh: Warung Sembako, Budidaya Ikan" required>
                    </div>
                    @endif

                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" class="form-control" rows="2"
                                  placeholder="Opsional — jika ada informasi tambahan yang perlu disampaikan">{{ old('keterangan_tambahan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ===== PERNYATAAN ===== --}}
            <div style="background:var(--krem);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1.5rem">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <input type="checkbox" id="pernyataan" required
                           style="width:16px;height:16px;margin-top:3px;accent-color:var(--hijau);flex-shrink:0">
                    <label for="pernyataan" style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-2);line-height:1.6;cursor:pointer">
                        Saya menyatakan bahwa semua data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.
                        Saya memahami bahwa data palsu dapat mengakibatkan pembatalan proses pengajuan.
                    </label>
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div style="display:flex;gap:1rem;align-items:center">
                <button type="submit" class="btn btn--primary" style="flex:1;font-size:0.9rem;padding:0.9rem">
                    📨 Kirim Pengajuan Surat
                </button>
                <a href="{{ route('layanan.index') }}"
                   style="font-family:var(--font-ui);font-size:0.82rem;color:var(--teks-muted)">Batal</a>
            </div>

        </form>
    </div>
</section>

@endsection
