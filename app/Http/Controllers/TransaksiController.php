<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\PlansTransaksi;
use App\Models\AdBalance;
use App\Models\AdvertisingalanceHistories;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }


    function uploadBuktiBayar(Request $request)
    {

        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::find($request->transaction_id);
        $plansTransaksi = PlansTransaksi::where('transaksis_id', $request->transaction_id)
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')

            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found.',
            ], 404);
        }


        $transaksi->transaction_status = 'processing';
        $transaksi->proof_of_transaction = $request->payment_image;


        $transaksi->save();

        return response()->json([
            'success' => true,
            'transaction' => $transaksi,
            'plansTransaksi' => $plansTransaksi,
            'message' => 'Proof of payment successfully uploaded.',
        ], 200);
    }



    // admin

    public function approvalBuktiBayar(Request $request)
    {
        try {
            // Ambil ID transaksi dari permintaan POST
            $idTransaksi = $request->input('transaction_id');

            // Temukan transaksi berdasarkan ID
            $transaksi = Transaksi::find($idTransaksi);

            // Periksa apakah transaksi ditemukan
            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found.',
                ], 404);
            }

            // Ubah status pembayaran dan status transaksi menjadi canceled
            $transaksi->payment_status = 'success';
            $transaksi->transaction_status = 'delivered';

            // Simpan perubahan ke database
            $transaksi->save();

            // Temukan detail rencana transaksi
            $plansTransaksi = PlansTransaksi::where('transaksis_id', $idTransaksi)
                ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
                ->first();
            // Temukan saldo iklan pengguna (AdBalance)



            // Cari atau buat AdBalance berdasarkan user_id dari transaksi
            $adBalance = AdBalance::where(['user_id' => $transaksi->user_id])->first();

            if (!$adBalance) {
                $adBalance = new AdBalance();

                // Setel balance AdBalance dengan nilai max_ads_posted
                $adBalance->balance = $plansTransaksi->max_ads_posted;
                $adBalance->user_id = $transaksi->user_id;

                // Simpan perubahan pada AdBalance
                $adBalance->save();
                $previousBalance = $plansTransaksi->max_ads_posted;
                $currentBalance = $plansTransaksi->max_ads_posted;
            } else {
                // Hitung saldo sebelumnya dan saldo sekarang
                // return response()->json([
                //     'success' => true,
                //     'message' => 'Transaction approved successfully.',
                //     'transaksi' => $transaksi, // Jika perlu, kirim data transaksi yang telah diubah
                // ]);
                $previousBalance = $adBalance->balance;
                $currentBalance = $previousBalance + $plansTransaksi->max_ads_posted;
                $adBalance->balance = $currentBalance;
                $adBalance->save();

            }








            // Buat riwayat perubahan saldo (Advertising Balance History)
            AdvertisingalanceHistories::create([
                'user_id' => $transaksi->user_id,
                'transaction_type' => 'Top-up',
                'amount_change' => $plansTransaksi->max_ads_posted,
                'previous_balance' => $previousBalance,
                'current_balance' => $currentBalance,
                'description' => 'Top-up balance for advertising campaign.',
            ]);

            // Kirim respons JSON sukses
            return response()->json([
                'success' => true,
                'message' => 'Transaction approved successfully.',
                'transaksi' => $transaksi, // Jika perlu, kirim data transaksi yang telah diubah
            ]);
        } catch (\Exception $e) {
            // Tangani pengecualian jika terjadi kesalahan
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function successbuktiBayar(Request $request)
    {
        try {
            // Ambil ID transaksi dari permintaan POST
            $idTransaksi = $request->input('transaction_id');

            // Temukan transaksi berdasarkan ID
            $transaksi = Transaksi::find($idTransaksi);

            // Periksa apakah transaksi ditemukan
            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found.',
                ], 404);
            }

            // Ubah status pembayaran dan status transaksi menjadi canceled
            $transaksi->payment_status = 'success';
            $transaksi->transaction_status = 'delivered';

            // Simpan perubahan ke database
            $transaksi->save();



            // Kirim respons JSON sukses
            return response()->json([
                'success' => true,
                'message' => 'Transaction approved successfully.',
                'transaksi' => $transaksi, // Jika perlu, kirim data transaksi yang telah diubah
            ]);
        } catch (\Exception $e) {
            // Tangani pengecualian jika terjadi kesalahan
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function canceledbuktiBayar(Request $request)
    {
        try {
            // Ambil ID transaksi dari permintaan POST
            $idTransaksi = $request->input('transaction_id');

            // Temukan transaksi berdasarkan ID
            $transaksi = Transaksi::find($idTransaksi);

            // Periksa apakah transaksi ditemukan
            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found.',
                ], 404);
            }

            // Ubah status pembayaran dan status transaksi menjadi canceled
            $transaksi->payment_status = 'canceled';
            $transaksi->transaction_status = 'canceled';

            // Simpan perubahan ke database
            $transaksi->save();



            // Kirim respons JSON sukses
            return response()->json([
                'success' => true,
                'message' => 'Transaction approved successfully.',
                'transaksi' => $transaksi, // Jika perlu, kirim data transaksi yang telah diubah
            ]);
        } catch (\Exception $e) {
            // Tangani pengecualian jika terjadi kesalahan
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
