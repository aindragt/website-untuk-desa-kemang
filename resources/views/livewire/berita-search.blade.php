<div class="space-y-6">
    {{-- Search & Filter Section --}}
    <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Search Input --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cari Berita
                </label>
                <input type="text"
                       wire:model.live="search"
                       placeholder="Ketik judul atau kata kunci..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            {{-- Category Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                </label>
                <select wire:model.live="kategori"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Reset Button --}}
        @if ($search || $kategori)
            <div class="mt-4">
                <button wire:click="resetSearch"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Reset Filter
                </button>
            </div>
        @endif
    </div>

    {{-- Results Info --}}
    <div class="text-sm text-gray-600">
        @if ($search || $kategori)
            Menampilkan hasil pencarian
            @if ($search)
                untuk "<strong>{{ $search }}</strong>"
            @endif
            @if ($kategori)
                di kategori "<strong>{{ $kategoriList[$kategori] ?? $kategori }}</strong>"
            @endif
        @else
            Menampilkan semua berita
        @endif
    </div>

    {{-- Loading State --}}
    <div wire:loading class="flex items-center justify-center py-8">
        <div class="animate-spin">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </div>
    </div>

    {{-- Berita Grid --}}
    <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($berita as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover animate-fade-in-up"
                 style="animation-delay: {{ $loop->index * 0.1 }}s">
                {{-- Image --}}
                <div class="relative h-48 bg-gray-200 overflow-hidden">
                    <img src="{{ $item->foto_url }}"
                         alt="{{ $item->judul }}"
                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                </div>

                {{-- Content --}}
                <div class="p-4">
                    {{-- Category Badge --}}
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full mb-2">
                        {{ $kategoriList[$item->kategori] ?? $item->kategori }}
                    </span>

                    {{-- Title --}}
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                        {{ $item->judul }}
                    </h3>

                    {{-- Summary --}}
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $item->ringkasan_auto }}
                    </p>

                    {{-- Meta --}}
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <span>{{ $item->penulis ?? 'Admin' }}</span>
                        <span>{{ $item->tanggal_format }}</span>
                    </div>

                    {{-- Read More Button --}}
                    <a href="{{ route('berita.show', $item->slug) }}"
                       class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-500 text-lg">Berita tidak ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
            </div>
        @endempty
    </div>

    {{-- Pagination --}}
    @if ($berita->hasPages())
        <div class="mt-8">
            {{ $berita->links() }}
        </div>
    @endif
</div>
