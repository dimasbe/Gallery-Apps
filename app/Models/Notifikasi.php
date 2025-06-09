<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = "notifikasi";

    protected $fillable = [
        'judul',
        'pesan',
        'tipe',
        'dibaca',
        'dibaca_pada',
        'user_id',
    ];
}
