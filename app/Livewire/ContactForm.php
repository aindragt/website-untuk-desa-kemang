<?php

namespace App\Livewire;

use App\Models\PesanKontak;
use Livewire\Component;

class ContactForm extends Component
{
    public string $nama = '';
    public string $kontak = '';
    public string $pesan = '';
    public bool $submitted = false;

    public function submit()
    {
        $validated = $this->validate([
            'nama' => 'required|string|max:100',
            'kontak' => 'required|string|max:100',
            'pesan' => 'required|string|max:2000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'kontak.required' => 'Email atau WhatsApp wajib diisi.',
            'pesan.required' => 'Pesan wajib diisi.',
        ]);

        PesanKontak::create($validated);

        $this->reset();
        $this->submitted = true;

        // Hide success message after 5 seconds
        $this->dispatch('toast', [
            'message' => 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.',
            'type' => 'success',
            'duration' => 5000,
        ]);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
