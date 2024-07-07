<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;
use App\Models\Districts;
use App\Models\Ads;
use App\Services\AdvertisingPointsManager;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Services\FoodService;
use App\Services\MarchantService;

use App\Services\PropertyRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\District;

class ToolController extends Controller
{
    use AdvertisingPointsManager;
    use FoodService;
    use PropertyRepository;
    use MarchantService;
    public function searchAds(Request $request)
    {
        $query = $request->input('search'); // asumsikan inputan pencarian disimpan dalam parameter 'query'
        $results = DB::table('id_districts')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('code', 'like', '%' . $query . '%')
                    ->orWhere('city_code', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%');
            })
            ->where('meta', '!=', null)
            ->get();

        return response()->json($results);
    }
    public function showDistirct(Request $request)
    {
        $query = $request->input('code'); // asumsikan inputan pencarian disimpan dalam parameter 'query'

        $results = DB::table('id_districts') // ganti 'nama_tabel' dengan nama tabel yang sesuai
            ->where('code', $query)->where('meta', '!=', null)->first();

        return response()->json($results);
    }

    function selectKabupatenKota(Request $request)
    {
        $Cities = Cities::where('province_code', $request->code)->orderBy('name', 'asc')->get();
        $html = '';
        foreach ($Cities as $key => $cts) {
            $html .= '<option value="' . $cts->code . '">' . $cts->name . '</option>';
        }
        return $html;
    }

    function kecamatanSelect(Request $request)
    {
        $Districts = Districts::where('city_code', $request->code)->orderBy('name', 'asc')->get();
        $html = '';
        foreach ($Districts as $key => $data) {
            $html .= '<option value="' . $data->code . '">' . $data->name . '</option>';
        }
        return $html;
    }

    function cekJudul(Request $request)
    {
        $ads = Ads::where('title', $request->judulIklan)->first();

        if ($ads) {
            return response()->json(['message' => 'Judul iklan sudah digunakan.', 'available' => false]);
        } else {
            return response()->json(['message' => 'Judul iklan tersedia.', 'available' => true]);
        }
    }

    function adsListsWithDistance(Request $request)
    {
        // dd($request);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $ads_type = $request->input('ads_type');
        $radius = 300; // default radius of 300 if not provided
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 10);
        $adsLists = $this->getAdsListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage,$page,$ads_type);
        // return response()->json(['adsLists' => $adsLists]);
        // return 'ok';
        // dd($adsLists);
        // dd($request->all());
        return view('Pages/Tool/Property/getAdsListsWithDistance', compact('adsLists'));
    }
    function adsListsWithDistanceBoosterHome(Request $request)
    {
        // dd($request);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $ads_type = $request->input('ads_type');
        $radius = $request->input('radius', 300); // default radius of 300 if not provided
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 10);
        $adsLists = $this->getAdsListsWithDistanceBoosterHome($latitude, $longitude, $radius, $searchQuery, $perPage,$page,$ads_type);
        // dd($adsLists);
        // return response()->json(['adsLists' => $adsLists]);
        // return 'ok';
        
        return view('Pages/Tool/Property/getAdsListsWithDistance', compact('adsLists'));
    }
    function adsListsWithDistanceBoosterSundul(Request $request)
    {
        // dd($request);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 300); // default radius of 300 if not provided
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 10);
        $adsLists = $this->getAdsListsWithDistanceBoosterHome($latitude, $longitude, $radius, $searchQuery, $perPage,$page,'PTYSDL');
        // dd($adsLists);
        // return response()->json(['adsLists' => $adsLists]);
        // return 'ok';
        
        return view('Pages/Tool/Property/getAdsListsWithDistance', compact('adsLists'));
    }

    function tes()
    {
        $Ads = Ads::whereMonth('created_at', Carbon::now()->month)->count();
        $uuid = (string) Str::orderedUuid();
        $num = str_pad(4, 5, '0', STR_PAD_LEFT);
        echo $uuid;
        $base36Chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $base36Chars[rand(0, 35)];
        }
        dd($num);
    }

    function getFoodListsWithDistance(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 10);
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $kategori = strval($request->input('kategori', ''));

        $adsLists = $this->getAdsFoodListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage, $kategori);

        return view('Pages/Tool/Food/getAdsFoodListsWithDistance', compact('adsLists'));
    }

    function getMarchantListsWithDistance(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 10);
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $kategori = strval($request->input('kategori', ''));
        $adsLists = $this->getAdsMarchantListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage, $kategori);


        return view('Pages/Tool/Marchnet/getAdsMarchentListsWithDistance', compact('adsLists'));
    }

    public function toggleStatus(Request $request)
{
    $adsId = $request->input('ads_id');
    $ad = Ads::whereId($adsId)->first();
    // dd($ad);
    if ($ad) {
        $ad->is_active = $ad->is_active ? 0 : 1;
        $ad->save();
        if($ad->is_active){
            $auth = Auth::user();
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
    
            $this->manageAdvertisingPoints($request, $ad, $auth, 'ABC010');
        }
    }

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}
public function searchDistricts(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query untuk mencari distrik berdasarkan keyword
        $districts = District::with('city.province')
                            ->where('name', 'LIKE', '%' . $keyword . '%')
                            ->orWhereHas('city', function($query) use ($keyword) {
                                $query->where('name', 'LIKE', '%' . $keyword . '%');
                            })
                            ->orWhereHas('city.province', function($query) use ($keyword) {
                                $query->where('name', 'LIKE', '%' . $keyword . '%');
                            })
                            ->get();

        // Mengubah hasil menjadi format Provinsi-Kota-Distrik
        $result = $districts->map(function($district) {
            return [
                'id' => $district->id,
                'name' => $district->city->province->name . '-' . $district->city->name . '-' . $district->name
            ];
        });

        return response()->json($result);
    }
}
