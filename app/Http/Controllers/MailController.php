<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use Illuminate\Http\Request;
use App\Mail\MyTestMail;
use App\Models\Ads;
use App\Models\EmailBank;
use App\Models\Kpr;
use App\Models\Lelang;
use App\Models\User;
use App\Models\PasswordChanges;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Services\WhatsAppService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

use App\Mail\WelcomeDeveloper;
class MailController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function index()
    {

        $details = [
            'title' => 'Mail from websitepercobaan.com',
            'body' => 'This is for testing email using smtp'
        ];

        Mail::to('1123150108@global.ac.id')->send(new \App\Mail\MyTestMail($details));

        return response()->json([
            'message' => 'Email berhasil dikirim'
        ]);

    }
    public function adminEmailBank(Request $request)
    {

        $kpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->join('jobs', 'jobs.id', '=', 'kpr.job_id')
            ->where('kpr.id', $request->kpr_id)
            ->select(
                'kpr.*',
                'userAgen.name as namaAgen',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'jobs.title as job_title',
                'bankBpr.email as bank_bpr_email'
            )
            ->first();

        // return response()->json([
        //     'message' => 'Email berhasil dikirim',
        //     'kpr' => $kpr
        // ]);

        $details = [
            'title' => 'Pengajuan KPR',
            'nama' => $kpr->kpr_name,
            'jabatan' => $kpr->job_title,
            'alamat' => $kpr->kpr_name,
            'body' => 'This is for testing email using smtp'
        ];



        Mail::to($request->bank_umum_email)->send(new \App\Mail\BankEmail($details));
        Mail::to($request->bank_bpr_email)->send(new \App\Mail\BankEmail($details));

        return response()->json([
            'message' => 'Email berhasil dikirim'
        ]);

    }

    function responseBackPengajuanKpr(Request $request)
    {
        $kpr = Kpr::orderBy('created_at', 'asc')
            ->join('ads', 'ads.id', '=', 'kpr.ads_id')
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->join('users as userAgen', 'userAgen.id', '=', 'ads.user_id')
            ->join('banks as bankUmum', 'bankUmum.id', '=', 'kpr.bank_id')
            ->join('banks as bankBpr', 'bankBpr.id', '=', 'kpr.bank_bpr_id')
            ->join('jobs', 'jobs.id', '=', 'kpr.job_id')
            ->join('kpr_response_banks', 'kpr_response_banks.kpr_id', '=', 'kpr.id')
            ->where('kpr.id', $request->kpr_id)
            ->select(
                'kpr.*',
                'kpr.uuid as kode_kpr',
                'ads_properties.uuid as kode_properti',
                'userAgen.id as id_agent',
                'userAgen.name as namaAgen',
                'userAgen.email as emailAgent',
                'userAgen.phone as phoneAgent',
                'bankUmum.alias_name as bank_umum_name',
                'bankUmum.email as bank_umum_email',
                'bankBpr.alias_name as bank_bpr_name',
                'jobs.title as job_title',
                'kpr_response_banks.status',
                'kpr_response_banks.namaPengajuan',
                'kpr_response_banks.proses',
                'bankBpr.email as bank_bpr_email'
            )
            ->first();

        // return response()->json([
        //     'message' => 'Email berhasil dikirim',
        //     'request' => $request->all(),
        //     'kpr'=>$kpr,
        // ]);
        $details = [
            'title' => '',
            'kodeKpr' => $kpr->kode_kpr,
            'kodeProerty' => $kpr->kode_properti,
            'agent' => $kpr->namaAgen,
            'namaPengaju' => $kpr->namaPengajuan,
            'status' => $kpr->status,
            'proses' => $kpr->proses
        ];

        $message = "Response bank,\n Kode Pengajuan KPR:$kpr->kode_kpr,\nKode Property:$kpr->kode_properti,\nAgent:$kpr->namaAgen,\nNama Pengajuan:$kpr->namaPengajuan ,\nProses:$kpr->proses";
        $response = $this->whatsAppService->sendMessage($kpr->kpr_phone, $message);
        $response = $this->whatsAppService->sendMessage($kpr->phoneAgent, $message);
        Mail::to($kpr->kpr_email)->send(new \App\Mail\ResponseBankKpr($details));
        Mail::to($kpr->emailAgent)->send(new \App\Mail\ResponseBankKpr($details));
        return response()->json([
            'message' => $kpr->kpr_email
        ]);

    }



    function adminEmailBankLelang(Request $request)
    {
        $pengajuanLelang = Lelang::query()
            ->join('ads', 'ads.id', '=', 'lelangs.ads_id')
            ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
            ->join('users as agen', 'agen.id', '=', 'lelangs.agen_id')
            ->join('ads_bank_lelangs', 'ads_bank_lelangs.ads_id', '=', 'ads.id')
            ->join('banks', 'banks.id', '=', 'ads_bank_lelangs.bank_id')
            ->where('lelangs.id', $request->lelang_id)
            ->select(
                'lelangs.id',
                'banks.id as bank_id',
                'lelangs.uuid as kd_lelang',
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
                'agen.email as emailAgent',
                'ads_properties.image',
                'ads_properties.price',
                'ads.uuid as kd_property',
            )
            ->distinct()
            ->first();
        // dd(str_replace('/storage','app/public',$pengajuanLelang->image_ktp));
        // $ads = Ads::where('ads.slug', $slug)
        // ->join('ads_properties', 'ads_properties.ads_id', '=', 'ads.id')
        // ->select('ads.*', 'ads_properties.*')
        // ->first();
        $emailBank = EmailBank::where('bank_id', $pengajuanLelang->bank_id)->where('email_type', 'lelang')->first();
        // dd($pengajuanLelang->bank_id);
        if ($emailBank) {

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
            $details = [
                'title' => '',
                'kd_lelang' => $pengajuanLelang->kd_lelang,
                'kd_property' => $pengajuanLelang->kd_property,
                'nama' => $pengajuanLelang->kpr_name,
                'email' => $pengajuanLelang->kpr_email,
                'agent' => $pengajuanLelang->namaAgen,
                'emailAgent' => $pengajuanLelang->emailAgent,
            ];

            // Path to the image file
            $filePath = storage_path(str_replace('/storage', 'app/public', $pengajuanLelang->image_ktp));


            Mail::to($emailBank->email)->send(new \App\Mail\BankEmailLelang($details, $filePath));
            return back()->with('success', 'Email berhasil terkirim ke bank');
        }
        return back()->with('error', 'Email bank  tidak di temukan');

    }

  

