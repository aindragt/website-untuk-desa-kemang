<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\PengajuanSurat;
use App\Models\PesanKontak;

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pengajuan_menunggu' => PengajuanSurat::where('status', 'menunggu')->count(),
            'pengajuan_diproses' => PengajuanSurat::where('status', 'diproses_operator')->count(),
            'pesan_baru'         => PesanKontak::where('is_read', false)->count(),
            'total_berita'       => Berita::count(),
        ];

        $pengajuanTerbaru = PengajuanSurat::latest()->limit(5)->get();
        $pesanTerbaru     = PesanKontak::where('is_read', false)->latest()->limit(5)->get();

        return view('operator.dashboard', compact('stats', 'pengajuanTerbaru', 'pesanTerbaru'));
    }
}