<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ads;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Media;
use App\Models\Food;
use App\Models\WorkingDays;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    function foodStroe(Request $request)
    {



        $user = Auth::user();
        $ads = new Ads();
        $ads->title = $request->adds;
        $ads->slug = $request->slug;
        $ads->description = $request->description;
        $ads->type = 'food';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = $request->isActive ? 1 : 0;
        $ads->is_archived = $request->isrchived ? 1 : 0;
        $ads->status = 'available';
        $ads->save();



        $food = new Food();
        $food->ads_id = $ads->id;
        $food->district = $request->district;
        $food->districtId = $request->districtId;
        $food->districtLocation_lat = $request->districtLocationLat;
        $food->districtLocation_long = $request->districtLocationLong;
        $food->kawasan = $request->kawasan;
        $food->alamat = $request->alamat;
        $food->working_days = '[]';
        $food->save();


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
        $food->image = $media->disk . '/' . $media->file_name;
        $food->save();
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

