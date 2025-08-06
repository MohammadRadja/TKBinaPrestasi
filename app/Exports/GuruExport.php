<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuruExport implements FromCollection, WithHeadings
{
    /**
     * Ambil data guru dari database
     */
    public function collection()
    {
        return Guru::select('id', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'agama', 'pendidikan_terakhir', 'no_hp', 'alamat')->get();
    }

    /**
     * Tambahkan header kolom
     */
    public function headings(): array
    {
        return ['ID', 'Nama Lengkap', 'Jenis Kelamin', 'Tanggal Lahir', 'Agama', 'Pendidikan Terakhir', 'No HP', 'Alamat'];
    }
}
