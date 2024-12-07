<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBkk;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserBkkController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bkks = UserBkk::with([
                'user:id,name,email,whatsapp',
                'user.roles:id,name' // Ambil data role terkait dengan kolom tertentu
            ]) // Ambil data admin dengan user terkait
                ->select('id', 'user_id');

            return DataTables::of($bkks)
                ->addIndexColumn()
                ->addColumn('user_name', function ($bkk) {
                    return $bkk->user ? $bkk->user->name : 'N/A';
                })
                ->addColumn('email', function ($bkk) {
                    return $bkk->user ? $bkk->user->email : 'N/A';
                })
                ->addColumn('whatsapp', function ($bkk) {
                    return $bkk->user ? $bkk->user->whatsapp : 'N/A';
                })
                // ->addColumn('roles', function ($bkk) {
                //     // Menampilkan nama role
                //     if ($bkk->user && $bkk->user->roles->isNotEmpty()) {
                //         return $bkk->user->roles->pluck('name')->join(', ');
                //     }
                //     return 'N/A'; // Jika tidak ada role
                // })
                ->addColumn('options', function ($bkk) {
                    // return '
                    //     <button class="btn btn-warning btn-sm" onclick="resetPassword(' . $bkk->id . ')">Reset Password</button>
                    //     <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $bkk->id . ')">Edit</button>
                    //     <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $bkk->id . ')">Delete</button>
                    // ';
                    return '
                    <button class="btn btn-warning btn-sm" onclick="confirmReset(' . $bkk->id . ')">Reset Password</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $bkk->id . ')">Delete</button>
                ';
                })
                ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                ->make(true);
        }

        return view('backend.users.bkk.index');
    }


    public function softdelete($id)
    {
        try {
            // Cari admin berdasarkan ID
            $admin = UserBkk::findOrFail($id);
            $admin->delete();

            // Soft delete juga user yang terkait dengan admin ini (misalnya, jika memiliki relasi)
            $user = User::where('id', $admin->user_id)->first();  // Sesuaikan relasi dengan tabel User jika ada
            if ($user) {
                // Set is_deleted = 1 untuk soft delete user
                $user->is_deleted = 1;
                $user->save();  // Simpan perubahan
                $user->delete();
            }

            return response()->json(['success' => true, 'message' => 'Hapus data berhasil']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function reset($id)
    {
        try {
            $admin = UserBkk::findOrFail($id);
            $user = User::findOrFail($admin->user_id);

            $user = $admin->user;  // Ambil user yang terkait dengan admin ini
            $user->update([
                'password' => bcrypt($user->email),
            ]);

            return response()->json(['success' => true, 'message' => 'Reset data berhasil']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
