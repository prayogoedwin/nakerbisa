<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeterampilan;
use App\Models\NakerPencariPendidikan;
use App\Models\NakerPencariPengalaman;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function index(Request $request)
    {
        // Mengambil data pendidikan berdasarkan user_id
        $pendidikan = NakerPencariPendidikan::where('user_id', auth()->id())->get();

        // Mengambil data keterampilan berdasarkan user_id
        $keterampilan = NakerPencariKeterampilan::where('user_id', auth()->id())->get();

        // Mengambil data pengalaman kerja berdasarkan user_id
        $pengalaman = NakerPencariPengalaman::where('user_id', auth()->id())->get();

        // Mengirim data ke view
        return view('backend.profil.index', compact('pendidikan', 'keterampilan', 'pengalaman'));
    }

    public function cetakCV()
    {
        $user = auth()->user();

        // Muat relasi `pencari` untuk mendapatkan data lengkap
        $user->load('pencari');
        $pendidikan = NakerPencariPendidikan::where('user_id', $user->id)->get();
        $pengalaman = NakerPencariPengalaman::where('user_id', $user->id)->get();
        $keterampilan = NakerPencariKeterampilan::where('user_id', $user->id)->get();

        return view('backend.profil.cetak-cv', compact('user', 'pendidikan', 'pengalaman', 'keterampilan'));
    }
}
