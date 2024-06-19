<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WebsiteAdsContent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    public function section()
    {
        return $this->belongsTo(WebsiteAdsSection::class, 'website_ads_section_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image != '-' ? Storage::disk('public')->url($this->image) : asset('assets/orumah-placeholder.jpg');
    }
}
