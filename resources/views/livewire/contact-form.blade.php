<div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
    {{-- Success Message --}}
    @if ($submitted)
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg animate-fade-in-up">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold text-green-800">Pesan Berhasil Dikirim!</p>
                    <p class="text-sm text-green-700">Kami akan segera menghubungi Anda.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit="submit" class="space-y-4">
        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Lengkap
            </label>
            <input type="text"
                   wire:model="nama"
                   placeholder="Masukkan nama Anda"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all
                   @error('nama') border-red-500 @enderror"
                   @if ($submitted) disabled @endif>
            @error('nama')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kontak --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email atau WhatsApp
            </label>
            <input type="text"
                   wire:model="kontak"
                   placeholder="Contoh: email@example.com atau 08123456789"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all
                   @error('kontak') border-red-500 @enderror"
                   @if ($submitted) disabled @endif>
            @error('kontak')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Pesan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Pesan
            </label>
            <textarea wire:model="pesan"
                      placeholder="Tulis pesan Anda di sini..."
                      rows="5"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none
                      @error('pesan') border-red-500 @enderror"
                      @if ($submitted) disabled @endif></textarea>
            <div class="flex items-center justify-between mt-1">
                <p class="text-xs text-gray-500">Maksimal 2000 karakter</p>
                <p class="text-xs text-gray-500">{{ strlen($pesan) }}/2000</p>
            </div>
            @error('pesan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="flex gap-3 pt-4">
            <button type="submit"
                    class="flex-1 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium btn-hover-lift"
                    wire:loading.attr="disabled"
                    @if ($submitted) disabled @endif>
                <span wire:loading.remove>Kirim Pesan</span>
                <span wire:loading class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengirim...
                </span>
            </button>

            @if ($submitted)
                <button type="button"
                        @click="$wire.submitted = false; $wire.reset()"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Kirim Lagi
                </button>
            @endif
        </div>
    </form>
</div>
