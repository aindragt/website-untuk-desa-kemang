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


}
