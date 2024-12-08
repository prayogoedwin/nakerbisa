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
            $today = now();

            // Query untuk menghitung jumlah data berdasarkan kabupaten/kota dan bulan
            $queryRembang = Lowongan::where('kabkota_id', 3317)
                ->where('status_id', 1)
                ->where('tanggal_end', '<', $today);

            $queryLuarRembang = Lowongan::where('kabkota_id', '!=', 3317)
                ->where('status_id', 1)
                ->where('tanggal_end', '<', $today);

            // Filter berdasarkan bulan jika parameter `month` ada
            if ($request->has('month') && $request->month) {
                $queryRembang->whereMonth('created_at', $request->month);
                $queryLuarRembang->whereMonth('created_at', $request->month);
            }

            // Hitung jumlah data
            $jumlahRembang = $queryRembang->count();
            $jumlahLuarRembang = $queryLuarRembang->count();

            // Data untuk ditampilkan di tabel
            $data = [
                ['judul_lowongan' => 'Rembang', 'jumlahAktif' => $jumlahRembang],
                ['judul_lowongan' => 'Luar Rembang', 'jumlahAktif' => $jumlahLuarRembang]
            ];

            return DataTables::of($data)
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
