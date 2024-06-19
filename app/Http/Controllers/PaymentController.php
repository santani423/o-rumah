<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\InvoiceCallback;
use Illuminate\Support\Str;
use App\Models\Transaksi;
use App\Models\PlansTransaksi;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalance;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;// Add the missing 'use' statement for the Auth facade at the top of the file
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;// Import the Payment model

class PaymentController extends Controller
{
    var $apiInstance = null;
    public function __construct()
    {
        Configuration::setXenditKey("xnd_development_V7NXvdfuefjPS3BYq3WyquzbQd4ZIo5NF3qXAT2QpncWTKYUNPx80Mm1e2QgbKEe");
        $this->apiInstance = new InvoiceApi();
    }
    function create(Request $request)
    {

        // $request->description = 'Langganan bulanan';
        $request->amount = 500000; // Rp 500.000
        // $request->payer_email = 'pelanggan@example.com';
        // $request->slug = 'gold';

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => (string) Str::uuid(),
            'description' => $request->description,
            'amount' => $request->amount,
            'payer_email' => $request->payer_email,
        ]);
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => (string) Str::uuid(),
            'description' => $request->description,
            'amount' => $request->amount,
            'payer_email' => $request->payer_email,
        ]);

        $plan = DB::table('plans')->where('slug', $request->slug)->first();
        $user = Auth::user();
        // return response()->json(['message' => 'Payment created successfully', $request->all()]);
        $response = $this->apiInstance->createInvoice($create_invoice_request);

        $payment = new Payment();
        $payment->checkout_link = $response['invoice_url'];
        $payment->external_id = $create_invoice_request['external_id'];
        $payment->status = 'pending';
        $payment->save();

        $transaction = new Transaksi();
        $transaction->user_id = $user->id;
        $transaction->payment_id = $payment->id;
        $transaction->payment_method = 'Credit Card';
        $transaction->amount = $request->amount;
        $transaction->description = "Pembayaran untuk layanan  $plan->name";
        $transaction->additional_info = 'Informasi tambahan';
        $transaction->transaction_time = Carbon::now(); // Waktu transaksi saat ini
        $transaction->save();
        // Simpan data ke tabel plans_transaksis
        $plansTransaksi = new PlansTransaksi();
        $plansTransaksi->transaksis_id = $transaction->id;
        $plansTransaksi->plans_id = $plan->id;
        $plansTransaksi->price = $request->amount;
        $plansTransaksi->description = "Pembayaran untuk layanan $plan->name";
        $plansTransaksi->save();

        return response()->json(['message' => 'Payment created successfully', 'payment' => $payment]);
    }
    function sdf(Request $request)
    {
        // return response()->json(['message' => 'Payment created successfully']);
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => (string) Str::uuid(),
            'description' => $request->description,
            'amount' => $request->amount,
            'payer_email' => $request->payer_email,
        ]);
        $plan = DB::table('plans')->where('slug', $request->slug)->first();
        $user = Auth::user();
        $response = $this->apiInstance->createInvoice($create_invoice_request);
        return response()->json(['message' => 'Payment created successfully', 'payment' => $user]);
        $payment = new Payment();
        $payment->checkout_link = $response['invoice_url'];
        $payment->external_id = $create_invoice_request['external_id'];
        $payment->status = 'pending';
        $payment->save();

        $transaction = new Transaksi();
        $transaction->user_id = $user->id;
        $transaction->payment_method = 'Credit Card';
        $transaction->amount = $request->amount;
        $transaction->description = "Pembayaran untuk layanan  $plan->name";
        $transaction->additional_info = 'Informasi tambahan';
        $transaction->transaction_time = Carbon::now(); // Waktu transaksi saat ini

        $transaction->save();

        // Simpan data ke tabel plans_transaksis
        $plansTransaksi = new PlansTransaksi();
        $plansTransaksi->transaksis_id = $transaction->id;
        $plansTransaksi->plans_id = $plan->id;
        $plansTransaksi->price = $request->amount;
        $plansTransaksi->description = "Pembayaran untuk layanan $plan->name";
        $plansTransaksi->save();

        return response()->json(['message' => 'Payment created successfully', 'payment' => $payment]);
    }

    public function webhook(Request $request)
    {
        $getInvoice = new InvoiceCallback($request->all());
        // Get data
        $payment = Payment::where('external_id', $request->external_id)->firstOrFail();

        if ($payment->status == 'settled') {
            return response()->json(['data' => 'Payment has been already processed']);
        }

        // Update status payment
        $payment->status = strtolower($getInvoice['status']);
        $payment->save();

        $transaksi = Transaksi::where('payment_id', $payment->id)->first();

        $transaksi->payment_status = 'success';
        $transaksi->transaction_status = 'delivered';
        // Simpan perubahan ke database
        $transaksi->save();

        // Temukan detail rencana transaksi
        $plansTransaksi = PlansTransaksi::where('transaksis_id', $transaksi->id)
            ->join('plans', 'plans.id', '=', 'plans_transaksis.plans_id')
            ->first();
        // Temukan saldo

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
        return response()->json(['data' => 'Success']);
    }
}