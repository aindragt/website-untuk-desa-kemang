<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;

class OperatorPesanController extends Controller
{
    public function index()
    {
        $pesan = PesanKontak::latest()->paginate(15);
        return view('operator.pesan.index', compact('pesan'));
    }

    public function show(PesanKontak $pesan)
    {
        $pesan->update(['is_read' => true]);
        return view('operator.pesan.show', compact('pesan'));
    }

    // Operator TIDAK BISA hapus pesan — tidak ada method destroy()
}
