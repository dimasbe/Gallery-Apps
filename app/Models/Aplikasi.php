<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    use HasFactory;

    protected $table = 'aplikasi';
    protected $primaryKey = 'id_aplikasi';

    protected $fillable = [
        'id_user',
        'nama_aplikasi',
        'logo',
        'id_kategori',
        'nama_pemilik',
        'tanggal_rilis',
        'versi',
        'tautan_aplikasi',
        'deskripsi',
        'fitur',
        'status_verifikasi',
        'arsip',
        'tanggal_ditambahkan',
        'tanggal_verifikasi',
        'alasan_penolakan',
    ];

    protected $dates = [
        'tanggal_rilis',
        'tanggal_ditambahkan',
        'tanggal_verifikasi',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAplikasi::class, 'id_kategori', 'id_kategori');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_aplikasi', 'id_aplikasi');
    }

    public function foto()
    {
        return $this->hasMany(FotoAplikasi::class, 'id_aplikasi', 'id_aplikasi');
    }

}
