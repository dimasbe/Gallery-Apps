<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganBerita extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_beritas';

    protected $fillable = [
        'berita_id',
        'ip_address',
        'user_agent',
        'tanggal_kunjungan',
    ];

    protected $dates = ['tanggal_kunjungan'];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }
}
