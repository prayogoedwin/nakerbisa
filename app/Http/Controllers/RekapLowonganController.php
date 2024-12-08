<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class RekapLowonganController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = Lowongan::select('id', 'judul_lowongan');

            return DataTables::of($datas)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-lowongan.index');
    }

    public function getData($id)
    {
        try {
            $data = Lowongan::select('id', 'judul_lowongan')->findOrFail($id);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
