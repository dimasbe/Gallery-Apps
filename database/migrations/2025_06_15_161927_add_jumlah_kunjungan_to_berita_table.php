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
        Schema::table('berita', function (Blueprint $table) {
            // Menambahkan kolom jumlah_kunjungan dengan default 0
            $table->unsignedBigInteger('jumlah_kunjungan')->default(0)->after('tanggal_dibuat'); // Sesuaikan posisi jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn('jumlah_kunjungan');
        });
    }
};