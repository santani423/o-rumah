<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\bosterAds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BosterAdsController extends Controller
{
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
        $auth = Auth::user();
        $BosterAds = BosterAds::where('booster_type_id', $request->booster_id)
        ->where('ads_id', $request->ads_id)
        ->where('user_id', $auth->id)
        ->count();
        
        $property = Ads::whereId($request->ads_id)->first();
       
        $bosterAds= new bosterAds();
        $bosterAds->booster_type_id = $request->booster_id;
        $bosterAds->user_id = $auth->id;
        $bosterAds->ads_id = $request->ads_id;
        $bosterAds->urutan = ++$BosterAds;
        $bosterAds->title = $property->title;
        $bosterAds->save();

        return redirect(route('listing.control-panel.view.property',$property->slug).'?navLink=booster')->with(['success'=>'Booster berhasil di terapkan']);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(bosterAds $bosterAds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bosterAds $bosterAds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bosterAds $bosterAds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bosterAds $bosterAds)
    {
        //
    }
}
