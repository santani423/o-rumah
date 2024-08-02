<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPropertyStatistics extends Model
{
    use HasFactory;
    protected $table = 'user_property_statistics';
    protected $guarded = [];
}
