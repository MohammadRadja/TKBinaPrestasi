<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\AbsensiSiswa;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Carbon\Carbon;

class AbsensiSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = Kelas::all();
        $guruList = Guru::all();

        if ($kelasList->count() < 4 || $guruList->count() < 4 || Siswa::count() < 4) {
            $this->command->warn('Minimal harus ada 4 kelas, 4 guru, dan 4 siswa.');
            return;
        }

        // Ambil 4 kelas acak dan 4 guru acak
        $randomKelas = $kelasList->random(4);
        $randomGuru = $guruList->random(4);

        for ($i = 0; $i < 4; $i++) {
            $kelas = $randomKelas[$i];
            $guru = $randomGuru[$i];

            // Ambil siswa secara acak dari kelas tersebut
            $siswa = Siswa::where('kelas_id', $kelas->id)->inRandomOrder()->first();

            if (!$siswa) {
                $this->command->warn("Tidak ada siswa di kelas {$kelas->nama_kelas}, data dilewati.");
                continue;
            }

            AbsensiSiswa::create([
                'id' => Str::uuid(),
                'siswa_id' => $siswa->id,
                'kelas_id' => $kelas->id,
                'guru_id' => $guru->id,
                'tanggal' => Carbon::now()->subDays(rand(1, 10)),
                'status' => ['Hadir', 'Izin', 'Sakit', 'Alpa'][array_rand(['Hadir', 'Izin', 'Sakit', 'Alpa'])],
                'keterangan' => 'Absensi acak kelas ' . $kelas->nama_kelas,
            ]);
        }
    }
}
