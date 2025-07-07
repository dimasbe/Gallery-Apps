<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; 

    protected $fillable = [
        'sub_kategori',
        'nama_kategori',
        'gambar',
        'tanggal_dibuat',
        'tanggal_diedit',
    ];
    
    public $timestamps = false;
    
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diedit';

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_diedit' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug'; 
    }

    /**
     * Relasi ke tabel aplikasi (one to many)
     */
    public function aplikasi()
    {
        return $this->hasMany(Aplikasi::class, 'id_kategori');
    }

    /**
     * Relasi ke tabel berita (one to many)
     */
    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }
}
