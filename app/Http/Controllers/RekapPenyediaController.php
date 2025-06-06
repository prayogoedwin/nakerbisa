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
            // Query untuk DataTables
            // $query = UserPenyedia::select(
            //     'id_kecamatan',
            //     DB::raw('count(*) as total') // Total count of all users
            // )
            //     ->groupBy('id_kecamatan');

            $query = DB::table('naker_kecamatan')
                ->leftJoin('users_penyedia', 'naker_kecamatan.id', '=', 'users_penyedia.id_kecamatan')
                ->select(
                    'naker_kecamatan.id as id_kecamatan',
                    'naker_kecamatan.name as kecamatan_name',
                    DB::raw('count(users_penyedia.id) as total')
                )
                ->where('naker_kecamatan.regency_id', '=', 3317)
                ->whereNull('users_penyedia.deleted_at') // Jika kolom deleted_at ada
                ->groupBy('naker_kecamatan.id', 'naker_kecamatan.name'); // Semua kolom non-agregat ditambahkan di sini
            
                 // Filter berdasarkan bulan jika parameter `month` ada
            if ($request->has('year') && $request->year) {
                $query->whereYear('users_penyedia.created_at', $request->year);
            }

            // Filter berdasarkan bulan jika parameter `month` ada
            if ($request->has('month') && $request->month) {
                $query->whereMonth('users_penyedia.created_at', $request->month);
            }

            // Filter berdasarkan tanggal spesifik jika parameter `tanggal` ada
            if ($request->has('tanggal') && $request->tanggal) {
                $query->whereDate('created_at', $request->tanggal);
            }

            // Ambil data setelah semua filter diterapkan
            $data = $query->get();


            // Mengembalikan data untuk DataTables
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->make(true);
        }

        // Hitung keseluruhan jumlah pengguna di semua kecamatan
        $totalKeseluruhan = UserPenyedia::count();

        // Kirim totalKeseluruhan ke view
        return view('backend.rekap.rekap-penyedia.index', compact('totalKeseluruhan'));
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
