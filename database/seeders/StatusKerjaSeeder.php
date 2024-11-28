<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = [
            ['status' => 'bekerja'],
            ['status' => 'belum bekerja'],
            ['status' => 'tidak bekerja'],
        ];

        DB::table('status_kerja')->insert($statuses);
    }
}
