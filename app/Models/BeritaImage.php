<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaImage extends Model
{
    protected $table = 'berita_images';

    protected $fillable = [
        'berita_id',
        'foto',
        'is_utama',
    ];

    protected $casts = [
        'is_utama' => 'boolean',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return asset('storage/' . $this->foto);
    }
}