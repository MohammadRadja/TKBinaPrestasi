<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PenggunaSeeder::class);
        $this->call(GuruSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(SiswaSeeder::class);
        $this->call(AktivitasHarianSeeder::class);
        $this->call(NilaiSiswaSeeder::class);
        $this->call(SuratPemberitahuanSeeder::class);
        $this->call(AbsensiSiswaSeeder::class);
        $this->call(PembayaranSeeder::class);
    }
}
