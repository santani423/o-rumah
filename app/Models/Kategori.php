<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    public function supKategoris()
    {
        return $this->hasMany(SupKategori::class, 'kategori_id');
    }
}
