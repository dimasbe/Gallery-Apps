<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kunjungan_aplikasis', function (Blueprint $table) {
            $table->unsignedBigInteger('aplikasi_id')->after('id');
            $table->string('ip_address')->nullable()->after('aplikasi_id');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->timestamp('tanggal_kunjungan')->nullable()->after('user_agent');

            $table->foreign('aplikasi_id')
                  ->references('id')
                  ->on('aplikasi')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kunjungan_aplikasis', function (Blueprint $table) {
            $table->dropForeign(['aplikasi_id']);
            $table->dropColumn(['aplikasi_id', 'ip_address', 'user_agent', 'tanggal_kunjungan']);
        });
    }
};
