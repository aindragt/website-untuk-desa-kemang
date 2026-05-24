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
            'fotos.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($data['judul']);
        $originalSlug = $slug;
        $i = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
        $data['slug']         = $slug;
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;
        $data['isi']          = clean($data['isi']);

        $berita = Berita::create($data);

        // Upload foto multiple jika ada
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $index => $foto) {
                $berita->images()->create([
                    'foto' => $foto->store('berita', 'public'),
                    'is_utama' => $index === 0,
                ]);
            }
        }

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
            'fotos.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_fotos' => 'nullable|array',
            'utama_foto'   => 'nullable|integer',
        ]);

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
        if ($data['is_published'] && !$berita->published_at) {
            $data['published_at'] = now();
        }

        $data['isi'] = clean($data['isi']);
        $berita->update($data);

        // Hapus foto jika ada yang dicentang
        if (!empty($data['delete_fotos'])) {
            $imagesToDelete = $berita->images()->whereIn('id', $data['delete_fotos'])->get();
            foreach ($imagesToDelete as $img) {
                \Storage::disk('public')->delete($img->foto);
                $img->delete();
            }
        }

        // Tambah foto baru
        if ($request->hasFile('fotos')) {
            $hasUtama = $berita->images()->where('is_utama', true)->exists();
            foreach ($request->file('fotos') as $index => $foto) {
                $berita->images()->create([
                    'foto' => $foto->store('berita', 'public'),
                    'is_utama' => !$hasUtama && $index === 0,
                ]);
            }
        }

        // Set foto utama
        if (!empty($data['utama_foto'])) {
            $berita->images()->update(['is_utama' => false]);
            $berita->images()->where('id', $data['utama_foto'])->update(['is_utama' => true]);
        } else {
            // Pastikan ada satu yang utama jika belum ada
            if ($berita->images()->count() > 0 && !$berita->images()->where('is_utama', true)->exists()) {
                $berita->images()->first()->update(['is_utama' => true]);
            }
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        foreach ($berita->images as $img) {
            \Storage::disk('public')->delete($img->foto);
        }
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
