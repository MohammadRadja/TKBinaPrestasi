<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\NilaiSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use Carbon\Carbon;

class NilaiSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaList = Siswa::all();
        $guruList = Guru::all();
        $kelasList = Kelas::all();

        // Mata pelajaran/aktivitas khas TK
        $aspekPerkembangan = ['Mengenal Huruf', 'Mengenal Angka', 'Kreativitas & Seni', 'Motorik Halus', 'Motorik Kasar', 'Sikap & Perilaku', 'Kerjasama dengan Teman'];

        // Nilai kualitatif (bukan hanya angka)
        $predikat = [
            100 => 'Sangat Baik',
            90 => 'Baik',
            80 => 'Cukup',
            70 => 'Perlu Bimbingan',
        ];

        foreach ($siswaList as $siswa) {
            foreach (array_rand($aspekPerkembangan, 4) as $key) {
                $nilaiAngka = array_rand($predikat);
                NilaiSiswa::create([
                    'siswa_id' => $siswa->id,
                    'guru_id' => $guruList->random()->id,
                    'kelas_id' => $kelasList->random()->id,
                    'mata_pelajaran' => $aspekPerkembangan[$key],
                    'nilai' => $nilaiAngka,
                    'keterangan' => $predikat[$nilaiAngka],
                    'tanggal_input' => Carbon::now()->subDays(rand(1, 15)),
                ]);
            }
        }
    }
}
