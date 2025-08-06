<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['guru_id', 'nama_kelas', 'tingkat', 'kapasitas', 'tahun_ajaran'];
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
    }

    // Relasi
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasMany(NilaiSiswa::class, 'kelas_id');
    }

    public function aktivitas()
    {
        return $this->hasMany(AktivitasHarian::class, 'kelas_id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiSiswa::class, 'kelas_id');
    }
}
