<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\UserPencari;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class LamaranController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = Lamaran::with('lowongan') // Relasi ke tabel lowongan
                ->join('naker_progres', 'naker_lamarans.progres_id', '=', 'naker_progres.kode') // Join tabel
                ->where('naker_progres.modul', 'lamaran') // Hanya modul 'lowongan'
                ->where('naker_lamarans.pencari_id', auth()->user()->id) // Data berdasarkan pencari_id yang login
                ->select(
                    'naker_lamarans.id',
                    'naker_lamarans.lowongan_id',
                    'naker_lamarans.created_at',
                    'naker_lamarans.progres_id',
                    'naker_progres.name as status' // Ambil name sebagai status
                );

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('lowongan', function ($data) {
                    return $data->lowongan->judul_lowongan ?? 'Tidak Ada';
                })
                ->addColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d M Y'); // Format tanggal
                })
                ->addColumn('status', function ($data) {
                    return $data->status ?? 'Tidak Ada'; // Gunakan name dari tabel progres
                })
                ->make(true);
        }

        return view('backend.lowongan.history-lamaran');
    }

    public function show($id)
    {
        try {
            // $id = decode_url($ids);
            $data = Lamaran::select('*')->findOrFail($id);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request)
    {
        $pelamar = Lamaran::find($request->id); // Find the lamaran by ID

        if ($pelamar) {

            // Ambil pencari_id dari lamaran
            $pencariId = $pelamar->pencari_id;


            $pelamar->progres_id = $request->status_id; // Update the status
            $pelamar->save();


        // Update kolom status_saat_ini di tabel users_pencari
        $usersPencari = UserPencari::where('user_id', $pencariId)->first(); // Cari berdasarkan user_id (pencari_id)
        
        if ($usersPencari) {
            $usersPencari->status_saat_ini = '1'; // 1 berarti Bekerja
            $usersPencari->save();
        }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

}
