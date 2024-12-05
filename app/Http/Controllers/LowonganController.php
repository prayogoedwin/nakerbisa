<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LowonganController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->roles->first()->name;
        if ($request->ajax()) {

            if ($userRole == 'tenaga-kerja') {
                //pencari kerja
                $lokers = Lowongan::select(
                    'naker_lowongan.id',
                    'naker_lowongan.judul_lowongan',
                    'naker_lowongan.tanggal_start',
                    'naker_lowongan.tanggal_end',
                    'naker_lowongan.deskripsi',
                    'naker_progres.name as progres_name' // Menambahkan kolom 'name' dari tabel naker_progres
                )
                    ->join('naker_progres', 'naker_lowongan.status_id', '=', 'naker_progres.kode') // Join tabel
                    ->where('naker_progres.modul', 'lowongan') // Kondisi where
                    ->where('naker_lowongan.status_id', 1) // Kondisi where
                    ->whereNull('naker_lowongan.deleted_at'); // Memastikan data tidak terhapus

                return DataTables::of($lokers)
                    ->addIndexColumn()
                    ->addColumn('options', function ($loker) {
                        return '
                        <button class="btn btn-primary btn-sm" onclick="showDetailModal(' . $loker->id . ')">Lamar</button>
                    ';
                    })
                    ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                    ->make(true);
            } else if ($userRole == 'penyedia-kerja') {
                //pencari kerja
                $lokers = Lowongan::select(
                    'naker_lowongan.id',
                    'naker_lowongan.judul_lowongan',
                    'naker_lowongan.tanggal_start',
                    'naker_lowongan.tanggal_end',
                    'naker_lowongan.deskripsi',
                    'naker_progres.name as progres_name' // Menambahkan kolom 'name' dari tabel naker_progres
                )
                    ->join('naker_progres', 'naker_lowongan.status_id', '=', 'naker_progres.kode') // Join tabel
                    ->where('naker_progres.modul', 'lowongan') // Kondisi where
                    ->where('naker_lowongan.posted_by', $userId) // Kondisi where
                    ->whereNull('naker_lowongan.deleted_at'); // Memastikan data tidak terhapus

                return DataTables::of($lokers)
                    ->addIndexColumn()
                    ->addColumn('options', function ($loker) {
                        return '
                        <a href="' . route('lowongan.pelamar', $loker->id) . '" class="btn btn-success btn-sm">Lihat Pelamar</a>
                        <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $loker->id . ')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $loker->id . ')">Hapus</button>
                    ';
                    })
                    ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                    ->make(true);
            } else {

                //lainnya
                $lokers = Lowongan::select(
                    'naker_lowongan.id',
                    'naker_lowongan.judul_lowongan',
                    'naker_lowongan.tanggal_start',
                    'naker_lowongan.tanggal_end',
                    'naker_lowongan.deskripsi',
                    'naker_progres.name as progres_name' // Menambahkan kolom 'name' dari tabel naker_progres
                )
                    ->join('naker_progres', 'naker_lowongan.status_id', '=', 'naker_progres.kode') // Join tabel
                    ->where('naker_progres.modul', 'lowongan') // Kondisi where
                    ->whereNull('naker_lowongan.deleted_at'); // Memastikan data tidak terhapus

                return DataTables::of($lokers)
                    ->addIndexColumn()
                    ->addColumn('options', function ($loker) {
                        return '
                        <a href="' . route('lowongan.pelamar', $loker->id) . '" class="btn btn-success btn-sm">Lihat Pelamar</a>
                        <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $loker->id . ')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $loker->id . ')">Hapus</button>
                    ';
                    })

                    ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                    ->make(true);
            }
        }

        // Data untuk form di view
        $data['jabatans'] = getJabatan();
        $data['sektors'] = getSektor();
        $data['kabkotas'] = getKabkota();
        $data['pendidikans'] = getPendidikan();
        $data['maritals'] = getMarital();
        $data['progresloker'] = getProgresLoker();

        return view('backend.lowongan.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'jabatan_id' => 'required|integer',
            'sektor_id' => 'required|integer',
            'tanggal_start' => 'required|date',
            'tanggal_end' => 'required|date',
            'judul_lowongan' => 'required|string|max:255',
            'kabkota_id' => 'required|integer',
            'lokasi_penempatan_text' => 'required|string',
            'jumlah_pria' => 'required|integer',
            'jumlah_wanita' => 'required|integer',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $userId = auth()->user()->id;
            // Menyimpan data ke tabel users
            $user = Lowongan::create([
                'jabatan_id' => $request->jabatan_id,
                'sektor_id' => $request->sektor_id,
                'tanggal_start' => $request->tanggal_start,
                'tanggal_end' => $request->tanggal_end,
                'judul_lowongan' => $request->judul_lowongan,
                'kabkota_id' => $request->kabkota_id,
                'lokasi_penempatan_text' => $request->lokasi_penempatan_text,
                'jumlah_pria' => $request->jumlah_pria,
                'jumlah_wanita' => $request->jumlah_wanita,
                'deskripsi' => $request->deskripsi,
                'pendidikan_id' => $request->pendidikan_id,
                'jurusan_id' => $request->jurusan_id,
                'marital_id' => $request->marital_id,
                'posted_by' => $userId,
            ]);

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            // DB::rollBack();
            // return back()->with('error', $th->getMessage());
            DB::rollBack();
            Log::error($th);
            // return back()->with('error', $th->getMessage());
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage()
            ]);
        }


        // Simpan data lowongan
        // $lowongan = EtamLowongan::create($validatedData);
        // return response()->json($lowongan, 201); // Kode 201 untuk Created
    }

    public function show($id)
    {
        try {
            $data = Lowongan::select('*')->findOrFail($id);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $userId = auth()->user()->id;
            $userRole = auth()->user()->role;

            // Validasi input
            $validatedData = $request->validate([
                'jabatan_id' => 'required|integer',
                'sektor_id' => 'required|integer',
                'tanggal_start' => 'required|date',
                'tanggal_end' => 'required|date',
                'judul_lowongan' => 'required|string|max:255',
                'kabkota_id' => 'required|integer',
                'lokasi_penempatan_text' => 'required|string',
                'jumlah_pria' => 'required|integer',
                'jumlah_wanita' => 'required|integer',
                'deskripsi' => 'required|string',
            ]);

            // Cari admin berdasarkan ID
            $data = Lowongan::findOrFail($id);


            // Data yang akan diupdate
            $updateData = [
                'jabatan_id' => $request->jabatan_id,
                'sektor_id' => $request->sektor_id,
                'tanggal_start' => $request->tanggal_start,
                'tanggal_end' => $request->tanggal_end,
                'judul_lowongan' => $request->judul_lowongan,
                'kabkota_id' => $request->kabkota_id,
                'lokasi_penempatan_text' => $request->lokasi_penempatan_text,
                'jumlah_pria' => $request->jumlah_pria,
                'jumlah_wanita' => $request->jumlah_wanita,
                'deskripsi' => $request->deskripsi,
                'pendidikan_id' => $request->pendidikan_id,
                'jurusan_id' => $request->jurusan_id,
                'marital_id' => $request->marital_id,
                'status_id' => $request->status_id,
                'updated_by' => $userId,
            ];

            // Cek jika user adalah super-admin
            if ($userRole == 'super-admin') {
                // Jika super-admin, izinkan mengupdate status_id
                $updateData['status_id'] = $request->status_id;
            }

            // Update data lowongan
            $data->update($updateData);

            return response()->json(['success' => true, 'message' => 'update data berhasil']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function lamar(Request $request, $id)
    {
        try {
            // Get the authenticated user's ID and role
            $userId = auth()->user()->id;
            $userRole = auth()->user()->role;

            // Find the job (lowongan) by its ID
            $lowongan = Lowongan::findOrFail($id);

            // Create a new lamaran record
            $lamaran = Lamaran::create([
                'pencari_id' => $userId, // The ID of the user applying
                'lowongan_id' => $lowongan->id, // The ID of the job being applied for
                'progres_id' => 0, // From the request
                'created_at' => now(), // Current timestamp
                'updated_at' => now(), // Current timestamp
            ]);

            return response()->json(['success' => true, 'message' => 'Lamaran berhasil dibuat', 'lamaran' => $lamaran]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function pelamar(Request $request, $id)
    {
        if ($request->ajax()) {
            $pelamars = Lamaran::select(
                'naker_lamarans.id',
                'users.email',
                'users.whatsapp',
                'users_pencari.name', // Select name from users_pencari
                'naker_lamarans.keterangan',
                'naker_lamarans.created_at'
            )
                ->join('users', 'naker_lamarans.pencari_id', '=', 'users.id') // Join with users table
                ->join('users_pencari', 'users.id', '=', 'users_pencari.user_id') // Join with users_pencari table
                ->where('naker_lamarans.lowongan_id', $id)
                ->whereNull('naker_lamarans.deleted_at'); // Ensure data is not deleted

            return DataTables::of($pelamars)
                ->addIndexColumn()
                ->addColumn('options', function ($pelamar) {
                    return '
                        <button class="btn btn-primary btn-sm" onclick="showDetailModal(' . $pelamar->id . ')">Detail</button>
                    ';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.lowongan.lamaran', ['lowongan_id' => $id]);
    }

    public function softdelete($id)
    {
        try {
            // Cari admin berdasarkan ID
            $data = Lowongan::findOrFail($id);
            $data->delete();
            return response()->json(['success' => true, 'message' => 'hapus data  berhasil.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error A: ' . $e->getMessage()]);
        }
    }

    public function penempatan(Request $request)
    {
        $progressId = DB::table('naker_progres')
            ->where('kode', 3)
            ->where('modul', 'lamaran')
            ->value('id');

        $user = auth()->user();

        if ($request->ajax()) {
            $query = DB::table('naker_lamarans')
                ->join('naker_progres', 'naker_lamarans.progres_id', '=', 'naker_progres.id') 
                ->join('users', 'naker_lamarans.pencari_id', '=', 'users.id') 
                ->join('naker_lowongan', 'naker_lamarans.lowongan_id', '=', 'naker_lowongan.id') 
                ->select(
                    'naker_progres.name as status_name',
                    'users.name as pencari_name',
                    'naker_lowongan.judul_lowongan as lowongan_title'
                )
                ->where('naker_lamarans.progres_id', $progressId);

            if ($user->hasRole('penyedia-kerja')) {
                $query->where('naker_lowongan.posted_by', $user->id);
            }

            // Ambil data penempatan
            $penempatanData = $query->get();

            return DataTables::of($penempatanData)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.penempatan.index');
    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
