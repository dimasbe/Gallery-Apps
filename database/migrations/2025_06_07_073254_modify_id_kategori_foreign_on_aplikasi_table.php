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
        Schema::table('aplikasi', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aplikasi', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->foreign('id_kategori')->references('id')->on('kategori_aplikasi')->onDelete('cascade');
        });
    }
};
