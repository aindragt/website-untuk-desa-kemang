<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;

class AdminPesanController extends Controller
{
    public function index()
    {
        $pesan = PesanKontak::latest()->paginate(15);
        return view('admin.pesan.index', compact('pesan'));
    }

    public function show(PesanKontak $pesan)
    {
        $pesan->update(['is_read' => true]);
        return view('admin.pesan.show', compact('pesan'));
    }

    public function destroy(PesanKontak $pesan)
    {
        $pesan->delete();
        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    public function tandaiBaca(PesanKontak $pesan)
    {
        $pesan->update(['is_read' => !$pesan->is_read]);
        return back()->with('success', 'Status pesan diperbarui.');
    }
}
