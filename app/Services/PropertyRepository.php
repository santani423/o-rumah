<?php

namespace App\Services;

use App\Models\AdsProperty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\UserClickAdsHistory;

trait PropertyRepository
{
    private function getAdsListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage = 10, $page = 3)
{
    $query = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
        ->join('media', function ($join) {
            $join->on('media.model_id', '=', 'ads.id')
                ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
        })
        ->join('users', 'users.id', '=', 'ads.user_id')
        ->where('ads.type', 'property')
        ->where('ads.is_active', 1)
        ->select(
            "ads_properties.id as ads_property_id",
            DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
            "ads.title",
            "ads.slug",
            "users.name as name_user",
            "ads_properties.*",
            "ads.status",
            'media.id as media_id',
            'media.file_name as file_name',
            "ads.is_active"
        );
    
    if ($latitude != null && $longitude != null && $latitude != 'null' && $longitude != 'null' ) {
        $query->selectRaw("
            (6371 * acos(
                cos(radians($latitude))
                * cos(radians(ads_properties.lat))
                * cos(radians(ads_properties.lng) - radians($longitude))
                + sin(radians($latitude))
                * sin(radians(ads_properties.lat))
            )) AS distance
        ")
        ->having('distance', '<', $radius);
    }
  
    $adsLists = $query->where(function ($query) use ($searchQuery) {
            $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                ->orWhere('ads_properties.ads_type', 'like', '%' . $searchQuery . '%')
                ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
        })
        ->orderBy('ads.id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

    return $adsLists;
}


}
