<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Lelang;
use App\Models\LinkeAds;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Models\Transaksi;
use App\Models\PlansTransaksi;
use App\Models\Kpr;
use App\Models\AdBalaceControl;
use App\Models\UserLelangPropertie;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Ads;
use App\Models\Media;
use App\Models\KategoriFood;
use App\Models\KategoriMarchent;
use App\Models\AdsProperty;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\AdvertisingPointsManager;
use App\Services\PropertyRepository;
use App\Services\KodeService;

use Illuminate\Support\Facades\DB;

class MemberNavController extends Controller
{
    use AdvertisingPointsManager;
    use PropertyRepository;
    use KodeService;
    function plans()
    {
        $plans = DB::table('plans')->orderBy('name', 'asc')
            ->paginate(10)->items();
        return view('Pages/ControlPanel/Member/Plan/index', ['plans' => $plans]);
    }
    function food(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        $filters = $request->all();

        // $ads = Ads::query()
        //     ->with('ofood', 'media')
        //     ->where('user_id', $user->id)
        //     ->latest()
        //     ->when(count($filters) > 0, function ($query) use ($filters) {
        //         $query
        //             ->whereHas('ofood', function ($q) use ($filters) {
        //                 if (array_key_exists('query', $filters) && $filters['query']) {
        //                     $q
        //                         ->where('title', 'like', $filters['query'] . '%')
        //                         ->orWhere('area', 'like', $filters['query'] . '%')
        //                         ->orWhere('address', 'like', $filters['query'] . '%');
        //                 }
        //             });
        //     })
        //     ->paginate(5);

        $ads = Ads::where('user_id', $user->id)->join('ofoods', 'ofoods.ads_id', '=', 'ads.id')->paginate(100000);

        // dd($ads->items());

        /* $ads->getCollection()->transform(
            function ($ads) {
                $data = [
                    ...mapAds($ads),
                ];
`
                return $data;
            }
        ); */

        return view('Pages/ControlPanel/Member/Food/index', ['food' => $ads->items(), 'url' => 'member.food.create-listing']);
        // return Inertia::render('Member/Page/FoodAndMarchant/Index', ['ads' => $ads->items(), 'url' => 'member.food.create-listing']);
    }
    function merchants(Request $request)
    {
        $user = Auth::user();




        $ads = Ads::where('user_id', $user->id)->join('omerchants', 'omerchants.ads_id', '=', 'ads.id')->paginate(100000);
        return view('Pages/ControlPanel/Member/Merchant/index', ['merchant' => $ads->items(), 'url' => 'member.food.create-listing']);
        // return Inertia::render('Member/Page/FoodAndMarchant/Index', ['ads' => $ads->items(), 'url' => 'member.merchants.create-listing']);
    }

    function listBank($slug = '')
    {
        $bank = Bank::paginate(10)->items();
        return Inertia::render('Member/Page/Plans/LisBank', ['bank' => $bank, 'slug' => $slug]);
    }

    function paymentMessage($slug = '')
    {
        $user = Auth::user();
        $plan = DB::table('plans')->where('slug', $slug)->first();
        // dd($plan);
        // Jika plan ditemukan
        $formattedPrice = 'Rp';



        if ($plan) {
            // Mengubah nilai price menjadi format rupiah (Rp)
            $ppn = $plan->price * 0.11;
            $total = $plan->price + $ppn;
            $formattedPrice = 'Rp ' . number_format($plan->price, 0, ',', '.');
            $formattedPricePPN = 'Rp ' . number_format($ppn, 0, ',', '.');
            $formattedPriceTotal = 'Rp ' . number_format($total, 0, ',', '.');
        } else {
        }
        // $poin = AdBalance::where('id', 68)->first();
        // dd($poin);
        return view('Pages/ControlPanel/Member/Plan/paymentMessage', [
            'formattedPrice' => $formattedPrice,
            'formattedPricePPN' => $formattedPricePPN,
            'formattedPriceTotal' => $formattedPriceTotal,
            'total' => $total,
            'plan' => $plan,
            'user' => $user,
            'slug' => $slug
        ]);
        // return Inertia::render('Member/Page/Plans/PaymentMessage', [
        //     'formattedPrice' => $formattedPrice,
        //     'formattedPricePPN' => $formattedPricePPN,
        //     'formattedPriceTotal' => $formattedPriceTotal,
        //     'total' => $total,
        //     'plan' => $plan,
        //     'user' => $user,
        //     'slug' => $slug
        // ]);
    }

