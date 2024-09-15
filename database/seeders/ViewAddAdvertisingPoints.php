<?php

namespace Database\Seeders;

use App\Models\Ads;
use App\Models\AdvertisingPoints;
use App\Models\ViewAd;
use App\Models\Visitors;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ViewAddAdvertisingPoints extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $controlPanel = AdvertisingPoints::get(); // Retrieve all AdvertisingPoints

        foreach ($controlPanel as $key => $value) {
            $ads = Ads::find($value->ads_id); // Find related Ads by ads_id
            
            if ($ads) {
                // Random visitor data
                $randomVisitor = Visitors::inRandomOrder()->first(); 
                
                for ($i = 0; $i <= $value->views_count; $i++) { 
                    // Generate random date between ads' created_at and now
                    $randomDate = Carbon::parse($ads->created_at)
                        ->addDays(rand(0, Carbon::now()->diffInDays(Carbon::parse($ads->created_at))));

                    // Create a new ViewAd record with random data and random date
                    ViewAd::create([
                        'ip_address' => $randomVisitor->ip_address,
                        'browser' => $randomVisitor->browser,
                        'device' => $randomVisitor->device,  
                        'visited_at' => $randomVisitor->visited_at, 
                        'page_visited' => 'view_ads',  
                        'advertising_points_id' => $value->id,
                        'created_at' => $randomDate,
                        'updated_at' => $randomDate, // Using the same random date for updated_at
                    ]);
                }
            }
        }
    }
}
