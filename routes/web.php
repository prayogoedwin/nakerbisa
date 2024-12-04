<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Ak1Controller;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\LowonganAdminController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\LowonganPencariController;
use App\Http\Controllers\NakerBeritaController;
use App\Http\Controllers\NakerBeritaNewController;
use App\Http\Controllers\NakerFaqController;
use App\Http\Controllers\NakerGaleriController;
use App\Http\Controllers\NakerInfografisController;
use App\Http\Controllers\PencariKeahlianKeterampilanController;
use App\Http\Controllers\PencariKeterampilanController;
use App\Http\Controllers\PencariPendidikanController;
use App\Http\Controllers\PencariPengalamanController;
use App\Http\Controllers\PencariProfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPencariController;
use App\Http\Controllers\UserPenyediaController;

// Menggunakan controller DepanController untuk mengambil data FAQ
Route::get('/', [DepanController::class, 'index'])->name('beranda');
Route::get('/depan/bkk', [DepanController::class, 'bkk']);
Route::get('/depan/blk', [DepanController::class, 'blk']);
Route::get('/depan/talent-ketrampilan', [DepanController::class, 'talent_ketrampilan']);
Route::get('/depan/talent-pendidikan', [DepanController::class, 'talent_pendidikan']);
Route::get('/depan/talent-wilayah', [DepanController::class, 'talent_wilayah']);
Route::get('/depan/statistik', [DepanController::class, 'statistik']);
Route::get('/depan/login', [DepanController::class, 'login']);
Route::get('/depan/register', [DepanController::class, 'register']);
Route::get('/depan/galeri', [DepanController::class, 'galeri'])->name('galeri');
Route::get('depan/lowongan-kerja', [DepanController::class, 'lowongan_kerja'])->name('depan.lowongan-kerja');
Route::get('/depan/lowongan-kerja-disabilitas', [DepanController::class, 'lowongan_kerja_disabilitas'])->name('lowongan-kerja-disabilitas');
Route::get('/depan/lowongan-kerja-ema', [DepanController::class, 'lowongan_kerja_ema']);
Route::get('/depan/lowongan-kerja-krr', [DepanController::class, 'lowongan_kerja_krr']);
Route::get('/depan/infografis', [DepanController::class, 'infografis'])->name('infografis');
Route::get('/depan/berita', [DepanController::class, 'berita'])->name('berita');
Route::get('/depan/berita/{id}', [DepanController::class, 'show'])->name('berita.show');
Route::post('/depan/daftar-akun', [DepanController::class, 'daftar_akun'])->name('daftar-akun');
Route::get('/depan/daftar', [DepanController::class, 'daftar']); //with role
Route::post('/depan/cek-awal-akun', [DepanController::class, 'cek_awal_akun'])->name('cek-awal-akun');
Route::post('/depan/cek-awal-otp', [DepanController::class, 'cek_awal_otp'])->name('cek-awal-otp');

Route::get('/depan/getkecamatanbyid/{kabkota_id}', [DepanController::class, 'getKecamatanByKabkota'])->name('get-kecamatan-bykabkota');
Route::get('/depan/getdesabyid/{kec_id}', [DepanController::class, 'getDesaByKec'])->name('get-desa-bykecamatan');
Route::get('/depan/getjurusanbyid/{pendidikan_id}', [DepanController::class, 'getJurusanByPendidikan'])->name('get-jurusan-bypendidikan');


Route::post('/depan/akhir_daftar-akun', [DepanController::class, 'akhir_daftar_akun'])->name('akhir-daftar-akun');
Route::post('/depan/akhir_daftar-akun-perush', [DepanController::class, 'akhir_daftar_akun_perush'])->name('akhir-daftar-akun-perush');
Route::post('/depan/akhir_daftar-akun-bkk', [DepanController::class, 'akhir_daftar_akun_bkk'])->name('akhir-daftar-akun-bkk');
Route::post('/depan/akhir_daftar-akun-blk', [DepanController::class, 'akhir_daftar_akun_blk'])->name('akhir-daftar-akun-blk');

Route::get('/depan/getkabkotabyid/{prov_id}', [DepanController::class, 'getKabkotaByProv'])->name('get-kabkota-byprov');

Route::post('/back/daftar-akun', [Ak1Controller::class, 'daftar_akun'])->name('daftar-akun-ak1');
Route::get('/back/daftar', [Ak1Controller::class, 'daftar']); //with role
Route::post('/back/cek-awal-akun', [Ak1Controller::class, 'cek_awal_akun'])->name('cek-awal-akun-ak1');
Route::post('/back/cek-awal-otp', [Ak1Controller::class, 'cek_awal_otp'])->name('cek-awal-otp-ak1');

