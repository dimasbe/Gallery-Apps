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
        Schema::create('aplikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama_aplikasi');
            $table->string('logo');
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade');
            $table->string('nama_pemilik');
            $table->date('tanggal_rilis')->nullable();
            $table->date('tanggal_update')->nullable();
            $table->string('versi');
            $table->string('rating_konten');
            $table->string('tautan_aplikasi');
            $table->text('deskripsi');
            $table->text('fitur');
            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->boolean('arsip')->default(false);
            $table->dateTime('tanggal_ditambahkan')->useCurrent();
            $table->dateTime('tanggal_verifikasi')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplikasi');
    }
};
