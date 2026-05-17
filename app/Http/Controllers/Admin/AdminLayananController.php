<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class AdminLayananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $jenis  = $request->get('jenis');
        $cari   = $request->get('cari');

        $query = PengajuanSurat::latest();

        if ($status) {
            $query->where('status', $status);
        }
        if ($jenis) {
            $query->where('jenis_surat', $jenis);
        }
        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lengkap', 'like', "%{$cari}%")
                  ->orWhere('nik', 'like', "%{$cari}%")
                  ->orWhere('nomor_referensi', 'like', "%{$cari}%");
            });
        }

        $pengajuan   = $query->paginate(15)->withQueryString();
        $daftarJenis = PengajuanSurat::daftarJenis();

        $ringkasan = [
            'menunggu' => PengajuanSurat::where('status', 'menunggu')->count(),
            'diproses' => PengajuanSurat::where('status', 'diproses')->count(),
            'selesai'  => PengajuanSurat::where('status', 'selesai')->count(),
            'ditolak'  => PengajuanSurat::where('status', 'ditolak')->count(),
        ];

        return view('admin.layanan.index', compact('pengajuan', 'daftarJenis', 'status', 'jenis', 'cari', 'ringkasan'));
    }

    public function show(PengajuanSurat $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    public function updateStatus(Request $request, PengajuanSurat $layanan)
    {
        $request->validate([
            'status'         => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan_admin'  => 'nullable|string|max:500',
        ]);

        $data = [
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        // Set timestamp otomatis
        if ($request->status === 'diproses' && !$layanan->diproses_at) {
            $data['diproses_at'] = now();
        }
        if ($request->status === 'selesai' && !$layanan->selesai_at) {
            $data['selesai_at'] = now();
        }

        $layanan->update($data);

        return back()->with('success', "Status pengajuan {$layanan->nomor_referensi} berhasil diubah menjadi \"{$layanan->fresh()->label_status}\".");
    }

    public function destroy(PengajuanSurat $layanan)
    {
        $ref = $layanan->nomor_referensi;
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', "Pengajuan {$ref} berhasil dihapus.");
    }

    public function cetak(PengajuanSurat $layanan)
    {
        return view('admin.layanan.cetak', compact('layanan'));
    }
}
