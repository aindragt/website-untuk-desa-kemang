<?php

namespace App\Livewire;

use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class StatusChecker extends Component
{
    #[Reactive]
    public string $nomorReferensi = '';

    public ?PengajuanSurat $pengajuan = null;

    public bool $searched = false;

    public function cekStatus()
    {
        $this->validate([
            'nomorReferensi' => 'required|string',
        ], [
            'nomorReferensi.required' => 'Nomor referensi wajib diisi',
        ]);

        $this->pengajuan = PengajuanSurat::where('nomor_referensi', strtoupper(trim($this->nomorReferensi)))
            ->first();

        $this->searched = true;
    }

    public function resetSearch()
    {
        $this->nomorReferensi = '';
        $this->pengajuan = null;
        $this->searched = false;
    }

    public function render()
    {
        return view('livewire.status-checker');
    }
}
