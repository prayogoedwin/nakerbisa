<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NakerMaritalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data untuk diinsert
        $data = [
            ['id' => 'S', 'name' => 'Single', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 'M', 'name' => 'Married', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 'D', 'name' => 'Divorced', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 'W', 'name' => 'Widowed', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert data ke tabel
        DB::table('naker_marital')->insert($data);
    }
}
