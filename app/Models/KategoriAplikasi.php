<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAplikasi extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false; // kalau kamu tidak punya kolom created_at, updated_at di tabel kategori

    protected $fillable = [
        'nama_kategori',
    ];

    public function aplikasi()
    {
        return $this->hasMany(Aplikasi::class, 'id_kategori', 'id_kategori');
    }
}
