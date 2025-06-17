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
        Schema::table('kategori', function (Blueprint $table) {
            // Tambahkan kolom 'slug' setelah 'nama_kategori'.
            // 'unique()' memastikan setiap slug itu unik (sangat direkomendasikan).
            // 'nullable()' jika Anda ingin slug bisa kosong sementara (tapi sebaiknya tidak).
            // Jika ingin slug selalu ada dan unik, hapus nullable() setelah mengisi data lama.
            $table->string('slug')->unique()->nullable()->after('nama_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};