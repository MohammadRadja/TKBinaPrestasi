<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($pengguna) {
            if (empty($pengguna->id)) {
                $pengguna->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = ['id', 'nama_lengkap', 'username', 'email', 'password', 'role', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'pengguna_id');
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'pengguna_id');
    }
}
