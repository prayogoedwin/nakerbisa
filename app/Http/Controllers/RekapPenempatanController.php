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
            // Query untuk menghitung jumlah tenaga kerja penempatan melalui NAKERBISA
            $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'L') // Hanya untuk gender Laki-laki
                ->distinct('naker_lamarans.pencari_id') // Pastikan pencari_id unik
                ->count();

            // Tambahkan data ke dalam tabel
            $data = [
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA',
                    'gender' => $penempatanMelaluiNakerbisaLaki
                ],
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA',
                    'gender' => 0 // Untuk saat ini, isi dengan default 0
                ]
            ];

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-penempatan.index');
    }
}
