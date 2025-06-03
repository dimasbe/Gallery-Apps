<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul_berita',
        'penulis',
        'isi_berita',
        'tanggal_dibuat',
        'tanggal_diedit',
    ];

    // Matikan timestamps default
    public $timestamps = false;

    // Cast kolom tanggal agar otomatis menjadi instance Carbon
    protected $casts = [
        'tanggal_dibuat' => 'datetime:Y-m-d H:i:s',
        'tanggal_diedit' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Relasi one-to-many: berita memiliki banyak foto
     */
    public function fotoBeritas()
    {
        return $this->hasMany(FotoBerita::class, 'berita_id');
    }

    /**
     * Relasi many-to-many: berita memiliki banyak kategori
     */
    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategori', 'berita_id', 'kategori_id');
    }

    /**
     * Akses custom untuk thumbnail
     */
    public function getThumbnailUrlAttribute(): string
    {
        $thumbnail = $this->fotoBeritas()->where('tipe', 'thumbnail')->first();

        return $thumbnail
            ? asset('storage/' . $thumbnail->nama_gambar)
            : 'https://placehold.co/100x100/A0AEC0/FFFFFF?text=No+Thumbnail';
    }

    /**
     * Akses custom untuk ringkasan isi berita
     */
    public function getRingkasanAttribute(): string
    {
        return \Str::limit(strip_tags($this->isi_berita), 150, '...');
    }
}
