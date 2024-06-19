<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ads;

class ManagementAdsController extends Controller
{
    function setActifity(Request $request)
    {
        $ads = Ads::whereId($request->ads_id)->first();

        if (!$ads) {
            return response()->json(['error' => 'Ads not found'], 404);
        }

        if ($ads->is_active == 1) {
            $ads->is_active = 0;
        } else {
            $ads->is_active = 1;
        }
        $ads->save();
        return json_encode($ads->is_active);

    }
}
