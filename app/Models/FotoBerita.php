<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // Jika tabel tidak pakai timestamps
    public $timestamps = false;

    /**
     * Relasi many-to-one dengan Berita.
     * Sebuah foto berita dimiliki oleh satu berita.
     */
    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }
}
