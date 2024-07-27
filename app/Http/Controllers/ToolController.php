<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;
use App\Models\Districts;
use App\Models\Ads;
use App\Models\User;
use App\Models\UserLelangPropertie;
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
        $html .= '<option value="">Pilih Kabupaten / Kota</option>';
        foreach ($Cities as $key => $cts) {
            $html .= '<option value="' . $cts->code . '">' . $cts->name . '</option>';
        }
        return $html;
    }

    function kecamatanSelect(Request $request)
    {
        $Districts = Districts::where('city_code', $request->code)->orderBy('name', 'asc')->get();
        $html = '';
        $html .= '<option value="">Pilih Kecamatan</option>';
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
        $adsLists = $this->getAdsListsWithDistanceBoosterHome($latitude, $longitude, $radius, $searchQuery, $perPage,$page,'PTYHOME');
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
    function adsListsWithDistanceBoosterEksklusif(Request $request)
    {
        // dd($request);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 300); // default radius of 300 if not provided
        $searchQuery = $request->input('searchQuery', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 10);
        $adsLists = $this->getAdsListsWithDistanceBoosterHome($latitude, $longitude, $radius, $searchQuery, $perPage,$page,'PTYESKL');
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
        $lelangId = $request->input('user_lelang_properties_id');
        $auth = Auth::user();
    
        // Menggunakan Eloquent untuk mencari iklan berdasarkan ID
        $ad = Ads::find($adsId);
        $userLelang = UserLelangPropertie::find($lelangId);
    
        if (!$ad) {
            return redirect()->back()->with('error', 'Ad not found!');
        }
    
        // Mengubah status iklan dan menyimpan perubahan
        if ($lelangId) {
            if (!$userLelang) {
                return redirect()->back()->with('error', 'Lelang Property not found!');
            }
            $userLelang->is_active = !$userLelang->is_active;
            $userLelang->save();
            if ( $userLelang->is_active) {
                $this->manageAdvertisingPoints($request, $ad, $auth, 'ABC010');
            }
        } else {
            $ad->is_active = !$ad->is_active;
            $ad->save();
        }
        // Memproses logika poin iklan jika iklan diaktifkan
      
        if ($ad->is_active) {
            $this->manageAdvertisingPoints($request, $ad, $auth, 'ABC010');
        }
    
        return redirect()->back()->with('status', 'Ad status updated successfully!');
    }
    
public function searchDistricts(Request $request)
    {
        $keyword = $request->input('keyword');
        // return response()->json($keyword);
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
        // dd($districts);

        // Mengubah hasil menjadi format Provinsi-Kota-Distrik
        $result = $districts->map(function($district) {
            return [
                'id' => $district->id,
                'name' => $district->city->province->name . '-' . $district->city->name . '-' . $district->name,
                'meta'=>$district->meta
            ];
        });

        return response()->json($result);
    }

    public function cekUsername(Request $request)
    {
        $username = $request->input('username');
        
        // Cek jika username mengandung spasi
        if (strpos($username, ' ') !== false) {
            $username = str_replace(' ', '', $username); // Hapus semua spasi dari username
        }
        
        $user = User::where('username', $username)->first();
        if ($user) {
            $references = $this->generateUsernameReferences($username);
            return response()->json(['exists' => true, 'references' => $references]);
        } else {
            return response()->json(['exists' => false, 'user' => $user, 'username' => $username]);
        }
    }

    private function generateUsernameReferences($username)
{
    $references = [];
    for ($i = 1; $i <= 4; $i++) {
        $newUsername = $username . mt_rand(11, 9999); // Menggabungkan username asli dengan angka acak antara 11 dan 9999
        while (User::where('username', $newUsername)->exists()) {
            $newUsername = $username . mt_rand(11, 999); // Pastikan username baru unik
        }
        $references[] = $newUsername;
    }
    return $references;
}

function searchAgnet(Request $request) {
    $keyword = $request->input('keyword');

        $agents = User::where('username', 'LIKE', '%' . $keyword . '%')->get();

        return response()->json($agents);
}

function order(Request $request){
   
    $ads = Ads::whereId($request->adsId)->first();
    // dd($request->all());
    $auth = User::whereId($ads->user_id)->first();
    // dd($ads);
    $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC015');
    return response()->json([
        'success' => true,                  // Indicates the request was successful
        'message' => 'Order has been processed successfully!',
        'data' => $request->all()              // Include the data received from the request
    ]);
}

function simulatorKpr()  {
    return view('pages.simulatorKpr');
}

}
