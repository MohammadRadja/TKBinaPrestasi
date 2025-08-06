<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Siswa extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'siswa';

    // Primary Key menggunakan UUID
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang dapat diisi (fillable) disesuaikan dengan migration
    protected $fillable = ['id', 'pengguna_id', 'kelas_id', 'nama_lengkap', 'nama_panggilan', 'jenis_kelamin', 'tempat_tanggal_lahir', 'agama', 'anak_ke', 'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'no_hp', 'alamat'];

    // Event model: set UUID saat membuat data baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::deleting(function ($siswa) {
            if ($siswa->pengguna) {
                $siswa->pengguna->delete();
            }
        });
    }

    // Relasi ke model Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function berkas()
    {
        return $this->hasMany(SiswaBerkas::class, 'siswa_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function nilai()
    {
        return $this->hasMany(NilaiSiswa::class, 'siswa_id');
    }

    public function getRataRataNilaiAttribute()
    {
        return $this->nilai()->avg('nilai');
    }

    public function aktivitas()
    {
        return $this->hasMany(AktivitasHarian::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiSiswa::class, 'siswa_id');
    }
}
