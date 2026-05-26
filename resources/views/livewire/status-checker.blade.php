<div style="display:grid;gap:1.5rem">
    {{-- Search Form --}}
    <div style="background:#fff;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:1.5rem;animation:fadeIn 0.6s ease-out">
        <h2 style="font-family:var(--font-display);font-size:1.5rem;font-weight:700;color:var(--teks);margin-bottom:1rem">Cek Status Pengajuan Surat</h2>

        <form wire:submit="cekStatus" style="display:grid;gap:1rem">
            <div>
                <label style="display:block;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:0.5rem">
                    Nomor Referensi
                </label>
                <div style="display:flex;gap:0.5rem">
                    <input type="text"
                           wire:model="nomorReferensi"
                           placeholder="Contoh: SKD-2025-ABC12"
                           style="flex:1;padding:0.5rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-family:var(--font-ui);text-transform:uppercase;transition:all 0.3s ease-out"
                           autocomplete="off">
                    <button type="submit"
                            style="padding:0.5rem 1.5rem;background:var(--emas);color:#fff;border-radius:var(--radius);font-family:var(--font-ui);font-weight:600;border:none;cursor:pointer;transition:all 0.3s ease-out"
                            onmouseover="this.style.background='var(--emas-dark)';this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.background='var(--emas)';this.style.transform='translateY(0)'"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Cek Status</span>
                        <span wire:loading style="display:flex;align-items:center;justify-content:center;gap:0.5rem">
                            <svg style="width:1rem;height:1rem;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mencari...
                        </span>
                    </button>
                </div>
                @error('nomorReferensi')
                    <p style="color:#ef4444;font-family:var(--font-ui);font-size:0.75rem;margin-top:0.25rem">{{ $message }}</p>
                @enderror
            </div>
        </form>

        {{-- Reset Button --}}
        @if ($searched)
            <button wire:click="resetSearch"
                    style="margin-top:1rem;padding:0.5rem 1rem;background:#e5e7eb;color:var(--teks);border-radius:var(--radius);font-family:var(--font-ui);font-size:0.8rem;border:none;cursor:pointer;transition:all 0.3s ease-out"
                    onmouseover="this.style.background='#d1d5db'"
                    onmouseout="this.style.background='#e5e7eb'">
                Cari Lagi
            </button>
        @endif
    </div>

    {{-- Status Result --}}
    @if ($searched)
        @if ($pengajuan)
            <div style="background:#fff;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:1.5rem;animation:fadeInUp 0.6s ease-out">
                {{-- Header --}}
                <div style="border-bottom:1px solid var(--border);padding-bottom:1rem;margin-bottom:1rem">
                    <h3 style="font-family:var(--font-display);font-size:1.25rem;font-weight:700;color:var(--teks)">Hasil Pencarian</h3>
                </div>

                {{-- Status Badge --}}
                <div style="margin-bottom:1.5rem">
                    <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted);margin-bottom:0.5rem">Status Pengajuan:</p>
                    <div style="display:inline-block">
                        <span style="padding:0.5rem 1rem;border-radius:9999px;font-weight:600;color:#fff;
                            @if ($pengajuan->status === 'menunggu')
                                background:#eab308
                            @elseif ($pengajuan->status === 'diproses_operator')
                                background:var(--emas)
                            @elseif ($pengajuan->status === 'menunggu_validasi_kades')
                                background:#a855f7
                            @elseif ($pengajuan->status === 'disetujui')
                                background:#22c55e
                            @elseif ($pengajuan->status === 'ditolak')
                                background:#ef4444
                            @endif
                        ">
                            {{ $pengajuan->label_status }}
                        </span>
                    </div>
                </div>

                {{-- Timeline --}}
                <div style="display:grid;gap:1rem;margin-bottom:1.5rem">
                    {{-- Submitted --}}
                    <div style="display:flex;gap:1rem">
                        <div style="display:flex;flex-direction:column;align-items:center">
                            <div style="width:2rem;height:2rem;border-radius:50%;background:#22c55e;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold">
                                ✓
                            </div>
                            <div style="width:2px;height:3rem;background:#d1d5db;margin-top:0.5rem"></div>
                        </div>
                        <div>
                            <p style="font-family:var(--font-ui);font-weight:600;color:var(--teks)">Pengajuan Diterima</p>
                            <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">{{ $pengajuan->tanggal_pengajuan }}</p>
                        </div>
                    </div>

                    {{-- Processing --}}
                    <div style="display:flex;gap:1rem">
                        <div style="display:flex;flex-direction:column;align-items:center">
                            <div style="width:2rem;height:2rem;border-radius:50%;
                                @if (in_array($pengajuan->status, ['diproses_operator', 'menunggu_validasi_kades', 'disetujui', 'ditolak']))
                                    background:#22c55e;color:#fff
                                @else
                                    background:#d1d5db;color:#6b7280
                                @endif
                                ;display:flex;align-items:center;justify-content:center;font-weight:bold">
                                @if (in_array($pengajuan->status, ['diproses_operator', 'menunggu_validasi_kades', 'disetujui', 'ditolak']))
                                    ✓
                                @else
                                    ⏳
                                @endif
                            </div>
                            <div style="width:2px;height:3rem;background:#d1d5db;margin-top:0.5rem"></div>
                        </div>
                        <div>
                            <p style="font-family:var(--font-ui);font-weight:600;color:var(--teks)">Sedang Diproses</p>
                            @if ($pengajuan->diproses_at)
                                <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">{{ $pengajuan->diproses_at->format('d F Y, H:i') }} WIB</p>
                            @else
                                <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">Menunggu untuk diproses...</p>
                            @endif
                        </div>
                    </div>

                    {{-- Completed --}}
                    <div style="display:flex;gap:1rem">
                        <div style="display:flex;flex-direction:column;align-items:center">
                            <div style="width:2rem;height:2rem;border-radius:50%;
                                @if (in_array($pengajuan->status, ['disetujui', 'ditolak']))
                                    @if ($pengajuan->status === 'disetujui')
                                        background:#22c55e;color:#fff
                                    @else
                                        background:#ef4444;color:#fff
                                    @endif
                                @else
                                    background:#d1d5db;color:#6b7280
                                @endif
                                ;display:flex;align-items:center;justify-content:center;font-weight:bold">
                                @if ($pengajuan->status === 'disetujui')
                                    ✓
                                @elseif ($pengajuan->status === 'ditolak')
                                    ✕
                                @else
                                    ⏳
                                @endif
                            </div>
                        </div>
                        <div>
                            <p style="font-family:var(--font-ui);font-weight:600;color:var(--teks)">
                                @if ($pengajuan->status === 'disetujui')
                                    Disetujui
                                @elseif ($pengajuan->status === 'ditolak')
                                    Ditolak
                                @else
                                    Menunggu Hasil
                                @endif
                            </p>
                            @if ($pengajuan->selesai_at)
                                <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">{{ $pengajuan->selesai_at->format('d F Y, H:i') }} WIB</p>
                            @else
                                <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">Proses masih berlangsung...</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Details --}}
                <div style="background:#f9fafb;border-radius:var(--radius);padding:1rem;display:grid;gap:0.75rem">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div>
                            <p style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);font-weight:600;text-transform:uppercase">Nomor Referensi</p>
                            <p style="font-family:monospace;font-size:1.1rem;font-weight:700;color:var(--teks)">{{ $pengajuan->nomor_referensi }}</p>
                        </div>
                        <div>
                            <p style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);font-weight:600;text-transform:uppercase">Jenis Surat</p>
                            <p style="font-family:var(--font-ui);font-size:1.1rem;font-weight:600;color:var(--teks)">{{ $pengajuan->label_jenis }}</p>
                        </div>
                        <div>
                            <p style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);font-weight:600;text-transform:uppercase">Nama Pemohon</p>
                            <p style="font-family:var(--font-ui);font-size:1.1rem;font-weight:600;color:var(--teks)">{{ $pengajuan->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);font-weight:600;text-transform:uppercase">NIK</p>
                            <p style="font-family:monospace;font-size:1.1rem;font-weight:700;color:var(--teks)">{{ $pengajuan->nik }}</p>
                        </div>
                    </div>

                    {{-- Catatan Admin (jika ada) --}}
                    @if ($pengajuan->catatan_admin)
                        <div style="border-top:1px solid var(--border);padding-top:0.75rem;margin-top:0.75rem">
                            <p style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);font-weight:600;text-transform:uppercase">Catatan Admin</p>
                            <p style="font-family:var(--font-ui);color:var(--teks);margin-top:0.25rem">{{ $pengajuan->catatan_admin }}</p>
                        </div>
                    @endif
                </div>

                {{-- Action Buttons --}}
                @if ($pengajuan->status === 'disetujui')
                    <div style="margin-top:1.5rem;display:flex;gap:0.75rem">
                        <a href="{{ route('layanan.cek-status', ['nomor' => $pengajuan->nomor_referensi]) }}"
                           style="flex:1;padding:0.5rem 1rem;background:#22c55e;color:#fff;border-radius:var(--radius);font-family:var(--font-ui);font-weight:600;text-align:center;text-decoration:none;transition:all 0.3s ease-out"
                           onmouseover="this.style.background='#16a34a';this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.background='#22c55e';this.style.transform='translateY(0)'">
                            Cetak Surat
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div style="background:#fff;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:1.5rem;animation:fadeInUp 0.6s ease-out">
                <div style="text-align:center;padding:2rem 0">
                    <svg style="width:4rem;height:4rem;color:#d1d5db;margin:0 auto 1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p style="font-family:var(--font-display);font-size:1rem;color:var(--teks-2);font-weight:600">Pengajuan Tidak Ditemukan</p>
                    <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted);margin-top:0.25rem">Periksa kembali nomor referensi Anda</p>
                </div>
            </div>
        @endif
    @endif
</div>
