<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $kategori     = $request->get('kategori', 'umum');
        $kategoriList = Galeri::kategoriList();

        $query = Galeri::active();

        if ($kategori && $kategori !== 'umum') {
            $query->where('kategori', $kategori);
        }

        $galeri = $query->paginate(12)->withQueryString();

        return view('galeri.index', compact('galeri', 'kategoriList', 'kategori'));
    }
}
