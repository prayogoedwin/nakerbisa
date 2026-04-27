<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NakerJurusanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = DB::table('naker_jurusan')
                ->leftJoin('naker_pendidikan', 'naker_jurusan.id_pendidikans', '=', 'naker_pendidikan.id')
                ->select(
                    'naker_jurusan.id',
                    'naker_jurusan.nama',
                    'naker_jurusan.id_pendidikans',
                    'naker_pendidikan.name as pendidikan_name'
                );

            if ($request->filled('pendidikan_id')) {
                $datas->where('naker_jurusan.id_pendidikans', $request->pendidikan_id);
            }

            return DataTables::query($datas)
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

        $pendidikans = DB::table('naker_pendidikan')->select('id', 'name')->orderBy('id')->get();
        return view('backend.setting.jurusan.index', compact('pendidikans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'id_pendidikans' => 'required|exists:naker_pendidikan,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        DB::table('naker_jurusan')->insert([
            'nama' => $request->nama,
            'id_pendidikans' => $request->id_pendidikans,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function getData($id)
    {
        try {
            $data = DB::table('naker_jurusan')
                ->select('id', 'nama', 'id_pendidikans')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
            }

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'id_pendidikans' => 'required|exists:naker_pendidikan,id',
            ]);

            DB::table('naker_jurusan')
                ->where('id', $id)
                ->update([
                    'nama' => $validatedData['nama'],
                    'id_pendidikans' => $validatedData['id_pendidikans'],
                    'updated_at' => now(),
                ]);

            return response()->json(['success' => true, 'message' => 'Update data berhasil']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('naker_jurusan')->where('id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Hapus data berhasil']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal hapus data: ' . $e->getMessage()]);
        }
    }
}
