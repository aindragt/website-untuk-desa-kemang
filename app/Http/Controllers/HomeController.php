<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Statistik;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $beritaTerbaru = Berita::published()->limit(3)->get();
        $statistikRingkas = [
            'total_penduduk' => Statistik::where('kategori', 'penduduk')->where('label', 'Total Penduduk')->value('nilai') ?? 2847,
            'jumlah_kk'      => Statistik::where('kategori', 'penduduk')->where('label', 'Kepala Keluarga')->value('nilai') ?? 742,
            'luas_wilayah'   => 10337,
            'jumlah_dusun'   => 3,
        ];

        return view('home.index', compact('beritaTerbaru', 'statistikRingkas'));
    }

    public function profil()
    {
        return view('home.profil');
    }

    public function statistik()
    {
        $penduduk   = Statistik::kategori('penduduk')->get();
        $pekerjaan  = Statistik::kategori('pekerjaan')->get();
        $pendidikan = Statistik::kategori('pendidikan')->get();
        $agama      = Statistik::kategori('agama')->get();

        return view('home.statistik', compact('penduduk', 'pekerjaan', 'pendidikan', 'agama'));
    }

    public function kontak()
    {
        return view('home.kontak');
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:100',
            'kontak' => 'required|string|max:100',
            'pesan'  => 'required|string|max:2000',
        ], [
            'nama.required'   => 'Nama wajib diisi.',
            'kontak.required' => 'Email atau WhatsApp wajib diisi.',
            'pesan.required'  => 'Pesan wajib diisi.',
        ]);

        PesanKontak::create($request->only('nama', 'kontak', 'pesan'));

        return redirect()->route('kontak')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
