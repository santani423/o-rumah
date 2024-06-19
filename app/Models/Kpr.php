<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpr extends Model
{
    use HasFactory;

    protected $table = 'kpr';

    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function bankBpr()
    {
        return $this->belongsTo(Bank::class, 'bank_bpr_id', 'id');
    }

    public function ads()
    {
        return $this->belongsTo(Ads::class, 'ads_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
