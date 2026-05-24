<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class OperatorLayananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $jenis  = $request->get('jenis');
        $cari   = $request->get('cari');

        $query = PengajuanSurat::latest();
        if ($status) $query->where('status', $status);
        if ($jenis)  $query->where('jenis_surat', $jenis);
        if ($cari)   $query->where(function($q) use ($cari) {
            $q->where('nama_lengkap', 'like', "%{$cari}%")
              ->orWhere('nik', 'like', "%{$cari}%")
              ->orWhere('nomor_referensi', 'like', "%{$cari}%");
        });

        $pengajuan   = $query->paginate(15)->withQueryString();
        $daftarJenis = PengajuanSurat::daftarJenis();
        $ringkasan   = [
            'menunggu'                => PengajuanSurat::where('status', 'menunggu')->count(),
            'diproses_operator'       => PengajuanSurat::where('status', 'diproses_operator')->count(),
            'menunggu_validasi_kades' => PengajuanSurat::where('status', 'menunggu_validasi_kades')->count(),
            'disetujui'               => PengajuanSurat::where('status', 'disetujui')->count(),
            'ditolak'                 => PengajuanSurat::where('status', 'ditolak')->count(),
        ];

        return view('operator.layanan.index', compact(
            'pengajuan', 'daftarJenis', 'status', 'jenis', 'cari', 'ringkasan'
        ));
    }

    public function show(PengajuanSurat $layanan)
    {
        return view('operator.layanan.show', compact('layanan'));
    }

    public function updateStatus(Request $request, PengajuanSurat $layanan)
    {
        $request->validate([
            'status'        => 'required|in:menunggu,diproses_operator,menunggu_validasi_kades,disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $data = [
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        if ($request->status === 'diproses_operator' && !$layanan->diproses_at) {
            $data['diproses_at'] = now();
        }
        if ($request->status === 'disetujui' && !$layanan->selesai_at) {
            $data['selesai_at'] = now();
        }

        $layanan->update($data);

        return back()->with('success', "Status pengajuan berhasil diubah.");
    }

    public function cetak(PengajuanSurat $layanan)
    {
        return view('admin.layanan.cetak', compact('layanan'));
    }

    public function destroy(PengajuanSurat $layanan)
    {
        $ref = $layanan->nomor_referensi;
        $layanan->delete();

        return redirect()->route('operator.layanan.index')
            ->with('success', "Pengajuan {$ref} berhasil dihapus.");
    }
}