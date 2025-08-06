<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesan extends Model
{
    protected $table = 'pesan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($pesan) {
            if (empty($pesan->id)) {
                $pesan->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'id',
        'pengguna_id', 
        'isi_pesan', 
        'waktu_kirim', 
        'parent_id',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function replies()
    {
        return $this->hasMany(Pesan::class, 'parent_id')->orderBy('waktu_kirim');
    }

    public function parent()
    {
        return $this->belongsTo(Pesan::class, 'parent_id');
    }
}