    function invoice($transactionId = '')
    {
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.id', $transactionId)
            ->first();
        // dd($transaksi);
        return view('Pages/ControlPanel/Member/Transaksi/invoice', ['transaksi' => $transaksi, 'slug' => 'apem']);
        // return Inertia::render('Member/Page/Transaksi/Invoice', ['transaksi' => $transaksi, 'slug' => 'apem']);
        // $bank = Bank::paginate(10)->items();
    }

    function transaksi()
    {
        $user = Auth::user();
        $plans = DB::table('plans')->orderBy('name', 'asc')
            ->paginate(10)->items();
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.user_id', $user->id)
            ->select('transaksis.created_at as tgl_transaksi', 'plans.description', 'transaksis.payment_method', 'transaksis.amount', 'transaksis.id', 'transaksis.updated_at')
            ->paginate(100);

        // Mengubah format tanggal dan menambahkan satu tahun
        $transaksi->getCollection()->transform(function ($item) {
            $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('d/m/Y');
            $item->updated_at_plus_one_year = Carbon::parse($item->updated_at)->addYear()->format('d/m/Y');
            return $item;
        });
        // dd($transaksi);
        return view('Pages/ControlPanel/Member/Transaksi/riwayatTransaksi', ['plans' => $plans, 'transaksi' => $transaksi->items()]);
        // return Inertia::render('Member/Page/Transaksi/Index', ['plans' => $plans, 'transaksi' => $transaksi->items()]);
    }

    function FoodCreateListing()
    {
        return view('Pages/ControlPanel/Member/Food/createRegion', [
            'isUpdate' => false,
            'url' => 'member.food.store-listing'
        ]);
        // return Inertia::render('Member/Page/FoodAndMarchant/Create', );
    }
    function merchantCreateListing()
    {
        return view('Pages/ControlPanel/Member/Merchant/createRegion', [
            'isUpdate' => false,
            'url' => 'member.food.store-listing'
        ]);
    }

    function merchantsStoreListing(Request $request)
    {

        $this->validate($request, [
            'district' => 'required',
            'area' => 'required',
            'adres' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ], [
            'district.required' => 'Kecamatan harus diisi',
            'area.required' => 'Kawasan harus diisi',
            'adres.required' => 'Alamat lengkap harus diisi',
            'lat.required' => 'Latitude lokasi distrik harus diisi.',
            'long.required' => 'Longitude lokasi distrik harus diisi.',
        ]);

        $certificate = AdsProperty::getAllCertificates();
        $apartmenType = AdsProperty::getApartmenType();
        $propertyType = AdsProperty::getAllPropertyType();
        $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
        return view('Pages/ControlPanel/Member/Merchant/adsMerchantPage', [
            'isUpdate' => false,
            'data' => $request->all(),
            'certificate' => $certificate,
            'apartmentType' => $apartmenType,
            'getAllEnvironmentalConditions' => $getAllEnvironmentalConditions,
            'propertyType' => $propertyType,
        ]);
        // return Inertia::render('Member/Page/FoodAndMarchant/AdsPropertiesPage', [
        //     'isUpdate' => false,
        //     'data' => $request->all(),
        //     'certificate' => $certificate,
        //     'apartmentType' => $apartmenType,
        //     'propertyType' => $propertyType,
        // ]);
    }

