<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganAplikasi extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_aplikasis';

    protected $fillable = [
        'aplikasi_id',
        'ip_address',
        'user_agent',
        'tanggal_kunjungan',
    ];

    protected $dates = ['tanggal_kunjungan'];

    public function aplikasi()
    {
        return $this->belongsTo(Aplikasi::class, 'aplikasi_id');
    }
}
