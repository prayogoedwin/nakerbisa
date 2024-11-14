<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepanController extends Controller
{
    //
    //index
    public function index()
    {
        return view('depan.depan_index');
    }

    public function bkk(){
        return view('depan.depan_bkk');
    }

    public function login(){
        return view('depan.depan_login');
    }

    public function register(){
        return view('depan.depan_register');
    }

    public function lowongan_kerja(){
        return view('depan.depan_lowongan_kerja');
    }
    
    public function lowongan_kerja_disabilitas(){
        return view('depan.depan_lowongan_kerja_disabilitas');
    }

    public function lowongan_kerja_ema(){
        return view('depan.depan_lowongan_kerja_ema');
    }

    public function lowongan_kerja_krr(){
        return view('depan.depan_lowongan_kerja_krr');
    }
    public function infografis(){
        return view('depan.depan_infografis');
    }

    public function galeri(){
        return view('depan.depan_galeri');
    }

    public function berita(){
        return view('depan.depan_berita');
    }


    public function daftar(Request $request){
        return view('depan.depan_registerbaru');
    }
}
