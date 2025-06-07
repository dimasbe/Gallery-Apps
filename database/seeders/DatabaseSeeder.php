<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder Admin saja
        // $this->call(AdminUserSeeder::class);
        $this->call(AplikasiSeeder::class);
        $this->call(KategoriSeeder::class);
    }
}
