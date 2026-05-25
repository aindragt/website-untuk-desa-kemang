@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero__pattern"></div>
    <div class="container hero__content">
        <div class="hero__badge">🏡 Website Resmi</div>
        <h1>Selamat Datang di<br><span>Desa Kemang</span></h1>
        <p class="hero__sub">Kecamatan Pangkalan Kuras · Kabupaten Pelalawan · Provinsi Riau</p>
        <p class="hero__desc">
            Bersama membangun desa yang maju, sejahtera, dan berbudaya.
            Melestarikan kearifan lokal Melayu dalam bingkai pembangunan yang berkelanjutan.
        </p>
        <a href="{{ route('profil') }}" class="hero__cta">Jelajahi Desa →</a>

        <div class="hero__stats">
            <div>
                <div class="hero__stat-num" data-counter="{{ $statistikRingkas['total_penduduk'] }}">{{ number_format($statistikRingkas['total_penduduk'], 0, ',', '.') }}</div>
                <div class="hero__stat-lbl">Penduduk</div>
            </div>
            <div>
                <div class="hero__stat-num" data-counter="{{ $statistikRingkas['jumlah_kk'] }}">{{ $statistikRingkas['jumlah_kk'] }}</div>
                <div class="hero__stat-lbl">Kepala Keluarga</div>
            </div>
            <div>
                <div class="hero__stat-num" data-counter="{{ $statistikRingkas['luas_wilayah'] }}">{{ number_format($statistikRingkas['luas_wilayah']) }}</div>
                <div class="hero__stat-lbl">Hektare Luas</div>
            </div>
            <div>
                <div class="hero__stat-num" data-counter="{{  $statistikRingkas['jumlah_dusun'] }}">{{ $statistikRingkas['jumlah_dusun'] }}</div>
                <div class="hero__stat-lbl">Dusun</div>
            </div>
        </div>
    </div>
</section>

<div class="motif-divider"></div>

{{-- ===== PROFIL SINGKAT ===== --}}
<section class="section">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
                <div class="section-eyebrow">Tentang Kami</div>
                <h2 class="section-title">Mengenal Desa Kemang</h2>
                <p class="section-desc mb-5">
                    Desa Kemang adalah salah satu desa yang terletak di Kecamatan Pangkalan Kuras,
                    Kabupaten Pelalawan, Provinsi Riau. Desa ini memiliki kekayaan budaya Melayu yang
                    kental serta potensi alam yang melimpah.
                </p>
                <p class="text-stone-700 text-[0.9rem] leading-[1.8] mb-7">
                    Dialiri sungai Kampar di sisi barat, Desa Kemang menyimpan potensi besar di bidang
                    pertanian, perkebunan, and perikanan air tawar. Warganya dikenal menjaga tradisi
                    gotong royong dan adat istiadat Melayu dengan penuh kebanggaan.
                </p>
                <a href="{{ route('profil') }}" class="btn btn--primary w-auto inline-flex">
                    Baca Selengkapnya
                </a>
            </div>
            <div class="profil-grid">
                <div class="profil-card">
                    <div class="profil-card__icon">🗺️</div>
                    <div class="profil-card__title">Wilayah</div>
                    <p class="profil-card__text">Luas ±1.240 ha. Berbatasan dengan Sungai Kampar di sisi barat desa.</p>
                </div>
                <div class="profil-card">
                    <div class="profil-card__icon">🌿</div>
                    <div class="profil-card__title">Potensi</div>
                    <p class="profil-card__text">Sawit, karet, ikan air tawar, dan kerajinan anyaman rotan.</p>
                </div>
                <div class="profil-card">
                    <div class="profil-card__icon">🎯</div>
                    <div class="profil-card__title">Visi</div>
                    <p class="profil-card__text">Mewujudkan Desa Kemang yang mandiri, berbudaya, dan sejahtera.</p>
                </div>
                <div class="profil-card">
                    <div class="profil-card__icon">🤝</div>
                    <div class="profil-card__title">Gotong Royong</div>
                    <p class="profil-card__text">Semangat kebersamaan yang terus terjaga antar warga desa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="motif-divider"></div>

