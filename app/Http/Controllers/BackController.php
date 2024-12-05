<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\UserPencari;
use App\Models\UserPenyedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->roles[0]['name'] == 'super-admin') {
            $pencariKerjaCount = DB::table('users_pencari')->count();
            $penyediaKerjaCount = DB::table('users_penyedia')->count();
            $lowonganAktifCount = DB::table('naker_lowongan')
                ->where('tanggal_start', '<=', now())
                ->where('tanggal_end', '>=', now())
                ->count();
            $progresIdDalamProses = DB::table('naker_progres')
                ->where('kode', 2)
                ->value('id');

            $lamaranDalamProsesCount = DB::table('naker_lamarans')
                ->where('progres_id', $progresIdDalamProses)
                ->count();
            return view('backend.dashboard.index', compact('pencariKerjaCount', 'penyediaKerjaCount', 'lowonganAktifCount', 'lamaranDalamProsesCount'));
        }

        if (Auth::user()->roles[0]['name'] == 'tenaga-kerja') {
            $userId = Auth::id();
            $lamaranAndaCount = DB::table('naker_lamarans')
                ->where('pencari_id', $userId)
                ->count();
            $lamaranDalamProsesCount = DB::table('naker_lamarans')
                ->join('naker_progres', 'naker_lamarans.progres_id', '=', 'naker_progres.id')
                ->where('naker_lamarans.pencari_id', $userId)
                ->where('naker_progres.kode', 2)
                ->count();
            $lowonganAktifCount = DB::table('naker_lowongan')
                ->where('tanggal_start', '<=', now())
                ->where('tanggal_end', '>=', now())
                ->count();
            return view('backend.dashboard.index_pencari', compact('lamaranAndaCount', 'lamaranDalamProsesCount', 'lowonganAktifCount'));
        }

        if (Auth::user()->roles[0]['name'] == 'penyedia-kerja') {
            return view('backend.dashboard.index_penyedia');
        }

        if (Auth::user()->roles[0]['name'] == 'admin-bkk') {
            return view('backend.dashboard.index_bkk');
        }
    }

    public function statistik()
    {
        $genderData = UserPencari::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();

        $genderChartData = $genderData->map(function ($item) {
            return [
                'name' => $item->gender == 'L' ? 'Pria' : 'Wanita',
                'y' => (int) $item->total
            ];
        });

        $educationData = UserPencari::join('naker_pendidikan', 'users_pencari.id_pendidikan', '=', 'naker_pendidikan.id')
            ->select('naker_pendidikan.name as education', DB::raw('count(users_pencari.id_pendidikan) as total'))
            ->groupBy('naker_pendidikan.name')
            ->get();

        $educationChartData = $educationData->map(function ($item) {
            return [
                'name' => $item->education,
                'y' => (int) $item->total
            ];
        });

        $generations = [
            'Baby Boomers' => [1946, 1980],
            'Millennials'  => [1981, 1996],
            'Gen Z'        => [1997, 2012],
            'Gen Alpha'    => [2013, date('Y')]
        ];

        $generationCounts = UserPencari::select(DB::raw('YEAR(tanggal_lahir) as birth_year'), DB::raw('count(*) as total'))
            ->groupBy('birth_year')
            ->get()
            ->groupBy(function ($item) use ($generations) {
                $year = $item->birth_year;
                foreach ($generations as $generation => $range) {
                    if ($year >= $range[0] && $year <= $range[1]) {
                        return $generation;
                    }
                }
                return 'Unknown';
            })
            ->map(function ($items) {
                return $items->sum('total');
            });

        $generationChartData = $generationCounts->map(function ($count, $generation) {
            return [
                'name' => $generation,
                'y' => $count
            ];
        })->values();

        $sectorCounts = UserPenyedia::select('id_sektor', DB::raw('count(*) as total'))
            ->groupBy('id_sektor')
            ->get()
            ->map(function ($item) {
                $sectorName = DB::table('naker_sektor')->where('id', $item->id_sektor)->value('name');
                return [
                    'name' => $sectorName ?? 'Unknown',
                    'y' => $item->total
                ];
            });

        $cityCounts = UserPenyedia::select(DB::raw('
            CASE 
                WHEN id_kota = 3317 THEN "Rembang"
                ELSE "Luar Rembang"
            END as city_category
        '), DB::raw('count(*) as total'))
            ->groupBy('city_category')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->city_category,
                    'y' => $item->total
                ];
            });

        $educationCounts = Lowongan::select('pendidikan_id', DB::raw('count(*) as total'))
            ->groupBy('pendidikan_id')
            ->get()
            ->map(function ($item) {
                $educationNames = [
                    1 => 'SD',
                    2 => 'SMP',
                    3 => 'SMA',
                    4 => 'D3',
                    5 => 'S1',
                    6 => 'S2',
                ];
                return [
                    'name' => $educationNames[$item->pendidikan_id] ?? 'Tidak Diketahui',
                    'y' => $item->total
                ];
            });

        $lowonganGenderData = Lowongan::select(DB::raw('sum(jumlah_pria) as total_pria'), DB::raw('sum(jumlah_wanita) as total_wanita'))
            ->first();

        $lowonganGenderChartData = [
            ['name' => 'Pria', 'y' => (int) $lowonganGenderData->total_pria],
            ['name' => 'Wanita', 'y' => (int) $lowonganGenderData->total_wanita]
        ];


        $currentDate = now(); // Mendapatkan tanggal saat ini

        // Menghitung jumlah lowongan aktif
        $activeLowonganCount = Lowongan::where('tanggal_start', '<=', $currentDate)
            ->where('tanggal_end', '>=', $currentDate)
            ->count();

        // Menghitung jumlah lowongan expired
        $expiredLowonganCount = Lowongan::where('tanggal_end', '<', $currentDate)
            ->count();

        $lowonganAktifChartData = [
            ['name' => 'Aktif', 'y' => $activeLowonganCount],
            ['name' => 'Expired', 'y' => $expiredLowonganCount]
        ];

        return view('backend.statistik.index', compact(
            'genderChartData',
            'educationChartData',
            'generationChartData',
            'sectorCounts',
            'cityCounts',
            'educationCounts',
            'lowonganGenderChartData',
            'lowonganAktifChartData'
        ));
    }


    public function sample()
    {
        return view('backend.sample.index');
    }

    public function settingBanner()
    {
        return view('backend.setting.banner.index');
    }
}
