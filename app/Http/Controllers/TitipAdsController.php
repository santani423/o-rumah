<?php

namespace App\Http\Controllers;

use App\Models\TitipAds;
use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\AdsProperty;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AdvertisingPointsManager;

class TitipAdsController extends Controller
{
    use AdvertisingPointsManager;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $titipAds = TitipAds::with(['owner', 'receiver'])->where('ads_id',$request->adsId)->get(); // Pastikan Anda telah mendefinisikan relasi `owner` dan `receiver` di model TitipAd

        return response()->json($titipAds);
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
    public function update(Request $request, $id)
    {
        $titpAds = TitipAds::findOrFail($id);
        $titpAds->status = $request->status;
        $titpAds->save();
    
        if ($request->status == 'approval') {
            $ads = Ads::whereId($titpAds->ads_id)->first();
            $newAd = $ads->replicate();
            // Generate unique title and slug
            $baseTitle = $ads->title . 'cpy'.rand(99, 9999);
            $baseSlug = $ads->slug . 'cpy'.rand(99, 9999);
    
            $newAd->title = $baseTitle;
            $newAd->slug = $baseSlug;
    
            $suffix = 1;
            while (Ads::where('title', $newAd->title)->exists() || Ads::where('slug', $newAd->slug)->exists()) {
                $newAd->title = $baseTitle . '-' . $suffix;
                $newAd->slug = $baseSlug . '-' . $suffix;
                $suffix++;
            }
    
            $newAd->save();
    
            $newAd->user_id = Auth::user()->id;
            $titpAds->new_ads_id = $newAd->id;
            $titpAds->save();
            // Duplicate AdsProperty
            $adsProperty = AdsProperty::where('ads_id', $ads->id)->first();
            if ($adsProperty) {
                $newAdsProperty = $adsProperty->replicate();
                $newAdsProperty->ads_id = $newAd->id;
                $newAdsProperty->save();
            }
    
            // Duplicate Media
            $media = Media::where('model_id', $ads->id)->get();
            foreach ($media as $value) {
                $newMedia = $value->replicate();
                $newMedia->model_id = $newAd->id;
                $newMedia->save();
            }
            $auth = User::find($ads->user_id);
            $agent = [
                "id" => $auth->id,
                "name" => $auth->name,
                "joined_at" => $auth->created_at->format('Y-m-d'),
                "username" => $auth->username,
                "company_name" => $auth->company_name,
                "company_image" => $auth->company_image,
                "phone" => $auth->phone,
                "wa_phone" => $auth->wa_phone,
                "total_ads" => 100,
                "total_sold" => 50,
                "average_price" => "$500,000",
                "image" => $auth->image,
            ];
    
            $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC014');
            session()->flash('status', 'Iklan berhasil di pasang');
            session()->flash('alert-class', 'alert-success');
        } else if ($request->status == 'reject') {
            session()->flash('status', 'Iklan di tolak');
            session()->flash('alert-class', 'alert-danger');
        }
    
        return back();
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitipAds $titipAds)
    {
        //
    }
}
