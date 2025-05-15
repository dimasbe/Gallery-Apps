<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoAplikasi extends Model
{
    use HasFactory;

    protected $table = 'foto_aplikasi';

    protected $fillable = [
        'id_aplikasi',
        'path_foto',
    ];

    public function aplikasi()
    {
        return $this->belongsTo(Aplikasi::class, 'id_aplikasi', 'id_aplikasi');
    }}
