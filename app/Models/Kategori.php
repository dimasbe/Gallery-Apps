<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; // Specify the table name if it's not the plural form of the model name

    protected $fillable = [
        'sub_kategori',
        'nama_kategori',
        'gambar',
        'tanggal_dibuat',
        'tanggal_diedit',
    ];

    // Disable default timestamps if you're managing them manually
    public $timestamps = false;

    // Define custom timestamp column names if they are different from 'created_at' and 'updated_at'
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

    public function aplikasi()
    {
        return $this->hasMany(Aplikasi::class, 'id_kategori');
    }

    /**
     * Relasi many-to-many dengan Berita.
     * Sebuah kategori bisa dimiliki oleh banyak berita.
     */
    public function berita()
    {
        return $this->belongsToMany(Berita::class, 'berita_kategori', 'kategori_id', 'berita_id');
    }
}