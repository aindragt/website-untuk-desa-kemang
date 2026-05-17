<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $layanan->label_jenis }} — {{ $layanan->nomor_referensi }}</title>
    <style>
        /* ============================================================
           DESA KEMANG — Template PDF Surat Pengantar
           Dioptimalkan untuk DomPDF (tidak mendukung flexbox/grid)
           ============================================================ */

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            line-height: 1.4;
        }

        .halaman {
            width: 100%;
            padding: 10mm 20mm 15mm 25mm;
        }

        /* ---- KOP SURAT ---- */
        .kop {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        /* Tabel untuk layout kop agar DomPDF bisa render dengan benar */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }
        .kop-logo-cell {
            width: 70px;
            text-align: center;
        }
        .kop-teks-cell {
            text-align: center;
            padding: 0 8px;
        }
        .kop-logo-kiri, .kop-logo-kanan {
            width: 62px;
            height: 62px;
            border: 2px solid #000;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            line-height: 58px;
            font-size: 13pt;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Teks kop */
        .kop-provinsi  { font-size: 10.5pt; }
        .kop-kabupaten { font-size: 13pt; font-weight: bold; }
        .kop-kecamatan { font-size: 10.5pt; }
        .kop-desa      { font-size: 17pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .kop-alamat    { font-size: 8.5pt; margin-top: 3px; color: #333; }

        /* ---- JUDUL SURAT ---- */
        .judul-wrapper {
            text-align: center;
            margin: 14px 0 4px;
        }
        .judul-surat {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .nomor-surat {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 16px;
        }

        /* ---- ISI SURAT ---- */
        .paragraf {
            text-align: justify;
            margin-bottom: 12px;
            font-size: 12pt;
            line-height: 1.7;
        }

        /* Tabel data diri */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 11.5pt;
        }
        .tabel-data td {
            padding: 2.5px 4px;
            vertical-align: top;
        }
        .tabel-data .kolom-label { width: 180px; }
        .tabel-data .kolom-titik { width: 12px; }

        /* ---- TANDA TANGAN ---- */
        .ttd-wrapper {
            width: 100%;
            margin-top: 20px;
        }
        .ttd-tabel {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-tabel td { vertical-align: top; }
        .ttd-kiri { width: 55%; }
        .ttd-kanan {
            width: 45%;
            text-align: center;
        }
        .ttd-tempat    { font-size: 11.5pt; margin-bottom: 4px; }
        .ttd-jabatan   { font-size: 11.5pt; margin-bottom: 56px; }
        .ttd-nama      { font-size: 12pt; font-weight: bold; text-decoration: underline; }
        .ttd-sub-nama  { font-size: 10pt; }
        .ttd-garis     { font-size: 12pt; }

        /* ---- CATATAN KAKI ---- */
        .catatan-kaki {
            width: 100%;
            margin-top: 28px;
            border-top: 1px solid #888;
            padding-top: 6px;
            font-size: 8pt;
            color: #555;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* ---- STEMPEL AREA ---- */
        .stempel-area {
            width: 80px;
            height: 80px;
            border: 1px dashed #ccc;
            border-radius: 50%;
            display: inline-block;
            margin: 4px 0;
            text-align: center;
            line-height: 78px;
            font-size: 7pt;
            color: #ccc;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
<div class="halaman">

    {{-- ===== KOP SURAT ===== --}}
    <div class="kop">
        <table class="kop-table">
            <tr>
                {{-- Logo kiri: Kabupaten Pelalawan --}}
                <td class="kop-logo-cell">
                    <div class="kop-logo-kiri">KAB</div>
                </td>

                {{-- Teks tengah --}}
                <td class="kop-teks-cell">
                    <div class="kop-provinsi">PEMERINTAH PROVINSI RIAU</div>
                    <div class="kop-kabupaten">KABUPATEN PELALAWAN</div>
                    <div class="kop-kecamatan">KECAMATAN PANGKALAN KURAS</div>
                    <div class="kop-desa">DESA KEMANG</div>
                    <div class="kop-alamat">
                        Jl. Raya Desa Kemang, Kec. Pangkalan Kuras, Kab. Pelalawan, Riau &nbsp;|&nbsp; Telp. (0761) XXXXXX
                    </div>
                </td>

                {{-- Logo kanan: Desa Kemang --}}
                <td class="kop-logo-cell">
                    <div class="kop-logo-kanan">DK</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== JUDUL SURAT ===== --}}
    <div class="judul-wrapper">
        <span class="judul-surat">{{ strtoupper($layanan->label_jenis) }}</span>
    </div>
    <div class="nomor-surat">
        Nomor: {{ $layanan->nomor_referensi }}/DESA-KMG/{{ now()->format('Y') }}
    </div>

    {{-- ===== KALIMAT PEMBUKA ===== --}}
    <p class="paragraf">
        Yang bertanda tangan di bawah ini, Kepala Desa Kemang, Kecamatan Pangkalan Kuras,
        Kabupaten Pelalawan, Provinsi Riau, dengan ini menerangkan bahwa:
    </p>

    {{-- ===== DATA DIRI PEMOHON ===== --}}
    <table class="tabel-data">
        <tr>
            <td class="kolom-label">Nama Lengkap</td>
            <td class="kolom-titik">:</td>
            <td><strong>{{ $layanan->nama_lengkap }}</strong></td>
        </tr>
        <tr>
            <td class="kolom-label">NIK</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->nik }}</td>
        </tr>
        <tr>
            <td class="kolom-label">Tempat / Tgl. Lahir</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->tempat_lahir }}, {{ $layanan->tanggal_lahir_format }}</td>
        </tr>
        <tr>
            <td class="kolom-label">Jenis Kelamin</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="kolom-label">Agama</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->agama }}</td>
        </tr>
        <tr>
            <td class="kolom-label">Pekerjaan</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->pekerjaan }}</td>
        </tr>
        <tr>
            <td class="kolom-label">Alamat</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->alamat }}, Desa Kemang, Kec. Pangkalan Kuras</td>
        </tr>
        @if($layanan->jenis_surat === 'usaha')
        <tr>
            <td class="kolom-label">Nama Usaha</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->nama_usaha }}</td>
        </tr>
        <tr>
            <td class="kolom-label">Jenis Usaha</td>
            <td class="kolom-titik">:</td>
            <td>{{ $layanan->jenis_usaha }}</td>
        </tr>
        @endif
    </table>

    {{-- ===== ISI SURAT per jenis ===== --}}
    @if($layanan->jenis_surat === 'domisili')
    <p class="paragraf">
        Adalah benar warga Desa Kemang, Kecamatan Pangkalan Kuras, Kabupaten Pelalawan dan
        <strong>benar-benar berdomisili</strong> di alamat tersebut di atas. Surat keterangan
        ini diberikan untuk keperluan: <strong>{{ $layanan->keperluan }}</strong>.
    </p>

    @elseif($layanan->jenis_surat === 'usaha')
    <p class="paragraf">
        Adalah benar warga Desa Kemang dan <strong>benar-benar menjalankan usaha</strong>
        dengan nama usaha <strong>{{ $layanan->nama_usaha }}</strong>
        ({{ $layanan->jenis_usaha }}) yang berlokasi di Desa Kemang, Kecamatan Pangkalan Kuras,
        Kabupaten Pelalawan. Surat keterangan ini diberikan untuk keperluan:
        <strong>{{ $layanan->keperluan }}</strong>.
    </p>

    @elseif($layanan->jenis_surat === 'tidak_mampu')
    <p class="paragraf">
        Adalah benar warga Desa Kemang yang menurut pengamatan dan keterangan yang kami ketahui
        adalah tergolong warga yang <strong>kurang mampu secara ekonomi</strong>.
        Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan:
        <strong>{{ $layanan->keperluan }}</strong>.
    </p>

    @elseif($layanan->jenis_surat === 'pengantar_ktpkk')
    <p class="paragraf">
        Adalah benar warga Desa Kemang, Kecamatan Pangkalan Kuras, Kabupaten Pelalawan.
        Surat pengantar ini diberikan kepada yang bersangkutan untuk keperluan
        <strong>pengurusan {{ $layanan->keperluan }}</strong> pada instansi yang berwenang.
        Kepada instansi terkait, mohon kiranya dapat memberikan pelayanan sebagaimana mestinya.
    </p>
    @endif

    {{-- ===== KALIMAT PENUTUP ===== --}}
    <p class="paragraf">
        Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dipergunakan
        sebagaimana mestinya. Apabila di kemudian hari terdapat kekeliruan dalam surat
        keterangan ini, maka akan diadakan perbaikan sebagaimana mestinya.
    </p>

    {{-- ===== TANDA TANGAN ===== --}}
    <div class="ttd-wrapper">
        <table class="ttd-tabel">
            <tr>
                <td class="ttd-kiri"></td>
                <td class="ttd-kanan">
                    <p class="ttd-tempat">Kemang, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="ttd-jabatan">Kepala Desa Kemang,</p>
                    {{-- Area stempel --}}
                    <div class="stempel-area">Cap<br>Desa</div>
                    <br>
                    <p class="ttd-garis">( _________________________ )</p>
                    <p class="ttd-nama">Kepala Desa Kemang</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== CATATAN KAKI ===== --}}
    <div class="catatan-kaki">
        Surat pengantar ini diterbitkan melalui sistem e-layanan Desa Kemang.
        &nbsp;|&nbsp; No. Referensi: <strong>{{ $layanan->nomor_referensi }}</strong>
        &nbsp;|&nbsp; Diterbitkan: {{ now()->translatedFormat('d F Y') }}
        &nbsp;|&nbsp; Dokumen ini sah setelah ditandatangani dan distempel oleh Kepala Desa.
    </div>

</div>
</body>
</html>
