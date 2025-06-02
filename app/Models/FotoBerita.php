<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoBerita extends Model
{
    use HasFactory;

    protected $table = 'foto_berita';

    protected $fillable = [
        'berita_id',
        'nama_gambar',
        'keterangan_gambar',
        'tipe',
    ];

    /**
     * Relasi many-to-one dengan Berita.
     * Sebuah foto berita dimiliki oleh satu berita.
     */
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }
}