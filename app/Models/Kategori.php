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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_diedit' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug'; 
    }


    public function aplikasi()
    {
        return $this->hasMany(Aplikasi::class, 'id_kategori');
    }

    /**
     * Relasi many-to-many dengan Berita.
     * Sebuah kategori bisa dimiliki oleh banyak berita.
     */
    public function beritas()
    {
        // Parameter: Model terkait, nama tabel pivot, foreign key di pivot untuk model ini, foreign key di pivot untuk model terkait
        return $this->belongsToMany(Berita::class, 'berita_kategori', 'kategori_id', 'berita_id');
    }
}