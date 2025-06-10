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
            // Tambahkan kolom jumlah_kunjungan dengan nilai default 0
            $table->integer('jumlah_kunjungan')->default(0)->after('rating_konten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aplikasi', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn('jumlah_kunjungan');
        });
    }
};