public function forgetPassword(Request $request)
{
    $contact = $request->contact;
    $email = $request->email;
    $method = $request->method;

    if ($method == 'email') {
        $user = User::where('email', $contact)->first();
        if ($user) {

            $data = new PasswordChanges();
            $data->user_id = $user->id;
            $data->email = $email;
            $data->uuid = Str::uuid();
            $data->expired = Carbon::now()->addHour();
            $data->noVerifikasi = PasswordChanges::generateUniqueVerificationCode();
            $data->save();

            $details = [
                'reset_link' => route('passwrod.change', $data->uuid),
            ];
            Mail::to($email)->send(new ForgetPassword($details));
        }
    } else {
        $user = User::where('wa_phone', $contact)->first();
        if ($user) {
            
            $data = new PasswordChanges();
            $data->user_id = $user->id;
            $data->email = $user->email;
            $data->uuid = Str::uuid();
            $data->expired = Carbon::now()->addHour();
            $data->noVerifikasi =  str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $data->save();
             

            $namaAplikasi = 'O-Rumah';
            $message = "Halo $user->name,\n\n" .
                "Kami menerima permintaan untuk mengubah kata sandi Anda di $namaAplikasi. Berikut adalah kode verifikasi Anda:\n\n" .
                "**{$data->noVerifikasi}**\n\n" .
                "Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.\n\n";
              

            $response = $this->whatsAppService->sendMessage($contact, $message);
        }
    }

    return response()->json(['status' => 'success', 'request' => $request->all()], 200);
}

}