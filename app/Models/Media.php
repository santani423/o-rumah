<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ads()
    {
        return $this->belongsTo(Ads::class, 'ads_id', 'id');
    }
}
