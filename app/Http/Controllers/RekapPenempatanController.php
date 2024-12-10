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
            // Query untuk menghitung tenaga kerja penempatan melalui NAKERBISA berdasarkan gender
            $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'L') // Gender Laki-laki
                ->distinct('naker_lamarans.pencari_id') // Pastikan pencari_id unik
                ->count();

            $penempatanMelaluiNakerbisaPerempuan = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'P') // Gender Perempuan
                ->distinct('naker_lamarans.pencari_id') // Pastikan pencari_id unik
                ->count();

            // Query untuk menghitung tenaga kerja penempatan diluar aplikasi NAKERBISA berdasarkan gender
            $penempatanDiluarNakerbisaLaki = DB::table('users_pencari')
                ->whereNotIn('user_id', function ($query) {
                    $query->select('pencari_id')
                        ->from('naker_lamarans'); // Semua pencari_id di naker_lamarans
                })
                ->where('gender', 'L') // Gender Laki-laki
                ->count();

            $penempatanDiluarNakerbisaPerempuan = DB::table('users_pencari')
                ->whereNotIn('user_id', function ($query) {
                    $query->select('pencari_id')
                        ->from('naker_lamarans'); // Semua pencari_id di naker_lamarans
                })
                ->where('gender', 'P') // Gender Perempuan
                ->count();

            // Tambahkan data ke dalam tabel
            $data = [
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA',
                    'gender_l' => $penempatanMelaluiNakerbisaLaki,
                    'gender_p' => $penempatanMelaluiNakerbisaPerempuan,
                ],
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA',
                    'gender_l' => $penempatanDiluarNakerbisaLaki,
                    'gender_p' => $penempatanDiluarNakerbisaPerempuan,
                ]
            ];

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-penempatan.index');
    }

    public function printPenempatan()
    {
        // Query untuk data yang sama dengan yang ditampilkan di tabel
        $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
            ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
            ->where('users_pencari.gender', 'L')
            ->distinct('naker_lamarans.pencari_id')
            ->count();

        $penempatanMelaluiNakerbisaPerempuan = DB::table('naker_lamarans')
            ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
            ->where('users_pencari.gender', 'P')
            ->distinct('naker_lamarans.pencari_id')
            ->count();

        $penempatanDiluarNakerbisaLaki = DB::table('users_pencari')
            ->whereNotIn('user_id', function ($query) {
                $query->select('pencari_id')->from('naker_lamarans');
            })
            ->where('gender', 'L')
            ->count();

        $penempatanDiluarNakerbisaPerempuan = DB::table('users_pencari')
            ->whereNotIn('user_id', function ($query) {
                $query->select('pencari_id')->from('naker_lamarans');
            })
            ->where('gender', 'P')
            ->count();

        $data = [
            [
                'jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA',
                'gender_l' => $penempatanMelaluiNakerbisaLaki,
                'gender_p' => $penempatanMelaluiNakerbisaPerempuan,
            ],
            [
                'jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA',
                'gender_l' => $penempatanDiluarNakerbisaLaki,
                'gender_p' => $penempatanDiluarNakerbisaPerempuan,
            ]
        ];

        return view('backend.rekap.rekap-penempatan.print', compact('data'));
    }
}
