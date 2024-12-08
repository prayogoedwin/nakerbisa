<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeahlianKeterampilan;
use App\Models\NakerPencariKeterampilan;
use App\Models\NakerPencariPendidikan;
use App\Models\NakerPencariPengalaman;
use App\Models\User;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user();

        // dd($user->id);
        // die();
        $profil = UserPencari::where('user_id', $user->id)->first();  // Sesuaikan relasi dengan tabel User jika ada
        $profilPenyedia = UserPenyedia::where('user_id', $user->id)->first();  // Sesuaikan relasi dengan tabel User jika ada
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

        // Mengambil data keterampilan berdasarkan user_id
        $keahlian = NakerPencariKeahlianKeterampilan::where('user_id', auth()->id())->get();

        // Mengambil data pengalaman kerja berdasarkan user_id
        $pengalaman = NakerPencariPengalaman::where('user_id', auth()->id())->get();

        // Mengirim data ke view
        return view('backend.profil.index', compact('profil', 'profilPenyedia', 'pendidikan', 'keterampilan', 'pengalaman', 'keahlian'));
    }

    public function updateUser(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'whatsapp' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        // Ambil data user
        $user = User::findOrFail($id);

        // Update data user (name, email, whatsapp, password)
        $user->name = $request->name;
        $user->email = $request->email;
        $user->whatsapp = $request->whatsapp;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Simpan data user
        $user->save();

        // Check if user has the role 'penyedia-kerja'
        if (Auth::user()->roles->contains('name', 'penyedia-kerja')) {
            // Cek apakah UserPenyedia ada
            $userPenyedia = UserPenyedia::where('user_id', $user->id)->first();

            // Jika UserPenyedia tidak ada, kita bisa membuat record baru
            if (!$userPenyedia) {
                $userPenyedia = new UserPenyedia();
                $userPenyedia->user_id = $user->id;
            }

            // Cek apakah foto baru diupload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if (!empty($userPenyedia->foto) && Storage::disk('public')->exists($userPenyedia->foto)) {
                    Storage::disk('public')->delete($userPenyedia->foto);
                }

                // Simpan foto baru
                $filePath = $request->file('foto')->store('profile_photos', 'public');
                $userPenyedia->foto = $filePath; // Simpan path file foto di model UserPenyedia
            }

            // Simpan perubahan pada UserPenyedia
            $userPenyedia->save();
        }

        // Redirect dengan pesan sukses
        return redirect()->route('profil.index')->with('success', 'Data user berhasil diperbarui.');
    }


    public function editProfil($id)
    {
        $profil = UserPencari::where('user_id', $id)->firstOrFail();
        $kabkotas = getKabkota(); // Mengambil semua kabupaten/kota
        $pendidikans = getPendidikan();
        $maritals = getMarital(); // Status perkawinan
        $agamas = getAgama();
        $statusKerjas = getStatusKerja();
        $sektors = getSektor();

        return view('profil.edit', compact('profil', 'kabkotas', 'pendidikans', 'maritals', 'agamas', 'sektors', 'statusKerjas'));
    }

    public function updateProfil(Request $request, $id)
    {
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
            'lokasi_kerja_saat_ini' => 'required|in:0,1',
            'lokasi_kerja_saat_ini_kec' => 'nullable|exists:naker_kecamatan,id',
            'sektor_pekerjaan_saat_ini' => 'nullable',
            'jam_kerja' => 'nullable',
            'gaji' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto
        ]);

        $userPencari = UserPencari::where('user_id', $id)->firstOrFail();

        if ($request->hasFile('foto')) {
            // Cek dan hapus foto lama jika ada
            if (!empty($userPencari->foto) && Storage::disk('public')->exists($userPencari->foto)) {
                Storage::disk('public')->delete($userPencari->foto);
            }

            // Simpan foto baru
            $filePath = $request->file('foto')->store('profile_photos', 'public');
            $userPencari->foto = $filePath;
        }

        // Menyimpan lokasi_kerja_saat_ini_kec berdasarkan kondisi
        // Jika status_kerja_id adalah 1, kita pertahankan lokasi kerja saat ini dan kecamatan yang dipilih
        $lokasiKerjaKecamatan = ($request->status_kerja_id == '1') ? $request->lokasi_kerja_saat_ini == '0' ? $request->lokasi_kerja_saat_ini_kec : null : null;

        $userPencari->update([
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

            // Set sektor, jam kerja, dan gaji berdasarkan status kerja
            'sektor_pekerjaan_saat_ini' => $request->status_kerja_id === '1' ? $request->sektor_pekerjaan_saat_ini : null,
            'jam_kerja' => $request->status_kerja_id === '1' ? $request->jam_kerja : null,
            'gaji' => $request->status_kerja_id === '1' ? $request->gaji : null,

            // Update lokasi kerja dan kecamatan
            'lokasi_kerja_saat_ini' => $request->lokasi_kerja_saat_ini,
            'lokasi_kerja_saat_ini_kec' => $lokasiKerjaKecamatan, // Set to null if not Rembang or not working
        ]);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
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

        return view('backend.profil.cetak-cv-new', compact('user', 'pendidikan', 'pengalaman', 'keterampilan'));
    }

    public function lihatCV(Request $request, $id)
    {

        $user = UserPencari::where('user_id', $id)->first();  // Sesuaikan relasi dengan tabel User jika ada
        $pendidikan = NakerPencariPendidikan::select(
            'naker_pencari_pendidikan.*',
            'naker_jurusan.nama as jurusan_name',
            'naker_pendidikan.name as pendidikan_name' // Nama tingkat pendidikan
        )
            ->leftJoin('naker_jurusan', 'naker_pencari_pendidikan.jurusan_id', '=', 'naker_jurusan.id')
            ->leftJoin('naker_pendidikan', 'naker_pencari_pendidikan.pendidikan_id', '=', 'naker_pendidikan.id')
            ->where('user_id', $id)
            ->get();
        $pengalaman = NakerPencariPengalaman::where('user_id', $id)->get();
        $keterampilan = NakerPencariKeterampilan::where('user_id', $id)->get();

        return view('backend.profil.cetak-cv-new-penyedia', compact('user', 'pendidikan', 'pengalaman', 'keterampilan'));
    }
}
