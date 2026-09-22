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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

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

        // Generate cache key yang unik berdasarkan parameter pencarian dan nomor halaman
        $page = $request->input('page', 1);
        $cacheKey = 'lowongan_kerja_' . md5("{$judulLowongan}_{$pendidikanId}_{$lokasiId}_{$page}");

        // Query pencarian berdasarkan parameter, dicache selama 2 menit (120 detik)
        $lowonganDisetujui = cache()->remember($cacheKey, 120, function () use ($judulLowongan, $pendidikanId, $lokasiId) {
            return Lowongan::select(
                'naker_lowongan.*',
                'users_penyedia.name as perusahaan_name',
                'users_penyedia.foto as perusahaan_foto',
                'users_penyedia.alamat as perusahaan_alamat',
                'naker_kecamatan.name as perusahaan_kecamatan',
                'naker_kabkota.name as perusahaan_kabupaten'
            )
                ->join('users_penyedia', 'naker_lowongan.posted_by', '=', 'users_penyedia.user_id')
                ->leftJoin('naker_kecamatan', 'users_penyedia.id_kecamatan', '=', 'naker_kecamatan.id')
                ->leftJoin('naker_kabkota', 'users_penyedia.id_kota', '=', 'naker_kabkota.id')
                ->where('naker_lowongan.status_id', 1) // Lowongan yang disetujui
                ->when($judulLowongan, function ($query, $judulLowongan) {
                    return $query->where('judul_lowongan', 'like', '%'.$judulLowongan.'%');
                })
                ->when($pendidikanId, function ($query, $pendidikanId) {
                    return $query->where('pendidikan_id', $pendidikanId);
                })
                ->when($lokasiId, function ($query, $lokasiId) {
                    return $query->where('kabkota_id', $lokasiId);
                })
                ->orderBy('tanggal_start', 'desc')
                ->paginate(9)
                ->withQueryString();
        });

        // Kirim data hasil pencarian ke view
        return view('depan.depan_lowongan_kerja', compact('lowonganDisetujui'));
    }

    public function lowongan_kerja_json(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Kunci cache dibedakan berdasarkan page dan per_page
        $cacheKey = 'lowongan_kerja_json_' . md5("{$perPage}_{$page}");

        // Query dan transformasi disalin ke dalam cache dengan durasi 4 menit (240 detik)
        $lowongan = cache()->remember($cacheKey, 240, function () use ($perPage) {
            $data = Lowongan::select(
                'naker_lowongan.*',
                'users_penyedia.name as perusahaan_name',
                'users_penyedia.foto as perusahaan_foto',
                'users_penyedia.alamat as perusahaan_alamat',
                'naker_kecamatan.name as perusahaan_kecamatan',
                'naker_kabkota.name as perusahaan_kabupaten'
            )
                ->join('users_penyedia', 'naker_lowongan.posted_by', '=', 'users_penyedia.user_id')
                ->leftJoin('naker_kecamatan', 'users_penyedia.id_kecamatan', '=', 'naker_kecamatan.id')
                ->leftJoin('naker_kabkota', 'users_penyedia.id_kota', '=', 'naker_kabkota.id')
                ->where('naker_lowongan.status_id', 1) // Lowongan yang disetujui
                ->where('naker_lowongan.tanggal_end', '>=', now()->toDateString())
                ->orderBy('naker_lowongan.tanggal_start', 'desc')
                ->paginate($perPage);

            // Tambahkan full URL prefix pada field perusahaan_foto
            $data->getCollection()->transform(function ($item) {
                if (!empty($item->perusahaan_foto)) {
                    $fotoPath = ltrim($item->perusahaan_foto, '/');
                    $item->perusahaan_foto = 'https://nakerbisa.rembangkab.go.id/storage/' . $fotoPath;
                }
                return $item;
            });

            return $data;
        });

        return response()->json([
            'status' => true,
            'message' => 'success, berhasil get data',
            'page' => $lowongan->currentPage(),
            'per_page' => $lowongan->perPage(),
            'total' => $lowongan->total(),
            'total_pages' => $lowongan->lastPage(),
            'data' => $lowongan->items()
        ]);
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
        $vacancies = [];

        // Fetch the data from the external API
        $response = Http::acceptJson()
            ->timeout(20)
            ->get('https://bursakerja.jatengprov.go.id/api/lowongan/index');

        // Check if the response is successful
        if ($response->successful()) {
            $payload = $response->json();

            if (is_array($payload)) {
                // Handle different response structures safely.
                $vacancies = data_get($payload, 'data', []);

                if (is_array($vacancies) && isset($vacancies['data']) && is_array($vacancies['data'])) {
                    $vacancies = $vacancies['data'];
                } elseif (! is_array($vacancies)) {
                    $vacancies = data_get($payload, 'lowongan', []);
                }

                if (! is_array($vacancies)) {
                    $vacancies = [];
                }

                // Normalize a single vacancy object into a list for the view loop.
                if (! empty($vacancies) && isset($vacancies['judul'])) {
                    $vacancies = [$vacancies];
                }
            } else {
                Log::warning('EMA vacancies API returned non-JSON payload', [
                    'status' => $response->status(),
                    'body_preview' => mb_substr($response->body(), 0, 500),
                ]);
            }
        } else {
            Log::warning('EMA vacancies API request failed', [
                'status' => $response->status(),
                'body_preview' => mb_substr($response->body(), 0, 500),
            ]);
        }

        return view('depan.depan_lowongan_kerja_ema', compact('vacancies'));
    }

    public function lowongan_kerja_ayokerjo()
    {
        return view('depan.depan_lowongan_kerja_ayokerjo');
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

        return redirect()->route('depan.daftar.role', ['role' => $request->role_dipilih]);
    }

    public function daftar(Request $request)
    {
        $role = $request->input('rl'); // backward compatibility
        if (! in_array($role, ['tenaga-kerja', 'penyedia-kerja', 'admin-bkk', 'admin-blk'])) {
            return abort(404);
        }

        return $this->renderDaftarByRole($role);
    }

    public function daftarByRole(string $role)
    {
        if (! in_array($role, ['tenaga-kerja', 'penyedia-kerja', 'admin-bkk', 'admin-blk'])) {
            return abort(404);
        }

        return $this->renderDaftarByRole($role);
    }

    public function cek_awal_akun(Request $request)
    {
        // return response()->json([
        //     'email' => $request->email,
        //     'wa' => $request->wa,
        // ]);

        $userEmail = User::where('email', $request->email)->first();
        $userWa = User::where('whatsapp', $request->wa)->first();

        if ($userEmail && $userWa && $userEmail->id !== $userWa->id) {
            return response()->json([
                'status' => 0,
                'message' => 'Email dan nomor WhatsApp sudah digunakan oleh akun berbeda',
            ]);
        }

        $role = Role::where('name', $request->role)->first();
        $existingUser = $userEmail ?: $userWa;

        if ($existingUser) {
            if ($this->hasCompletedProfileByRole($existingUser->id, $request->role)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Akun dengan Email/WhatsApp ini sudah terdaftar lengkap. Silakan login.',
                ]);
            }

            // Akun lama belum punya profil sesuai role: lanjutkan pendaftaran dari step berikutnya.
            $existingUser->update([
                'name' => $request->email,
                'email' => $request->email,
                'whatsapp' => $request->wa,
                'password' => $request->password,
                'otp' => null,
            ]);
            $existingUser->syncRoles($role->name);
            $user = $existingUser;
        } else {
            // create users baru jika memang belum ada
            $user = User::create([
                'name' => $request->email,
                'email' => $request->email,
                'whatsapp' => $request->wa,
                'password' => $request->password,
            ]);
            $user->syncRoles($role->name);
            $user->update(['otp' => null]);
        }

        session(['email_registered' => $request->email]);
        // dd(session('email_registered'));

        return response()->json([
            'status' => 1,
            'message' => 'Email dan nomor Whatsapp dapat digunakan, lanjutkan pendaftaran',
            'data' => $user,
        ]);
    }

    private function hasCompletedProfileByRole(int $userId, string $role): bool
    {
        return match ($role) {
            'tenaga-kerja' => UserPencari::where('user_id', $userId)->whereNull('deleted_at')->exists(),
            'penyedia-kerja' => UserPenyedia::where('user_id', $userId)->whereNull('deleted_at')->exists(),
            'admin-bkk' => UserBkk::where('user_id', $userId)->whereNull('deleted_at')->exists(),
            'admin-blk' => UserBlk::where('user_id', $userId)->whereNull('deleted_at')->exists(),
            default => true,
        };
    }

    public function cek_awal_otp(Request $request)
    {

        // $cek = User::where([
        //     ['email', '=', $request->email_registered],
        //     ['otp', '=', $request->otp]
        // ])->first();

        // if (!$cek) {
        //     return response()->json([
        //         'status' => 0,
        //         'message' => 'Kode OTP salah'
        //     ]);
        // }

        return response()->json([
            'status' => 1,
            'message' => 'Verifikasi kode OTP berhasil',
            'session_email' => session('email_registered'),
        ]);
    }

    public function storeKlikSipet(Request $request)
    {
        $source = Auth::check() ? 'dari_web_admin' : 'dari_web_publik';

        DB::table('klik_sipet')->insert([
            'nama' => $source,
            'wa' => $source,
            'judu' => $source,
            'isi' => $source,
            'created_at' => now(),
            'created_by' => Auth::id(),
            'created_by_ip' => $request->ip(),
        ]);

        $waNumber = '6282225567996';
        $message = 'Halo admin nakerbisa, saya dari web mau tanya tentang .....';
        $encodedMessage = rawurlencode($message);

        $isMobile = preg_match('/android|iphone|ipad|ipod/i', strtolower($request->userAgent() ?? '')) === 1;
        $whatsappUrl = $isMobile
            ? "https://wa.me/{$waNumber}?text={$encodedMessage}"
            : "https://web.whatsapp.com/send?phone={$waNumber}&text={$encodedMessage}";

        return redirect()->away($whatsappUrl);
    }

    public function akhir_daftar_akun(Request $request)
    {

        $imel = session('email_registered');
        $user = User::where('email', $imel)->first();

        $nikSudahTerpakai = UserPencari::where('ktp', $request->nik)
            ->whereNull('deleted_at')
            ->exists();

        if ($nikSudahTerpakai) {
            return back()
                ->withInput()
                ->withErrors(['nik' => 'NIK sudah terdaftar dan masih aktif. Silakan gunakan NIK lain.']);
        }

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
                'id_pendidikan' => $request->pendidikan_id ?? 0,
                'id_jurusan' => $request->jurusan_id ?? 0,
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
                'message' => $th->getMessage(),
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
                'message' => $th->getMessage(),
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
                'message' => $th->getMessage(),
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
                'message' => $th->getMessage(),
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

    private function renderDaftarByRole(string $role)
    {
        $resumeRegistration = session('resume_registration');

        $depanModel = new Depan;
        $data['agama'] = $depanModel->getAllAgama();
        $data['kabkota'] = $depanModel->getKabkotaByProvince();
        $data['dt'] = [
            'role' => $role,
            'role_name' => $this->resolveRoleName($role),
        ];
        $data['prefill'] = [
            'email' => '',
            'whatsapp' => '',
        ];

        if (is_array($resumeRegistration) && ($resumeRegistration['role'] ?? null) === $role) {
            $data['prefill']['email'] = $resumeRegistration['email'] ?? '';
            $data['prefill']['whatsapp'] = $resumeRegistration['whatsapp'] ?? '';
        }

        session()->forget('email_registered');

        return view('depan.depan_registerbaru', $data);
    }

    private function resolveRoleName(string $role): string
    {
        return match ($role) {
            'tenaga-kerja' => 'Tenaga Kerja',
            'penyedia-kerja' => 'Penyedia Kerja',
            'admin-bkk' => 'BKK',
            'admin-blk' => 'BLK',
            default => '-',
        };
    }
}
