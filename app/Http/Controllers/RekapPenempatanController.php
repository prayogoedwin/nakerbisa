<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\DB;

class RekapPenempatanController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Query untuk menghitung jumlah tenaga kerja penempatan melalui NAKERBISA berdasarkan gender
            $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'L') // Hanya untuk gender Laki-laki
                ->count();

            $penempatanMelaluiNakerbisaPerempuan = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'P') // Hanya untuk gender Perempuan
                ->count();

            // Untuk jumlah tenaga kerja penempatan diluar NAKERBISA, tambahkan query jika tersedia
            $penempatanDiluarNakerbisaLaki = 0; // Nilai default
            $penempatanDiluarNakerbisaPerempuan = 0; // Nilai default

            // Tambahkan data ke dalam tabel
            $data = [
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA',
                    'gender_l' => $penempatanMelaluiNakerbisaLaki,
                    'gender_p' => $penempatanMelaluiNakerbisaPerempuan
                ],
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA',
                    'gender_l' => $penempatanDiluarNakerbisaLaki,
                    'gender_p' => $penempatanDiluarNakerbisaPerempuan
                ]
            ];

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-penempatan.index');
    }
}
