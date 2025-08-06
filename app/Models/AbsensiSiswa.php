<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsensiSiswa extends Model
{
    use HasFactory;

    protected $table = 'absensi_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'siswa_id', 'kelas_id', 'guru_id', 'tanggal', 'status', 'keterangan'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
