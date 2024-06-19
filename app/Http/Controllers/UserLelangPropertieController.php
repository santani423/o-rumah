<?php

namespace App\Http\Controllers;

use App\Models\UserLelangPropertie;
use Illuminate\Http\Request;
use App\Models\AdsProperty;
use App\Models\Ads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\AdvertisingPointsManager;

class UserLelangPropertieController extends Controller
{
    use AdvertisingPointsManager;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserLelangPropertie $userLelangPropertie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserLelangPropertie $userLelangPropertie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserLelangPropertie $userLelangPropertie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserLelangPropertie $userLelangPropertie)
    {
        //
    }

    public function takeAuction(Request $request)
    {
        // Contoh data yang mungkin ingin Anda kirim sebagai respons JSON
        $auth = Auth::user();
        $properti = AdsProperty::find($request->properti_id);
        $add = UserLelangPropertie::where('user_id', $auth->id)
            ->where('property_id', $properti->id)
            ->where('ads_id', )->first();
        $add = new UserLelangPropertie();
        $add->user_id = $auth->id;
        $add->property_id = $properti->id;
        $add->ads_id = $properti->ads_id;
        $add->save();
        $ads = Ads::where('ads.id', $properti->ads_id)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*')
            ->first();

        $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC008');

        $data = [
            'success' => true,
            'user' => $auth,
            'properti' => $properti,
            'message' => 'Auction taken successfully',
            'data' => $request->all() // Mengembalikan semua input yang diterima
        ];

        return response()->json($data);
    }


}
