<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\JenisJaminan;
use App\Models\JenisPinjaman;
use App\Models\Job;
use App\Models\Pengajuan;
use App\Models\TypePengajuan;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;

class PengajuanController extends Controller
{
    
    protected $whatsAppService;
    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }
    function index($slug) {
        $bank = Bank::get();
        $bankUmum = Bank::where('type', "umum")
            ->orderBy('province', 'asc')
            ->get();
             
        $bankBpr = Bank::where('type', "BPR")
            ->orderBy('province', 'asc')
            ->get();
            
        $job = Job::get();
        $typePengajuan = TypePengajuan::where('slug',$slug)->first();
        $jenisPinjaman = JenisPinjaman::orderBy('urutan', 'asc')->get();
        $jenisJaminan = JenisJaminan::orderBy('urutan', 'asc')->get();
        return view('Pages/Frond/Pengajuan/kpr', compact('bank',  'bankBpr', 'bankUmum','job','slug','typePengajuan','jenisPinjaman','jenisJaminan')); 
    }

    public function store(Request $request, $slug)
{
    // Validasi data
    // $validatedData = $request->validate([
    //     'bankUmum' => 'required',
    //     'bankBpr' => 'required',
    //     'pekerjaan' => 'required',
    //     'namaLengkap' => 'required|string|max:255',
    //     'email' => 'required|email',
    //     'noHp' => 'required|numeric',
    //     'agreement' => 'required|boolean',
    //     'imageSrc' => 'required|image',
    //     'imagekkSrc' => 'required|image',
    //     'fotoRekeningKoranSrc' => 'required|image',
    //     'fotoSlipGajiSrc' => 'required|image'
    // ], [
    //     'required' => ':attribute harus diisi.',
    //     'email' => ':attribute harus berupa email yang valid.',
    //     'numeric' => ':attribute harus berupa angka.',
    //     'image' => ':attribute harus berupa file gambar.',
    //     'boolean' => ':attribute harus berupa nilai benar atau salah.'
    // ]);

    // Ambil data TypePengajuan berdasarkan slug
    $typePengajuan = TypePengajuan::where('slug', $slug)->first();

    // Buat objek Pengajuan baru
    $pengajuan = new Pengajuan();
    $pengajuan->type_pengajuan_id = $typePengajuan->id;
    $pengajuan->code_pengajuan = $slug . date('Ymd') . str_pad(Pengajuan::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
    $pengajuan->nomor_pengajuan = $slug . date('Ymd') . str_pad(Pengajuan::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
    $pengajuan->jenis_pinjaman = $request->input('jenisPinjaman');
    $pengajuan->bank_umum_id = $request->input('bankUmum');
    $pengajuan->bank_bpr_id = $request->input('bankBpr');
    $pengajuan->status_pernikahan = $request->input('statusPernikahan');
    $pengajuan->nama_lengkap = $request->input('namaLengkap');
    $pengajuan->email = $request->input('email');
    $pengajuan->no_tlp = $request->input('noHp');
    $pengajuan->tanggal_pengajuan = date('y-m-d');

    // Simpan file jika ada
    // if ($request->hasFile('imageSrc')) {
    //     $file = $request->file('imageSrc');
    //     $filePath = $file->store('public/pengajuan');
    //     $pengajuan->kartu_keluarga = $filePath;
    // }

    // if ($request->hasFile('imagekkSrc')) {
    //     $file = $request->file('imagekkSrc');
    //     $filePath = $file->store('public/pengajuan');
    //     $pengajuan->kartu_keluarga = $filePath;
    // }

    // if ($request->hasFile('fotoRekeningKoranSrc')) {
    //     $file = $request->file('fotoRekeningKoranSrc');
    //     $filePath = $file->store('public/pengajuan');
    //     $pengajuan->rekening_koran = $filePath;
    // }

    // if ($request->hasFile('fotoSlipGajiSrc')) {
    //     $file = $request->file('fotoSlipGajiSrc');
    //     $filePath = $file->store('public/pengajuan');
    //     $pengajuan->slip_gaji = $filePath;
    // }

    // if ($request->hasFile('file_jaminan')) {
    //     $file = $request->file('file_jaminan');
    //     $filePath = $file->store('public/pengajuan');
    //     $pengajuan->file_jaminan = $filePath;
    // }

    // Simpan pengajuan ke database
    $pengajuan->save();

    // Kirim pesan WhatsApp
    // $message = "Halo {$pengajuan->nama_lengkap},\n\n"
    //     . "Terima kasih telah mengajukan {$typePengajuan->name} di O Rumah. Pengajuan Anda telah berhasil kami terima dan akan segera diproses. Berikut adalah detail pengajuan Anda:\n\n"
    //     . "Kode Pengajuan Pengajuan: {$pengajuan->uuid}\n"
    //     . "Kode Properti: {$pengajuan->code_pengajuan}\n"
    //     . "Nama: {$pengajuan->nama_lengkap}\n"
    //     . "Email: {$pengajuan->email}\n\n"
    //     . "No HP Agen: {$pengajuan->no_tlp}\n\n"
    //     . "Terima kasih telah memilih O Rumah.\n\n"
    //     . "Hormat kami,\n"
    //     . "Tim O Rumah";
    // $response = $this->whatsAppService->sendMessage($request->noHp, $message);

    // Mengembalikan respons JSON dengan ID pengajuan yang baru dibuat
    
    
    return response()->json([
        'success' => true,
        'message' => 'Pengajuan berhasil disimpan.',
        'pengajuan_id' => $pengajuan->id,
        'slug' => $slug,
    ]);


   
}
function show($id,$slug) {
    $typePengajuan = TypePengajuan::where('slug', $slug)->first();
    $pengajuan = Pengajuan::whereId($id)->first();
    return view('/Pages/Frond/Pengajuan/appterPengajuan',compact('pengajuan','typePengajuan'));
}

}
