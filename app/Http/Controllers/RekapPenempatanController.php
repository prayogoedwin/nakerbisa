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
            // Get selected month and year from the request
            $month = $request->input('month');
            $year = $request->input('year');

            // Query to count placement through NAKERBISA for male gender with month and year filters
            $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'L') // Gender Male
                ->where('naker_lamarans.progres_id', 1) // Filter for progres_id = 1
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
                })
                ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
                ->count();

            // Query to count placement through NAKERBISA for female gender with month and year filters
            $penempatanMelaluiNakerbisaPerempuan = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'P') // Gender Female
                ->where('naker_lamarans.progres_id', 1) // Filter for progres_id = 1
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
                })
                ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
                ->count();

            // Query for placement outside NAKERBISA for male gender with month and year filters
            $penempatanDiluarNakerbisaLaki = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'L') // Gender Male
                ->where('users_pencari.status_saat_ini', 1) // Active status
                ->where('naker_lamarans.progres_id', '!=', 1) // Filter for progres_id not equal to 1
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
                })
                ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
                ->count();

            // Query for placement outside NAKERBISA for female gender with month and year filters
            $penempatanDiluarNakerbisaPerempuan = DB::table('naker_lamarans')
                ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
                ->where('users_pencari.gender', 'P') // Gender Female
                ->where('users_pencari.status_saat_ini', 1) // Active status
                ->where('naker_lamarans.progres_id', '!=', 1) // Filter for progres_id not equal to 1
                ->when($month, function ($query, $month) {
                    return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
                })
                ->when($year, function ($query, $year) {
                    return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
                })
                ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
                ->count();

            // Add data into the table
            $data = [
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA',
                    'gender_l' => $penempatanMelaluiNakerbisaLaki,
                    'gender_p' => $penempatanMelaluiNakerbisaPerempuan,
                ],
                [
                    'jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA',
                    'gender_l' => $penempatanDiluarNakerbisaLaki, // Default value 0 if needed
                    'gender_p' => $penempatanDiluarNakerbisaPerempuan,
                ]
            ];

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-penempatan.index');
    }

    public function printPenempatan(Request $request)
    {
        // Get selected month and year from the request
        $month = $request->input('month');
        $year = $request->input('year');

        // Query to count placement through NAKERBISA for male gender with month and year filters
        $penempatanMelaluiNakerbisaLaki = DB::table('naker_lamarans')
            ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
            ->where('users_pencari.gender', 'L') // Gender Male
            ->where('naker_lamarans.progres_id', 1) // Filter for progres_id = 1
            ->when($month, function ($query, $month) {
                return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
            })
            ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
            ->count();

        // Query to count placement through NAKERBISA for female gender with month and year filters
        $penempatanMelaluiNakerbisaPerempuan = DB::table('naker_lamarans')
            ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
            ->where('users_pencari.gender', 'P') // Gender Female
            ->where('naker_lamarans.progres_id', 1) // Filter for progres_id = 1
            ->when($month, function ($query, $month) {
                return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
            })
            ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
            ->count();

        // Query for placement outside NAKERBISA for male gender with month and year filters
        $penempatanDiluarNakerbisaLaki = DB::table('naker_lamarans')
            ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
            ->where('users_pencari.gender', 'L') // Gender Male
            ->where('users_pencari.status_saat_ini', 1) // Active status
            ->where('naker_lamarans.progres_id', '!=', 1) // Filter for progres_id not equal to 1
            ->when($month, function ($query, $month) {
                return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
            })
            ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
            ->count();

        // Query for placement outside NAKERBISA for female gender with month and year filters
        $penempatanDiluarNakerbisaPerempuan = DB::table('naker_lamarans')
            ->join('users_pencari', 'naker_lamarans.pencari_id', '=', 'users_pencari.user_id')
            ->where('users_pencari.gender', 'P') // Gender Female
            ->where('users_pencari.status_saat_ini', 1) // Active status
            ->where('naker_lamarans.progres_id', '!=', 1) // Filter for progres_id not equal to 1
            ->when($month, function ($query, $month) {
                return $query->whereMonth('naker_lamarans.created_at', $month); // Apply month filter
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('naker_lamarans.created_at', $year); // Apply year filter
            })
            ->distinct('naker_lamarans.pencari_id') // Ensure unique pencari_id
            ->count();

        // Prepare data for printing
        $data = [
            [
                'jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA',
                'gender_l' => $penempatanMelaluiNakerbisaLaki,
                'gender_p' => $penempatanMelaluiNakerbisaPerempuan,
            ],
            [
                'jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA',
                'gender_l' => $penempatanDiluarNakerbisaLaki, // Default value 0 if needed
                'gender_p' => $penempatanDiluarNakerbisaPerempuan,
            ]
        ];

        // Return the view for printing
        return view('backend.rekap.rekap-penempatan.print', compact('data', 'month', 'year'));
    }
}
