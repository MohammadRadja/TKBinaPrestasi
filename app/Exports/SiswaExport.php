<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Join dengan pengguna untuk mengambil nama lengkap dari tabel pengguna
        return Siswa::select(
            'nama_lengkap',
            'nama_panggilan',
            'jenis_kelamin',
            'tempat_tanggal_lahir',
            'agama',
            'anak_ke',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'no_hp',
            'alamat'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Nama Panggilan',
            'Jenis Kelamin',
            'Tempat, Tanggal Lahir',
            'Agama',
            'Anak Ke',
            'Nama Ayah',
            'Nama Ibu',
            'Pekerjaan Ayah',
            'Pekerjaan Ibu',
            'No HP',
            'Alamat'
        ];
    }
}
