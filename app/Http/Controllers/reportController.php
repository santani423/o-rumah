<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingPoints;
use App\Models\ViewAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reportController extends Controller
{
    public function filter(Request $request)
    {
        // Ambil input tanggal, null jika tidak ada
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $adsId = $request->input('adsId'); // Ambil adsId dari request

        // Query dasar
        $reportAds = AdvertisingPoints::where('advertising_points.ads_id', $adsId)
            ->join('view_ads', 'view_ads.advertising_points_id', '=', 'advertising_points.id')
            ->select(
                DB::raw('DATE(view_ads.created_at) as date'),
                DB::raw('COUNT(view_ads.id) as total_ads')
            );

        // Jika start_date dan end_date tidak null, tambahkan whereBetween
        if ($startDate && $endDate) {
            $reportAds = $reportAds->whereBetween('view_ads.created_at', [$startDate, $endDate]);
        }

        // Grouping dan pengurutan
        $reportAds = $reportAds->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Mengonversi hasil query menjadi format yang diinginkan untuk chartData
        $chartData = $reportAds->map(function ($item) {
            return [
                'date' => $item->date,          // Menggunakan field 'date'
                'views' => (int) $item->total_ads // Menggunakan field 'view'
            ];
        })->toArray();

        // Mengembalikan data dalam format JSON untuk AJAX
        return response()->json($chartData);
    }
}
