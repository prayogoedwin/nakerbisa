<?php

namespace App\Http\Controllers;

use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekapPenyediaController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil jumlah pengguna berdasarkan id_kecamatan dan status_saat_ini
            $query = UserPenyedia::select(
                'id_kecamatan',
                DB::raw('count(*) as total') // Total count of all users
            )
                ->groupBy('id_kecamatan');

            // Filter berdasarkan bulan jika parameter `month` ada
            if ($request->has('month') && $request->month) {
                $query->whereMonth('created_at', $request->month);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->make(true);
        }

        return view('backend.rekap.rekap-penyedia.index');
    }


    public function getData($id)
    {
        try {
            $data = UserPenyedia::select('id', 'name')->findOrFail($id);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
