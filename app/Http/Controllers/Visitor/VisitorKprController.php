<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Kpr;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorKprController extends Controller
{
    function linkKprStore(Request $request)
    {
        // dd($request);
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
}
