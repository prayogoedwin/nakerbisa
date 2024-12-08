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

            // Query data untuk kategori "Rembang"
            $queryAktifRembang = Lowongan::where('kabkota_id', 3317)
                ->where('status_id', 1)
                ->where('tanggal_end', '>=', $today);

            $queryNonAktifRembang = Lowongan::where('kabkota_id', 3317)
                ->where(function ($query) use ($today) {
                    $query->where('status_id', '!=', 1)
                        ->orWhere('tanggal_end', '<', $today);
                });

            // Query data untuk kategori "Luar Rembang"
            $queryAktifLuarRembang = Lowongan::where('kabkota_id', '!=', 3317)
                ->where('status_id', 1)
                ->where('tanggal_end', '>=', $today);

            $queryNonAktifLuarRembang = Lowongan::where('kabkota_id', '!=', 3317)
                ->where(function ($query) use ($today) {
                    $query->where('status_id', '!=', 1)
                        ->orWhere('tanggal_end', '<', $today);
                });

            // Filter berdasarkan bulan jika ada
            if ($request->has('month') && $request->month) {
                $queryAktifRembang->whereMonth('created_at', $request->month);
                $queryNonAktifRembang->whereMonth('created_at', $request->month);
                $queryAktifLuarRembang->whereMonth('created_at', $request->month);
                $queryNonAktifLuarRembang->whereMonth('created_at', $request->month);
            }

            // Hitung jumlah data untuk tiap kategori dan gender
            $jumlahAktifRembangL = $queryAktifRembang->sum('jumlah_pria');
            $jumlahAktifRembangP = $queryAktifRembang->sum('jumlah_wanita');

            $jumlahNonAktifRembangL = $queryNonAktifRembang->sum('jumlah_pria');
            $jumlahNonAktifRembangP = $queryNonAktifRembang->sum('jumlah_wanita');

            $jumlahAktifLuarRembangL = $queryAktifLuarRembang->sum('jumlah_pria');
            $jumlahAktifLuarRembangP = $queryAktifLuarRembang->sum('jumlah_wanita');

            $jumlahNonAktifLuarRembangL = $queryNonAktifLuarRembang->sum('jumlah_pria');
            $jumlahNonAktifLuarRembangP = $queryNonAktifLuarRembang->sum('jumlah_wanita');

            // Total semua lowongan
            $jumlahSemuaRembangL = $jumlahAktifRembangL + $jumlahNonAktifRembangL;
            $jumlahSemuaRembangP = $jumlahAktifRembangP + $jumlahNonAktifRembangP;

            $jumlahSemuaLuarRembangL = $jumlahAktifLuarRembangL + $jumlahNonAktifLuarRembangL;
            $jumlahSemuaLuarRembangP = $jumlahAktifLuarRembangP + $jumlahNonAktifLuarRembangP;

            // Data untuk ditampilkan di tabel
            $data = [
                [
                    'judul_lowongan' => 'Rembang',
                    'jumlahAktifL' => $jumlahAktifRembangL,
                    'jumlahAktifP' => $jumlahAktifRembangP,
                    'jumlahNonAktifL' => $jumlahNonAktifRembangL,
                    'jumlahNonAktifP' => $jumlahNonAktifRembangP,
                    'jumlahSemuaL' => $jumlahSemuaRembangL,
                    'jumlahSemuaP' => $jumlahSemuaRembangP
                ],
                [
                    'judul_lowongan' => 'Luar Rembang',
                    'jumlahAktifL' => $jumlahAktifLuarRembangL,
                    'jumlahAktifP' => $jumlahAktifLuarRembangP,
                    'jumlahNonAktifL' => $jumlahNonAktifLuarRembangL,
                    'jumlahNonAktifP' => $jumlahNonAktifLuarRembangP,
                    'jumlahSemuaL' => $jumlahSemuaLuarRembangL,
                    'jumlahSemuaP' => $jumlahSemuaLuarRembangP
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
