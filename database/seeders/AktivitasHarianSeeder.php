<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\AktivitasHarian;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use Carbon\Carbon;

class AktivitasHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil Data Siswa, Kelas dan Guru
        $siswa = Siswa::first();
        $guru = Guru::first();
        $kelas = Kelas::first();

        // Jika belum ada siswa atau guru, hentikan
        if (!$siswa || !$guru) {
            $this->command->warn('Seeder AktivitasHarian: Pastikan sudah ada data siswa dan guru terlebih dahulu!');
            return;
        }

        $data = [
            [
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'guru_id' => $guru->id,
                'kelas_id' => $kelas->id,
                'tanggal' => Carbon::now()->subDays(2),
                'aktivitas' => 'Belajar membaca huruf hijaiyah',
                'catatan' => 'Perlu bimbingan tambahan di rumah',
                'foto_aktivitas' => null,
            ],
            [
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'guru_id' => $guru->id,
                'kelas_id' => $kelas->id,
                'tanggal' => Carbon::now()->subDay(),
                'aktivitas' => 'Menghafal surat pendek',
                'catatan' => 'Siswa sangat antusias',
                'foto_aktivitas' => null,
            ],
            [
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'guru_id' => $guru->id,
                'kelas_id' => $kelas->id,
                'tanggal' => Carbon::now(),
                'aktivitas' => 'Praktik wudhu dan shalat',
                'catatan' => 'Sudah lancar',
                'foto_aktivitas' => null,
            ],
        ];

        foreach ($data as $item) {
            AktivitasHarian::create($item);
        }
    }
}
