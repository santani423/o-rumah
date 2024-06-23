<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Ads;
use App\Models\Media;
use App\Models\AdsProperty;
use App\Models\Kpr;
use App\Models\User;
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

class ListingController extends Controller
{
    public function index(Request $request)
    {
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";

        $user = Auth::user();
        $properties = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->where('ads.type', 'property')
            ->where('users.id', $user->id)
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
        // dd($properties);

        return view('Pages/ControlPanel/Member/Properti/index', compact('properties'));
        // return Inertia::render('Listing/ListingPage', [
        //     'properties' => $properties->items(),
        //     'pagination' => $properties,
        //     'title' => 'Lelang'
        // ]);
    }
    function viewProperty($slug=''){
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


       

        return view('Pages/ControlPanel/Member/Properti/view',compact('ads'));
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
  
    return view('Pages/ControlPanel/Member/Properti/Edit/tentangProperti',compact('ads'));
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
            $prop->housing_name = $request->namaKomplek;
            $prop->cluster_name = $request->namaCluster;
            $prop->year_built = Carbon::parse($request->tahunDibangun)->format('Y');
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
        $hargaInt = (int) str_replace(['.', ''], '', $harga);



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
        // $AdsProperty->housing_name = $request->adds;
        // $AdsProperty->cluster_name = $request->adds;
        $AdsProperty->year_built = date('Y', strtotime($request->tahunDiBangun));

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

    public function toggle(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        // $action = $request->get('action');
        // $ads = Ads::whereId($id)->first();
        $ads = Ads::whereId($id)->first();
        $ads->is_active = $ads->is_active ? 0 : 1;
        $ads->save();
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
}
