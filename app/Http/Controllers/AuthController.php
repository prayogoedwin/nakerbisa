<?php

namespace App\Http\Controllers;

use App\Models\UserBkk;
use App\Models\UserBlk;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // buat file auth/login.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha', // Validasi captcha
        ]);

        // Jika validasi captcha dan kredensial login berhasil
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $roleName = $user->roles[0]['name'] ?? null;

            // Jika pendaftaran role belum lengkap, jangan izinkan login ke dashboard.
            if ($roleName && !$this->hasCompletedProfileByRole($user->id, $roleName)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('depan.daftar.role', ['role' => $roleName])
                    ->with('resume_registration', [
                        'role' => $roleName,
                        'email' => $user->email,
                        'whatsapp' => $user->whatsapp,
                    ])
                    ->with('info', 'Data akun ditemukan. Silakan selesaikan proses pendaftaran terlebih dahulu.');
            }

            // Default redirection for other roles
            return redirect()->route('dashboard'); // Ganti dengan rute yang sesuai
        }

        return back()->withErrors(['login_error' => 'Invalid credentials or captcha']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
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
}
