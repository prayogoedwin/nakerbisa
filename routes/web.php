<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\NakerBeritaController;
use App\Http\Controllers\NakerBeritaNewController;
use App\Http\Controllers\NakerFaqController;
use App\Http\Controllers\NakerGaleriController;
use App\Http\Controllers\NakerInfografisController;

// Menggunakan controller DepanController untuk mengambil data FAQ
Route::get('/', [DepanController::class, 'index'])->name('beranda');
Route::get('/depan/bkk', [DepanController::class, 'bkk']);
Route::get('/depan/blk', [DepanController::class, 'blk']);
Route::get('/depan/login', [DepanController::class, 'login']);
Route::get('/depan/register', [DepanController::class, 'register']);
Route::get('/depan/galeri', [DepanController::class, 'galeri'])->name('galeri');
Route::get('/depan/lowongan-kerja', [DepanController::class, 'lowongan_kerja']);
Route::get('/depan/lowongan-kerja-disabilitas', [DepanController::class, 'lowongan_kerja_disabilitas'])->name('lowongan-kerja-disabilitas');
Route::get('/depan/lowongan-kerja-ema', [DepanController::class, 'lowongan_kerja_ema']);
Route::get('/depan/lowongan-kerja-krr', [DepanController::class, 'lowongan_kerja_krr']);
Route::get('/depan/infografis', [DepanController::class, 'infografis']);
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

    Route::prefix('users')->group(function () {

        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/add', [AdminController::class, 'store'])->name('admin.add');
        Route::get('/admin/get/{id}', [AdminController::class, 'getAdmin'])->name('admin.detail');
        Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'softdelete'])->name('admin.softdelete');
    });
});


Route::middleware('guest')->get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/act_login', [AuthController::class, 'login'])->name('login.action');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::name('setting')->prefix('setting')->group(function () {
//     Route::get('/banner', [BackController::class, 'settingBanner'])->name('banner');
//   });
