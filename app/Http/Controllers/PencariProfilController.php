<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariPendidikan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;

class PencariProfilController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = NakerPencariPendidikan::select('id', 'user_id', 'pendidikan_id', 'jurusan_id', 'nama_sekolah', 'alamat_sekolah', 'lulus');

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '
                    <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $data->id . ')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $data->id . ')">Delete</button>
                ';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.profil.index');
    }


    // Method untuk menyimpan data user baru
    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'pendidikan_id' => 'required|integer',
            'jurusan_id' => 'required|integer',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:255',
            'lulus' => 'required|integer|min:1900|max:' . date('Y')
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        NakerPencariPendidikan::create([
            'user_id' => $userId,
            'pendidikan_id' => $request->pendidikan_id,
            'jurusan_id' => $request->jurusan_id,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'lulus' => $request->lulus,
        ]);

        return response()->json(['success' => true]);
    }


    public function getData($id)
    {
        try {
            $data = NakerPencariPendidikan::select('id', 'user_id', 'pendidikan_id', 'jurusan_id', 'nama_sekolah', 'alamat_sekolah', 'lulus')->findOrFail($id);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pendidikan_id' => 'required|integer',
            'jurusan_id' => 'required|integer',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:255',
            'lulus' => 'required|integer|min:1900|max:' . date('Y')
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        try {
            $data = NakerPencariPendidikan::findOrFail($id);

            $data->update([
                'pendidikan_id' => $request->pendidikan_id,
                'jurusan_id' => $request->jurusan_id,
                'nama_sekolah' => $request->nama_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'lulus' => $request->lulus,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function softdelete($id)
    {
        try {
            $data = NakerPencariPendidikan::findOrFail($id);
            $data->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
