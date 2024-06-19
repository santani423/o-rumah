<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use App\Services\FoodService;

class FoodController extends Controller
{
    use FoodService;
    function listing(Request $request)
    {

        $searchQuery = request()->input('search');
        $adsLists = $this->getAdsListsWithDistance($request->latitude, $request->longitude, $request->radius, $searchQuery);
    }
}
