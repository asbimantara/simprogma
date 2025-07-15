<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['nama_status' => 'Draft'],
            ['nama_status' => 'Diajukan'],
            ['nama_status' => 'Sedang Dikoreksi'],
            ['nama_status' => 'Revisi'],
            ['nama_status' => 'Disetujui'],
            ['nama_status' => 'Ditolak'],
        ]);
    }
}
