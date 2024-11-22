<?php

namespace App\Http\Controllers;

use App\Models\NakerBerita;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use Illuminate\Support\Facades\File;



class NakerBeritaController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = NakerBerita::select('id', 'name', 'cover', 'status');

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    return $data->status ? '1' : '0';
                })
                ->addColumn('options', function ($data) {
                    return '
                        <button class="btn btn-primary btn-sm" onclick="showEditModal(' . $data->id . ')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $data->id . ')">Delete</button>
                    ';
                })
                ->rawColumns(['options']) // Pastikan menambahkan ini untuk kolom options
                ->make(true);
        }

        return view('backend.setting.berita.index');
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'cover' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|boolean',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        // Mengelola file cover (file yang di-upload)
        $filePath = null;
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filePath = $file->store('berita', 'public');
        }

        // Mengelola deskripsi untuk mengganti base64 image dengan path file
        $description = $request->description;
        $dom = new DOMDocument();
        @$dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');

            // Jika gambar adalah base64
            if (strpos($src, 'data:image/') === 0) {
                // Decode base64 image
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);

                // Pastikan direktori upload ada
                $uploadPath = public_path('upload');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                // Generate nama file unik untuk gambar
                $image_name = '/upload/' . time() . $key . '.png';

                // Simpan gambar sebagai file
                file_put_contents(public_path($image_name), $data);

                // Ganti atribut src gambar dengan path file yang baru
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }

        // Simpan perubahan deskripsi setelah mengganti src gambar
        $description = $dom->saveHTML();

        // Simpan data ke dalam database
        NakerBerita::create([
            'name' => $request->name,
            'description' => $description,
            'cover' => $filePath,
            'status' => $request->status,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    { // Find the data by ID 
        $data = NakerBerita::findOrFail($id);
        // Return the data as JSON response
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        // Validate input 
        $validator = Validator::make(
            $request->all(),
            ['name' => 'required|string', 'description' => 'required|string', 'cover' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 'status' => 'required|boolean',]
        );
        // If validation fails 
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        // Find the existing data to update 
        $data = NakerBerita::findOrFail($id);
        // Handle file upload (if a new file is uploaded) 
        if ($request->hasFile('cover')) {
            // Delete the old file if it exists 
            if ($data->cover) {
                Storage::disk('public')->delete($data->cover);
            }
            // Store the new file 
            $file = $request->file('cover');
            $filePath = $file->store('berita', 'public');
        } else {
            // Keep the old file if no new cover is uploaded 
            $filePath = $data->cover;
        }
        // Handle description (base64 images handling, if any) 
        $description = $request->description;
        $dom = new DOMDocument();
        @$dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');
            // If image is base64 
            if (strpos($src, 'data:image/') === 0) {
                // Decode base64 image 
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                // Save the image to the upload directory 
                $uploadPath = public_path('upload');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
                // Generate a unique filename for the image 
                $image_name = '/upload/' . time() . $key . '.png';
                file_put_contents(public_path($image_name), $data);
                // Update the image src attribute with the new path
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }
        // Save the updated description
        $description = $dom->saveHTML();
        // Update the data in the database 
        $data->update(['name' => $request->name, 'description' => $description, 'cover' => $filePath, 'status' => $request->status, 'updated_by' => auth()->user()->id,]);
        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $data = NakerBerita::findOrFail($id);

        // Hapus file terkait jika ada
        if ($data->cover) {
            // Gunakan disk 'public' untuk menghapus file
            Storage::disk('public')->delete($data->cover);
        }

        // Hapus data dari database
        $data->delete();

        // Return response
        return response()->json(['success' => true, 'message' => 'Data dan file berhasil dihapus']);
    }
}
