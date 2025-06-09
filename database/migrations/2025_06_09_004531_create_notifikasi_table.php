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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // pengguna yang menerima notifikasi
            $table->string('judul'); // judul notifikasi
            $table->text('pesan'); // isi pesan notifikasi
            $table->string('tipe')->nullable(); // tipe notifikasi (info, warning, success, dll)
            $table->boolean('dibaca')->default(false); // status dibaca atau belum
            $table->timestamp('dibaca_pada')->nullable(); // waktu dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
