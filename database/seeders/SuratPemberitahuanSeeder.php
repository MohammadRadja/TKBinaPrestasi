<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratPemberitahuan;
use App\Models\Pengguna;

class SuratPemberitahuanSeeder extends Seeder
{
    public function run(): void
    {
        // ambil admin pertama dari tabel pengguna
        $admin = Pengguna::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('⚠️ Tidak ada admin ditemukan. Seeder SuratPemberitahuan dilewati.');
            return;
        }

        $data = [
            [
                'judul' => 'Pengumuman Libur Sekolah',
                'isi' => 'Sekolah akan libur pada tanggal 17 Agustus dalam rangka Hari Kemerdekaan Indonesia.',
                'dibuat_oleh' => $admin->id,
                'target_role' => 'siswa',
            ],
            [
                'judul' => 'Rapat Guru',
                'isi' => 'Rapat guru akan dilaksanakan pada hari Senin pukul 09.00 di ruang guru.',
                'dibuat_oleh' => $admin->id,
                'target_role' => 'guru',
            ],
            [
                'judul' => 'Pengambilan Raport',
                'isi' => 'Pengambilan raport akan dilaksanakan pada tanggal 30 Juni. Orang tua diminta hadir.',
                'dibuat_oleh' => $admin->id,
                'target_role' => 'siswa',
            ],
            [
                'judul' => 'Ucapan Terima Kasih',
                'isi' => 'Terima kasih kepada seluruh guru, siswa, dan orang tua atas dukungan selama tahun ajaran ini.',
                'dibuat_oleh' => $admin->id,
                'target_role' => 'semua',
            ],
        ];

        foreach ($data as $item) {
            SuratPemberitahuan::create($item); // UUID otomatis untuk ID surat
        }
    }
}
