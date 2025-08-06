<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $fillable = ['pengguna_id', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'agama', 'pendidikan_terakhir', 'no_hp', 'alamat'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::deleting(function ($guru) {
            if ($guru->pengguna) {
                $guru->pengguna->delete();
            }
        });
    }

    public function rankingPerKelas()
    {
        return $this->kelas()
            ->with(['siswa.nilai'])
            ->get()
            ->mapWithKeys(function ($kelas) {
                $ranking = $kelas->siswa->sortByDesc(fn($siswa) => $siswa->rata_rata_nilai)->take(5);
                return [
                    $kelas->id => [
                        'kelas' => $kelas,
                        'ranking' => $ranking,
                    ],
                ];
            });
    }

    // Relasi
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function nilai()
    {
        return $this->hasMany(NilaiSiswa::class, 'guru_id');
    }

    public function aktivitas()
    {
        return $this->hasMany(AktivitasHarian::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiSiswa::class, 'guru_id');
    }
}
