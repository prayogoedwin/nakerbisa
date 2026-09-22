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
        $progressId = DB::table('naker_progres')
            ->where('kode', 3)
            ->where('modul', 'lamaran')
            ->value('id');

        if ($request->ajax()) {
            $query = DB::table('naker_lamarans')
                ->join('naker_progres', 'naker_lamarans.progres_id', '=', 'naker_progres.id')
                ->join('users', 'naker_lamarans.pencari_id', '=', 'users.id')
                ->join('naker_lowongan', 'naker_lamarans.lowongan_id', '=', 'naker_lowongan.id')
                ->select(
                    'naker_progres.name as status_name',
                    'users.name as pencari_name',
                    'naker_lowongan.judul_lowongan as lowongan_title',
                    'naker_lowongan.lokasi_penempatan_text as lokasi_penempatan',
                    'naker_lamarans.created_at'
                )
                ->where('naker_lamarans.progres_id', $progressId);

            // Filter berdasarkan bulan jika parameter `month` ada
            if ($request->has('month') && $request->month) {
                $query->whereMonth('naker_lamarans.created_at', $request->month);
            }

            $penempatanData = $query->get();

            return DataTables::of($penempatanData)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-penempatan.index');
    }
}
