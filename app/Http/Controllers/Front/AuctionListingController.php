<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuctionListingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        $ads = Ads::query()
            ->with('property', 'media')
            ->whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->whereHas('property', function ($query) {
                $query->where('ads_type', 'Lelang')->orWhere('ads_type', 'lelang');
            })
            // append property
            ->paginate(5);

        return Inertia::render('Listing/Auction/AuctionListingPage', [
            'ads' => $ads
        ]);
    }

    public function update(Request $request, $adsId)
    {

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        $action = $request->get('action');
        $ads = Ads::find($adsId);

        if ($action == 'bid') {
            $ads->update([
                'is_active' => true
            ]);

            // add to auctions
            $user->adsAuctions()->attach($ads);

            session()->flash('success', 'Lelang berhasil dibuka!');
        } else if ($action == 'activate') {
            $ads->update([
                'is_active' => true
            ]);

            session()->flash('success', 'Lelang berhasil diaktifkan!');
        } else if ($action == 'deactivate') {
            $ads->update([
                'is_active' => false
            ]);

            session()->flash('success', 'Lelang berhasil dinonaktifkan!');
        }
    }
}
