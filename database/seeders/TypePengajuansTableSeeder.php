<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePengajuansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_pengajuans')->insert([
            [
                'name' => 'Pengajuan KPR',
                'slug' => 'pengajuan-kpr',
                'logo' => null,
                'urutan' => '1',
                'description' => 'Pengajuan Kredit Pemilikan Rumah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengajuan Dana',
                'slug' => 'pengajuan-dana',
                'logo' => null,
                'urutan' => '2',
                'description' => 'Pengajuan pinjaman dana tunai.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
