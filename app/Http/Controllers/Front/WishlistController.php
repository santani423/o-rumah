<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ads_id' => 'required|exists:ads,id',
        ], [
            'ads_id.required' => 'Iklan harus diisi',
            'ads_id.exists' => 'Iklan tidak ditemukan',
        ]);

        User::addFavoritedAds($request->ads_id);
    }

    public function destroy(Request $request)
    {
        User::removeFavoritedAds($request->adsIds);
    }
}
