<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Ads;
use App\Models\Media;
use App\Models\AdsProperty;
use App\Models\bosterAds;
use App\Models\Kpr;
use App\Models\User;
use App\Models\bosterAdsTYpe;
use App\Models\Food;
use App\Models\Merchant;
use App\Models\TitipAds;
use App\Models\WilayahKerja;
use App\Services\AdvertisingPointsManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\District;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Services\PropertyRepository;
use App\Services\ToolService;

class ListingController extends Controller
{
    use PropertyRepository;
    use AdvertisingPointsManager;
    use ToolService;

    function home(Request $request){
        return view('Pages/ControlPanel/Home/index');
    }


    public function index(Request $request)
    {
       
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";

        $auth = Auth::user();
        $user = Auth::user();
        
        $properties = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
        ->join('media', function ($join) {
            $join->on('media.model_id', '=', 'ads.id')
                ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
        })
        ->leftJoin('user_lelang_properties', function ($join) use ($user) {
            $join->on('user_lelang_properties.ads_id', '=', 'ads.id')
                ->where('user_lelang_properties.user_id', '=', $user->id);
        })
        ->join('users', 'users.id', '=', 'ads.user_id')
        ->where(function ($query) use ($user, $searchQuery) {
            $query->where('users.id', $user->id)
                ->orWhere('ads.type', 'lelang');
        })
        ->where(function ($query) use ($auth) {
            $query->where(function ($subQuery) use ($auth) {
                $subQuery->whereNull('user_lelang_properties.id')
                    ->where('ads.user_id', $auth->id);
            })
            ->orWhere(function ($subQuery) use ($auth) {
                $subQuery->whereNotNull('user_lelang_properties.id')
                    ->where('user_lelang_properties.user_id', $auth->id);
            });
        })
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
            'user_lelang_properties.id as user_lelang_properties_id',
            DB::raw("IFNULL(user_lelang_properties.is_active, ads.is_active) as is_active"),
            DB::raw("IFNULL(user_lelang_properties.created_at, ads.created_at) as created_at")
        )
        ->where(function ($query) use ($searchQuery) {
            $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                ->orWhere('ads_properties.ads_type', 'like', '%' . $searchQuery . '%')
                ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
        })
        ->orderBy('created_at', 'desc')
        ->get();
    


