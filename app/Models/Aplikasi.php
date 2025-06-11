<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str helper untuk membuat slug

class Aplikasi extends Model
{
    use HasFactory;

    protected $table = 'aplikasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'nama_aplikasi',
        'logo',
        'id_kategori',
        'nama_pemilik',
        'tanggal_rilis',
        'versi',
        'rating_konten',
        'jumlah_kunjungan',
        'tautan_aplikasi',
        'deskripsi',
        'fitur',
        'status_verifikasi',
        'arsip',
        'tanggal_ditambahkan',
        'tanggal_verifikasi',
        'alasan_penolakan',
        'slug', // <<< TAMBAHKAN INI: Kolom slug
    ];

    protected $dates = [
        'tanggal_rilis',
        'tanggal_ditambahkan',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
        'rating_konten' => 'float',
        'jumlah_kunjungan' => 'integer',
    ];

    /**
     * Mendefinisikan kolom yang akan digunakan untuk Route Model Binding.
     * Dalam kasus ini, kita menggunakan 'slug' alih-alih 'id'.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Boot method model untuk menangani event.
     * Digunakan untuk secara otomatis membuat slug sebelum menyimpan atau memperbarui model.
     */
    protected static function boot()
    {
        parent::boot();

        // Event 'creating' akan dijalankan saat model baru dibuat
        static::creating(function ($aplikasi) {
            $aplikasi->slug = Str::slug($aplikasi->nama_aplikasi);
        });

        // Event 'updating' akan dijalankan saat model yang sudah ada diperbarui
        static::updating(function ($aplikasi) {
            // Perbarui slug hanya jika 'nama_aplikasi' berubah
            if ($aplikasi->isDirty('nama_aplikasi')) {
                $aplikasi->slug = Str::slug($aplikasi->nama_aplikasi);
            }
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_aplikasi');
    }

    public function fotoAplikasi()
    {
        return $this->hasMany(FotoAplikasi::class, 'id_aplikasi');
    }

    public function fotoUtama()
    {
        return $this->hasOne(FotoAplikasi::class, 'id_aplikasi')->latestOfMany();
    }

}