<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul', 'slug', 'kategori', 'ringkasan',
        'isi', 'foto', 'penulis', 'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
            if (empty($berita->published_at) && $berita->is_published) {
                $berita->published_at = now();
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('published_at');
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function images()
    {
        return $this->hasMany(BeritaImage::class);
    }

    public function getFotoUrlAttribute(): string
    {
        $mainImage = $this->images()->where('is_utama', true)->first();
        if ($mainImage) {
            return $mainImage->foto_url;
        }

        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/berita-default.jpg');
    }

    public function getRingkasanAutoAttribute(): string
    {
        return $this->ringkasan ?: Str::limit(strip_tags($this->isi), 120);
    }

    public function getTanggalFormatAttribute(): string
    {
        return $this->published_at
            ? $this->published_at->translatedFormat('d F Y')
            : $this->created_at->translatedFormat('d F Y');
    }

    public static function kategoriList(): array
    {
        return [
            'umum'         => 'Umum',
            'pembangunan'  => 'Pembangunan',
            'sosial'       => 'Sosial',
            'budaya'       => 'Budaya & Adat',
            'kesehatan'    => 'Kesehatan',
            'pendidikan'   => 'Pendidikan',
        ];
    }
}