            // dd($properties);
            $titipAds = TitipAds::with(['owner', 'receiver','ads'])->where('user_receiver_id',$user->id)->where('status','pending')->get();
        $bosterAdsType = bosterAdsTYpe::where('type','property')->get();
        // dd(88);
       $gcu = $this->getOrCreateUserAdBalance($user->id);
        // dd($gcu);
        return view('Pages/ControlPanel/Member/Properti/index', compact('properties','titipAds','bosterAdsType','gcu'));
        // return Inertia::render('Listing/ListingPage', [
        //     'properties' => $properties->items(),
        //     'pagination' => $properties,
        //     'title' => 'Lelang'
        // ]);
    }
    function viewProperty(Request $request,$slug=''){
        $auth = Auth::user();
        $ads = Ads::where('ads.slug', $slug)
        ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
        ->join('id_districts','id_districts.id','=','ads_properties.district_id')
        ->join('id_cities','id_cities.code','=','id_districts.city_code')
        ->join('id_provinces','id_provinces.code','=','id_cities.province_code')
        ->select('ads.*', 'ads_properties.*', 'ads.id as ads_id','ads_properties.id as ads_properties_id','id_cities.name as name_cities','id_provinces.name as name_provinces')
        ->first();
        // dd($ads);
        $media = Media::where('model_id', $ads->ads_id)
        ->select('id', 'disk', 'file_name')
        ->get()
        ->map(function ($item) {
            return [
                'url' => asset($item->disk . '/' . $item->file_name), // Menggunakan asset helper untuk URL yang benar
                'id' => $item->id
            ];
        });
        $BosterAds = BosterAds::join('boster_ads_t_ypes','boster_ads_t_ypes.id','=','boster_ads.booster_type_id')
        ->where('boster_ads.ads_id', $ads->ads_id)
        ->where('boster_ads.user_id', $auth->id)
        ->select('boster_ads_t_ypes.title','boster_ads.created_at')
        ->orderBy('created_at','DESC')
        ->get();
    // dd($BosterAds);
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
    $navLink = $request->navLink;

    $bosterAdsType = bosterAdsTYpe::where('type','property')->get();
    
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius');
    $searchQuery = $request->input('searchQuery');
    $perPage = $request->input('perPage', 10);
    $page = $request->input('page', 3);
    $code = $request->input('code', 'PTYHOME');
    $slug = $request->input('slug');

    $position = $this->getPropertyPosition($latitude, $longitude, $radius, $searchQuery, $perPage, $page, $code, $slug);

       
    // dd($position);
        return view('Pages/ControlPanel/Member/Properti/view',compact('ads','navLink','media','bosterAdsType','BosterAds'));
    }

    function editPropertiTentangProperti($slug='')  {
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
    
    $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
  
    return view('Pages/ControlPanel/Member/Properti/Edit/tentangProperti',compact('ads','getAllEnvironmentalConditions'));
    }

    function updatePropertiTentangProperti(Request $request,$id) {

    //    dd($request->all);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'property_type' => 'required',
            'year_built' => 'required|date_format:Y',
            'lt' => 'required',
            'lb' => 'required',
            'dl' => 'required',
            'jl' => 'required',
            'jk' => 'required',
            'jkm' => 'required',
            'furniture_condition' => 'required',
            'house_facility' => 'array',
            'other_facility' => 'array',
        ], [
            'required' => ':attribute harus diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'date_format' => ':attribute harus dalam format tahun (YYYY).',
            'array' => ':attribute harus berupa array.',
            'url' => ':attribute harus berupa URL yang valid.'
        ]);
        // dd($request->certificate);
        $ads = Ads::whereId($id)->first();
        // dd($ads);
        $ads->title = $request->title; 
        $ads->description = $request->description; 
        $ads->save();
        $harga = $request->price;
        $hargaInt = (int) str_replace(['Rp.', ',',' ','.'], '', $harga);
      
        $AdsProperty =  AdsProperty::where('ads_id',$ads->id)->first(); 
        $AdsProperty->property_type = $request->property_type;
        // $AdsProperty->rent_type = $request->adds;
        $AdsProperty->price = $hargaInt;
        $certificate = $request->certificate;
        $AdsProperty->certificate = json_encode($certificate);
        $AdsProperty->housing_name = $request->housing_name;
        $AdsProperty->cluster_name = $request->cluster_name;
        $AdsProperty->year_built = $request->year_built;

        $AdsProperty->lt = $request->lt;
        $AdsProperty->lb = $request->lb;
        $AdsProperty->dl = $request->dl;
        $AdsProperty->jl = $request->jl;
        $AdsProperty->jk = $request->jk;
        $AdsProperty->jkm = $request->jkm;
        // $AdsProperty->apartment_type = $request->adds;
        // $AdsProperty->floor_location = $request->adds;
        $AdsProperty->furniture_condition = $request->furniture_condition;
        
        $house_facility = $request->house_facility;
        $other_facility = $request->other_facility;
        $AdsProperty->house_facility = json_encode($house_facility);
        $AdsProperty->other_facility = json_encode($other_facility); 
        $AdsProperty->video = $request->videoYoutube; 
        $AdsProperty->save();

        return redirect()->route('listing.control-panel.view.property', ['slug' => $ads->slug, 'navLink' => 'properti'])->with('success', 'Properti berhasil diperbarui.');

    }

    function setMediaUtama(Request $request,$ads_properties_id){
        $AdsProperty =  AdsProperty::whereId($ads_properties_id)->first(); 
        $AdsProperty->image = $request->url;
        $AdsProperty->save(); 
        return back()->with(['navLink' => 'galeri', 'success' => 'Media berhasil diperbarui.']);
    }

    function setMediaUpdate(Request $request, $ads_properties_id) {
        // Temukan media berdasarkan ID
        $media = Media::find($request->mediaId);
        $properti = AdsProperty::whereId($ads_properties_id)->first();
    
        if (!$media) {
            return back()->withErrors(['error' => 'Media tidak ditemukan.']);
        }
    
        if ($properti['image'] != $media['url']) {
            // Hapus gambar lama dari storage
            $oldImagePath = $media->disk . '/' . $media->file_name;
            Storage::disk('public')->delete($oldImagePath);
        }
    
        // Simpan file baru
        $image = $request->file('media');
        $path = $image->store('/images/properti/property/' . $ads_properties_id, 'public');
        
        // Perbarui informasi media
        $media->disk = '/storage/images/properti/property/' . $ads_properties_id;
        $media->file_name = basename($path);
        $media->save();
    
        // Redirect dengan pesan sukses
        return back()->with(['success' => 'Media berhasil diperbarui.']);
    }


    function editPropertiAddres($slug){
        $ads = Ads::where('ads.slug', $slug)
        ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
        ->join('id_districts','id_districts.id','=','ads_properties.district_id')
        ->join('id_cities','id_cities.code','=','id_districts.city_code')
        ->join('id_provinces','id_provinces.code','=','id_cities.province_code')
        ->select('ads.*', 'ads_properties.*', 'ads.id as ads_id','ads_properties.id as ads_properties_id','id_cities.name as name_cities','id_provinces.name as name_provinces')
        ->first();
        return view('Pages/ControlPanel/Member/Properti/Edit/addres',compact('ads'));
    }

    function updatePropertiAddres(Request $request,$adsId = '') {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
            'district' => 'required', 
            'area' => 'required',
            'adres' => 'required',
        ], [
            'lat.required' => 'Latitude harus diisi.',
            'lat.numeric' => 'Latitude harus berupa angka.',
            'lat.between' => 'Latitude harus antara -90 dan 90.',
            'lng.required' => 'Longitude harus diisi.',
            'lng.numeric' => 'Longitude harus berupa angka.',
            'lng.between' => 'Longitude harus antara -180 dan 180.',
            'district.required' => 'Kecamatan harus diisi.',
            'district.string' => 'Kecamatan harus berupa teks.',
            'district.max' => 'Kecamatan tidak boleh lebih dari 255 karakter.',
            'districtId.required' => 'ID kecamatan harus diisi.',
            'districtId.integer' => 'ID kecamatan harus berupa angka.',
            'districtId.exists' => 'ID kecamatan tidak ditemukan.',
            'area.required' => 'Area harus diisi.',
            'area.string' => 'Area harus berupa teks.',
            'area.max' => 'Area tidak boleh lebih dari 255 karakter.',
            'adres.required' => 'Alamat harus diisi.',
            'adres.string' => 'Alamat harus berupa teks.',
            'adres.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
        ]);
        $AdsProperty = AdsProperty::where('ads_id',$adsId)->first();
        $AdsProperty->lat = $request->lat;
        $AdsProperty->lng = $request->lng;
        $AdsProperty->district_name = $request->district;
        $AdsProperty->district_id = $request->districtId;
        $AdsProperty->area = $request->area;
        $AdsProperty->address = $request->adres;
        $AdsProperty->save(); 
        // dd($AdsProperty);
        // dd($request->all());
        $ads = Ads::whereId($AdsProperty->ads_id)->first();
        return redirect()->route('listing.control-panel.view.property', ['slug' => $ads->slug, 'navLink' => 'lokasi'])->with('success', 'Alamat berhasil diperbarui.');
    }

    public function create()
    {
        return Inertia::render('Listing/CreateListingPage', [
            'isUpdate' => false,
        ]);
    }

    

    public function edit($id, Request $request)
    {
        $ads = Ads::with('property', 'media')->find($id);

        $certificate = AdsProperty::getAllCertificates();
        $apartmenType = AdsProperty::getApartmenType();
        $data = [
            'district' => $ads->property->district_name,
            'districtId' => $ads->property->district_id,
            'districtLocation' => [
                'lat' => $ads->property->lat,
                'long' => $ads->property->lng
            ],
            'kawasan' => $ads->property->area,
            'alamat' => $ads->property->address,
        ];

        if ($request->all() != null && count($request->all()) > 0) {
            $data = $request->all();
        }

        return Inertia::render('Listing/AdsPropertiesPage', [
            'isUpdate' => true,
            'ads' => $ads,
            'data' => $data,
            'certificate' => $certificate,
            'apartmentType' => $apartmenType,
            'propertyType' => AdsProperty::getAllPropertyType(),
        ]);
    }

    public function update($id, Request $request)
    {
        $ads = Ads::with('property', 'media')->find($id);

        $this->validate($request, [
            'judul' => 'required',
            'tipeIklan' => 'required',
            'tipeProperti' => 'required',
            'deskripsi' => 'required',
            'tipeSewa' => 'required_if:tipeIklan,=,sewa',
            'harga' => 'required',
            'namaKomplek' => 'required_unless:tipeProperti,apartemen',
            'namaCluster' => 'required',
            'luasTanah' => 'required_unless:tipeProperti,apartemen',
            'luasBangunan' => 'required_unless:tipeProperti,tanah',
            'posisiLantai' => 'required_if:tipeProperti,=,apartemen',
            'sertifikat' => 'required',
            'tahunDibangun' => 'required_unless:tipeProperti,=,tanah',
            'dayaListrik' => 'required_unless:tipeProperti,=,tanah',
            // 'fotoProperti' => 'array|max:10|min:1',
        ], [
            'judul.required' => 'Judul iklan harus diisi',
            'tipeIklan.required' => 'Tipe iklan harus diisi',
            'tipeProperti.required' => 'Tipe properti harus diisi',
            'deskripsi.required' => 'Deskripsi iklan harus diisi',
            'tipeSewa.required_if' => 'Tipe sewa harus diisi jika iklan ini sewa',
            'harga.required' => 'Harga properti harus diisi',
            'namaKomplek.required_unless' => 'Nama komplek harus diisi',
            'namaCluster.required' => 'Nama cluster harus diisi',
            'luasTanah.required_unless' => 'Luas tanah harus diisi',
            'luasBangunan.required_unless' => 'Luas bangunan harus diisi',
            'posisiLantai.required_if' => 'Posisi lantai harus diisi',
            'sertifikat.required' => 'Jenis sertifikat harus diisi',
            'tahunDibangun.required_unless' => 'Tahun dibangun harus diisi',
            'dayaListrik.required_unless' => 'Daya listrik harus diisi',
            // 'fotoProperti.min' => 'Sertakan foto properti minimal satu'
        ]);

        try {
            DB::beginTransaction();
            $ads->title = $request->judul;
            $ads->description = $request->deskripsi;
            $ads->update();

            $prop = AdsProperty::where('ads_id', $id)->first();
            $prop->district_id = $request->districtId;
            $prop->district_name = $request->district;
            $prop->lat = $request->districtLocation['lat'];
            $prop->lng = $request->districtLocation['long'];
            $prop->location = new Point(doubleval($prop->lat), doubleval($prop->lng));
            $prop->area = $request->kawasan;
            $prop->address = $request->alamat;
            $prop->ads_type = $request->tipeIklan;
            $prop->property_type = $request->tipeProperti;
            if ($request->tipeIklan == 'sewa') {
                $prop->rent_type = $request->tipeSewa;
            }
            $prop->price = $request->harga;
            $prop->certificate = $request->sertifikat;
            $prop->housing_name = $request->housing_name;
            $prop->cluster_name = $request->cluster_name;
            $prop->year_built = $request->tahunDibangun;
            $prop->lt = $request->luasTanah;
            $prop->lb = $request->luasBangunan;
            $prop->dl = $request->dayaListrik;
            $prop->jl = $request->jumlahLantai;
            $prop->jk = $request->kamarTidur;
            $prop->jkm = $request->kamarMandi;
            if ($request->tipeProperti == 'apartemen') {
                $prop->apartment_type = $request->tipeApartemen;
                $prop->floor_location = $request->posisiLantai;
            }
            $prop->furniture_condition = $request->kondisiPerabotan;
            $prop->house_facility = json_encode($request->fasilitasRumah);
            $prop->other_facility = json_encode($request->fasilitasPerumahan);
            $prop->video = $request->video;
            $prop->update();

            DB::commit();

            if (count($request->fotoProperti) > 0) {
                collect($request->fotoProperti)->each(function ($file) use ($ads) {
                    $ads->addMedia($file)->toMediaCollection('ads');
                });
            }

            if ($request->deletedFotoProperti != null && count($request->deletedFotoProperti) > 0) {
                foreach ($request->deletedFotoProperti as $key => $deletedFoto) {
                    $ads->deleteMedia($deletedFoto);
                }
            }

            return redirect()->back()->with('success', 'Iklan berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function adsProperties()
    {
        return Inertia::render('Listing/AdsPropertiesPage', [
            'propertyType' => AdsProperty::getAllPropertyType(),
        ]);
    }

    public function storeLocation(Request $request)
    {
        $this->validate($request, [
            'district' => 'required',
            'kawasan' => 'required',
            'alamat' => 'required'
        ], [
            'district.required' => 'Kecamatan harus diisi',
            'kawasan.required' => 'Kawasan harus diisi',
            'alamat.required' => 'Alamat lengkap harus diisi'
        ]);

        $certificate = AdsProperty::getAllCertificates();
        $apartmenType = AdsProperty::getApartmenType();
        $propertyType = AdsProperty::getAllPropertyType();
        $environmentalConditions = AdsProperty::getAllEnvironmentalConditions();

        return Inertia::render('Listing/AdsPropertiesPage', [
            'isUpdate' => false,
            'data' => $request->all(),
            'certificate' => $certificate,
            'apartmentType' => $apartmenType,
            'propertyType' => $propertyType,
            'environmentalConditions' => $environmentalConditions,
        ]);
    }

    public function storeAds(Request $request)
    {
        $user = Auth::user();
        $ads = new Ads();
        $ads->title = $request->adds;
        $ads->slug = $request->slug;
        $ads->description = $request->description;
        $ads->type = 'property';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = 1;
        // $ads->is_active = $request->isActive ? 1 : 0;
        $ads->is_archived = $request->isrchived ? 1 : 0;
        $ads->status = 'available';
        $ads->save();
        $harga = $request->harga;
        $hargaInt = (int) str_replace(['Rp.', ',',' ','.'], '', $harga);



        $AdsProperty = new AdsProperty();
        $AdsProperty->ads_id = $ads->id;
        $AdsProperty->district_id = $request->districtId;
        $AdsProperty->district_name = $request->district;
        $AdsProperty->lat = $request->districtLocationLat;
        $AdsProperty->lng = $request->districtLocationLong;
        // $AdsProperty->location = $request->adds;
        $AdsProperty->area = $request->kawasan;
        $AdsProperty->address = $request->alamat;
        $AdsProperty->ads_type = 'property';
        $AdsProperty->property_type = $request->selectedProperty;
        // $AdsProperty->rent_type = $request->adds;
        $AdsProperty->price = $hargaInt;
        $AdsProperty->certificate = $request->jenisSertifikat;
        $AdsProperty->housing_name = $request->housing_name;
        $AdsProperty->cluster_name = $request->cluster_name;
        $AdsProperty->year_built = $request->tahunDiBangun;

        $AdsProperty->lt = $request->luasTanah;
        $AdsProperty->lb = $request->luasBangunan;
        $AdsProperty->dl = $request->dayaListrik;
        $AdsProperty->jl = $request->lantai;
        $AdsProperty->jk = $request->kamarTidur;
        $AdsProperty->jkm = $request->kamarMandi;
        // $AdsProperty->apartment_type = $request->adds;
        // $AdsProperty->floor_location = $request->adds;
        $AdsProperty->furniture_condition = $request->kondisiPerabotan;
        $AdsProperty->house_facility = json_encode(json_decode($request->fasilitas));
        $AdsProperty->other_facility = json_encode(json_decode($request->other_facility));
        $AdsProperty->video = $request->videoYoutube;
        // $AdsProperty->property_type_id = $request->adds;
        $AdsProperty->save();

        if ($request->hasFile('uploadedImages')) {
            foreach ($request->file('uploadedImages') as $image) {
                $path = $image->store('/images/properti/mamber/' . $ads->id, 'public');
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
                $media->disk = '/storage/images/properti/mamber/' . $ads->id; // Ganti disk sesuai konfigurasi storage

                $media->size = $image->getSize();
                $media->save();
            }
        }
        $AdsProperty->image = $media->disk . '/' . $media->file_name;
        $AdsProperty->save();
        return response()->json(['message' => 'Data stored successfully', 'data' => $request->all()]);
    }

    public function editLocation($id)
    {
        $ads = Ads::with('property', 'media')->find($id);

        return Inertia::render('Listing/CreateListingPage', [
            'id' => $id,
            'isUpdate' => true,
            'data' => [
                'district' => $ads->property->district_name,
                'districtId' => $ads->property->district_id,
                'districtLocation' => [
                    'lat' => $ads->property->lat,
                    'long' => $ads->property->lng
                ],
                'kawasan' => $ads->property->area,
                'alamat' => $ads->property->address,
            ],
        ]);
    }

    public function getDistrict(Request $request)
    {
        $districts = District::limit(5);

        if ($request->name) {
            $districts = $districts->where('name', 'like', $request->name . '%');
        }

        $districts = $districts->get();

        return response()->json($districts);
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        // $action = $request->get('action');
        // $ads = Ads::whereId($id)->first();
        $ads = Ads::whereId($request->ads_id)->first();
       
    
        if ($ads) {
            $ads->is_active = $ads->is_active ? 0 : 1;
            $ads->save(); 
            if($ads->is_active){
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
        
                $this->manageAdvertisingPoints($request, $ads, $auth, 'ABC010');
            }
        }
        // if ($action == 'activate') {
        //     $ads->update([
        //         'is_active' => true
        //     ]);

        //     session()->flash('success', 'Iklan berhasil diaktifkan!');
        // } else if ($action == 'deactivate') {
        //     $ads->update([
        //         'is_active' => false
        //     ]);

        //     session()->flash('success', 'Iklan berhasil dinonaktifkan!');
        // }
        return back();
    }

    function viewFood(Request $request,$slug='') {
        $auth = Auth::user();
        $ads = Ads::where('ads.slug', $slug)
        ->leftjoin('ofoods', 'ofoods.ads_id', '=', 'ads.id')
        ->leftjoin('id_districts','id_districts.id','=','ofoods.districtId')
        ->leftjoin('id_cities','id_cities.code','=','id_districts.city_code')
        ->leftjoin('id_provinces','id_provinces.code','=','id_cities.province_code')
        ->select('ads.*', 'ofoods.*', 'ads.id as ads_id','ofoods.id as ofoods_id','id_cities.name as name_cities','id_provinces.name as name_provinces')
        ->first();
        // dd($ads);
        $media = Media::where('model_id', $ads->ads_id)
        ->select('id', 'disk', 'file_name')
        ->get()
        ->map(function ($item) {
            return [
                'url' => asset($item->disk . '/' . $item->file_name), // Menggunakan asset helper untuk URL yang benar
                'id' => $item->id
            ];
        });
        // dd($media);
        $BosterAds = BosterAds::join('boster_ads_t_ypes','boster_ads_t_ypes.id','=','boster_ads.booster_type_id')
        ->where('boster_ads.ads_id', $ads->ads_id)
        ->where('boster_ads.user_id', $auth->id)
        ->select('boster_ads_t_ypes.title','boster_ads.created_at')
        ->orderBy('created_at','DESC')
        ->get();
    // dd($BosterAds);
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
    $navLink = $request->navLink;

    $bosterAdsType = bosterAdsTYpe::where('type','property')->get();
    
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius');
    $searchQuery = $request->input('searchQuery');
    $perPage = $request->input('perPage', 10);
    $page = $request->input('page', 3);
    $code = $request->input('code', 'PTYHOME');
    $slug = $request->input('slug');

    $position = $this->getPropertyPosition($latitude, $longitude, $radius, $searchQuery, $perPage, $page, $code, $slug);

       
    // dd($ads);
        return view('Pages/ControlPanel/Member/Food/view',compact('ads','navLink','media','bosterAdsType','BosterAds'));
    }

    function uploadImagesFood(Request $request, $ads_id)
    {
        $images = $request->input('images');
        $imageUrls = [];
    
        foreach ($images as $image) {
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $fileName = Str::random(10) . '.jpg';
            $disk = 'images/food/' . $ads_id ;
            $imageName =$disk. '/' . $fileName;
    
            // Save image to storage
            Storage::disk('public')->put($imageName, base64_decode($image));
    
            // Get image URL
            $imageUrl = Storage::url($imageName);
            $imageUrls[] = $imageUrl;
    
            // Save image details to the database
            Media::create([
                'model_type' => 'App\\Models\\YourModel', // Adjust to your actual model type
                'model_id' => $ads_id,
                'uuid' => (string) Str::uuid(),
                'collection_name' => 'default', // Adjust if you have specific collections
                'name' => pathinfo($fileName, PATHINFO_FILENAME),
                'file_name' => $fileName,
                'mime_type' => 'image/jpeg',
                'disk' => 'storage/'.$disk,
                'conversions_disk' => 'public', // Adjust if you have different conversion disks
                'size' => Storage::disk('public')->size($imageName),
                'manipulations' => json_encode([]), // Default manipulations
                'custom_properties' => json_encode([]), // Default custom properties
                'generated_conversions' => json_encode([]), // Default conversions
                'responsive_images' => json_encode([]), // Default responsive images
            ]);
        }
        session()->flash('success', 'Images uploaded successfully.');
        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully.',
            'urls' => $imageUrls
        ]);
    }

    function editFood(Request $request, $slug=''){
        $auth = Auth::user();
        $ads = Ads::where('ads.slug', $slug)
        ->leftjoin('ofoods', 'ofoods.ads_id', '=', 'ads.id')
        ->leftjoin('id_districts','id_districts.id','=','ofoods.districtId')
        ->leftjoin('id_cities','id_cities.code','=','id_districts.city_code')
        ->leftjoin('id_provinces','id_provinces.code','=','id_cities.province_code')
        ->select('ads.*', 'ofoods.*', 'ads.id as ads_id','ofoods.id as ofoods_id','id_cities.name as name_cities','id_provinces.name as name_provinces')
        ->first();
        // dd($ads);
        $media = Media::where('model_id', $ads->ads_id)
        ->select('id', 'disk', 'file_name')
        ->get()
        ->map(function ($item) {
            return [
                'url' => asset($item->disk . '/' . $item->file_name), // Menggunakan asset helper untuk URL yang benar
                'id' => $item->id
            ];
        });
        // dd($media);
        $BosterAds = BosterAds::join('boster_ads_t_ypes','boster_ads_t_ypes.id','=','boster_ads.booster_type_id')
        ->where('boster_ads.ads_id', $ads->ads_id)
        ->where('boster_ads.user_id', $auth->id)
        ->select('boster_ads_t_ypes.title','boster_ads.created_at')
        ->orderBy('created_at','DESC')
        ->get();
        // dd($BosterAds);
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
    $navLink = $request->navLink;
    
    $bosterAdsType = bosterAdsTYpe::where('type','property')->get();
    
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius');
    $searchQuery = $request->input('searchQuery');
    $perPage = $request->input('perPage', 10);
    $page = $request->input('page', 3);
    $code = $request->input('code', 'PTYHOME');
    $slug = $request->input('slug');
    
    $position = $this->getPropertyPosition($latitude, $longitude, $radius, $searchQuery, $perPage, $page, $code, $slug);
    
    // dd($slug);
    

    $certificate = AdsProperty::getAllCertificates();
    $apartmenType = AdsProperty::getApartmenType();
    $propertyType = AdsProperty::getAllPropertyType();
    $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
    return view('Pages/ControlPanel/Member/Food/edit',compact('ads','navLink','media','bosterAdsType','BosterAds'));
    // return view('Pages/ControlPanel/Member/Food/adsFoodPage', [
    //     'isUpdate' => false,
    //     'data' => $request->all(),
    //     'certificate' => $certificate,
    //     'apartmentType' => $apartmenType,
    //     'getAllEnvironmentalConditions' => $getAllEnvironmentalConditions,
    //     'propertyType' => $propertyType,
    // ]);
    // dd($ads);
    }
    
    public function updateMedia(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        $newImage = $request->file('media');

        $disk = str_replace('storage/', '', $media->disk);
        // Delete the old image
        Storage::disk('public')->delete($disk. '/' . $media->file_name);

        // Process and store new image
        $fileName = Str::random(10) . '.jpg';
        $imageName = $disk . '/' . $fileName;

        // Save new image to storage
        Storage::disk('public')->put($imageName, file_get_contents($newImage));

        // Update media record
        $media->update([
            'name' => pathinfo($fileName, PATHINFO_FILENAME),
            'file_name' => $fileName,
            'disk' => 'storage/'.$disk,
            'size' => Storage::disk('public')->size($imageName),
        ]);

        return back()->with('success', 'Media updated successfully');
    }

    public function deleteMedia($id)
    {
        $media = Media::findOrFail($id);

        // Delete image from storage
        Storage::disk('public')->delete('images/food/' . $media->model_id . '/' . $media->file_name);

        // Delete media record
        $media->delete();

        return back()->with('success', 'Media deleted successfully');
    }
    function editAdresFood($slug) {
        return view('Pages/ControlPanel/Member/Food/createRegion', [
            'isUpdate' => false,
            'url' => route('listing.control-panel.food.update.addres',$slug)
        ]);
    }

    public function updateFood(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
        ]);

        // try {
             // Temukan iklan berdasarkan ID
             $ad = Ads::findOrFail($id);
             $food = Food::where('ads_id',$id)->first();
             // Membersihkan input harga agar menjadi numeric
             $cleanPrice = str_replace(['Rp.', ',',' ','.'], '', $request->input('price'));
             
             // Pastikan harga adalah numeric
             if (!is_numeric($cleanPrice)) {
                 return redirect()->back()->with('error', 'Harga harus berupa angka.');
                }
                
                // Update data iklan
                $ad->title = $request->input('title');
                $ad->description = $request->input('description');
                $ad->save();
                $food->price = (int) $cleanPrice; // Konversi ke integer
                $food->save();
                // dd($ad);
                // Redirect dengan pesan sukses
            return redirect(route('listing.control-panel.view.food',$ad->slug))->with('success', 'Iklan berhasil diperbarui.');
            // return redirect()->route('ads.index')->with('success', 'Iklan berhasil diperbarui.');
        // } catch (\Exception $e) {
        //     // Redirect dengan pesan error jika terjadi kesalahan
        //     // return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui iklan.');
        // }
    }

    function updateAddresFood(Request $request,$slug='') {
        $ads = Ads::where('slug',$slug)->first();
        $district = District::whereId($request->districtId)->first();
        $ofood = Food::where('ads_id',$ads->id)->first();
        $ofood->district = $district->name;
        $ofood->districtId = $district->id;
        $ofood->districtLocation_lat = $request->lat;
        $ofood->districtLocation_long = $request->lng;
        $ofood->kawasan = $request->area;
        $ofood->alamat = $request->adres;
        $ofood->save();
        // dd($ofood);

        return redirect(route('listing.control-panel.view.food',$ads->slug))->with('success', 'Alamat Berhasil di ubah');
    }

    function setMediaUtamaFood(Request $request,$ofoods_id='') {
        $AdsFood =  Food::whereId($ofoods_id)->first(); 
        $AdsFood->image = $request->url;
        $AdsFood->save(); 
        return back()->with(['navLink' => 'galeri', 'success' => 'Media berhasil diperbarui.']);
    }


    // ------------------------------------------
    function viewmarchant(Request $request,$slug=''){
        $auth = Auth::user();
        $ads = Ads::where('ads.slug', $slug)
        ->join('omerchants', 'omerchants.ads_id', '=', 'ads.id')
        ->leftjoin('id_districts','id_districts.id','=','omerchants.districtId')
        ->leftjoin('id_cities','id_cities.code','=','id_districts.city_code')
        ->leftjoin('id_provinces','id_provinces.code','=','id_cities.province_code')
        ->select('ads.*', 'omerchants.*', 'ads.id as ads_id','omerchants.id as omerchants_id','id_cities.name as name_cities','id_provinces.name as name_provinces')
        ->first();
        // dd($ads);
        $media = Media::where('model_id', $ads->ads_id)
        ->select('id', 'disk', 'file_name')
        ->get()
        ->map(function ($item) {
            return [
                'url' => asset($item->disk . '/' . $item->file_name), // Menggunakan asset helper untuk URL yang benar
                'id' => $item->id
            ];
        });
        // dd($media);
        $BosterAds = BosterAds::join('boster_ads_t_ypes','boster_ads_t_ypes.id','=','boster_ads.booster_type_id')
        ->where('boster_ads.ads_id', $ads->ads_id)
        ->where('boster_ads.user_id', $auth->id)
        ->select('boster_ads_t_ypes.title','boster_ads.created_at')
        ->orderBy('created_at','DESC')
        ->get();
    // dd($BosterAds);
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
    $navLink = $request->navLink;

    $bosterAdsType = bosterAdsTYpe::where('type','property')->get();
    
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius');
    $searchQuery = $request->input('searchQuery');
    $perPage = $request->input('perPage', 10);
    $page = $request->input('page', 3);
    $code = $request->input('code', 'PTYHOME');
    $slug = $request->input('slug');

    $position = $this->getPropertyPosition($latitude, $longitude, $radius, $searchQuery, $perPage, $page, $code, $slug);

       
    // dd($ads);
        return view('Pages/ControlPanel/Member/Merchant/view',compact('ads','navLink','media','bosterAdsType','BosterAds'));
    }
    function editmarchant(Request $request,$slug=''){
        $auth = Auth::user();
        $ads = Ads::where('ads.slug', $slug)
        ->leftjoin('omerchants', 'omerchants.ads_id', '=', 'ads.id')
        ->leftjoin('id_districts','id_districts.id','=','omerchants.districtId')
        ->leftjoin('id_cities','id_cities.code','=','id_districts.city_code')
        ->leftjoin('id_provinces','id_provinces.code','=','id_cities.province_code')
        ->select('ads.*', 'omerchants.*', 'ads.id as ads_id','omerchants.id as omerchants_id','id_cities.name as name_cities','id_provinces.name as name_provinces')
        ->first();
        // dd($ads);
        $media = Media::where('model_id', $ads->ads_id)
        ->select('id', 'disk', 'file_name')
        ->get()
        ->map(function ($item) {
            return [
                'url' => asset($item->disk . '/' . $item->file_name), // Menggunakan asset helper untuk URL yang benar
                'id' => $item->id
            ];
        });
        // dd($media);
        $BosterAds = BosterAds::join('boster_ads_t_ypes','boster_ads_t_ypes.id','=','boster_ads.booster_type_id')
        ->where('boster_ads.ads_id', $ads->ads_id)
        ->where('boster_ads.user_id', $auth->id)
        ->select('boster_ads_t_ypes.title','boster_ads.created_at')
        ->orderBy('created_at','DESC')
        ->get();
        // dd($BosterAds);
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
    $navLink = $request->navLink;
    
    $bosterAdsType = bosterAdsTYpe::where('type','property')->get();
    
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius');
    $searchQuery = $request->input('searchQuery');
    $perPage = $request->input('perPage', 10);
    $page = $request->input('page', 3);
    $code = $request->input('code', 'PTYHOME');
    $slug = $request->input('slug');
    
    $position = $this->getPropertyPosition($latitude, $longitude, $radius, $searchQuery, $perPage, $page, $code, $slug);
    
    // dd($slug);
    

    $certificate = AdsProperty::getAllCertificates();
    $apartmenType = AdsProperty::getApartmenType();
    $propertyType = AdsProperty::getAllPropertyType();
    $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
    return view('Pages/ControlPanel/Member/Merchant/edit',compact('ads','navLink','media','bosterAdsType','BosterAds'));
    
    }

    function editAdresmarchant($slug){
        return view('Pages/ControlPanel/Member/Merchant/createRegion', [
            'isUpdate' => false,
            'url' => route('listing.control-panel.Merchant.update.addres',$slug)
        ]);
    }


    function updateAddresMarchant(Request $request,$slug='')  {
        
        $ads = Ads::where('slug',$slug)->first();
        $district = District::whereId($request->districtId)->first();
        $Merchant = Merchant::where('ads_id',$ads->id)->first();
        $Merchant->district = $district->name;
        $Merchant->districtId = $district->id;
        $Merchant->districtLocation_lat = $request->lat;
        $Merchant->districtLocation_long = $request->lng;
        $Merchant->kawasan = $request->area;
        $Merchant->alamat = $request->adres;
        $Merchant->save();
        // dd($ofood);

        return redirect(route('listing.control-panel.marchant.view.tentang-marchant',$ads->slug))->with('success', 'Alamat Berhasil di ubah');
    }

    function updatemarchant(Request $request,$id=''){
         // Validasi data input
         $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
        ]);
        
        // try {
            // Temukan iklan berdasarkan ID
            $ad = Ads::findOrFail($id);
            $Merchant = Merchant::where('ads_id',$id)->first();
            // Membersihkan input harga agar menjadi numeric
            $cleanPrice = str_replace(['Rp.', ',',' ','.'], '', $request->input('price'));
            
            // dd($cleanPrice);
            // Pastikan harga adalah numeric
            if (!is_numeric($cleanPrice)) {
                return redirect()->back()->with('error', 'Harga harus berupa angka.');
            }
            
                // Update data iklan
                $ad->title = $request->input('title');
                $ad->description = $request->input('description');
                $ad->save();
                $Merchant->price = (int) $cleanPrice; // Konversi ke integer
                $Merchant->save();
                // dd($ad);
                // Redirect dengan pesan sukses
            return redirect(route('listing.control-panel.marchant.view.tentang-marchant',$ad->slug))->with('success', 'Iklan berhasil diperbarui.');
            // return redirect()->route('ads.index')->with('success', 'Iklan berhasil diperbarui.');
        // } catch (\Exception $e) {
        //     // Redirect dengan pesan error jika terjadi kesalahan
        //     // return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui iklan.');
        // }
    }


    function wilayahKerja(){
        $user = Auth::user();
        $wilayahKerjas = WilayahKerja::where('user_id',$user->id)->get();
        return view('Pages/Member/WilayahKerja/index',compact('wilayahKerjas'));
    }

    function wilayahKerjaCreate() {
        return view('Pages/Member/WilayahKerja/wilayahKerjaStore', [
            'isUpdate' => false,
            'url' => route('listing.control-panel.wilayah-kerja.store','99')
        ]);
        
    }

    function wilayahKerjaStore(Request $request){
         // Validasi input
         $validatedData = $request->validate([
            'districtId' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
        ]);

        // Menyimpan data ke dalam database
        $wilayahKerja = new WilayahKerja();
        $wilayahKerja->user_id = auth()->user()->id; // atau masukkan ID user yang sesuai
        $wilayahKerja->district_id = $validatedData['districtId'];
        $wilayahKerja->district_name = $validatedData['district'];
        $wilayahKerja->lat = $validatedData['lat'];
        $wilayahKerja->lng = $validatedData['lng'];
        $wilayahKerja->area = $validatedData['area'];
        $wilayahKerja->address = $validatedData['adres'];

        $wilayahKerja->save();
        return redirect(route('listing.control-panel.wilayah-kerja'))->with('success', 'Berhasil Menambahkan Wilayah Kerja');
        // Redirect atau response sesuai kebutuhan Anda
        // return response()->json([
        //     'message' => 'Data wilayah kerja berhasil ditambahkan',
        //     'data' => $wilayahKerja
        // ], 201);
    }

  
}
