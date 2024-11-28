<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk query builder

class Back extends Model
{
    use SoftDeletes;

    // Tentukan tabel yang akan digunakan oleh model
    protected $table = 'naker_bkk';

    // Tentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'no_sekolah', 'id_sekolah', 'name', 'website', 'email', 'alamat',
        'id_provinsi', 'id_kota', 'id_kecamatan', 'id_desa', 'kodepos', 'nama_bkk',
        'no_bkk', 'tanggal_aktif_bkk', 'tanggal_non_aktif_bkk', 'telpon', 'hp',
        'contact_person', 'jabatan', 'foto', 'tanggal_register', 'role_id',
        'username_', 'password_', 'status_id', 'last_login', 'foto_logo',
        'kode_verifikasi', 'kode_verifikasi_waktu'
    ];

    // Tambahkan ini jika menggunakan soft delete
    protected $dates = ['deleted_at'];

    // Method untuk mengambil data agama
    public function getAllAgama()
    {
        return DB::table('naker_agama')->get(); // Mengambil semua data dari tabel naker_agama
    }

    // Fungsi untuk mengambil data dari tabel naker_kabkota dengan province_id = 64
    public function getKabkotaByProvince($provinceId = 64)
    {
        return DB::table('naker_kabkota')
                 ->where('province_id', $provinceId)
                 ->get();
    }
}
