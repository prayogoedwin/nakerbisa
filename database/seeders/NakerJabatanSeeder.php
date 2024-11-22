<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NakerJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data untuk diinsert
        $data = [
            ['nama' => 'Manajer', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Supervisor', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Staff', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Operator', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Teknisi', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert data ke tabel
        DB::table('naker_jabatan')->insert($data);
    }
}
