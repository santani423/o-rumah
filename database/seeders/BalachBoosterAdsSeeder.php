<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BalachBoosterAdsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'ad_balace_control_id' => 15,
                'booster_ads_id' => 3,
                'created_at' => '2024-07-07 07:52:41',
                'updated_at' => '2024-07-07 07:52:41',
            ],
            [
                'ad_balace_control_id' => 16,
                'booster_ads_id' => 1,
                'created_at' => '2024-07-07 09:14:32',
                'updated_at' => '2024-07-07 09:38:07',
            ],
            [
                'ad_balace_control_id' => 17,
                'booster_ads_id' => 2,
                'created_at' => '2024-07-07 09:50:49',
                'updated_at' => '2024-07-07 09:50:49',
            ],
        ];

        foreach ($data as $item) {
            $exists = DB::table('balach_booster_ads')
                ->where('ad_balace_control_id', $item['ad_balace_control_id'])
                ->where('booster_ads_id', $item['booster_ads_id'])
                ->exists();
                
            if (!$exists) {
                DB::table('balach_booster_ads')->insert($item);
            }
        }
    }
}
