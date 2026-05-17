<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
    protected $table = 'statistik';

    protected $fillable = ['kategori', 'label', 'nilai', 'satuan', 'urutan'];

    protected $casts = [
        'nilai' => 'integer',
    ];

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori)->orderBy('urutan');
    }

    // Menghitung persentase nilai terhadap total kategori yang sama
    public function getPresentaseAttribute(): float
    {
        $total = static::where('kategori', $this->kategori)->sum('nilai');
        if ($total == 0) return 0;
        return round(($this->nilai / $total) * 100, 1);
    }
}
