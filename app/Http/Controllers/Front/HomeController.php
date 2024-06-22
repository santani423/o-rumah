<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\AdsProperty;
use App\Models\Banner;
use App\Models\Bank;
use App\Models\Kategori;
use App\Models\Lelang;
use App\Models\Media;
use App\Models\Kpr;
use App\Models\Job;
use App\Models\PropertyType;
use App\Models\User;
use App\Models\Food;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\UserClickAdsHistory;
use App\Models\LinkeAds;
use App\Models\KprFileBank;
use ZipArchive;
use Carbon\Carbon;
use App\Models\WebsiteAdsSection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\AdvertisingPointsManager;
use App\Services\ToolService;
use App\Services\PropertyRepository;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    use AdvertisingPointsManager;
    use PropertyRepository;
    use ToolService;
    /**
     * Retrieves data for the index page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $bannerLists = Banner::active()->where('show_on', 'homepage')->get();
        // dd($bannerLists);
        // $latestAdsLists = Ads::getLatestProperty();
        // $agentLists = User::getAgents(count: 6);
        $frontAdsLists = WebsiteAdsSection::query()
            ->where('slug', 'iklan-homepage-bawah-search')
            ->first();
        $propertyTypeLists = PropertyType::query()
            ->orderBy('id', 'ASC')
            ->pluck('name', 'name');
        $isLanding = true;

        debug($propertyTypeLists);
        $searchQuery = request()->input('search');
        $latitude = -6.1571072;
        $longitude = 106.774528;
        $radius = 300; // radius in kilometers

        $adsLists = $this->getAdsListsWithDistance($latitude, $longitude, $radius, $searchQuery);

        // dd($adsLists);
        return view('Pages/Frond/home', compact('bannerLists', 'adsLists'));
        // return Inertia::render('Front/Pages/HomePage', [
        //     'bannerLists' => $bannerLists,
        //     // 'latestAdsLists' => $latestAdsLists,
        //     // 'agentLists' => $agentLists,
        //     'frontAdsLists' => $frontAdsLists->content ?? [],
        //     'propertyTypeLists' => $propertyTypeLists,
        //     'isLanding' => $isLanding
        // ]);
    }

    /**
     * Returns the coming soon page.
     *
     * @return \Inertia\Response
     */
    public function comingSoon()
    {
        return Inertia::render('Front/Shared/ComingSoonPage');
    }

    /**
     * Returns the latest properties page.
     *
     * @return \Inertia\Response
     */
    public function latest(Request $request)
    {
        $searchQuery = request()->input('search');
        $adsLists = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->where('ads.type', 'property')
            ->select(
                "ads_properties.id",
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "ads.slug",
                "users.name as name_user",
                "ads_properties.*",
                "ads.status",
                "ads.id as ads_id",
                'media.id as media_id',
                'media.file_name as file_name',
                "ads.is_active"
            )

            ->where(function ($query) use ($searchQuery) {
                $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads_properties.ads_type', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('ads.id', 'desc')
            ->paginate(10);
        $bannerLists = Banner::active()->where('show_on', 'omerchant')->get();
        // dd($adsLists);
        return view('Pages/Frond/propertiBaru', compact('adsLists', 'bannerLists'));
        // dd($adsLists);

        // return Inertia::render('Front/Pages/LatestPage', [
        //     'adsLists' => $adsLists,
        //     'bannerLists' => $bannerLists,
        // ]);
    }

    /**
     * Returns the auction page.
     *
     * @return \Inertia\Response
     */
    public function auction(Request $request)
    {
        $searchQuery = request()->input('search');
        // $adsLists = Ads::getAllAds(paginate: 9, loadAgent: false, adsPropertyType: 'Lelang', filters: $request->all());
        $adsLists = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('user_lelang_properties', 'user_lelang_properties.ads_id', '=', 'ads.id')
            ->join('users', 'users.id', '=', 'user_lelang_properties.user_id')
            ->where('ads.type', 'lelang')
            ->select(
                "ads_properties.id",
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "ads.slug",
                "users.name as name_user",
                "users.name as username",
                "ads_properties.ads_type",
                "ads_properties.image",
                "ads_properties.price",
                "ads_properties.address",
                "ads_properties.*",
                "ads_properties.id as id_properti",
                "ads.status",
                "ads.id as ads_id",
                'media.id as media_id',
                'media.file_name as file_name',
                "ads.is_active",
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads_properties.ads_type', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('ads.id', 'desc')
            ->paginate(10);
        // dd($adsLists->items());
        $bannerLists = Banner::active()->where('show_on', 'auction')->get();
        return view('Pages/Frond/propertiLelang', compact('adsLists', 'bannerLists'));
    }

    /**
     * Returns the ofoods page.
     *
     * @return \Inertia\Response
     */
    public function ofoods(Request $request)
    {
        $searchQuery = request()->input('search');

        $adsLists = Food::join('ads', 'ads.id', '=', 'ofoods.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->where('ads.is_active', 1)
            ->select(  
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "users.name as name_user",
                "ads.status",
                "ads.is_active",
                "ads.id as ads_id",
                'media.id as media_id',
                'media.file_name as file_name',
                "ofoods.*",
                "ads.slug"
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('ads.id', 'desc')
            ->paginate(10)->items();
        ;
        // $bannerLists = Banner::active()->where('show_on', 'omerchant')->get();
        $bannerLists = Banner::where('show_on', 'food')->orderBy('order', 'asc')->active()->get();
        $kategori = Kategori::where('tipe', 'food')->join('sup_kategoris','sup_kategoris.kategori_id','=','kategoris.id')->select('sup_kategoris.*')->get();
        return view('Pages/Frond/OFoodPage', compact('adsLists', 'bannerLists', 'kategori'));
        // return Inertia::render('Front/Pages/OFoodPage', [
        //     'adsLists' => $adsLists,
        //     'bannerLists' => $bannerLists,
        //     'typeLike' => 'food'
        // ]);
    }
    function ofoodsByKategori(Request $request, $kategori = '')
    {


        return view('Pages/Frond/Food/ofoodsByKategori', compact('kategori'));
    }

    /**
     * Returns the omerchant page.
     *
     * @return \Inertia\Response
     */
    public function omerchant(Request $request)
    {
        $adsLists = Ads::join('omerchants', 'omerchants.ads_id', '=', 'ads.id')
            ->where('ads.is_active', 1)->paginate(100000);
        // $bannerLists = Banner::active()->where('show_on', 'omerchant')->get();
        $bannerLists = Banner::where('show_on', 'marchent')->orderBy('order', 'asc')->active()->get();


        
        $kategori = Kategori::where('tipe', 'food')->join('sup_kategoris','sup_kategoris.kategori_id','=','kategoris.id')->select('sup_kategoris.*')->get();

        return view('Pages/Frond/OMearchntPage', compact('adsLists', 'bannerLists', 'kategori'));
        // return Inertia::render('Front/Pages/OMerchantPage', [
        //     'adsLists' => $adsLists,
        //     'bannerLists' => $bannerLists,
        // ]);
    }

    function omerchantByKategori($kategori)
    {
        return view('Pages/Frond/Marchent/marchentByKategori', compact('kategori'));
    }
    public function lawHelper(Request $request)
    {
        $userLists = User::getAllLawHelper(paginate: 9, filters: $request->all());
        $bannerLists = Banner::active()->where('show_on', 'law-helper')->get();
        // dd($userLists);
        return view('Pages/Frond/LbhPage', compact('userLists', 'bannerLists'));
        // return Inertia::render('Front/Pages/LawHelperPage', [
        //     'userLists' => $userLists,
        //     'bannerLists' => $bannerLists,
        // ]);
    }

    /**
     * Returns the notaris page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Inertia\Response
     */
    public function notaris(Request $request)
    {
        $userLists = User::getAllNotaris(paginate: 9, filters: $request->all());
        $bannerLists = Banner::active()->where('show_on', 'notaris')->get();
        return view('Pages/Frond/NotarisPage', compact('userLists', 'bannerLists'));
        // return Inertia::render('Front/Pages/NotarisPage', [
        //     'userLists' => $userLists,
        //     'bannerLists' => $bannerLists,
        // ]);
    }

    /**
     * Returns the agent page.
     *
     * @params \Illuminate\Http\Request $request
     *
     * @return \Inertia\Response
     */
    public function agent(Request $request)
    {
        $userLists = User::getAllAgents(paginate: 9, filters: $request->all());
        $bannerLists = Banner::active()->where('show_on', 'agent')->get();
        return view('Pages/Frond/AgenPage', compact('userLists', 'bannerLists'));
        // return Inertia::render('Front/Pages/AgentPage', [
        //     'userLists' => $userLists,
        //     'bannerLists' => $bannerLists,
        // ]);
    }

    /**
     * Returns the agent detail page.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $username
     *
     * @return \Inertia\Response
     */
    public function agentDetail(Request $request, string $username)
    {
        $agent = User::getByUsername(username: $username, filters: $request->all());

        if (!$agent) {
            abort(404);
        }

        return Inertia::render('Front/Pages/AgentDetailPage', [
            'agent' => $agent,
        ]);
    }

    /**
     * Retrieves the property details.
     *
     * @param string $slug
     * @return \Inertia\Response
     */
    public function propertyDetail(Request $request, $slug)
    {
        $ads = Ads::where('ads.slug', $slug)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*', 'ads.id as ads_id')
            ->first();
        $media = Media::where('model_id', $ads->ads_id)->select('disk', 'file_name')->get()->map(function ($item) {
            return [
                'url' => $item->disk . '/' . $item->file_name
            ];
        });
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

        $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC007');

        if (Auth::user()) {
            $like = LinkeAds::where('user_id', Auth::user()->id)
                ->where('ads_id', $ads->ads_id)
                ->first();
        } else {
            $like = false;
        }

        $typeFood = 'properti';
        return view('Pages/Frond/Properti/detailProperti', compact('ads', 'slug', 'agent', 'like', 'typeFood', 'media'));

        // return Inertia::render('Front/Pages/PropertiDetailPage', [
        //     'ads' => $ads,
        //     'slug' => $slug,
        //     'agent' => $agent,
        //     'like' => $like,
        //     'typeFood' => $typeFood,
        //     'media' => $media
        // ]);
    }

    /**
     * Retrieves the auction details.
     *
     * @param string $slug
     * @return \Inertia\Response
     */
    public function auctionDetail(Request $request, $slug = '', $username = '')
    {
        $ads = Ads::where('ads.slug', $slug)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*', 'ads.id as ads_id')
            ->first();
        // Sample data that can be used with the provided code
        $media = Media::where('model_id', $ads->ads_id)->select('disk', 'file_name')->get()->map(function ($item) {
            return [
                'url' => $item->disk . '/' . $item->file_name
            ];
        });
        $auth = User::where('username', $username)->first();



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


        $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC007');

        if (Auth::user()) {
            $like = LinkeAds::where('user_id', Auth::user()->id)
                ->where('ads_id', $ads->ads_id)
                ->exists();
        } else {
            $like = false;
        }
        $typeFood = 'lelang';
        return view('Pages/Frond/Properti/detailPropertiLelang', compact('ads', 'slug', 'agent', 'like', 'typeFood', 'media'));
        // return Inertia::render('Front/Pages/AuctionDetailPage', [
        //     'ads' => $ads,
        //     'slug' => $slug,
        //     'agent' => $agent,
        //     'like' => $like,
        //     'typeFood' => 'lelang',
        //     'media' => $media
        // ]);
    }

    /**
     * Retrieves the ofood details.
     *
     * @param string $slug
     * @return \Inertia\Response
     */
    public function ofoodDetail(Request $request, $slug)
    {


        $ads = Ads::where('ads.slug', $slug)
            ->join('ofoods', 'ofoods.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ofoods.*', 'ads.id as ads_id')
            ->first();
        // Sample data that can be used with the provided code
        $media = Media::where('model_id', $ads->ads_id)->select('disk', 'file_name')->get()->map(function ($item) {
            return [
                'url' => $item->disk . '/' . $item->file_name
            ];
        });
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
        $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC007');
        if (Auth::user()) {
            $like = LinkeAds::where('user_id', Auth::user()->id)
                ->where('ads_id', $ads->ads_id)
                ->exists();
        } else {
            $like = false;
        }

        $typeFood = 'food';
        return view('Pages/Frond/Food/DetailFood', compact('ads', 'slug', 'agent', 'like', 'typeFood', 'media'));


        // You can use this sample data with the existing code to display images
        // return Inertia::render('Front/Pages/OFoodDetailPage', [
        //     'ads' => $ads,
        //     'slug' => $slug,
        //     'agent' => $agent,
        //     'like' => $like,
        //     'typeFood' => 'food',
        //     'media' => $media
        // ]);
    }

    /**
     * Retrieves the omerchant details.
     *
     * @param string $slug
     * @return \Inertia\Response
     */
    public function omerchantDetail(Request $request, $slug)
    {
        $ads = Ads::where('ads.slug', $slug)
            ->join('omerchants', 'omerchants.ads_id', '=', 'ads.id')
            ->select('ads.*', 'omerchants.*', 'ads.id as ads_id')
            ->first();
        // Sample data that can be used with the provided code
        $media = Media::where('model_id', $ads->ads_id)->select('disk', 'file_name')->get()->map(function ($item) {
            return [
                'url' => $item->disk . '/' . $item->file_name
            ];
        });
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
        $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC007');
        if (Auth::user()) {
            $like = LinkeAds::where('user_id', Auth::user()->id)
                ->where('ads_id', $ads->ads_id)
                ->exists();
        } else {
            $like = false;
        }

        $typeFood = 'marchent';
        return view('Pages/Frond/Food/DetailFood', compact('ads', 'slug', 'agent', 'like', 'typeFood', 'media'));

        // You can use this sample data with the existing code to display images
        // return Inertia::render('Front/Pages/OMerchantDetailPage', [
        //     'ads' => $ads,
        //     'slug' => $slug,
        //     'agent' => $agent,
        //     'like' => $like,
        //     'media' => $media
        // ]);
    }


    /**
     * A function that handles the registration of KPR.
     *
     * @param string $slug
     * @return \Inertia\Response
     */
    public function kprRegistration($slug)
    {
        $ads = Ads::getAdsBySlug($slug);

        return Inertia::render('Front/Pages/KprRegistrationPage', [
            'ads' => $ads,
            'slug' => $slug
        ]);
    }


    /**
     * Returns the profile page.
     *
     * @return \Inertia\Response
     */
    public function profile()
    {
        return Inertia::render('Front/Pages/ProfilePage')->with('info', 'Harap lengkapi profil anda');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|string|lowercase|email|max:100|unique:' . User::class . ',id,' . $request->id,
            'username' => 'required|string|lowercase|max:100|unique:' . User::class . ',id,' . $request->id,
            'bio' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'wa_phone' => 'nullable|string|max:20',
            'bank_number' => 'nullable|numeric',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 100 karakter',

            'email.required' => 'Email harus diisi',
            'email.string' => 'Email harus berupa teks',
            'email.lowercase' => 'Email harus dalam bentuk huruf kecil',
            'email.email' => 'Email harus valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah terdaftar, silakan coba lagi',

            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa teks',
            'username.lowercase' => 'Username harus dalam bentuk huruf kecil',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah terdaftar',

            'bio.max' => 'Bio maksimal 100 karakter',

            'phone.max' => 'Nomor telepon maksimal 20 karakter',

            'wa_phone.max' => 'Nomor WhatsApp maksimal 20 karakter',

            'bank_number.numeric' => 'Nomor rekening harus berupa angka',
        ]);

        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->bio = $request->bio;
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->wa_phone = $request->wa_phone;
            $user->company_name = $request->company_name;
            $user->bank_name = $request->bank_name;
            $user->bank_number = $request->bank_number;
            $user->update();

            if ($request->image != null) {
                $user->clearMediaCollection('profileAvatar');
                $user->addMedia($request->image)->toMediaCollection('profileAvatar');
                // dd($user->getFirstMediaUrl('profileAvatar'));

                $user->image = $user->getFirstMediaUrl('profileAvatar');
                $user->update();
            }

            if ($request->company_image != null) {
                $user->clearMediaCollection('companyAvatar');
                $user->addMedia($request->company_image)->toMediaCollection('companyAvatar');

                $user->company_image = $user->getFirstMediaUrl('companyAvatar');
                $user->update();
            }

            return redirect()->back()->with('success', 'Profil berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'old_password.required' => 'Password lama harus diisi',
            'old_password.string' => 'Password lama harus berupa teks',
            'old_password.min' => 'Password lama minimal 8 karakter',

            'password.required' => 'Password baru harus diisi',
            'password.string' => 'Password baru harus berupa teks',
            'password.min' => 'Password baru minimal 8 karakter',
            'password.confirmed' => 'Password baru tidak sesuai, silakan coba lagi',
        ]);

        try {
            $user = auth()->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai');
            }
            $user->password = bcrypt($request->password);
            $user->update();

            return redirect()->back()->with('success', 'Password berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Returns the wishlist page.
     *
     * @return \Inertia\Response
     */
    public function wishlist()
    {
        $adsLists = Ads::getFavoritedAds(paginate: 6);

        return Inertia::render('Front/Pages/WishlistPage', [
            'adsLists' => $adsLists,
        ]);
    }


    function linkKpr($slug)
    {
        $bank = Bank::get();
        $bankUmum = Bank::where('type', "umum")
            ->orderBy('province', 'asc')
            ->get()
            ->groupBy('province')
            ->map(function ($items, $province) {
                return [
                    'province' => $province,
                    'banks' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'alias_name' => $item->alias_name
                        ];
                    })
                ];
            });
        $bankBpr = Bank::where('type', "BPR")
            ->orderBy('province', 'asc')
            ->get()
            ->groupBy('province')
            ->map(function ($items, $province) {
                return [
                    'province' => $province,
                    'banks' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'alias_name' => $item->alias_name
                        ];
                    })
                ];
            });
        // dd($bankBpr);
        $ads = Ads::where('ads.slug', $slug)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*')
            ->first();
        $user = User::find($ads->user_id);
        $job = Job::get();
        $agent = [
            "id" => $user->id,
            "name" => $user->name,
            "joined_at" => $user->created_at->format('Y-m-d'),
            "username" => $user->username,
            "company_name" => $user->company_name,
            "company_image" => $user->company_image,
            "phone" => $user->phone,
            "wa_phone" => $user->wa_phone,
            "total_ads" => 100,
            "total_sold" => 50,
            "average_price" => "$500,000",
            "image" => $user->image,
        ];

        return view('Pages/Frond/Properti/Pengajuan/kpr', compact('bank', 'ads', 'user', 'job', 'bankBpr', 'bankUmum', 'agent'));

        // return Inertia::render('Front/Pages/Kpr/FormKpr', compact('bank', 'ads', 'user', 'job', 'bankBpr', 'bankUmum', 'agent'));
    }

    function linkKprStore(Request $request)
    {
        $validatedData = $request->validate([
            'ads_id' => 'required',
            'bankUmum' => 'required',
            'bankBpr' => 'required',
            'pekerjaan' => 'required',
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'noHp' => 'required|numeric',
            'agreement' => 'required|boolean',
            'imageSrc' => 'required|image',
            'imagekkSrc' => 'required|image',
            'fotoSuratNikahSrc' => 'required|image',
            'fotoRekeningKoranSrc' => 'required|image',
            'fotoSlipGajiSrc' => 'required|image'
        ], [
            'required' => ':attribute harus diisi.',
            'email' => ':attribute harus berupa email yang valid.',
            'numeric' => ':attribute harus berupa angka.',
            'image' => ':attribute harus berupa file gambar.',
            'boolean' => ':attribute harus berupa nilai benar atau salah.'
        ]);
        $userId = null;

        $user = auth()->user();
        if ($user) {
            $userId = $user->id;
        }
        // Menyimpan setiap gambar dan mengembalikan path penyimpanannya

        $timestamp = now()->format('Y_m_d');
        $job = Job::find($request->pekerjaan);
        $kpr = new Kpr();
        $kpr->ads_id = $request->ads_id;
        $kpr->user_id = $userId;
        $kpr->bank_id = $request->bankUmum;
        $kpr->agreement = $request->agreement;
        $kpr->bank_bpr_id = $request->bankBpr;
        $kpr->job_id = $request->pekerjaan;
        $kpr->kpr_name = $request->namaLengkap;
        $kpr->kpr_email = $request->email;
        $kpr->kpr_phone = $request->noHp;
        $kpr->kpr_occupation = $job->title;
        $kpr->save();
        $kpr->uuid = 'KPR' . date('Ymd') . str_pad(Kpr::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
        $kpr->save();
        $kpr->image_ktp = str_replace('public/', '/storage/', $request->file('imageSrc')->store('public/images/kpr/' . $timestamp . '/' . $kpr->id));

        $kpr->image_kk = str_replace('public/', '/storage/', $request->file('imagekkSrc')->store('public/images/kpr/' . $timestamp . '/' . $kpr->id));

        // Jika Anda ingin menyimpan image_npwp dengan cara yang sama, uncomment dan sesuaikan baris berikut:
        // $kpr->image_npwp = str_replace('public/', '/storage/', $request->file('imageNpwpSrc')->store('public/images/kpr/' . $timestamp . '/' . $kpr->id));

        $kpr->image_surat_nikah = str_replace('public/', '/storage/', $request->file('fotoSuratNikahSrc')->store('public/images/kpr/' . $timestamp . '/' . $kpr->id));

        $kpr->image_rekening_koran = str_replace('public/', '/storage/', $request->file('fotoRekeningKoranSrc')->store('public/images/kpr/' . $timestamp . '/' . $kpr->id));

        $kpr->image_slip_gaji = str_replace('public/', '/storage/', $request->file('fotoSlipGajiSrc')->store('public/images/kpr/' . $timestamp . '/' . $kpr->id));
        // $kpr->status = $request->status;
        // $kpr->history = $request->history;

        $kpr->save();
        return redirect(route('member.pengajuan.kpr'));
        // Mengembalikan response sukses
        // return response()->json([
        //     'message' => 'Data berhasil disimpan',
        //     'request' => $request->all(),
        //     'job' => $job
        // ]);
    }

    function kprFormFinish()
    {

    }


    function linkAuction($slug, $username)
    {
        $bank = Bank::get();
        $bankUmum = Bank::where('type', "umum")
            ->orderBy('province', 'asc')
            ->get()
            ->groupBy('province')
            ->map(function ($items, $province) {
                return [
                    'province' => $province,
                    'banks' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'alias_name' => $item->alias_name
                        ];
                    })
                ];
            });
        $bankBpr = Bank::where('type', "BPR")
            ->orderBy('province', 'asc')
            ->get()
            ->groupBy('province')
            ->map(function ($items, $province) {
                return [
                    'province' => $province,
                    'banks' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'alias_name' => $item->alias_name
                        ];
                    })
                ];
            });
        // dd($bankBpr);
        $ads = Ads::where('ads.slug', $slug)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*')
            ->first();
        // dd($ads);
        $user = User::where('username', $username)->first();
        $job = Job::get();
        $agent = [
            "name" => $user->name,
            "joined_at" => $user->created_at->format('Y-m-d'),
            "username" => $user->username,
            "company_name" => $user->company_name,
            "company_image" => $user->company_image,
            "phone" => $user->phone,
            "wa_phone" => $user->wa_phone,
            "total_ads" => 100,
            "total_sold" => 50,
            "average_price" => "$500,000",
            "image" => $user->image,
        ];
        return view('Pages/Frond/Properti/Pengajuan/formLelang', compact('bank', 'ads', 'user', 'job', 'bankBpr', 'bankUmum', 'agent'));
        // return Inertia::render('Front/Pages/Auction/FormAuction', compact('bank', 'ads', 'user', 'job', 'bankBpr', 'bankUmum', 'agent'));
    }

    function linkLelangStore(Request $request)
    {
        // Menambahkan validasi untuk input yang diterima
        $validatedData = $request->validate([
            'ads_id' => 'required|integer',
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'noHp' => 'required|numeric',
            'agreement' => 'required|boolean',
            'imageSrc' => 'required|image'
        ], [
            'required' => ':attribute harus diisi.',
            'integer' => ':attribute harus berupa angka.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'email' => ':attribute harus berupa email yang valid.',
            'numeric' => ':attribute harus berupa nomor.',
            'boolean' => ':attribute harus berupa nilai benar atau salah.',
            'image' => ':attribute harus berupa file gambar.'
        ]);
        $userId = null;

        $user = auth()->user();
        if ($user) {
            $userId = $user->id;
        }
        // Menyimpan setiap gambar dan mengembalikan path penyimpanannya

        $timestamp = now()->format('Y_m_d');
        $lelang = new Lelang();
        $lelang->ads_id = $request->ads_id;
        $lelang->agen_id = $request->agen_id;
        $lelang->user_id = $userId;
        $lelang->agreement = $request->agreement;
        $lelang->kpr_name = $request->namaLengkap;
        $lelang->kpr_email = $request->email;
        $lelang->kpr_phone = $request->noHp;
        $lelang->save();
        $lelang->uuid = 'llg' . date('Ymd') . str_pad(Lelang::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
        $lelang->save();
        $lelang->image_ktp = str_replace('public/', '/storage/', $request->file('imageSrc')->store('public/images/kpr/' . $timestamp . '/' . $lelang->id));

        $lelang->save();
        return redirect(route('member.pengajuan.lelang'));
        // Mengembalikan response sukses
        // return response()->json([
        //     'message' => 'Data berhasil disimpan',
        //     'request' => $request->all()
        // ]);
    }

    function aboutAs()
    {
        return view('Pages.aboutAs');
    }
}
