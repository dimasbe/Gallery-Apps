<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str helper untuk membuat slug

class Aplikasi extends Model
{
    use HasFactory;

    protected $table = 'aplikasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'nama_aplikasi',
        'logo',
        'id_kategori',
        'nama_pemilik',
        'tanggal_rilis',
        'versi',
        'rating_konten',
        'jumlah_kunjungan',
        'tautan_aplikasi',
        'deskripsi',
        'fitur',
        'status_verifikasi',
        'arsip',
        'tanggal_ditambahkan',
        'tanggal_verifikasi',
        'alasan_penolakan',
        'tanggal_diarsipkan',
        'slug', // <<< TAMBAHKAN INI: Kolom slug
    ];

    protected $dates = [
        'tanggal_rilis',
        'tanggal_ditambahkan',
        'tanggal_verifikasi',
        'tanggal_diarsipkan',
    ];

    protected $casts = [
        'tanggal_rilis' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'rating_konten' => 'float',
        'jumlah_kunjungan' => 'integer',
        'tanggal_diarsipkan' => 'datetime',
        'arsip' => 'boolean', // Cast 'arsip' to a boolean for easier use (0/1 will be true/false)
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_aplikasi');
    }

    public function fotoAplikasi()
    {
        return $this->hasMany(FotoAplikasi::class, 'id_aplikasi');
    }

    public function fotoUtama()
    {
        return $this->hasOne(FotoAplikasi::class, 'id_aplikasi')->latestOfMany();
    }

}