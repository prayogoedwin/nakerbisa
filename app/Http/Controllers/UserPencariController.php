<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPencari;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserPencariController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pencaris = UserPencari::with([
                'user:id,name,email,whatsapp',
                'user.roles:id,name' // Ambil data role terkait dengan kolom tertentu
            ]) // Ambil data admin dengan user terkait
                ->select('id', 'user_id');

            return DataTables::of($pencaris)
                ->addIndexColumn()
                ->addColumn('user_name', function ($pencari) {
                    return $pencari->user ? $pencari->user->name : 'N/A';
                })
                ->addColumn('email', function ($pencari) {
                    return $pencari->user ? $pencari->user->email : 'N/A';
                })
                ->addColumn('whatsapp', function ($pencari) {
                    return $pencari->user ? $pencari->user->whatsapp : 'N/A';
                })
                // ->addColumn('roles', function ($pencari) {
                //     // Menampilkan nama role
                //     if ($pencari->user && $pencari->user->roles->isNotEmpty()) {
                //         return $pencari->user->roles->pluck('name')->join(', ');
                //     }
                //     return 'N/A'; // Jika tidak ada role
                // })
                ->addColumn('options', function ($pencari) {
                    return '
                    <button class="btn btn-info btn-sm" onclick="showEditModal(' . $pencari->id . ')">Edit Akun</button>
                    <a class="btn btn-primary btn-sm" href="' . route('data.pencari.edit', $pencari->id) . '">Edit Profil</a>
                    <button class="btn btn-warning btn-sm" onclick="confirmReset(' . $pencari->id . ')">Reset Password</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $pencari->id . ')">Delete</button>
                ';
                })
                ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                ->make(true);
        }

        return view('backend.users.pencari.index');
    }

    public function gagal_daftar(Request $request)
    {
        if ($request->ajax()) {
            // Membuat query sesuai SQL yang diberikan
            $pencaris = User::select('users.id', 'users.email', 'users.whatsapp', 'mhr.role_id')
                ->leftJoin('users_pencari as up', 'users.id', '=', 'up.user_id')
                ->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
                ->whereNull('up.user_id')
                ->where('mhr.role_id', 4);

            return DataTables::of($pencaris)
                ->addIndexColumn()
                ->addColumn('whatsapp', function ($pencari) {
                    return $pencari->whatsapp ?? 'N/A'; // Asumsi 'name' ada di tabel 'users'
                })
                ->addColumn('email', function ($pencari) {
                    return $pencari->email ?? 'N/A';
                })
                ->addColumn('role_id', function ($pencari) {
                    return $pencari->role_id ?? 'N/A';
                })
                ->addColumn('options', function ($pencari) {
                    return '
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $pencari->id . ')">Delete</button>
                    ';
                })
                ->rawColumns(['options'])  // Pastikan menambahkan ini untuk kolom options
                ->make(true);
        }

        return view('backend.users.pencari.gagal');
    }

    public function getData($id)
    {
        try {
            $pencari = UserPencari::with('user:id,name,email,whatsapp')
                ->select('id', 'user_id')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $pencari->id,
                    'user_id' => $pencari->user_id,
                    'name' => $pencari->user->name ?? '',
                    'email' => $pencari->user->email ?? '',
                    'whatsapp' => $pencari->user->whatsapp ?? '',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function updateAkun(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'whatsapp' => 'required|string|max:255',
            ]);

            $pencari = UserPencari::select('id', 'user_id')->findOrFail($id);
            $user = User::findOrFail($pencari->user_id);

            $emailDipakaiUserLain = User::where('email', $validatedData['email'])
                ->where('id', '!=', $user->id)
                ->exists();
            if ($emailDipakaiUserLain) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah dipakai akun lain, tidak bisa update.',
                ]);
            }

            $waDipakaiUserLain = User::where('whatsapp', $validatedData['whatsapp'])
                ->where('id', '!=', $user->id)
                ->exists();
            if ($waDipakaiUserLain) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor WhatsApp sudah dipakai akun lain, tidak bisa update.',
                ]);
            }

            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'whatsapp' => $validatedData['whatsapp'],
            ]);

            return response()->json(['success' => true, 'message' => 'Update akun berhasil']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function softdelete($id)
    {
        try {
            // Cari admin berdasarkan ID
            $admin = UserPencari::findOrFail($id);
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

    public function forcedelete($id)
    {
        try {
            // Cari UserPencari berdasarkan ID
            $admin = User::findOrFail($id);

            // Hapus user terkait secara permanen
            $user = User::find($admin->user_id); // Sesuaikan relasi jika ada
            if ($user) {
                $user->forceDelete(); // Hapus user secara permanen
            }

            // Hapus admin terkait secara permanen
            $admin->forceDelete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function reset($id)
    {
        try {
            $admin = UserPencari::findOrFail($id);
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
