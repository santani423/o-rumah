<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearChatsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kosongkan tabel chats
        DB::table('chats')->truncate();

        // Kosongkan tabel listgroupchats
        DB::table('listgroupchats')->truncate();

        // Kosongkan tabel groupchats
        DB::table('groupchats')->truncate();
    }
}
