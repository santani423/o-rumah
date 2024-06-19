<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)->orderBy('order', 'asc');
    }

    public function getImageUrlAttribute()
    {
        return $this->image != '-' ? Storage::disk('public')->url($this->image) : asset('assets/orumah-placeholder.jpg');
    }
}
