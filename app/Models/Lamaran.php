<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lamaran extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'naker_lamarans';

    protected $fillable = [
        'pencari_id',
        'lowongan_id',
        'kabkota_penempatan_id',
        'progres_id',
        'created_at',
        'updated_at',
        'keterangan'
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke model User
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }
}
