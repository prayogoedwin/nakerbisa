<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NakerSektorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data untuk diinsert
        $data = [
            ['kode' => 'IT', 'name' => 'Teknologi Informasi', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'EDU', 'name' => 'Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'HLT', 'name' => 'Kesehatan', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'FNC', 'name' => 'Keuangan', 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'MNF', 'name' => 'Manufaktur', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert data ke tabel
        DB::table('naker_sektor')->insert($data);
    }
}
