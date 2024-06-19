<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Media;
use App\Models\Food;
use App\Models\Merchant;
use App\Models\WorkingDays;
use Illuminate\Support\Facades\Storage;

class MarchantsController extends Controller
{
    function merchantsStroe(Request $request)
    {


        $user = Auth::user();
        $ads = new Ads();
        $ads->title = $request->adds;
        $ads->slug = $request->slug;
        $ads->description = $request->description;
        $ads->type = 'marchant';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = $request->isActive ? 1 : 0;
        $ads->is_archived = $request->isrchived ? 1 : 0;
        $ads->status = 'available';
        $ads->save();


        $Merchant = new Merchant();
        $Merchant->ads_id = $ads->id;
        $Merchant->district = $request->district;
        $Merchant->districtId = $request->districtId;
        $Merchant->districtLocation_lat = $request->districtLocationLat;
        $Merchant->districtLocation_long = $request->districtLocationLong;
        $Merchant->kawasan = $request->kawasan;
        $Merchant->alamat = $request->alamat;
        $Merchant->working_days = '[]';
        $Merchant->save();


        // Proses menyimpan gambar

        if ($request->hasFile('uploadedImages')) {
            foreach ($request->file('uploadedImages') as $image) {
                $path = $image->store('/images/food/' . $ads->id, 'public');
                $imageUrl = Storage::url($path);

                $media = new Media();
                $media->model_type = 'App\\Models\\Food';
                $media->model_id = $ads->id;
                $media->collection_name = 'images';
                $media->name = $image->getClientOriginalName();
                $media->file_name = basename($path);
                $media->manipulations = '[]';
                $media->custom_properties = '[]';
                $media->generated_conversions = '[]';
                $media->responsive_images = '[]';
                $media->mime_type = $image->getClientMimeType();
                $media->disk = '/storage/images/food/' . $ads->id; // Ganti disk sesuai konfigurasi storage

                $media->size = $image->getSize();
                $media->save();
            }
        }
        $Merchant->image = $media->disk . '/' . $media->file_name;
        $Merchant->save();
        return response()->json([
            'message' => 'Data received successfully',
            'request' => $request->all(),
            'data' => [
                'title' => $request->Adds,
                'slug' => $request->Slug,
                'description' => $request->Description,
            ]
        ], 200);
    }
}
