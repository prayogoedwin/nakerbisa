<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class LamaranController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data lamaran berdasarkan pencari_id yang login
            $datas = Lamaran::with('lowongan')  // Asumsikan relasi sudah didefinisikan
                ->where('pencari_id', auth()->user()->id)
                ->select('id', 'lowongan_id', 'kabkota_penempatan_id', 'progres_id', 'created_at', 'keterangan');

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('lowongan', function ($data) {
                    return $data->lowongan->judul_lowongan ?? 'Tidak Ada';  // Ambil nama lowongan dari relasi
                })
                ->addColumn('status', function ($data) {
                    return $data->progres_id == 1 ? 'Dalam Proses' : 'Selesai';  // Sesuaikan dengan status
                })
                ->addColumn('options', function ($data) {
                    return '
                        <button class="btn btn-primary btn-sm" onclick="showDetailsModal(' . $data->id . ')">Detail</button>
                    ';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.lowongan.history-lamaran');
    }
}
