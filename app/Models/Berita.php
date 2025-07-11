<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel di database Anda (pastikan ini sesuai, yaitu 'berita')
    protected $table = 'berita';

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'judul_berita',
        'penulis',
        'isi_berita',
        'kategori_id',
    ];

    // Matikan timestamps default Laravel karena Anda pakai kolom kustom
    public $timestamps = false;

    // Cast kolom tanggal agar otomatis menjadi instance Carbon
    protected $casts = [
        'tanggal_dibuat' => 'datetime:Y-m-d H:i:s',
        'tanggal_diedit' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Relasi one-to-many: berita memiliki banyak foto.
     * Kita asumsikan tabel foto adalah 'foto_berita' dan Model 'FotoBerita'.
     */
    public function fotoBerita() // Menggunakan singular 'fotoBerita'
    {
        return $this->hasMany(FotoBerita::class, 'berita_id');
    }

    public function fotoBeritas()
    {
        return $this->hasMany(FotoBerita::class);
    }

    /**
     * Relasi many-to-one: berita dimiliki oleh satu kategori.
     * Menggunakan foreign key 'kategori_id' di tabel 'berita'.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    //     public function kategoris()
    // {
    //     return $this->belongsToMany(Kategori::class, 'berita_kategori', 'berita_id', 'kategori_id');
    // }

    /**
     * Aksesor: Mendapatkan URL thumbnail berita.
     */
    public function getThumbnailUrlAttribute(): string
    {
        // Sesuaikan jika relasi Anda menggunakan nama 'fotoBerita' (singular)
        $thumbnail = $this->fotoBerita()->where('tipe', 'thumbnail')->first();

        return $thumbnail
            ? asset('storage/' . $thumbnail->nama_gambar)
            : 'https://placehold.co/100x100/A0AEC0/FFFFFF?text=No+Thumbnail';
    }

    /**
     * Aksesor: Mendapatkan ringkasan isi berita.
     */
    public function getRingkasanAttribute(): string
    {
        return Str::limit(strip_tags($this->isi_berita), 150, '...');
    }

    /**
     * Relasi one-to-many: berita memiliki banyak kunjungan.
     */
    public function kunjungan()
    {
        return $this->hasMany(KunjunganBerita::class, 'berita_id');
    }
}
