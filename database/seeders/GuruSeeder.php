<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    public function run()
    {
        $guruList = [['nama' => 'Ramli, S. Pd', 'jk' => 'L'], ['nama' => 'Rifda Azkia Syahida, S. Pd. D', 'jk' => 'P'], ['nama' => 'Hasani', 'jk' => 'L'], ['nama' => 'Syarifatimah Zahroh, S. Pd', 'jk' => 'P']];

        $penggunaData = [];
        $guruData = [];

        foreach ($guruList as $index => $guru) {
            $i = $index + 1;
            $penggunaId = Str::uuid();

            // Data pengguna (role guru)
            $penggunaData[] = [
                'id' => $penggunaId,
                'nama_lengkap' => $guru['nama'],
                'username' => strtolower(str_replace(' ', '', $guru['nama'])),
                'email' => strtolower(str_replace(' ', '', $guru['nama'])) . '@example.com',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Data guru lengkap
            $guruData[] = [
                'id' => Str::uuid(),
                'pengguna_id' => $penggunaId,
                'nama_lengkap' => $guru['nama'],
                'jenis_kelamin' => $guru['jk'],
                'tanggal_lahir' => "198$i-0" . rand(1, 9) . '-0' . rand(1, 9),
                'agama' => ['Islam', 'Islam', 'Islam', 'Islam'][$i % 4],
                'pendidikan_terakhir' => ['S1 Pendidikan', 'S2 Pendidikan', 'S1 Matematika', 'S1 Bahasa Indonesia'][$i % 4],
                'no_hp' => "0812345678$i",
                'alamat' => "Jl. Melati No.$i, Jakarta",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data pengguna dan guru
        DB::table('pengguna')->insert($penggunaData);
        DB::table('guru')->insert($guruData);
    }
}
