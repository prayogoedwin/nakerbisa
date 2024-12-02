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

        return view('backend.data.pencari');
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
