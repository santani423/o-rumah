<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisJaminan extends Model
{
    use HasFactory;
    protected $table = 'jenis_jaminans';
    protected $guarded = [];
}
