<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'siswa_id', 'jenis_pembayaran', 'jumlah', 'status', 'metode', 'bukti_pembayaran', 'tanggal_pembayaran'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
