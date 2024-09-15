<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdvertisingPoints;
use App\Models\UserClickAdsHistory;

class SetAdvin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil semua data dari tabel user_click_ads_histories
        $clickHistories = UserClickAdsHistory::get();
        
        foreach ($clickHistories as $value) {
            // Cari baris yang sesuai di tabel advertising_points berdasarkan advertising_points_id
            $advertisingPoints = AdvertisingPoints::where('id', $value->advertising_points_id)->first();
            
            // Jika ditemukan, set nilai ads_id
            if ($advertisingPoints) {
                $advertisingPoints->ads_id = $value->ads_id;
                $advertisingPoints->save();
            }
        }
    }
}
// php artisan db:seed --class=SetAdvin
