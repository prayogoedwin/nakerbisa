<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeahlianKeterampilan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class PencariKeahlianKeterampilanController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the current authenticated user
        $userId = auth()->user()->id;

        if ($request->ajax()) {
            $datas = NakerPencariKeahlianKeterampilan::select(
                'id',
                'keahlian'
            )->where('naker_pencari_keahlian_keterampilan.user_id', $userId);

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

        return view('backend.profil.keahlian-keterampilan.index');
    }

    // Method untuk menyimpan data user baru
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'keahlian' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }


        // Menyimpan data ke tabel users
        $user = NakerPencariKeahlianKeterampilan::create([
            'user_id' => $userId,
            'keahlian' => $request->keahlian,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        // Ambil data keterampilan berdasarkan ID
        $keterampilan = NakerPencariKeahlianKeterampilan::find($id);

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
            'keahlian' => 'required|string|max:255',
        ]);

        // Cari keterampilan berdasarkan ID
        $keterampilan = NakerPencariKeahlianKeterampilan::find($id);

        if ($keterampilan) {
            // Update data keterampilan
            $keterampilan->keahlian = $validated['keahlian'];
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
            $data = NakerPencariKeahlianKeterampilan::findOrFail($id);

            // Perform the soft delete
            $data->delete();

            return response()->json(['success' => true, 'message' => 'Data successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
