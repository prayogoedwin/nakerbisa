<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariPengalaman;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class PencariPengalamanController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the current authenticated user
        $userId = auth()->user()->id;

        if ($request->ajax()) {
            $datas = NakerPencariPengalaman::select(
                'id',
                'nama_perusahaan',
                'alamat_perusahaan',
                'mulai_tahun',
                'berhenti_tahun',
                'jabatan'
            )->where('naker_pencari_pengalaman.user_id', $userId); // Filter berdasarkan user_id yang login;

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '
                        <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $data->id . ')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $data->id . ')">Delete</button>
                    ';
                })
                ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                ->make(true);
        }

        return view('backend.profil.pengalaman.index');
    }

    // Method untuk menyimpan data user baru
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string',
            'alamat_perusahaan' => 'required|string',
            'mulai_tahun' => 'required|numeric|min:1900|max:' . date('Y'),
            'berhenti_tahun' => 'nullable|numeric|min:1900|max:' . date('Y'),
            'jabatan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }


        // Menyimpan data ke tabel users
        $user = NakerPencariPengalaman::create([
            'user_id' => $userId,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'mulai_tahun' => $request->mulai_tahun,
            'berhenti_tahun' => $request->berhenti_tahun,
            'jabatan' => $request->jabatan,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        // Ambil data pengalaman berdasarkan ID
        $pengalaman = NakerPencariPengalaman::find($id);

        if ($pengalaman) {
            return response()->json([
                'success' => true,
                'data' => $pengalaman
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pengalaman tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Update the specified experience in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string|max:255',
            'mulai_tahun' => 'required|integer',
            'berhenti_tahun' => 'required|integer',
            'jabatan' => 'required|string|max:255',
        ]);

        // Cari pengalaman berdasarkan ID
        $pengalaman = NakerPencariPengalaman::find($id);

        if ($pengalaman) {
            // Update data pengalaman
            $pengalaman->nama_perusahaan = $validated['nama_perusahaan'];
            $pengalaman->alamat_perusahaan = $validated['alamat_perusahaan'];
            $pengalaman->mulai_tahun = $validated['mulai_tahun'];
            $pengalaman->berhenti_tahun = $validated['berhenti_tahun'];
            $pengalaman->jabatan = $validated['jabatan'];
            $pengalaman->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengalaman berhasil diperbarui!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pengalaman tidak ditemukan.'
            ], 404);
        }
    }

    public function softdelete($id)
    {
        try {
            // Find the record by its ID
            $data = NakerPencariPengalaman::findOrFail($id);

            // Perform the soft delete
            $data->delete();

            return response()->json(['success' => true, 'message' => 'Data successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
