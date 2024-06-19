<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kpr()
    {
        return $this->hasMany(Kpr::class, 'bank_id', 'id');
    }

    public function kprBpr()
    {
        return $this->hasMany(Kpr::class, 'bank_bpr_id', 'id');
    }
}
