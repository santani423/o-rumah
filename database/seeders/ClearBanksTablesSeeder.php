<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearBanksTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nonaktifkan pemeriksaan kunci asing
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel 'banks' dan 'email_banks'
        DB::table('email_banks')->truncate();
        DB::table('banks')->truncate();

        // Aktifkan kembali pemeriksaan kunci asing
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
