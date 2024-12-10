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
            // Data untuk ditampilkan di tabel dengan gender kosong
            $data = [
                ['jenis_penempatan' => 'Jumlah tenaga kerja penempatan melalui NAKERBISA', 'gender' => ''],
                ['jenis_penempatan' => 'Jumlah tenaga kerja penempatan diluar aplikasi NAKERBISA', 'gender' => '']
            ];

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-penempatan.index');
    }
}
