<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ads;

class MemberToolController extends Controller
{
    function cekUniqueTitleAds(Request $request)
    {
        $ads = Ads::where("title", $request->adds)->first(); // Mengubah $request->adds menjadi $request->title
        $isUnique = $ads ? false : true; // Mengubah logika untuk mengecek keunikan judul
        return response()->json([
            'success' => true,
            'isUnique' => $isUnique, // Mengubah 'ads' menjadi 'isUnique' 
            'message' => $isUnique ? 'Judul unik.' : 'Judul sudah digunakan.', // Pesan berdasarkan keunikan judul
        ]);
    }

    function foodSetActive(Request $request)
    {
        $ads = Ads::whereId($request->id)->first();
        $ads->is_active = $request->is_active;
        $ads->save();
        return response()->json([
            'success' => true,
            'request' => $request->all(),
            'message' => 'oke',
            'ads' => $ads,
        ]);
    }
}
