<?php

use App\Models\Ads;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

function slugify($string)
{
    return Str::slug($string, '-');
}

function getLocationByIp(string $ip)
{
    // check if ip is valid
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return [];
    }

    // check if ip is localhost, then return laravel default timezone
    if ($ip === '127.0.0.1') {
        return [];
    }

    // request to http://www.geoplugin.net/json.gp?ip=, return all response as json
    try {
        $response = Http::get('http://www.geoplugin.net/json.gp?ip=' . $ip);

        return $response->json();
    } catch (\Exception $e) {
        return [];
    }
}

function getTimezoneFromSession()
{
    return session('timezone') ?? session('fallback_timezone');
}

function formatToRupiah($n, $precise = 1)
{
    if ($n < 900) {
        $numberFormat = number_format($n, $precise);
        $symbol = '';
    } else if ($n < 900000) {
        $numberFormat = number_format($n / 1000, $precise, ',', '.');
        $symbol = 'Ribu';
    } else if ($n < 900000000) {
        $numberFormat = number_format($n / 1000000, $precise, ',', '.');
        $symbol = 'Juta';
    } else if ($n < 900000000000) {
        $numberFormat = number_format($n / 1000000000, $precise, ',', '.');
        $symbol = 'Miliar';
    } else {
        $numberFormat = number_format($n / 1000000000000, $precise, ',', '.');
        $symbol = 'Triliun';
    }

    if ($precise > 0) {
        $separator = '.' . str_repeat('0', $precise);
        $numberFormat = str_replace($separator, '', $numberFormat);
    }

    return 'Rp' . $numberFormat . ' ' . $symbol;
}

function mapAgent(User $agent)
{
    return [
        'agent_id' => $agent->id,
        'image' => $agent->image,
        'name' => $agent->name,
        'bio' => $agent->bio,
        'username' => $agent->username,
        'type' => $agent->type,
        'phone' => $agent->phone,
        'wa_phone' => $agent->wa_phone,
        'joined_at' => $agent->joined_at,
        // 'company_image' => $agent->company?->image ?: 'https://via.placeholder.com/200',
        // 'company_name' => $agent->company?->name,
        'company_image' => $agent->company_image ?: 'https://via.placeholder.com/200',
        'company_name' => $agent->company_name,
        'bank_name' => $agent->bank_name,
        'bank_number' => $agent->bank_number,
        'total_ads' => $agent->total_ads,
        'total_sold' => $agent->total_sold,
        'average_price' => $agent->average_price,
    ];
}

function mapAds(Ads $ads)
{
    $furnitureCondition = $ads->property?->furniture_condition;

    if ($furnitureCondition == 'semi-furnished') {
        $furnitureCondition = 'Semi Furnished';
    } elseif ($furnitureCondition == 'furnished') {
        $furnitureCondition = 'Furnished';
    } else {
        $furnitureCondition = 'Unfurnished';
    }

    return [
        'ads_id' => $ads->id,
        'title' => $ads->title,
        'slug' => $ads->slug,
        'description' => $ads->description,
        'property_id' => $ads->property?->id,
        'area' => $ads->property?->area,
        'ads_type' => $ads->property?->ads_type,
        'price' => $ads->property?->price,
        'formatted_price' => $ads->property?->formatted_price,
        'image' => $ads->featured?->original_url ?: 'https://via.placeholder.com/500',
        'year_built' => $ads->property?->year_built,
        'lt' => $ads->property?->lt,
        'lb' => $ads->property?->lb,
        'dl' => $ads->property?->dl,
        'jl' => $ads->property?->jl,
        'jk' => $ads->property?->jk,
        'jkm' => $ads->property?->jkm,
        'certificate' => $ads->property?->certificate,
        'housing_name' => $ads->property?->housing_name,
        'cluster_name' => $ads->property?->cluster_name,
        'apartment_type' => $ads->property?->apartment_type,
        'floor_location' => $ads->property?->floor_location,
        'furniture_condition' => $furnitureCondition,
        'house_facility' => json_decode($ads->property?->house_facility, true),
        'other_facility' => json_decode($ads->property?->other_facility, true),
        'video' => $ads->property?->video,
        'ofood_working_days' => json_decode($ads->ofood?->working_days, true),
        'omerchant_working_days' => json_decode($ads->omerchant?->working_days, true),
    ];
}
