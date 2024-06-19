<?php

namespace App\Http\Controllers;

use App\Models\LinkeAds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkeAdsController extends Controller
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
    public function show(LinkeAds $linkeAds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LinkeAds $linkeAds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LinkeAds $linkeAds)
    {
        //
    }

    //
    public function like(Request $request)
    {
        $auth = Auth::user();
        $like = LinkeAds::where('user_id', $auth->id)
            ->where('ads_id', $request->addId)
            ->where('type', $request->type)
            ->first();


        // Jika data sudah ada, hapus
        if ($like) {
            $like->delete();

            $lk = false;
        } else {
            // Jika data belum ada, tambahkan
            $like = new LinkeAds();
            $like->user_id = $auth->id;
            $like->user_agen_id = $request->agentId;
            $like->ads_id = $request->addId;
            $like->type = $request->type;
            $like->save();
            $lk = true;
        }



        $user = Auth::user();
        $countLike = LinkeAds::where('user_id', $user->id)->count();

        return response()->json([
            'message' => 'Like ditambahkan',
            'request' => $request->all(),
            'like' => $lk,
            'countLike' => $countLike,
        ]);
    }

}
