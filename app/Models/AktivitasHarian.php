<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasHarian extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_harian';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'siswa_id', 'guru_id', 'kelas_id', 'tanggal', 'aktivitas', 'catatan', 'foto_aktivitas'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
