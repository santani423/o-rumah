<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\UserClickAdsHistory;
use App\Models\ViewAd;

use Jenssegers\Agent\Agent; // Library untuk mendeteksi device dan browser
trait AdvertisingPointsManager
{
    private function manageAdvertisingPoints(Request $request, $ads, $auth, $code = '')
    {
        $controll = AdBalaceControl::where("code", $code)->first();
        $adBalaces = AdBalance::where('user_id', $auth->id)->first();
        $AdvertisingPoints = AdvertisingPoints::where('ad_balance_control_id', $controll->id)
            ->where('ad_balance_id', $adBalaces->id)
            ->where('views_count', '<', $controll->klik)
            ->first();
    
        if ($adBalaces->balance >= $controll->nilai) {
    
            if (!$AdvertisingPoints) {
                $AdvertisingPoints = new AdvertisingPoints();
                $AdvertisingPoints->ad_balance_control_id = $controll->id;
                $AdvertisingPoints->ad_balance_id = $adBalaces->id;
                $AdvertisingPoints->title = $auth->name;
                $AdvertisingPoints->views_count = 1;
                $AdvertisingPoints->ads_id = $ads->ads_id;
                $AdvertisingPoints->points_deducted = 0;
                $AdvertisingPoints->description = $auth->name; 
            } else {
                $AdvertisingPoints->views_count++;
            }
            $AdvertisingPoints->save();
    
            // Create a new entry in the view_ads table
            $agent = new Agent();
            ViewAd::create([
                'ip_address' => $request->ip(),
                'browser' => $agent->browser(),
                'device' => $agent->device(), // You can adjust how to detect device type
                'visited_at' => now(),
                'page_visited' => 'ads_page', // You can set the actual page being visited
                'advertising_points_id' => $AdvertisingPoints->id,
            ]);
            // dd($AdvertisingPoints->id);
    
            if ($controll->klik > 0 && $AdvertisingPoints->views_count >= $controll->klik) {
                $AdvertisingPoints->points_deducted = $controll->nilai;
                $AdvertisingPoints->save();
                $adBalaces->balance -= $controll->nilai;
                $adBalaces->save();
    
                $history = new UserClickAdsHistory([
                    'user_id' => $ads->user_id,
                    'ads_id' => $ads->ads_id,
                    'advertising_points_id' => $AdvertisingPoints->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $auth->name
                ]);
                $history->save();
            }
    
            return response()->json([
                'message' => 'Poin iklan berhasil dikelola',
                'balance' => $adBalaces->balance,
            ], 200);
        }
    
        return response()->json([
            'message' => 'Saldo tidak mencukupi',
            'balance' => null
        ], 400);
    }
    
}