<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeterampilan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class PencariKeterampilanController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = NakerPencariKeterampilan::select(
                'id',
                'lembaga_penyelenggara',
                'alamat_penyelenggara',
                'lulus_tahun',
                'no_sertifikat',
                'lembaga_penguji'
            );

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

        return view('backend.profil.keterampilan.index');
    }

    // Method untuk menyimpan data user baru
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'lembaga_penyelenggara' => 'required|string',
            'alamat_penyelenggara' => 'required|string',
            'lulus_tahun' => 'required|numeric|min:1900|max:' . date('Y'),
            'no_sertifikat' => 'required|numeric',
            'lembaga_penguji' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }


        // Menyimpan data ke tabel users
        $user = NakerPencariKeterampilan::create([
            'user_id' => $userId,
            'lembaga_penyelenggara' => $request->lembaga_penyelenggara,
            'alamat_penyelenggara' => $request->alamat_penyelenggara,
            'lulus_tahun' => $request->lulus_tahun,
            'no_sertifikat' => $request->no_sertifikat,
            'lembaga_penguji' => $request->lembaga_penguji,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        // Ambil data keterampilan berdasarkan ID
        $keterampilan = NakerPencariKeterampilan::find($id);

        if ($keterampilan) {
            return response()->json([
                'success' => true,
                'data' => $keterampilan
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Keterampilan tidak ditemukan.'
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
            'lembaga_penyelenggara' => 'required|string|max:255',
            'alamat_penyelenggara' => 'required|string|max:255',
            'lulus_tahun' => 'required|integer',
            'no_sertifikat' => 'required|integer',
            'lembaga_penguji' => 'required|string|max:255',
        ]);

        // Cari keterampilan berdasarkan ID
        $keterampilan = NakerPencariKeterampilan::find($id);

        if ($keterampilan) {
            // Update data keterampilan
            $keterampilan->lembaga_penyelenggara = $validated['lembaga_penyelenggara'];
            $keterampilan->alamat_penyelenggara = $validated['alamat_penyelenggara'];
            $keterampilan->lulus_tahun = $validated['lulus_tahun'];
            $keterampilan->no_sertifikat = $validated['no_sertifikat'];
            $keterampilan->lembaga_penguji = $validated['lembaga_penguji'];
            $keterampilan->save();

            return response()->json([
                'success' => true,
                'message' => 'keterampilan berhasil diperbarui!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'keterampilan tidak ditemukan.'
            ], 404);
        }
    }

    public function softdelete($id)
    {
        try {
            // Find the record by its ID
            $data = NakerPencariKeterampilan::findOrFail($id);

            // Perform the soft delete
            $data->delete();

            return response()->json(['success' => true, 'message' => 'Data successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
