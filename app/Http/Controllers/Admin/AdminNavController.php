<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AdsProperty;
use App\Models\Food;
use App\Models\Bank;
use App\Models\User;
use App\Models\Media;
use App\Models\PropertyType;
use App\Models\Merchant;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\AdsBankLelang;
use App\Models\Kpr;
use App\Models\Cities;
use App\Models\Provinces;
use App\Models\EmailBank;
use App\Models\AdBalaceControl;
use App\Models\KprFileBank;
use App\Models\KprResponseBank;
use File;
use ZipArchive;
use App\Models\Transaksi;
use App\Models\PlansTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
// composer require intervention/image


use App\Services\KodeService;

use App\Models\Ads;
use App\Models\BalachBoosterAds;
use App\Models\bosterAdsTYpe;

class AdminNavController extends Controller
{
    
    use KodeService;
    function properti()
    {
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";


        $properties = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->select(
                "ads_properties.id",
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "users.name as name_user",
                "ads_properties.ads_type",
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




        return Inertia::render('Admin/Page/Properti/Index', ['properties' => $properties->items(), 'pagination' => $properties]);
    }

    function lelang()
    {
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";


        $properties = AdsProperty::join('ads', 'ads.id', '=', 'ads_properties.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->where('ads.type', 'lelang')
            ->select(
                "ads_properties.id",
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
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


        return view('Pages/ControlPanel/Admin/Lelang/index', ['properties' => $properties->items(), 'pagination' => $properties, 'title' => 'Lelang']);

        // return Inertia::render('Admin/Page/Properti/Index', ['properties' => $properties->items(), 'pagination' => $properties, 'title' => 'Lelang']);
    }

    function lelangCreate()
    {
        return view('Pages/ControlPanel/Admin/Lelang/createRegion', [
            'isUpdate' => false,
            'url' => 'admin.nav.lelang.create-listing'
        ]);


    }
    function lelangCreateListing(Request $request)
    {
        // dd($request->all());
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
        $environmentalConditions = AdsProperty::getAllEnvironmentalConditions();
        $getAllEnvironmentalConditions = AdsProperty::getAllEnvironmentalConditions();
        $bank = Bank::orderBy('province', 'asc')
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
        // dd($bank['BALI']['banks']);

        return view('Pages/ControlPanel/Admin/Lelang/adsLelangPage', [
            'isUpdate' => false,
            'data' => $request->all(),
            'certificate' => $certificate,
            'bank' => $bank,
            'apartmentType' => $apartmenType,
            'propertyType' => $propertyType,
            'environmentalConditions' => $environmentalConditions,
            'getAllEnvironmentalConditions' => $getAllEnvironmentalConditions,
        ]);
    }

    function lelangStore(Request $request)
    {
       
        $request->validate([
            'fileInput.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png', // Validasi untuk setiap file
            'fileInput' => 'required', // Pastikan setidaknya satu file diunggah
            'bank_id' => 'required', // Pastikan bank diisi
            'title' => 'required|string|max:255',
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
            'certificate' => 'nullable',
            'year_built' => 'nullable|date_format:Y',
            'lt' => 'nullable|integer',
            'lb' => 'nullable|integer',
            'dl' => 'nullable|integer',
            'jl' => 'nullable|integer',
            'jk' => 'nullable|integer',
            'jkm' => 'nullable|integer',
            'furniture_condition' => 'nullable|string|max:255',
            'house_facility' => 'nullable|array',
            'other_facility' => 'nullable|array',
            'video' => 'nullable|string|max:255',
        ], [
            'fileInput.*.file' => 'File harus berupa file.',
            'fileInput.*.mimes' => 'File harus berformat: pdf, doc, docx, jpg, jpeg, png.',
            'fileInput.*.max' => 'Ukuran file tidak boleh lebih dari 2048 kilobytes.',
            'fileInput.required' => 'Setidaknya satu file harus diunggah.',
            'title.required' => 'Judul harus diisi.',
            'bank_id.required' => 'Bank harus diisi.',
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
        $ads->title = $request->title. '-' . uniqid();
        $ads->slug = Str::slug($request->title) . '-' . uniqid();
        $ads->description = $request->description;
        $ads->type = 'lelang';
        $ads->published_at = Carbon::now();
        $ads->user_id = $user->id;
        $ads->is_active = $request->isActive ? 1 : 0;
        $ads->is_archived = $request->isrchived ? 1 : 0;
        $ads->status = 'available';
        $ads->save();
        $ads->uuid = $this->kodeIklanLelang('lelang',$request->bank_id,$ads->created_at,Ads::whereMonth('created_at', Carbon::now()->month)->count());
        $ads->save();
        $hargaInt = (int) preg_replace('/\D/', '', $request->price);


        $AdsProperty = new AdsProperty();
        $AdsProperty->ads_id = (string) $ads->id;
        $AdsProperty->district_id = (string) $request->district_id;
        $AdsProperty->district_name = (string) $request->district_name;
        $AdsProperty->lat = (string) $request->lat;
        $AdsProperty->lng = (string) $request->lng;
        // $AdsProperty->location = (string) $request->adds;
        $AdsProperty->area = (string) $request->area;
        $AdsProperty->address = (string) $request->adres;
        $AdsProperty->ads_type = (string) $request->ads_type;
        $AdsProperty->property_type = (string) $request->property_type;
        $AdsProperty->price = (string) $hargaInt;
        $AdsProperty->certificate = is_array($request->certificate) ? json_encode($request->certificate) : (string) $request->certificate;
        $AdsProperty->year_built = (string) date('Y', strtotime($request->year_built));
        $AdsProperty->lt = (string) $request->lt;
        $AdsProperty->lb = (string) $request->lb;
        $AdsProperty->dl = (string) $request->dl;
        $AdsProperty->jl = (string) $request->jl;
        $AdsProperty->jk = (string) $request->jk;
        $AdsProperty->jkm = (string) $request->jkm;
        $AdsProperty->furniture_condition = (string) $request->furniture_condition;
        $AdsProperty->house_facility = is_array($request->house_facility) ? json_encode($request->house_facility) : (string) $request->house_facility;
        $AdsProperty->other_facility = is_array($request->other_facility) ? json_encode($request->other_facility) : (string) $request->other_facility;
        $AdsProperty->video = (string) $request->youtubeLink;
        // $AdsProperty->property_type_id = (string) $request->adds;
        $AdsProperty->save();
        
        
        
        // dd(json_encode($request->furniture_condition));
        if ($request->hasFile('fileInput')) {
            foreach ($request->file('fileInput') as $image) {
                $path = $image->store('/images/properti/lelang/' . $ads->id, 'public');
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
                $media->disk = '/storage/images/properti/lelang/' . $ads->id; // Ganti disk sesuai konfigurasi storage

                $media->size = $image->getSize();
                $media->save();
            }
        }
        $AdsProperty->image = $media->disk . '/' . $media->file_name;
        $AdsProperty->save();
        $AdsBankLelang = new AdsBankLelang();
        $AdsBankLelang->bank_id = $request->bank_id;
        $AdsBankLelang->ads_id = $ads->id;
        $AdsBankLelang->save();
        return redirect(route('admin.nav.lelang'))->with('success', 'Lelang berhasil disimpan.');
    }

    function oFood()
    {
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";


        $OFood = Food::join('ads', 'ads.id', '=', 'ofoods.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->select(
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "users.name as name_user",
                "ads.status",
                "ads.id as ads_id",
                'media.id as media_id',
                'media.file_name as file_name',
                "ads.is_active"
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('ads.id', 'desc')
            ->paginate(10)->items();
        // dd($OFood);




        return Inertia::render('Admin/Page/OFood/Index', ['OFood' => $OFood]);
    }

    function oMerchant()
    {
        // $properties = AdsProperty::paginate(10)->items();
        $searchQuery = request()->input('search');
        // $searchQuery = "Ads 1";


        $OFood = Merchant::join('ads', 'ads.id', '=', 'omerchants.ads_id')
            ->join('media', function ($join) {
                $join->on('media.model_id', '=', 'ads.id')
                    ->whereRaw('media.id = (SELECT MIN(id) FROM media WHERE media.model_id = ads.id)');
            })
            ->join('users', 'users.id', '=', 'ads.user_id')
            ->select(
                DB::raw("CONCAT('" . Config::get('app.url') . "/storage/', media.id, '/', media.file_name) AS image_path"),
                "ads.title",
                "users.name as name_user",
                "ads.status",
                "ads.id as ads_id",
                'media.id as media_id',
                'media.file_name as file_name',
                "ads.is_active"
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('ads.title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('users.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.status', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ads.is_active', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('ads.id', 'desc')
            ->paginate(10)->items();
        // dd($OFood);




        return Inertia::render('Admin/Page/Omerchant/Index', ['OFood' => $OFood]);
    }

    function bank()
    {
        $bank = Bank::paginate(10)->items();
        // dd($bank);
        $Cities = Cities::get();
        $Provinces = Provinces::get();
        return view('Pages/ControlPanel/Admin/Master/Bank/index', ['bank' => $bank]);
        // return Inertia::render('Admin/Page/Bank/Index', ['bank' => $bank]);
    }
    function bankAdd()
    {
        $bank = Bank::paginate(10)->items();
        // dd($bank);
        $cities = Cities::get();
        $provinces = Provinces::get();
        // dd($provinces);
        return view('Pages/ControlPanel/Admin/Master/Bank/add', compact('bank', 'cities', 'provinces'));
    }
    function bankStore(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'alias_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'office_type' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'details' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'email_kpr' => 'nullable|email|max:255',
            'email_lelang' => 'nullable|email|max:255',
            'email_lainnya' => 'nullable|email|max:255',
        ]);
        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Store data in the database
        $bank = Bank::create([
            'bank' => $request->bank,
            'code' => $request->code,
            'type' => $request->type,
            'alias_name' => $request->alias_name,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'office_type' => $request->office_type,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $imagePath ?? null,
            'details' => $request->details,
            'is_active' => $request->is_active,
        ]);

        EmailBank::create([
            'bank_id' => $bank->id,
            'email' => $request->email_kpr,
            'email_type' => 'kpr',
        ]);
        EmailBank::create([
            'bank_id' => $bank->id,
            'email' => $request->email_lelang,
            'email_type' => 'lelang',
        ]);
        EmailBank::create([
            'bank_id' => $bank->id,
            'email' => $request->email_lainnya,
            'email_type' => 'lainnya',
        ]);

        return redirect(route('admin.nav.bank'))->with('success', 'Bank berhasil disimpan');
    }

    function bankEdit(Request $request, $id)
    {
        $bank = Bank::whereId($id)->first();
        $cities = Cities::get();
        $provinces = Provinces::get();
        $emailTypes = ['kpr', 'lelang', 'lainnya'];
        $emails = [];

        foreach ($emailTypes as $type) {
            $emailRecord = EmailBank::where('bank_id', $bank->id)->where('email_type', $type)->first();
            $emails[$type] = $emailRecord ? $emailRecord->email : null;
        }

        $emailKpr = $emails['kpr'];
        $emailLelang = $emails['lelang'];
        $emaillainnya = $emails['lainnya'];

        return view('Pages/ControlPanel/Admin/Master/Bank/edit', compact('bank', 'cities', 'provinces', 'emailKpr', 'emailLelang', 'emaillainnya'));
    }
    function bankUpdate(Request $request, $id)
    {
        $request->validate([
            'bank' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'alias_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'office_type' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'details' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'email_kpr' => 'nullable|email|max:255',
            'email_lelang' => 'nullable|email|max:255',
            'email_lainnya' => 'nullable|email|max:255',
        ]);

        $bank = Bank::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('image')) {
            if ($bank->image) {
                Storage::disk('public')->delete($bank->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Update bank data in the database
        $bank->update([
            'bank' => $request->bank,
            'code' => $request->code,
            'type' => $request->type,
            'alias_name' => $request->alias_name,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'office_type' => $request->office_type,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $imagePath ?? $bank->image,
            'details' => $request->details,
            'is_active' => $request->is_active,
        ]);

        $emailTypes = ['kpr', 'lelang', 'lainnya'];
        foreach ($emailTypes as $type) {
            $emailField = 'email_' . $type;
            $email = $request->$emailField;
            $emailRecord = EmailBank::where('bank_id', $bank->id)->where('email_type', $type)->first();
            if ($email) {
                if ($emailRecord) {
                    $emailRecord->update(['email' => $email]);
                } else {
                    EmailBank::create([
                        'bank_id' => $bank->id,
                        'email' => $email,
                        'email_type' => $type,
                    ]);
                }
            } elseif ($emailRecord) {
                $emailRecord->delete();
            }
        }

        return redirect(route('admin.nav.bank'))->with('success', 'Bank berhasil diperbarui');
    }

    function adsControllPanel()
    {
        $data = AdBalaceControl::get();
        return view('Pages/ControlPanel/Admin/Setting/PlanControl/index', compact('data'));

        // return Inertia::render('Admin/Page/AdsControllPanel/Index', compact('data'));
    }

    function adsControllPanelUpdatae(Request $request)
    {
        AdBalaceControl::find($request->id)->update($request->all());
        return back()->with('success', 'Pembaruan berhasil dilakukan.');
        // return response()->json(['message' => 'Update berhasil dilakukan', 'request' => $request->all()]);
    }


    function adsControllBooster()
    {
        $data = bosterAdsType::leftJoin('balach_booster_ads', 'balach_booster_ads.booster_ads_id', '=', 'boster_ads_t_ypes.id')
        ->select('boster_ads_t_ypes.*', 'balach_booster_ads.ad_balace_control_id')
        ->orderBy('boster_ads_t_ypes.id','desc')->get();
// dd($data);
        $AdBalanch = AdBalaceControl::get();
        return view('Pages/ControlPanel/Admin/Setting/BoosterControl/index', compact('data','AdBalanch'));

        // return Inertia::render('Admin/Page/AdsControllPanel/Index', compact('data'));
    }

    function adsControllBoosterUpdatae(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'limit' => 'required|integer',
        ]);

        $adsType = bosterAdsTYpe::findOrFail($id);
        $adsType->title = $request->input('title');
        $adsType->limit = $request->input('limit');
        $adsType->durasi = $request->input('durasi');
        $adsType->save();

        $add = BalachBoosterAds::where('booster_ads_id',$id)->first();

        if (!$add) {
            $add = new BalachBoosterAds();
            $add->booster_ads_id = $id;
        }

        $add->ad_balace_control_id = $request->balach_booster_ads;
        $add->save();

        return redirect()->back()->with('success', 'Ad Type updated successfully.');
    }


    function pengguna()
    {
        $user = User::paginate(10)->items();
        $bank = Bank::paginate(10)->items();
        return Inertia::render('Admin/Page/Pengguna/Index', ['user' => $user, 'bank' => $bank]);
    }
    function penggunaDetail($id)
    {
        $user = User::find($id);
        return Inertia::render('Admin/Page/Pengguna/DetailPengguna', ['user' => $user]);
    }

    function tipeProperti()
    {
        $PropertyType = PropertyType::paginate(10)->items();
        // dd($PropertyType);
        return Inertia::render('Admin/Page/PropertyType/Index', ['PropertyType' => $PropertyType]);
    }

    function districts()
    {
        $idDistricts = DB::table('id_districts')
            ->join('id_cities', 'id_cities.code', '=', 'id_districts.city_code')
            ->join('id_provinces', 'id_provinces.code', '=', 'id_cities.province_code')
            ->orderBy('id_districts.name', 'asc')
            ->select('id_districts.id', 'id_districts.name as district', 'id_districts.city_code', 'id_cities.name as citie', 'id_provinces.name as province')
            ->paginate(10)->items();

        return Inertia::render('Admin/Page/District/Index', ['idDistricts' => $idDistricts]);
    }

    function citie()
    {
        $idCities = DB::table('id_cities')
            ->join('id_provinces', 'id_provinces.code', '=', 'id_cities.province_code')
            ->orderBy('id_cities.name', 'asc')
            ->select('id_cities.id', 'id_cities.name as citie', 'id_provinces.name as province')
            ->paginate(10)->items();

        return Inertia::render('Admin/Page/Citie/Index', ['idCities' => $idCities]);
    }

    function provinces()
    {
        $idprovinces = DB::table('id_provinces')
            ->orderBy('id_provinces.name', 'asc')
            ->select('id_provinces.name as province')
            ->paginate(10)->items();

        return Inertia::render('Admin/Page/Province/Index', ['idprovinces' => $idprovinces]);
    }

    function banner()
    {
        $banners = Banner::orderBy('name', 'asc')
            ->paginate(10)->items();
        // dd($banners);
        return view('Pages/ControlPanel/Admin/Browser/Banner/banner', compact('banners'));

        // return Inertia::render('Admin/Page/Banner/Index', ['banner' => $banner]);
    }
    function bannerCreate()
    {
        $banners = Banner::orderBy('name', 'asc')
            ->paginate(10)->items();
        return view('Pages/ControlPanel/Admin/Browser/Banner/create', compact('banners'));
        // return Inertia::render('Admin/Page/Banner/Create', ['banner' => $banner]);
    }
    function bannerEdit($id='')
    {
        $banner = Banner::whereId($id)->first();
        return view('Pages/ControlPanel/Admin/Browser/Banner/edit', compact('banner'));
        // return Inertia::render('Admin/Page/Banner/Edit', ['banner' => $banner]);
    }
    function bannerStore(Request $request)
    {
        // return response()->json(['message' => 'Banner created successfully', 'request' => $request->all()], 201);
        // $validatedData = $request->validate([
        //     'name' => 'required|string',
        //     'description' => 'nullable|string',
        //     'url' => 'nullable|string',
        //     'image' => 'required|image',
        //     'is_active' => 'required|boolean',
        //     'show_on' => 'required|string|in:homepage,lelang,ofood,omarchent',
        //     'order' => 'nullable|integer',
        // ]);





        $imagePathStored = $request->file('image')->store('images/banner', 'public');
        $banner = new Banner();
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->url = $request->url;
        $banner->image = $imagePathStored;
        $banner->is_active = $request->is_active ? 1 : 0;
        $banner->show_on = $request->show_on;
        $banner->order = $request->order;
        $banner->save();
        return redirect(route('admin.nav.banner'));
        // return response()->json(['message' => 'Banner created successfully'], 201);
    }

    function bannerUpdate(Request $request, $id)
    {


        $banner = Banner::find($id);
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->url = $request->url;
        if ($request->file('image')) {
            $imagePathStored = $request->file('image')->store('images/banner', 'public');

            $banner->image = $imagePathStored;
        }
        $banner->is_active = $request->is_active ? 1 : 0;
        $banner->show_on = $request->show_on;
        $banner->order = $request->order;
        $banner->save();
        return redirect()->route('admin.nav.banner')->with('success', 'Banner berhasil disimpan');

        // return response()->json(['message' => 'Banner updated successfully']);
    }

    function plans()
    {
        $plans = DB::table('plans')->orderBy('name', 'asc')
            ->paginate(10)->items();
        // dd($plans);
        return Inertia::render('Admin/Page/Plans/Index', ['plans' => $plans]);
        // return view('Pages/ControlPanel/Admin/Setting/Plan/index', compact('plans'));
    }

    function websiteAdsSections()
    {
        $websiteAdsSections = DB::table('website_ads_sections')->orderBy('name', 'asc')
            ->paginate(10)->items();
        return Inertia::render('Admin/Page/WebsiteAdsSection/Index', ['websiteAdsSections' => $websiteAdsSections]);
    }

    function settings()
    {

        $setting = Setting::orderBy('key', 'asc')
            ->paginate(10)->items();
        return Inertia::render('Admin/Page/Setting/Index', ['setting' => $setting]);
    }

    function transaksiPanding()
    {
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.payment_status', '=', 'pending')
            ->where('transaksis.transaction_status', '=', 'pending')
            ->orderBy('transaksis.id', 'asc')
            ->paginate(10);
        // dd($transaksi);
        return Inertia::render('Admin/Page/Transaksi/Index', ['transaksi' => $transaksi->items(), 'title' => 'Panding']);

    }

    function transaksiProcessing()
    {
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.payment_status', '=', 'pending')
            ->where('transaksis.transaction_status', '=', 'processing')
            ->select('transaksis.created_at as tgl_transaksi', 'transaksis.id', 'plans.description', 'transaksis.payment_method', 'transaksis.amount')
            ->orderBy('transaksis.id', 'asc')
            ->paginate(10);
        // dd($transaksi);
        return Inertia::render('Admin/Page/Transaksi/Index', ['transaksi' => $transaksi->items(), 'title' => 'Approval']);

    }

    function transaksiProcessingDetail($transactionId = '')
    {
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.id', $transactionId)
            ->first();


        // $bank = Bank::paginate(10)->items();
        return Inertia::render('Member/Page/Transaksi/Invoice', ['transaksi' => $transaksi, 'slug' => 'apem']);
    }

    function transaksiSuccessDetail($transactionId = '')
    {
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.payment_status', '=', 'success')
            ->where('transaksis.transaction_status', '=', 'delivered')
            ->select('transaksis.created_at as tgl_transaksi', 'transaksis.id', 'plans.description', 'transaksis.payment_method', 'transaksis.amount')
            ->orderBy('transaksis.id', 'asc')
            ->paginate(10);
        // dd($transaksi);
        return Inertia::render('Admin/Page/Transaksi/Index', ['transaksi' => $transaksi->items(), 'title' => 'Success']);
    }

    function transaksiCanceledDetail($transactionId = '')
    {
        $transaksi = PlansTransaksi::join('transaksis', 'transaksis.id', '=', 'plans_transaksis.transaksis_id')
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->where('transaksis.payment_status', '=', 'canceled')
            ->where('transaksis.transaction_status', '=', 'canceled')
            ->select('transaksis.created_at as tgl_transaksi', 'transaksis.id', 'plans.description', 'transaksis.payment_method', 'transaksis.amount')
            ->orderBy('transaksis.id', 'asc')
            ->paginate(10);
        // dd($transaksi);
        return Inertia::render('Admin/Page/Transaksi/Index', ['transaksi' => $transaksi->items(), 'title' => 'Canceled']);
    }

    function pengajuanKpr()
    {



        $kpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->select(
                'kpr.*',
                'userAgen.name as namaAgen',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'bankBpr.email as bank_bpr_email'
            )
            ->get();
        // dd($kpr);
        return view('Pages/ControlPanel/Admin/Pengajuan/pengajuanKpr', compact('kpr'));
        // return Inertia::render('Admin/Page/Pengajuan/Kpr/Index', compact('kpr'));
    }


    function uploadXlxs(Request $request)
    {
        $kpr = Kpr::where('uuid', $request->kodeKpr)->first();
        // Bad Request
        if ($kpr) {
            $responBank = KprResponseBank::where('kpr_id', $kpr->id)->first();
            // $responBank = KprResponseBank::first();
            if (!$responBank) {
                $responBank = new KprResponseBank();

            }

            $responBank->kpr_id = $kpr->id;
            $responBank->tanggal = $request->tanggal;
            $responBank->kodeKpr = $request->kodeKpr;
            $responBank->namaPengajuan = $request->namaPengajuan;
            $responBank->noVisitor = $request->noVisitor;
            $responBank->proses = $request->proses;
            $responBank->status = $request->status;
            $responBank->save();
            $kpr->status = $request->proses;
            $kpr->save();
            return response()->json([
                'message' => 'Data uploaded and processed successfully',
                'error' => false,
                'kpr_id' => $kpr->id,
                'request' => $request->all(),
            ], 200);

        }
        return response()->json([
            'message' => 'No file uploaded.',
            'error' => true,
            'request' => $request->all()
        ], 200); // Bad Request
    }

    function pengajuanLelang()
    {

        $pengajuanLelang = Lelang::query()
            ->join('ads', 'ads.id', '=', 'lelangs.ads_id')
            ->join('users as agen', 'agen.id', '=', 'lelangs.agen_id')
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
                'agen.wa_phone',
                'agen.company_name',
            )
            ->distinct()
            ->get();
        return view('Pages/ControlPanel/Admin/Pengajuan/pengajuanLelang', compact('pengajuanLelang'));
        // return Inertia::render('Admin/Page/Pengajuan/Kpr/Index', compact('kpr'));
    }

    function pengajuanDetailLelang($id) {
        $pengajuanLelang = Lelang::query()
            ->join('ads', 'ads.id', '=', 'lelangs.ads_id')
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->join('users as agen', 'agen.id', '=', 'lelangs.agen_id')
            ->join('ads_bank_lelangs','ads_bank_lelangs.ads_id','=','ads.id')
            ->join('banks','banks.id','=','ads_bank_lelangs.bank_id')
            ->where('lelangs.id',$id)
            ->select(
                'lelangs.id',
                'lelangs.bank_id',
                'lelangs.created_at',
                'lelangs.status',
                'lelangs.image_ktp',
                'lelangs.image_kk',
                'lelangs.agen_id',
                'lelangs.agreement',
                'lelangs.kpr_name',
                'lelangs.kpr_email',
                'banks.alias_name',
                'banks.type as bank_type',
                'lelangs.kpr_phone',
                'ads.slug as ads_slug',
                'ads.id as ads_id',
                'ads.title',
                'agen.name as namaAgen',
                'ads_properties.image',
                'ads_properties.price',
                'ads_properties.area',
            )
            ->distinct()
            ->first();
            // dd($pengajuanLelang->id);
            // $ads = Ads::where('ads.slug', $slug)
            // ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            // ->select('ads.*', 'ads_properties.*')
            // ->first();
        $user = User::find($pengajuanLelang->agen_id); 
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

            // dd($pengajuanLelang);
            return view('Pages/ControlPanel/Admin/Pengajuan/detailPengajuanLelang', compact('pengajuanLelang','agent'));
    }

    function pengajuanDetailKpr($id)
    {

        $kpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->where('kpr.id', $id)
            ->select(
                'kpr.*',
                'userAgen.name as namaAgen',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'bankBpr.email as bank_bpr_email',
                'ads.slug'
            )
            ->first();
        $ads = Ads::where('ads.slug', $kpr->slug)
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->select('ads.*', 'ads_properties.*')
            ->first();
        $user = User::find($ads->user_id);
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
        // dd($kpr);
        $filebankUmum = KprFileBank::join('file_banks', 'file_banks.id', '=', 'file_bank_id')->where('kpr_file_banks.kpr_id', $kpr->id)->where('file_banks.file_type', 'bank_umum')->get();
        // dd($filebankUmum);
        $filebankBpr = KprFileBank::join('file_banks', 'file_banks.id', '=', 'file_bank_id')->where('kpr_file_banks.kpr_id', $kpr->id)->where('file_banks.file_type', 'bank_bpr')->get();
        return view('Pages/ControlPanel/Admin/Pengajuan/detailKpr', compact('kpr', 'ads', 'user', 'agent', 'filebankUmum', 'filebankBpr'));
        // return Inertia::render('Admin/Page/Pengajuan/Kpr/DetailKpr', compact('kpr'));
    }

    function settingStatusKpr(Request $request, $id)
    {
        $kpr = Kpr::whereId($id)->first();
        $kpr->status = $request->status;
        $kpr->save();
        return back()->with('success', 'Status Pengajuan KPR Berhasil Diubah');
    }

    public function downloadKprFiles($kprId)
    {
        $kpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->where('kpr.id', $kprId)
            ->select(
                'kpr.*',
                'userAgen.name as namaAgen',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'bankBpr.email as bank_bpr_email'
            )
            ->first();

        if (!$kpr) {
            return response()->json(['error' => 'Data KPR tidak ditemukan'], 404);
        }

        $zip = new ZipArchive;
        $fileName = 'KPR_Files_' . $kprId . '.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $filesToZip = [
                $kpr->image_ktp,
                $kpr->image_kk,
                $kpr->image_npwp,
                $kpr->image_surat_nikah,
                $kpr->image_rekening_koran,
                $kpr->image_slip_gaji
            ];

            foreach ($filesToZip as $file) {
                if ($file) {
                    $absolutePath = public_path($file);
                    if (file_exists($absolutePath)) {
                        $zip->addFile($absolutePath, basename($file));
                    }
                }
            }

            $zip->close();
            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Gagal membuat file ZIP'], 500);
        }
    }

    function typeProperti()  {
        
    }

}
