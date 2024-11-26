<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerPencariPendidikan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_pencari_pendidikan';

    protected $fillable = [
        'user_id',
        'pendidikan_id',
        'jurusan_id',
        'nama_sekolah',
        'alamat_sekolah',
        'lulus',
    ];
}
