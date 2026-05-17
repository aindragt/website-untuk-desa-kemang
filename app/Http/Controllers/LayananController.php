<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // Halaman daftar layanan surat
    public function index()
    {
        $layanan = [
            [
                'kode'       => 'domisili',
                'judul'      => 'Surat Keterangan Domisili',
                'ikon'       => '🏠',
                'deskripsi'  => 'Surat keterangan yang menyatakan bahwa seseorang benar-benar berdomisili di wilayah Desa Kemang.',
                'keperluan'  => ['Pembukaan rekening bank', 'Pendaftaran sekolah', 'Keperluan instansi', 'Lainnya'],
                'syarat'     => ['Fotokopi KTP', 'Fotokopi KK', 'Surat pengantar RT/RW'],
            ],
            [
                'kode'       => 'usaha',
                'judul'      => 'Surat Keterangan Usaha',
                'ikon'       => '🏪',
                'deskripsi'  => 'Surat keterangan yang menyatakan bahwa seseorang menjalankan usaha di wilayah Desa Kemang.',
                'keperluan'  => ['Pengajuan pinjaman/kredit', 'Pendaftaran UMKM', 'Perizinan usaha', 'Lainnya'],
                'syarat'     => ['Fotokopi KTP', 'Fotokopi KK', 'Surat pengantar RT/RW', 'Foto tempat usaha'],
            ],
            [
                'kode'       => 'tidak_mampu',
                'judul'      => 'Surat Keterangan Tidak Mampu',
                'ikon'       => '📋',
                'deskripsi'  => 'Surat keterangan yang menyatakan kondisi ekonomi seseorang untuk keperluan tertentu.',
                'keperluan'  => ['Beasiswa pendidikan', 'Keringanan biaya rumah sakit', 'Bantuan sosial', 'Lainnya'],
                'syarat'     => ['Fotokopi KTP', 'Fotokopi KK', 'Surat pengantar RT/RW', 'Surat pernyataan dari RT'],
            ],
            [
                'kode'       => 'pengantar_ktpkk',
                'judul'      => 'Surat Pengantar KTP / KK',
                'ikon'       => '🪪',
                'deskripsi'  => 'Surat pengantar dari desa untuk pengurusan pembuatan atau perubahan data KTP dan Kartu Keluarga.',
                'keperluan'  => ['Pembuatan KTP baru', 'Perubahan data KTP', 'Pembuatan KK baru', 'Perubahan data KK'],
                'syarat'     => ['Fotokopi KK (untuk KTP baru)', 'KTP lama (untuk perubahan)', 'Surat pengantar RT/RW', 'Akta kelahiran'],
            ],
        ];

        return view('layanan.index', compact('layanan'));
    }

    // Halaman form pengajuan per jenis surat
    public function form(string $jenis)
    {
        $daftarJenis = PengajuanSurat::daftarJenis();

        if (!array_key_exists($jenis, $daftarJenis)) {
            abort(404);
        }

        $judulSurat = $daftarJenis[$jenis];
        $agama      = PengajuanSurat::daftarAgama();

        return view('layanan.form', compact('jenis', 'judulSurat', 'agama'));
    }

    // Proses submit pengajuan
    public function submit(Request $request, string $jenis)
    {
        $daftarJenis = PengajuanSurat::daftarJenis();
        if (!array_key_exists($jenis, $daftarJenis)) {
            abort(404);
        }

        $rules = [
            'nama_lengkap'  => 'required|string|max:150',
            'nik'           => 'required|digits:16',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama'         => 'required|string',
            'pekerjaan'     => 'required|string|max:100',
            'alamat'        => 'required|string|max:500',
            'no_hp'         => 'required|string|max:15',
            'keperluan'     => 'required|string|max:200',
        ];

        // Validasi tambahan khusus surat usaha
        if ($jenis === 'usaha') {
            $rules['nama_usaha']  = 'required|string|max:150';
            $rules['jenis_usaha'] = 'required|string|max:100';
        }

        $messages = [
            'nik.digits'           => 'NIK harus tepat 16 digit angka.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'no_hp.max'            => 'Nomor HP maksimal 15 karakter.',
        ];

        $data = $request->validate($rules, $messages);
        $data['jenis_surat'] = $jenis;

        $pengajuan = PengajuanSurat::create($data);

        return redirect()->route('layanan.sukses', $pengajuan->nomor_referensi);
    }

    // Halaman sukses setelah submit
    public function sukses(string $nomorReferensi)
    {
        $pengajuan = PengajuanSurat::where('nomor_referensi', $nomorReferensi)->firstOrFail();
        return view('layanan.sukses', compact('pengajuan'));
    }

    // Cek status pengajuan
    public function cekStatus(Request $request)
    {
        $pengajuan = null;
        $nomorReferensi = $request->get('nomor');

        if ($nomorReferensi) {
            $pengajuan = PengajuanSurat::where('nomor_referensi', strtoupper(trim($nomorReferensi)))->first();
        }

        return view('layanan.cek-status', compact('pengajuan', 'nomorReferensi'));
    }
}
