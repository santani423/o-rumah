<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdBalanceControlSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Ads KPR',
                'code' => 'ABC001',
                'klik' => 0,
                'nilai' => 10,
                'description' => 'Description for Ad Campaign 1',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-05-28 06:29:07',
            ],
            [
                'title' => 'Ads Titip',
                'code' => 'ABC002',
                'klik' => 0,
                'nilai' => 3,
                'description' => 'Description for Ad Campaign 2',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-05-09 14:04:11',
            ],
            [
                'title' => 'Booster',
                'code' => 'ABC003',
                'klik' => 1,
                'nilai' => 5,
                'description' => 'Penggunaan Poin Booster',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-07-07 09:11:06',
            ],
            [
                'title' => 'Booster Home Properti',
                'code' => 'ABC004',
                'klik' => 1,
                'nilai' => 10,
                'description' => 'Description for Ad Campaign 4',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-07-07 09:15:22',
            ],
            [
                'title' => 'Booster Eksklusif Properti',
                'code' => 'ABC005',
                'klik' => 1,
                'nilai' => 2,
                'description' => 'Description for Ad Campaign 5',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-07-07 09:51:28',
            ],
            [
                'title' => 'Ads Projec Developr',
                'code' => 'ABC006',
                'klik' => 350,
                'nilai' => 175,
                'description' => 'Description for Ad Campaign 6',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-05-09 14:04:11',
            ],
            [
                'title' => 'Ads Klik',
                'code' => 'ABC007',
                'klik' => 10,
                'nilai' => 1,
                'description' => 'Description for Ad Campaign 7',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-05-09 14:04:11',
            ],
            [
                'title' => 'Ambil Lelang',
                'code' => 'ABC008',
                'klik' => 1,
                'nilai' => 10,
                'description' => 'Description for Ad Campaign 7',
                'created_at' => '2024-05-09 14:04:11',
                'updated_at' => '2024-06-01 16:15:57',
            ],
            [
                'title' => 'Add Properti',
                'code' => 'ABC009',
                'klik' => 1,
                'nilai' => 1,
                'description' => 'Add property agent',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'title' => 'Aktivasi Property',
                'code' => 'ABC010',
                'klik' => 1,
                'nilai' => 5,
                'description' => 'Pemotongan adds saat agent mengaktifkan',
                'created_at' => null,
                'updated_at' => '2024-07-07 09:07:19',
            ],
            [
                'title' => 'Add Food',
                'code' => 'ABC011',
                'klik' => 1,
                'nilai' => 1,
                'description' => 'Add Food',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'title' => 'Add Marchent',
                'code' => 'ABC012',
                'klik' => 1,
                'nilai' => 1,
                'description' => 'Add Marchent',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'title' => 'Order Food & Marchant',
                'code' => 'ABC013',
                'klik' => 1,
                'nilai' => 1,
                'description' => 'Order Food & Marchant',
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        foreach ($data as $item) {
            $exists = DB::table('ad_balace_controls')->where('code', $item['code'])->exists();
            if (!$exists) {
                DB::table('ad_balace_controls')->insert($item);
            }
        }
    }
}
