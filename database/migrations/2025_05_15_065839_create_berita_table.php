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
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('thumbnail');
            $table->string('judul_berita');
            $table->foreignId('penulis')->constrained('users')->onDelete('cascade');
            $table->longText('isi_berita');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_terbit')->nullable();
            $table->boolean('status')->default(false); // false = draft, true = published
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
