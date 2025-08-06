<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SuratPemberitahuan extends Model
{
    use HasFactory;

    protected $table = 'surat_pemberitahuan';
    protected $fillable = ['judul','isi','dibuat_oleh','target_role'];
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

    public function admin()
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }
}
