<div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem">
    {{-- Success Message --}}
    @if ($submitted)
        <div style="background:#ecf7ec;border:1px solid #7dbf7d;border-radius:var(--radius);padding:1rem;margin-bottom:1.5rem">
            <div style="display:flex;align-items:center;gap:0.75rem">
                <svg style="width:1.5rem;height:1.5rem;color:#2d6a2d;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p style="font-family:var(--font-display);font-size:0.9rem;color:#2d6a2d;font-weight:600">Pesan Berhasil Dikirim!</p>
                    <p style="font-family:var(--font-ui);font-size:0.8rem;color:#2d6a2d">Kami akan segera menghubungi Anda.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit="submit" style="display:grid;gap:1rem">
        {{-- Nama --}}
        <div>
            <label style="display:block;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:0.5rem">
                Nama Lengkap
            </label>
            <input type="text"
                   wire:model="nama"
                   placeholder="Masukkan nama Anda"
                   class="form-control"
                   style="width:100%;border-color:{{ $errors->has('nama') ? '#ef4444' : 'var(--border)' }}"
                   @if ($submitted) disabled @endif>
            @error('nama')
                <p style="color:#ef4444;font-family:var(--font-ui);font-size:0.75rem;margin-top:0.25rem">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kontak --}}
        <div>
            <label style="display:block;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:0.5rem">
                Email atau WhatsApp
            </label>
            <input type="text"
                   wire:model="kontak"
                   placeholder="Contoh: email@example.com atau 08123456789"
                   class="form-control"
                   style="width:100%;border-color:{{ $errors->has('kontak') ? '#ef4444' : 'var(--border)' }}"
                   @if ($submitted) disabled @endif>
            @error('kontak')
                <p style="color:#ef4444;font-family:var(--font-ui);font-size:0.75rem;margin-top:0.25rem">{{ $message }}</p>
            @enderror
        </div>

        {{-- Pesan --}}
        <div>
            <label style="display:block;font-family:var(--font-ui);font-size:0.82rem;font-weight:600;color:var(--teks);margin-bottom:0.5rem">
                Pesan
            </label>
            <textarea wire:model="pesan"
                      placeholder="Tulis pesan Anda di sini..."
                      rows="5"
                      class="form-control"
                      style="width:100%;resize:none;border-color:{{ $errors->has('pesan') ? '#ef4444' : 'var(--border)' }}"
                      @if ($submitted) disabled @endif></textarea>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.5rem">
                <p style="font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted)">Maksimal 2000 karakter</p>
                <p style="font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted)">{{ strlen($pesan) }}/2000</p>
            </div>
            @error('pesan')
                <p style="color:#ef4444;font-family:var(--font-ui);font-size:0.75rem;margin-top:0.25rem">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div style="display:flex;gap:0.75rem;padding-top:1rem">
            <button type="submit"
                    class="btn btn--primary"
                    style="flex:1;width:auto"
                    wire:loading.attr="disabled"
                    @if ($submitted) disabled @endif>
                <span wire:loading.remove>📨 Kirim Pesan</span>
                <span wire:loading style="display:flex;align-items:center;justify-content:center;gap:0.5rem">
                    <svg style="width:1rem;height:1rem;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24">
                        <circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengirim...
                </span>
            </button>

            @if ($submitted)
                <button type="button"
                        wire:click="$set('submitted', false)"
                        class="btn btn--secondary"
                        style="width:auto;padding:0.5rem 1rem">
                    Kirim Lagi
                </button>
            @endif
        </div>
    </form>
</div>
