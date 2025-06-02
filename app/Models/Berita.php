<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model
    protected $table = 'berita';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'judul_berita',
        'penulis',
        'isi_berita',
    ];

    // Kolom tanggal yang akan secara otomatis dikelola oleh Eloquent
    // Nonaktifkan timestamps bawaan karena kita punya kolom kustom
    public $timestamps = false; // Nonaktifkan timestamps bawaan Laravel

    // Atribut yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_diedit' => 'datetime',
    ];

    /**
     * Relasi one-to-many dengan FotoBerita.
     * Sebuah berita bisa memiliki banyak foto.
     */
    public function fotoBeritas()
    {
        return $this->hasMany(FotoBerita::class, 'berita_id');
    }

    /**
     * Relasi many-to-many dengan Kategori.
     * Sebuah berita bisa memiliki banyak kategori.
     */
    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategori', 'berita_id', 'kategori_id');
    }

    /**
     * Ambil URL thumbnail berita.
     * Mengambil foto dengan tipe 'thumbnail' jika ada.
     */
    public function getThumbnailUrlAttribute()
    {
        $thumbnail = $this->fotoBeritas()->where('tipe', 'thumbnail')->first();
        return $thumbnail ? asset('storage/' . $thumbnail->nama_gambar) : 'https://placehold.co/100x100/A0AEC0/FFFFFF?text=No+Thumbnail'; // Placeholder jika tidak ada thumbnail
    }
}