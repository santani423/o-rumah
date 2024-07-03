<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;
use App\Models\Districts;
use App\Models\Ads;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Services\FoodService;
use App\Services\MarchantService;

use App\Services\PropertyRepository;
use Illuminate\Support\Facades\DB;

class ToolController extends Controller
{

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
        $radius = 300; // default radius of 300 if not provided
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 10);
        $adsLists = $this->getAdsListsWithDistance($latitude, $longitude, $radius, $searchQuery, $perPage,$page);
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
        $radius = $request->input('radius', 300); // default radius of 300 if not provided
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 10);
        $adsLists = $this->getAdsListsWithDistanceBoosterHome($latitude, $longitude, $radius, $searchQuery, $perPage,$page);
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
    }

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}

}
