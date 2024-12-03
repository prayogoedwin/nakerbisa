<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeahlianKeterampilan;
use App\Models\NakerPencariKeterampilan;
use App\Models\NakerPencariPendidikan;
use App\Models\NakerPencariPengalaman;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    //
    public function pencari(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data users_pencari beserta nama wilayah
            $query = UserPencari::select([
                'users_pencari.id',
                'users_pencari.ktp',
                'users_pencari.name',
                'users_pencari.tempat_lahir',
                'users_pencari.tanggal_lahir',
                'users_pencari.gender',
                'users_pencari.alamat',
                'users_pencari.kodepos',
                'users_pencari.tahun_lulus',
                'users_pencari.medsos',
                'users_pencari.status_saat_ini',
                'users_pencari.sektor_pekerjaan_saat_ini',
                'users_pencari.jam_kerja',
                'users_pencari.gaji',
                'users_pencari.id_kota',
                'users_pencari.id_kecamatan',
                'users_pencari.id_desa'
            ]);

            return DataTables::eloquent($query)
                ->addColumn('kota', function ($data) {
                    // Ambil nama kota berdasarkan id_kota
                    $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                    return $kota ?? 'Tidak Ditemukan';
                })
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->addColumn('desa', function ($data) {
                    // Ambil nama desa berdasarkan id_desa
                    $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                    return $desa ?? 'Tidak Ditemukan';
                })
                ->addColumn('sektor', function ($data) {
                    // Ambil nama sektor berdasarkan sektor_pekerjaan_saat_ini
                    $sektor = DB::table('naker_sektor')->where('id', $data->sektor_pekerjaan_saat_ini)->value('name');
                    return $sektor ?? '-';
                })
                ->addColumn('status', function ($data) {
                    // Ambil nama sektor berdasarkan status_saat_ini
                    $status = DB::table('status_kerja')->where('id', $data->status_saat_ini)->value('status');
                    return $status ?? '-';
                })
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '<a href="' . route('data.pencari.edit', $data->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.data-pencari.pencari');
    }

    public function edit($id)
    {
        $pencari = UserPencari::findOrFail($id);

        // Ambil data pendidikan berdasarkan user_id dari $pencari
        $pendidikan = NakerPencariPendidikan::select(
            'naker_pencari_pendidikan.*',
            'naker_pendidikan.name as pendidikan_name', // Nama Pendidikan
            'naker_jurusan.nama as jurusan_name'        // Nama Jurusan
        )
            ->join('naker_pendidikan', 'naker_pencari_pendidikan.pendidikan_id', '=', 'naker_pendidikan.id') // Join tabel pendidikan
            ->leftJoin('naker_jurusan', 'naker_pencari_pendidikan.jurusan_id', '=', 'naker_jurusan.id')      // Left join tabel jurusan
            ->where('naker_pencari_pendidikan.user_id', $pencari->user_id) // Menggunakan user_id dari $pencari
            ->get();

        // Ambil data keterampilan berdasarkan user_id dari $pencari
        $keterampilan = NakerPencariKeterampilan::where('user_id', $pencari->user_id)->get();

        // Ambil data keahlian berdasarkan user_id dari $pencari
        $keahlian = NakerPencariKeahlianKeterampilan::where('user_id', $pencari->user_id)->get();

        // Ambil data pengalaman kerja berdasarkan user_id dari $pencari
        $pengalaman = NakerPencariPengalaman::where('user_id', $pencari->user_id)->get();

        return view('backend.data-pencari.edit', compact('pencari', 'pendidikan', 'keterampilan', 'pengalaman', 'keahlian'));
    }

    public function updateDataPencari(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:100',
            'ktp' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'id_provinsi' => '64',
            'kabkota_id' => 'required|integer',
            'kecamatan_id' => 'required|integer',
            'desa_id' => 'required|string|max:10',
            'alamat' => 'required|string|max:200',
            'kodepos' => 'required|string|max:5',
            'pendidikan_id' => 'required|integer',
            'jurusan_id' => 'required|integer',
            'tahun_lulus' => 'required|integer',
            'status_perkawinan_id' => 'required',
            'agama_id' => 'required|integer',
            'medsos' => 'required|string|max:200',
            'status_kerja_id' => 'required|string|max:200',
            'sektor_pekerjaan_saat_ini' => 'nullable',
            'jam_kerja' => 'nullable',
            'gaji' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto
        ]);

        // Mengambil data UserPencari berdasarkan ID
        $pencari = UserPencari::findOrFail($id);

        // Jika ada foto baru yang di-upload
        if ($request->hasFile('foto')) {
            // Cek dan hapus foto lama jika ada
            if (!empty($pencari->foto) && Storage::disk('public')->exists($pencari->foto)) {
                Storage::disk('public')->delete($pencari->foto);
            }

            // Simpan foto baru
            $filePath = $request->file('foto')->store('profile_photos', 'public');
            $pencari->foto = $filePath;
        }

        // Update data UserPencari
        $pencari->update([
            'name' => $request->name,
            'ktp' => $request->ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'id_provinsi' => '64',
            'id_kota' => $request->kabkota_id,
            'id_kecamatan' => $request->kecamatan_id,
            'id_desa' => $request->desa_id,
            'alamat' => $request->alamat,
            'kodepos' => $request->kodepos,
            'id_pendidikan' => $request->pendidikan_id,
            'id_jurusan' => $request->jurusan_id,
            'tahun_lulus' => $request->tahun_lulus,
            'id_status_perkawinan' => $request->status_perkawinan_id,
            'id_agama' => $request->agama_id,
            'medsos' => $request->medsos,
            'status_saat_ini' => $request->status_kerja_id,
            'sektor_pekerjaan_saat_ini' => $request->status_kerja_id === '1' ? $request->sektor_pekerjaan_saat_ini : null,
            'jam_kerja' => $request->status_kerja_id === '1' ? $request->jam_kerja : null,
            'gaji' => $request->status_kerja_id === '1' ? $request->gaji : null,
        ]);

        // Redirect ke halaman profil setelah berhasil update
        return redirect()->route('data.pencari')->with('success', 'Profil berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $query = UserPencari::select([
            'id',
            'ktp',
            'name',
            'tempat_lahir',
            'tanggal_lahir',
            'gender',
            'alamat',
            'kodepos',
            'tahun_lulus',
            'medsos',
            'id_kota',
            'id_kecamatan',
            'id_desa',
            'status_saat_ini',
            'sektor_pekerjaan_saat_ini',
            'jam_kerja',
            'gaji'
        ]);

        // Terapkan filter pencarian dari DataTables
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('ktp', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%")
                ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%")
                ->orWhere('kodepos', 'like', "%{$search}%")
                ->orWhere('tahun_lulus', 'like', "%{$search}%")
                ->orWhere('medsos', 'like', "%{$search}%")
                ->orWhere('id_kota', 'like', "%{$search}%")
                ->orWhere('id_kecamatan', 'like', "%{$search}%")
                ->orWhere('id_desa', 'like', "%{$search}%")
                ->orWhere('status_saat_ini', 'like', "%{$search}%")
                ->orWhere('sektor_pekerjaan_saat_ini', 'like', "%{$search}%")
                ->orWhere('jam_kerja', 'like', "%{$search}%")
                ->orWhere('gaji', 'like', "%{$search}%");
        }

        // Ambil data setelah difilter
        $pencariData = $query->get();

        $fileName = 'data_pencari.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Kolom-kolom yang akan diekspor ke CSV
        $columns = [
            'ID',
            'KTP',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Gender',
            'Alamat',
            'Kodepos',
            'Tahun Lulus',
            'Medsos',
            'Kota',
            'Kecamatan',
            'Desa',
            'Status Saat Ini',
            'Sektor Pekerjaan Saat Ini',
            'Jam Kerja',
            'Gaji',
        ];

        // Callback untuk menulis data ke CSV
        $callback = function () use ($pencariData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis header CSV

            foreach ($pencariData as $data) {
                // Ambil nama wilayah untuk setiap kolom
                $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                $sektor = DB::table('naker_sektor')->where('id', $data->sektor_pekerjaan_saat_ini)->value('name');
                $status = DB::table('status_kerja')->where('id', $data->status_saat_ini)->value('status');

                // Tulis data ke CSV dengan nama wilayah
                fputcsv($file, [
                    $data->id,
                    $data->ktp,
                    $data->name,
                    $data->tempat_lahir,
                    $data->tanggal_lahir,
                    $data->gender,
                    $data->alamat,
                    $data->kodepos,
                    $data->tahun_lulus,
                    $data->medsos,
                    $kota,     
                    $kecamatan, 
                    $desa,     
                    $status,
                    $sektor,
                    $data->jam_kerja,
                    $data->gaji
                ]);
            }

            fclose($file);
        };

        // Mengirimkan file CSV ke browser
        return response()->stream($callback, 200, $headers);
    }


    public function penyedia(Request $request)
    {
        if ($request->ajax()) {
            $query = UserPenyedia::select('*');
            return DataTables::eloquent($query)->make(true);
        }

        return view('backend.data.penyedia');
    }
}
