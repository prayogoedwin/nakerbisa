<?php

namespace App\Http\Controllers;

use App\Models\Depan; // Import model Depan
use App\Models\Lowongan;
use App\Models\NakerBerita;
use App\Models\NakerFaq;
use App\Models\NakerGaleri;
use App\Models\NakerInfografis;
use App\Models\NakerPencariKeahlianKeterampilan;
use App\Models\User;
use App\Models\UserBkk;
use App\Models\UserBlk;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DepanController extends Controller
{
    //
    //index
    public function index(Request $request)
    {
        // Mengambil semua data FAQ
        $faq = NakerFaq::all();

        // Mengambil berita terbaru
        $beritaTerbaru = NakerBerita::select('id', 'name', 'cover', 'status')
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        // Menghitung jumlah lowongan terbaru (misalnya berdasarkan lowongan yang dibuat dalam 30 hari terakhir)
        $lowonganTerbaruCount = Lowongan::where('created_at', '>=', now()->subDays(30))
            ->whereNull('deleted_at')
            ->count();

        // Menghitung jumlah lowongan aktif (status_id = 1, misalnya)
        $lowonganAktifCount = Lowongan::where('status_id', 1)
            ->whereNull('deleted_at')
            ->count();

        $lowonganTerbaru = Lowongan::select('naker_lowongan.*', 'users_penyedia.name as perusahaan_name', 'users_penyedia.foto as perusahaan_foto')
            ->join('users_penyedia', 'naker_lowongan.posted_by', '=', 'users_penyedia.user_id')
            ->where('naker_lowongan.created_at', '>=', now()->subDays(30))
            ->whereNull('naker_lowongan.deleted_at')
            ->where('naker_lowongan.status_id', 1)
            ->orderBy('naker_lowongan.created_at', 'desc')
            ->limit(8)
            ->get();


        // Mengirim data ke view
        return view('depan.depan_index', compact('faq', 'beritaTerbaru', 'lowonganTerbaruCount', 'lowonganAktifCount', 'lowonganTerbaru'));
    }

    public function bkk()
    {
        $bkkList = DB::table('users_bkk')
            ->leftJoin('naker_sektor', 'users_bkk.id_sektor', '=', 'naker_sektor.id')
            ->leftJoin('naker_kabkota', 'users_bkk.id_kota', '=', 'naker_kabkota.id')
            ->leftJoin('naker_kecamatan', 'users_bkk.id_kecamatan', '=', 'naker_kecamatan.id')
            ->leftJoin('naker_desa', 'users_bkk.id_desa', '=', 'naker_desa.id')
            ->whereNull('users_bkk.deleted_at')
            ->select(
                'users_bkk.*',
                'naker_sektor.name as sektor_name',
                'naker_kabkota.name as kabkota_name',
                'naker_kecamatan.name as kec_name',
                'naker_desa.name as desa_name'
            )
            ->paginate(10);

        return view('depan.depan_bkk', compact('bkkList'));
    }

    public function blk()
    {
        $blkList = DB::table('users_blk')
            ->leftJoin('naker_kabkota', 'users_blk.id_kota', '=', 'naker_kabkota.id')
            ->leftJoin('naker_kecamatan', 'users_blk.id_kecamatan', '=', 'naker_kecamatan.id')
            ->leftJoin('naker_desa', 'users_blk.id_desa', '=', 'naker_desa.id')
            ->whereNull('users_blk.deleted_at')
            ->select(
                'users_blk.*',
                'naker_kabkota.name as kabkota_name',
                'naker_kecamatan.name as kec_name',
                'naker_desa.name as desa_name'
            )
            ->paginate(10);
        return view('depan.depan_blk', compact('blkList'));
    }

    public function talent_ketrampilan()
    {
        $ketrampilan = NakerPencariKeahlianKeterampilan::select('keahlian')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->paginate(10);

        return view('depan.depan_talent-ketrampilan', compact('ketrampilan'));
    }

    public function talent_pendidikan()
    {
        // Ambil data berdasarkan kecamatan, pendidikan, dan gender (laki-laki/perempuan)
        // $pendidikanLakiLaki = UserPencari::select('naker_pendidikan.name as pendidikan', DB::raw('count(*) as total'))
        //     ->join('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
        //     ->where('users_pencari.gender', 'L')
        //     ->groupBy('users_pencari.id_pendidikan')
        //     ->get();

        $pendidikanLakiLaki = UserPencari::select('naker_pendidikan.name as pendidikan', DB::raw('count(*) as total'))
            ->join('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
            ->where('users_pencari.gender', 'L')
            ->groupBy('users_pencari.id_pendidikan', 'naker_pendidikan.name') // Tambahkan kolom 'naker_pendidikan.name' di sini
            ->get();

        // $pendidikanPerempuan = UserPencari::select('naker_pendidikan.name as pendidikan', DB::raw('count(*) as total'))
        //     ->join('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
        //     ->where('users_pencari.gender', 'P')
        //     ->groupBy('users_pencari.id_pendidikan')
        //     ->get();

        $pendidikanPerempuan = UserPencari::select('naker_pendidikan.name as pendidikan', DB::raw('count(*) as total'))
            ->join('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
            ->where('users_pencari.gender', 'P')
            ->groupBy('users_pencari.id_pendidikan', 'naker_pendidikan.name') // Tambahkan kolom 'naker_pendidikan.name' di sini
            ->get();

        // Kirim data ke view, dan pastikan variabel ada di setiap view
        return view('depan.depan_talent-pendidikan', [
            'pendidikanLakiLaki' => $pendidikanLakiLaki ?? [],
            'pendidikanPerempuan' => $pendidikanPerempuan ?? [],
        ]);
    }

    public function talent_wilayah()
    {
        // Ambil semua kecamatan di Rembang
        $kecamatanData = DB::table('naker_kecamatan')
            ->select('id', 'name')
            ->where('id', 'LIKE', '3317%') // 3317 untuk kecamatan di Rembang
            ->get();

        // Hitung jumlah tenaga kerja per kecamatan dari tabel users_pencari
        $dataTenagaKerja = DB::table('users_pencari')
            ->select('id_kecamatan', DB::raw('count(*) as total'))
            ->where('id_kecamatan', 'LIKE', '3317%') // Filter kecamatan Rembang
            ->groupBy('id_kecamatan')
            ->pluck('total', 'id_kecamatan');

        // Gabungkan data kecamatan dengan jumlah tenaga kerja, default 0 jika tidak ada data
        $rekapData = $kecamatanData->map(function ($item) use ($dataTenagaKerja) {
            return [
                'name' => $item->name,
                'total' => $dataTenagaKerja->get($item->id, 0), // Jika tidak ada, tampilkan 0
            ];
        });

        return view('depan.depan_talent-wilayah', compact('rekapData'));
    }

    public function talent_tempat_kerja()
    {
        // Hitung data rekap berdasarkan kondisi lokasi kerja kecamatan
        $luarRembangCount = UserPencari::whereNull('lokasi_kerja_saat_ini_kec') // lokasi_kerja_saat_ini_kec nullable
            ->count();

        $dalamRembangCount = UserPencari::whereNotNull('lokasi_kerja_saat_ini_kec') // lokasi_kerja_saat_ini_kec tidak null
            ->count();

        // Ambil rekap data untuk grafik bar berdasarkan status_saat_ini = 1 dan lokasi_kerja_saat_ini_kec
        $rekapData = UserPencari::select('lokasi_kerja_saat_ini_kec', DB::raw('count(*) as total'))
            ->where('status_saat_ini', 1)  // status_saat_ini = 1
            ->whereNotNull('lokasi_kerja_saat_ini_kec')
            ->groupBy('lokasi_kerja_saat_ini_kec')
            ->get();

        // Ambil data kecamatan untuk menampilkan nama kecamatan
        $kecamatanData = DB::table('naker_kecamatan')
            ->select('id', 'name')
            ->where('id', 'LIKE', '3317%') // Asumsi kode wilayah Rembang
            ->get();

        // Gabungkan data kecamatan dengan jumlah tenaga kerja
        $rekapDataTempat = $rekapData->map(function ($item) use ($kecamatanData) {
            $kecamatan = $kecamatanData->firstWhere('id', $item->lokasi_kerja_saat_ini_kec);
            return [
                'name' => $kecamatan ? $kecamatan->name : 'Tidak Diketahui',
                'total' => $item->total,
            ];
        });

        return view('depan.depan_talent-tempat-kerja', compact('luarRembangCount', 'dalamRembangCount', 'rekapDataTempat'));
    }

    public function login()
    {
        return view('depan.depan_login');
    }

    public function register()
    {
        return view('depan.depan_register');
    }

    public function lowongan_kerja(Request $request)
    {
        // Ambil parameter pencarian
        $judulLowongan = $request->input('judul_lowongan');
        $pendidikanId = $request->input('pendidikan_id');
        $lokasiId = $request->input('kabkota_id');

        // Query pencarian berdasarkan parameter
        $lowonganDisetujui = Lowongan::select('naker_lowongan.*', 'users_penyedia.name as perusahaan_name', 'users_penyedia.foto as perusahaan_foto')
            ->join('users_penyedia', 'naker_lowongan.posted_by', '=', 'users_penyedia.user_id')
            ->where('naker_lowongan.status_id', 1) // Lowongan yang disetujui
            ->when($judulLowongan, function ($query, $judulLowongan) {
                return $query->where('judul_lowongan', 'like', '%' . $judulLowongan . '%');
            })
            ->when($pendidikanId, function ($query, $pendidikanId) {
                return $query->where('pendidikan_id', $pendidikanId);
            })
            ->when($lokasiId, function ($query, $lokasiId) {
                return $query->where('kabkota_id', $lokasiId);
            })
            ->orderBy('tanggal_start', 'desc')
            ->paginate(9);

        // Kirim data hasil pencarian ke view
        return view('depan.depan_lowongan_kerja', compact('lowonganDisetujui'));
    }

    public function showLowongan($ids)
    {
        $id = decode_url($ids);
        // Ambil detail lowongan berdasarkan ID
        $lowongan = Lowongan::select('naker_lowongan.*', 'users_penyedia.name as perusahaan_name', 'users_penyedia.foto as perusahaan_foto')
            ->join('users_penyedia', 'naker_lowongan.posted_by', '=', 'users_penyedia.user_id')
            ->findOrFail($id);
        $kabkota = DB::table('naker_kabkota')
            ->where('id', $lowongan->kabkota_id)
            ->first();
        $jabatan = DB::table('naker_jabatan')
            ->where('id', $lowongan->jabatan_id)
            ->first();
        $sektor = DB::table('naker_sektor')
            ->where('id', $lowongan->sektor_id)
            ->first();

        return view('depan.depan_lowongan_detail', compact('lowongan', 'sektor', 'jabatan', 'kabkota'));
    }

    public function lowongan_kerja_disabilitas()
    {
        return view('depan.depan_lowongan_kerja_disabilitas');
    }

    public function lowongan_kerja_ema()
    {
        // Fetch the data from the external API
        $response = Http::get('https://bursakerja.jatengprov.go.id/api/lowongan/index');

        // Check if the response is successful
        if ($response->successful()) {
            // Get the data from the response
            $vacancies = $response->json()['data'];

            // Pass the data to the view
            return view('depan.depan_lowongan_kerja_ema', compact('vacancies'));
        } else {
            // Handle the error if the request fails
            return view('depan.depan_lowongan_kerja_ema', ['vacancies' => []]);
        }
    }

    public function lowongan_kerja_krr()
    {
        return view('depan.depan_lowongan_kerja_krr');
    }

    public function statistik()
    {
        return view('depan.depan_statistik');
    }


    public function infografis()
    {
        $infografis = NakerInfografis::where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('depan.depan_infografis', compact('infografis'));
    }

    public function galeri()
    {
        $galeri = NakerGaleri::where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('depan.depan_galeri', compact('galeri'));
    }

    public function berita()
    {
        $berita = NakerBerita::where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('depan.depan_berita', compact('berita'));
    }

    public function show($ids)
    {
        $id = decode_url($ids);
        $berita = NakerBerita::findOrFail($id);

        return view('depan.depan_berita_detail', compact('berita'));
    }


    public function daftar_akun(Request $request)
    {
        $request->validate([
            'role_dipilih' => 'required',
        ]);

        $url_role = encode_url($request->role_dipilih);

        return redirect()->to('depan/daftar?rl=' . $url_role);
    }

    public function daftar(Request $request)
    {
        $rl = $request->input('rl'); // atau bisa juga menggunakan $request->query('rl')
        $decode_rl = decode_url($rl);

        if (!in_array($decode_rl, ['tenaga-kerja', 'penyedia-kerja', 'admin-bkk', 'admin-blk'])) {
            return abort(404);
        }

        $nm_role = '';
        if ($decode_rl == 'tenaga-kerja') {
            $nm_role = 'Tenaga Kerja';
        } else if ($decode_rl == 'penyedia-kerja') {
            $nm_role = 'Penyedia Kerja';
        } else if ($decode_rl == 'admin-bkk') {
            $nm_role = 'BKK';
        } else if ($decode_rl == 'admin-blk') {
            $nm_role = 'BLK';
        }


        $depanModel = new Depan();
        $data['agama'] = $depanModel->getAllAgama(); // Mendapatkan semua data agama
        $data['kabkota'] = $depanModel->getKabkotaByProvince();

        $data['dt'] = array(
            'role' => $decode_rl,
            'role_name' => $nm_role
        );

        session()->forget('email_registered');
        // dd(session('email_registered'));

        // dd($data);
        return view('depan.depan_registerbaru', $data);
        // echo json_encode($data);
    }

    public function cek_awal_akun(Request $request)
    {
        // return response()->json([
        //     'email' => $request->email,
        //     'wa' => $request->wa,
        // ]);

        $userEmail = User::where('email', $request->email)->first();
        if ($userEmail) {
            return response()->json([
                'status' => 0,
                'message' => 'Email sudah pernah terdaftar'
            ]);
        }

        $userWa = User::where('whatsapp', $request->wa)->first();
        if ($userWa) {
            return response()->json([
                'status' => 0,
                'message' => 'Nomor whatsapp sudah pernah terdaftar'
            ]);
        }

        $role = Role::where('name', $request->role)->first();

        //create users
        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'whatsapp' => $request->wa,
            'password' => $request->password
        ]);
        $user->syncRoles($role->name);

        $otp = generateOtp();
        $user->update([
            'otp' => $otp,
            // 'otp_created_at' => now()
        ]);
        // dd($userWa);
        sendWa($user->whatsapp, 'Lanjutkan pendaftaran dengan memasukkan Kode OTP berikut : *' . $otp . '*');

        session(['email_registered' => $request->email]);
        // dd(session('email_registered'));

        return response()->json([
            'status' => 1,
            'message' => 'Email dan nomor Whatsapp dapat digunakan',
            'data' => $user
        ]);
    }

    public function cek_awal_otp(Request $request)
    {

        $cek = User::where([
            ['email', '=', $request->email_registered],
            ['otp', '=', $request->otp]
        ])->first();

        if (!$cek) {
            return response()->json([
                'status' => 0,
                'message' => 'Kode OTP salah'
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Verifikasi kode OTP berhasil',
            'session_email' => session('email_registered')
        ]);
    }

    public function akhir_daftar_akun(Request $request)
    {

        $imel = session('email_registered');
        $user = User::where('email', $imel)->first();

        // dd($user->id);

        DB::beginTransaction();
        try {
            // create affiliator
            UserPencari::create([
                'user_id' => $user->id,
                'ktp' => $request->nik,
                'name' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'gender' => $request->gender_id,
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
                'foto' => null,
                'status_id' => 1,
                'is_alumni_bkk' => 0,
                'bkk_id' => null,
                'toket' => null,
                'disabilitas' => null,
                'jenis_disabilitas' => null,
                'keterangan_disabilitas' => null,
                'posted_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s'),
                // 'updated_at',
                // 'deleted_at',
                'is_diterima' => 0,
                'medsos' => $request->medsos,
                'status_saat_ini' => $request->status_saat_ini,
                'sektor_pekerjaan_saat_ini' => $request->status_saat_ini === '1' ? $request->sektor_pekerjaan_saat_ini : null,
                'jam_kerja' => $request->status_saat_ini === '1' ? $request->jam_kerja : null,
                'gaji' => $request->status_saat_ini === '1' ? $request->gaji : null,
            ]);

            DB::commit();

            return redirect()->to('login')->with('success', 'Berhasil membuat akun silahkan login');
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
    }

    public function akhir_daftar_akun_perush(Request $request)
    {
        $imel = session('email_registered');
        $user = User::where('email', $imel)->first();

        // dd($user->id);

        DB::beginTransaction();
        try {
            // create affiliator
            UserPenyedia::create([
                'user_id' => $user->id,
                'name' => $request->nama_perusahaan,
                'luar_negri' => $request->luar_negri,
                'deskripsi' => $request->deskripsi,
                'jenis_perusahaan' => $request->jenis_perusahaan,
                'nomor_sip3mi' => null,
                'nib' => $request->nib,
                'id_sektor' => $request->sektor_id,
                'id_provinsi' => $request->provinsi_id,
                'id_kota' => $request->kabkota_id,
                'id_kecamatan' => $request->kecamatan_id,
                'id_desa' => $request->desa_id,
                'alamat' => $request->alamat,
                'kodepos' => $request->kodepos,
                'telpon' => $request->telpon,
                'jabatan' => $request->jabatan,
                'website' => $request->website,
                'status_id' => 1,
                'foto' => null,
                'shared_by_id' => null,
                'posted_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s'),
                // 'updated_at',
                // 'deleted_at',
            ]);

            DB::commit();

            return redirect()->to('login')->with('success', 'Berhasil membuat akun perusahaan silahkan login');
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
    }

    public function akhir_daftar_akun_bkk(Request $request)
    {
        $imel = session('email_registered');
        $user = User::where('email', $imel)->first();

        // dd($user->id);

        DB::beginTransaction();
        try {
            // create affiliator
            UserBkk::create([
                'user_id' => $user->id,
                'name' => $request->nama_bkk,
                'luar_negri' => $request->luar_negri,
                'deskripsi' => $request->deskripsi,
                'jenis_bkk' => $request->jenis_bkk,
                'nomor_sip3mi' => null,
                'nib' => $request->nib,
                'id_sektor' => $request->sektor_id,
                'id_provinsi' => $request->provinsi_id,
                'id_kota' => $request->kabkota_id,
                'id_kecamatan' => $request->kecamatan_id,
                'id_desa' => $request->desa_id,
                'alamat' => $request->alamat,
                'kodepos' => $request->kodepos,
                'telpon' => $request->telpon,
                'jabatan' => $request->jabatan,
                'website' => $request->website,
                'status_id' => 1,
                'foto' => null,
                'shared_by_id' => null,
                'posted_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s'),
                // 'updated_at',
                // 'deleted_at',
            ]);

            DB::commit();

            return redirect()->to('login')->with('success', 'Berhasil membuat akun bkk silahkan login');
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
    }

    public function akhir_daftar_akun_blk(Request $request)
    {
        $imel = session('email_registered');
        $user = User::where('email', $imel)->first();

        // dd($user->id);

        DB::beginTransaction();
        try {
            // create affiliator
            UserBlk::create([
                'user_id' => $user->id,
                'name' => $request->nama_blk,
                'id_provinsi' => $request->provinsi_id,
                'id_kota' => $request->kabkota_id,
                'id_kecamatan' => $request->kecamatan_id,
                'id_desa' => $request->desa_id,
                'alamat' => $request->alamat,
                'kodepos' => $request->kodepos,
                'telpon' => $request->telpon,
                'pic' => $request->pic,
                'jabatan' => $request->jabatan,
                'website' => $request->website,
                'status_id' => 1,
                'foto' => null,
                'posted_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s'),
                'no_izin_pendirian' => $request->no_izin_pendirian, // No. Izin Pendirian
                'waktu_pendirian' => $request->waktu_pendirian, // Waktu Pendirian
                'nomor_vin' => $request->nomor_vin, // Nomor VIN
                'nomor_induk_berusaha' => $request->nomor_induk_berusaha, // Nomor Induk Berusaha (NIB)
                'nomor_akreditasi_lembaga' => $request->nomor_akreditasi_lembaga, // Nomor Akreditasi Lembaga
                'berlaku_sampai' => $request->berlaku_sampai, // Berlaku Sampai
                'jenis_pelatihan' => $request->jenis_pelatihan, // Jenis Pelatihan
                'kapasitas_peserta_per_pelatihan' => $request->kapasitas_peserta_per_pelatihan, // Kapasitas Peserta Per Pelatihan
                'jumlah_lulusan_sampai_sekarang' => $request->jumlah_lulusan_sampai_sekarang, // Jumlah Lulusan Sampai Sekarang
                'jumlah_peserta_lulus_uji_kompetensi' => $request->jumlah_peserta_lulus_uji_kompetensi, // Jumlah Peserta Lulus Uji Kompetensi
                'jumlah_instruktur' => $request->jumlah_instruktur, // Jumlah Instruktur
                'jumlah_instruktur_bersertifikat_kompetensi' => $request->jumlah_instruktur_bersertifikat_kompetensi, // Jumlah Instruktur Bersertifikat Kompetensi
                // 'updated_at',
                // 'deleted_at',
            ]);

            DB::commit();

            return redirect()->to('login')->with('success', 'Berhasil membuat akun blk silahkan login');
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
    }

    public function getKabkotaByProv($prov_id)
    {
        $kabkota = DB::table('naker_kabkota')->where('province_id', $prov_id)->get();

        return response()->json($kabkota);
    }

    public function getKecamatanByKabkota($kabkota_id)
    {
        // Misal mengambil data dari tabel 'naker_kecamatan' berdasarkan kabkota_id
        $kecamatan = DB::table('naker_kecamatan')->where('regency_id', $kabkota_id)->get();

        return response()->json($kecamatan);
    }

    public function getDesaByKec($kec_id)
    {
        $desa = DB::table('naker_desa')->where('district_id', $kec_id)->get();

        return response()->json($desa);
    }

    public function getJurusanByPendidikan($pendidikan_id)
    {
        $pendidikan = DB::table('naker_jurusan')->where('id_pendidikans', $pendidikan_id)->get();

        return response()->json($pendidikan);
    }
}
