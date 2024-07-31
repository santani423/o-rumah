<?php

namespace App\Services;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

trait MarchantService
{
    private function getAdsMarchantListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage = 10, $kategori = '')
    {
        // Pastikan kategori adalah string
        $kategori = strval($kategori);

        $adsLists = Merchant::join('ads', 'ads.id', '=', 'omerchants.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->when($kategori, function ($query, $kategori) {
                return $query->join('kategori_marchents', 'kategori_marchents.marchent_id', '=', 'omerchants.id')
                    ->join('sup_kategoris', 'sup_kategoris.id', '=', 'kategori_marchents.kategori_id')
                    // ->join('kategoris', 'kategoris.id', '=', 'sup_kategoris.kategori_id')
                    ->where('sup_kategoris.slug', $kategori);
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
                "omerchants.*",
                "ads.slug",
                DB::raw("
                (6371 * acos(
                    cos(radians($latitude))
                    * cos(radians(omerchants.districtLocation_lat))
                    * cos(radians(omerchants.districtLocation_long) - radians($longitude))
                    + sin(radians($latitude))
                    * sin(radians(omerchants.districtLocation_lat))
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
// dd($adsLists);
        return $adsLists;
    }


}