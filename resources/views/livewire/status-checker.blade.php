<div class="space-y-6">
    {{-- Search Form --}}
    <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Cek Status Pengajuan Surat</h2>

        <form wire:submit="cekStatus" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Referensi
                </label>
                <div class="flex gap-2">
                    <input type="text"
                           wire:model="nomorReferensi"
                           placeholder="Contoh: SKD-2025-ABC12"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all uppercase"
                           autocomplete="off">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium btn-hover-lift"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Cek Status</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mencari...
                        </span>
                    </button>
                </div>
                @error('nomorReferensi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </form>

        {{-- Reset Button --}}
        @if ($searched)
            <button wire:click="resetSearch"
                    class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                Cari Lagi
            </button>
        @endif
    </div>

    {{-- Status Result --}}
    @if ($searched)
        @if ($pengajuan)
            <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in-up">
                {{-- Header --}}
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Hasil Pencarian</h3>
                </div>

                {{-- Status Badge --}}
                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Status Pengajuan:</p>
                    <div class="inline-block">
                        <span class="px-4 py-2 rounded-full font-semibold text-white
                            @if ($pengajuan->status === 'menunggu')
                                bg-yellow-500
                            @elseif ($pengajuan->status === 'diproses_operator')
                                bg-blue-500
                            @elseif ($pengajuan->status === 'menunggu_validasi_kades')
                                bg-purple-500
                            @elseif ($pengajuan->status === 'disetujui')
                                bg-green-500
                            @elseif ($pengajuan->status === 'ditolak')
                                bg-red-500
                            @endif
                        ">
                            {{ $pengajuan->label_status }}
                        </span>
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="space-y-4 mb-6">
                    {{-- Submitted --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white">
                                ✓
                            </div>
                            <div class="w-0.5 h-12 bg-gray-300 mt-2"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Pengajuan Diterima</p>
                            <p class="text-sm text-gray-600">{{ $pengajuan->tanggal_pengajuan }}</p>
                        </div>
                    </div>

                    {{-- Processing --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full
                                @if (in_array($pengajuan->status, ['diproses_operator', 'menunggu_validasi_kades', 'disetujui', 'ditolak']))
                                    bg-green-500 text-white
                                @else
                                    bg-gray-300 text-gray-600
                                @endif
                                flex items-center justify-center">
                                @if (in_array($pengajuan->status, ['diproses_operator', 'menunggu_validasi_kades', 'disetujui', 'ditolak']))
                                    ✓
                                @else
                                    ⏳
                                @endif
                            </div>
                            <div class="w-0.5 h-12 bg-gray-300 mt-2"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Sedang Diproses</p>
                            @if ($pengajuan->diproses_at)
                                <p class="text-sm text-gray-600">{{ $pengajuan->diproses_at->format('d F Y, H:i') }} WIB</p>
                            @else
                                <p class="text-sm text-gray-600">Menunggu untuk diproses...</p>
                            @endif
                        </div>
                    </div>

                    {{-- Completed --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full
                                @if (in_array($pengajuan->status, ['disetujui', 'ditolak']))
                                    @if ($pengajuan->status === 'disetujui')
                                        bg-green-500 text-white
                                    @else
                                        bg-red-500 text-white
                                    @endif
                                @else
                                    bg-gray-300 text-gray-600
                                @endif
                                flex items-center justify-center">
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
                            <p class="font-semibold text-gray-900">
                                @if ($pengajuan->status === 'disetujui')
                                    Disetujui
                                @elseif ($pengajuan->status === 'ditolak')
                                    Ditolak
                                @else
                                    Menunggu Hasil
                                @endif
                            </p>
                            @if ($pengajuan->selesai_at)
                                <p class="text-sm text-gray-600">{{ $pengajuan->selesai_at->format('d F Y, H:i') }} WIB</p>
                            @else
                                <p class="text-sm text-gray-600">Proses masih berlangsung...</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Details --}}
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-600 uppercase font-semibold">Nomor Referensi</p>
                            <p class="text-lg font-mono font-bold text-gray-900">{{ $pengajuan->nomor_referensi }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase font-semibold">Jenis Surat</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengajuan->label_jenis }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase font-semibold">Nama Pemohon</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengajuan->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase font-semibold">NIK</p>
                            <p class="text-lg font-mono font-bold text-gray-900">{{ $pengajuan->nik }}</p>
                        </div>
                    </div>

                    {{-- Catatan Admin (jika ada) --}}
                    @if ($pengajuan->catatan_admin)
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <p class="text-xs text-gray-600 uppercase font-semibold">Catatan Admin</p>
                            <p class="text-gray-700 mt-1">{{ $pengajuan->catatan_admin }}</p>
                        </div>
                    @endif
                </div>

                {{-- Action Buttons --}}
                @if ($pengajuan->status === 'disetujui')
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('layanan.cek-status', ['nomor' => $pengajuan->nomor_referensi]) }}"
                           class="flex-1 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium text-center btn-hover-lift">
                            Cetak Surat
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in-up">
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg font-semibold">Pengajuan Tidak Ditemukan</p>
                    <p class="text-gray-400 text-sm mt-1">Periksa kembali nomor referensi Anda</p>
                </div>
            </div>
        @endif
    @endif
</div>
