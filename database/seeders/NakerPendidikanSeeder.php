<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NakerPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data untuk diinsert
        $data = [
            ['kode' => 'SD', 'name' => 'Sekolah Dasar', 'id_alternate' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'SMP', 'name' => 'Sekolah Menengah Pertama', 'id_alternate' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'SMA', 'name' => 'Sekolah Menengah Atas', 'id_alternate' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'D3', 'name' => 'Diploma 3', 'id_alternate' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'S1', 'name' => 'Sarjana', 'id_alternate' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'S2', 'name' => 'Magister', 'id_alternate' => 6, 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert data ke tabel
        DB::table('naker_pendidikan')->insert($data);
    }
}