{{-- ===== LEMBAGA DESA ===== --}}
<section class="section section--alt">
    <div class="container">
        <div class="text-center mb-10">
            <div class="section-eyebrow justify-center">Organisasi Kemasyarakatan</div>
            <h2 class="section-title">Lembaga Desa</h2>
            <p class="section-desc mx-auto">
                Desa Kemang didukung berbagai lembaga kemasyarakatan yang aktif bergerak demi kesejahteraan warga.
            </p>
        </div>
        <div class="lembaga-grid">
            @foreach ([
                ['🏛️', 'BPD', 'Badan Permusyawaratan Desa, mitra strategis pemerintah desa dalam pengambilan keputusan.'],
                ['👩‍👧‍👦', 'TP. PKK', 'Pemberdayaan dan Kesejahteraan Keluarga, menggerakkan program sosial kemasyarakatan.'],
                ['⭐', 'Karang Taruna', 'Wadah pengembangan generasi muda yang kreatif, aktif, dan berdedikasi.'],
                ['🌾', 'Kelompok Tani', 'Mendorong produktivitas sektor pertanian dan perkebunan warga desa.'],
                ['🎭', 'Lembaga Adat', 'Penjaga nilai, tradisi, dan budaya Melayu Desa Kemang.'],
                ['🐟', 'Kelompok Nelayan', 'Mengelola dan mengembangkan potensi perikanan air tawar.'],
            ] as $lembaga)
            <div class="lembaga-card">
                <div class="lembaga-card__icon">{{ $lembaga[0] }}</div>
                <div class="lembaga-card__title">{{ $lembaga[1] }}</div>
                <p class="lembaga-card__desc">{{ $lembaga[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="motif-divider"></div>



{{-- ===== LAYANAN SURAT DESA ===== --}}
<section class="section">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
                <div class="section-eyebrow">Pelayanan Publik Online</div>
                <h2 class="section-title">Layanan Surat Desa</h2>
                <p class="text-stone-700 text-[0.95rem] leading-[1.8] mb-7">
                    Ajukan surat keterangan secara online tanpa perlu datang ke kantor terlebih dahulu.
                    Cukup isi formulir, dan surat Anda akan diproses oleh perangkat desa.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-7">
                    @foreach([
                        ['🏠','Surat Keterangan Domisili','domisili'],
                        ['🏪','Surat Keterangan Usaha','usaha'],
                        ['📋','Surat Keterangan Tidak Mampu','tidak_mampu'],
                        ['🪪','Surat Pengantar KTP / KK','pengantar_ktpkk'],
                    ] as [$ikon,$nama,$kode])
                    <a href="{{ route('layanan.form', $kode) }}"
                       class="flex items-center gap-2 p-3 bg-krem border border-[#D9C8A8] rounded font-ui text-[0.78rem] text-stone-900 transition-all duration-200 hover:bg-white hover:border-emas">
                        <span class="text-[1.1rem]">{{ $ikon }}</span>
                        <span>{{ $nama }}</span>
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('layanan.index') }}" class="btn btn--primary w-auto inline-flex">
                    Lihat Semua Layanan →
                </a>
            </div>
            <div class="bg-hijau rounded-lg p-8 text-white">
                <div class="font-display text-[1rem] text-emas mb-5">
                    Alur Pengajuan Surat
                </div>
                @foreach([
                    ['📝','Pilih jenis surat yang dibutuhkan'],
                    ['✍️','Isi formulir online dengan data yang benar'],
                    ['📨','Submit — dapatkan nomor referensi'],
                    ['⏳','Tunggu 1–3 hari kerja proses'],
                    ['🏢','Ambil surat ke kantor desa'],
                ] as $i => [$ikon,$teks])
                <div class="flex gap-3 items-start {{ $i < 4 ? 'mb-3.5' : 'mb-0' }}">
                    <div class="w-7 h-7 rounded-full bg-[#C8952A]/20 border border-emas flex items-center justify-center text-[0.85rem] shrink-0">
                        {{ $ikon }}
                    </div>
                    <p class="font-ui text-[0.82rem] text-white/75 pt-1 leading-relaxed">
                        {{ $teks }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<div class="motif-divider"></div>

{{-- ===== BERITA TERBARU ===== --}}
<section class="section section--alt">
    <div class="container">
        <div class="flex items-end justify-between mb-10 flex-wrap gap-4">
            <div>
                <div class="section-eyebrow">Informasi Terkini</div>
                <h2 class="section-title mb-0">Berita Desa</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="font-ui text-[0.82rem] font-semibold text-emas">Semua Berita →</a>
        </div>
        <div class="berita-grid">
            @forelse($beritaTerbaru as $b)
            <article class="berita-card">
                @if($b->images->isNotEmpty() || $b->foto)
                    <img src="{{ $b->foto_url }}" alt="{{ $b->judul }}" class="berita-card__thumb" loading="lazy">
                @else
                    <div class="berita-card__thumb--placeholder">📰</div>
                @endif
                <div class="berita-card__body">
                    <div class="berita-card__meta">
                        <span class="berita-card__kategori">{{ \App\Models\Berita::kategoriList()[$b->kategori] ?? $b->kategori }}</span>
                        <span class="berita-card__tanggal">{{ $b->tanggal_format }}</span>
                    </div>
                    <h3 class="berita-card__judul">{{ $b->judul }}</h3>
                    <p class="berita-card__ringkasan">{{ $b->ringkasan_auto }}</p>
                    <a href="{{ route('berita.show', $b->slug) }}" class="berita-card__link">Baca selengkapnya →</a>
                </div>
            </article>
            @empty
            <p class="text-stone-500 text-[0.9rem]">Belum ada berita tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<div class="motif-divider"></div>

{{-- ===== CTA KONTAK ===== --}}
<section class="section section--dark text-center">
    <div class="container">
        <div class="section-eyebrow justify-center">Hubungi Kami</div>
        <h2 class="section-title text-white mb-3">Ada Pertanyaan atau Keperluan?</h2>
        <p class="text-white/55 text-[0.95rem] mb-8 max-w-[480px] mx-auto">
            Tim pemerintahan Desa Kemang siap membantu. Hubungi kami melalui formulir kontak atau kunjungi kantor desa.
        </p>
        <a href="{{ route('kontak') }}" class="hero__cta">Hubungi Kami →</a>
    </div>
</section>

@endsection
