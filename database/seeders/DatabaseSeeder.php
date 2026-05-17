<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------
        // STATISTIK
        // -------------------------
        $statistik = [
            // Penduduk
            ['kategori' => 'penduduk', 'label' => 'Total Penduduk',   'nilai' => 2847, 'satuan' => 'jiwa', 'urutan' => 1],
            ['kategori' => 'penduduk', 'label' => 'Kepala Keluarga',   'nilai' => 742,  'satuan' => 'KK',   'urutan' => 2],
            ['kategori' => 'penduduk', 'label' => 'Penduduk Laki-laki','nilai' => 1423, 'satuan' => 'jiwa', 'urutan' => 3],
            ['kategori' => 'penduduk', 'label' => 'Penduduk Perempuan','nilai' => 1424, 'satuan' => 'jiwa', 'urutan' => 4],

            // Pekerjaan
            ['kategori' => 'pekerjaan', 'label' => 'Petani / Pekebun', 'nilai' => 1053, 'satuan' => 'jiwa', 'urutan' => 1],
            ['kategori' => 'pekerjaan', 'label' => 'Nelayan',           'nilai' => 186,  'satuan' => 'jiwa', 'urutan' => 2],
            ['kategori' => 'pekerjaan', 'label' => 'Wiraswasta',        'nilai' => 155,  'satuan' => 'jiwa', 'urutan' => 3],
            ['kategori' => 'pekerjaan', 'label' => 'PNS / TNI / Polri', 'nilai' => 77,   'satuan' => 'jiwa', 'urutan' => 4],
            ['kategori' => 'pekerjaan', 'label' => 'Lainnya',           'nilai' => 77,   'satuan' => 'jiwa', 'urutan' => 5],

            // Pendidikan
            ['kategori' => 'pendidikan', 'label' => 'Tidak / Belum Sekolah', 'nilai' => 310, 'satuan' => 'jiwa', 'urutan' => 1],
            ['kategori' => 'pendidikan', 'label' => 'SD / Sederajat',         'nilai' => 820, 'satuan' => 'jiwa', 'urutan' => 2],
            ['kategori' => 'pendidikan', 'label' => 'SMP / Sederajat',        'nilai' => 640, 'satuan' => 'jiwa', 'urutan' => 3],
            ['kategori' => 'pendidikan', 'label' => 'SMA / Sederajat',        'nilai' => 810, 'satuan' => 'jiwa', 'urutan' => 4],
            ['kategori' => 'pendidikan', 'label' => 'Diploma / S1 ke atas',   'nilai' => 267, 'satuan' => 'jiwa', 'urutan' => 5],

            // Agama
            ['kategori' => 'agama', 'label' => 'Islam',     'nilai' => 2790, 'satuan' => 'jiwa', 'urutan' => 1],
            ['kategori' => 'agama', 'label' => 'Kristen',   'nilai' => 42,   'satuan' => 'jiwa', 'urutan' => 2],
            ['kategori' => 'agama', 'label' => 'Katolik',   'nilai' => 10,   'satuan' => 'jiwa', 'urutan' => 3],
            ['kategori' => 'agama', 'label' => 'Lainnya',   'nilai' => 5,    'satuan' => 'jiwa', 'urutan' => 4],
        ];

        foreach ($statistik as $s) {
            DB::table('statistik')->insert(array_merge($s, [
                'created_at' => now(), 'updated_at' => now(),
            ]));
        }

        // -------------------------
        // BERITA
        // -------------------------
        $beritaData = [
            [
                'judul'    => 'Musyawarah Desa Bahas Rencana Pembangunan Jalan Lingkungan 2025',
                'kategori' => 'pembangunan',
                'ringkasan'=> 'Warga bersama perangkat desa membahas prioritas pembangunan infrastruktur tahun anggaran 2025 dalam musyawarah yang berlangsung meriah.',
                'isi'      => '<p>Pemerintah Desa Kemang menggelar Musyawarah Desa (Musdes) pada akhir Maret 2025 yang dihadiri oleh ratusan warga dari enam dusun. Agenda utama musyawarah adalah membahas Rencana Kerja Pemerintah Desa (RKPDes) tahun anggaran 2025.</p><p>Kepala Desa Kemang dalam sambutannya menyampaikan bahwa pembangunan jalan lingkungan menjadi prioritas utama tahun ini, mengingat kondisi beberapa ruas jalan yang perlu segera diperbaiki demi kelancaran aktivitas warga.</p><p>"Kita akan memastikan pembangunan ini merata dan benar-benar dirasakan manfaatnya oleh seluruh warga Desa Kemang," ujar Kepala Desa dalam musyawarah tersebut.</p><p>Selain infrastruktur jalan, musyawarah juga membahas pembangunan drainase, perbaikan sarana posyandu, serta program pemberdayaan ekonomi masyarakat berbasis potensi lokal.</p>',
                'penulis'  => 'Admin Desa',
                'published_at' => Carbon::now()->subDays(4),
            ],
            [
                'judul'    => 'PKK Desa Kemang Raih Juara 2 Lomba Masak Makanan Tradisional Melayu',
                'kategori' => 'budaya',
                'ringkasan'=> 'Tim PKK Desa Kemang berhasil meraih penghargaan bergengsi pada festival budaya tingkat Kabupaten Pelalawan dengan menampilkan masakan tradisional Melayu.',
                'isi'      => '<p>Prestasi membanggakan kembali ditorehkan oleh warga Desa Kemang. Tim PKK desa berhasil meraih Juara 2 pada Lomba Masak Makanan Tradisional Melayu yang diselenggarakan dalam rangka Festival Budaya Melayu Kabupaten Pelalawan.</p><p>Tim PKK Desa Kemang menampilkan masakan tradisional Gulai Ikan Baung dan Lemang Bambu yang dimasak dengan cara tradisional menggunakan kayu bakar. Keahlian dan keaslian resep turun-temurun yang dipertahankan menjadi nilai lebih di mata juri.</p><p>Ketua PKK Desa Kemang menyampaikan rasa syukur dan bangga atas pencapaian ini. "Ini bukan hanya kemenangan PKK, tetapi kemenangan seluruh warga Desa Kemang yang terus menjaga dan melestarikan budaya Melayu kita," ungkapnya.</p>',
                'penulis'  => 'Admin Desa',
                'published_at' => Carbon::now()->subDays(17),
            ],
            [
                'judul'    => 'Gotong Royong Bersihkan Drainase Jelang Musim Hujan',
                'kategori' => 'sosial',
                'ringkasan'=> 'Ratusan warga Desa Kemang bahu-membahu membersihkan saluran air di seluruh penjuru desa sebagai langkah antisipasi banjir menjelang musim hujan.',
                'isi'      => '<p>Semangat gotong royong warga Desa Kemang kembali terbukti dalam kegiatan bersih-bersih drainase yang dilaksanakan serentak di seluruh dusun. Kegiatan ini merupakan program rutin desa menjelang musim hujan tiba.</p><p>Lebih dari 200 warga dari berbagai kalangan — mulai dari pemuda Karang Taruna, ibu-ibu PKK, hingga tokoh masyarakat — turun langsung membersihkan saluran air yang dipenuhi lumpur dan sampah.</p><p>Kepala Desa Kemang yang turut hadir menyerok lumpur bersama warga menegaskan bahwa kegiatan ini adalah wujud nyata bahwa warga desa masih menjunjung tinggi nilai kebersamaan dan gotong royong sebagai warisan budaya leluhur.</p>',
                'penulis'  => 'Admin Desa',
                'published_at' => Carbon::now()->subDays(27),
            ],
            [
                'judul'    => 'Posyandu Desa Kemang Berhasil Capai 95% Cakupan Imunisasi Anak',
                'kategori' => 'kesehatan',
                'ringkasan'=> 'Program posyandu rutin yang konsisten berhasil mengangkat cakupan imunisasi anak di Desa Kemang hingga mencapai 95%, melampaui target nasional.',
                'isi'      => '<p>Komitmen Desa Kemang dalam bidang kesehatan ibu dan anak kembali menunjukkan hasil yang menggembirakan. Cakupan imunisasi anak di desa ini berhasil mencapai angka 95%, melampaui target nasional sebesar 80%.</p><p>Pencapaian ini tidak lepas dari kerja keras kader posyandu yang aktif menjemput bola dengan mengunjungi rumah-rumah warga, terutama yang memiliki bayi dan balita. Program ini didukung penuh oleh Puskesmas Kecamatan Pangkalan Kuras.</p><p>Bidan desa menyampaikan bahwa kunci keberhasilan ini adalah kepercayaan warga dan konsistensi jadwal posyandu yang tidak pernah absen setiap bulannya.</p>',
                'penulis'  => 'Tim Kesehatan Desa',
                'published_at' => Carbon::now()->subDays(35),
            ],
            [
                'judul'    => 'Kelompok Tani Kemang Mulai Budidaya Ikan Patin di Keramba Sungai',
                'kategori' => 'sosial',
                'ringkasan'=> 'Kelompok Tani Maju Bersama Desa Kemang memulai program budidaya ikan patin menggunakan keramba jaring apung di aliran Sungai Kampar.',
                'isi'      => '<p>Inovasi di sektor perikanan mulai dirintis oleh Kelompok Tani Maju Bersama Desa Kemang. Dengan memanfaatkan potensi Sungai Kampar yang melintasi wilayah desa, kelompok ini memulai budidaya ikan patin menggunakan sistem keramba jaring apung.</p><p>Program ini mendapat dukungan dari Dinas Perikanan Kabupaten Pelalawan yang menyediakan benih ikan dan pendampingan teknis. Setiap anggota kelompok mendapat satu unit keramba berukuran 4x4 meter dengan kapasitas 500 ekor benih patin.</p><p>Diharapkan dalam 6-8 bulan ke depan, hasil panen perdana dapat menambah penghasilan anggota kelompok dan menjadi model percontohan bagi kelompok tani lain di kecamatan.</p>',
                'penulis'  => 'Admin Desa',
                'published_at' => Carbon::now()->subDays(42),
            ],
            [
                'judul'    => 'Festival Bakar Tongkang Tradisional Meriahkan Hari Jadi Desa Kemang',
                'kategori' => 'budaya',
                'ringkasan'=> 'Peringatan hari jadi Desa Kemang dimeriahkan dengan berbagai pertunjukan budaya Melayu termasuk festival bakar tongkang yang sudah menjadi tradisi tahunan.',
                'isi'      => '<p>Peringatan hari jadi Desa Kemang tahun ini berlangsung meriah dengan menghadirkan berbagai pertunjukan budaya Melayu. Puncak acara adalah Festival Bakar Tongkang yang sudah menjadi tradisi tahunan dan selalu dinantikan warga.</p><p>Festival ini menampilkan berbagai kesenian tradisional seperti tari zapin, pantun berbalas, dan kompang. Ratusan warga dari desa-desa sekitar turut hadir menyaksikan kemeriahan acara yang berlangsung selama tiga hari tiga malam ini.</p><p>Lembaga Adat Desa Kemang berharap festival ini dapat terus dipertahankan sebagai sarana pelestarian budaya Melayu sekaligus menjadi daya tarik wisata budaya di Kabupaten Pelalawan.</p>',
                'penulis'  => 'Panitia Hari Jadi Desa',
                'published_at' => Carbon::now()->subDays(60),
            ],
        ];

        foreach ($beritaData as $b) {
            DB::table('berita')->insert(array_merge($b, [
                'slug'         => Str::slug($b['judul']),
                'foto'         => null,
                'is_published' => true,
                'created_at'   => $b['published_at'],
                'updated_at'   => $b['published_at'],
            ]));
        }

        // -------------------------
        // GALERI
        // -------------------------
        // Galeri akan diisi melalui panel admin / upload manual
        // Placeholder data bisa ditambahkan setelah foto disiapkan
    }
}
