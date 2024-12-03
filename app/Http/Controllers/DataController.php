<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeterampilan;
use App\Models\NakerPencariPendidikan;
use App\Models\NakerPencariPengalaman;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    //
    public function pencari(Request $request)
    {
        if ($request->ajax()) {
            $query = UserPencari::select(['id', 'name', 'alamat']);

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '
                        <a href="' . route('data.pencari.edit', $data->id) . '" class="btn btn-primary btn-sm">Edit</a>
                    ';
                })
                ->rawColumns(['options']) // Izinkan kolom options untuk merender HTML
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

        // Ambil data pengalaman kerja berdasarkan user_id dari $pencari
        $pengalaman = NakerPencariPengalaman::where('user_id', $pencari->user_id)->get();

        return view('backend.data-pencari.edit', compact('pencari', 'pendidikan', 'keterampilan', 'pengalaman'));
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



    public function penyedia(Request $request)
    {
        if ($request->ajax()) {
            $query = UserPenyedia::select('*');
            return DataTables::eloquent($query)->make(true);
        }

        return view('backend.data.penyedia');
    }
}
