<?php

namespace App\Services;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

trait FoodService
{
    private function getAdsFoodListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage = 10, $kategori = '')
    {
        // Pastikan kategori adalah string
        $kategori = strval($kategori);

        $adsLists = Food::join('ads', 'ads.id', '=', 'ofoods.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->when($kategori, function ($query, $kategori) {
                return $query->join('kategori_food', 'kategori_food.oFood_id', '=', 'ofoods.id')
                    ->join('sup_kategoris', 'sup_kategoris.id', '=', 'kategori_food.kategori_id')
                    ->join('kategoris', 'kategoris.id', '=', 'sup_kategoris.kategori_id')
                    ->where('sup_kategoris.nama', $kategori);
            })
            ->where('ads.is_active', 1)
            ->select(
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "users.name as name_user",
                "ads.status",
                "ads.is_active",
                "ads.id as ads_id",
                'media.id as media_id',
                'media.file_name as file_name',
                "ofoods.*",
                "ads.slug",
                DB::raw("
                (6371 * acos(
                    cos(radians($latitude))
                    * cos(radians(ofoods.districtLocation_lat))
                    * cos(radians(ofoods.districtLocation_long) - radians($longitude))
                    + sin(radians($latitude))
                    * sin(radians(ofoods.districtLocation_lat))
                )) AS distance
            ")
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('ads.id', 'desc')
            ->paginate($perPage)->items();

        return $adsLists;
    }


}