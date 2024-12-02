<?php

namespace App\Http\Controllers;

use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables

class DataController extends Controller
{
    //
    public function pencari(Request $request)
    {
        if ($request->ajax()) {
            $query = UserPencari::select(['id', 'name', 'alamat']);

            return DataTables::eloquent($query)->make(true);
        }

        return view ('backend.data.pencari');
    }

    public function getDetailPencari(Request $request, $id)
    {
        $userPencari = UserPencari::find($id);

        if (!$userPencari) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $userPencari,
        ]);
    }

    // Update job seeker data
    public function updatePencari(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'ktp' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'kodepos' => 'required|string|max:5',
            'tahun_lulus' => 'required|integer',
            'medsos' => 'required|string|max:200',
        ]);

        $userPencari = UserPencari::find($id);

        if (!$userPencari) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        // Update the userPencari record
        $userPencari->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'ktp' => $request->ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'kodepos' => $request->kodepos,
            'tahun_lulus' => $request->tahun_lulus,
            'medsos' => $request->medsos,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui',
        ]);
    }

    public function penyedia(Request $request)
    {
        if ($request->ajax()) {
            $query = UserPenyedia::select('*');
            return DataTables::eloquent($query)->make(true);
        }

        return view('backend.data.penyedia');
    }
}
