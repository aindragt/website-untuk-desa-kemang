@extends('admin.layouts.admin')
@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')

@section('content')
<div style="max-width:640px">
    <div class="admin-card" style="padding:1.75rem">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;padding-bottom:1.25rem;border-bottom:1px solid #e8e4d8">
            <div style="width:48px;height:48px;border-radius:50%;background:var(--krem);border:2px solid var(--emas);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--hijau);flex-shrink:0">
                {{ strtoupper(substr($pesan->nama, 0, 1)) }}
            </div>
            <div>
                <div style="font-family:var(--font-display);font-size:1rem;color:var(--teks)">{{ $pesan->nama }}</div>
                <div style="font-size:0.8rem;color:var(--teks-muted)">{{ $pesan->kontak }}</div>
            </div>
            <div style="margin-left:auto;font-size:0.75rem;color:var(--teks-muted)">
                {{ $pesan->created_at->translatedFormat('d F Y, H:i') }} WIB
            </div>
        </div>

        <p style="font-size:0.95rem;color:var(--teks);line-height:1.8;white-space:pre-wrap">{{ $pesan->pesan }}</p>

        <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #e8e4d8;display:flex;gap:0.75rem">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesan->kontak) }}" target="_blank"
               class="btn-sm btn-sm--edit">💬 Balas via WhatsApp</a>
            <a href="mailto:{{ $pesan->kontak }}"
               class="btn-sm btn-sm--view">✉️ Balas via Email</a>
            <form action="{{ route('admin.pesan.destroy', $pesan) }}" method="POST" style="margin-left:auto">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-sm--hapus"
                        onclick="return confirm('Hapus pesan ini?')">🗑️ Hapus</button>
            </form>
        </div>
    </div>

    <div style="margin-top:1rem">
        <a href="{{ route('admin.pesan.index') }}" style="font-size:0.82rem;color:var(--teks-muted)">
            ← Kembali ke daftar pesan
        </a>
    </div>
</div>
@endsection