    function merchantsStoreListingMarchent(Request $request)
    {
        $request->validate([
            'fileInput.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'fileInput' => 'required',
            'title' => 'required|string|max:255|unique:ads,title',
            'description' => 'nullable|string',
            'district_name' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'area' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
        ], [
            'fileInput.*.file' => 'File harus berupa file.',
            'fileInput.*.mimes' => 'File harus berformat: pdf, doc, docx, jpg, jpeg, png.',
            'fileInput.*.max' => 'Ukuran file tidak boleh lebih dari 2048 kilobytes.',
            'fileInput.required' => 'Setidaknya satu file harus diunggah.',
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa string.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'title.unique' => 'Judul sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa string.',
        ]);

        $user = Auth::user();
        $ads = new Ads();
        $ads->title = $request->title;
        $ads->slug = Str::slug($request->title) . '-' . uniqid();
        $ads->description = $request->description;
        $ads->type = 'merchant';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = 1;
        $ads->is_archived = 1;
        $ads->status = 'available';
        $ads->save();
        $hargaInt = (int) preg_replace('/\D/', '', $request->price);

        $merchnt = new Merchant();
        $merchnt->ads_id = $ads->id;
        $merchnt->district = $request->district_name;
        $merchnt->districtLocation_lat = $request->lat;
        $merchnt->districtLocation_long = $request->lng;
        $merchnt->price = $hargaInt;
        $merchnt->kawasan = $request->area;
        $merchnt->alamat = $request->adres;
        $merchnt->save();


        if ($request->hasFile('fileInput')) {
            foreach ($request->file('fileInput') as $image) {
                $path = $image->store('/images/properti/merchant/' . $ads->id, 'public');
                $imageUrl = Storage::url($path);

                $media = new Media();
                $media->model_type = 'App\\Models\\Merchant';
                $media->model_id = $ads->id;
                $media->collection_name = 'images';
                $media->name = $image->getClientOriginalName();
                $media->file_name = basename($path);
                $media->manipulations = '[]';
                $media->custom_properties = '[]';
                $media->generated_conversions = '[]';
                $media->responsive_images = '[]';
                $media->mime_type = $image->getClientMimeType();
                $media->disk = '/storage/images/properti/merchant/' . $ads->id; // Ganti disk sesuai konfigurasi storage

                $media->size = $image->getSize();
                $media->save();
            }
        }
        $merchnt->image = $media->disk . '/' . $media->file_name;
        $merchnt->save();
        if($request->subkategori){
            foreach ($request->subkategori as $key => $subkategori) {

                $KategoriMarchent = new KategoriMarchent();
                $KategoriMarchent->kategori_id = $subkategori;
                $KategoriMarchent->marchent_id = $merchnt->id;
                $KategoriMarchent->save();
            } 
        }
        $this->manageAdvertisingPoints($request, $ads, $user, 'ABC012');
        return redirect(route('member.merchants'))->with('success', 'Food berhasil disimpan.');
    }
    function FoodStoreListing(Request $request)
    {

        $this->validate($request, [
            'district' => 'required',
            'area' => 'required',
            'adres' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ], [
            'district.required' => 'Kecamatan harus diisi',
            'area.required' => 'Kawasan harus diisi',
            'adres.required' => 'Alamat lengkap harus diisi',
            'lat.required' => 'Latitude lokasi distrik harus diisi.',
            'long.required' => 'Longitude lokasi distrik harus diisi.',
        ]);

        $certificate = AdsProperty::getAllCertificates();
        $apartmenType = AdsProperty::getApartmenType();
        $propertyType = AdsProperty::getAllPropertyType();
        $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
        return view('Pages/ControlPanel/Member/Food/adsFoodPage', [
            'isUpdate' => false,
            'data' => $request->all(),
            'certificate' => $certificate,
            'apartmentType' => $apartmenType,
            'getAllEnvironmentalConditions' => $getAllEnvironmentalConditions,
            'propertyType' => $propertyType,
        ]);
        // return Inertia::render('Member/Page/FoodAndMarchant/AdsPropertiesPage', [
        //     'isUpdate' => false,
        //     'data' => $request->all(),
        //     'certificate' => $certificate,
        //     'apartmentType' => $apartmenType,
        //     'propertyType' => $propertyType,
        // ]);
    }


