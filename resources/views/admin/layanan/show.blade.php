@extends('admin.layouts.admin')
@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Surat')

@section('content')

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

    {{-- KOLOM KIRI: Data pemohon --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- Header pengajuan --}}
        <div class="admin-card" style="padding:1.25rem">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem">
                <div>
                    <div style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px">Nomor Referensi</div>
                    <div style="font-family:var(--font-display);font-size:1.5rem;color:var(--hijau);font-weight:700;letter-spacing:0.04em">
                        {{ $layanan->nomor_referensi }}
                    </div>
                </div>
                <div style="text-align:right">
                    <span class="badge {{ $layanan->badge_status }}" style="font-size:0.8rem;padding:4px 14px">
                        {{ $layanan->label_status }}
                    </span>
                    <div style="font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted);margin-top:4px">
                        {{ $layanan->tanggal_pengajuan }}
                    </div>
                </div>
            </div>
            <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid var(--border)">
                <span style="font-family:var(--font-ui);font-size:0.78rem;font-weight:600;color:var(--teks)">{{ $layanan->label_jenis }}</span>
                <span style="font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted);margin-left:8px">· Keperluan: {{ $layanan->keperluan }}</span>
            </div>
        </div>

        {{-- Data Diri --}}
        <div class="admin-card" style="padding:1.25rem">
            <div style="font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:1rem">📋 Data Diri Pemohon</div>
            @php
            $rows = [
                ['Nama Lengkap',   $layanan->nama_lengkap],
                ['NIK',            $layanan->nik],
                ['Tempat / Tgl Lahir', $layanan->tempat_lahir . ', ' . $layanan->tanggal_lahir_format . ' (' . $layanan->umur . ' tahun)'],
                ['Jenis Kelamin',  $layanan->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                ['Agama',          $layanan->agama],
                ['Pekerjaan',      $layanan->pekerjaan],
                ['Alamat',         $layanan->alamat],
                ['No. HP',         $layanan->no_hp],
            ];
            if ($layanan->jenis_surat === 'usaha') {
                $rows[] = ['Nama Usaha',  $layanan->nama_usaha ?? '-'];
                $rows[] = ['Jenis Usaha', $layanan->jenis_usaha ?? '-'];
            }
            if ($layanan->keterangan_tambahan) {
                $rows[] = ['Keterangan Tambahan', $layanan->keterangan_tambahan];
            }
            @endphp
            @foreach($rows as [$label, $nilai])
            <div style="display:flex;gap:1rem;padding:0.55rem 0;border-bottom:0.5px solid var(--border);font-family:var(--font-ui);font-size:0.82rem">
                <span style="color:var(--teks-muted);width:170px;flex-shrink:0">{{ $label }}</span>
                <span style="color:var(--teks);font-weight:500">{{ $nilai }}</span>
            </div>
            @endforeach
        </div>

        {{-- Timeline status --}}
        <div class="admin-card" style="padding:1.25rem">
            <div style="font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:1rem">📅 Riwayat Status</div>
            <div style="display:flex;flex-direction:column;gap:0.75rem">
                <div style="display:flex;gap:10px;align-items:flex-start">
                    <div style="width:8px;height:8px;border-radius:50%;background:var(--hijau);margin-top:5px;flex-shrink:0"></div>
                    <div>
                        <div style="font-family:var(--font-ui);font-size:0.8rem;font-weight:500;color:var(--teks)">Pengajuan Diterima</div>
                        <div style="font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted)">{{ $layanan->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                    </div>
                </div>
                @if($layanan->diproses_at)
                <div style="display:flex;gap:10px;align-items:flex-start">
                    <div style="width:8px;height:8px;border-radius:50%;background:var(--emas);margin-top:5px;flex-shrink:0"></div>
                    <div>
                        <div style="font-family:var(--font-ui);font-size:0.8rem;font-weight:500;color:var(--teks)">Mulai Diproses</div>
                        <div style="font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted)">{{ $layanan->diproses_at->translatedFormat('d F Y, H:i') }} WIB</div>
                    </div>
                </div>
                @endif
                @if($layanan->selesai_at)
                <div style="display:flex;gap:10px;align-items:flex-start">
                    <div style="width:8px;height:8px;border-radius:50%;background:var(--hijau);margin-top:5px;flex-shrink:0"></div>
                    <div>
                        <div style="font-family:var(--font-ui);font-size:0.8rem;font-weight:500;color:var(--teks)">Selesai</div>
                        <div style="font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted)">{{ $layanan->selesai_at->translatedFormat('d F Y, H:i') }} WIB</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN: Ubah status --}}
    <div style="position:sticky;top:70px;display:flex;flex-direction:column;gap:1rem">

        {{-- Form ubah status --}}
        <div class="admin-card" style="padding:1.25rem">
            <div style="font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:1rem">🔄 Validasi Pengajuan (Kepala Desa)</div>

            <form action="{{ route('admin.layanan.status', $layanan) }}" method="POST">
                @csrf @method('PATCH')
                <div class="form-group" style="margin-bottom:0.75rem">
                    <label class="form-label">Tindakan</label>
                    <select name="status" class="form-control">
                        @foreach(['menunggu_validasi_kades'=>'⏱️ Menunggu Validasi','disetujui'=>'✅ Setuju / Sahkan','ditolak'=>'❌ Tolak'] as $k=>$v)
                        <option value="{{ $k }}" {{ $layanan->status === $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:1rem">
                    <label class="form-label">Catatan Kades</label>
                    <textarea name="catatan_admin" class="form-control" rows="3"
                              placeholder="Opsional. Misal: catatan revisi, alasan penolakan, dll.">{{ $layanan->catatan_admin }}</textarea>
                </div>
                <button type="submit" class="btn btn--primary" style="font-size:0.82rem;padding:0.7rem">
                    💾 Simpan Keputusan
                </button>
            </form>
        </div>

        {{-- Aksi --}}
        <div class="admin-card" style="padding:1.25rem;display:flex;flex-direction:column;gap:0.75rem">
            @if($layanan->status === 'disetujui')
            <a href="{{ route('admin.layanan.cetak', $layanan) }}" target="_blank"
               class="btn-sm btn-sm--edit" style="justify-content:center;padding:0.6rem">
                🖨️ Cetak Surat
            </a>
            @endif
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $layanan->no_hp) }}" target="_blank"
               class="btn-sm" style="background:#25D366;color:#fff;justify-content:center;padding:0.6rem">
                💬 WhatsApp Pemohon
            </a>
            <form action="{{ route('admin.layanan.destroy', $layanan) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-sm--hapus" style="width:100%;justify-content:center;padding:0.6rem"
                        onclick="return confirm('Hapus pengajuan ini permanen?')">
                    🗑️ Hapus Pengajuan
                </button>
            </form>
        </div>

        <a href="{{ route('admin.layanan.index') }}"
           style="font-family:var(--font-ui);font-size:0.78rem;color:var(--teks-muted);text-align:center">
            ← Kembali ke daftar
        </a>
    </div>

</div>

@endsection
