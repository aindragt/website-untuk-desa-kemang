<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class BeritaSearch extends Component
{
    #[Reactive]
    public string $search = '';

    public string $kategori = '';

    public function render()
    {
        $query = Berita::published();

        // Filter by search
        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('ringkasan', 'like', '%' . $this->search . '%')
                  ->orWhere('isi', 'like', '%' . $this->search . '%');
        }

        // Filter by kategori
        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }

        $berita = $query->with('images')->paginate(9);
        $kategoriList = Berita::kategoriList();

        return view('livewire.berita-search', [
            'berita' => $berita,
            'kategoriList' => $kategoriList,
        ]);
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->kategori = '';
    }
}
