<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitipAds extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_owner_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_receiver_id');
    }

    public function ads()
    {
        return $this->belongsTo(Ads::class, 'ads_id');
    }
}
