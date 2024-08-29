<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class JenisJaminanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_jaminans')->insert([
            [
                'nama' => 'BPKB',
                'deskripsi' => 'Bukti Pemilikan Kendaraan Bermotor',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sertifikat',
                'deskripsi' => 'Sertifikat Tanah atau Bangunan',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'AJB',
                'deskripsi' => 'Akta Jual Beli',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
