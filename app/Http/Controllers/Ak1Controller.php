<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Ak1Controller extends Controller
{
    //
    public function cetakBaru()
    {
        return view('backend.ak1.create'); // Halaman untuk input user baru
    }

    public function cetakExisting()
    {
        return view('backend.ak1.existing'); // Halaman untuk cetak dari user yang sudah ada
    }
}
