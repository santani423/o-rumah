<?php

namespace App\Http\Controllers;

use App\Models\TitipAds;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TitipAdsController extends Controller
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
        $titipAd = new TitipAds();
        $titipAd->ads_id = $request->input('ads_id');
        $titipAd->user_owner_id = $request->input('user_owner_id');
        $titipAd->user_receiver_id = $request->input('user_receiver_id');
        $titipAd->status = 'pending';
        $titipAd->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TitipAds $titipAds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TitipAds $titipAds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TitipAds $titipAds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitipAds $titipAds)
    {
        //
    }
}
