<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $cari     = $request->get('cari');

        $query = Berita::published();

        if ($kategori && $kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('ringkasan', 'like', "%{$cari}%");
            });
        }

        $berita       = $query->paginate(9)->withQueryString();
        $kategoriList = Berita::kategoriList();

        return view('berita.index', compact('berita', 'kategoriList', 'kategori', 'cari'));
    }

    public function show(string $slug)
    {
        $berita   = Berita::published()->where('slug', $slug)->firstOrFail();
        $lainnya  = Berita::published()
                        ->where('id', '!=', $berita->id)
                        ->limit(4)
                        ->get();

        return view('berita.show', compact('berita', 'lainnya'));
    }
}
