<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\UserClickAdsHistory;

trait AdvertisingPointsManager
{
    private function manageAdvertisingPoints(Request $request, $ads, $auth, $code = '')
    {
        $controll = AdBalaceControl::where("code", $code)->first();
        $adBalaces = AdBalance::where('user_id', $auth->id)->first();
        dd($controll);
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
                $AdvertisingPoints->points_deducted = 0;
                $AdvertisingPoints->description = $auth->name;
                $AdvertisingPoints->save();
            } else {
                $AdvertisingPoints->views_count++;
            }

            $AdvertisingPoints->save();

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