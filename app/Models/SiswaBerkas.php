<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SiswaBerkas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'siswa_berkas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'siswa_id',
        'jenis_berkas',
        'file_path',
    ];

    // Relasi ke Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
