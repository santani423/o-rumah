<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Job;
use App\Models\Kpr;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorKprController extends Controller
{
    function linkKprInfo($uuid='')
    {
        $kpr = Kpr::where('uuid',$uuid)->first();
        $ads = Ads::whereId($kpr->ads_id)->first();
        $agent = User::whereId($ads->user_id)->first();
        return view('/Pages/Frond/Pengajuan/Visitor/linkKprInfo',compact('kpr','agent','ads'));
    }
}
