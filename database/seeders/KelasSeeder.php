<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $guruList = DB::table('guru')->get();

        if ($guruList->count() < 4) {
            throw new \Exception('Data guru kurang dari 4. Jalankan GuruSeeder terlebih dahulu.');
        }

        $kelasList = [['nama_kelas' => 'Kelas Mawar', 'tingkat' => 'A', 'kapasitas' => 20], ['nama_kelas' => 'Kelas Melati', 'tingkat' => 'A', 'kapasitas' => 20], ['nama_kelas' => 'Kelas Anggrek', 'tingkat' => 'B', 'kapasitas' => 20], ['nama_kelas' => 'Kelas Tulip', 'tingkat' => 'B', 'kapasitas' => 20]];

        foreach ($kelasList as $index => $kelas) {
            $guru = $guruList->values()->get($index);
            Kelas::create([
                'guru_id' => $guru->id,
                'nama_kelas' => $kelas['nama_kelas'],
                'tingkat' => $kelas['tingkat'],
                'kapasitas' => $kelas['kapasitas'],
                'tahun_ajaran' => '2024/2025',
            ]);
        }
    }
}
