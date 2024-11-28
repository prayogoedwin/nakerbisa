<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeterampilan;
use App\Models\NakerPencariPendidikan;
use App\Models\NakerPencariPengalaman;
use App\Models\User;
use App\Models\UserPencari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user();

        // dd($user->id);
        // die();
        $profil = UserPencari::where('user_id', $user->id)->first();  // Sesuaikan relasi dengan tabel User jika ada
        $pendidikan = NakerPencariPendidikan::select(
            'naker_pencari_pendidikan.*',
            'naker_pendidikan.name as pendidikan_name', // Nama Pendidikan
            'naker_jurusan.nama as jurusan_name'       // Nama Jurusan
        )
            ->join('naker_pendidikan', 'naker_pencari_pendidikan.pendidikan_id', '=', 'naker_pendidikan.id') // Join tabel pendidikan
            ->leftJoin('naker_jurusan', 'naker_pencari_pendidikan.jurusan_id', '=', 'naker_jurusan.id')      // Join tabel jurusan (left join untuk jurusan opsional)
            ->where('naker_pencari_pendidikan.user_id', auth()->id()) // Hanya data milik user saat ini
            ->get();

        // Mengambil data keterampilan berdasarkan user_id
        $keterampilan = NakerPencariKeterampilan::where('user_id', auth()->id())->get();

        // Mengambil data pengalaman kerja berdasarkan user_id
        $pengalaman = NakerPencariPengalaman::where('user_id', auth()->id())->get();

        // Mengirim data ke view
        return view('backend.profil.index', compact('profil', 'pendidikan', 'keterampilan', 'pengalaman'));
    }

    public function updateUser(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data user
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profil.index')->with('success', 'Update data User berhasil diperbarui.');
    }

    public function editProfil($id)
    {
        $profil = UserPencari::where('user_id', $id)->firstOrFail();
        $kabkotas = getKabkota(); // Mengambil semua kabupaten/kota
        $pendidikans = getPendidikan();
        $maritals = getMarital(); // Status perkawinan
        $agamas = getAgama();

        return view('profil.edit', compact('profil', 'kabkotas', 'pendidikans', 'maritals', 'agamas'));
    }

    public function updateProfil(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'ktp' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'id_provinsi' => '64', // Validasi statis untuk id_provinsi
            'kabkota_id' => 'required|integer', // Menggunakan kabkota_id dari input
            'kecamatan_id' => 'required|integer', // Menggunakan kecamatan_id dari input
            'desa_id' => 'required|string|max:10', // Menggunakan desa_id dari input
            'alamat' => 'required|string|max:200',
            'kodepos' => 'required|string|max:5',
            'pendidikan_id' => 'required|integer',
            'jurusan_id' => 'required|integer',
            'tahun_lulus' => 'required|integer',
            'status_perkawinan_id' => 'required',
            'agama_id' => 'required|integer',
            // Validasi lainnya sesuai kebutuhan
        ]);

        $userPencari = UserPencari::where('user_id', $id)->firstOrFail();

        $userPencari->update([
            'name' => $request->name,
            'ktp' => $request->ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'id_provinsi' => '64', // Tetap seperti ini jika statis
            'id_kota' => $request->kabkota_id, // Menyimpan kabkota_id sebagai id_kota
            'id_kecamatan' => $request->kecamatan_id, // Menyimpan kecamatan_id sebagai id_kecamatan
            'id_desa' => $request->desa_id, // Menyimpan desa_id sebagai id_desa
            'alamat' => $request->alamat,
            'kodepos' => $request->kodepos,
            'id_pendidikan' => $request->pendidikan_id,
            'id_jurusan' => $request->jurusan_id,
            'tahun_lulus' => $request->tahun_lulus,
            'id_status_perkawinan' => $request->status_perkawinan_id, 
            'id_agama' => $request->agama_id, 
        ]);

        return redirect()->route('profil.index')->with('success', 'Update data Profil berhasil diperbarui.');
    }


    public function cetakCV()
    {
        $user = auth()->user();

        // Muat relasi `pencari` untuk mendapatkan data lengkap
        $user->load('pencari');
        $pendidikan = NakerPencariPendidikan::select(
            'naker_pencari_pendidikan.*',
            'naker_jurusan.nama as jurusan_name',
            'naker_pendidikan.name as pendidikan_name' // Nama tingkat pendidikan
        )
            ->leftJoin('naker_jurusan', 'naker_pencari_pendidikan.jurusan_id', '=', 'naker_jurusan.id')
            ->leftJoin('naker_pendidikan', 'naker_pencari_pendidikan.pendidikan_id', '=', 'naker_pendidikan.id')
            ->where('user_id', $user->id)
            ->get();
        $pengalaman = NakerPencariPengalaman::where('user_id', $user->id)->get();
        $keterampilan = NakerPencariKeterampilan::where('user_id', $user->id)->get();

        return view('backend.profil.cetak-cv', compact('user', 'pendidikan', 'pengalaman', 'keterampilan'));
    }
}
