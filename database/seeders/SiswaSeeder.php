<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Kelas;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $namaDepan = ['Alya', 'Rafa', 'Nayla', 'Arka', 'Ziva', 'Keanu', 'Kayla', 'Raihan', 'Mikaela', 'Daffa', 'Lia', 'Rizky', 'Salsa', 'Farhan', 'Dinda', 'Irfan', 'Tiara', 'Bima', 'Tasya', 'Fajar'];
        $namaBelakang = ['Zahra', 'Pratama', 'Putri', 'Nugraha', 'Aurel', 'Aditya', 'Safira', 'Alvaro', 'Anindya', 'Pradipta', 'Nurhaliza', 'Saputra', 'Rahmawati', 'Wijaya', 'Kusuma', 'Santoso', 'Ramadhan', 'Maulana', 'Permata', 'Syahputra'];
        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $agamaList = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'];

        $kelasList = Kelas::all();
        $totalPerKelas = 20;

        if ($kelasList->count() < 1) {
            $this->command->error('Tidak ada data kelas. Tambahkan kelas terlebih dahulu.');
            return;
        }

        $penggunaData = [];
        $siswaData = [];

        $counter = 1;

        foreach ($kelasList as $kelas) {
            for ($i = 0; $i < $totalPerKelas; $i++) {
                $first = $namaDepan[array_rand($namaDepan)];
                $last = $namaBelakang[array_rand($namaBelakang)];
                $nama = "$first $last";
                $panggilan = $first;
                $jk = $jenisKelamin[array_rand($jenisKelamin)];

                $penggunaId = Str::uuid();
                $siswaId = Str::uuid();

                // Data pengguna
                $penggunaData[] = [
                    'id' => $penggunaId,
                    'nama_lengkap' => $nama,
                    'username' => strtolower($panggilan),
                    'email' => strtolower($panggilan) . '@example.com',
                    'password' => Hash::make('siswa123'),
                    'role' => 'siswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Data siswa
                $siswaData[] = [
                    'id' => $siswaId,
                    'pengguna_id' => $penggunaId,
                    'kelas_id' => $kelas->id,
                    'nama_lengkap' => $nama,
                    'nama_panggilan' => $panggilan,
                    'jenis_kelamin' => $jk,
                    'tempat_tanggal_lahir' => 'Jakarta, 201' . rand(0, 5) . '-0' . rand(1, 9) . '-0' . rand(1, 9),
                    'agama' => $agamaList[array_rand($agamaList)],
                    'anak_ke' => rand(1, 3),
                    'nama_ayah' => "Bapak $panggilan",
                    'nama_ibu' => "Ibu $panggilan",
                    'pekerjaan_ayah' => 'Karyawan',
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'no_hp' => '0812345678' . str_pad($counter, 2, '0', STR_PAD_LEFT),
                    'alamat' => "Jl. Melati No.{$counter}, Jakarta",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $counter++;
            }
        }

        // Insert batch
        DB::table('pengguna')->insert($penggunaData);
        DB::table('siswa')->insert($siswaData);
    }
}
