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

            // Query untuk menghitung jumlah data berdasarkan status dan tanggal
            $queryAktifRembang = Lowongan::where('kabkota_id', 3317)
                ->where('status_id', 1)
                ->where('tanggal_end', '>=', $today);

            $queryNonAktifRembang = Lowongan::where('kabkota_id', 3317)
                ->where(function ($query) use ($today) {
                    $query->where('status_id', '!=', 1)
                        ->orWhere('tanggal_end', '<', $today);
                });

            $queryAktifLuarRembang = Lowongan::where('kabkota_id', '!=', 3317)
                ->where('status_id', 1)
                ->where('tanggal_end', '>=', $today);

            $queryNonAktifLuarRembang = Lowongan::where('kabkota_id', '!=', 3317)
                ->where(function ($query) use ($today) {
                    $query->where('status_id', '!=', 1)
                        ->orWhere('tanggal_end', '<', $today);
                });

            // Filter berdasarkan bulan jika parameter `month` ada
            if ($request->has('month') && $request->month) {
                $queryAktifRembang->whereMonth('created_at', $request->month);
                $queryNonAktifRembang->whereMonth('created_at', $request->month);
                $queryAktifLuarRembang->whereMonth('created_at', $request->month);
                $queryNonAktifLuarRembang->whereMonth('created_at', $request->month);
            }

            // Hitung jumlah data
            $jumlahAktifRembang = $queryAktifRembang->count();
            $jumlahNonAktifRembang = $queryNonAktifRembang->count();

            $jumlahAktifLuarRembang = $queryAktifLuarRembang->count();
            $jumlahNonAktifLuarRembang = $queryNonAktifLuarRembang->count();

            // Data untuk ditampilkan di tabel
            $data = [
                [
                    'judul_lowongan' => 'Rembang',
                    'jumlahAktif' => $jumlahAktifRembang,
                    'jumlahNonAktif' => $jumlahNonAktifRembang
                ],
                [
                    'judul_lowongan' => 'Luar Rembang',
                    'jumlahAktif' => $jumlahAktifLuarRembang,
                    'jumlahNonAktif' => $jumlahNonAktifLuarRembang
                ]
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
