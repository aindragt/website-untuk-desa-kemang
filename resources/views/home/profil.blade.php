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
    <div class="container" x-data="{ activeTab: 'sejarah' }">
        {{-- TAB NAVIGASI --}}
        <div class="profil-tabs">
            <a href="#" class="profil-tab" :class="{ 'active': activeTab === 'sejarah' }" @click.prevent="activeTab = 'sejarah'">Sejarah</a>
            <a href="#" class="profil-tab" :class="{ 'active': activeTab === 'wilayah' }" @click.prevent="activeTab = 'wilayah'">Wilayah</a>
            <a href="#" class="profil-tab" :class="{ 'active': activeTab === 'visi' }" @click.prevent="activeTab = 'visi'">Visi & Misi</a>
            <a href="#" class="profil-tab" :class="{ 'active': activeTab === 'potensi' }" @click.prevent="activeTab = 'potensi'">Potensi Desa</a>
            <a href="#" class="profil-tab" :class="{ 'active': activeTab === 'aparatur' }" @click.prevent="activeTab = 'aparatur'">Aparatur Desa</a>
        </div>

        {{-- TAB: SEJARAH --}}
        <div class="profil-panel" id="tab-sejarah" 
             x-show="activeTab === 'sejarah'"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                <div>
                    <div class="section-eyebrow">Jejak Sejarah</div>
                    <h2 class="section-title">Asal-Usul Desa Kemang</h2>
                    <p class="text-stone-700 text-[0.95rem] leading-[1.85] mb-4">
                        Nama "Kemang" berasal dari nama pohon kemang (<em>Mangifera kemanga</em>), sejenis pohon buah
                        dari keluarga mangga yang dahulu banyak tumbuh subur di kawasan ini. Pohon inilah yang menjadi
                        penanda awal wilayah pemukiman nenek moyang warga desa.
                    </p>
                    <p class="text-stone-700 text-[0.95rem] leading-[1.85] mb-4">
                        Pada era 1940-an, sekelompok rumpun keluarga Melayu dari pesisir Sungai Kampar mulai
                        membuka lahan dan mendirikan pemukiman di kawasan ini. Semangat gotong royong dan nilai-nilai
                        adat Melayu menjadi fondasi kehidupan bermasyarakat sejak awal.
                    </p>
                    <p class="text-stone-700 text-[0.95rem] leading-[1.85]">
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
        <div class="profil-panel" id="tab-wilayah" 
             x-show="activeTab === 'wilayah'" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                <div>
                    <div class="section-eyebrow">Geografi</div>
                    <h2 class="section-title">Wilayah Desa Kemang</h2>
                    <p class="text-stone-700 text-[0.95rem] leading-[1.85] mb-8">
                        Desa Kemang terletak di Kecamatan Pangkalan Kuras, Kabupaten Pelalawan, Provinsi Riau.
                        Luas wilayah desa mencapai sekitar 1.240 hektare, terdiri dari pemukiman, lahan pertanian,
                        perkebunan, dan kawasan tepian sungai.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        @foreach ([
                            ['Luas Wilayah', '±1.240 Ha'],
                            ['Jumlah Dusun', '6 Dusun'],
                            ['Jumlah RT', '18 RT'],
                            ['Jumlah RW', '6 RW'],
                        ] as $data)
                        <div class="bg-krem rounded p-4">
                            <div class="font-ui text-[0.7rem] text-stone-500 uppercase tracking-wider mb-1">{{ $data[0] }}</div>
                            <div class="font-display text-[1.1rem] text-stone-900 font-bold">{{ $data[1] }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="bg-krem rounded-lg p-6">
                        <div class="font-display text-[0.95rem] text-stone-900 mb-3">Batas Wilayah</div>
                        @foreach ([
                            ['Utara', '🔼', 'Berbatasan dengan Desa Dundangan'],
                            ['Selatan', '🔽', 'Berbatasan dengan Desa Rawang Empat'],
                            ['Barat', '◀', 'Berbatasan dengan Sungai Kampar'],
                            ['Timur', '▶', 'Berbatasan dengan Desa Betung'],
                        ] as $batas)
                        <div class="flex gap-2.5 items-center py-1.5 border-b border-[#D9C8A8]/50 font-ui text-[0.82rem]">
                            <span class="w-[50px] text-stone-500">{{ $batas[0] }}</span>
                            <span class="text-stone-900">{{ $batas[2] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-gradient-to-br from-hijau to-green-700 rounded-lg aspect-square flex items-center justify-center text-white/40 text-[0.8rem] font-ui text-center p-6">
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
        <div class="profil-panel" id="tab-visi" 
             x-show="activeTab === 'visi'" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-[760px] mx-auto text-center">
                <div class="section-eyebrow justify-center">Arah & Tujuan</div>
                <h2 class="section-title">Visi & Misi Desa Kemang</h2>
                <div class="bg-hijau rounded-lg p-10 my-8">
                    <div class="font-ui text-[0.7rem] font-semibold text-emas tracking-widest uppercase mb-3">Visi</div>
                    <p class="font-display text-[1.2rem] text-white leading-relaxed italic">
                        "Terwujudnya Desa Kemang yang Mandiri, Berbudaya, dan Sejahtera Berlandaskan Nilai-Nilai Melayu"
                    </p>
                </div>
                <div class="text-left">
                    <div class="font-ui text-[0.7rem] font-semibold text-emas tracking-widest uppercase mb-5 text-center">Misi</div>
                    @foreach ([
                        'Meningkatkan kualitas pelayanan pemerintahan desa yang transparan, akuntabel, dan berpihak kepada masyarakat.',
                        'Mendorong pembangunan infrastruktur desa yang merata dan berkualitas demi kemudahan akses warga.',
                        'Memberdayakan perekonomian masyarakat berbasis potensi lokal — pertanian, perikanan, dan UMKM.',
                        'Melestarikan dan mengembangkan nilai-nilai budaya Melayu sebagai identitas dan kebanggaan desa.',
                        'Meningkatkan kualitas sumber daya manusia melalui pendidikan, pelatihan, dan pembinaan generasi muda.',
                        'Mewujudkan lingkungan desa yang bersih, sehat, dan ramah bagi seluruh warga.',
                    ] as $i => $misi)
                    <div class="flex gap-4 items-start mb-4 p-4 bg-krem rounded">
                        <div class="w-7 h-7 rounded-full bg-emas flex items-center justify-center font-ui text-[0.75rem] font-bold text-stone-900 shrink-0">{{ $i+1 }}</div>
                        <p class="text-[0.9rem] text-stone-700 leading-[1.7]">{{ $misi }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TAB: POTENSI --}}
        <div class="profil-panel" id="tab-potensi" 
             x-show="activeTab === 'potensi'" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="section-eyebrow">Kekayaan Desa</div>
            <h2 class="section-title mb-8">Potensi Desa Kemang</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['🌴', 'Perkebunan Sawit & Karet', 'Komoditas utama penggerak ekonomi warga. Lahan sawit dan karet tersebar di sebagian besar wilayah desa dengan produktivitas yang terus meningkat.'],
                    ['🐟', 'Perikanan Air Tawar', 'Sungai Kampar yang melintasi desa menjadi sumber daya alam berharga. Budidaya ikan patin, nila, dan lele berkembang dengan sistem keramba.'],
                    ['🌾', 'Pertanian Pangan', 'Lahan pertanian padi sawah dan palawija dikelola oleh kelompok tani secara berkelompok untuk menjaga ketahanan pangan lokal.'],
                    ['🧺', 'Kerajinan Anyaman Rotan', 'Kerajinan tangan anyaman rotan dan pandan menjadi warisan budaya sekaligus produk UMKM unggulan Desa Kemang.'],
                    ['🎭', 'Wisata Budaya Melayu', 'Tradisi zapin, kompang, dan festival budaya menjadi daya tarik wisata yang potensial untuk terus dikembangkan.'],
                    ['🌊', 'Wisata Alam Sungai', 'Keindahan tepian Sungai Kampar menawarkan potensi ekowisata yang belum banyak dieksploitasi namun kaya nilai alam.'],
                ] as $potensi)
                <div class="bg-white border border-[#D9C8A8] border-l-4 border-l-emas rounded p-6">
                    <div class="text-[1.75rem] mb-3">{{ $potensi[0] }}</div>
                    <h3 class="font-display text-[0.95rem] text-stone-900 mb-2">{{ $potensi[1] }}</h3>
                    <p class="text-[0.85rem] text-stone-700 leading-[1.7]">{{ $potensi[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TAB: APARATUR DESA --}}
        <div class="profil-panel" id="tab-aparatur" 
             x-show="activeTab === 'aparatur'" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="section-eyebrow">Struktur Pemerintahan</div>
            <h2 class="section-title mb-8">Aparatur Desa Kemang</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ([
                    ['Kepala Desa',         'Lukman Hakim',  'Pimpinan pemerintahan desa.'],
                    ['Sekretaris Desa',     '——————',  'Membantu kepala desa dalam administrasi.'],
                    ['Kaur Keuangan',       '——————',  'Mengelola keuangan dan aset desa.'],
                    ['Kaur Umum',           '——————',  'Urusan umum dan tata usaha desa.'],
                    ['Kasi Pemerintahan',   '——————',  'Pelayanan pemerintahan dan kependudukan.'],
                    ['Kasi Kesra',          '——————',  'Kesejahteraan rakyat dan sosial budaya.'],
                    ['Kasi Pelayanan',      '——————',  'Pelayanan publik dan informasi desa.'],
                    ['Kepala Dusun I–VI',   '——————',  'Koordinator wilayah di masing-masing dusun.'],
                ] as $aparatur)
                <div class="bg-white border border-[#D9C8A8] rounded-lg p-5 text-center">
                    <div class="w-14 h-14 rounded-full bg-krem border-2 border-emas flex items-center justify-center text-[1.5rem] mx-auto mb-3">👤</div>
                    <div class="font-body text-[0.75rem] text-stone-500 mb-0.5">{{ $aparatur[0] }}</div>
                    <div class="font-display text-[0.9rem] text-stone-900 mb-1">{{ $aparatur[1] }}</div>
                    <p class="font-ui text-[0.75rem] text-stone-500">{{ $aparatur[2] }}</p>
                </div>
                @endforeach
            </div>
            <p class="text-[0.8rem] text-stone-500 font-ui mt-6 italic">
                * Data aparatur desa dapat diperbarui melalui panel administrasi.
            </p>
        </div>
    </div>
</section>

@endsection
