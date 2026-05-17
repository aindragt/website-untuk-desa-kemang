<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OperatorBeritaController extends Controller
{
    public function index(Request $request)
    {
        $cari     = $request->get('cari');
        $kategori = $request->get('kategori');

        $query = Berita::latest();
        if ($cari)     $query->where('judul', 'like', "%{$cari}%");
        if ($kategori) $query->where('kategori', $kategori);

        $berita       = $query->paginate(10)->withQueryString();
        $kategoriList = Berita::kategoriList();

        return view('operator.berita.index', compact('berita', 'kategoriList', 'cari', 'kategori'));
    }

    public function create()
    {
        $kategoriList = Berita::kategoriList();
        return view('operator.berita.form', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|string',
            'ringkasan'    => 'nullable|string|max:500',
            'isi'          => 'required|string',
            'is_published' => 'boolean',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        $slug = Str::slug($data['judul']);
        $i = 1;
        $orig = $slug;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $orig . '-' . $i++;
        }
        $data['slug']         = $slug;
        $data['penulis']      = session('user_nama'); // nama operator sebagai penulis
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        Berita::create($data);

        return redirect()->route('operator.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $kategoriList = Berita::kategoriList();
        return view('operator.berita.form', compact('berita', 'kategoriList'));
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
            if ($berita->foto) \Storage::disk('public')->delete($berita->foto);
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        if ($data['judul'] !== $berita->judul) {
            $slug = Str::slug($data['judul']);
            $orig = $slug; $i = 1;
            while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
                $slug = $orig . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && !$berita->published_at) {
            $data['published_at'] = now();
        }

        $berita->update($data);

        return redirect()->route('operator.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
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

    // Operator TIDAK bisa hapus — tidak ada method destroy()
}