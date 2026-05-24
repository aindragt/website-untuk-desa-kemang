<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\PesanKontak;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_berita'  => Berita::count(),
            'berita_tayang' => Berita::where('is_published', true)->count(),
            'pesan_baru'    => PesanKontak::where('is_read', false)->count(),
        ];

        $beritaTerbaru = Berita::latest()->limit(5)->get();
        $pesanTerbaru  = PesanKontak::where('is_read', false)->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'beritaTerbaru', 'pesanTerbaru'));
    }
}
