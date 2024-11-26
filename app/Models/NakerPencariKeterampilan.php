<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerPencariKeterampilan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_pencari_ketrampilan';

    protected $fillable = [
        'user_id',
        'lembaga_penyelenggara',
        'alamat_penyelenggara',
        'lulus_tahun',
        'no_sertifikat',
        'lembaga_penguji',
    ];
}
