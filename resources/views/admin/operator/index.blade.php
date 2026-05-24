@extends('admin.layouts.admin')
@section('title', 'Kelola Operator')
@section('page-title', 'Kelola Akun Operator')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

    {{-- DAFTAR OPERATOR --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <div class="admin-card__title">Daftar Operator Desa ({{ $operators->count() }})</div>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Terakhir Login</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operators as $op)
                <tr>
                    <td>
                        <div style="font-weight:500;color:var(--teks)">{{ $op->nama }}</div>
                    </td>
                    <td style="font-family:monospace;font-size:0.82rem;color:var(--teks-2)">
                        {{ $op->username }}
                    </td>
                    <td>
                        @if($op->is_active)
                            <span class="badge badge--hijau">Aktif</span>
                        @else
                            <span class="badge badge--abu">Nonaktif</span>
                        @endif
                    </td>
                    <td style="font-size:0.75rem;color:var(--teks-muted)">
                        {{ $op->last_login_at ? $op->last_login_at->diffForHumans() : 'Belum pernah' }}
                    </td>
                    <td style="white-space:nowrap">
                        {{-- Toggle aktif/nonaktif --}}
                        <form action="{{ route('admin.operator.toggle', $op) }}" method="POST" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="btn-sm {{ $op->is_active ? 'btn-sm--hapus' : 'btn-sm--edit' }}"
                                    onclick="return confirm('{{ $op->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                                {{ $op->is_active ? '🔒 Nonaktifkan' : '🔓 Aktifkan' }}
                            </button>
                        </form>

                        {{-- Reset password --}}
                        <button class="btn-sm btn-sm--view"
                                onclick="document.getElementById('reset-{{ $op->id }}').classList.toggle('hidden')">
                            🔑 Reset Pass
                        </button>

                        {{-- Hapus --}}
                        <form action="{{ route('admin.operator.destroy', $op) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm btn-sm--hapus"
                                    onclick="return confirm('Hapus akun {{ $op->nama }}?')">
                                🗑️ Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- Form reset password (tersembunyi) --}}
                <tr id="reset-{{ $op->id }}" class="hidden">
                    <td colspan="5" style="background:#faf9f5;padding:0.75rem 1.25rem">
                        <form action="{{ route('admin.operator.reset-password', $op) }}" method="POST"
                              style="display:flex;gap:0.75rem;align-items:flex-end">
                            @csrf @method('PATCH')
                            <div style="flex:1">
                                <label class="form-label" style="margin-bottom:4px">Password Baru untuk {{ $op->nama }}</label>
                                <input type="text" name="password_baru" class="form-control"
                                       placeholder="Minimal 6 karakter" style="padding:0.4rem 0.75rem" required>
                            </div>
                            <button type="submit" class="btn-sm btn-sm--edit" style="padding:0.5rem 1rem">
                                💾 Simpan
                            </button>
                            <button type="button" class="btn-sm btn-sm--hapus" style="padding:0.5rem 1rem"
                                    onclick="document.getElementById('reset-{{ $op->id }}').classList.add('hidden')">
                                Batal
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:3rem;color:var(--teks-muted)">
                        Belum ada akun operator. Buat akun pertama di form sebelah →
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FORM TAMBAH OPERATOR --}}
    <div class="admin-card" style="padding:1.25rem;position:sticky;top:70px">
        <div style="font-size:0.875rem;font-weight:600;color:var(--teks);margin-bottom:1.25rem">
            ➕ Tambah Akun Operator
        </div>

        <form action="{{ route('admin.operator.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Username <span style="color:red">*</span></label>
                <input type="text" name="username" class="form-control"
                       value="{{ old('username') }}" placeholder="Contoh: operator_budi" required>
                <p style="font-size:0.72rem;color:var(--teks-muted);margin-top:3px">
                    Huruf, angka, underscore, dan dash saja.
                </p>
            </div>
            <div class="form-group" style="margin-bottom:1.25rem">
                <label class="form-label">Password <span style="color:red">*</span></label>
                <input type="text" name="password" class="form-control"
                       placeholder="Minimal 6 karakter" required>
            </div>
            <button type="submit" class="btn btn--primary" style="font-size:0.82rem;padding:0.7rem">
                ➕ Buat Akun Operator
            </button>
        </form>

        @if($errors->any())
        <div class="alert alert--error" style="margin-top:1rem">
            @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
        </div>
        @endif

        <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--border)">
            <div style="font-family:var(--font-ui);font-size:0.72rem;color:var(--teks-muted);line-height:1.7">
                <strong style="color:var(--teks-2)">Operator dapat:</strong><br>
                ✅ Tulis & edit berita<br>
                ✅ Proses pengajuan surat<br>
                ✅ Baca pesan masuk<br>
                <br>
                <strong style="color:var(--teks-2)">Operator tidak dapat:</strong><br>
                ❌ Hapus berita/foto/pesan<br>
                ❌ Edit data statistik<br>
                ❌ Kelola akun operator<br>
            </div>
        </div>
    </div>

</div>

<style>
    .hidden { display: none; }
</style>

@endsection
