<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kunjungan_beritas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('berita_id');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('tanggal_kunjungan')->useCurrent();
            $table->timestamps();

            $table->foreign('berita_id')
                ->references('id')
                ->on('berita') // pastikan pakai nama tabel sesuai database: `berita`, bukan `beritas`
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_beritas');
    }
};
