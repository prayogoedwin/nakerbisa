<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBlk extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'users_blk';

    protected $fillable = [
        'user_id',
        'name',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_desa',
        'alamat',
        'kodepos',
        'telpon',
        'pic',
        'jabatan',
        'website',
        'status_id',
        'foto',
        'posted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'no_izin_pendirian',
        'waktu_pendirian',
        'nomor_vin',
        'nomor_induk_berusaha',
        'nomor_akreditasi_lembaga',
        'berlaku_sampai',
        'jenis_pelatihan',
        'kapasitas_peserta_per_pelatihan',
        'jumlah_lulusan_sampai_sekarang',
        'jumlah_peserta_lulus_uji_kompetensi',
        'jumlah_instruktur',
        'jumlah_instruktur_bersertifikat_kompetensi',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
