<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerPencariPengalaman extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_pencari_pengalaman';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'mulai_tahun',
        'berhenti_tahun',
        'jabatan',
    ];
}
