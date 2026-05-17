@extends('operator.layouts.operator')
@section('title', 'Kelola Pengajuan Surat')
@section('page-title', 'Pengajuan Surat Masuk')

@section('content')

{{-- Ringkasan status --}}
<div class="admin-stat-grid" style="margin-bottom:1.5rem">
    @foreach([
        ['menunggu', '⏳', 'Menunggu',  'admin-stat-card__icon--emas'],
        ['diproses', '🔄', 'Diproses',  'admin-stat-card__icon--hijau'],
        ['selesai',  '✅', 'Selesai',   'admin-stat-card__icon--hijau'],
        ['ditolak',  '❌', 'Ditolak',   'admin-stat-card__icon--merah'],
    ] as [$st, $ikon, $label, $cls])
    <a href="{{ route('operator.layanan.index', ['status' => $st]) }}"
       style="text-decoration:none" class="admin-stat-card">
        <div class="admin-stat-card__icon {{ $cls }}">{{ $ikon }}</div>
        <div>
            <div class="admin-stat-card__num">{{ $ringkasan[$st] }}</div>
            <div class="admin-stat-card__lbl">{{ $label }}</div>
        </div>
    </a>
    @endforeach
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <div class="admin-card__title">Daftar Pengajuan ({{ $pengajuan->total() }})</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <form action="{{ route('operator.layanan.index') }}" method="GET" style="display:flex;gap:6px;flex-wrap:wrap">
                <input type="text" name="cari" value="{{ $cari }}" class="form-control"
                       placeholder="Nama / NIK / No. Ref..." style="width:190px;padding:0.4rem 0.75rem">
                <select name="jenis" class="form-control" style="width:180px;padding:0.4rem 0.75rem">
                    <option value="">Semua Jenis</option>
                    @foreach($daftarJenis as $key => $label)
                    <option value="{{ $key }}" {{ $jenis === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-control" style="width:130px;padding:0.4rem 0.75rem">
                    <option value="">Semua Status</option>
                    @foreach(['menunggu'=>'Menunggu','diproses'=>'Diproses','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $k=>$v)
                    <option value="{{ $k }}" {{ $status === $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
                <button class="btn-sm btn-sm--view" type="submit">Filter</button>
                @if($cari || $jenis || $status)
                <a href="{{ route('operator.layanan.index') }}" class="btn-sm btn-sm--hapus">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>No. Referensi</th>
                <th>Pemohon</th>
                <th>Jenis Surat</th>
                <th>Keperluan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $p)
            <tr>
                <td>
                    <div style="font-family:var(--font-ui);font-size:0.78rem;font-weight:700;color:var(--hijau);letter-spacing:0.04em">
                        {{ $p->nomor_referensi }}
                    </div>
                </td>
                <td>
                    <div style="font-weight:500;color:var(--teks)">{{ $p->nama_lengkap }}</div>
                    <div style="font-size:0.72rem;color:var(--teks-muted)">{{ $p->nik }}</div>
                </td>
                <td style="font-size:0.8rem;color:var(--teks-2)">{{ $p->label_jenis }}</td>
                <td style="font-size:0.8rem;color:var(--teks-2)">{{ Str::limit($p->keperluan, 40) }}</td>
                <td style="font-size:0.75rem;color:var(--teks-muted);white-space:nowrap">
                    {{ $p->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <span class="badge {{ $p->badge_status }}">{{ $p->label_status }}</span>
                </td>
                <td style="white-space:nowrap">
                    <a href="{{ route('operator.layanan.show', $p) }}" class="btn-sm btn-sm--view">👁️ Detail</a>
                    <a href="{{ route('operator.layanan.cetak', $p) }}" target="_blank" class="btn-sm btn-sm--edit">🖨️ Cetak</a>
                    {{-- <form action="{{ route('operator.layanan.destroy', $p) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-sm btn-sm--hapus"
                                onclick="return confirm('Hapus pengajuan ini?')">🗑️</button>
                    </form> --}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:3rem;color:var(--teks-muted)">
                    Belum ada pengajuan surat masuk.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($pengajuan->hasPages())
    <div class="admin-pagination">
        <span>{{ $pengajuan->firstItem() }}–{{ $pengajuan->lastItem() }} dari {{ $pengajuan->total() }}</span>
        {{ $pengajuan->withQueryString()->links('pagination::simple-default') }}
    </div>
    @endif
</div>

@endsection
