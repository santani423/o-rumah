<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteAdsSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function content()
    {
        return $this->hasMany(WebsiteAdsContent::class, 'website_ads_section_id', 'id');
    }
}
