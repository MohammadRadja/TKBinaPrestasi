<?php

namespace App\Exports;

use App\Models\NilaiSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiSiswaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return NilaiSiswa::with(['siswa', 'guru', 'kelas'])->get();
    }

    public function headings(): array
    {
        return ['Nama Siswa', 'Nama Guru', 'Kelas', 'Mata Pelajaran', 'Nilai', 'Keterangan', 'Tanggal Input'];
    }

    public function map($nilai): array
    {
        return [$nilai->siswa->nama ?? '-', $nilai->guru->nama ?? '-', $nilai->kelas->nama ?? '-', $nilai->mata_pelajaran, $nilai->nilai, $nilai->keterangan, $nilai->tanggal_input->format('d-m-Y')];
    }
}
