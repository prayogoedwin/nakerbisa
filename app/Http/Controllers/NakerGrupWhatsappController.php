<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NakerGrupWhatsappController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = DB::table('naker_grup_whatsapp')
                ->select('id', 'tipe_grup', 'link_grup', 'created_at')
                ->orderByDesc('id');

            if ($request->filled('tipe_grup')) {
                $datas->where('tipe_grup', $request->tipe_grup);
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

        $tipeGrupOptions = $this->tipeGrupOptions();
        return view('backend.setting.grup-whatsapp.index', compact('tipeGrupOptions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe_grup' => 'required|in:tenaga_kerja,perusahaan,bkk,blk',
            'link_grup' => 'required|url|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        DB::table('naker_grup_whatsapp')->insert([
            'tipe_grup' => $request->tipe_grup,
            'link_grup' => $request->link_grup,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function getData($id)
    {
        $data = DB::table('naker_grup_whatsapp')
            ->select('id', 'tipe_grup', 'link_grup')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tipe_grup' => 'required|in:tenaga_kerja,perusahaan,bkk,blk',
            'link_grup' => 'required|url|max:2000',
        ]);

        DB::table('naker_grup_whatsapp')
            ->where('id', $id)
            ->update([
                'tipe_grup' => $validatedData['tipe_grup'],
                'link_grup' => $validatedData['link_grup'],
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true, 'message' => 'Update data berhasil']);
    }

    public function destroy($id)
    {
        DB::table('naker_grup_whatsapp')->where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Hapus data berhasil']);
    }

    private function tipeGrupOptions(): array
    {
        return [
            'tenaga_kerja' => 'Tenaga Kerja',
            'perusahaan' => 'Perusahaan',
            'bkk' => 'BKK',
            'blk' => 'BLK',
        ];
    }
}
