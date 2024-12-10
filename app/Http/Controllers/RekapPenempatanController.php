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
        $month = $request->input('month'); // Get the selected month
        $year = $request->input('year'); // Get the selected year

        if ($request->ajax()) {
            // Query for NAKERBISA placement by gender
            $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'L')
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
                })
                ->distinct('naker_lamarans.pencari_id')
                ->count();

            $penempatanMelaluiNakerbisaPerempuan = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'P')
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('naker_lamarans.created_at', $month);
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('naker_lamarans.created_at', $year);
                })
                ->distinct('naker_lamarans.pencari_id')
                ->count();

            // Query for non-NAKERBISA placements by gender
            $penempatanDiluarNakerbisaLaki = DB::table('users_pencari')
                ->whereNotIn('user_id', function ($query) {
                    $query->select('pencari_id')
                        ->from('naker_lamarans');
                })
                ->where('gender', 'L')
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('users_pencari.created_at', $month);
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('users_pencari.created_at', $year);
                })
                ->count();

            $penempatanDiluarNakerbisaPerempuan = DB::table('users_pencari')
                ->whereNotIn('user_id', function ($query) {
                    $query->select('pencari_id')
                        ->from('naker_lamarans');
                })
                ->where('gender', 'P')
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('users_pencari.created_at', $month);
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('users_pencari.created_at', $year);
                })
                ->count();

            // Add data to the table
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
