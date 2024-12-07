<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBlk;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserBlkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blks = UserBlk::with([
                'user:id,name,email,whatsapp',
                'user.roles:id,name' // Ambil data role terkait dengan kolom tertentu
            ]) // Ambil data admin dengan user terkait
                ->select('id', 'user_id');

            return DataTables::of($blks)
                ->addIndexColumn()
                ->addColumn('user_name', function ($blk) {
                    return $blk->user ? $blk->user->name : 'N/A';
                })
                ->addColumn('email', function ($blk) {
                    return $blk->user ? $blk->user->email : 'N/A';
                })
                ->addColumn('whatsapp', function ($blk) {
                    return $blk->user ? $blk->user->whatsapp : 'N/A';
                })
                // ->addColumn('roles', function ($blk) {
                //     // Menampilkan nama role
                //     if ($blk->user && $blk->user->roles->isNotEmpty()) {
                //         return $blk->user->roles->pluck('name')->join(', ');
                //     }
                //     return 'N/A'; // Jika tidak ada role
                // })
                ->addColumn('options', function ($blk) {
                    // return '
                    //     <button class="btn btn-warning btn-sm" onclick="resetPassword(' . $blk->id . ')">Reset Password</button>
                    //     <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $blk->id . ')">Edit</button>
                    //     <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $blk->id . ')">Delete</button>
                    // ';
                    return '
                    <button class="btn btn-warning btn-sm" onclick="confirmReset(' . $blk->id . ')">Reset Password</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $blk->id . ')">Delete</button>
                ';
                })
                ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                ->make(true);
        }

        return view('backend.users.blk.index');
    }


    public function softdelete($id)
    {
        try {
            // Cari admin berdasarkan ID
            $admin = UserBlk::findOrFail($id);
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
            $admin = UserBlk::findOrFail($id);
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
