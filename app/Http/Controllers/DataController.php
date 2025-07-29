<?php

namespace App\Http\Controllers;

use App\Models\NakerPencariKeahlianKeterampilan;
use App\Models\NakerPencariKeterampilan;
use App\Models\NakerPencariPendidikan;
use App\Models\NakerPencariPengalaman;
use App\Models\UserBkk;
use App\Models\UserBlk;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;  // Mengimpor DataTables
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    //
    public function pencari(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data users_pencari beserta nama wilayah
            $query = UserPencari::select([
                'users_pencari.id',
                'users_pencari.ktp',
                'users_pencari.name',
                'users_pencari.tempat_lahir',
                'users_pencari.tanggal_lahir',
                'users_pencari.gender',
                'users_pencari.alamat',
                'users_pencari.kodepos',
                'users_pencari.tahun_lulus',
                'users_pencari.medsos',
                'users_pencari.status_saat_ini',
                'users_pencari.sektor_pekerjaan_saat_ini',
                'users_pencari.jam_kerja',
                'users_pencari.gaji',
                'users_pencari.id_kota',
                'users_pencari.id_kecamatan',
                'users_pencari.id_desa',
                'users_pencari.id_pendidikan',
                'users_pencari.id_jurusan',
                'users_pencari.id_agama',
                'users_pencari.id_status_perkawinan',
                'users_pencari.created_at'
            ])
            ->leftJoin('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
            ->leftJoin('naker_jurusan', 'users_pencari.id_jurusan', '=', 'naker_jurusan.id')
            ;

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('users_pencari.name', 'like', "%{$search}%")
                                ->orWhere('users_pencari.ktp', 'like', "%{$search}%")
                                ->orWhere('naker_pendidikan.name', 'like', "%{$search}%") // bisa dicari via pendidikan
                                ->orWhere('naker_jurusan.nama', 'like', "%{$search}%")    // bisa dicari via jurusan
                                // ... tambahkan kolom lain yang ingin dicari ...
                                ;
                        });
                    }
                })
                ->addColumn('kota', function ($data) {
                    // Ambil nama kota berdasarkan id_kota
                    $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                    return $kota ?? 'Tidak Ditemukan';
                })
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->addColumn('desa', function ($data) {
                    // Ambil nama desa berdasarkan id_desa
                    $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                    return $desa ?? 'Tidak Ditemukan';
                })
                ->addColumn('sektor', function ($data) {
                    // Ambil nama sektor berdasarkan sektor_pekerjaan_saat_ini
                    $sektor = DB::table('naker_sektor')->where('id', $data->sektor_pekerjaan_saat_ini)->value('name');
                    return $sektor ?? '-';
                })
                ->addColumn('status', function ($data) {
                    // Ambil nama sektor berdasarkan status_saat_ini
                    $status = DB::table('status_kerja')->where('id', $data->status_saat_ini)->value('status');
                    return $status ?? '-';
                })
                ->addColumn('pendidikan', function ($data) {
                    // Ambil nama pendidikan berdasarkan id_pendidikan
                    $pendidikan = DB::table('naker_pendidikan')->where('id', $data->id_pendidikan)->value('name');
                    return $pendidikan ?? '-';
                })
                ->addColumn('jurusan', function ($data) {
                    // Ambil nama jurusan berdasarkan id_jurusan
                    $jurusan = DB::table('naker_jurusan')->where('id', $data->id_jurusan)->value('nama');
                    return $jurusan ?? '-';
                })
                ->addColumn('marital', function ($data) {
                    // Ambil nama marital berdasarkan id_status_perkawinan
                    $marital = DB::table('naker_marital')->where('id', $data->id_status_perkawinan)->value('name');
                    return $marital ?? '-';
                })
                ->addColumn('agama', function ($data) {
                    // Ambil nama agama berdasarkan id_agama
                    $agama = DB::table('naker_agama')->where('id', $data->id_agama)->value('name');
                    return $agama ?? '-';
                })
                ->addColumn('created_at', function ($data) {
                    if ($data->created_at) {
                        return date('d-m-Y', strtotime($data->created_at));
                    }
                    return '-';
                })
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '<a href="' . route('data.pencari.edit', $data->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.data-pencari.pencari');
    }

    public function edit($id)
    {
        $pencari = UserPencari::findOrFail($id);

        // Ambil data pendidikan berdasarkan user_id dari $pencari
        $pendidikan = NakerPencariPendidikan::select(
            'naker_pencari_pendidikan.*',
            'naker_pendidikan.name as pendidikan_name', // Nama Pendidikan
            'naker_jurusan.nama as jurusan_name'        // Nama Jurusan
        )
            ->join('naker_pendidikan', 'naker_pencari_pendidikan.pendidikan_id', '=', 'naker_pendidikan.id') // Join tabel pendidikan
            ->leftJoin('naker_jurusan', 'naker_pencari_pendidikan.jurusan_id', '=', 'naker_jurusan.id')      // Left join tabel jurusan
            ->where('naker_pencari_pendidikan.user_id', $pencari->user_id) // Menggunakan user_id dari $pencari
            ->get();

        // Ambil data keterampilan berdasarkan user_id dari $pencari
        $keterampilan = NakerPencariKeterampilan::where('user_id', $pencari->user_id)->get();

        // Ambil data keahlian berdasarkan user_id dari $pencari
        $keahlian = NakerPencariKeahlianKeterampilan::where('user_id', $pencari->user_id)->get();

        // Ambil data pengalaman kerja berdasarkan user_id dari $pencari
        $pengalaman = NakerPencariPengalaman::where('user_id', $pencari->user_id)->get();

        return view('backend.data-pencari.edit', compact('id', 'pencari', 'pendidikan', 'keterampilan', 'pengalaman', 'keahlian'));
    }

    public function softDeletePendidikan($id)
    {
        $pendidikan = NakerPencariPendidikan::findOrFail($id);
        $pendidikan->delete(); // Menggunakan Soft Delete
        return redirect()->back()->with('success', 'Data pendidikan berhasil dihapus.');
    }

    public function softDeletePengalaman($id)
    {
        $pengalaman = NakerPencariPengalaman::findOrFail($id);
        $pengalaman->delete(); // Menggunakan Soft Delete
        return redirect()->back()->with('success', 'Data pengalaman berhasil dihapus.');
    }

    public function softDeleteSertifikasi($id)
    {
        $keterampilan = NakerPencariKeterampilan::findOrFail($id);
        $keterampilan->delete(); // Menggunakan Soft Delete
        return redirect()->back()->with('success', 'Data keterampilan berhasil dihapus.');
    }

    public function updateDataPencari(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:100',
            'ktp' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'id_provinsi' => '64',
            'kabkota_id' => 'required|integer',
            'kecamatan_id' => 'required|integer',
            'desa_id' => 'required|string|max:10',
            'alamat' => 'required|string|max:200',
            'kodepos' => 'required|string|max:5',
            'pendidikan_id' => 'required|integer',
            'jurusan_id' => 'required|integer',
            'tahun_lulus' => 'required|integer',
            'status_perkawinan_id' => 'required',
            'agama_id' => 'required|integer',
            'medsos' => 'required|string|max:200',
            'status_kerja_id' => 'required|string|max:200',
            'sektor_pekerjaan_saat_ini' => 'nullable',
            'jam_kerja' => 'nullable',
            'gaji' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto
        ]);

        // Mengambil data UserPencari berdasarkan ID
        $pencari = UserPencari::findOrFail($id);

        // Jika ada foto baru yang di-upload
        if ($request->hasFile('foto')) {
            // Cek dan hapus foto lama jika ada
            if (!empty($pencari->foto) && Storage::disk('public')->exists($pencari->foto)) {
                Storage::disk('public')->delete($pencari->foto);
            }

            // Simpan foto baru
            $filePath = $request->file('foto')->store('profile_photos', 'public');
            $pencari->foto = $filePath;
        }

        // Update data UserPencari
        $pencari->update([
            'name' => $request->name,
            'ktp' => $request->ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'id_provinsi' => '64',
            'id_kota' => $request->kabkota_id,
            'id_kecamatan' => $request->kecamatan_id,
            'id_desa' => $request->desa_id,
            'alamat' => $request->alamat,
            'kodepos' => $request->kodepos,
            'id_pendidikan' => $request->pendidikan_id,
            'id_jurusan' => $request->jurusan_id,
            'tahun_lulus' => $request->tahun_lulus,
            'id_status_perkawinan' => $request->status_perkawinan_id,
            'id_agama' => $request->agama_id,
            'medsos' => $request->medsos,
            'status_saat_ini' => $request->status_kerja_id,
            'sektor_pekerjaan_saat_ini' => $request->status_kerja_id === '1' ? $request->sektor_pekerjaan_saat_ini : null,
            'jam_kerja' => $request->status_kerja_id === '1' ? $request->jam_kerja : null,
            'gaji' => $request->status_kerja_id === '1' ? $request->gaji : null,
        ]);

        // Redirect ke halaman profil setelah berhasil update
        return redirect()->route('data.pencari')->with('success', 'Data Pencari Kerja berhasil diperbarui.');
    }

    public function export_bak(Request $request)
    {
        $query = UserPencari::select([
            'id',
            'ktp',
            'name',
            'tempat_lahir',
            'tanggal_lahir',
            'gender',
            'alamat',
            'kodepos',
            'tahun_lulus',
            'medsos',
            'id_status_perkawinan',
            'id_agama',
            'id_pendidikan',
            'id_jurusan',
            'id_kota',
            'id_kecamatan',
            'id_desa',
            'status_saat_ini',
            'sektor_pekerjaan_saat_ini',
            'jam_kerja',
            'gaji',
            'created_at'
        ]);

        // Terapkan filter pencarian dari DataTables
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('ktp', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%")
                ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%")
                ->orWhere('kodepos', 'like', "%{$search}%")
                ->orWhere('tahun_lulus', 'like', "%{$search}%")
                ->orWhere('medsos', 'like', "%{$search}%")
                ->orWhere('id_status_perkawinan', 'like', "%{$search}%")
                ->orWhere('id_agama', 'like', "%{$search}%")
                ->orWhere('id_pendidikan', 'like', "%{$search}%")
                ->orWhere('id_jurusan', 'like', "%{$search}%")
                ->orWhere('id_kota', 'like', "%{$search}%")
                ->orWhere('id_kecamatan', 'like', "%{$search}%")
                ->orWhere('id_desa', 'like', "%{$search}%")
                ->orWhere('status_saat_ini', 'like', "%{$search}%")
                ->orWhere('sektor_pekerjaan_saat_ini', 'like', "%{$search}%")
                ->orWhere('jam_kerja', 'like', "%{$search}%")
                ->orWhere('gaji', 'like', "%{$search}%");
        }

        // Ambil data setelah difilter
        $pencariData = $query->get();

        $fileName = 'data_pencari.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Kolom-kolom yang akan diekspor ke CSV
        $columns = [
            'ID',
            'KTP',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Gender',
            'Alamat',
            'Kodepos',
            'Tahun Lulus',
            'Medsos',
            'Status Perkawinan',
            'Agama',
            'Pendidikan',
            'Jurusan',
            'Kota',
            'Kecamatan',
            'Desa',
            'Status Saat Ini',
            'Sektor Pekerjaan Saat Ini',
            'Jam Kerja',
            'Gaji',
            'Tanggal Input',
        ];

        // Callback untuk menulis data ke CSV
        $callback = function () use ($pencariData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis header CSV

            foreach ($pencariData as $data) {
                // Ambil nama wilayah untuk setiap kolom
                $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                $sektor = DB::table('naker_sektor')->where('id', $data->sektor_pekerjaan_saat_ini)->value('name');
                $status = DB::table('status_kerja')->where('id', $data->status_saat_ini)->value('status');
                $pendidikan = DB::table('naker_pendidikan')->where('id', $data->id_pendidikan)->value('name');
                $jurusan = DB::table('naker_jurusan')->where('id', $data->id_jurusan)->value('nama');
                $marital = DB::table('naker_marital')->where('id', $data->id_status_perkawinan)->value('name');
                $agama = DB::table('naker_agama')->where('id', $data->id_agama)->value('name');
                $created_at = date('d-m-Y', strtotime($data->created_at));

                // Tulis data ke CSV dengan nama wilayah
                fputcsv($file, [
                    $data->id,
                    $data->ktp,
                    $data->name,
                    $data->tempat_lahir,
                    $data->tanggal_lahir,
                    $data->gender,
                    $data->alamat,
                    $data->kodepos,
                    $data->tahun_lulus,
                    $data->medsos,
                    $marital,
                    $agama,
                    $pendidikan,
                    $jurusan,
                    $kota,
                    $kecamatan,
                    $desa,
                    $status,
                    $sektor,
                    $data->jam_kerja,
                    $data->gaji,
                    $created_at
                ]);
            }

            fclose($file);
        };

        // Mengirimkan file CSV ke browser
        return response()->stream($callback, 200, $headers);
    }

    public function export(Request $request)
{
    $query = UserPencari::query()
        ->leftJoin('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
        ->leftJoin('naker_jurusan', 'users_pencari.id_jurusan', '=', 'naker_jurusan.id')
        // Join tabel lainnya yang diperlukan untuk pencarian
        ->select([
            'users_pencari.*',
            'naker_pendidikan.name as pendidikan_name',
            'naker_jurusan.nama as jurusan_name',
            // Kolom join lainnya
        ]);

    // Terapkan filter pencarian jika ada
    if ($request->has('search.value') && !empty($request->search['value'])) {
        $search = $request->search['value'];
        $query->where(function($q) use ($search) {
            $q->where('users_pencari.name', 'like', "%{$search}%")
                ->orWhere('users_pencari.ktp', 'like', "%{$search}%")
                ->orWhere('users_pencari.alamat', 'like', "%{$search}%")
                ->orWhere('naker_pendidikan.name', 'like', "%{$search}%")
                ->orWhere('naker_jurusan.nama', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%")
                ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%")
                ->orWhere('kodepos', 'like', "%{$search}%")
                ->orWhere('tahun_lulus', 'like', "%{$search}%")
                ->orWhere('medsos', 'like', "%{$search}%")
                ->orWhere('id_status_perkawinan', 'like', "%{$search}%")
                ->orWhere('id_agama', 'like', "%{$search}%")
                ->orWhere('id_pendidikan', 'like', "%{$search}%")
                ->orWhere('id_jurusan', 'like', "%{$search}%")
                ->orWhere('id_kota', 'like', "%{$search}%")
                ->orWhere('id_kecamatan', 'like', "%{$search}%")
                ->orWhere('id_desa', 'like', "%{$search}%")
                ->orWhere('status_saat_ini', 'like', "%{$search}%")
                ->orWhere('sektor_pekerjaan_saat_ini', 'like', "%{$search}%")
                ->orWhere('jam_kerja', 'like', "%{$search}%")
                ->orWhere('gaji', 'like', "%{$search}%");
                // Tambahkan kondisi pencarian lainnya
        });
    }

    $pencariData = $query->get();

    $fileName = 'data_pencari_'.date('YmdHis').'.csv';
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
    ];

    $columns = [
        'ID', 'KTP', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Gender',
        'Alamat', 'Kodepos', 'Tahun Lulus', 'Medsos', 'Status Perkawinan',
        'Agama', 'Pendidikan', 'Jurusan', 'Kota', 'Kecamatan', 'Desa',
        'Status Saat Ini', 'Sektor Pekerjaan', 'Jam Kerja', 'Gaji', 'Tanggal Input'
    ];

    $callback = function() use ($pencariData, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($pencariData as $data) {
            // Gunakan data dari join untuk menghindari query tambahan
            $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
            $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
            $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
            
            fputcsv($file, [
                $data->id,
                '"'.$data->ktp,
                $data->name,
                $data->tempat_lahir,
                $data->tanggal_lahir,
                $data->gender,
                $data->alamat,
                $data->kodepos,
                $data->tahun_lulus,
                $data->medsos,
                $data->marital_name ?? DB::table('naker_marital')->where('id', $data->id_status_perkawinan)->value('name'),
                $data->agama_name ?? DB::table('naker_agama')->where('id', $data->id_agama)->value('name'),
                $data->pendidikan_name,
                $data->jurusan_name,
                $kota,
                $kecamatan,
                $desa,
                $data->status_name ?? DB::table('status_kerja')->where('id', $data->status_saat_ini)->value('status'),
                $data->sektor_name ?? DB::table('naker_sektor')->where('id', $data->sektor_pekerjaan_saat_ini)->value('name'),
                $data->jam_kerja,
                $data->gaji,
                date('d-m-Y', strtotime($data->created_at))
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


    public function penyedia(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data users_penyedia beserta nama wilayah
            $query = UserPenyedia::select([
                'users_penyedia.id',
                'users_penyedia.name',
                'users_penyedia.luar_negri',
                'users_penyedia.deskripsi',
                'users_penyedia.jenis_perusahaan',
                'users_penyedia.nib',
                'users_penyedia.id_sektor',
                'users_penyedia.id_kota',
                'users_penyedia.id_kecamatan',
                'users_penyedia.id_desa',
                'users_penyedia.alamat',
                'users_penyedia.kodepos',
                'users_penyedia.telpon',
                'users_penyedia.jabatan',
                'users_penyedia.website',
                'users_penyedia.created_at',
            ]);

            return DataTables::eloquent($query)
                ->addColumn('jenis_perusahaan', function ($data) {
                    $jenis = [
                        'bumd' => 'Badan Usaha Milik Daerah',
                        'bumn' => 'Badan Usaha Milik Negara',
                        'cv' => 'Comanditer Venotschaap',
                        'firma' => 'Firma',
                        'instansi' => 'Instansi',
                        'kp' => 'Koperasi',
                        'pt' => 'Perseroan Terbatas',
                        'pp' => 'Perusahaan Perorangan',
                        'po' => 'PO*',
                        'yayasan' => 'Yayasan'
                    ];
                    return $jenis[$data->jenis_perusahaan] ?? 'Tidak Diketahui';
                })
                ->addColumn('luar_negri', function ($data) {
                    return $data->luar_negri == 1 ? 'Ya' : 'Tidak';
                })
                ->addColumn('kota', function ($data) {
                    // Ambil nama kota berdasarkan id_kota
                    $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                    return $kota ?? 'Tidak Ditemukan';
                })
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->addColumn('desa', function ($data) {
                    // Ambil nama desa berdasarkan id_desa
                    $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                    return $desa ?? 'Tidak Ditemukan';
                })
                ->addColumn('sektor', function ($data) {
                    // Ambil nama sektor berdasarkan id_sektor
                    $sektor = DB::table('naker_sektor')->where('id', $data->id_sektor)->value('name');
                    return $sektor ?? '-';
                })
                 ->addColumn('created_at', function ($data) {
                    if ($data->created_at) {
                        return date('d-m-Y', strtotime($data->created_at));
                    }
                    return '-';
                })
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '<a href="' . route('data.penyedia.edit', $data->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.data-penyedia.penyedia');
    }

    public function editPenyedia($id)
    {
        $penyedia = UserPenyedia::findOrFail($id);
        return view('backend.data-penyedia.edit', compact('penyedia'));
    }

    public function updateDataPenyedia(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:100',
            'luar_negri' => 'required|in:0,1',
            'jenis_perusahaan' => 'required|in:bumd,bumn,cv,firma,instansi,kp,pt,pp,po,yayasan',
            'deskripsi' => 'nullable|string|max:500',
            'nib' => 'nullable|string|max:30',
            'id_sektor' => 'nullable|integer',
            'id_provinsi' => '64',
            'kabkota_id' => 'required|integer',
            'kecamatan_id' => 'required|integer',
            'desa_id' => 'required|string|max:10',
            'alamat' => 'required|string|max:200',
            'kodepos' => 'required|string|max:5',
            'telpon' => 'required|string|max:15',
            'jabatan' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:100',
        ]);

        // Mengambil data UserPenyedia berdasarkan ID
        $penyedia = UserPenyedia::findOrFail($id);

        // Update data UserPenyedia
        $penyedia->update([
            'name' => $request->name,
            'luar_negri' => $request->luar_negri,
            'jenis_perusahaan' => $request->jenis_perusahaan,
            'deskripsi' => $request->deskripsi,
            'nib' => $request->nib,
            'id_sektor' => $request->id_sektor,
            'id_provinsi' => '64',
            'id_kota' => $request->kabkota_id,
            'id_kecamatan' => $request->kecamatan_id,
            'id_desa' => $request->desa_id,
            'alamat' => $request->alamat,
            'kodepos' => $request->kodepos,
            'telpon' => $request->telpon,
            'jabatan' => $request->jabatan,
            'website' => $request->website,
        ]);

        // Redirect ke halaman profil setelah berhasil update
        return redirect()->route('data.penyedia')->with('success', 'Data penyedia berhasil diperbarui.');
    }

    public function exportPenyedia(Request $request)
    {
        $query = UserPenyedia::select([
            'id',
            'name',
            'nib',
            'jenis_perusahaan',
            'id_sektor',
            'alamat',
            'kodepos',
            'telpon',
            'jabatan',
            'website',
            'id_kota',
            'id_kecamatan',
            'id_desa',
            'luar_negri',
            'deskripsi',
            'created_at'
        ]);

        // Terapkan filter pencarian dari DataTables
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('nib', 'like', "%{$search}%")
                ->orWhere('jenis_perusahaan', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('kodepos', 'like', "%{$search}%")
                ->orWhere('telpon', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%")
                ->orWhere('website', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('luar_negri', 'like', "%{$search}%");
        }

        // Ambil data setelah difilter
        $penyediaData = $query->get();


        $fileName = 'data_penyedia.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Kolom-kolom yang akan diekspor ke CSV
        $columns = [
            'ID',
            'Nama Perusahaan',
            'NIB',
            'Jenis Perusahaan',
            'Sektor',
            'Alamat',
            'Kodepos',
            'Telpon',
            'Jabatan',
            'Website',
            'Kota',
            'Kecamatan',
            'Desa',
            'Penyedia Luar Negeri',
            'Deskripsi',
             'Tanggal Input',
        ];

        // Callback untuk menulis data ke CSV
        $callback = function () use ($penyediaData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis header CSV

            foreach ($penyediaData as $data) {
                // Ambil nama wilayah untuk setiap kolom
                $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                $sektor = DB::table('naker_sektor')->where('id', $data->id_sektor)->value('name');
                $jenisPerusahaanMapping = [
                    'bumd' => 'Badan Usaha Milik Daerah',
                    'bumn' => 'Badan Usaha Milik Negara',
                    'cv' => 'Comanditer Venotschaap',
                    'firma' => 'Firma',
                    'instansi' => 'Instansi',
                    'kp' => 'Koperasi',
                    'pt' => 'Perseroan Terbatas',
                    'pp' => 'Perusahaan Perorangan',
                    'po' => 'PO*',
                    'yayasan' => 'Yayasan',
                ];
                $jenisPerusahaan = $jenisPerusahaanMapping[$data->jenis_perusahaan] ?? 'Tidak Diketahui';
                $luarNegri = $data->luar_negri == '1' ? 'Ya' : 'Tidak';
                 $created_at = date('d-m-Y', strtotime($data->created_at));

                // Tulis data ke CSV dengan nama wilayah dan sektor
                fputcsv($file, [
                    $data->id,
                    $data->name,
                    $data->nib,
                    $jenisPerusahaan,
                    $sektor,
                    $data->alamat,
                    $data->kodepos,
                    $data->telpon,
                    $data->jabatan,
                    $data->website,
                    $kota,
                    $kecamatan,
                    $desa,
                    $luarNegri,
                    $data->deskripsi,
                    $created_at
                ]);
            }

            fclose($file);
        };

        // Mengirimkan file CSV ke browser
        return response()->stream($callback, 200, $headers);
    }


    public function bkk(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data users_bkk beserta nama wilayah
            $query = UserBkk::select([
                'users_bkk.id',
                'users_bkk.name',
                'users_bkk.luar_negri',
                'users_bkk.deskripsi',
                'users_bkk.jenis_bkk',
                'users_bkk.nib',
                'users_bkk.id_sektor',
                'users_bkk.id_provinsi',
                'users_bkk.id_kota',
                'users_bkk.id_kecamatan',
                'users_bkk.id_desa',
                'users_bkk.alamat',
                'users_bkk.kodepos',
                'users_bkk.telpon',
                'users_bkk.jabatan',
                'users_bkk.website',
                'users_bkk.created_at'
            ]);

            return DataTables::eloquent($query)
                ->addColumn('jenis_bkk', function ($data) {
                    $jenis = [
                        'bumd' => 'Badan Usaha Milik Daerah',
                        'bumn' => 'Badan Usaha Milik Negara',
                        'cv' => 'Comanditer Venotschaap',
                        'firma' => 'Firma',
                        'instansi' => 'Instansi',
                        'kp' => 'Koperasi',
                        'pt' => 'Perseroan Terbatas',
                        'pp' => 'Perusahaan Perorangan',
                        'po' => 'PO*',
                        'yayasan' => 'Yayasan'
                    ];
                    return $jenis[$data->jenis_bkk] ?? 'Tidak Diketahui';
                })
                ->addColumn('luar_negri', function ($data) {
                    return $data->luar_negri == 1 ? 'Ya' : 'Tidak';
                })
                ->addColumn('provinsi', function ($data) {
                    // Ambil nama provinsi berdasarkan id_provinsi
                    $provinsi = DB::table('naker_provinsi')->where('id', $data->id_provinsi)->value('name');
                    return $provinsi ?? 'Tidak Ditemukan';
                })
                ->addColumn('kota', function ($data) {
                    // Ambil nama kota berdasarkan id_kota
                    $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                    return $kota ?? 'Tidak Ditemukan';
                })
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->addColumn('desa', function ($data) {
                    // Ambil nama desa berdasarkan id_desa
                    $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                    return $desa ?? 'Tidak Ditemukan';
                })
                ->addColumn('sektor', function ($data) {
                    // Ambil nama sektor berdasarkan id_sektor
                    $sektor = DB::table('naker_sektor')->where('id', $data->id_sektor)->value('name');
                    return $sektor ?? '-';
                })
                 ->addColumn('created_at', function ($data) {
                    if ($data->created_at) {
                        return date('d-m-Y', strtotime($data->created_at));
                    }
                    return '-';
                })
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '<a href="' . route('data.bkk.edit', $data->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.data-bkk.bkk');
    }

    public function editBkk($id)
    {
        $bkk = UserBkk::findOrFail($id);
        return view('backend.data-bkk.edit', compact('bkk'));
    }

    public function updateDataBkk(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:100',
            'luar_negri' => 'required|in:0,1',
            'jenis_bkk' => 'required|in:bumd,bumn,cv,firma,instansi,kp,pt,pp,po,yayasan',
            'deskripsi' => 'nullable|string|max:500',
            'nib' => 'nullable|string|max:30',
            'id_sektor' => 'nullable|integer',
            'provinsi_id' => 'required|integer',
            'kabkota_id' => 'required|integer',
            'kecamatan_id' => 'required|integer',
            'desa_id' => 'required|string|max:10',
            'alamat' => 'required|string|max:200',
            'kodepos' => 'required|string|max:5',
            'telpon' => 'required|string|max:15',
            'jabatan' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:100',
        ]);

        // Mengambil data UserBkk berdasarkan ID
        $bkk = UserBkk::findOrFail($id);

        // Update data UserBkk
        $bkk->update([
            'name' => $request->name,
            'luar_negri' => $request->luar_negri,
            'jenis_bkk' => $request->jenis_bkk,
            'deskripsi' => $request->deskripsi,
            'nib' => $request->nib,
            'id_sektor' => $request->id_sektor,
            'id_provinsi' => $request->provinsi_id,
            'id_kota' => $request->kabkota_id,
            'id_kecamatan' => $request->kecamatan_id,
            'id_desa' => $request->desa_id,
            'alamat' => $request->alamat,
            'kodepos' => $request->kodepos,
            'telpon' => $request->telpon,
            'jabatan' => $request->jabatan,
            'website' => $request->website,
        ]);

        // Redirect ke halaman profil setelah berhasil update
        return redirect()->route('data.bkk')->with('success', 'Data Bkk berhasil diperbarui.');
    }

    public function exportBkk(Request $request)
    {
        $query = UserBkk::select([
            'id',
            'name',
            'nib',
            'jenis_bkk',
            'id_sektor',
            'alamat',
            'kodepos',
            'telpon',
            'jabatan',
            'website',
            'id_provinsi',
            'id_kota',
            'id_kecamatan',
            'id_desa',
            'luar_negri',
            'deskripsi',
            'created_at'
        ]);

        // Terapkan filter pencarian dari DataTables
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('nib', 'like', "%{$search}%")
                ->orWhere('jenis_bkk', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('kodepos', 'like', "%{$search}%")
                ->orWhere('telpon', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%")
                ->orWhere('website', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('luar_negri', 'like', "%{$search}%");
        }

        // Ambil data setelah difilter
        $bkkData = $query->get();


        $fileName = 'data_bkk.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Kolom-kolom yang akan diekspor ke CSV
        $columns = [
            'ID',
            'Nama Bkk',
            'NIB',
            'Jenis Bkk',
            'Sektor',
            'Alamat',
            'Kodepos',
            'Telpon',
            'Jabatan',
            'Website',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Desa',
            'Penyedia Luar Negeri',
            'Deskripsi',
            'Tanggal Input',
        ];

        // Callback untuk menulis data ke CSV
        $callback = function () use ($bkkData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis header CSV

            foreach ($bkkData as $data) {
                // Ambil nama wilayah untuk setiap kolom
                $provinsi = DB::table('naker_provinsi')->where('id', $data->id_provinsi)->value('name');
                $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                $sektor = DB::table('naker_sektor')->where('id', $data->id_sektor)->value('name');
                $jenisPerusahaanMapping = [
                    'bumd' => 'Badan Usaha Milik Daerah',
                    'bumn' => 'Badan Usaha Milik Negara',
                    'cv' => 'Comanditer Venotschaap',
                    'firma' => 'Firma',
                    'instansi' => 'Instansi',
                    'kp' => 'Koperasi',
                    'pt' => 'Perseroan Terbatas',
                    'pp' => 'Perusahaan Perorangan',
                    'po' => 'PO*',
                    'yayasan' => 'Yayasan',
                ];
                $jenisPerusahaan = $jenisPerusahaanMapping[$data->jenis_bkk] ?? 'Tidak Diketahui';
                $luarNegri = $data->luar_negri == '1' ? 'Ya' : 'Tidak';
                  $created_at = date('d-m-Y', strtotime($data->created_at));

                // Tulis data ke CSV dengan nama wilayah dan sektor
                fputcsv($file, [
                    $data->id,
                    $data->name,
                    $data->nib,
                    $jenisPerusahaan,
                    $sektor,
                    $data->alamat,
                    $data->kodepos,
                    $data->telpon,
                    $data->jabatan,
                    $data->website,
                    $provinsi,
                    $kota,
                    $kecamatan,
                    $desa,
                    $luarNegri,
                    $data->deskripsi,
                     $created_at
                ]);
            }

            fclose($file);
        };

        // Mengirimkan file CSV ke browser
        return response()->stream($callback, 200, $headers);
    }

    public function blk(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data users_blk beserta nama wilayah
            $query = UserBlk::select([
                'users_blk.id',
                'users_blk.name',
                'users_blk.id_provinsi',
                'users_blk.id_kota',
                'users_blk.id_kecamatan',
                'users_blk.id_desa',
                'users_blk.alamat',
                'users_blk.kodepos',
                'users_blk.telpon',
                'users_blk.pic',
                'users_blk.jabatan',
                'users_blk.website',
                'users_blk.created_at',
            ]);

            return DataTables::eloquent($query)
                ->addColumn('provinsi', function ($data) {
                    // Ambil nama provinsi berdasarkan id_provinsi
                    $provinsi = DB::table('naker_provinsi')->where('id', $data->id_provinsi)->value('name');
                    return $provinsi ?? 'Tidak Ditemukan';
                })
                ->addColumn('kota', function ($data) {
                    // Ambil nama kota berdasarkan id_kota
                    $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                    return $kota ?? 'Tidak Ditemukan';
                })
                ->addColumn('kecamatan', function ($data) {
                    // Ambil nama kecamatan berdasarkan id_kecamatan
                    $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                    return $kecamatan ?? 'Tidak Ditemukan';
                })
                ->addColumn('desa', function ($data) {
                    // Ambil nama desa berdasarkan id_desa
                    $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                    return $desa ?? 'Tidak Ditemukan';
                })
                 ->addColumn('created_at', function ($data) {
                    if ($data->created_at) {
                        return date('d-m-Y', strtotime($data->created_at));
                    }
                    return '-';
                })
                ->addIndexColumn()
                ->addColumn('options', function ($data) {
                    return '<a href="' . route('data.blk.edit', $data->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('backend.data-blk.blk');
    }

    public function editBlk($id)
    {
        $blk = UserBlk::findOrFail($id);
        return view('backend.data-blk.edit', compact('blk'));
    }

    public function updateDataBlk(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:100',
            'provinsi_id' => 'required|integer',
            'kabkota_id' => 'required|integer',
            'kecamatan_id' => 'required|integer',
            'desa_id' => 'required|string|max:10',
            'alamat' => 'required|string|max:200',
            'kodepos' => 'required|string|max:5',
            'telpon' => 'required|string|max:15',
            'pic' => 'required|string|max:50',
            'jabatan' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:100',
        ]);

        // Mengambil data UserBlk berdasarkan ID
        $blk = UserBlk::findOrFail($id);

        // Update data UserBlk
        $blk->update([
            'name' => $request->name,
            'id_provinsi' => $request->provinsi_id,
            'id_kota' => $request->kabkota_id,
            'id_kecamatan' => $request->kecamatan_id,
            'id_desa' => $request->desa_id,
            'alamat' => $request->alamat,
            'kodepos' => $request->kodepos,
            'telpon' => $request->telpon,
            'pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'website' => $request->website,
        ]);

        // Redirect ke halaman profil setelah berhasil update
        return redirect()->route('data.blk')->with('success', 'Data Blk berhasil diperbarui.');
    }

    public function exportBlk(Request $request)
    {
        $query = UserBlk::select([
            'id',
            'name',
            'alamat',
            'kodepos',
            'telpon',
            'pic',
            'jabatan',
            'website',
            'id_provinsi',
            'id_kota',
            'id_kecamatan',
            'id_desa',
            'created_at'
        ]);

        // Terapkan filter pencarian dari DataTables
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('kodepos', 'like', "%{$search}%")
                ->orWhere('telpon', 'like', "%{$search}%")
                ->orWhere('pic', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%")
                ->orWhere('website', 'like', "%{$search}%");
        }

        // Ambil data setelah difilter
        $blkData = $query->get();


        $fileName = 'data_blk.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Kolom-kolom yang akan diekspor ke CSV
        $columns = [
            'ID',
            'Nama Blk',
            'Alamat',
            'Kodepos',
            'Telpon',
            'Pic',
            'Jabatan',
            'Website',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Desa',
            'Tanggal Input',
        ];

        // Callback untuk menulis data ke CSV
        $callback = function () use ($blkData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis header CSV

            foreach ($blkData as $data) {
                // Ambil nama wilayah untuk setiap kolom
                $provinsi = DB::table('naker_provinsi')->where('id', $data->id_provinsi)->value('name');
                $kota = DB::table('naker_kabkota')->where('id', $data->id_kota)->value('name');
                $kecamatan = DB::table('naker_kecamatan')->where('id', $data->id_kecamatan)->value('name');
                $desa = DB::table('naker_desa')->where('id', $data->id_desa)->value('name');
                 $created_at = date('d-m-Y', strtotime($data->created_at));

                // Tulis data ke CSV dengan nama wilayah dan sektor
                fputcsv($file, [
                    $data->id,
                    $data->name,
                    $data->alamat,
                    $data->kodepos,
                    $data->telpon,
                    $data->pic,
                    $data->jabatan,
                    $data->website,
                    $provinsi,
                    $kota,
                    $kecamatan,
                    $desa,
                     $created_at
                ]);
            }

            fclose($file);
        };

        // Mengirimkan file CSV ke browser
        return response()->stream($callback, 200, $headers);
    }
}
