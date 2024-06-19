<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdBalanceControlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ad_balace_controls')->insert([
            ['code' => 'ABC001', 'title' => 'Ads KPR', 'klik' => 0, 'nilai' => 10, 'description' => 'Description for Ad Campaign 1', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC002', 'title' => 'Ads Titip', 'klik' => 0, 'nilai' => 3, 'description' => 'Description for Ad Campaign 2', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC003', 'title' => 'Ads Group Supplier', 'klik' => 0, 'nilai' => 0, 'description' => 'Description for Ad Campaign 3', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC004', 'title' => 'Ads Export Import', 'klik' => 0, 'nilai' => 0, 'description' => 'Description for Ad Campaign 4', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC005', 'title' => 'Ads Chart', 'klik' => 0, 'nilai' => 0, 'description' => 'Description for Ad Campaign 5', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC006', 'title' => 'Ads Projec Developr', 'klik' => 350, 'nilai' => 175, 'description' => 'Description for Ad Campaign 6', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC007', 'title' => 'Ads Klik', 'klik' => 10, 'nilai' => 1, 'description' => 'Description for Ad Campaign 7', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ABC008', 'title' => 'Ambil Lelang', 'klik' => 10, 'nilai' => 1, 'description' => 'Description for Ad Campaign 7', 'created_at' => now(), 'updated_at' => now()],
        ]);

        //    php artisan db:seed --class=AdBalanceControlsTableSeeder
    }
}