    function FoodStoreListingFood(Request $request)
    {
        $request->validate([
            'fileInput.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'fileInput' => 'required',
            'title' => 'required|string|max:255|unique:ads,title',
            'description' => 'nullable|string',
            'district_name' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'area' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
        ], [
            'fileInput.*.file' => 'File harus berupa file.',
            'fileInput.*.mimes' => 'File harus berformat: pdf, doc, docx, jpg, jpeg, png.',
            'fileInput.*.max' => 'Ukuran file tidak boleh lebih dari 2048 kilobytes.',
            'fileInput.required' => 'Setidaknya satu file harus diunggah.',
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa string.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'title.unique' => 'Judul sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa string.',
        ]);


        $user = Auth::user();
        $ads = new Ads();
        $ads->title = $request->title;
        $ads->slug = Str::slug($request->title) . '-' . uniqid();
        $ads->description = $request->description;
        $ads->type = 'food';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = 1;
        $ads->is_archived = 1;
        $ads->status = 'available';
        $ads->save();
        $hargaInt = (int) preg_replace('/\D/', '', $request->price);
        $food = new Food();
        $food->ads_id = $ads->id;
        $food->district = $request->district_name;
        $food->districtLocation_lat = $request->lat;
        $food->districtLocation_long = $request->lng;
        $food->kawasan = $request->area;
        $food->price = $hargaInt;
        $food->alamat = $request->adres;
        $food->save();


        if ($request->hasFile('fileInput')) {
            foreach ($request->file('fileInput') as $image) {
                $path = $image->store('/images/properti/food/' . $ads->id, 'public');
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
                $media->disk = '/storage/images/properti/food/' . $ads->id; // Ganti disk sesuai konfigurasi storage

                $media->size = $image->getSize();
                $media->save();
            }
        }
        $food->image = $media->disk . '/' . $media->file_name;
        $food->save();
        if($request->subkategori){

            foreach ($request->subkategori as $key => $subkategori) {

                $KategoriFood = new KategoriFood();
                $KategoriFood->kategori_id = $subkategori;
                $KategoriFood->oFood_id = $food->id;
                $KategoriFood->save();
            }
        }
        $this->manageAdvertisingPoints($request, $ads, $user, 'ABC011');
        return redirect(route('member.food'))->with('success', 'Food berhasil disimpan.');
    }

