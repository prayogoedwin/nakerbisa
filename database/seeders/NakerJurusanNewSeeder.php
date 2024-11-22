<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NakerJurusanNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data untuk diinsert
        $data = [
            ['nama' => 'Teknik Informatika', 'id_pendidikans' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Sistem Informasi', 'id_pendidikans' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Teknik Elektro', 'id_pendidikans' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Manajemen', 'id_pendidikans' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Akuntansi', 'id_pendidikans' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Multimedia', 'id_pendidikans' => '3', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Teknik Mesin', 'id_pendidikans' => '4', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert data ke tabel
        DB::table('naker_jurusan')->insert($data);
    }
}
