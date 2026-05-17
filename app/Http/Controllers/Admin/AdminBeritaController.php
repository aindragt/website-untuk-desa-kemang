<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBeritaController extends Controller
{
    public function index(Request $request)
    {
        $cari     = $request->get('cari');
        $kategori = $request->get('kategori');

        $query = Berita::latest();

        if ($cari) {
            $query->where('judul', 'like', "%{$cari}%");
        }
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $berita       = $query->paginate(10)->withQueryString();
        $kategoriList = Berita::kategoriList();

        return view('admin.berita.index', compact('berita', 'kategoriList', 'cari', 'kategori'));
    }

    public function create()
    {
        $kategoriList = Berita::kategoriList();
        return view('admin.berita.form', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|string',
            'ringkasan'    => 'nullable|string|max:500',
            'isi'          => 'required|string',
            'penulis'      => 'required|string|max:100',
            'is_published' => 'boolean',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        // Buat slug unik
        $slug = Str::slug($data['judul']);
        $originalSlug = $slug;
        $i = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
        $data['slug']         = $slug;
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $kategoriList = Berita::kategoriList();
        return view('admin.berita.form', compact('berita', 'kategoriList'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|string',
            'ringkasan'    => 'nullable|string|max:500',
            'isi'          => 'required|string',
            'penulis'      => 'required|string|max:100',
            'is_published' => 'boolean',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($berita->foto) {
                \Storage::disk('public')->delete($berita->foto);
            }
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        // Update slug hanya jika judul berubah
        if ($data['judul'] !== $berita->judul) {
            $slug = Str::slug($data['judul']);
            $originalSlug = $slug;
            $i = 1;
            while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        $data['is_published'] = $request->boolean('is_published');

        // Set published_at saat pertama kali ditayangkan
        if ($data['is_published'] && !$berita->published_at) {
            $data['published_at'] = now();
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->foto) {
            \Storage::disk('public')->delete($berita->foto);
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function togglePublish(Berita $berita)
    {
        $berita->is_published = !$berita->is_published;
        if ($berita->is_published && !$berita->published_at) {
            $berita->published_at = now();
        }
        $berita->save();

        $status = $berita->is_published ? 'ditayangkan' : 'disembunyikan';
        return back()->with('success', "Berita berhasil {$status}.");
    }
}
