<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'thumbnail',
        'judul_berita',
        'penulis', // user id admin
        'isi_berita',
        'tanggal_dibuat',
        'tanggal_terbit',
        'status',
    ];

    protected $dates = [
        'tanggal_dibuat',
        'tanggal_terbit',
    ];

    public function penulisUser()
    {
        return $this->belongsTo(User::class, 'penulis');
    }
}
