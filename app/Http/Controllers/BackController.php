<?php

namespace App\Http\Controllers;

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
            return view('backend.dashboard.index');
        }

        if (Auth::user()->roles[0]['name'] == 'tenaga-kerja') {
            return view('backend.dashboard.index_pencari');
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

        return view('backend.statistik.index', compact('genderChartData', 'educationChartData', 'generationChartData', 'sectorCounts'));
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
