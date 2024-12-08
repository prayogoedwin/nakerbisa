<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPencari extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'users_pencari';

    protected $fillable = [
        'user_id',
        'ktp',
        'name',
        'tempat_lahir',
        'tanggal_lahir',
        'gender',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_desa',
        'alamat',
        'kodepos',
        'id_pendidikan',
        'id_jurusan',
        'tahun_lulus',
        'id_status_perkawinan',
        'id_agama',
        'foto',
        'status_id',
        'is_alumni_bkk',
        'bkk_id',
        'toket',
        'disabilitas',
        'jenis_disabilitas',
        'keterangan_disabilitas',
        'posted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_diterima',
        'medsos',
        'status_saat_ini',
        'sektor_pekerjaan_saat_ini',
        'jam_kerja',
        'gaji',
        'lokasi_kerja_saat_ini_kec',
        'lokasi_kerja_saat_ini',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
