<div>
    {{-- Search & Filter Section --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
            {{-- Search Input --}}
            <div style="grid-column:1/3">
                <label style="display:block;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:0.5rem">
                    Cari Berita
                </label>
                <input type="text"
                       wire:model.live="search"
                       placeholder="Ketik judul atau kata kunci..."
                       class="form-control"
                       style="width:100%">
            </div>

            {{-- Category Filter --}}
            <div>
                <label style="display:block;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:0.5rem">
                    Kategori
                </label>
                <select wire:model.live="kategori"
                        class="form-control"
                        style="width:100%">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Reset Button --}}
        @if ($search || $kategori)
            <div style="margin-top:1rem">
                <button wire:click="resetSearch"
                        class="btn btn--secondary"
                        style="width:auto;padding:0.5rem 1rem">
                    Reset Filter
                </button>
            </div>
        @endif
    </div>

    {{-- Results Info --}}
    <div style="font-family:var(--font-ui);font-size:0.85rem;color:var(--teks-muted);margin-bottom:1.5rem">
        @if ($search || $kategori)
            Menampilkan hasil pencarian
            @if ($search)
                untuk "<strong style="color:var(--teks)">{{ $search }}</strong>"
            @endif
            @if ($kategori)
                di kategori "<strong style="color:var(--teks)">{{ $kategoriList[$kategori] ?? $kategori }}</strong>"
            @endif
        @else
            Menampilkan semua berita
        @endif
    </div>

    {{-- Loading State --}}
    <div wire:loading style="display:flex;align-items:center;justify-content:center;padding:2rem">
        <div style="animation:spin 1s linear infinite">
            <svg style="width:2rem;height:2rem;color:var(--emas)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </div>
    </div>

    {{-- Berita Grid --}}
    <div wire:loading.remove style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem">
        @forelse ($berita as $item)
            <article class="berita-card" style="animation:fadeInUp 0.6s ease-out forwards;opacity:0" style="animation-delay:{{ $loop->index * 0.1 }}s">
                {{-- Image --}}
                <div style="position:relative;height:12rem;background:var(--krem);overflow:hidden">
                    <img src="{{ $item->foto_url }}"
                         alt="{{ $item->judul }}"
                         class="berita-card__thumb"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.3s ease-out">
                </div>

                {{-- Content --}}
                <div style="padding:1rem">
                    {{-- Category Badge --}}
                    <span style="display:inline-block;padding:0.25rem 0.75rem;background:var(--emas);color:#fff;font-family:var(--font-ui);font-size:0.7rem;font-weight:600;border-radius:var(--radius);margin-bottom:0.5rem">
                        {{ $kategoriList[$item->kategori] ?? $item->kategori }}
                    </span>

                    {{-- Title --}}
                    <h3 style="font-family:var(--font-display);font-size:0.95rem;color:var(--teks);margin-bottom:0.5rem;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                        {{ $item->judul }}
                    </h3>

                    {{-- Summary --}}
                    <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-2);margin-bottom:1rem;line-height:1.5;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden">
                        {{ $item->ringkasan_auto }}
                    </p>

                    {{-- Meta --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted);margin-bottom:1rem">
                        <span>{{ $item->penulis ?? 'Admin' }}</span>
                        <span>{{ $item->tanggal_format }}</span>
                    </div>

                    {{-- Read More Button --}}
                    <a href="{{ route('berita.show', $item->slug) }}"
                       style="display:inline-block;padding:0.5rem 1rem;background:var(--emas);color:#fff;border-radius:var(--radius);font-family:var(--font-ui);font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.3s ease-out;cursor:pointer"
                       class="berita-btn">
                        Baca Selengkapnya
                    </a>
                </div>
            </article>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:3rem 0">
                <svg style="width:4rem;height:4rem;color:var(--krem-tua);margin:0 auto 1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p style="font-family:var(--font-display);font-size:1rem;color:var(--teks-2);margin-bottom:0.5rem">Berita tidak ditemukan</p>
                <p style="font-family:var(--font-ui);font-size:0.8rem;color:var(--teks-muted)">Coba ubah filter atau kata kunci pencarian</p>
            </div>
        @endempty
    </div>

    {{-- Pagination --}}
    @if ($berita->hasPages())
        <div style="margin-top:2rem">
            {{ $berita->links() }}
        </div>
    @endif
</div>
