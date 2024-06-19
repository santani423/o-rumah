<?php

namespace App\Http\Controllers;

use App\Models\AdBalance;
use Illuminate\Http\Request;

class AdBalanceController extends Controller
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
    public function show(AdBalance $adBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdBalance $adBalance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdBalance $adBalance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdBalance $adBalance)
    {
        //
    }

    function poin(Request $request)
    {
        $dataBalace = AdBalance::where("user_id", $request->id_user)->first();
        if (!$dataBalace) {
            $dataBalace = new AdBalance();
            $dataBalace->user_id = $request->id_user;
            $dataBalace->balance = 20;
            $dataBalace->save();
        }

        return response()->json([
            'message' => 'Respon berhasil',
            'data' => $request->all(),
            'balace' => floor($dataBalace->balance)
        ]);
    }
}
