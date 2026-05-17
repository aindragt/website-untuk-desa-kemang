@extends('layouts.app')
@section('title', 'Profil Desa')

@section('content')

<div class="page-header">
    <div class="container page-header__content">
        <div class="page-header__eyebrow">Mengenal Lebih Dekat</div>
        <h1>Profil Desa Kemang</h1>
        <p class="page-header__desc">Sejarah, wilayah, visi misi, dan potensi Desa Kemang, Kabupaten Pelalawan.</p>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb__sep">/</span>
            <span>Profil Desa</span>
        </nav>
    </div>
</div>

<div class="motif-divider"></div>

<section class="section">
    <div class="container">
        {{-- TAB NAVIGASI --}}
        <div class="profil-tabs">
            <a href="#" class="profil-tab active" data-target="tab-sejarah">Sejarah</a>
            <a href="#" class="profil-tab" data-target="tab-wilayah">Wilayah</a>
            <a href="#" class="profil-tab" data-target="tab-visi">Visi & Misi</a>
            <a href="#" class="profil-tab" data-target="tab-potensi">Potensi Desa</a>
            <a href="#" class="profil-tab" data-target="tab-aparatur">Aparatur Desa</a>
        </div>

        {{-- TAB: SEJARAH --}}
        <div class="profil-panel" id="tab-sejarah">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:start">
                <div>
                    <div class="section-eyebrow">Jejak Sejarah</div>
                    <h2 class="section-title">Asal-Usul Desa Kemang</h2>
                    <p style="color:var(--teks-2);font-size:0.95rem;line-height:1.85;margin-bottom:1rem">
                        Nama "Kemang" berasal dari nama pohon kemang (<em>Mangifera kemanga</em>), sejenis pohon buah
                        dari keluarga mangga yang dahulu banyak tumbuh subur di kawasan ini. Pohon inilah yang menjadi
                        penanda awal wilayah pemukiman nenek moyang warga desa.
                    </p>
                    <p style="color:var(--teks-2);font-size:0.95rem;line-height:1.85;margin-bottom:1rem">
                        Pada era 1940-an, sekelompok rumpun keluarga Melayu dari pesisir Sungai Kampar mulai
                        membuka lahan dan mendirikan pemukiman di kawasan ini. Semangat gotong royong dan nilai-nilai
                        adat Melayu menjadi fondasi kehidupan bermasyarakat sejak awal.
                    </p>
                    <p style="color:var(--teks-2);font-size:0.95rem;line-height:1.85">
                        Setelah pemekaran Kabupaten Pelalawan dari Kampar pada tahun 2001, Desa Kemang resmi
                        masuk dalam wilayah administratif Kabupaten Pelalawan dan terus berkembang hingga kini.
                    </p>
                </div>
                <div class="timeline">
                    @foreach ([
                        ['1940-an', 'Awal Pemukiman', 'Rumpun keluarga Melayu dari pesisir Sungai Kampar mulai membuka lahan dan mendirikan pemukiman.'],
                        ['1960-an', 'Pengembangan Pertanian', 'Warga mulai mengembangkan lahan pertanian dan perkebunan sebagai sumber mata pencaharian utama.'],
                        ['1979', 'Desa Definitif', 'Desa Kemang resmi ditetapkan sebagai desa definitif dalam wilayah administrasi Kecamatan Pangkalan Kuras.'],
                        ['2001', 'Bergabung ke Kab. Pelalawan', 'Pasca pemekaran Kabupaten Pelalawan, Desa Kemang resmi masuk dalam wilayah administratif kabupaten baru.'],
                        ['2010', 'Infrastruktur Berkembang', 'Pembangunan jalan, jembatan, dan fasilitas umum mulai dipercepat seiring Dana Desa.'],
                        ['Kini', 'Desa Berkembang', 'Terus bertumbuh dengan program pemberdayaan masyarakat, digitalisasi, dan pelestarian budaya Melayu.'],
                    ] as $item)
                    <div class="timeline__item">
                        <div class="timeline__dot"></div>
                        <div class="timeline__year">{{ $item[0] }}</div>
                        <div class="timeline__title">{{ $item[1] }}</div>
                        <p class="timeline__desc">{{ $item[2] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TAB: WILAYAH --}}
        <div class="profil-panel" id="tab-wilayah">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:start">
                <div>
                    <div class="section-eyebrow">Geografi</div>
                    <h2 class="section-title">Wilayah Desa Kemang</h2>
                    <p style="color:var(--teks-2);font-size:0.95rem;line-height:1.85;margin-bottom:2rem">
                        Desa Kemang terletak di Kecamatan Pangkalan Kuras, Kabupaten Pelalawan, Provinsi Riau.
                        Luas wilayah desa mencapai sekitar 1.240 hektare, terdiri dari pemukiman, lahan pertanian,
                        perkebunan, dan kawasan tepian sungai.
                    </p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem">
                        @foreach ([
                            ['Luas Wilayah', '±1.240 Ha'],
                            ['Jumlah Dusun', '6 Dusun'],
                            ['Jumlah RT', '18 RT'],
                            ['Jumlah RW', '6 RW'],
                        ] as $data)
                        <div style="background:var(--krem);border-radius:var(--radius);padding:1rem">
                            <div style="font-family:var(--font-ui);font-size:0.7rem;color:var(--teks-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px">{{ $data[0] }}</div>
                            <div style="font-family:var(--font-display);font-size:1.1rem;color:var(--teks);font-weight:700">{{ $data[1] }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div style="background:var(--krem);border-radius:var(--radius-lg);padding:1.5rem">
                        <div style="font-family:var(--font-display);font-size:0.95rem;color:var(--teks);margin-bottom:0.75rem">Batas Wilayah</div>
                        @foreach ([
                            ['Utara', '🔼', 'Berbatasan dengan Desa Dundangan'],
                            ['Selatan', '🔽', 'Berbatasan dengan Desa Rawang Empat'],
                            ['Barat', '◀', 'Berbatasan dengan Sungai Kampar'],
                            ['Timur', '▶', 'Berbatasan dengan Desa Betung'],
                        ] as $batas)
                        <div style="display:flex;gap:10px;align-items:center;padding:6px 0;border-bottom:0.5px solid var(--border);font-family:var(--font-ui);font-size:0.82rem">
                            <span style="width:50px;color:var(--teks-muted)">{{ $batas[0] }}</span>
                            <span style="color:var(--teks)">{{ $batas[2] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div style="background:linear-gradient(135deg,var(--hijau),var(--hijau-muda));border-radius:var(--radius-lg);aspect-ratio:1;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.4);font-size:0.8rem;font-family:var(--font-ui);text-align:center;padding:1.5rem">
                    <div>
                        {{-- <div style="font-size:3rem;margin-bottom:0.5rem">🗺️</div>
                        <p>Peta wilayah Desa Kemang<br>akan ditampilkan di sini</p> --}}
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60677.635215146955!2d101.88810138427174!3d0.3035808039684395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5dd72647a2217%3A0x69ad8a7fde2d5465!2sKemang%2C%20Kec.%20Pangkalan%20Kuras%2C%20Kabupaten%20Pelalawan%2C%20Riau!5e1!3m2!1sid!2sid!4v1777188741497!5m2!1sid!2sid" 
                            width="500" 
                            height="550" 
                            style="border:0; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: VISI MISI --}}
        <div class="profil-panel" id="tab-visi">
            <div style="max-width:760px;margin:0 auto;text-align:center">
                <div class="section-eyebrow" style="justify-content:center">Arah & Tujuan</div>
                <h2 class="section-title">Visi & Misi Desa Kemang</h2>
                <div style="background:var(--hijau);border-radius:var(--radius-lg);padding:2.5rem;margin:2rem 0">
                    <div style="font-family:var(--font-ui);font-size:0.7rem;font-weight:600;color:var(--emas);letter-spacing:0.15em;text-transform:uppercase;margin-bottom:0.75rem">Visi</div>
                    <p style="font-family:var(--font-display);font-size:1.2rem;color:#fff;line-height:1.6;font-style:italic">
                        "Terwujudnya Desa Kemang yang Mandiri, Berbudaya, dan Sejahtera Berlandaskan Nilai-Nilai Melayu"
                    </p>
                </div>
                <div style="text-align:left">
                    <div style="font-family:var(--font-ui);font-size:0.7rem;font-weight:600;color:var(--emas);letter-spacing:0.15em;text-transform:uppercase;margin-bottom:1.25rem;text-align:center">Misi</div>
                    @foreach ([
                        'Meningkatkan kualitas pelayanan pemerintahan desa yang transparan, akuntabel, dan berpihak kepada masyarakat.',
                        'Mendorong pembangunan infrastruktur desa yang merata dan berkualitas demi kemudahan akses warga.',
                        'Memberdayakan perekonomian masyarakat berbasis potensi lokal — pertanian, perikanan, dan UMKM.',
                        'Melestarikan dan mengembangkan nilai-nilai budaya Melayu sebagai identitas dan kebanggaan desa.',
                        'Meningkatkan kualitas sumber daya manusia melalui pendidikan, pelatihan, dan pembinaan generasi muda.',
                        'Mewujudkan lingkungan desa yang bersih, sehat, dan ramah bagi seluruh warga.',
                    ] as $i => $misi)
                    <div style="display:flex;gap:1rem;align-items:flex-start;margin-bottom:1rem;padding:1rem;background:var(--krem);border-radius:var(--radius)">
                        <div style="width:28px;height:28px;border-radius:50%;background:var(--emas);display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-size:0.75rem;font-weight:700;color:var(--hijau-tua);flex-shrink:0">{{ $i+1 }}</div>
                        <p style="font-size:0.9rem;color:var(--teks-2);line-height:1.7">{{ $misi }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TAB: POTENSI --}}
        <div class="profil-panel" id="tab-potensi">
            <div class="section-eyebrow">Kekayaan Desa</div>
            <h2 class="section-title" style="margin-bottom:2rem">Potensi Desa Kemang</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.5rem">
                @foreach ([
                    ['🌴', 'Perkebunan Sawit & Karet', 'Komoditas utama penggerak ekonomi warga. Lahan sawit dan karet tersebar di sebagian besar wilayah desa dengan produktivitas yang terus meningkat.'],
                    ['🐟', 'Perikanan Air Tawar', 'Sungai Kampar yang melintasi desa menjadi sumber daya alam berharga. Budidaya ikan patin, nila, dan lele berkembang dengan sistem keramba.'],
                    ['🌾', 'Pertanian Pangan', 'Lahan pertanian padi sawah dan palawija dikelola oleh kelompok tani secara berkelompok untuk menjaga ketahanan pangan lokal.'],
                    ['🧺', 'Kerajinan Anyaman Rotan', 'Kerajinan tangan anyaman rotan dan pandan menjadi warisan budaya sekaligus produk UMKM unggulan Desa Kemang.'],
                    ['🎭', 'Wisata Budaya Melayu', 'Tradisi zapin, kompang, dan festival budaya menjadi daya tarik wisata yang potensial untuk terus dikembangkan.'],
                    ['🌊', 'Wisata Alam Sungai', 'Keindahan tepian Sungai Kampar menawarkan potensi ekowisata yang belum banyak dieksploitasi namun kaya nilai alam.'],
                ] as $potensi)
                <div style="background:#fff;border:1px solid var(--border);border-left:4px solid var(--emas);border-radius:var(--radius);padding:1.5rem">
                    <div style="font-size:1.75rem;margin-bottom:0.75rem">{{ $potensi[0] }}</div>
                    <h3 style="font-family:var(--font-display);font-size:0.95rem;color:var(--teks);margin-bottom:0.5rem">{{ $potensi[1] }}</h3>
                    <p style="font-size:0.85rem;color:var(--teks-2);line-height:1.7">{{ $potensi[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TAB: APARATUR DESA --}}
        <div class="profil-panel" id="tab-aparatur">
            <div class="section-eyebrow">Struktur Pemerintahan</div>
            <h2 class="section-title" style="margin-bottom:2rem">Aparatur Desa Kemang</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem">
                @foreach ([
                    ['Kepala Desa',         '——————',  'Pimpinan pemerintahan desa.'],
                    ['Sekretaris Desa',     '——————',  'Membantu kepala desa dalam administrasi.'],
                    ['Kaur Keuangan',       '——————',  'Mengelola keuangan dan aset desa.'],
                    ['Kaur Umum',           '——————',  'Urusan umum dan tata usaha desa.'],
                    ['Kasi Pemerintahan',   '——————',  'Pelayanan pemerintahan dan kependudukan.'],
                    ['Kasi Kesra',          '——————',  'Kesejahteraan rakyat dan sosial budaya.'],
                    ['Kasi Pelayanan',      '——————',  'Pelayanan publik dan informasi desa.'],
                    ['Kepala Dusun I–VI',   '——————',  'Koordinator wilayah di masing-masing dusun.'],
                ] as $aparatur)
                <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem;text-align:center">
                    <div style="width:56px;height:56px;border-radius:50%;background:var(--krem);border:2px solid var(--emas);display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 0.75rem">👤</div>
                    <div style="font-family:var(--font-body);font-size:0.75rem;color:var(--teks-muted);margin-bottom:2px">{{ $aparatur[0] }}</div>
                    <div style="font-family:var(--font-display);font-size:0.9rem;color:var(--teks);margin-bottom:4px">{{ $aparatur[1] }}</div>
                    <p style="font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted)">{{ $aparatur[2] }}</p>
                </div>
                @endforeach
            </div>
            <p style="font-size:0.8rem;color:var(--teks-muted);font-family:var(--font-ui);margin-top:1.5rem;font-style:italic">
                * Data aparatur desa dapat diperbarui melalui panel administrasi.
            </p>
        </div>
    </div>
</section>

@endsection
