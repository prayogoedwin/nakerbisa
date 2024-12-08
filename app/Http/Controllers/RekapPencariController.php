<?php

namespace App\Http\Controllers;

use App\Models\UserPencari;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekapPencariController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil jumlah pengguna berdasarkan id_kecamatan dan status_saat_ini
            $query = UserPencari::select(
                'id_kecamatan',
                DB::raw('count(case when status_saat_ini = 1 and gender = "L" then 1 end) as sudah_bekerja_laki'),
                DB::raw('count(case when status_saat_ini = 1 and gender = "P" then 1 end) as sudah_bekerja_perempuan'),
                DB::raw('count(case when status_saat_ini = 2 and gender = "L" then 1 end) as belum_bekerja_laki'),
                DB::raw('count(case when status_saat_ini = 2 and gender = "P" then 1 end) as belum_bekerja_perempuan'),
                DB::raw('count(case when status_saat_ini = 3 and gender = "L" then 1 end) as tidak_bekerja_laki'),
                DB::raw('count(case when status_saat_ini = 3 and gender = "P" then 1 end) as tidak_bekerja_perempuan'),
                DB::raw('count(case when gender = "L" then 1 end) as total_laki'),
                DB::raw('count(case when gender = "P" then 1 end) as total_perempuan'),
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
