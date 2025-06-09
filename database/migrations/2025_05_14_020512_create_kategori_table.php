<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->enum('sub_kategori', ['aplikasi', 'berita']);
            $table->string('nama_kategori');
            $table->string('gambar')->nullable(); // untuk menyimpan nama file atau URL gambar
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diedit')->useCurrent()->useCurrentOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
