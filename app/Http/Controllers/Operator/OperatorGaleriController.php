<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class OperatorGaleriController extends Controller
{
    public function index()
    {
        $galeri       = Galeri::orderBy('urutan')->paginate(12);
        $kategoriList = Galeri::kategoriList();
        return view('operator.galeri.index', compact('galeri', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:150',
            'kategori'   => 'required|string',
            'keterangan' => 'nullable|string|max:300',
            'foto'       => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['foto']      = $request->file('foto')->store('galeri', 'public');
        $data['is_active'] = true;
        $data['urutan']    = Galeri::max('urutan') + 1;

        Galeri::create($data);

        return back()->with('success', 'Foto berhasil diunggah.');
    }

    // Operator BISA upload tapi TIDAK BISA hapus foto
}