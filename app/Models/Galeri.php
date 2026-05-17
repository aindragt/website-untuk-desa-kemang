<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'judul', 'foto', 'kategori', 'keterangan', 'urutan', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function getFotoUrlAttribute(): string
    {
        return asset('storage/' . $this->foto);
    }

    public static function kategoriList(): array
    {
        return [
            'umum'          => 'Semua',
            'kegiatan'      => 'Kegiatan',
            'infrastruktur' => 'Infrastruktur',
            'budaya'        => 'Budaya',
            'alam'          => 'Alam & Lingkungan',
        ];
    }
}
