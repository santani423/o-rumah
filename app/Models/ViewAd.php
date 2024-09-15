<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewAd extends Model
{
    use HasFactory;
    protected $fillable = ['ip_address', 'browser', 'device', 'visited_at', 'page_visited','advertising_points_id'];
}
