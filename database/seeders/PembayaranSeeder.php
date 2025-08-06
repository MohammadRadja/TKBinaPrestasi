<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa siswa untuk relasi
        $siswa = DB::table('siswa')->pluck('id')->toArray();

        if (empty($siswa)) {
            $this->command->warn('⚠️ Tidak ada data siswa di tabel siswa. Seeder Pembayaran dilewati.');
            return;
        }

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id' => (string) Str::uuid(),
                'siswa_id' => $siswa[array_rand($siswa)],
                'jenis_pembayaran' => collect(['pendaftaran', 'seragam', 'spp', 'lainnya'])->random(),
                'jumlah' => rand(500000, 2000000), // Nominal acak antara 500rb - 2jt
                'status' => collect(['pending', 'lunas', 'gagal'])->random(),
                'metode' => collect(['transfer', 'tunai'])->random(),
                'bukti_pembayaran' => null, // Bisa diisi contoh file bukti jika ada
                'tanggal_pembayaran' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pembayaran')->insert($data);
    }
}
