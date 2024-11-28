<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Ak1Controller extends Controller
{
    //
    public function cetakBaru()
    {
        return view('backend.ak1.create'); // Halaman untuk input user baru
    }

    public function cetakExisting(Request $request)
    {
        $user = null;

        if ($request->has('ktp')) {
            $user = User::whereHas('pencari', function ($query) use ($request) {
                $query->where('ktp', $request->ktp);
            })->with('pencari')->first();
        }

        return view('backend.ak1.existing', compact('user'));
    }


    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name'])); // Update nama
        $user->pencari()->update($request->only(['alamat', 'tanggal_lahir'])); // Update data pencari kerja

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function printAk1($id)
    {
        $user = User::with('pencari')->findOrFail($id);

        // Generate and return AK1 print view
        return view('backend.ak1.print', compact('user'));
    }
}
