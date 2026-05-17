<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class AdminGaleriController extends Controller
{
    public function index()
    {
        $galeri       = Galeri::orderBy('urutan')->paginate(12);
        $kategoriList = Galeri::kategoriList();
        return view('admin.galeri.index', compact('galeri', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:150',
            'kategori'   => 'required|string',
            'keterangan' => 'nullable|string|max:300',
            'urutan'     => 'nullable|integer',
            'foto'       => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['foto']      = $request->file('foto')->store('galeri', 'public');
        $data['is_active'] = true;
        $data['urutan']    = $data['urutan'] ?? (Galeri::max('urutan') + 1);

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil diunggah ke galeri.');
    }

    public function destroy(Galeri $galeri)
    {
        \Storage::disk('public')->delete($galeri->foto);
        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }

    public function toggleActive(Galeri $galeri)
    {
        $galeri->is_active = !$galeri->is_active;
        $galeri->save();

        $status = $galeri->is_active ? 'diaktifkan' : 'disembunyikan';
        return back()->with('success', "Foto berhasil {$status}.");
    }
}
