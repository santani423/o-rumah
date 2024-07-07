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
use App\Models\bosterAdsTYpe;
use App\Models\UserClickAdsHistory;
use Carbon\Carbon;

trait PropertyRepository
{
    private function getAdsListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage = 10, $page = 3,$adsType = null,$property_type=null)
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
    if ($adsType != null) {
        $query->where('ads_properties.ads_type', $adsType);
    }
    if ($property_type != null) {
        $query->where('ads_properties.property_type', $property_type);
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


private function getAdsListsWithDistanceBoosterHome($latitude, $longitude, $radius, $searchQuery, $perPage = 10, $page = 3, $code = 'PTYHOME')
{
    $booster = bosterAdsTYpe::where('code', $code)->first();
    if ($booster) {
        $perPage = $booster->limit;
    }

    $oneMonthAgo = Carbon::now()->subMonth(); 

    $query = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
        ->join('media', function ($join) {
            $join->on('media.model_id', '=', 'ads.id')
                ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
        })
        ->join('users', 'users.id', '=', 'ads.user_id')
        ->join('boster_ads', function ($join) use ($code) {
            $join->on('ads.id', '=', 'boster_ads.ads_id')
                ->whereRaw('boster_ads.created_at = (SELECT MAX(ba.created_at) FROM boster_ads ba 
                    JOIN boster_ads_t_ypes bat ON ba.booster_type_id = bat.id 
                    WHERE ba.ads_id = ads.id AND bat.code = ?)', [$code]);
        })
        ->join('boster_ads_t_ypes', 'boster_ads_t_ypes.id', '=', 'boster_ads.booster_type_id')
        ->where('boster_ads_t_ypes.code', $code)
        ->where('ads.type', 'property')
        ->where('ads.is_active', 1)
        ->where('boster_ads.created_at', '>=', $oneMonthAgo) // Menambahkan kondisi untuk menampilkan data satu bulan terakhir
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
            "ads.is_active",
            'boster_ads.created_at as booster_created_at',
            'boster_ads_t_ypes.slug as booster_slug' // Menambahkan slug dari bosterAdsTYpe
        );

    if ($latitude != null && $longitude != null && $latitude != 'null' && $longitude != 'null') {
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
        ->orderBy('boster_ads.created_at', 'desc')
        ->orderBy('ads.id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

    return $adsLists;
}




private function getPropertyPosition($latitude, $longitude, $radius, $searchQuery, $perPage = 10, $page = 3, $code = 'PTYHOME', $slug)
{
    $query = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
        ->join('media', function ($join) {
            $join->on('media.model_id', '=', 'ads.id')
                ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
        })
        ->join('users', 'users.id', '=', 'ads.user_id')
        ->join('boster_ads', function ($join) use ($code) {
            $join->on('ads.id', '=', 'boster_ads.ads_id')
                ->whereRaw('boster_ads.created_at = (SELECT MAX(ba.created_at) FROM boster_ads ba 
                    JOIN boster_ads_t_ypes bat ON ba.booster_type_id = bat.id 
                    WHERE ba.ads_id = ads.id AND bat.code = ?)', [$code]);
        })
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
            "ads.is_active",
            'boster_ads.created_at as booster_created_at'
        );

    if ($latitude != null && $longitude != null && $latitude != 'null' && $longitude != 'null') {
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
        ->orderBy('boster_ads.created_at', 'desc')
        ->orderBy('ads.id', 'desc')
        ->get();

    $position = $adsLists->search(function ($item, $key) use ($slug) {
        return $item->slug === $slug;
    });

    return $position !== false ? $position + 1 : null;
}


}
