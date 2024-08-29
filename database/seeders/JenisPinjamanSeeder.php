<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPinjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_pinjaman')->insert([
            [
                'nama' => 'Multi Guna',
                'deskripsi' => 'Pinjaman untuk berbagai keperluan',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Modal Kerja',
                'deskripsi' => 'Pinjaman untuk modal usaha',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