Route::post('/back/akhir_daftar-akun', [Ak1Controller::class, 'akhir_daftar_akun'])->name('akhir-daftar-akun-ak1');

Route::get('ak1/cek/{unik_kode}', [Ak1Controller::class, 'viewAk1'])->name('ak1.view');






// Route::get('/captcha', function () {
//     return response()->json(['captcha' => captcha_src()]);
// });


Route::get('/captcha', function () {
    // Menghasilkan gambar CAPTCHA baru
    $captcha = captcha_src(); // Mendapatkan URL gambar CAPTCHA
    return response()->json(['captcha' => $captcha]); // Mengembalikan URL gambar sebagai JSON
});

Route::prefix('dapur')->middleware('auth')->group(function () {

    //route untuk admin
    Route::get('/dashboard', [BackController::class, 'index'])->name('dashboard');
    Route::get('/sample', [BackController::class, 'sample'])->name('sample');

    Route::get('/statistik', [BackController::class, 'statistik'])->name('statistik');

    Route::prefix('setting')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

        Route::get('/faqs', [NakerFaqController::class, 'index'])->name('faq.index');
        Route::post('/faq/add', [NakerFaqController::class, 'store'])->name('faq.add');
        Route::get('/faq/get/{id}', [NakerFaqController::class, 'getData'])->name('faq.detail');
        Route::delete('/faq/delete/{id}', [NakerFaqController::class, 'softdelete'])->name('faq.softdelete');
        Route::put('/faq/update/{id}', [NakerFaqController::class, 'update'])->name('faq.update');

        Route::get('/infografis', [NakerInfografisController::class, 'index'])->name('infografis.index');
        Route::post('/infografis/add', [NakerInfografisController::class, 'store'])->name('infografis.add');
        Route::get('/infografis/{id}', [NakerInfografisController::class, 'edit'])->name('infografis.edit');
        Route::put('/infografis/update/{id}', [NakerInfografisController::class, 'update'])->name('infografis.update');
        Route::delete('/infografis/delete/{id}', [NakerInfografisController::class, 'destroy'])->name('infografis.destroy');

        Route::get('/galeri', [NakerGaleriController::class, 'index'])->name('galeri.index');
        Route::post('/galeri/add', [NakerGaleriController::class, 'store'])->name('galeri.add');
        Route::get('/galeri/{id}', [NakerGaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('/galeri/update/{id}', [NakerGaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/delete/{id}', [NakerGaleriController::class, 'destroy'])->name('galeri.destroy');

        Route::get('/berita', [NakerBeritaController::class, 'index'])->name('berita.index');
        Route::post('/berita/add', [NakerBeritaController::class, 'store'])->name('berita.add');
        Route::get('/berita/{id}/edit', [NakerBeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{id}', [NakerBeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/delete/{id}', [NakerBeritaController::class, 'destroy'])->name('berita.destroy');
    });

    Route::prefix('profil')->group(function () {
        Route::put('/admin/update-user/{id}', [ProfileController::class, 'updateUser'])->name('admin.update-user');
        Route::put('/admin/update-profil/{id}', [ProfileController::class, 'updateProfil'])->name('admin.update-profil');

        Route::get('/', [ProfileController::class, 'index'])->name('profil.index');

        Route::get('/cetak-cv', [ProfileController::class, 'cetakCV'])->name('cetak.cv');

        Route::get('/pendidikan', [PencariPendidikanController::class, 'index'])->name('pendidikan.index');
        Route::post('/pendidikan/add', [PencariPendidikanController::class, 'store'])->name('pendidikan.add');
        Route::get('/pendidikan/get/{id}', [PencariPendidikanController::class, 'getData'])->name('pendidikan.detail');
        Route::delete('/pendidikan/delete/{id}', [PencariPendidikanController::class, 'softdelete'])->name('pendidikan.softdelete');
        Route::put('/pendidikan/update/{id}', [PencariPendidikanController::class, 'update'])->name('pendidikan.update');

        Route::get('/pengalaman', [PencariPengalamanController::class, 'index'])->name('pengalaman.index');
        Route::post('/pengalaman/add', [PencariPengalamanController::class, 'store'])->name('pengalaman.add');
        Route::get('/pengalaman/{id}', [PencariPengalamanController::class, 'show'])->name('pengalaman.detail');
        Route::put('/pengalaman/update/{id}', [PencariPengalamanController::class, 'update'])->name('pengalaman.update');
        Route::delete('/pengalaman/delete/{id}', [PencariPengalamanController::class, 'softdelete'])->name('pengalaman.softdelete');

        Route::get('/keterampilan', [PencariKeterampilanController::class, 'index'])->name('keterampilan.index');
        Route::post('/keterampilan/add', [PencariKeterampilanController::class, 'store'])->name('keterampilan.add');
        Route::get('/keterampilan/{id}', [PencariKeterampilanController::class, 'show'])->name('keterampilan.detail');
        Route::put('/keterampilan/update/{id}', [PencariKeterampilanController::class, 'update'])->name('keterampilan.update');
        Route::delete('/keterampilan/delete/{id}', [PencariKeterampilanController::class, 'softdelete'])->name('keterampilan.softdelete');

        Route::get('/keahlian-keterampilan', [PencariKeahlianKeterampilanController::class, 'index'])->name('keahlian-keterampilan.index');
        Route::post('/keahlian-keterampilan/add', [PencariKeahlianKeterampilanController::class, 'store'])->name('keahlian-keterampilan.add');
        Route::get('/keahlian-keterampilan/{id}', [PencariKeahlianKeterampilanController::class, 'show'])->name('keahlian-keterampilan.detail');
        Route::put('/keahlian-keterampilan/update/{id}', [PencariKeahlianKeterampilanController::class, 'update'])->name('keahlian-keterampilan.update');
        Route::delete('/keahlian-keterampilan/delete/{id}', [PencariKeahlianKeterampilanController::class, 'softdelete'])->name('keahlian-keterampilan.softdelete');
    });

    Route::prefix('users')->group(function () {

        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/add', [AdminController::class, 'store'])->name('admin.add');
        Route::get('/admin/get/{id}', [AdminController::class, 'getAdmin'])->name('admin.detail');
        Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'softdelete'])->name('admin.softdelete');

        Route::get('/pencari', [UserPencariController::class, 'index'])->name('userpencari.index');
        Route::delete('/pencari/delete/{id}', [UserPencariController::class, 'softdelete'])->name('userpencari.softdelete');
        Route::put('/pencari/reset/{id}', [UserPencariController::class, 'reset'])->name('userpencari.reset');

        Route::get('/penyedia', [UserPenyediaController::class, 'index'])->name('userperush.index');
    });

    Route::prefix('ak1')->group(function () {
        Route::get('/existing', [Ak1Controller::class, 'cetakExisting'])->name('ak1.existing');

        Route::put('ak1/update/{id}', [Ak1Controller::class, 'updateUser'])->name('ak1.update');
        Route::get('ak1/print/{id}', [Ak1Controller::class, 'printAk1'])->name('ak1.print');
        Route::get('ak1/printTenagaKerja/{id}', [Ak1Controller::class, 'printAk1TenagaKerja'])->name('ak1.printTk');

        Route::get('/data', [Ak1Controller::class, 'dataAk1'])->name('ak1.data');
        Route::get('/data-ak1-tk', [Ak1Controller::class, 'dataAk1Tk'])->name('ak1.dataTk');
    });

    Route::prefix('data')->group(function () {
        Route::get('pencari', [DataController::class, 'pencari'])->name('data.pencari');
        Route::get('pencari/export', [DataController::class, 'export'])->name('data.pencari.export');
        Route::get('/pencari/edit/{id}', [DataController::class, 'edit'])->name('data.pencari.edit');
        Route::put('/pencari/edit/{id}', [DataController::class, 'updateDataPencari'])->name('data.pencari.update');

        Route::get('penyedia', [DataController::class, 'penyedia'])->name('data.penyedia');
        Route::get('penyedia/export', [DataController::class, 'export'])->name('data.penyedia.export');
        Route::get('/penyedia/edit/{id}', [DataController::class, 'editPenyedia'])->name('data.penyedia.edit');
        Route::put('/penyedia/edit/{id}', [DataController::class, 'updateDataPenyedia'])->name('data.penyedia.update');
    });

    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/{id}', [LowonganController::class, 'show'])->name('lowongan.detail');
    Route::put('/lowongan/update/{id}', [LowonganController::class, 'update'])->name('lowongan.update');
    Route::post('/lowongan/lamar/{id}', [LowonganController::class, 'lamar'])->name('lowongan.lamar');
    Route::get('/lowongan/pelamar/{id}', [LowonganController::class, 'pelamar'])->name('lowongan.pelamar');
    Route::post('/lowongan/add', [LowonganController::class, 'store'])->name('lowongan.add');
    Route::delete('/lowongan/delete/{id}', [LowonganController::class, 'softdelete'])->name('lowongan.softdelete');
});


Route::middleware('guest')->get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/act_login', [AuthController::class, 'login'])->name('login.action');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
