<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $layanan->label_jenis }} — {{ $layanan->nomor_referensi }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #e8e8e8;
        }

        /* ============================================================
           BAR NAVIGASI — hanya tampil di layar, HILANG saat print
           ============================================================ */
        .preview-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: #2D5016;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .preview-bar__info {
            color: rgba(255,255,255,0.85);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }
        .preview-bar__info strong { color: #C8952A; }
        .preview-bar__actions { display: flex; gap: 10px; align-items: center; }
        .btn-cetak {
            background: #C8952A;
            color: #1a3a08;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
        }
        .btn-cetak:hover { background: #e8b84b; }
        .btn-kembali {
            color: rgba(255,255,255,0.7);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            text-decoration: none;
            padding: 8px 12px;
        }
        .btn-kembali:hover { color: #fff; }

        /* Wrapper untuk pratinjau di layar */
        .page-wrapper {
            padding: 60px 20px 30px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* ============================================================
           KERTAS SURAT
           ============================================================ */
        .surat {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            padding: 18mm 20mm 20mm 25mm;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        }

        /* ============================================================
           KOP SURAT — 2 logo simetris
           ============================================================ */
        .kop {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }
        .kop-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .kop-logo {
            width: 68px;
            height: 68px;
            border: 2.5px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kop-logo-teks {
            font-family: 'Times New Roman', Times, serif;
            font-size: 7.5pt;
            font-weight: bold;
            text-align: center;
            line-height: 1.3;
            padding: 0 4px;
        }
        .kop-teks { text-align: center; flex: 1; }
        .kop-teks .t-provinsi  { font-size: 11pt; }
        .kop-teks .t-kabupaten { font-size: 13pt; font-weight: bold; }
        .kop-teks .t-kecamatan { font-size: 11pt; }
        .kop-teks .t-desa      { font-size: 18pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .kop-teks .t-alamat    { font-size: 8.5pt; color: #333; margin-top: 3px; }

        /* ============================================================
           JUDUL & NOMOR
           ============================================================ */
        .judul-surat {
            text-align: center;
            margin: 16px 0 4px;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .nomor-surat {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 18px;
        }

        /* ============================================================
           ISI SURAT
           ============================================================ */
        .paragraf {
            text-align: justify;
            margin-bottom: 12px;
            font-size: 12pt;
            line-height: 1.75;
        }

        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .tabel-data td {
            font-size: 11.5pt;
            padding: 3px 4px;
            vertical-align: top;
            line-height: 1.6;
        }
        .tabel-data .col-label { width: 185px; }
        .tabel-data .col-titik { width: 14px; }

        /* ============================================================
           TANDA TANGAN
           ============================================================ */
        .ttd-section {
            margin-top: 22px;
            display: flex;
            justify-content: flex-end;
        }
        .ttd-box { text-align: center; width: 230px; }
        .ttd-box .ttd-kota    { font-size: 11.5pt; margin-bottom: 4px; }
        .ttd-box .ttd-jabatan { font-size: 11.5pt; }
        .ttd-ruang {
            height: 90px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stempel-image {
            position: absolute;
            width: 95px;
            height: 95px;
            object-fit: contain;
            opacity: 0.85;
            left: 30px;
            top: -2px;
            z-index: 2;
        }
        .ttd-image {
            position: absolute;
            width: 130px;
            height: 75px;
            object-fit: contain;
            z-index: 1;
            top: 8px;
        }
        .ttd-box .ttd-garis { font-size: 12pt; margin-top: 4px; }
        .ttd-box .ttd-nama  { font-size: 11.5pt; font-weight: bold; text-decoration: underline; }

        /* ============================================================
           CATATAN KAKI
           ============================================================ */
        .catatan-kaki {
            margin-top: 30px;
            border-top: 1px solid #999;
            padding-top: 6px;
            font-size: 7.5pt;
            color: #666;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
        }

        /* ============================================================
           @media print — INI KUNCINYA
           Semua elemen selain .surat disembunyikan saat print/save PDF
           ============================================================ */
        @media print {
            /* Sembunyikan bar navigasi */
            .preview-bar {
                display: none !important;
            }

            /* Hapus background abu & padding wrapper */
            body {
                background: #fff !important;
            }
            .page-wrapper {
                padding: 0 !important;
                display: block !important;
                background: none !important;
            }

            /* Surat tampil penuh tanpa bayangan */
            .surat {
                width: 100% !important;
                min-height: auto !important;
                box-shadow: none !important;
                padding: 12mm 15mm 15mm 20mm !important;
            }

            /* Hindari pemotongan di tengah elemen */
            .paragraf,
            .tabel-data,
            .ttd-section,
            .catatan-kaki {
                page-break-inside: avoid;
            }
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>
<body>

    {{-- ===== BAR NAVIGASI (hilang otomatis saat print) ===== --}}
    <div class="preview-bar">
        <div class="preview-bar__info">
            🖨 Pratinjau Surat &nbsp;·&nbsp;
            <strong>{{ $layanan->nomor_referensi }}</strong>
            &nbsp;·&nbsp; {{ $layanan->nama_lengkap }}
        </div>
        <div class="preview-bar__actions">
            <button class="btn-cetak" onclick="window.print()">
                🖨️ Cetak / Simpan PDF
            </button>
            @if(request()->is('operator/*') || request()->routeIs('operator.*'))
            <a href="{{ route('operator.layanan.show', $layanan) }}" class="btn-kembali">
            @else
            <a href="{{ route('admin.layanan.show', $layanan) }}" class="btn-kembali">
            @endif
                ← Kembali
            </a>
        </div>
    </div>

    {{-- ===== WRAPPER PRATINJAU ===== --}}
    <div class="page-wrapper">
        <div class="surat">

            {{-- KOP SURAT --}}
            <div class="kop">
                <div class="kop-inner">
                    {{-- Logo Kiri: Kabupaten Pelalawan --}}
                    <div class="logo">
                        @if(file_exists(public_path('logo/logo-pelalawan.png')))
                            <img src="{{ asset('logo/logo-pelalawan.png') }}"
                                 width="88" height="88" style="object-fit:contain">
                        @else
                            <div class="kop-logo-teks">KAB.<br>PELA<br>LAWAN</div>
                        @endif
                    </div>

                    {{-- Teks Tengah --}}
                    <div class="kop-teks">
                        <div class="t-provinsi">PEMERINTAH PROVINSI RIAU</div>
                        <div class="t-kabupaten">KABUPATEN PELALAWAN</div>
                        <div class="t-kecamatan">KECAMATAN PANGKALAN KURAS</div>
                        <div class="t-desa">DESA KEMANG</div>
                        <div class="t-alamat">
                            Jl. Raya Desa Kemang, Kec. Pangkalan Kuras, Kab. Pelalawan, Riau
                            &nbsp;|&nbsp; Telp. +62 822-8575-3837
                        </div>
                    </div>

                    {{-- Logo Kanan: Desa Kemang --}}
                    <div class="logo">
                        @if(file_exists(public_path('logo/logo-pelalawan.png')))
                            <img src="{{ asset('logo/logo-pelalawan.png') }}"
                                 width="88" height="88" style="object-fit:contain">
                        @else
                            <div class="kop-logo-teks">DESA<br>KE<br>MANG</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- JUDUL SURAT --}}
            <div class="judul-surat">{{ strtoupper($layanan->label_jenis) }}</div>
            <div class="nomor-surat">
                Nomor: {{ $layanan->nomor_referensi }}/DESA-KMG/{{ now()->format('Y') }}
            </div>

            {{-- PEMBUKA --}}
            <p class="paragraf">
                Yang bertanda tangan di bawah ini, Kepala Desa Kemang, Kecamatan Pangkalan Kuras,
                Kabupaten Pelalawan, Provinsi Riau, dengan ini menerangkan bahwa:
            </p>

            {{-- DATA DIRI --}}
            <table class="tabel-data">
                <tr>
                    <td class="col-label">Nama Lengkap</td>
                    <td class="col-titik">:</td>
                    <td><strong>{{ $layanan->nama_lengkap }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">NIK</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->nik }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat / Tgl. Lahir</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->tempat_lahir }}, {{ $layanan->tanggal_lahir_format }}</td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->agama }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->pekerjaan }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->alamat }}, Desa Kemang, Kec. Pangkalan Kuras</td>
                </tr>
                @if($layanan->jenis_surat === 'usaha')
                <tr>
                    <td class="col-label">Nama Usaha</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->nama_usaha }}</td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Usaha</td>
                    <td class="col-titik">:</td>
                    <td>{{ $layanan->jenis_usaha }}</td>
                </tr>
                @endif
            </table>

            {{-- ISI SURAT per jenis --}}
            @if($layanan->jenis_surat === 'domisili')
            <p class="paragraf">
                Adalah benar warga Desa Kemang, Kecamatan Pangkalan Kuras, Kabupaten Pelalawan
                dan <strong>benar-benar berdomisili</strong> di alamat tersebut di atas. Surat
                keterangan ini diberikan untuk keperluan: <strong>{{ $layanan->keperluan }}</strong>.
            </p>

            @elseif($layanan->jenis_surat === 'usaha')
            <p class="paragraf">
                Adalah benar warga Desa Kemang dan <strong>benar-benar menjalankan usaha</strong>
                dengan nama <strong>{{ $layanan->nama_usaha }}</strong>
                ({{ $layanan->jenis_usaha }}) yang berlokasi di Desa Kemang, Kecamatan Pangkalan
                Kuras, Kabupaten Pelalawan. Surat keterangan ini diberikan untuk keperluan:
                <strong>{{ $layanan->keperluan }}</strong>.
            </p>

            @elseif($layanan->jenis_surat === 'tidak_mampu')
            <p class="paragraf">
                Adalah benar warga Desa Kemang yang menurut pengamatan dan keterangan yang kami
                ketahui adalah tergolong <strong>warga yang kurang mampu secara ekonomi</strong>.
                Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan:
                <strong>{{ $layanan->keperluan }}</strong>.
            </p>

            @elseif($layanan->jenis_surat === 'pengantar_ktpkk')
            <p class="paragraf">
                Adalah benar warga Desa Kemang, Kecamatan Pangkalan Kuras, Kabupaten Pelalawan.
                Surat pengantar ini diberikan kepada yang bersangkutan untuk keperluan
                <strong>pengurusan {{ $layanan->keperluan }}</strong> pada instansi yang
                berwenang. Kepada instansi terkait, mohon kiranya dapat memberikan pelayanan
                sebagaimana mestinya.
            </p>
            @endif

            {{-- PENUTUP --}}
            <p class="paragraf">
                Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dipergunakan
                sebagaimana mestinya. Apabila di kemudian hari terdapat kekeliruan dalam surat
                keterangan ini, maka akan diadakan perbaikan sebagaimana mestinya.
            </p>

            {{-- TANDA TANGAN --}}
            <div class="ttd-section">
                <div class="ttd-box">
                    <p class="ttd-kota">Kemang, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="ttd-jabatan">Kepala Desa Kemang,</p>
                    <div class="ttd-ruang">
                        @if($layanan->status === 'disetujui')
                            <img src="{{ asset('images/ttd-kades.png') }}" class="ttd-image" alt="Tanda Tangan Kades">
                            <img src="{{ asset('images/stempel-desa.png') }}" class="stempel-image" alt="Stempel Desa">
                        @else
                            <div style="font-size: 8pt; color: #888; font-style: italic; border: 1px dashed #ccc; padding: 10px 15px; border-radius: 4px; font-family: var(--font-ui)">
                                Belum Divalidasi
                            </div>
                        @endif
                    </div>
                    <p class="ttd-garis">( _________________________ )</p>
                    <p class="ttd-nama">Lukman Hakim</p>
                </div>
            </div>

            {{-- CATATAN KAKI --}}
            <div class="catatan-kaki">
                Surat ini diterbitkan secara digital melalui sistem e-layanan Desa Kemang.
                &nbsp;·&nbsp; Nomor Referensi: <strong>{{ $layanan->nomor_referensi }}</strong>
                &nbsp;·&nbsp; Diterbitkan: {{ now()->translatedFormat('d F Y') }}
            </div>

        </div>
    </div>

</body>
</html>
