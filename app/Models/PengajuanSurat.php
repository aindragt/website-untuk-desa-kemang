<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PengajuanSurat extends Model
{
    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'nomor_referensi', 'jenis_surat', 'nama_lengkap', 'nik',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama',
        'pekerjaan', 'alamat', 'no_hp', 'keperluan',
        'nama_usaha', 'jenis_usaha', 'nama_pasangan',
        'keterangan_tambahan', 'status', 'catatan_admin',
        'diproses_at', 'selesai_at',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'diproses_at'   => 'datetime',
        'selesai_at'    => 'datetime',
    ];

    // -------------------------------------------------------
    // Boot: generate nomor referensi otomatis
    // -------------------------------------------------------
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->nomor_referensi = static::generateNomorReferensi($model->jenis_surat);
        });
    }

    public static function generateNomorReferensi(string $jenisSurat): string
    {
        $prefix = match ($jenisSurat) {
            'domisili'       => 'SKD',
            'usaha'          => 'SKU',
            'tidak_mampu'    => 'SKM',
            'pengantar_ktpkk'=> 'SPK',
            default          => 'SKT',
        };

        do {
            $nomor = $prefix . '-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        } while (static::where('nomor_referensi', $nomor)->exists());

        return $nomor;
    }

    // -------------------------------------------------------
    // Scopes
    // -------------------------------------------------------
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // -------------------------------------------------------
    // Helpers / Accessors
    // -------------------------------------------------------
    public static function daftarJenis(): array
    {
        return [
            'domisili'        => 'Surat Keterangan Domisili',
            'usaha'           => 'Surat Keterangan Usaha',
            'tidak_mampu'     => 'Surat Keterangan Tidak Mampu',
            'pengantar_ktpkk' => 'Surat Pengantar KTP / KK',
        ];
    }

    public static function daftarAgama(): array
    {
        return ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    }

    public function getLabelJenisAttribute(): string
    {
        return static::daftarJenis()[$this->jenis_surat] ?? $this->jenis_surat;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu'  => 'Menunggu',
            'diproses'  => 'Diproses',
            'selesai'   => 'Selesai',
            'ditolak'   => 'Ditolak',
            default     => ucfirst($this->status),
        };
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'badge--emas',
            'diproses' => 'badge--hijau',
            'selesai'  => 'badge--hijau',
            'ditolak'  => 'badge--merah',
            default    => 'badge--abu',
        };
    }

    public function getTanggalLahirFormatAttribute(): string
    {
        return $this->tanggal_lahir?->translatedFormat('d F Y') ?? '-';
    }

    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir?->age ?? 0;
    }

    public function getTanggalPengajuanAttribute(): string
    {
        return $this->created_at->translatedFormat('d F Y, H:i') . ' WIB';
    }
}
