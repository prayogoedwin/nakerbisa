<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeahlianKeterampilan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class PencariKeahlianKeterampilanController extends Controller
{
    //
    public function index(Request $request, $id = null)
    {
        // Mendapatkan user yang sedang login
        $userId = auth()->user()->id;
        $isSuperAdmin = auth()->user()->roles[0]['name'] == 'super-admin'; // Mengecek apakah user adalah super-admin

        if ($request->ajax()) {
            $datas = NakerPencariKeahlianKeterampilan::select(
                'naker_pencari_keahlian_keterampilan.id',
                'naker_pencari_keahlian_keterampilan.keahlian',
            );

            // Jika user adalah super-admin, filter berdasarkan user_id dari URL
            if ($isSuperAdmin && $id) {
                $datas->where('naker_pencari_keahlian_keterampilan.user_id', $id); // Filter berdasarkan user_id yang ada di URL
            } elseif (!$isSuperAdmin) {
                // Jika bukan super-admin, filter berdasarkan user_id yang login
                $datas->where('naker_pencari_keahlian_keterampilan.user_id', $userId); // Filter berdasarkan user_id yang login
            }

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
        // Cek apakah user adalah super-admin
        $isSuperAdmin = auth()->user()->roles[0]['name'] == 'super-admin';

        // Jika super-admin, ambil user_id dari request
        $userId = $isSuperAdmin ? $request->user_id : auth()->user()->id;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'keahlian' => 'required|string',
            'user_id' => $isSuperAdmin ? 'required|integer' : 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }


        // Menyimpan data ke tabel users
        NakerPencariKeahlianKeterampilan::create([
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