    function lelang()
    {
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";
        $user = auth()->user();

        $properties = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->where('ads.type', 'lelang')
            ->leftJoin('user_lelang_properties', function ($join) use ($user) {
                $join->on('user_lelang_properties.ads_id', '=', 'ads.id')
                    ->where('user_lelang_properties.user_id', '=', $user->id);
            })
            ->select(
                "ads_properties.id",
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "users.name as name_user",
                "ads_properties.ads_type",
                "ads_properties.image",
                "ads_properties.price",
                "ads_properties.address",
                "ads_properties.*",
                "ads_properties.id as id_properti",
                "ads.status",
                "ads.id as ads_id",
                'media.id as media_id',
                "media.file_name as file_name",
                "ads.is_active",
                DB::raw("CASE WHEN user_lelang_properties.user_id = " . $user->id . " THEN true ELSE false END AS lelang_ads")
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
            // dd($properties);
        $adControll = AdBalaceControl::where('code', 'ABC008')->first();

        // dd($properties->items());
        return view('Pages/ControlPanel/Member/Lelang/lisLelang', ['properties' => $properties->items(), 'pagination' => $properties, 'title' => 'Lelang', 'adControll' => $adControll]);

        // return Inertia::render('Member/Page/Lelang/Index', ['properties' => $properties->items(), 'pagination' => $properties, 'title' => 'Lelang', 'adControll' => $adControll]);
    }

    public function lelangStore(Request $request)
    {
        // dd($request->all());
        $ads = Ads::where('ads.id', $request->ads_id)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*', 'ads.id as ads_id')
            ->first();
        $auth = User::find($request->user_id);
        // dd($auth);
        $balance = $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC008');
        $responseData = $balance->getData();
        // dd($responseData->balance);
        if ($responseData->balance) {
            UserLelangPropertie::create($request->all());
            return back()->with('success', 'Lelang berhasil di pasang');
        }
        return back()->with('error', $responseData->message);
    }

    function pengajuanKpr()
    {
        $auth = Auth::user();
        $pengajuanKpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->where('kpr.user_id', $auth->id)
            ->select(
                'kpr.*',
                'userAgen.name as namaAgen',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'bankBpr.email as bank_bpr_email'
            )
            ->get();

        // dd($pengajuanLelang);

        return view('Pages/Member/Lelang/pengajuanKpr', compact('pengajuanKpr'));
        // return Inertia::render('Member/Page/Pengajuan/Kpr/Index', compact('pengajuanKpr', 'pengajuanLelang'));
    }
    function pengajuanLelang()
    {
        $auth = Auth::user();

        $pengajuanLelang = Lelang::query()
            ->join('ads', 'ads.id', '=', 'lelangs.ads_id')
            ->join('users as agen', 'agen.id', '=', 'lelangs.agen_id')
            ->where('lelangs.user_id', $auth->id)
            ->select(
                'lelangs.id',
                'lelangs.uuid',
                'lelangs.created_at',
                'lelangs.status',
                'lelangs.image_ktp',
                'lelangs.image_kk',
                'lelangs.agreement',
                'lelangs.kpr_name',
                'lelangs.kpr_email',
                'lelangs.kpr_phone',
                'ads.slug as ads_slug',
                'ads.id as ads_id',
                'agen.name as namaAgen',
                'agen.name as wa_phone',
            )
            ->distinct()
            ->get();
        // dd($pengajuanLelang);

        return view('Pages/Member/Lelang/pengajuanLelang', compact('pengajuanLelang'));
        // return Inertia::render('Member/Page/Pengajuan/Kpr/Index', compact('pengajuanKpr', 'pengajuanLelang'));
    }

    function agenListPengajuanKpr()
    {

        $auth = Auth::user();
        $pengajuanKpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->where('userAgen.id', $auth->id)
            ->select(
                'kpr.*',
                'userAgen.name as namaAgen',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'bankBpr.email as bank_bpr_email'
            )
            ->get();

        // dd($pengajuanKpr);

        return Inertia::render('Member/Page/Pengajuan/Agen/ListKaprVisitor', compact('pengajuanKpr'));

    }


    function favorit()
    {
        $auth = Auth::user();
        $favorits = LinkeAds::join('ads', 'ads.id', '=', 'linke_ads.ads_id')
            ->leftJoin('ads_properties', function ($join) {
                $join->on('ads_properties.ads_id', '=', 'ads.id');
            })
            ->leftJoin('ofoods', function ($join) {
                $join->on('ofoods.ads_id', '=', 'ads.id');
            })
            ->leftJoin('omerchants', function ($join) {
                $join->on('omerchants.ads_id', '=', 'ads.id');
            })
            ->leftJoin('user_lelang_properties', function ($join) use ($auth) {
                $join->on('user_lelang_properties.ads_id', '=', 'ads.id')
                    ->where('linke_ads.type', '=', 'lelang');
            })
            ->leftJoin('users', function ($join) use ($auth) {
                $join->on('users.id', '=', 'user_lelang_properties.user_id')
                    ->orWhere('users.id', '=', 'linke_ads.user_id');
            })
            ->where('linke_ads.user_id', $auth->id)
            ->select(
                'ads.title',
                'ads.slug',
                'linke_ads.type',
                DB::raw("CASE 
                WHEN linke_ads.type = 'properti' THEN ads_properties.image 
                WHEN linke_ads.type = 'lelang' THEN ads_properties.image 
                WHEN linke_ads.type = 'food' THEN ofoods.image 
                WHEN linke_ads.type = 'marchent' THEN omerchants.image 
                ELSE NULL 
            END AS image"),
                DB::raw("EXISTS (SELECT 1 FROM omerchants WHERE omerchants.ads_id = ads.id) AS is_omerchants_installed")
            )
            ->get();

        // dd($favorits);
        return view('Pages/Frond/favorit', compact('favorits'));
        // return Inertia::render('Member/Page/Favorit/Index', compact('favorits'));
    }

    function propertiCreate()
    {

        return view('Pages/ControlPanel/Member/Properti/createRegion');
    }
    function propertiCreateListing(Request $request)
    {

        $this->validate($request, [
            'district' => 'required',
            'area' => 'required',
            'adres' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ], [
            'district.required' => 'Kecamatan harus diisi',
            'area.required' => 'Kawasan harus diisi',
            'adres.required' => 'Alamat lengkap harus diisi',
            'lat.required' => 'Latitude lokasi distrik harus diisi.',
            'long.required' => 'Longitude lokasi distrik harus diisi.',
        ]);

        $certificate = AdsProperty::getAllCertificates();
        $apartmenType = AdsProperty::getApartmenType();
        $propertyType = AdsProperty::getAllPropertyType();
        $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
        // dd($request->all());
        // return Inertia::render('Member/Page/FoodAndMarchant/AdsPropertiesPage', [
        //     'isUpdate' => false,
        //     'data' => $request->all(),
        //     'certificate' => $certificate,
        //     'apartmentType' => $apartmenType,
        //     'propertyType' => $propertyType,
        // ]);

        return view('Pages/ControlPanel/Member/Properti/propertiCreateListing', [
            'isUpdate' => false,
            'data' => $request->all(),
            'certificate' => $certificate,
            'apartmentType' => $apartmenType,
            'propertyType' => $propertyType,
            'getAllEnvironmentalConditions' => $getAllEnvironmentalConditions,
        ]);
    }

    function propertiStoreListing(Request $request)
    {
        // dd($request);
        $request->validate([
            // 'fileInput.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Validasi untuk setiap file
            'fileInput.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png', // Validasi untuk setiap file nantinya di pasang 500mb
            'fileInput' => 'required', // Pastikan setidaknya satu file diunggah
            'title' => 'required|string|max:255|unique:ads,title',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'district_id' => 'nullable|exists:id_districts,id',
            'district_name' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'ads_type' => 'nullable|string|max:255',
            'property_type' => 'nullable|string|max:255',
            'price' => 'nullable',
            'certificate' => 'nullable|max:255',
            'year_built' => 'nullable|date_format:Y|max:' . date('Y'),
            'lt' => 'nullable|integer',
            'lb' => 'nullable|integer',
            'dl' => 'nullable|integer',
            'jl' => 'nullable|integer',
            'jk' => 'nullable|integer',
            'jkm' => 'nullable|integer',
            'furniture_condition' => 'nullable|string|max:255',
            'house_facility' => 'nullable',
            'other_facility' => 'nullable', 
        ], [
            'fileInput.*.file' => 'File harus berupa file.',
            'fileInput.*.mimes' => 'File harus berformat: pdf, doc, docx, jpg, jpeg, png.',
            'fileInput.*.max' => 'Ukuran file tidak boleh lebih dari 2048 kilobytes.',
            'fileInput.required' => 'Setidaknya satu file harus diunggah.',
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa string.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'title.unique' => 'Judul sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa string.',
            'type.in' => 'Tipe harus salah satu dari: property.',
            'published_at.date' => 'Tanggal publikasi harus berupa tanggal yang valid.',
            'district_id.exists' => 'ID distrik tidak ditemukan.',
            'district_name.string' => 'Nama distrik harus berupa string.',
            'district_name.max' => 'Nama distrik tidak boleh lebih dari 255 karakter.',
            'lat.numeric' => 'Latitude harus berupa angka.',
            'lng.numeric' => 'Longitude harus berupa angka.',
            'area.string' => 'Area harus berupa string.',
            'area.max' => 'Area tidak boleh lebih dari 255 karakter.',
            'address.string' => 'Alamat harus berupa string.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'ads_type.string' => 'Tipe iklan harus berupa string.',
            'ads_type.max' => 'Tipe iklan tidak boleh lebih dari 255 karakter.',
            'property_type.string' => 'Tipe properti harus berupa string.',
            'property_type.max' => 'Tipe properti tidak boleh lebih dari 255 karakter.',
            'certificate.string' => 'Sertifikat harus berupa string.',
            'certificate.max' => 'Sertifikat tidak boleh lebih dari 255 karakter.',
            'year_built.date_format' => 'Tahun dibangun harus dalam format tahun (YYYY).',
            'year_built.max' => 'Tahun dibangun tidak boleh lebih dari tahun saat ini.',
            'lt.integer' => 'Luas tanah harus berupa angka.',
            'lb.integer' => 'Luas bangunan harus berupa angka.',
            'dl.integer' => 'Daya listrik harus berupa angka.',
            'jl.integer' => 'Jumlah lantai harus berupa angka.',
            'jk.integer' => 'Jumlah kamar tidur harus berupa angka.',
            'jkm.integer' => 'Jumlah kamar mandi harus berupa angka.',
            'furniture_condition.string' => 'Kondisi furnitur harus berupa string.',
            'furniture_condition.max' => 'Kondisi furnitur tidak boleh lebih dari 255 karakter.',
            'video.string' => 'Link video harus berupa string.',
            'video.max' => 'Link video tidak boleh lebih dari 255 karakter.',
        ]);

        $user = Auth::user();
        $ads = new Ads();
        $ads->title = $request->title;
        $ads->slug = Str::slug($request->title) . '-' . uniqid();
        $ads->description = $request->description;
        $ads->type = 'property';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = 1;
        $ads->is_archived = 1;
        $ads->status = 'available';
        $ads->save();
        $ads->uuid = $this->KodeIklan('property',$request->ads_type,$ads->created_at,Ads::whereMonth('created_at', Carbon::now()->month)->count());
        // $ads->uuid = Str::uuid() . '-' . str_pad(Ads::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
        $ads->save();
        $hargaInt = (int) preg_replace('/\D/', '', $request->price);


        $AdsProperty = new AdsProperty();
        $AdsProperty->ads_id = $ads->id;
        $AdsProperty->district_id = $request->district_id;
        $AdsProperty->district_name = $request->district_name;
        $AdsProperty->lat = $request->lat;
        $AdsProperty->lng = $request->lng;
        // $AdsProperty->location = $request->adds;
        $AdsProperty->area = $request->area;
        $AdsProperty->address = $request->adres;
        $AdsProperty->ads_type = $request->ads_type;
        $AdsProperty->property_type = $request->property_type;
        // $AdsProperty->rent_type = $request->adds;
        $AdsProperty->price = $hargaInt;
        $AdsProperty->certificate = json_encode($request->certificate);
        $AdsProperty->housing_name = $request->housing_name;
        $AdsProperty->cluster_name = $request->cluster_name;
        $AdsProperty->year_built = date('Y', strtotime($request->year_built));

        $AdsProperty->lt = $request->lt;
        $AdsProperty->lb = $request->lb;
        $AdsProperty->dl = $request->dl;
        $AdsProperty->jl = $request->jl;
        $AdsProperty->jk = $request->jk;
        $AdsProperty->jkm = $request->jkm;
        // $AdsProperty->apartment_type = $request->adds;
        // $AdsProperty->floor_location = $request->adds;
        // dd($request->house_facility);
        $AdsProperty->furniture_condition = $request->furniture_condition;
        $AdsProperty->house_facility = json_encode($request->house_facility);
        $AdsProperty->other_facility = json_encode($request->other_facility);
        $AdsProperty->video = $request->youtubeLink;
        // $AdsProperty->property_type_id = $request->adds;
        $AdsProperty->save();
        $AdsProperty->uuid = Str::uuid() . '-' . str_pad(AdsProperty::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
        $AdsProperty->save();

        if ($request->hasFile('fileInput')) {
            foreach ($request->file('fileInput') as $image) {
                $path = $image->store('/images/properti/property/' . $ads->id, 'public');
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
                $media->disk = '/storage/images/properti/property/' . $ads->id; // Ganti disk sesuai konfigurasi storage

                $media->size = $image->getSize();
                $media->save();
            }
        }
        $AdsProperty->image = $media->disk . '/' . $media->file_name;
        $AdsProperty->save();
       
        $this->manageAdvertisingPoints($request, $ads, $user, 'ABC009');

        // return false;
        return redirect(route('listing.index'))->with('success', 'Listing berhasil disimpan.');
        // return response()->json(['message' => 'Data stored successfully', 'data' => $request->all()]);
    }

    function profile()
    {
        return view('Pages/Member/Profile/Index');
    }

    function memberProfileStore(Request $request)
    {
        // dd($request);
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->wa_phone = $request->wa_phone;
        $user->bio = $request->bio;
        $user->address = $request->address;
        $user->company_name = $request->company_name;
        $user->bank_name = $request->bank_name;
        $user->bank_number = $request->bank_number;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        // // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/profile_pengguna/' . $user->id, 'public');
            $user->image = Storage::url($path);
            $user->update(); // Menyimpan perubahan pada user
        }
        if ($request->hasFile('company_image')) {
            $path = $request->file('company_image')->store('images/company_image/' . $user->id, 'public');
            $user->company_image = Storage::url($path);
            $user->update(); // Menyimpan perubahan pada user
        }
        
        
        $user->save();
        return back()->with('succsess', 'Berhasil Menyimpan Data Pefile');

    }
}
