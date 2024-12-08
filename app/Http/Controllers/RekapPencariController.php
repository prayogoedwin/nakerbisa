<?php

namespace App\Http\Controllers;

use App\Models\UserPencari;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class RekapPencariController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = UserPencari::select('id', 'name');

            return DataTables::of($datas)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.rekap.rekap-pencari.index');
    }

    public function getData($id)
    {
        try {
            $data = UserPencari::select('id', 'name')->findOrFail($id);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
