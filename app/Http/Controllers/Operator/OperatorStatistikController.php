<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Statistik;
use Illuminate\Http\Request;

class OperatorStatistikController extends Controller
{
    public function index()
    {
        $data = Statistik::orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');
        return view('operator.statistik.index', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'statistik'         => 'required|array',
            'statistik.*.id'    => 'required|exists:statistik,id',
            'statistik.*.nilai' => 'required|integer|min:0',
        ]);

        foreach ($request->statistik as $item) {
            Statistik::where('id', $item['id'])->update(['nilai' => $item['nilai']]);
        }

        return back()->with('success', 'Data statistik berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|string',
            'label'    => 'required|string|max:100',
            'nilai'    => 'required|integer|min:0',
            'satuan'   => 'required|string|max:30',
        ]);

        $data['urutan'] = Statistik::where('kategori', $data['kategori'])->max('urutan') + 1;
        Statistik::create($data);

        return back()->with('success', 'Data statistik berhasil ditambahkan.');
    }

    public function destroy(Statistik $statistik)
    {
        $statistik->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
